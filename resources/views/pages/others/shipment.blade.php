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
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card border-0 rounded-3 mb-4" style="background: linear-gradient(108deg, #3A4252 0%, #23272E 100%);">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="d-inline-block px-3 bg-success bg-opacity-25 text-success border border-success rounded-pill fs-12 fw-medium">+35.5%</span>
                                                <div class="text-end">
                                                    <span class="ms-2 fs-12" style="color: #B1BBC8;">Last 30 days</span>
                                                    <span class="fs-12 fw-bold text-success d-block">$13,250</span>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex align-items-end">
                                                <div class="flex-grow-1">
                                                    <span class="d-block mb-1" style="color: #B1BBC8;">Total Income</span>
                                                    <h4 class="fs-20 mb-0 text-white">$531,200</h4>
                                                </div>
                                                <div class="flex-shrink-0 me-3 me-auto">
                                                    <i class="ri-money-dollar-circle-line fs-24 text-success bg-success d-inline-block text-center rounded-circle text-white" style="width: 60px; height: 60px; line-height: 60px;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card border-0 rounded-3 bg-white mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="d-inline-block px-3 bg-success bg-opacity-10 text-success border border-success rounded-pill fs-12 fw-medium">+45%</span>
                                                <div class="text-end">
                                                    <span class="ms-2 fs-12">Last 30 days</span>
                                                    <span class="fs-12 fw-bold text-primary-div d-block">+20,300</span>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex align-items-end">
                                                <div class="flex-grow-1">
                                                    <span class="d-block mb-1">Total Shipment</span>
                                                    <h4 class="fs-20 mb-0">175,950</h4>
                                                </div>
                                                <div class="flex-shrink-0 me-3 me-auto">
                                                    <i class="ri-truck-line fs-24 text-white bg-primary-div d-inline-block text-center rounded-circle text-white" style="width: 60px; height: 60px; line-height: 60px;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card border-0 rounded-3 bg-white mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="d-inline-block px-3 bg-success bg-opacity-10 text-success border border-success rounded-pill fs-12 fw-medium">+15%</span>
                                                <div class="text-end">
                                                    <span class="ms-2 fs-12">Last 30 days</span>
                                                    <span class="fs-12 fw-bold text-primary d-block">+3k</span>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex align-items-end">
                                                <div class="flex-grow-1">
                                                    <span class="d-block mb-1">Total Customer</span>
                                                    <h4 class="fs-20 mb-0">29,554</h4>
                                                </div>
                                                <div class="flex-shrink-0 me-3 me-auto">
                                                    <i class="ri-group-line fs-24 text-white bg-primary d-inline-block text-center rounded-circle text-white" style="width: 60px; height: 60px; line-height: 60px;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card border-0 rounded-3 bg-white mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="d-inline-block px-3 bg-danger bg-opacity-10 text-danger border border-danger rounded-pill fs-12 fw-medium">-2.5%</span>
                                                <div class="text-end">
                                                    <span class="ms-2 fs-12">Last 30 days</span>
                                                    <span class="fs-12 fw-bold text-danger d-block">-140</span>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex align-items-end">
                                                <div class="flex-grow-1">
                                                    <span class="d-block mb-1">Total Order</span>
                                                    <h4 class="fs-20 mb-0">49,120</h4>
                                                </div>
                                                <div class="flex-shrink-0 me-3 me-auto">
                                                    <i class="ri-box-3-line fs-24 text-white bg-danger d-inline-block text-center rounded-circle text-white" style="width: 60px; height: 60px; line-height: 60px;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
                                        <h3 class="mb-0">Shipment Delivered</h3>
                                        <span class="fs-12">Last 30 days</span>
                                    </div>

                                    <div style="margin: -24px -40px -19px -17px;">
                                        <div id="shipment_delivered"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card border-0 rounded-3 bg-white mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
                                                <span>Average Delivery Time</span>
                                                <span class="fs-12">Per Month</span>
                                            </div>  
                                            <div style="margin: -24px -22px -26px -18px;">
                                                <div id="average_delivery_time"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 rounded-3 bg-white mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
                                                <span>Live Shipment Status</span>
                                                <span class="fs-12">Last 7 days</span>
                                            </div>  
                                            <div style="margin: -24px -6px -25px -17px;">
                                                <div id="live_shipment_status"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-4">
                                        <h3 class="mb-0">Tracking Order</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color bg-transparent" aria-label="Default select example">
                                            <option selected="">Last 30 days</option>
                                            <option value="1">Last 90 days</option>
                                            <option value="1">Last 1 year</option>
                                        </select>
                                    </div>
        
                                    <div class="default-table-area style-two transaction-history tracking-order">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                </div>
                                                                <span class="ms-1">Order ID</span>
                                                            </div>
                                                        </th>
                                                        <th scope="col">Customer Name</th>
                                                        <th scope="col">Order Date</th>
                                                        <th scope="col">Current Location</th>
                                                        <th scope="col">Tracking Number</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                                </div>
                                                                <span class="ms-1 text-secondary">#OR045</span>
                                                            </div>
                                                        </td>
                                                        <td>Mark Blake</td> 
                                                        <td>2024-09-05</td> 
                                                        <td>Chicago, IL</td> 
                                                        <td>TRK001</td> 
                                                        <td>
                                                            <span class="d-inline-block fs-12 bg-success bg-opacity-10 text-success px-2 py-1 rounded-1">Delivered</span>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                                </div>
                                                                <span class="ms-1 text-secondary">#OR085</span>
                                                            </div>
                                                        </td>
                                                        <td>Cheryl Myers</td> 
                                                        <td>2024-09-06</td> 
                                                        <td>London, UK</td> 
                                                        <td>TRK002</td> 
                                                        <td>
                                                            <span class="d-inline-block fs-12 bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-1">In Transit</span>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                                </div>
                                                                <span class="ms-1 text-secondary">#OR099</span>
                                                            </div>
                                                        </td>
                                                        <td>Marc Bradley</td> 
                                                        <td>2024-09-10</td> 
                                                        <td>Paris, France</td> 
                                                        <td>TRK003</td> 
                                                        <td>
                                                            <span class="d-inline-block fs-12 bg-danger bg-opacity-10 text-danger px-2 py-1 rounded-1">On The Way</span>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                                </div>
                                                                <span class="ms-1 text-secondary">#OR125</span>
                                                            </div>
                                                        </td>
                                                        <td>Ryan Vasquez</td> 
                                                        <td>N/A</td> 
                                                        <td>N/A</td> 
                                                        <td>N/A</td> 
                                                        <td>
                                                            <span class="d-inline-block fs-12 bg-danger bg-opacity-25 text-danger px-2 py-1 rounded-1">Canceled</span>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                                </div>
                                                                <span class="ms-1 text-secondary">#OR245</span>
                                                            </div>
                                                        </td>
                                                        <td>Donald Ness</td> 
                                                        <td>2024-09-12</td> 
                                                        <td>Tokyo, Japan</td> 
                                                        <td>TRK004</td> 
                                                        <td>
                                                            <span class="d-inline-block fs-12 bg-warning bg-opacity-10 text-warning px-2 py-1 rounded-1">Pending</span>
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
                                                        <a class="page-link icon" href="/shipment" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/shipment">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/shipment">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/shipment">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/shipment">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/shipment" aria-label="Next">
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
                        <div class="col-xxl-4">
                            <div class="row">
                                <div class="col-md-6 col-xxl-12">
                                    <div class="card border-0 rounded-3 bg-primary mb-4">
                                        <div class="card-body p-4">
                                            <h3 class="text-white mx-auto mb-4 text-center" style="max-width: 230px; line-height: 1.5;">Shipment to top countries around the world</h3>
        
                                            <div class="text-center" style="margin: 30px 0;">
                                                <div id="shipment_to_top"></div>
                                            </div>
        
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center mt-3">
                                                        <img src="/assets/images/united-states-2.png" class="rounded-circle" style="width: 16px;" alt="united-states">
                                                        <span class="text-white ms-2">United States 85%</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center mt-3">
                                                        <img src="/assets/images/germany-2.png" class="rounded-circle" style="width: 16px;" alt="germany">
                                                        <span class="text-white ms-2">Germany 75%</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center mt-3">
                                                        <img src="/assets/images/united-kingdom-2.png" class="rounded-circle" style="width: 16px;" alt="united-kingdom">
                                                        <span class="text-white ms-2">United Kingdom 40%</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center mt-3">
                                                        <img src="/assets/images/canada-2.png" class="rounded-circle" style="width: 16px;" alt="canada">
                                                        <span class="text-white ms-2">Canada 10%</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center mt-3">
                                                        <img src="/assets/images/portugal.svg" class="rounded-circle" style="width: 16px;" alt="portugal">
                                                        <span class="text-white ms-2">Portugal 05%</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center mt-3">
                                                        <img src="/assets/images/spain.svg" class="rounded-circle" style="width: 16px;" alt="spain">
                                                        <span class="text-white ms-2">Spain 15%</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center mt-3">
                                                        <img src="/assets/images/france.svg" class="rounded-circle" style="width: 16px;" alt="france">
                                                        <span class="text-white ms-2">France 25%</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center mt-3">
                                                        <img src="/assets/images/australia.png" class="rounded-circle" style="width: 16px;" alt="australia">
                                                        <span class="text-white ms-2">Australia 55%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xxl-12">
                                    <div class="card border-0 rounded-3 bg-white mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                                <h3 class="mb-0">Chat</h3>                           
        
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
        
                                            <ul class="ps-0 mb-0 list-unstyled" style="height: 240px;" data-simplebar>
                                                <li class="mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-62.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fw-medium fs-16 mb-0">Irene George</h4>
                                                            <span class="fs-12">05:30PM</span>
                                                        </div>
                                                    </div>
                                                    <p style="max-width: 310px;">Hey, have you finished the report for the project yet?</p>
                                                </li>
                                                <li class="text-end">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="flex-grow-1 me-2">
                                                            <h4 class="fw-medium fs-16 mb-0">Virgil Martin</h4>
                                                            <span class="fs-12">05:30PM</span>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-63.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="user">
                                                        </div>
                                                    </div>
                                                    <p class="bg-danger bg-opacity-10 p-2 rounded-2 ms-auto" style="max-width: 310px;">Almost! I just need to double-check some data. I’ll send it over in about an hour.</p>
                                                </li>
                                                <li class="mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-64.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fw-medium fs-16 mb-0">Alex Dew</h4>
                                                            <span class="fs-12">05:30PM</span>
                                                        </div>
                                                    </div>
                                                    <p style="max-width: 310px;">Hey, have you finished the report for the project yet?</p>
                                                </li>
                                                <li class="text-end">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="flex-grow-1 me-2">
                                                            <h4 class="fw-medium fs-16 mb-0">Heriy Smith</h4>
                                                            <span class="fs-12">05:30PM</span>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-65.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="user">
                                                        </div>
                                                    </div>
                                                    <p class="bg-danger bg-opacity-10 p-2 rounded-2 ms-auto" style="max-width: 310px;">Almost! I just need to double-check some data. I’ll send it over in about an hour.</p>
                                                </li>
                                            </ul>
        
                                            <form class="position-relative mt-3">
                                                <input type="text" class="form-control bg-body-bg border-0" style="height: 35px; padding-left: 40px;" placeholder="Write your message...">
                                                <div class="d-flex gap-2 align-items-center position-absolute top-50 end-0 translate-middle-y pe-3 bg-body-bg">
                                                    <button class="border-0 p-0 bg-transparent">
                                                        <i class="ri-emotion-happy-line fs-16 text-body"></i>
                                                    </button>
                                                    <button type="submit" class="border-0 p-0 bg-transparent">
                                                        <i class="ri-send-plane-2-line fs-16 text-body"></i>
                                                    </button>
                                                </div>
                                                <i class="ri-attachment-2 fs-16 position-absolute top-50 start-0 translate-middle-y ps-3"></i>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-xxl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <span class="fs-14 d-block mb-4">Top Shipping Methods</span>
                                    <div style="margin: -7px 0 -13px 0;">
                                        <div id="top_shipping_methods"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xxl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-start mb-4">
                                        <div class="">
                                            <span class="fs-14 d-block mb-1">Todays Shipments</span>
                                            <h3 class="fs-18 mb-0">9,120 Ton</h3>
                                        </div>
                                        <span class="fs-12 fw-medium text-success bg-success bg-opacity-10 border border-success d-inline-block px-2 rounded-pill">+5%</span>
                                    </div>
                                    <div style="margin: -24px -10px -26px -18px;">
                                        <div id="todays_shipments"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xxl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <span class="fs-14 d-block mb-4">On-Time Delivery</span>
                                    <div style="margin: -7px 0 -13px 0;">
                                        <div id="on_time_delivery"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-4">
                                <h3 class="mb-0">Shipment List</h3>
                                <div class="d-flex flex-wrap gap-2 gap-sm-3 align-items-center">
                                    <form class="position-relative table-src-form me-0">
                                        <input type="text" class="form-control" placeholder="Search here">
                                        <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                    </form>
                                    <select class="form-select month-select form-control w-135 bg-border-color border-color bg-transparent" aria-label="Default select example">
                                        <option selected="">Last 30 days</option>
                                        <option value="1">Last 90 days</option>
                                        <option value="1">Last 1 year</option>
                                    </select>
                                </div>
                            </div>

                            <div class="default-table-area style-two shipment-list">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        </div>
                                                        <span class="ms-1">Shipment ID</span>
                                                    </div>
                                                </th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Products</th>
                                                <th scope="col">Cost</th>
                                                <th scope="col">Ship Date</th>
                                                <th scope="col">Origin</th>
                                                <th scope="col">Shipment Method</th>
                                                <th scope="col">Status</th>
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
                                                        <span class="ms-1 text-secondary">#0015</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="/my-profile" class="d-flex align-items-center">
                                                        <img src="/assets/images/user-1.jpg" class="wh-30 rounded-circle" alt="user">
                                                        <div class="ms-2">
                                                            <h6 class="fw-medium fs-14">David Farrior</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>Toys</td>
                                                <td class="text-danger">$50,000</td> 
                                                <td>2024-10-01</td> 
                                                <td>New York, USA</td> 
                                                <td>Air</td> 
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Delivered</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown action-opt">
                                                        <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i data-feather="more-horizontal"></i>
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
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                        </div>
                                                        <span class="ms-1 text-secondary">#0099</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="/my-profile" class="d-flex align-items-center">
                                                        <img src="/assets/images/user-2.jpg" class="wh-30 rounded-circle" alt="user">
                                                        <div class="ms-2">
                                                            <h6 class="fw-medium fs-14">Leslie Yawn</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>Sports</td>
                                                <td class="text-danger">$1,20,000</td> 
                                                <td>2024-09-28</td> 
                                                <td>Shanghai, China</td> 
                                                <td>Sea</td> 
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">In Transit</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown action-opt">
                                                        <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i data-feather="more-horizontal"></i>
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
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                        </div>
                                                        <span class="ms-1 text-secondary">#0145</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="/my-profile" class="d-flex align-items-center">
                                                        <img src="/assets/images/user-3.jpg" class="wh-30 rounded-circle" alt="user">
                                                        <div class="ms-2">
                                                            <h6 class="fw-medium fs-14">Willie Wood</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>Fashion</td>
                                                <td class="text-danger">$50,000</td> 
                                                <td>2024-09-25</td> 
                                                <td>Berlin, Germany</td> 
                                                <td>Road</td> 
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">On The Way</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown action-opt">
                                                        <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i data-feather="more-horizontal"></i>
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
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                        </div>
                                                        <span class="ms-1 text-secondary">#0247</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="/my-profile" class="d-flex align-items-center">
                                                        <img src="/assets/images/user-4.jpg" class="wh-30 rounded-circle" alt="user">
                                                        <div class="ms-2">
                                                            <h6 class="fw-medium fs-14">Jill Caldera</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>Food</td>
                                                <td class="text-danger">$80,000</td> 
                                                <td>2024-09-22</td> 
                                                <td>Tokyo, Japan</td> 
                                                <td>Air</td> 
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Delivered</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown action-opt">
                                                        <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i data-feather="more-horizontal"></i>
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
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                        </div>
                                                        <span class="ms-1 text-secondary">#0299</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="/my-profile" class="d-flex align-items-center">
                                                        <img src="/assets/images/user-5.jpg" class="wh-30 rounded-circle" alt="user">
                                                        <div class="ms-2">
                                                            <h6 class="fw-medium fs-14">Bill Mitchell</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>Electronics</td>
                                                <td class="text-danger">$1,50,000</td> 
                                                <td>2024-09-20</td> 
                                                <td>Madrid, Spain</td> 
                                                <td>Sea</td> 
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown action-opt">
                                                        <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i data-feather="more-horizontal"></i>
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
    
                                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap p-4">
                                    <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
    
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination mb-0 justify-content-center">
                                            <li class="page-item">
                                                <a class="page-link icon" href="/shipment" aria-label="Previous">
                                                    <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link active" href="/shipment">1</a></li>
                                            <li class="page-item"><a class="page-link" href="/shipment">2</a></li>
                                            <li class="page-item"><a class="page-link" href="/shipment">3</a></li>
                                            <li class="page-item"><a class="page-link" href="/shipment">4</a></li>
                                            <li class="page-item">
                                                <a class="page-link icon" href="/shipment" aria-label="Next">
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