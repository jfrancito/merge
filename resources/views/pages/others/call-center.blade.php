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
                        <div class="col-xxl-8">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="custom-padding-30">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-4">
                                        <h3 class="mb-0 fw-semibold">Overview</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color bg-transparent" aria-label="Default select example">
                                            <option selected="">This Year</option>
                                            <option value="1">Last Year</option>
                                            <option value="1">Last 2 year</option>
                                        </select>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card bg-primary border-0 rounded-3 p-4 mb-4">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="flex-grow-1 me-3">
                                                        <span class="text-border-color d-block mb-1">Total Calls</span>
                                                        <h3 class="fs-24 fw-medium text-white">26,435</h3>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/total-calls.svg" alt="total-calls">
                                                    </div>
                                                </div>
                                                <span class="d-flex align-items-center align-items-center text-white"> 
                                                    <i class="material-symbols-outlined fs-18 pe-2 position-relative top-1">trending_up</i> 
                                                    <span class="fw-medium me-1">+15%</span> last year
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card border-0 rounded-3 p-4 mb-4" style="background-color: #FAF5FF;">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="flex-grow-1 me-3">
                                                        <span class="text-body d-block mb-1">Answered Calls</span>
                                                        <h3 class="fs-24 fw-medium text-secondary">18,520</h3>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/answered-calls.svg" alt="answered-calls">
                                                    </div>
                                                </div>
                                                <span class="d-flex align-items-center align-items-center text-body"> 
                                                    <i class="material-symbols-outlined fs-18 pe-2 position-relative top-1 text-success">trending_up</i> 
                                                    <span class="fw-medium me-1 text-secondary">+15%</span> last year
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="card border-0 rounded-3 p-4 mb-4" style="background-color: #FFF5ED;">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="flex-grow-1 me-3">
                                                        <span class="text-body d-block mb-1">Missed Calls</span>
                                                        <h3 class="fs-24 fw-medium text-secondary">3,735</h3>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/missed-calls.svg" alt="missed-calls">
                                                    </div>
                                                </div>
                                                <span class="d-flex align-items-center align-items-center text-body"> 
                                                    <i class="material-symbols-outlined fs-18 pe-2 position-relative top-1 text-danger-50">trending_down</i> 
                                                    <span class="fw-medium me-1 text-secondary">-25%</span> last year
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div style="margin: -24px -10px -26px -18px;">
                                        <div id="call_overview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4">
                            <div class="row">
                                <div class="col-xxl-12 col-md-6">
                                    <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                        <div class="custom-padding-30">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-1 pb-4 position-relative z-1">
                                                <div>
                                                    <h3 class="mb-0 fw-semibold">Inbound Calls</h3>
                                                    <span class="fs-12">Overview of incoming call volume</span>
                                                </div>
                                                <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                                    <option selected="">Today</option>
                                                    <option value="1">Last Month</option>
                                                    <option value="2">Last Year</option>
                                                </select>
                                            </div>
        
                                            <div style="margin: -53px -9px -30px -11px;">
                                                <div id="inbound_calls"></div>
                                            </div>
        
                                            <div class="d-flex align-items-center position-relative z-1">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-body-bg border text-center rounded-2" style="width: 48px; height: 48px; line-height: 48px;">
                                                            <img src="/assets/images/inbound-calls.svg" alt="inbound-calls">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h3 class="fs-28 fw-medium text-secondary mb-0">1,235</h3>
                                                        <span class="text-body d-block">Past 24 hours</span>
                                                    </div>
                                                </div>
        
                                                <span class="d-flex align-items-center align-items-center text-body ms-5"> 
                                                    <i class="material-symbols-outlined fs-18 pe-2 text-success">trending_up</i> 
                                                    <span class="fw-medium me-1 text-secondary">+7.5%</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-6">
                                    <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                        <div class="custom-padding-30">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-1 pb-4 position-relative z-1">
                                                <div>
                                                    <h3 class="mb-0 fw-semibold">Outbound Calls</h3>
                                                    <span class="fs-12">Summary of outgoing call efforts</span>
                                                </div>
                                                <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                                    <option selected="">Last Month</option>
                                                    <option value="1">Last Year</option>
                                                </select>
                                            </div>
        
                                            <div style="margin: -53px -9px -30px -11px;">
                                                <div id="outbound_calls"></div>
                                            </div>
        
                                            <div class="d-flex align-items-center position-relative z-1">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-body-bg border text-center rounded-2" style="width: 48px; height: 48px; line-height: 48px;">
                                                            <img src="/assets/images/outbound-calls.svg" alt="outbound-calls">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h3 class="fs-28 fw-medium text-secondary mb-0">8,90</h3>
                                                        <span class="text-body d-block">Last month</span>
                                                    </div>
                                                </div>
        
                                                <span class="d-flex align-items-center align-items-center text-body ms-5"> 
                                                    <i class="material-symbols-outlined fs-18 pe-2 text-danger">trending_down</i> 
                                                    <span class="fw-medium me-1 text-secondary">-5.8%</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-xxl-6"> 
                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="custom-padding-30">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 gap-sm-3 pb-4 mb-2">
                                        <h3 class="mb-0">Agents Performance Overview</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected="">Today</option>
                                            <option value="1">Last Month</option>
                                            <option value="2">Last Year</option>
                                        </select>
                                    </div>

                                    <div class="row mb-4 pb-2">
                                        <div class="col-lg-12">
                                            <span class="d-block mb-3">Top Performing Agent</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 position-relative z-1">
                                                    <img src="/assets/images/user-1.jpg" class="rounded-2" alt="user">
                                                    <span class="bg-success rounded-circle d-inline-block position-absolute top-50 start-100 translate-middle" style="width: 8px; height: 8px;"></span>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-14 fw-medium mb-1">John Smith</h4>
                                                    <span class="text-body">380 Calls</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8 mt-2 mt-sm-0">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span>Customer Satisfaction (CSAT)</span>
                                                <span>92%</span>
                                            </div>
                                            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100" style="height: 6px;">
                                                <div class="progress-bar bg-success rounded-pill" style="width: 92%; height: 6px;"></div>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="default-table-area style-three agents-performance-overview">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 position-relative z-1">
                                                                    <img src="/assets/images/user-2.jpg" class="rounded-2" alt="user">
                                                                    <span class="bg-success rounded-circle d-inline-block position-absolute top-50 start-100 translate-middle" style="width: 8px; height: 8px;"></span>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h4 class="fs-14 fw-medium mb-1">Sarah Davis</h4>
                                                                    <span class="text-body">65 Calls</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-body">Avg. Call Duration</span>
                                                            <span class="fw-medium d-block">4 mins 10 secs</span>
                                                        </td> 
                                                        <td>
                                                            <span class="text-body">FCR</span>
                                                            <span class="fw-medium d-block">85%</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-body">CSAT</span>
                                                            <span class="fw-medium d-block">90%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-white" style="padding: 5px !important;"></td>
                                                        <td class="bg-white" style="padding: 5px !important;"></td>
                                                        <td class="bg-white" style="padding: 5px !important;"></td>
                                                        <td class="bg-white" style="padding: 5px !important;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 position-relative z-1">
                                                                    <img src="/assets/images/user-3.jpg" class="rounded-2" alt="user">
                                                                    <span class="bg-danger rounded-circle d-inline-block position-absolute top-50 start-100 translate-middle" style="width: 8px; height: 8px;"></span>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h4 class="fs-14 fw-medium mb-1">Sarah Davis</h4>
                                                                    <span class="text-body">65 Calls</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-body">Avg. Call Duration</span>
                                                            <span class="fw-medium d-block">4 mins 10 secs</span>
                                                        </td> 
                                                        <td>
                                                            <span class="text-body">FCR</span>
                                                            <span class="fw-medium d-block">85%</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-body">CSAT</span>
                                                            <span class="fw-medium d-block">90%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-white" style="padding: 5px !important;"></td>
                                                        <td class="bg-white" style="padding: 5px !important;"></td>
                                                        <td class="bg-white" style="padding: 5px !important;"></td>
                                                        <td class="bg-white" style="padding: 5px !important;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 position-relative z-1">
                                                                    <img src="/assets/images/user-4.jpg" class="rounded-2" alt="user">
                                                                    <span class="bg-success rounded-circle d-inline-block position-absolute top-50 start-100 translate-middle" style="width: 8px; height: 8px;"></span>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h4 class="fs-14 fw-medium mb-1">Sarah Davis</h4>
                                                                    <span class="text-body">65 Calls</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-body">Avg. Call Duration</span>
                                                            <span class="fw-medium d-block">4 mins 10 secs</span>
                                                        </td> 
                                                        <td>
                                                            <span class="text-body">FCR</span>
                                                            <span class="fw-medium d-block">85%</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-body">CSAT</span>
                                                            <span class="fw-medium d-block">90%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-white" style="padding: 5px !important;"></td>
                                                        <td class="bg-white" style="padding: 5px !important;"></td>
                                                        <td class="bg-white" style="padding: 5px !important;"></td>
                                                        <td class="bg-white" style="padding: 5px !important;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 position-relative z-1">
                                                                    <img src="/assets/images/user-5.jpg" class="rounded-2" alt="user">
                                                                    <span class="bg-danger rounded-circle d-inline-block position-absolute top-50 start-100 translate-middle" style="width: 8px; height: 8px;"></span>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h4 class="fs-14 fw-medium mb-1">Sarah Davis</h4>
                                                                    <span class="text-body">65 Calls</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-body">Avg. Call Duration</span>
                                                            <span class="fw-medium d-block">4 mins 10 secs</span>
                                                        </td> 
                                                        <td>
                                                            <span class="text-body">FCR</span>
                                                            <span class="fw-medium d-block">85%</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-body">CSAT</span>
                                                            <span class="fw-medium d-block">90%</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xxl-6">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="custom-padding-30">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Call Center Geography</h3>

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
                                    <div class="text-center" style="margin: 40px 0;">
                                        <div id="call_center_geography" style="height: 188px;"></div>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled sales_by_locations mt-4">
                                        <li class="d-flex align-items-center pe-0">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/usa.svg" class="wh-30 rounded-circle" alt="usa">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex justify-content-between position-relative">
                                                    <span class="fw-medium d-block mb-2">United States</span>
                                                    <span class="count fw-medium text-body">90%</span>
                                                    <span class="position-absolute top-50 start-50 translate-middle pb-2">1,200 calls</span>
                                                </div>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-success" style="width: 90%"></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center pe-0">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/canada.svg" class="wh-30 rounded-circle" alt="canada">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex justify-content-between position-relative">
                                                    <span class="fw-medium d-block mb-2">Canada</span>
                                                    <span class="count fw-medium text-body">88%</span>
                                                    <span class="position-absolute top-50 start-50 translate-middle pb-2">980 calls</span>
                                                </div>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-primary-div" style="width: 88%"></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center pe-0">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/brazil.svg" class="wh-30 rounded-circle" alt="brazil">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex justify-content-between position-relative">
                                                    <span class="fw-medium d-block mb-2">Brazil</span>
                                                    <span class="count fw-medium text-body">65%</span>
                                                    <span class="position-absolute top-50 start-50 translate-middle pb-2">850 calls</span>
                                                </div>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-danger" style="width: 65%"></div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-4">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="custom-padding-30">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-2 mb-4">
                                        <h3 class="mb-0">Agent Avg. Earnings</h3>

                                        <div class="dropdown action-opt">
                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-vertical"></i>
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

                                    <ul class="nav nav-tabs justify-content-between ethereum-rate-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active fw-normal" style="font-size: 14px;" id="ethereum1-tab" data-bs-toggle="tab" data-bs-target="#ethereum1-tab-pane" type="button" role="tab" aria-controls="ethereum1-tab-pane" aria-selected="true">1d</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link fw-normal" style="font-size: 14px;" id="ethereum2-tab" data-bs-toggle="tab" data-bs-target="#ethereum2-tab-pane" type="button" role="tab" aria-controls="ethereum2-tab-pane" aria-selected="false">15d</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link fw-normal" style="font-size: 14px;" id="ethereum3-tab" data-bs-toggle="tab" data-bs-target="#ethereum3-tab-pane" type="button" role="tab" aria-controls="ethereum3-tab-pane" aria-selected="false">1m</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link fw-normal" style="font-size: 14px;" id="ethereum4-tab" data-bs-toggle="tab" data-bs-target="#ethereum4-tab-pane" type="button" role="tab" aria-controls="ethereum4-tab-pane" aria-selected="false">6m</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link fw-normal" style="font-size: 14px;" id="ethereum5-tab" data-bs-toggle="tab" data-bs-target="#ethereum5-tab-pane" type="button" role="tab" aria-controls="ethereum5-tab-pane" aria-selected="false">1y</button>
                                        </li>
                                    </ul>
    
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="ethereum1-tab-pane" role="tabpanel" aria-labelledby="ethereum1-tab" tabindex="0">
                                            <div style="margin: -30px -5px 0 -21px;">
                                                <div id="agent_avg_earnings"></div>
                                            </div>
                                            <div class="d-flex align-items-center position-relative z-1 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-body-bg border text-center rounded-2" style="width: 48px; height: 48px; line-height: 48px;">
                                                            <img src="/assets/images/agent-avg-earnings.svg" alt="agent-avg-earnings">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h3 class="fs-28 fw-semibold text-secondary mb-0">$2,534</h3>
                                                        <span class="text-body d-block">Last month earning</span>
                                                    </div>
                                                </div>
        
                                                <span class="d-flex align-items-center align-items-center text-body"> 
                                                    <i class="material-symbols-outlined fs-18 pe-2 text-success">trending_up</i> 
                                                    <span class="fw-medium me-1 text-secondary">+8.7%</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="ethereum2-tab-pane" role="tabpanel" aria-labelledby="ethereum2-tab" tabindex="0">
                                            <div style="margin: -30px -5px 0 -21px;">
                                                <div id="agent_avg_earnings2"></div>
                                            </div>
                                            <div class="d-flex align-items-center position-relative z-1 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-body-bg border text-center rounded-2" style="width: 48px; height: 48px; line-height: 48px;">
                                                            <img src="/assets/images/agent-avg-earnings.svg" alt="agent-avg-earnings">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h3 class="fs-28 fw-semibold text-secondary mb-0">$3,456</h3>
                                                        <span class="text-body d-block">Last month earning</span>
                                                    </div>
                                                </div>
        
                                                <span class="d-flex align-items-center align-items-center text-body"> 
                                                    <i class="material-symbols-outlined fs-18 pe-2 text-success">trending_up</i> 
                                                    <span class="fw-medium me-1 text-secondary">+8.7%</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="ethereum3-tab-pane" role="tabpanel" aria-labelledby="ethereum3-tab" tabindex="0">
                                            <div style="margin: -30px -5px 0 -21px;">
                                                <div id="agent_avg_earnings3"></div>
                                            </div>
                                            <div class="d-flex align-items-center position-relative z-1 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-body-bg border text-center rounded-2" style="width: 48px; height: 48px; line-height: 48px;">
                                                            <img src="/assets/images/agent-avg-earnings.svg" alt="agent-avg-earnings">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h3 class="fs-28 fw-semibold text-secondary mb-0">$1,753</h3>
                                                        <span class="text-body d-block">Last month earning</span>
                                                    </div>
                                                </div>
        
                                                <span class="d-flex align-items-center align-items-center text-body"> 
                                                    <i class="material-symbols-outlined fs-18 pe-2 text-success">trending_up</i> 
                                                    <span class="fw-medium me-1 text-secondary">+4.7%</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="ethereum4-tab-pane" role="tabpanel" aria-labelledby="ethereum4-tab" tabindex="0">
                                            <div style="margin: -30px -5px 0 -21px;">
                                                <div id="agent_avg_earnings4"></div>
                                            </div>
                                            <div class="d-flex align-items-center position-relative z-1 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-body-bg border text-center rounded-2" style="width: 48px; height: 48px; line-height: 48px;">
                                                            <img src="/assets/images/agent-avg-earnings.svg" alt="agent-avg-earnings">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h3 class="fs-28 fw-semibold text-secondary mb-0">$6,753</h3>
                                                        <span class="text-body d-block">Last month earning</span>
                                                    </div>
                                                </div>
        
                                                <span class="d-flex align-items-center align-items-center text-body"> 
                                                    <i class="material-symbols-outlined fs-18 pe-2 text-success">trending_up</i> 
                                                    <span class="fw-medium me-1 text-secondary">+6.7%</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="ethereum5-tab-pane" role="tabpanel" aria-labelledby="ethereum5-tab" tabindex="0">
                                            <div style="margin: -30px -5px 0 -21px;">
                                                <div id="agent_avg_earnings5"></div>
                                            </div>
                                            <div class="d-flex align-items-center position-relative z-1 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-body-bg border text-center rounded-2" style="width: 48px; height: 48px; line-height: 48px;">
                                                            <img src="/assets/images/agent-avg-earnings.svg" alt="agent-avg-earnings">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h3 class="fs-28 fw-semibold text-secondary mb-0">$5,325</h3>
                                                        <span class="text-body d-block">Last month earning</span>
                                                    </div>
                                                </div>
        
                                                <span class="d-flex align-items-center align-items-center text-body"> 
                                                    <i class="material-symbols-outlined fs-18 pe-2 text-success">trending_up</i> 
                                                    <span class="fw-medium me-1 text-secondary">+3.7%</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 custom-padding-30 border-bottom pb-4 custom-padding-30">
                                    <h3 class="mb-0">Recent Calls</h3>
                                    <div class="d-flex align-items-center">
                                        <form class="position-relative table-src-form">
                                            <input type="text" class="form-control border-0" id="SearchControl" style="width: 265px;" placeholder="Search for a name....">
                                            <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                        </form>
                                        <div class="dropdown action-opt">
                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-vertical"></i>
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
                                </div>
    
                                <div class="default-table-area style-three recent-calls for-data-table">
                                    <div class="table-responsive">
                                        <table class="table align-middle border-0" id="myTable">
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th scope="col" class="bg-transparent">Caller Name</th>
                                                    <th scope="col" class="bg-transparent">Call Type</th>
                                                    <th scope="col" class="bg-transparent">Duration</th>
                                                    <th scope="col" class="bg-transparent">Status</th>
                                                    <th scope="col" class="bg-transparent">Time</th>
                                                    <th scope="col" class="bg-transparent">CSAT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-6.jpg" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2">
                                                                <h4 class="fs-14 fw-medium mb-0">Emily Johnson</h4>
                                                                <span class="fs-12 text-body">+1 555-123-4567</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-primary fw-medium">Inbound</td> 
                                                    <td class="fw-medium">5 mins</td> 
                                                    <td class="text-success-60 fw-medium">Resolved</td> 
                                                    <td class="fw-medium">10:30 AM</td> 
                                                    <td class="text-success-60 fw-medium">90%</td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-7.jpg" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2">
                                                                <h4 class="fs-14 fw-medium mb-0">Sarah Green</h4>
                                                                <span class="fs-12 text-body">+44 20 7946 0958</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-danger fw-medium">Outbound</td> 
                                                    <td class="fw-medium">3 mins</td> 
                                                    <td class="text-danger fw-medium">Pending</td> 
                                                    <td class="fw-medium">10:35 AM</td> 
                                                    <td class="text-success-60 fw-medium">85%</td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-8.jpg" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2">
                                                                <h4 class="fs-14 fw-medium mb-0">Adam Smith</h4>
                                                                <span class="fs-12 text-body">+1 555-234-5678</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-primary fw-medium">Inbound</td> 
                                                    <td class="fw-medium">7 mins</td> 
                                                    <td class="text-success-60 fw-medium">Resolved</td> 
                                                    <td class="fw-medium">10:40 AM</td> 
                                                    <td class="text-success-60 fw-medium">83%</td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-9.jpg" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2">
                                                                <h4 class="fs-14 fw-medium mb-0">Laura Martin</h4>
                                                                <span class="fs-12 text-body">+61 2 1234 5678</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-primary fw-medium">Inbound</td> 
                                                    <td class="fw-medium">4 mins</td> 
                                                    <td class="text-primary-div fw-medium">Dropped</td> 
                                                    <td class="fw-medium">10:45 AM</td> 
                                                    <td class="text-success-60 fw-medium">87%</td> 
                                                </tr>
                                            </tbody>
                                        </table>
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