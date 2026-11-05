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
                    <div class="card border-0 rounded-3 bg-white p-25 bg-img debit-card-bg-for-dark-mode mb-4" style="background-image: url(/assets/images/sparkline-bg.jpg);">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 crypto-performance">
                            <h3 class="mb-0 text-white">Crypto Performance</h3>

                            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                <ol class="breadcrumb align-items-center mb-0 lh-1">
                                    <li class="breadcrumb-item">
                                        <a href="#" class="d-flex align-items-center text-decoration-none">
                                            <i class="ri-home-4-line fs-18 text-white me-1 position-relative" style="top: -1px;"></i>
                                            <span class="text-secondary hover text-white fs-13">Dashboard</span>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <span class="text-white fs-13">Crypto Performance</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-lg-6">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                                    <h3 class="mb-0 fw-semibold">Performance Per Investment</h3>
                                    <div class="dropdown select-dropdown without-border position-relative" style="right: -5px;">
                                        <button class="dropdown-toggle bg-transparent border text-body rounded-2" style="padding-right: 20px;" data-bs-toggle="dropdown" aria-expanded="false">
                                            Last Month
                                        </button>
                                      
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Today</button>
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

                                <div style="margin: -15px 0 -14px 0;">
                                    <div id="performance_per_investment_chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row g-4">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="card border-0 rounded-3 bg-primary-70 p-25 performance-for-darkmode" style="padding-top: 15px; padding-bottom: 15px;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="flex-grow-1">
                                                <span class="d-block">Portfolio Value</span>
                                                <h3 class="fs-20 mb-0" style="margin-top: 4px;">$94.69B</h3>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="material-symbols-outlined d-flex align-items-center justify-content-center text-primary rounded-circle fs-24 bg-white" style="width: 53px; height: 53px;">attach_money</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="card border-0 rounded-3 bg-primary-div-60 p-25 performance-for-darkmode" style="padding-top: 15px; padding-bottom: 15px;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="flex-grow-1">
                                                <span class="d-block">Crypto Market Cap</span>
                                                <h3 class="fs-20 mb-0" style="margin-top: 4px;">$2.64T</h3>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="material-symbols-outlined d-flex align-items-center justify-content-center text-primary-div rounded-circle fs-24 bg-white" style="width: 53px; height: 53px;">payments</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card bg-white border-0 rounded-3">
                                        <div class="card-body p-0">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 p-4">
                                                <h3 class="mb-0">Transactions History</h3>

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
                
                                            <div class="default-table-area style-two transactions-history">
                                                <div class="table-responsive">
                                                    <table class="table align-middle">
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-body">
                                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                                        <img src="/assets/images/cardano.png" style="max-width: 22px;" alt="cardano">
                                                                        <span class="fw-medium text-secondary fs-13">Bitcoin <span class="fw-normal fs-12 text-body">(BTC)</span></span>
                                                                    </div>
                                                                </td> 
                                                                <td class="text-center">
                                                                    <span class="d-inline-block bg-success-60 bg-opacity-25 rounded-1 text-success-60 fs-12 fw-medium" style="padding: 2px 8px;">Sold</span>
                                                                </td> 
                                                                <td class="text-body text-end fs-13">$68848.92</td> 
                                                            </tr>
                                                            <tr>
                                                                <td class="text-body">
                                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                                        <img src="/assets/images/ethereum-2.png" style="max-width: 22px;" alt="ethereum-2">
                                                                        <span class="fw-medium text-secondary fs-13">Ethereum<span class="fw-normal fs-12 text-body">(ETH)</span></span>
                                                                    </div>
                                                                </td> 
                                                                <td class="text-center">
                                                                    <span class="d-inline-block bg-danger-80 bg-opacity-25 rounded-1 text-danger-80 fs-12 fw-medium" style="padding: 2px 8px;">Withdraw</span>
                                                                </td> 
                                                                <td class="text-body text-end fs-13">$2565.77</td> 
                                                            </tr>
                                                            <tr>
                                                                <td class="text-body">
                                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                                        <img src="/assets/images/binance-2.png" style="max-width: 22px;" alt="binance-2">
                                                                        <span class="fw-medium text-secondary fs-13">Binance<span class="fw-normal fs-12 text-body">(BNB)</span></span>
                                                                    </div>
                                                                </td> 
                                                                <td class="text-center">
                                                                    <span class="d-inline-block bg-success-60 bg-opacity-25 rounded-1 text-success-60 fs-12 fw-medium" style="padding: 2px 8px;">Sold</span>
                                                                </td> 
                                                                <td class="text-body text-end fs-13">$2565.77</td> 
                                                            </tr>
                                                            <tr>
                                                                <td class="text-body">
                                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                                        <img src="/assets/images/tether.png" style="max-width: 22px;" alt="tether">
                                                                        <span class="fw-medium text-secondary fs-13">Tether<span class="fw-normal fs-12 text-body">(USDT)</span></span>
                                                                    </div>
                                                                </td> 
                                                                <td class="text-center">
                                                                    <span class="d-inline-block bg-success-60 bg-opacity-25 rounded-1 text-success-60 fs-12 fw-medium" style="padding: 2px 8px;">Sold</span>
                                                                </td> 
                                                                <td class="text-body text-end fs-13">$1.00</td> 
                                                            </tr>
                                                            <tr>
                                                                <td class="text-body">
                                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                                        <img src="/assets/images/xrp.png" style="max-width: 22px;" alt="xrp">
                                                                        <span class="fw-medium text-secondary fs-13">XRP<span class="fw-normal fs-12 text-body">(XRP)</span></span>
                                                                    </div>
                                                                </td> 
                                                                <td class="text-center">
                                                                    <span class="d-inline-block bg-danger-80 bg-opacity-25 rounded-1 text-danger-80 fs-12 fw-medium" style="padding: 2px 8px;">Withdraw</span>
                                                                </td> 
                                                                <td class="text-body text-end fs-13">$0.529105</td> 
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                    
                                                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap p-4" style="padding-top: 15px !important;">
                                                    <span class="fs-13">Showing 5 of 36 results</span>
                    
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
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-lg-5">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                                    <h3 class="mb-0 fw-semibold">Market Performance</h3>
                                    <div class="dropdown select-dropdown without-border position-relative" style="right: -5px;">
                                        <button class="dropdown-toggle bg-transparent border text-body rounded-2" style="padding-right: 20px;" data-bs-toggle="dropdown" aria-expanded="false">
                                            Last Month
                                        </button>
                                      
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Today</button>
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

                                <div id="market_performance_chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                                    <h3 class="mb-0 fw-semibold">Performance Metrics</h3>
                                    <div class="dropdown select-dropdown without-border position-relative" style="right: -5px;">
                                        <button class="dropdown-toggle bg-transparent border text-body rounded-2" style="padding-right: 20px;" data-bs-toggle="dropdown" aria-expanded="false">
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

                                <div style="margin: -20px 0 -22px 0;">
                                    <div id="performance_metrics_chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 p-4">
                                <h3 class="mb-0">Individual Asset Performance</h3>

                                <div class="dropdown select-dropdown">
                                    <button class="dropdown-toggle border text-body rounded-2 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                        Last 30 Days
                                    </button>
                                    
                                    <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">Last 7 Days</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">Last 15 Days</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">Last 30 Days</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="default-table-area style-two py-21 individual-asset-performance">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-secondary">Asset</th>
                                                <th scope="col" class="text-secondary">Allocation %</th>
                                                <th scope="col" class="text-secondary">ROI</th>
                                                <th scope="col" class="text-secondary">Current Value</th>
                                                <th scope="col" class="text-secondary">Net Gain/Los</th>
                                                <th scope="col" class="text-secondary">1D Change</th>
                                                <th scope="col" class="text-secondary">7D Change</th>
                                                <th scope="col" class="text-secondary">Sparkline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">
                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                        <img src="/assets/images/cardano.png" style="max-width: 22px;" alt="cardano">
                                                        <span class="fw-medium text-secondary fs-13">Bitcoin <span class="fw-normal fs-12 text-body">(BTC)</span></span>
                                                    </div>
                                                </td>
                                                <td>35%</td> 
                                                <td>+120%</td> 
                                                <td>$35,000</td> 
                                                <td>$15,000</td> 
                                                <td class="text-success-60">+0.5%</td> 
                                                <td class="text-success-60">+3.0%</td>
                                                <td class="overflow-hidden">
                                                    <div class="position-relative" style="top: 9px;">
                                                        <div id="individual_asset_performance_chart_1"></div>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">
                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                        <img src="/assets/images/ethereum-2.png" style="max-width: 22px;" alt="ethereum-2">
                                                        <span class="fw-medium text-secondary fs-13">Ethereum<span class="fw-normal fs-12 text-body">(ETH)</span></span>
                                                    </div>
                                                </td>
                                                <td>25%</td> 
                                                <td>+80%</td> 
                                                <td>$25,000</td> 
                                                <td>$8,000</td> 
                                                <td class="text-danger-80">-1.0%</td> 
                                                <td class="text-success-60">+1.5%</td> 
                                                <td class="overflow-hidden">
                                                    <div class="position-relative" style="top: 9px;">
                                                        <div id="individual_asset_performance_chart_2"></div>
                                                    </div>
                                                </td>  
                                            </tr>
                                            <tr>
                                                <td class="text-body">
                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                        <img src="/assets/images/binance-2.png" style="max-width: 22px;" alt="binance-2">
                                                        <span class="fw-medium text-secondary fs-13">Binance<span class="fw-normal fs-12 text-body">(BNB)</span></span>
                                                    </div>
                                                </td>
                                                <td>15%</td> 
                                                <td>+30%</td> 
                                                <td>$7,500</td> 
                                                <td>$1,500</td> 
                                                <td class="text-danger-80">-2.5%</td> 
                                                <td class="text-danger-80">-5.0%</td> 
                                                <td class="overflow-hidden">
                                                    <div class="position-relative" style="top: 9px;">
                                                        <div id="individual_asset_performance_chart_3"></div>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">
                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                        <img src="/assets/images/tether.png" style="max-width: 22px;" alt="tether">
                                                        <span class="fw-medium text-secondary fs-13">Tether<span class="fw-normal fs-12 text-body">(USDT)</span></span>
                                                    </div>
                                                </td>
                                                <td>10%</td> 
                                                <td>+45%</td> 
                                                <td>$4,500</td> 
                                                <td>$1,000</td> 
                                                <td class="text-success-60">+0.2%</td> 
                                                <td class="text-success-60">+2.0%</td> 
                                                <td class="overflow-hidden">
                                                    <div class="position-relative" style="top: 0;">
                                                        <div id="individual_asset_performance_chart_4"></div>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">
                                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                                        <img src="/assets/images/xrp.png" style="max-width: 22px;" alt="xrp">
                                                        <span class="fw-medium text-secondary fs-13">XRP<span class="fw-normal fs-12 text-body">(XRP)</span></span>
                                                    </div>
                                                </td>
                                                <td>5%</td> 
                                                <td>+60%</td> 
                                                <td>$3,000</td> 
                                                <td>$1,200</td> 
                                                <td class="text-success-60">+1.5%</td> 
                                                <td class="text-success-60">+4.5%</td> 
                                                <td class="overflow-hidden">
                                                    <div class="position-relative" style="top: 9px;">
                                                        <div id="individual_asset_performance_chart_5"></div>
                                                    </div>
                                                </td> 
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
    
                                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap p-4" style="padding-top: 15px !important;">
                                    <span class="fs-13">Showing 5 of 36 results</span>
    
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

                    <div class="row g-4 mb-4">
                        <div class="col-lg-4">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <h3 class="mb-4 fw-semibold">Risk & Stability Indicators</h3>

                                <div style="margin-bottom: -2px;">
                                    <div id="risk_stability_indicators_chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                                    <h3 class="mb-0 fw-semibold">Comparative Analysis</h3>
                                    <div class="dropdown select-dropdown without-border position-relative" style="right: -5px;">
                                        <button class="dropdown-toggle bg-transparent border text-body rounded-2" style="padding-right: 20px;" data-bs-toggle="dropdown" aria-expanded="false">
                                            Monthly
                                        </button>
                                      
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
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

                                <div style="margin: -10px 0 -20px 0;">
                                    <div id="comparative_analysis_chart"></div>
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
