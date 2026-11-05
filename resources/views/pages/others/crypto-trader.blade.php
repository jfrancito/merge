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
                    <div class="card border-0 rounded-3 bg-white p-25 bg-img mb-4" style="background-image: url(/assets/images/sparkline-bg.jpg);">
                        <div class="row g-3 g-md-4">
                            <div class="col-xxl-3 col-sm-6">
                                <div class="card border-0 rounded-3 bg-white p-25">
                                    <span class="d-block">Total Value of all Crypto</span>
                                    <h3 class="fs-20 mb-0" style="margin-top: 5px;">$597.655B</h3>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-6">
                                <div class="card border-0 rounded-3 bg-white p-25">
                                    <span class="d-block">First Trade Volume</span>
                                    <h3 class="fs-20 mb-0" style="margin-top: 5px;">$21.953M <sub class="bottom-0 fw-normal text-body fs-14">(1 Jan, 2025)</sub></h3>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-6">
                                <div class="card border-0 rounded-3 bg-white p-25">
                                    <span class="d-block">Last Trade Volume</span>
                                    <h3 class="fs-20 mb-0" style="margin-top: 5px;">$25.965B <sub class="bottom-0 fw-normal text-body fs-14">(1 Nov, 2025)</sub></h3>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-6">
                                <div class="card border-0 rounded-3 bg-white p-25">
                                    <span class="d-block">Crypto Total Market Cap</span>
                                    <h3 class="fs-20 mb-0" style="margin-top: 5px;">$1.36T</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-xxl-8">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                                    <h3 class="mb-0">Price Movement</h3>

                                    <ul class="p-0 m-0 list-unstyled d-flex align-items-center" style="gap: 6px;">
                                        <li>
                                            <button class="bg-primary p-0 border d-flex justify-content-center align-items-center rounded-1 text-white hover-bg" style="width: 40px; height: 30px;">1h</button>
                                        </li>
                                        <li>
                                            <button class="bg-transparent p-0 border d-flex justify-content-center align-items-center rounded-1 text-body hover-bg" style="width: 40px; height: 30px;">1d</button>
                                        </li>
                                        <li>
                                            <button class="bg-transparent p-0 border d-flex justify-content-center align-items-center rounded-1 text-body hover-bg" style="width: 40px; height: 30px;">1w</button>
                                        </li>
                                        <li>
                                            <button class="bg-transparent p-0 border d-flex justify-content-center align-items-center rounded-1 text-body hover-bg" style="width: 40px; height: 30px;">1m</button>
                                        </li>
                                    </ul>
                                </div>

                                <div style="margin: -18px 0 -15px 0;">
                                    <div id="price_movement_chart"></div>
                                    <div id="price_movement_chart2" style="margin-top: -11px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4">
                            <div class="row g-4">
                                <div class="col-xxl-12 col-md-6">
                                    <div class="card border-0 rounded-3 bg-white p-25">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                            <div class="d-flex align-items-center" style="gap: 15px;">
                                                <div>
                                                    <span class="d-block" style="margin-bottom: 5px;">Trading Volume</span>
                                                    <h3 class="mb-0 fs-20 lh-1">$117,950</h3>
                                                </div>
                                                <div>
                                                    <span class="d-inline-block bg-success-80 border-success-60 border px-2 rounded-pill text-success-60 fs-12 fw-medium">+7.6%</span>
                                                </div>
                                            </div>
    
                                            <span>Last 7 days</span>
                                        </div>
                                        
                                        <div style="margin: -24px 0 -24px 0">
                                            <div id="trading_volume_chart"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-12 col-md-6">
                                    <div class="card border-0 rounded-3 bg-white p-25">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                            <h3 class="mb-0">Portfolio Distribution</h3>
                                            
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
                
                                        <div style="margin: -6px 0 -5px 0;">
                                            <div id="portfolio_distribution_chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-lg-8">
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="card border-0 rounded-3 bg-white p-25">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                            <h3 class="mb-0">Profit & Loss</h3>
                                            
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
        
                                        <div style="margin: -21px 0 -20px 0;">
                                            <div id="profit_loss_chart"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border-0 rounded-3 bg-white p-25">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 position-relative z-1">
                                            <h3 class="mb-0">Risk Exposure</h3>
                                            
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
        
                                        <div style="margin: -51px -17px -50px;">
                                            <div id="risk_exposure_chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card bg-white border-0 rounded-3">
                                <div class="card-body p-0">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 p-4">
                                        <h3 class="mb-0">Recent Transactions</h3>
        
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
        
                                    <div class="default-table-area style-two py-14 recent-transactions2">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-secondary">Date</th>
                                                        <th scope="col" class="text-secondary">Asset</th>
                                                        <th scope="col" class="text-secondary">Type</th>
                                                        <th scope="col" class="text-secondary">Amount</th>
                                                        <th scope="col" class="text-secondary">Price</th>
                                                        <th scope="col" class="text-secondary">Total Value	</th>
                                                        <th scope="col" class="text-secondary">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>2025-10-31</td> 
                                                        <td class="fw-medium">Bitcoin</td> 
                                                        <td>
                                                            <span class="d-inline-block bg-success-60 bg-opacity-25 rounded-1 text-success-60 fs-12 fw-medium" style="padding: 2px 8px;">Buy</span>
                                                        </td> 
                                                        <td>0.5 BTC</td> 
                                                        <td>$34,000</td> 
                                                        <td>$17,000</td>
                                                        <td>
                                                            <span class="d-inline-block bg-success-60 bg-opacity-25 rounded-1 text-success-60 fs-12 fw-medium" style="padding: 2px 8px;">Done</span>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td>2025-10-30</td> 
                                                        <td class="fw-medium">Ethereum</td> 
                                                        <td>
                                                            <span class="d-inline-block bg-danger-80 bg-opacity-25 rounded-1 text-danger-80 fs-12 fw-medium" style="padding: 2px 8px;">Sell</span>
                                                        </td> 
                                                        <td>2 ETH</td> 
                                                        <td>$1,800</td> 
                                                        <td>$3,600</td>
                                                        <td>
                                                            <span class="d-inline-block bg-success-60 bg-opacity-25 rounded-1 text-success-60 fs-12 fw-medium" style="padding: 2px 8px;">Done</span>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td>2025-10-29</td> 
                                                        <td class="fw-medium">Tether</td> 
                                                        <td>
                                                            <span class="d-inline-block bg-success-60 bg-opacity-25 rounded-1 text-success-60 fs-12 fw-medium" style="padding: 2px 8px;">Buy</span>
                                                        </td> 
                                                        <td>$1.00</td> 
                                                        <td>$175</td> 
                                                        <td>$1,750</td>
                                                        <td>
                                                            <span class="d-inline-block bg-danger-80 bg-opacity-25 rounded-1 text-danger-80 fs-12 fw-medium" style="padding: 2px 8px;">Failed</span>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td>2025-10-28</td> 
                                                        <td class="fw-medium">USD Coin</td> 
                                                        <td>
                                                            <span class="d-inline-block bg-danger-80 bg-opacity-25 rounded-1 text-danger-80 fs-12 fw-medium" style="padding: 2px 8px;">Sell</span>
                                                        </td> 
                                                        <td>$0.9999</td> 
                                                        <td>$230</td> 
                                                        <td>$1,150</td>
                                                        <td>
                                                            <span class="d-inline-block bg-success-60 bg-opacity-25 rounded-1 text-success-60 fs-12 fw-medium" style="padding: 2px 8px;">Done</span>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td>2025-10-27</td> 
                                                        <td class="fw-medium">Cardano</td> 
                                                        <td>
                                                            <span class="d-inline-block bg-success-60 bg-opacity-25 rounded-1 text-success-60 fs-12 fw-medium" style="padding: 2px 8px;">Buy</span>
                                                        </td> 
                                                        <td>5000 DOGE</td> 
                                                        <td>$0.07</td> 
                                                        <td>$350</td>
                                                        <td>
                                                            <span class="d-inline-block bg-warning bg-opacity-25 rounded-1 text-warning fs-12 fw-medium" style="padding: 2px 8px;">Pending</span>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td>2025-10-26</td> 
                                                        <td class="fw-medium">Tron</td> 
                                                        <td>
                                                            <span class="d-inline-block bg-success-60 bg-opacity-25 rounded-1 text-success-60 fs-12 fw-medium" style="padding: 2px 8px;">Buy</span>
                                                        </td> 
                                                        <td>142 TRX</td> 
                                                        <td>$0.192391</td> 
                                                        <td>$350</td>
                                                        <td>
                                                            <span class="d-inline-block bg-danger-80 bg-opacity-25 rounded-1 text-danger-80 fs-12 fw-medium" style="padding: 2px 8px;">Failed</span>
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
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 p-4">
                                        <h3 class="mb-0">Live Price Tracker</h3>

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
        
                                    <div class="default-table-area style-two py-11">
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
                                                        <td class="text-body text-end fs-13">$68848.92</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-body">
                                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                                <img src="/assets/images/ethereum-2.png" style="max-width: 22px;" alt="ethereum-2">
                                                                <span class="fw-medium text-secondary fs-13">Ethereum<span class="fw-normal fs-12 text-body">(ETH)</span></span>
                                                            </div>
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
                                                        <td class="text-body text-end fs-13">$2565.77</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-body">
                                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                                <img src="/assets/images/tether.png" style="max-width: 22px;" alt="tether">
                                                                <span class="fw-medium text-secondary fs-13">Tether<span class="fw-normal fs-12 text-body">(USDT)</span></span>
                                                            </div>
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
                                                        <td class="text-body text-end fs-13">$0.529105</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-body">
                                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                                <img src="/assets/images/solana-2.png" style="max-width: 22px;" alt="solana">
                                                                <span class="fw-medium text-secondary fs-13">Solana<span class="fw-normal fs-12 text-body">(SOL)</span></span>
                                                            </div>
                                                        </td> 
                                                        <td class="text-body text-end fs-13">$179.44</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-body">
                                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                                <img src="/assets/images/usdc.png" style="max-width: 22px;" alt="usdc">
                                                                <span class="fw-medium text-secondary fs-13">USDC<span class="fw-normal fs-12 text-body">(USDC)</span></span>
                                                            </div>
                                                        </td> 
                                                        <td class="text-body text-end fs-13">$1.00</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-body">
                                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                                <img src="/assets/images/tron.png" style="max-width: 22px;" alt="tron">
                                                                <span class="fw-medium text-secondary fs-13">Tron<span class="fw-normal fs-12 text-body">(TRX)</span></span>
                                                            </div>
                                                        </td> 
                                                        <td class="text-body text-end fs-13">$0.192391</td> 
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

                            <div class="card border-0 rounded-3 bg-white p-25">
                                <h3 class="mb-4">Trades Per Month</h3>

                                <div style="margin: -23px 0 -15px 0">
                                    <div id="trades_per_month_chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-xxl-4 col-md-6">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                    <h3 class="mb-0">Asset Allocation</h3>
                                    
                                    <span>Last 30 Days</span>
                                </div>

                                <div>
                                    <span class="d-block">Total Value</span>
                                    <h3 class="fs-20 mb-0 mt-6">$17,485</h3>
                                </div>

                                <div style="margin: 0 0 -15px 0">
                                    <div id="asset_allocation_chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="card-body p-0 pb-1">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 p-4">
                                        <h3 class="mb-0">Gainers & Losers</h3>

                                        <span>Timeframe: 24h</span>
                                    </div>
        
                                    <div class="default-table-area style-two py-11 gainers-losers">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-body fs-13">Goatseus Maximus</td> 
                                                        <td class="text-body text-center fs-13">$0.719</td> 
                                                        <td class="text-success-60 text-end fs-13">+ 47.44%</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-body fs-13">Uniswap</td> 
                                                        <td class="text-body text-center fs-13">$9.15</td> 
                                                        <td class="text-danger-80 text-end fs-13">- 31.87%</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-body fs-13">Aave</td> 
                                                        <td class="text-body text-center fs-13">$161.05</td> 
                                                        <td class="text-success-60 text-end fs-13">+ 23.94%</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-body fs-13">Bittenso</td> 
                                                        <td class="text-body text-center fs-13">$526.97</td> 
                                                        <td class="text-danger-80 text-end fs-13">- 22.94%</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-body fs-13">Injective</td> 
                                                        <td class="text-body text-center fs-13">$20.87</td> 
                                                        <td class="text-success-60 text-end fs-13">+ 21.41%</td> 
                                                    </tr>
                                                    <tr>
                                                        <td class="text-body fs-13 border-0">Monero</td> 
                                                        <td class="text-body text-center fs-13 border-0">$209.38</td> 
                                                        <td class="text-danger-80 text-end fs-13 border-0">- 0.84%</td> 
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                    <h3 class="mb-0">Market Sentiment Indicator</h3>
                                    
                                    <span>Last 30 Days</span>
                                </div>

                                <div style="margin: -30px 0 -26px 0">
                                    <div id="market_sentiment_indicator_chart"></div>
                                </div>

                                <ul class="p-0 m-0 list-unstyled d-flex align-items-center mx-auto justify-content-center flex-wrap" style="gap: 13px; max-width: 315px;">
                                    <li class="d-flex align-items-center" style="gap: 5px;">
                                        <span class="d-block rounded-circle" style="background-color: #00d26a; width: 12px; height: 12px;"></span>
                                        <span class="fs-12">Extreme Greed</span>
                                    </li>
                                    <li class="d-flex align-items-center" style="gap: 5px;">
                                        <span class="d-block rounded-circle" style="background-color: #00d26a; width: 12px; height: 12px;"></span>
                                        <span class="fs-12">Greed</span>
                                    </li>
                                    <li class="d-flex align-items-center" style="gap: 5px;">
                                        <span class="d-block rounded-circle" style="background-color: #fcd53f; width: 12px; height: 12px;"></span>
                                        <span class="fs-12">Neutral</span>
                                    </li>
                                    <li class="d-flex align-items-center" style="gap: 5px;">
                                        <span class="d-block rounded-circle" style="background-color: #ff6723; width: 12px; height: 12px;"></span>
                                        <span class="fs-12">Fear</span>
                                    </li>
                                    <li class="d-flex align-items-center" style="gap: 5px;">
                                        <span class="d-block rounded-circle" style="background-color: #f8312f; width: 12px; height: 12px;"></span>
                                        <span class="fs-12">Extreme Fear</span>
                                    </li>
                                </ul>
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
