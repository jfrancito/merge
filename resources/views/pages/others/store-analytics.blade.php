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
                        <div class="col-lg-9"> 
                            <div class="card border-0 rounded-3 p-4" style="background: linear-gradient(104deg, #361E7D 2.4%, #403CFF 112.33%);">
                                <div class="d-flex justify-content-between flex-wrap gap-3">
                                    <div class="mt-sm-4  ms-sm-4">
                                        <span class="fw-medium d-block mb-2" style="color: #C2CDFF;">Hello William ✋</span>
                                        <h3 class="fs-28 text-white fw-900 mb-0"><span class="fw-normal">Welcome To</span> Your Store!</h3>
                                    </div>
                                    <div class="py-sm-1">
                                        <img src="/assets/images/store.png" alt="store">
                                    </div>
                                </div>
                            </div>
                            <div class="px-sm-4 px-xxl-5" style="margin-top: -48px;">
                                <div class="row justify-content-center">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 me-1">
                                                    <span class="d-block mb-2">New Customer</span>
                                                    <h2 class="mb-2 fs-28">14.5K</h2>
                                                    <span class="d-inline-block bg-success bg-opacity-10 border-success border px-2 rounded-pill text-success fs-12 fw-medium">+7%</span>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="bg-primary bg-opacity-25 text-primary text-center rounded-circle" style="width: 48px; height: 48px; line-height: 48px;">
                                                        <i class="ri-user-3-fill fs-24"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 me-1">
                                                    <span class="d-block mb-2">Sales</span>
                                                    <h2 class="mb-2 fs-28">$64.5K</h2>
                                                    <span class="d-inline-block bg-danger bg-opacity-10 border-danger border px-2 rounded-pill text-danger fs-12 fw-medium">-1.4%</span>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="bg-success bg-opacity-25 text-success text-center rounded-circle" style="width: 48px; height: 48px; line-height: 48px;">
                                                        <i class="ri-money-dollar-circle-line fs-24"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 me-1">
                                                    <span class="d-block mb-2">Products</span>
                                                    <h2 class="mb-2 fs-28">11.9K</h2>
                                                    <span class="d-inline-block bg-success bg-opacity-10 border-success border px-2 rounded-pill text-success fs-12 fw-medium">+7%</span>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="bg-primary-div bg-opacity-25 text-primary-div text-center rounded-circle" style="width: 48px; height: 48px; line-height: 48px;">
                                                        <i class="ri-layout-grid-fill fs-24"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                <h3 class="mb-4">Customer Visit</h3>
                                <div class="position-relative z-1">
                                    <div class="row">
                                        <div class="col pe-0">
                                            <div class="text-center wh-25 lh-25 rounded-circle mb-2" style="background-color: #F6F7F9;">
                                                <i class="ri-user-3-fill"></i>
                                            </div>
                                            <span class="d-inline-block mb-2" style="max-width: 65px;">Walk-In Customer</span>
                                            <h3 class="fs-28 mb-2">1.5K</h3>
                                            <span class="d-inline-block bg-success bg-opacity-10 border-success border px-2 rounded-pill text-success fs-12 fw-medium">+7%</span>
                                        </div>
                                        <div class="col ps-0 text-end border-start">
                                            <div class="text-center wh-25 lh-25 rounded-circle mb-2 ms-auto" style="background-color: #F6F7F9;">
                                                <i class="ri-user-received-2-fill"></i>
                                            </div>
                                            <span class="d-inline-block mb-2" style="max-width: 65px;">Repeat Customer</span>
                                            <h3 class="fs-28 mb-2">2.1K</h3>
                                            <span class="d-inline-block bg-danger bg-opacity-10 border-danger border px-2 rounded-pill text-danger fs-12 fw-medium">-1.4%</span> 
                                        </div>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 text-primary text-center rounded-circle position-absolute top-50 start-50 translate-middle" style="width: 33px; height: 33px; line-height: 45px;">
                                        <span class="material-symbols-outlined">bolt</span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="progress bg-success rounded-pill" role="progressbar" aria-label="Basic example" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100" style="height: 8px;">
                                        <div class="progress-bar bg-primary rounded-pill" style="width: 32%; height: 8px;"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <span class="fs-12">32%</span>
                                        <span class="fs-12">64%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                <h3 class="mb-4">Top Selling Product</h3>

                                <div class="last-child-none">
                                    <div class="d-flex gap-1 justify-content-between align-items-center child mb-3 pb-3 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/product-18.png" class="rounded-2" alt="product">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h4 class="fs-14 fw-semibold mb-0">Tablet PC</h4>
                                                <span class="fs-12"><span class="fw-bold">2032</span> sold</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <span class="fs-12 position-relative top-1">5.0</span>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1 justify-content-between align-items-center child mb-3 pb-3 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/product-19.png" class="rounded-2" alt="product">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h4 class="fs-14 fw-semibold mb-0">Clay Camera</h4>
                                                <span class="fs-12"><span class="fw-bold">1020</span> sold</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-half-line text-warning"></i> 
                                            <span class="fs-12 position-relative top-1">4.9</span>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1 justify-content-between align-items-center child mb-3 pb-3 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/product-20.png" class="rounded-2" alt="product">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h4 class="fs-14 fw-semibold mb-0">Laptop</h4>
                                                <span class="fs-12"><span class="fw-bold">99</span> sold</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-half-line text-warning"></i>
                                            <span class="fs-12 position-relative top-1">4.8</span>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1 justify-content-between align-items-center child mb-3 pb-3 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/product-21.png" class="rounded-2" alt="product">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h4 class="fs-14 fw-semibold mb-0">Zenbook X</h4>
                                                <span class="fs-12"><span class="fw-bold">89</span> sold</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-half-line text-warning"></i>
                                            <span class="fs-12 position-relative top-1">4.5</span>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1 justify-content-between align-items-center child mb-3 pb-3 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/product-22.png" class="rounded-2" alt="product">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h4 class="fs-14 fw-semibold mb-0">QCY Airpod</h4>
                                                <span class="fs-12"><span class="fw-bold">72</span> sold</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-half-line text-warning"></i>
                                            <span class="fs-12 position-relative top-1">4.3</span>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1 justify-content-between align-items-center child mb-3 pb-3 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/product-18.png" class="rounded-2" alt="product">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h4 class="fs-14 fw-semibold mb-0">Laptop Mockup</h4>
                                                <span class="fs-12"><span class="fw-bold">72</span> sold</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-line text-warning"></i>
                                            <span class="fs-12 position-relative top-1">4.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 p-4 mb-4 rounded-10">
                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-1">
                                    <span class="d-block mb-1">Gross Revenue</span>
                                    <div class="dropdown select-dropdown">
                                        <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Monthly
                                        </button>
                                      
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Monthly</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Weekly</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Yearly</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div  class="d-flex align-items-center mb-2">
                                    <h3 class="fs-32 fw-bold text-secondary mb-0">$1,528</h3>
                                    <span class="fw-medium fs-12 text-success bg-success bg-opacity-10 border border-success px-2 rounded-pill ms-2">
                                        +5.4%
                                        <i class="ri-arrow-up-line"></i>
                                    </span>
                                </div> 
                                <span class="fs-12 d-block mb-4">vs previous 30 days</span>

                                <div style="margin: -24px -11px -21px -16px;">
                                    <div id="gross_revenue2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                        <h3 class="mb-0">Recent Sales</h3>
                                        <div class="dropdown select-dropdown">
                                            <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                This Month
                                            </button>
                                          
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
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
                                    <div class="default-table-area style-two campaigns-table">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr class="border-bottom">
                                                        <th scope="col" class=" bg-transparent text-body fw-medium">
                                                            <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">REF</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">CUSTOMER</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">GRAND TOTAL</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">PAID</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">PAYMENT METHOD</span>
                                                        </th>
                                                        <th scope="col" class="text-end bg-transparent text-body fw-medium">
                                                            <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">STATUS</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="fs-12 fw-semibold text-body-color-50">#001</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-81.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Johhna Loren</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body-color-50">$6240</td>
                                                        <td class="fs-12 fw-semibold text-body-color-50">Paid</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/paypal.png" alt="paypal">
                                                                <span class="ms-2 text-body-color-50 fs-12 fw-semibold">Paypal</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block px-2 bg-success bg-opacity-10 text-success border border-success rounded-pill fs-12 fw-medium">Completed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-semibold text-body-color-50">#002</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-82.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Skyler White</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body-color-50">$5135</td>
                                                        <td class="fs-12 fw-semibold text-body-color-50">Due</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/wise.png" alt="paypal">
                                                                <span class="ms-2 text-body-color-50 fs-12 fw-semibold">Wise</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block px-2 bg-primary-div bg-opacity-10 text-primary-div border border-primary-div rounded-pill fs-12 fw-medium">Pending</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-semibold text-body-color-50">#003</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-83.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Jonathon Watson</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body-color-50">$4321</td>
                                                        <td class="fs-12 fw-semibold text-body-color-50">Paid</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/bank.png" alt="bank">
                                                                <span class="ms-2 text-body-color-50 fs-12 fw-semibold">Bank</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block px-2 bg-danger bg-opacity-10 text-danger border border-danger rounded-pill fs-12 fw-medium">Failed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-semibold text-body-color-50">#004</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-84.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Walter White</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body-color-50">$3124</td>
                                                        <td class="fs-12 fw-semibold text-body-color-50">Paid</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/skrill.png" alt="skrill">
                                                                <span class="ms-2 text-body-color-50 fs-12 fw-semibold">Skrill</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block px-2 bg-success bg-opacity-10 text-success border border-success rounded-pill fs-12 fw-medium">Completed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-semibold text-body-color-50">#005</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-85.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">David Carlen</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body-color-50">$2137</td>
                                                        <td class="fs-12 fw-semibold text-body-color-50">Paid</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/paypal.png" alt="paypal">
                                                                <span class="ms-2 text-body-color-50 fs-12 fw-semibold">Paypal</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block px-2 bg-primary-div bg-opacity-10 text-primary-div border border-primary-div rounded-pill fs-12 fw-medium">Pending</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                                            <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
            
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
                        <div class="col-lg-3">
                            <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                <h3 class="mb-4">Sales By Gender</h3>
                                <div style="margin: 0 0 0 0;">
                                    <div id="sales_by_gender"></div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                <div class="mb-3">
                                    <span class="d-block mb-1">Sales This Month</span>
                                    <h3 class="fs-28 fw-bold text-secondary mb-1">$64.5K</h3>
                                    <span class="fw-medium fs-12 text-danger bg-danger bg-opacity-10 border border-danger px-2 rounded-pill d-inline-block">
                                        -1.4%
                                    </span>
                                </div>
                                <div style="margin: -29px -11px -29px -11px;">
                                    <div id="sales_this_month"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                <h3 class="mb-4">Sales By Category</h3>
                                <div style="margin: -43px 0 -25px 0;">
                                    <div id="sales_by_category"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-1">Stock Alert</h3>
                                    <div class="default-table-area style-two campaigns-table">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr class="border-bottom">
                                                        <th scope="col" class=" bg-transparent text-body fw-medium">
                                                            <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">CODE</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">PRODUCT</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium text-center">
                                                            <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">STORE</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium text-center">
                                                            <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">QUANTITY</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium text-center">
                                                            <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">ALERT QUANTITY</span>
                                                        </th>
                                                        <th scope="col" class="text-end bg-transparent text-body fw-medium">
                                                            <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">ACTION</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="fs-12 fw-semibold text-body-color-50">#3421</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/product-24.png" class="rounded-1" style="width: 30px; height: 30px;" alt="product">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">ZenX Laptop</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body-color-50 text-center">Store 01</td>
                                                        <td class="fs-12 fw-semibold text-body-color-50 text-center">5</td>
                                                        <td class="text-center">
                                                            <span class="fw-medium fs-12 text-danger bg-danger bg-opacity-10 border border-danger px-2 rounded-pill d-inline-block">10</span>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="dropdown action-opt">
                                                                <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i data-feather="more-vertical"></i>
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
                                                        <td class="fs-12 fw-semibold text-body-color-50">#3429</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/product-25.png" class="rounded-1" style="width: 30px; height: 30px;" alt="product">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Macbook Pro</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body-color-50 text-center">Store 02</td>
                                                        <td class="fs-12 fw-semibold text-body-color-50 text-center">3</td>
                                                        <td class="text-center">
                                                            <span class="fw-medium fs-12 text-danger bg-danger bg-opacity-10 border border-danger px-2 rounded-pill d-inline-block">15</span>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="dropdown action-opt">
                                                                <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i data-feather="more-vertical"></i>
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
                                                        <td class="fs-12 fw-semibold text-body-color-50">#3421</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/product-26.png" class="rounded-1" style="width: 30px; height: 30px;" alt="product">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Smart Pencil</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body-color-50 text-center">Store 01</td>
                                                        <td class="fs-12 fw-semibold text-body-color-50 text-center">2</td>
                                                        <td class="text-center">
                                                            <span class="fw-medium fs-12 text-danger bg-danger bg-opacity-10 border border-danger px-2 rounded-pill d-inline-block">07</span>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="dropdown action-opt">
                                                                <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i data-feather="more-vertical"></i>
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
                                                        <td class="fs-12 fw-semibold text-body-color-50">#3424</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/product-27.png" class="rounded-1" style="width: 30px; height: 30px;" alt="product">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Banner Mockup</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body-color-50 text-center">Store 02</td>
                                                        <td class="fs-12 fw-semibold text-body-color-50 text-center">4</td>
                                                        <td class="text-center">
                                                            <span class="fw-medium fs-12 text-danger bg-danger bg-opacity-10 border border-danger px-2 rounded-pill d-inline-block">12</span>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="dropdown action-opt">
                                                                <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i data-feather="more-vertical"></i>
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
                                                        <td class="fs-12 fw-semibold text-body-color-50">#3422</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/product-28.png" class="rounded-1" style="width: 30px; height: 30px;" alt="product">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Clay Camera</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body-color-50 text-center">Store 01</td>
                                                        <td class="fs-12 fw-semibold text-body-color-50 text-center">3</td>
                                                        <td class="text-center">
                                                            <span class="fw-medium fs-12 text-danger bg-danger bg-opacity-10 border border-danger px-2 rounded-pill d-inline-block">10</span>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="dropdown action-opt">
                                                                <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i data-feather="more-vertical"></i>
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

                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                                            <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
            
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
