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
                        <div class="col-lg-8">
                            <div class="card border-0 p-4 bg-white rounded-3 mb-4">
                                <div class="d-flex flex-wrap gap-2 justify-content-between mb-30 pb-lg-2">
                                    <div>
                                        <h3 class="mb-1">Analytics Overview</h3>
                                        <span>Track, Analyze, and Optimize Performance</span>
                                    </div>
                                    <div>
                                        <ul class="analytics-tabs d-flex list-unstyled ps-0 mb-0">
                                            <li>
                                                <button>Day</button>
                                            </li>
                                            <li>
                                                <button class="active">Week</button>
                                            </li>
                                            <li>
                                                <button>Month</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row align-items-end">
                                    <div class="col-lg-8 col-md-7">
                                        <div class="me-plus-27 mb-4 mb-md-0">
                                            <div style="margin: -23px -9px -27px -17px;">
                                                <div id="analytics_overview"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-5">
                                        <div class="ms-minus-27">
                                            <div class="mb-4">
                                                <div class="d-flex justify-content-between mb-2 pb-1">
                                                    <div>
                                                        <span class="fs-12 d-block mb-1 text-secondary">New Users</span>
                                                        <h4 class="fs-16 mb-0">19.5k</h4>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="fs-12 d-block mb-1">Goal Reached</span>
                                                        <h4 class="fs-16 mb-0 text-body">75%</h4>
                                                    </div>
                                                </div>
                                                <div class="progress rounded-pill" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-primary rounded-pill" style="width: 75%; height: 4px;"></div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="d-flex justify-content-between mb-2 pb-1">
                                                    <div>
                                                        <span class="fs-12 d-block mb-1 text-secondary">Page Views</span>
                                                        <h4 class="fs-16 mb-0">48k</h4>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="fs-12 d-block mb-1">Goal Reached</span>
                                                        <h4 class="fs-16 mb-0 text-body">45%</h4>
                                                    </div>
                                                </div>
                                                <div class="progress rounded-pill" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-primary-div rounded-pill" style="width: 45%; height: 4px;"></div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="d-flex justify-content-between mb-2 pb-1">
                                                    <div>
                                                        <span class="fs-12 d-block mb-1 text-secondary">Page Sessions</span>
                                                        <h4 class="fs-16 mb-0">33.3k</h4>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="fs-12 d-block mb-1">Goal Reached</span>
                                                        <h4 class="fs-16 mb-0 text-body">55%</h4>
                                                    </div>
                                                </div>
                                                <div class="progress rounded-pill" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-primary rounded-pill" style="width: 55%; height: 4px;"></div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="d-flex justify-content-between mb-2 pb-1">
                                                    <div>
                                                        <span class="fs-12 d-block mb-1 text-secondary">Bounce Rate</span>
                                                        <h4 class="fs-16 mb-0">22.45%</h4>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="fs-12 d-block mb-1">Goal Reached</span>
                                                        <h4 class="fs-16 mb-0 text-body">35%</h4>
                                                    </div>
                                                </div>
                                                <div class="progress rounded-pill" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-danger rounded-pill" style="width: 30%; height: 4px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <div class="card border-0 p-4 bg-white rounded-3 mb-4 position-relative">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 pe-4">
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <div class="mb-3">
                                                <span class="fs-14">Website Visits</span>
                                                <h3 class="fs-20 mb-0">215.2k</h3>
                                            </div>
                                            <div id="website_visits" class="chart-position for-sale" style="right: -10px; top: -30px;"></div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between position-relative mt-1">
                                            <span class="d-inline-block bg-success bg-opacity-10 text-success px-2 border border-success rounded-pill fs-12 fw-medium">+10% Increase</span>
                                            <span class="fs-12">Last 7 days</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 border-start ps-lg-4">
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <div class="mb-3">
                                                <span class="fs-14">New Registers</span>
                                                <h3 class="fs-20 mb-0">35.3k</h3>
                                            </div>
                                            <div id="new_registers" class="chart-position for-sale" style="right: -10px; top: -30px;"></div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between position-relative mt-1">
                                            <span class="d-inline-block bg-success bg-opacity-10 text-success px-2 border border-success rounded-pill fs-12 fw-medium">+15% Increase</span>
                                            <span class="fs-12">Last 7 days</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 d-none d-md-block">
                                        <img src="/assets/images/shape-2.png" class="position-absolute top-0 end-0 bottom-0 shape-2" alt="shape">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card border-0 rounded-3 p-4 position-relative mb-4 realtime-for-dark" style="background-color: #4936F5 !important;">
                                <img src="/assets/images/shape-3.png" class="position-absolute top-0 end-0" alt="shape">
                                <span class="fs-16 fw-normal text-border-color d-block mb-1">Realtime Active Users</span>
                                <h2 class="lh-1 fs-36 mb-0 fw-medium text-white mb-5">4,890</h2>
                                <span class="d-block mb-2 text-white fs-14 fw-normal pb-2" style="border-bottom: 1px solid #605DFF;">Page views per second</span>
                                <div class="text-center" style="margin: -10px -20px -10px -32px;">
                                    <div id="realtime"></div>
                                </div>
                                <ul class="ps-0 mb-0 list-unstyled">
                                    <li class="pb-1 mb-2" style="border-bottom: 1px solid #605DFF;">
                                        <span class="fs-14 fw-semibold text-white">Top Active Pages</span>
                                    </li>
                                    <li class="pb-1 mb-1 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #605DFF;">
                                        <p class="fs-14 fw-normal text-white mb-0">
                                            /monitoring/user-activity 
                                            <a href="#" class="text-decoration-none">
                                                <i class="ri-external-link-line text-white fs-16"></i>
                                            </a>
                                        </p>
                                        <span class="fs-14 fw-normal text-white">1520</span>
                                    </li>
                                    <li class="pb-1 mb-1 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #605DFF;">
                                        <p class="fs-14 fw-normal text-white mb-0">
                                            /monitoring/user-activity 
                                            <a href="#" class="text-decoration-none">
                                                <i class="ri-external-link-line text-white fs-16"></i>
                                            </a>
                                        </p>
                                        <span class="fs-14 fw-normal text-white">980</span>
                                    </li>
                                    <li class="pb-1 mb-1 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #605DFF;">
                                        <p class="fs-14 fw-normal text-white mb-0">
                                            /specific/industry-comparisons 
                                            <a href="#" class="text-decoration-none">
                                                <i class="ri-external-link-line text-white fs-16"></i>
                                            </a>
                                        </p>
                                        <span class="fs-14 fw-normal text-white">856</span>
                                    </li>
                                    <li class="pb-1 mb-1 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #605DFF;">
                                        <p class="fs-14 fw-normal text-white mb-0">
                                            /global-reach-2023/statistics
                                            <a href="#" class="text-decoration-none">
                                                <i class="ri-external-link-line text-white fs-16"></i>
                                            </a>
                                        </p>
                                        <span class="fs-14 fw-normal text-white">735</span>
                                    </li>
                                    <li class="pb-1 mb-1 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #605DFF;">
                                        <p class="fs-14 fw-normal text-white mb-0">
                                            /security-alerts/2024-update 
                                            <a href="#" class="text-decoration-none">
                                                <i class="ri-external-link-line text-white fs-16"></i>
                                            </a>
                                        </p>
                                        <span class="fs-14 fw-normal text-white">520</span>
                                    </li>
                                    <li class="d-flex justify-content-end mt-4">
                                        <a href="#" class="btn btn-outline-primary text-white">
                                            All Real-Time Report
                                            <i class="ri-arrow-right-s-line"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-4">
                                        <h3 class="mb-0">Browser Used By Users</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 pe-4 w-auto" style="background-position: right 0 center; color: #64748B !important;" aria-label="Default select example">
                                            <option>July 01 - July 31, 2024</option>
                                            <option value="1">August 01 - August 31, 2024</option>
                                            <option selected value="2">September 01 - September 31, 2024</option>
                                        </select>
                                    </div>

                                    <div class="default-table-area style-two browser-leads">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr class=" border-bottom">
                                                        <th scope="col" class="text-center bg-transparent">Browser</th>
                                                        <th scope="col" class="text-end bg-transparent">Users (%)</th>
                                                        <th scope="col" class="text-end bg-transparent">Sessions</th>
                                                        <th scope="col" class="text-end bg-transparent">Bounce Rate (%)</th>
                                                        <th scope="col" class="text-end bg-transparent">Avg. Session Duration</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <a href="/my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/chrome.png" class="wh-16 rounded-circle" alt="chrome">
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14">Google Chrome</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-end fw-medium">58.4%</td>
                                                        <td class="text-end fw-medium">12,345</td> 
                                                        <td class="text-end fw-medium">34.2%</td> 
                                                        <td class="text-end fw-medium">3m 15s</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="/my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/safari.png" class="wh-16 rounded-circle" alt="safari">
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14">Safari</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-end fw-medium">58.4%</td>
                                                        <td class="text-end fw-medium">12,345</td> 
                                                        <td class="text-end fw-medium">34.2%</td> 
                                                        <td class="text-end fw-medium">3m 15s</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="/my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/edge.png" class="wh-16 rounded-circle" alt="edge">
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14">Microsoft Edge</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-end fw-medium">58.4%</td>
                                                        <td class="text-end fw-medium">12,345</td> 
                                                        <td class="text-end fw-medium">34.2%</td> 
                                                        <td class="text-end fw-medium">3m 15s</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="/my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/firefox.png" class="wh-16 rounded-circle" alt="firefox">
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14">Mozilla Firefox</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-end fw-medium">58.4%</td>
                                                        <td class="text-end fw-medium">12,345</td> 
                                                        <td class="text-end fw-medium">34.2%</td> 
                                                        <td class="text-end fw-medium">3m 15s</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="/my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/opera.png" class="wh-16 rounded-circle" alt="opera">
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14">Opera</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-end fw-medium">58.4%</td>
                                                        <td class="text-end fw-medium">12,345</td> 
                                                        <td class="text-end fw-medium">34.2%</td> 
                                                        <td class="text-end fw-medium">3m 15s</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="/my-profile" class="d-flex align-items-center">
                                                                <img src="/assets/images/other.png" class="wh-16 rounded-circle" alt="other">
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14">Other</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-end fw-medium">58.4%</td>
                                                        <td class="text-end fw-medium">12,345</td> 
                                                        <td class="text-end fw-medium">34.2%</td> 
                                                        <td class="text-end fw-medium">3m 15s</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-4">
                                        <h3 class="mb-0">Browser Used By Users</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 pe-4 w-auto" style="background-position: right 0 center; color: #64748B !important;" aria-label="Default select example">
                                            <option>Last Week</option>
                                            <option value="1">Last Month</option>
                                            <option selected value="2">Last Year</option>
                                        </select>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-sm-5">
                                            <div id="device_sessions"></div>
                                        </div>
                                        <div class="col-sm-7">
                                            <ul class="ps-0 mb-0 list-unstyled ms-plus-21 border-top pt-1">
                                                <li class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-1">
                                                    <div class="d-flex align-items-center">
                                                        <span class="d-inline-block bg-success rounded-circle" style="width: 10px; height: 10px;"></span>
                                                        <div class="ps-3">
                                                            <span class="fs-12 text-secondary d-block mb-1">Desktop</span>
                                                            <h4 class="fw-semibold fs-16 mb-0">45.2%</h4>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <span class="text-body d-block mb-1 fs-12">Sessions</span>
                                                        <h4 class="text-body mb-0 fw-semibold">8,732</h4>
                                                    </div>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-1">
                                                    <div class="d-flex align-items-center">
                                                        <span class="d-inline-block bg-primary rounded-circle" style="width: 10px; height: 10px;"></span>
                                                        <div class="ps-3">
                                                            <span class="fs-12 text-secondary d-block mb-1">Mobile</span>
                                                            <h4 class="fw-semibold fs-16 mb-0">48.7%</h4>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <span class="text-body d-block mb-1 fs-12">Sessions</span>
                                                        <h4 class="text-body mb-0 fw-semibold">9,416</h4>
                                                    </div>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-1">
                                                    <div class="d-flex align-items-center">
                                                        <span class="d-inline-block bg-primary-div rounded-circle" style="width: 10px; height: 10px;"></span>
                                                        <div class="ps-3">
                                                            <span class="fs-12 text-secondary d-block mb-1">Tablet</span>
                                                            <h4 class="fw-semibold fs-16 mb-0">32.3%</h4>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <span class="text-body d-block mb-1 fs-12">Sessions</span>
                                                        <h4 class="text-body mb-0 fw-semibold">1,042</h4>
                                                    </div>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-1">
                                                    <div class="d-flex align-items-center">
                                                        <span class="d-inline-block bg-danger rounded-circle" style="width: 10px; height: 10px;"></span>
                                                        <div class="ps-3">
                                                            <span class="fs-12 text-secondary d-block mb-1">Other</span>
                                                            <h4 class="fw-semibold fs-16 mb-0">45.2%</h4>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <span class="text-body d-block mb-1 fs-12">Sessions</span>
                                                        <h4 class="text-body mb-0 fw-semibold">135</h4>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <p class="fs-12 lh-16 mt-3 pt-2">This data helps you understand which devices are most commonly used and how engagement metrics vary between them.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-xl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box position-relative">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <span>Clicks</span>
                                            <div class="d-flex align-items-center mb-4">
                                                <h3 class="fs-20 mt-1 mb-0">4,500</h3>
                                                <span class="d-inline-block bg-success text-success bg-opacity-25 px-2 rounded-1 fs-12 fw-medium d-flex align-items-center ms-2"><i class="ri-arrow-up-s-fill fs-20 lh-1 me-1"></i> 37.5%</span>
                                            </div>
                                            <span class="fs-12">Last 30 days</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <div id="clicks" class="chart-position" style="max-width: 160px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box position-relative">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <span>Impressions</span>
                                            <div class="d-flex align-items-center mb-4">
                                                <h3 class="fs-20 mt-1 mb-0">12,000</h3>
                                                <span class="d-inline-block bg-danger text-danger bg-opacity-25 px-2 rounded-1 fs-12 fw-medium d-flex align-items-center ms-2"><i class="ri-arrow-down-s-fill fs-20 lh-1 me-1"></i> 10.5%</span>
                                            </div>
                                            <span class="fs-12">Last 30 days</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <div id="impressions" class="chart-position" style="max-width: 160px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box position-relative">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <span>Sessions</span>
                                            <div class="d-flex align-items-center mb-4">
                                                <h3 class="fs-20 mt-1 mb-0">3,800</h3>
                                                <span class="d-inline-block bg-success text-success bg-opacity-25 px-2 rounded-1 fs-12 fw-medium d-flex align-items-center ms-2"><i class="ri-arrow-up-s-fill fs-20 lh-1 me-1"></i> 17.8%</span>
                                            </div>
                                            <span class="fs-12">Last 30 days</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <div id="sessions" class="chart-position" style="max-width: 160px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0">Sessions by Channel</h3>
                                        <select class="form-select month-select form-control w-135" aria-label="Default select example">
                                            <option selected>Last 30 Days</option>
                                            <option value="1">Last 60 Days</option>
                                            <option value="2">Last 90 Days</option>
                                        </select>
                                    </div>

                                    <div style="margin-top: -10px; margin-bottom: 10px;">
                                        <div id="sessions_by_channel"></div> 
                                    </div>

                                    <div class="d-flex justify-content-center flex-wrap gap-3 gap-lg-4">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <span class="wh-11 bg-primary rounded-1 me-1"></span>
                                                <span>Email</span>
                                            </div>
                                            <h4 class="fs-18 fw-medium mb-0 mt-1 ps-3">976</h4>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <span class="wh-11 rounded-1 me-1" style="background-color: #3584FC;"></span>
                                                <span>Organic Search</span>
                                            </div>
                                            <h4 class="fs-18 fw-medium mb-0 mt-1 ps-3">651</h4>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <span class="wh-11 bg-primary-div rounded-1 me-1"></span>
                                                <span>Direct Browse</span>
                                            </div>
                                            <h4 class="fs-18 fw-medium mb-0 mt-1 ps-3">818</h4>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <span class="wh-11 bg-info rounded-1 me-1"></span>
                                                <span>Paid Search</span>
                                            </div>
                                            <h4 class="fs-18 fw-medium mb-0 mt-1 ps-3">459</h4>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <span class="wh-11 bg-success rounded-1 me-1"></span>
                                                <span>Social</span>
                                            </div>
                                            <h4 class="fs-18 fw-medium mb-0 mt-1 ps-3">320</h4>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <span class="wh-11 bg-danger rounded-1 me-1"></span>
                                                <span>Referral</span>
                                            </div>
                                            <h4 class="fs-18 fw-medium mb-0 mt-1 ps-3">209</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-4">
                                        <h3 class="mb-0">Clicks/Impressions by Keywords</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 pe-4 w-auto" style="background-position: right 0 center; color: #64748B !important;" aria-label="Default select example">
                                            <option>July 01 - July 31, 2024</option>
                                            <option value="1">August 01 - August 31, 2024</option>
                                            <option selected value="2">September 01 - September 31, 2024</option>
                                        </select>
                                    </div>

                                    <div class="default-table-area style-two browser-leads">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0 w-100 for-mobile-width">
                                                <thead>
                                                    <tr class="border-bottom">
                                                        <th scope="col" class="text-center bg-transparent">
                                                            <div class="d-flex">
                                                                <span>#</span>
                                                                <span class="ps-4">Dimension</span>
                                                            </div>
                                                        </th>
                                                        <th scope="col" class="text-end bg-transparent">Impressions</th>
                                                        <th scope="col" class="text-end bg-transparent">Clicks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex">
                                                                <span class="fw-medium">1</span>
                                                                <span class="ps-4 fw-medium">data metrics</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-success fs-20 position-relative top-2  me-2">trending_up</i>
                                                                <span class="fw-medium">949</span>
                                                            </div>
                                                        </td> 
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-danger fs-20 position-relative top-1  me-2">trending_down</i>
                                                                <span class="fw-medium">656</span>
                                                            </div>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex">
                                                                <span class="fw-medium">2</span>
                                                                <span class="ps-4 fw-medium">sales metrics</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-success fs-20 position-relative top-2  me-2">trending_up</i>
                                                                <span class="fw-medium">842</span>
                                                            </div>
                                                        </td> 
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-danger fs-20 position-relative top-1  me-2">trending_down</i>
                                                                <span class="fw-medium">420</span>
                                                            </div>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex">
                                                                <span class="fw-medium">3</span>
                                                                <span class="ps-4 fw-medium">analytics dashboard</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-success fs-20 position-relative top-2  me-2">trending_up</i>
                                                                <span class="fw-medium">640</span>
                                                            </div>
                                                        </td> 
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-success fs-20 position-relative top-2  me-2">trending_up</i>
                                                                <span class="fw-medium">534</span>
                                                            </div>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex">
                                                                <span class="fw-medium">4</span>
                                                                <span class="ps-4 fw-medium">saas metrics</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-success fs-20 position-relative top-2  me-2">trending_up</i>
                                                                <span class="fw-medium">865</span>
                                                            </div>
                                                        </td> 
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-success fs-20 position-relative top-2  me-2">trending_up</i>
                                                                <span class="fw-medium">560</span>
                                                            </div>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex">
                                                                <span class="fw-medium">5</span>
                                                                <span class="ps-4 fw-medium">hubspot analytics</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-danger fs-20 position-relative top-2  me-2">trending_down</i>
                                                                <span class="fw-medium">435</span>
                                                            </div>
                                                        </td> 
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-danger fs-20 position-relative top-1  me-2">trending_down</i>
                                                                <span class="fw-medium">328</span>
                                                            </div>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex">
                                                                <span class="fw-medium">6</span>
                                                                <span class="ps-4 fw-medium">smart goals</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-success fs-20 position-relative top-2  me-2">trending_up</i>
                                                                <span class="fw-medium">756</span>
                                                            </div>
                                                        </td> 
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-success fs-20 position-relative top-2  me-2">trending_up</i>
                                                                <span class="fw-medium">235</span>
                                                            </div>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex">
                                                                <span class="fw-medium">7</span>
                                                                <span class="ps-4 fw-medium">google analytics</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-success fs-20 position-relative top-2  me-2">trending_up</i>
                                                                <span class="fw-medium">578</span>
                                                            </div>
                                                        </td> 
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-danger fs-20 position-relative top-1  me-2">trending_down</i>
                                                                <span class="fw-medium">456</span>
                                                            </div>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex">
                                                                <span class="fw-medium">8</span>
                                                                <span class="ps-4 fw-medium">trezo dashboard</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-success fs-20 position-relative top-2  me-2">trending_up</i>
                                                                <span class="fw-medium">660</span>
                                                            </div>
                                                        </td> 
                                                        <td class="text-end fw-medium">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <i class="material-symbols-outlined text-danger fs-20 position-relative top-1  me-2">trending_down</i>
                                                                <span class="fw-medium">478</span>
                                                            </div>
                                                        </td> 
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                                            <span class="fs-12 fw-medium">Showing 8 of 30 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/analytics" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/analytics">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/analytics">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/analytics">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/analytics">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/analytics" aria-label="Next">
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
                        <div class="col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-3 mb-1">
                                        <h3 class="mb-0">Top Browsing Pages Today</h3>
                                        <form class="position-relative table-src-form me-0">
                                            <input type="text" class="form-control" placeholder="Search here">
                                            <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                        </form>
                                    </div>

                                    <div class="default-table-area style-two browser-leads">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr class="border-bottom">
                                                        <th scope="col" class="bg-transparent">Page URL</th>
                                                        <th scope="col" class="bg-transparent">Source</th>
                                                        <th scope="col" class="bg-transparent">Avg Time</th>
                                                        <th scope="col" class="bg-transparent text-end">Page Views</th>
                                                        <th scope="col" class="bg-transparent text-end">Bounce Rate (%)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-medium">
                                                            <a href="/analytics" class="text-primary">/dashboard-overview</a>
                                                        </td>
                                                        <td class="fw-medium">Organic</td> 
                                                        <td class="fw-medium">3m 45s</td> 
                                                        <td class="text-end fw-medium">350</td> 
                                                        <td class="text-end fw-medium">30.5%</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-medium">
                                                            <a href="/analytics" class="text-primary">/custom-reports/generate</a>
                                                        </td>
                                                        <td class="fw-medium">Paid</td> 
                                                        <td class="fw-medium">7m 00s</td> 
                                                        <td class="text-end fw-medium">400</td> 
                                                        <td class="text-end fw-medium">24.9%</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-medium">
                                                            <a href="/analytics" class="text-primary">/export-data</a>
                                                        </td>
                                                        <td class="fw-medium">Direct</td> 
                                                        <td class="fw-medium">2m 30s</td> 
                                                        <td class="text-end fw-medium">125</td> 
                                                        <td class="text-end fw-medium">50.0%</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-medium">
                                                            <a href="/analytics" class="text-primary">/realtime-users</a>
                                                        </td>
                                                        <td class="fw-medium">Referral</td> 
                                                        <td class="fw-medium">3m 00s</td> 
                                                        <td class="text-end fw-medium">190</td> 
                                                        <td class="text-end fw-medium">40.2%</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-medium">
                                                            <a href="/analytics" class="text-primary">/account-preferences</a>
                                                        </td>
                                                        <td class="fw-medium">Organic</td> 
                                                        <td class="fw-medium">2m 50s</td> 
                                                        <td class="text-end fw-medium">180</td> 
                                                        <td class="text-end fw-medium">42.1%</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-medium">
                                                            <a href="/analytics" class="text-primary">/apis-and-reports</a>
                                                        </td>
                                                        <td class="fw-medium">Paid</td> 
                                                        <td class="fw-medium">4m 15s</td> 
                                                        <td class="text-end fw-medium">320</td> 
                                                        <td class="text-end fw-medium">28.7%</td> 
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                                            <span class="fs-12 fw-medium">Showing 6 of 30 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/analytics" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/analytics">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/analytics">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/analytics">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/analytics">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/analytics" aria-label="Next">
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
                        <div class="col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 pb-0">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                        <h3 class="mb-0">Users by Country</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 pe-4 w-auto" style="background-position: right 0 center; color: #64748B !important;" aria-label="Default select example">
                                            <option>Last Week</option>
                                            <option value="1">Last Month</option>
                                            <option selected value="2">Last Year</option>
                                        </select>
                                    </div>
                                    <div class="map text-center my-5">
                                        <img src="/assets/images/map-2.png" alt="map">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="d-flex mb-4">
                                                <div class="flex-shrink-0 position-relative top-1">
                                                    <img src="/assets/images/united-states-2.png" class="rounded-circle" style="width: 20px; height: 20px;" alt="united-states">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span class="fs-12 fw-medium d-block mb-1">United States</span>
                                                    <h4 class="mb-0 fs-16 fw-semibold">12,800 <span class="text-body fs-12">35.6%</span></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex mb-4">
                                                <div class="flex-shrink-0 position-relative top-1">
                                                    <img src="/assets/images/united-kingdom-2.png" class="rounded-circle" style="width: 20px; height: 20px;" alt="united-states">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span class="fs-12 fw-medium d-block mb-1">United Kingdom</span>
                                                    <h4 class="mb-0 fs-16 fw-semibold">6,750 <span class="text-body fs-12">18.7%</span></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="border-bottom mb-4"></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex mb-4">
                                                <div class="flex-shrink-0 position-relative top-1">
                                                    <img src="/assets/images/canada-2.png" class="rounded-circle" style="width: 20px; height: 20px;" alt="canada">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span class="fs-12 fw-medium d-block mb-1">Canada</span>
                                                    <h4 class="mb-0 fs-16 fw-semibold">2,500 <span class="text-body fs-12">6.3%</span></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex mb-4">
                                                <div class="flex-shrink-0 position-relative top-1">
                                                    <img src="/assets/images/australia.png" class="rounded-circle" style="width: 20px; height: 20px;" alt="australia">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span class="fs-12 fw-medium d-block mb-1">Australia</span>
                                                    <h4 class="mb-0 fs-16 fw-semibold">2,200 <span class="text-body fs-12">5.4%</span></h4>
                                                </div>
                                            </div>
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
