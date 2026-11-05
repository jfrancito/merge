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
                    <div class="border-0 p-4 pb-0 bg-white rounded-3 mb-4 without-card">
                        <div class="d-flex flex-wrap gap-2 justify-content-between mb-4">
                            <div>
                                <h3 class="mb-0">Cryptocurrency Watch List</h3>
                            </div>
                            <div>
                                <div class="cryptocurrency-controller d-flex gap-1">
                                    <div class="controller-icon prev">
                                        <i class="ri-arrow-left-s-line"></i>
                                    </div>
                                    <div class="controller-icon next">
                                        <i class="ri-arrow-right-s-line"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper cryptocurrency-slide">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="border-0 rounded-3 mb-4 bg-primary bg-opacity-10 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/bitcoin.png" class="rounded-circle" style="width: 48px; height: 48px;" alt="bitcoin">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <span class="mb-1 d-block fw-medium text-secondary">BITCOIN <span class="text-body fw-normal">(BTC)</span></span>
                                                <div class="d-flex">
                                                    <h3 class="mb-0 fs-20 fw-semibold me-1">$27,500</h3>
                                                    <i class="material-symbols-outlined fs-16 position-relative top-3 text-success">trending_up</i>
                                                    <span class="text-success">+2.3%</span>   
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div id="bitcoin" style="margin: -11px 0; max-width: 325px; margin: auto;"></div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="fs-12 fw-medium d-block mb-1">Market Cap:</span>
                                                <h4 class="fs-12 fw-semibold mb-0">$520B</h4>
                                            </div>
                                            <div>
                                                <span class="fs-12 fw-medium d-block mb-1">Volume (24h):</span>
                                                <h4 class="fs-12 fw-semibold mb-0">$35B</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="border-0 rounded-3 mb-4 bg-primary-div bg-opacity-10 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/ethereum.png" class="rounded-circle" style="width: 48px; height: 48px;" alt="ethereum">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <span class="mb-1 d-block fw-medium text-secondary">ETHEREUM <span class="text-body fw-normal">(BTC)</span></span>
                                                <div class="d-flex">
                                                    <h3 class="mb-0 fs-20 fw-semibold me-1">$1,750</h3>
                                                    <i class="material-symbols-outlined fs-16 position-relative top-3 text-danger">trending_down</i>
                                                    <span class="text-danger">-1.2%</span>   
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div id="ethereum" style="margin: -11px 0; max-width: 325px; margin: auto;"></div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="fs-12 fw-medium d-block mb-1">Market Cap:</span>
                                                <h4 class="fs-12 fw-semibold mb-0">$210B</h4>
                                            </div>
                                            <div>
                                                <span class="fs-12 fw-medium d-block mb-1">Volume (24h):</span>
                                                <h4 class="fs-12 fw-semibold mb-0">$20B</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="border-0 rounded-3 mb-4 bg-danger bg-opacity-10 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/solana.png" class="rounded-circle" style="width: 48px; height: 48px;" alt="solana">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <span class="mb-1 d-block fw-medium text-secondary">SOLANA <span class="text-body fw-normal">(SOL)</span></span>
                                                <div class="d-flex">
                                                    <h3 class="mb-0 fs-20 fw-semibold me-1">$35</h3>
                                                    <i class="material-symbols-outlined fs-16 position-relative top-3 text-success">trending_up</i>
                                                    <span class="text-success">+5.8%</span>   
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div id="solana" style="margin: -11px 0; max-width: 325px; margin: auto;"></div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="fs-12 fw-medium d-block mb-1">Market Cap:</span>
                                                <h4 class="fs-12 fw-semibold mb-0">$12B</h4>
                                            </div>
                                            <div>
                                                <span class="fs-12 fw-medium d-block mb-1">Volume (24h):</span>
                                                <h4 class="fs-12 fw-semibold mb-0">$3.5B</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="border-0 rounded-3 mb-4 bg-success bg-opacity-10 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/binance.png" class="rounded-circle" style="width: 48px; height: 48px;" alt="binance">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <span class="mb-1 d-block fw-medium text-secondary">BINANCE <span class="text-body fw-normal">(BNB)</span></span>
                                                <div class="d-flex">
                                                    <h3 class="mb-0 fs-20 fw-semibold me-1">$250</h3>
                                                    <i class="material-symbols-outlined fs-16 position-relative top-3 text-success">trending_up</i>
                                                    <span class="text-success">+1.5%</span>   
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div id="binance" style="margin: -11px 0; max-width: 325px; margin: auto;"></div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="fs-12 fw-medium d-block mb-1">Market Cap:</span>
                                                <h4 class="fs-12 fw-semibold mb-0">$12B</h4>
                                            </div>
                                            <div>
                                                <span class="fs-12 fw-medium d-block mb-1">Volume (24h):</span>
                                                <h4 class="fs-12 fw-semibold mb-0">$3.5B</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="border-0 rounded-3 mb-4 bg-warning bg-opacity-10 p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/cardano.png" class="rounded-circle" style="width: 48px; height: 48px;" alt="cardano">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <span class="mb-1 d-block fw-medium text-secondary">CARDANO <span class="text-body fw-normal">(ADA)</span></span>
                                                <div class="d-flex">
                                                    <h3 class="mb-0 fs-20 fw-semibold me-1">$0.38</h3>
                                                    <i class="material-symbols-outlined fs-16 position-relative top-3 text-success">trending_up</i>
                                                    <span class="text-success">+2.3%</span>   
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div id="cardano" style="margin: -11px 0; max-width: 325px; margin: auto;"></div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="fs-12 fw-medium d-block mb-1">Market Cap:</span>
                                                <h4 class="fs-12 fw-semibold mb-0">$25B</h4>
                                            </div>
                                            <div>
                                                <span class="fs-12 fw-medium d-block mb-1">Volume (24h):</span>
                                                <h4 class="fs-12 fw-semibold mb-0">$1.3B</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card border bg-white rounded-3 mb-4 p-0">
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4 border-bottom p-3 px-4">
                                        <div>
                                            <h3 class="mb-0">Market Price Statistics</h3>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <ul class="analytics-tabs d-flex list-unstyled ps-0 mb-0">
                                                    <li>
                                                        <button>1H</button>
                                                    </li>
                                                    <li>
                                                        <button>24H</button>
                                                    </li>
                                                    <li>
                                                        <button class="active">1W</button>
                                                    </li>
                                                    <li>
                                                        <button>1M</button>
                                                    </li>
                                                    <li>
                                                        <button>1Y</button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown action-opt ms-3">
                                                <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="/assets/images/cardano.png" style="width: 24px;" alt="cardano">
                                                    <span class="fs-14 fw-semibold text-secondary ms-1">Bitcoin</span>
                                                    <i data-feather="chevron-down" style="stroke: #3A4252;"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                    <li>
                                                        <a class="dropdown-item text-secondary" href="javascript:;">
                                                            <img src="/assets/images/ethereum.png" style="width: 24px;" alt="ethereum">
                                                            <span class="ms-1">Ethereum (BTC)</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-secondary" href="javascript:;">
                                                            <img src="/assets/images/solana.png" style="width: 24px;" alt="solana">
                                                            <span class="ms-1">Solana (SOL)</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-secondary" href="javascript:;">
                                                            <img src="/assets/images/binance.png" style="width: 24px;" alt="binance">
                                                            <span class="ms-1">Binance (BNB)</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-secondary" href="javascript:;">
                                                            <img src="/assets/images/bitcoin.png" style="width: 24px;" alt="binance">
                                                            <span class="ms-1">Cardano (ADA)</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-4 pt-0">
                                        <div class="row align-items-center">
                                            <div class="col-xxl-8 col-sm-10">
                                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/cardano.png" class="rounded-circle" style="width: 48px; height: 48px;" alt="cardano">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <span class="mb-1 d-block fw-medium text-secondary">BITCOIN <span class="text-body fw-normal">(BTC)</span></span>
                                                            <div class="d-flex">
                                                                <h3 class="mb-0 fs-20 fw-semibold me-1">$27,500</h3>
                                                                <i class="material-symbols-outlined fs-16 position-relative top-3 text-success">trending_up</i>
                                                                <span class="text-success">+2.3%</span>   
                                                            </div>
                                                        </div>
                                                    </div>
                
                                                    <div>
                                                        <span class="fs-14 fw-medium d-block mb-1">Market Cap:</span>
                                                        <h4 class="fs-14 fw-semibold mb-0">$520B</h4>
                                                    </div>
                                                    <div>
                                                        <span class="fs-14 fw-medium d-block mb-1">Volume (24h):</span>
                                                        <h4 class="fs-14 fw-semibold mb-0">$35B</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-sm-2">
                                                <div class="d-flex justify-content-end mt-3 mt-sm-0">
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
                                        </div>
                                    </div>

                                    <div class="p-4 pt-0" style="margin: -9px 0 -20px -18px;">
                                        <div id="market_price_statistics"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card p-0 border-0 rounded-3 mb-4 exchange-for-dark" style="background-color: #F3E8FF;">
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4 p-3 px-4" style="border-bottom: 1px solid #D5D9E2;">
                                        <div>
                                            <h3 class="mb-0">Exchange</h3>
                                        </div>
                                        <button class="p-0 border-0 bg-transparent position-relative top-3">
                                            <span class="material-symbols-outlined">replay</span>
                                        </button>
                                    </div>

                                    <form class="p-4 pt-0">
                                        <div class="mb-30">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span>SELLING</span>
                                                <span>MAX 4,238</span>
                                            </div>

                                            <div class="dropdown action-opt mb-3">
                                                <button class="btn bg-transparent p-0 d-flex justify-content-between align-items-center w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <div class="">
                                                        <img src="/assets/images/ethereum.png" style="width: 42px;" alt="cardano">
                                                        <span class="fs-14 fw-semibold text-secondary ms-1">ETHEREUM (ETH)</span>
                                                    </div>
                                                    <i data-feather="chevron-down" style="stroke: #3A4252;"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow w-100">
                                                    <li>
                                                        <a class="dropdown-item text-secondary" href="javascript:;">
                                                            <img src="/assets/images/ethereum.png" style="width: 24px;" alt="ethereum">
                                                            <span class="ms-1">Ethereum (BTC)</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-secondary" href="javascript:;">
                                                            <img src="/assets/images/solana.png" style="width: 24px;" alt="solana">
                                                            <span class="ms-1">Solana (SOL)</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-secondary" href="javascript:;">
                                                            <img src="/assets/images/binance.png" style="width: 24px;" alt="binance">
                                                            <span class="ms-1">Binance (BNB)</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-secondary" href="javascript:;">
                                                            <img src="/assets/images/bitcoin.png" style="width: 24px;" alt="binance">
                                                            <span class="ms-1">Cardano (ADA)</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="position-relative z-1">
                                                <input type="text" class="form-control h-55 bg-white border-0" placeholder="1 ETH">
                                                <span class="fs-14 position-absolute top-50 end-0 translate-middle-y pe-3">$1750</span>
                                            </div>
                                        </div>

                                        <div class="mb-30">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span>SELLING</span>
                                                <span>MAX 4,238</span>
                                            </div>

                                            <div class="dropdown action-opt mb-3">
                                                <button class="btn bg-transparent p-0 d-flex justify-content-between align-items-center w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <div class="">
                                                        <img src="/assets/images/solana.png" style="width: 42px;" alt="solana">
                                                        <span class="fs-14 fw-semibold text-secondary ms-1">SOLANA (SOL)</span>
                                                    </div>
                                                    <i data-feather="chevron-down" style="stroke: #3A4252;"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow w-100">
                                                    <li>
                                                        <a class="dropdown-item text-secondary" href="javascript:;">
                                                            <img src="/assets/images/ethereum.png" style="width: 24px;" alt="ethereum">
                                                            <span class="ms-1">Ethereum (BTC)</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-secondary" href="javascript:;">
                                                            <img src="/assets/images/solana.png" style="width: 24px;" alt="solana">
                                                            <span class="ms-1">Solana (SOL)</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-secondary" href="javascript:;">
                                                            <img src="/assets/images/binance.png" style="width: 24px;" alt="binance">
                                                            <span class="ms-1">Binance (BNB)</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-secondary" href="javascript:;">
                                                            <img src="/assets/images/bitcoin.png" style="width: 24px;" alt="binance">
                                                            <span class="ms-1">Cardano (ADA)</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="position-relative z-1">
                                                <input type="text" class="form-control h-55 bg-white border-0" placeholder="75 SOL">
                                                <span class="fs-14 position-absolute top-50 end-0 translate-middle-y pe-3">$35</span>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary py-2 px-4 w-100">
                                            <span class="d-inline-block py-1">Exchange</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-3">
                                        <h3 class="mb-0">Transaction History</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 pe-4 w-auto" style="background-position: right 0 center; color: #64748B !important;" aria-label="Default select example">
                                            <option>July 01 - July 31, 2024</option>
                                            <option value="1">August 01 - August 31, 2024</option>
                                            <option selected value="2">September 01 - September 31, 2024</option>
                                        </select>
                                    </div>

                                    <div class="default-table-area style-two transaction-table">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr class="border-bottom">
                                                        <th scope="col" class="bg-transparent">Coin</th>
                                                        <th scope="col" class="text-end bg-transparent">Date</th>
                                                        <th scope="col" class="text-end bg-transparent">Amount</th>
                                                        <th scope="col" class="text-end bg-transparent">Price</th>
                                                        <th scope="col" class="text-end bg-transparent">Type</th>
                                                        <th scope="col" class="text-end bg-transparent pe-0">Total Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-end fw-medium ps-0">
                                                            <div class="d-flex">
                                                                <img src="/assets/images/cardano.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="cardano">
                                                                <span class="ps-2 fw-medium">Bitcoin <span class="text-body">(BTC)</span></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">2024-09-10</td>
                                                        <td class="text-end fw-medium">0.50 BTC</td>
                                                        <td class="text-end fw-medium">$27,000</td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Buy</span>
                                                        </td>
                                                        <td class="text-end fw-medium pe-0">$13,500</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium ps-0">
                                                            <div class="d-flex">
                                                                <img src="/assets/images/ethereum-2.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="ethereum">
                                                                <span class="ps-2 fw-medium">Ethereum <span class="text-body">(ETH)</span></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">2024-09-08</td>
                                                        <td class="text-end fw-medium">5.00 ETH</td>
                                                        <td class="text-end fw-medium">$1,750</td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block py-1 px-2 bg-danger bg-opacity-10 rounded-2 text-danger">Sell</span>
                                                        </td>
                                                        <td class="text-end fw-medium pe-0">$8,750</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium ps-0">
                                                            <div class="d-flex">
                                                                <img src="/assets/images/binance-2.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="binance">
                                                                <span class="ps-2 fw-medium">Binance <span class="text-body">(BNB)</span></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">2024-09-05</td>
                                                        <td class="text-end fw-medium">100 SOL</td>
                                                        <td class="text-end fw-medium">$250</td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Buy</span>
                                                        </td>
                                                        <td class="text-end fw-medium pe-0">$3,500</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium ps-0">
                                                            <div class="d-flex">
                                                                <img src="/assets/images/tether.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="tether">
                                                                <span class="ps-2 fw-medium">Tether <span class="text-body">(USDT)</span></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">2024-08-30</td>
                                                        <td class="text-end fw-medium">10 BNB</td>
                                                        <td class="text-end fw-medium">$1.00</td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Buy</span>
                                                        </td>
                                                        <td class="text-end fw-medium pe-0">$2,500</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium ps-0">
                                                            <div class="d-flex">
                                                                <img src="/assets/images/xrp.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="xrp">
                                                                <span class="ps-2 fw-medium">XRP<span class="text-body">(XRP)</span></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">2024-08-25</td>
                                                        <td class="text-end fw-medium">1,000 ADA</td>
                                                        <td class="text-end fw-medium">$0.50</td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block py-1 px-2 bg-danger bg-opacity-10 rounded-2 text-danger">Sell</span>
                                                        </td>
                                                        <td class="text-end fw-medium pe-0">$250</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium ps-0">
                                                            <div class="d-flex">
                                                                <img src="/assets/images/solana-2.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="solana">
                                                                <span class="ps-2 fw-medium">Solana <span class="text-body">(SOL)</span></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">2024-08-20</td>
                                                        <td class="text-end fw-medium">0.40 BTC	</td>
                                                        <td class="text-end fw-medium">$35</td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block py-1 px-2 bg-danger bg-opacity-10 rounded-2 text-danger">Sell</span>
                                                        </td>
                                                        <td class="text-end fw-medium pe-0">$11,800</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end fw-medium ps-0">
                                                            <div class="d-flex">
                                                                <img src="/assets/images/usdc.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="usdc">
                                                                <span class="ps-2 fw-medium">USDC <span class="text-body">(USDC)</span></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium">2024-08-15</td>
                                                        <td class="text-end fw-medium">3.00 USDC</td>
                                                        <td class="text-end fw-medium">$0.9999</td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Buy</span>
                                                        </td>
                                                        <td class="text-end fw-medium pe-0">$5,400</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                                            <span class="fs-12 fw-medium">Showing 7 of 30 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/crypto" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/crypto">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/crypto">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/crypto">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/crypto">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/crypto" aria-label="Next">
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
                        <div class="col-lg-5 col-md-6">
                            <div class="card bg-primary p-4 border-0 position-relative z-1">
                                <div class="pb-4 mb-3">
                                    <h3 class="mb-0 text-white">Portfolio</h3>
                                </div>
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <img src="/assets/images/balance.png" style="width: 41px;" alt="balance">
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <span class="mb-1 d-block fw-medium text-white">TOTAL BALANCE</span>
                                        <div class="d-flex">
                                            <h3 class="mb-0 fs-20 fw-semibold me-1 text-white">$78,350.00</h3>
                                            <i class="material-symbols-outlined fs-16 position-relative top-3 text-success">trending_up</i>
                                            <span class="text-success">+2.3%</span>   
                                        </div>
                                    </div>
                                </div>
                                <div class="default-table-area style-two portfolio-table">
                                    <div class="table-responsive">
                                        <table class="table align-middle border-0">
                                            <thead>
                                                <tr class="border-bottom">
                                                    <th scope="col" class="text-white bg-transparent">Coin</th>
                                                    <th scope="col" class="text-white text-end bg-transparent">Amount</th>
                                                    <th scope="col" class="text-white text-end bg-transparent pe-0">Total Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="fw-medium ps-0 text-white">
                                                        <span class="fw-medium">Bitcoin <span>(BTC)</span></span>
                                                    </td>
                                                    <td class="text-end fw-medium text-white">0.50 BTC</td>
                                                    <td class="text-end fw-medium text-white pe-0">$41,250</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium ps-0">
                                                        <span class="fw-medium text-white">Ethereum <span>(ETH)</span></span>
                                                    </td>
                                                    <td class="text-end fw-medium text-white">10.00 ETH</td>
                                                    <td class="text-end fw-medium text-white pe-0">$17,500</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium ps-0">
                                                        <span class="fw-medium text-white">Solana <span>(SOL)</span></span>
                                                    </td>
                                                    <td class="text-end fw-medium text-white">500 BTC	</td>
                                                    <td class="text-end fw-medium text-white">$17,500</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium text-white ps-0">
                                                        <span class="fw-medium">Cardano <span>(ADA)</span></span>
                                                    </td>
                                                    <td class="text-end fw-medium text-white">2,000 ADA</td>
                                                    <td class="text-end fw-medium text-white">$500</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium text-white ps-0">
                                                        <span class="fw-medium">Binance <span>(BNB)</span></span>
                                                    </td>
                                                    <td class="text-end fw-medium text-white">5.00 BNB</td>
                                                    <td class="text-end fw-medium text-white">$1,250</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="text-end mt-4">
                                        <a href="/crypto" class="btn btn-outline-primary text-white py-2 px-3" style="border-color: #757DFF;">
                                            View All Portfolio
                                        </a>
                                    </div>
                                </div>
                                <img src="/assets/images/shape-5.png" class="position-absolute bottom-0 start-0 z-n1" alt="shape">
                                <img src="/assets/images/shape-6.png" class="position-absolute top-0 end-0 z-n1 pt-4 pe-4 shape-6" alt="shape">
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-3">
                                <h3 class="mb-0">Crypto Rankings</h3>
                                <select class="form-select month-select form-control p-0 h-auto border-0 pe-4 w-auto" style="background-position: right 0 center; color: #64748B !important;" aria-label="Default select example">
                                    <option>July 01 - July 31, 2024</option>
                                    <option value="1">August 01 - August 31, 2024</option>
                                    <option selected value="2">September 01 - September 31, 2024</option>
                                </select>
                            </div>

                            <div class="default-table-area style-two rankings-table">
                                <div class="table-responsive">
                                    <table class="table align-middle border-0">
                                        <thead>
                                            <tr class="border-bottom">
                                                <th scope="col" class="bg-transparent">Rank</th>
                                                <th scope="col" class="bg-transparent">Cryptocurrency</th>
                                                <th scope="col" class="text-end bg-transparent">Market Cap</th>
                                                <th scope="col" class="text-end bg-transparent">Price</th>
                                                <th scope="col" class="text-end bg-transparent">24h Change %</th>
                                                <th scope="col" class="text-end bg-transparent">7d Change %</th>
                                                <th scope="col" class="text-end bg-transparent">Value 24h</th>
                                                <th scope="col" class="text-end bg-transparent">Circulating Supply</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-medium">1</td>
                                                <td class="text-end fw-medium ps-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/cardano.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="cardano">
                                                        <span class="ps-2 fw-medium">Bitcoin <span class="text-body">(BTC)</span></span>
                                                    </div>
                                                </td>
                                                <td class="text-end fw-medium">$520B</td>
                                                <td class="text-end fw-medium">$27,500</td>
                                                <td class="text-end fw-medium text-success">+2.3%</td>
                                                <td class="text-end fw-medium text-success">+10.2%</td>
                                                <td class="text-end fw-medium">$35B</td>
                                                <td class="text-end fw-medium">19M BTC</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">2</td>
                                                <td class="text-end fw-medium ps-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/ethereum-2.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="ethereum">
                                                        <span class="ps-2 fw-medium">Ethereum <span class="text-body">(ETH)</span></span>
                                                    </div>
                                                </td>
                                                <td class="text-end fw-medium">$210B</td>
                                                <td class="text-end fw-medium">$1,750</td>
                                                <td class="text-end fw-medium text-danger">-1.2%</td>
                                                <td class="text-end fw-medium text-success">+6.3%</td>
                                                <td class="text-end fw-medium">$20B</td>
                                                <td class="text-end fw-medium">120M ETH</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">3</td>
                                                <td class="text-end fw-medium ps-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/binance-2.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="binance">
                                                        <span class="ps-2 fw-medium">Binance <span class="text-body">(BNB)</span></span>
                                                    </div>
                                                </td>
                                                <td class="text-end fw-medium">$40B</td>
                                                <td class="text-end fw-medium">$250</td>
                                                <td class="text-end fw-medium text-success">+1.5%	</td>
                                                <td class="text-end fw-medium text-success">+7.8%</td>
                                                <td class="text-end fw-medium">$1.8B</td>
                                                <td class="text-end fw-medium">160M BNB</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">4</td>
                                                <td class="text-end fw-medium ps-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/tether.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="tether">
                                                        <span class="ps-2 fw-medium">Tether <span class="text-body">(USDT)</span></span>
                                                    </div>
                                                </td>
                                                <td class="text-end fw-medium">$83B</td>
                                                <td class="text-end fw-medium">$1.00</td>
                                                <td class="text-end fw-medium text-success">+0.01%</td>
                                                <td class="text-end fw-medium text-success">+0.02%</td>
                                                <td class="text-end fw-medium">$45B</td>
                                                <td class="text-end fw-medium">83B USDT</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">5</td>
                                                <td class="text-end fw-medium ps-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/xrp.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="xrp">
                                                        <span class="ps-2 fw-medium">XRP <span class="text-body">(XRP)</span></span>
                                                    </div>
                                                </td>
                                                <td class="text-end fw-medium">$25B</td>
                                                <td class="text-end fw-medium">$0.50</td>
                                                <td class="text-end fw-medium text-success">+0.9%</td>
                                                <td class="text-end fw-medium text-danger">-8.6%</td>
                                                <td class="text-end fw-medium">$2.2B</td>
                                                <td class="text-end fw-medium">50B XRP</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">6</td>
                                                <td class="text-end fw-medium ps-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/solana-2.png" class="rounded-circle" style="width: 22px; height: 22px;" alt="solana">
                                                        <span class="ps-2 fw-medium">Solana <span class="text-body">(SOL)</span></span>
                                                    </div>
                                                </td>
                                                <td class="text-end fw-medium">$12B</td>
                                                <td class="text-end fw-medium">$35</td>
                                                <td class="text-end fw-medium text-success">+5.8%</td>
                                                <td class="text-end fw-medium text-success">+15.5%</td>
                                                <td class="text-end fw-medium">$3.5B</td>
                                                <td class="text-end fw-medium">400M SOL</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                                    <span class="fs-12 fw-medium">Showing 6 of 30 Results</span>
    
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination mb-0 justify-content-center">
                                            <li class="page-item">
                                                <a class="page-link icon" href="/crypto" aria-label="Previous">
                                                    <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link active" href="/crypto">1</a></li>
                                            <li class="page-item"><a class="page-link" href="/crypto">2</a></li>
                                            <li class="page-item"><a class="page-link" href="/crypto">3</a></li>
                                            <li class="page-item"><a class="page-link" href="/crypto">4</a></li>
                                            <li class="page-item">
                                                <a class="page-link icon" href="/crypto" aria-label="Next">
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
