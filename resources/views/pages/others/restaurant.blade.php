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
                    <div class="row g-4">
                        <div class="col-xxl-6">
                            <div class="card border-0 rounded-3 bg-rating-color welcome-restaurant position-relative z-1 mb-4">
                                <div class="mb-1">
                                    <span class="d-inline-block bg-dark fs-16 fw-medium" style="padding: 1px 13px; color: #FFE8D4;">Hello William!</span>
                                </div>
                                <h2>Here Your Restaurant Stats Today.</h2>

                                <div class="d-flex align-items-center" style="gap: 40px;">
                                    <div class="d-flex" style="gap: 10px;">
                                        <div class="flex-shrink-0">
                                            <i class="material-symbols-outlined fs-24 text-border-color position-relative top-5">order_approve</i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="fs-14 d-block" style="color: #FFE8D4; margin-bottom: 3px;">Total Order</span>
                                            <h4 class="mb-0 fs-16 fw-bold text-white">12051+</h4>
                                        </div>
                                    </div>
                                    <div class="d-flex" style="gap: 10px;">
                                        <div class="flex-shrink-0">
                                            <i class="material-symbols-outlined fs-24 text-border-color position-relative top-5">group</i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="fs-14 d-block" style="color: #FFE8D4; margin-bottom: 3px;">Total Users</span>
                                            <h4 class="mb-0 fs-16 fw-bold text-white">153K+</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="dish-wrap">
                                    <img src="/assets/images/dish.png" class="dish-img" alt="dish">
                                    <img src="/assets/images/dish-shape1.png" class="dish-shape1" alt="dish-shape">
                                    <img src="/assets/images/dish-shape2.png" class="dish-shape2" alt="dish-shape">
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="card border-0 rounded-3 bg-white revenue-card">
                                        <div class="d-flex align-items-center position-relative z-1">
                                            <div class="flex-shrink-0">
                                                <span class="fs-14">Order</span>
                                                <h2 class="text-secondary-50">1250</h2>
                                                <span class="d-inline-block bg-success-80 border-success-80 border rounded-pill text-success-60 fs-12 fw-medium mb-1" style="padding: 0 9.5px; line-height: 130%;">+5.4%</span>
                                                <p class="fs-12">vs previous 30 days</p>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div style="margin: -30px -9px 0 0; max-width: 130px; top: 10px;" class="ms-auto position-relative">
                                                    <div id="restaurant_order"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card border-0 rounded-3 bg-white revenue-card">
                                        <div class="d-flex align-items-center position-relative z-1">
                                            <div class="flex-shrink-0">
                                                <span class="fs-14">Pending</span>
                                                <h2 class="text-secondary-50">113</h2>
                                                <span class="d-inline-block bg-danger-70 text-danger-90 border-danger-70 border rounded-pill fs-12 fw-medium mb-1" style="padding: 0 9.5px; line-height: 130%;">-3.2%</span>
                                                <p class="fs-12">vs previous 30 days</p>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div style="margin: -28px -10px 0 0; max-width: 130px;" class="ms-auto">
                                                    <div id="restaurant_pending"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6">
                            <div class="row g-4 mb-4">
                                <div class="col-sm-6">
                                    <div class="card border-0 rounded-3 bg-white revenue-card">
                                        <div class="d-flex align-items-center position-relative z-1">
                                            <div class="flex-shrink-0">
                                                <span class="fs-14">Revenue</span>
                                                <h2 class="text-secondary-50">$3M</h2>
                                                <span class="d-inline-block bg-success-80 border-success-80 border rounded-pill text-success-60 fs-12 fw-medium mb-1" style="padding: 0 9.5px; line-height: 130%;">+3.4%</span>
                                                <p class="fs-12">vs previous 30 days</p>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div style="margin: 7px -5px 0 0; max-width: 80px;" class="ms-auto">
                                                    <div id="restaurant_revenue"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card border-0 rounded-3 bg-white revenue-card">
                                        <div class="d-flex align-items-center position-relative z-1">
                                            <div class="flex-shrink-0">
                                                <span class="fs-14">Expense</span>
                                                <h2 class="text-secondary-50">$132K</h2>
                                                <span class="d-inline-block bg-danger-70 text-danger-90 border-danger-70 border rounded-pill fs-12 fw-medium mb-1" style="padding: 0 9.5px; line-height: 130%;">-1.2%</span>
                                                <p class="fs-12">vs previous 30 days</p>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div style="margin: -93px -12px 0 0; max-height: 80px; max-width: 80px;" class="ms-auto">
                                                    <div id="restaurant_expense"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-20">
                                        <h3 class="mb-0 text-secondary-50">Top Selling Item</h3>
                                        <div class="dropdown select-dropdown">
                                            <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Weekly
                                            </button>
                                            
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Day</button>
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

                                    <div class="row g-4">
                                        <div class="col-sm-6 col-md-3">
                                            <a href="/dish-details" class="text-decoration-none">
                                                <div class="position-relative mb-2 pb-1">
                                                    <div class="bg-img" style="background-image: url(/assets/images/top-item-1.jpg); height: 146px; border-radius: 10px;"></div>
                                                    <div class="d-inline-block position-absolute top-0 end-0" style="padding: 3px;">
                                                        <div class="d-flex align-items-center bg-dark rounded-pill" style="gap: 2px;     padding: 1.5px 5px;">
                                                            <i class="ri-star-fill fs-14 text-danger"></i>
                                                            <span class="fs-12 fw-semibold" style="color: #FFF5ED;">5.0</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Thai Bean Soup</h4>
                                                <span class="fs-12 fw-medium text-body">1235 sold</span>
                                            </a>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <a href="/dish-details" class="text-decoration-none">
                                                <div class="position-relative mb-2 pb-1">
                                                    <div class="bg-img" style="background-image: url(/assets/images/top-item-2.jpg); height: 146px; border-radius: 10px;"></div>
                                                    <div class="d-inline-block position-absolute top-0 end-0" style="padding: 3px;">
                                                        <div class="d-flex align-items-center bg-dark rounded-pill" style="gap: 2px;     padding: 1.5px 5px;">
                                                            <i class="ri-star-fill fs-14 text-danger"></i>
                                                            <span class="fs-12 fw-semibold" style="color: #FFF5ED;">4.8</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Meat Lasagna</h4>
                                                <span class="fs-12 fw-medium text-body">1045 sold</span>
                                            </a>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <a href="/dish-details" class="text-decoration-none">
                                                <div class="position-relative mb-2 pb-1">
                                                    <div class="bg-img" style="background-image: url(/assets/images/top-item-3.jpg); height: 146px; border-radius: 10px;"></div>
                                                    <div class="d-inline-block position-absolute top-0 end-0" style="padding: 3px;">
                                                        <div class="d-flex align-items-center bg-dark rounded-pill" style="gap: 2px;     padding: 1.5px 5px;">
                                                            <i class="ri-star-fill fs-14 text-danger"></i>
                                                            <span class="fs-12 fw-semibold" style="color: #FFF5ED;">4.9</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Veg Sandwich</h4>
                                                <span class="fs-12 fw-medium text-body">1015 sold</span>
                                            </a>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <a href="/dish-details" class="text-decoration-none">
                                                <div class="position-relative mb-2 pb-1">
                                                    <div class="bg-img" style="background-image: url(/assets/images/top-item-4.jpg); height: 146px; border-radius: 10px;"></div>
                                                    <div class="d-inline-block position-absolute top-0 end-0" style="padding: 3px;">
                                                        <div class="d-flex align-items-center bg-dark rounded-pill" style="gap: 2px;     padding: 1.5px 5px;">
                                                            <i class="ri-star-fill fs-14 text-danger"></i>
                                                            <span class="fs-12 fw-semibold" style="color: #FFF5ED;">4.8</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Creamy Fish</h4>
                                                <span class="fs-12 fw-medium text-body">996 sold</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <h3 class="mb-0 text-secondary-50">Recent Order List</h3>
                                <div class="dropdown select-dropdown">
                                    <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Today
                                    </button>
                                    
                                    <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">Today</button>
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
                            <div class="default-table-area style-two campaigns-table recent-order-list-table">
                                <div class="table-responsive">
                                    <table class="table align-middle border-0">
                                        <thead>
                                            <tr class="border-bottom">
                                                <th scope="col" class=" bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">CODE</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">ITEM</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">QUANTITY</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">CUSTOMER</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">LOCATION</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">DELIVERY TIME</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">PRICE</span>
                                                </th> 
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">STATUS</span>
                                                </th> 
                                                <th scope="col" class="text-end bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">ACTION</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50">#001</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/order-1.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="order">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Fish Cutlet</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body-color-50">05</td>
                                                <td class="fs-12 fw-normal text-body-color-50">Johnna Loren</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">Washington, D.C.</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">10:05 AM</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">$ 35.75</td> 
                                                <td>
                                                    <span class="d-inline-block bg-success-80 border-success-80 border rounded-pill text-success-60 fs-12 fw-medium" style="padding: 2px 15px; line-height: 130%;">Delivered</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50">#002</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/order-2.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="order">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Pea Creamy Soup</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body-color-50">01</td>
                                                <td class="fs-12 fw-normal text-body-color-50">Skyler White</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">Los Angeles, CA</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">11:15 AM</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">$ 24.30</td> 
                                                <td>
                                                    <span class="d-inline-block bg-primary-70 border-primary-70 border rounded-pill text-primary fs-12 fw-medium" style="padding: 2px 15px; line-height: 130%;">Processing</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50">#003</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/order-3.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="order">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Macaroon 02</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body-color-50">02</td>
                                                <td class="fs-12 fw-normal text-body-color-50">Jonathon Watson</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">New York</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">11:30 AM</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">$ 21.15</td> 
                                                <td>
                                                    <span class="d-inline-block bg-card-text-c border-card-text-c border rounded-pill text-danger fs-12 fw-medium" style="padding: 2px 15px; line-height: 130%;">Cancelled</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50">#004</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/order-4.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="order">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Healthy Salad Bowl</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body-color-50">01</td>
                                                <td class="fs-12 fw-normal text-body-color-50">Walter White</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">San Jose, CA</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">11:52 AM</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">$ 12.20</td> 
                                                <td>
                                                    <span class="d-inline-block bg-success-80 border-success-80 border rounded-pill text-success-60 fs-12 fw-medium" style="padding: 2px 15px; line-height: 130%;">Delivered</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50">#005</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/order-5.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="order">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Macaroon</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body-color-50">01</td>
                                                <td class="fs-12 fw-normal text-body-color-50">David Carlen</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">Redmond, WA</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">12:05 PM</td>
                                                <td class="fs-12 fw-semibold text-body-color-50">$ 21.50</td> 
                                                <td>
                                                    <span class="d-inline-block bg-primary-70 border-primary-70 border rounded-pill text-primary fs-12 fw-medium" style="padding: 2px 15px; line-height: 130%;">Processing</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
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

                    <div class="row g-4 mb-4">
                        <div class="col-xxl-3 col-md-6">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-20">
                                        <h3 class="mb-0 text-secondary-50">Order Summary</h3>
                                        <div class="dropdown select-dropdown">
                                            <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Today
                                            </button>
                                            
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Today</button>
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
                                    
                                    <div style="margin: -6px 0 0 0;">
                                        <div id="restaurant_order_Summary"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-md-6">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-20">
                                        <h3 class="mb-0 text-secondary-50">Revenue Vs Expense</h3>
                                        <div class="dropdown select-dropdown">
                                            <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Weekly
                                            </button>
                                            
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Today</button>
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
                                    
                                    <div style="margin: -24px -10px -27px -18px;">
                                        <div id="restaurant_revenue_vs_expense"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-12">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4" style="padding-bottom: 10px;">
                                        <h3 class="mb-0 text-text-secondary-50">Low Stock Alert</h3>
                                        
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
                                    
                                    <ul class="p-0 m-0 list-unstyled">
                                        <li class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-border-color-50">
                                            <span class="fs-14 fw-semibold text-secondary-50">Thai Bean Soup</span>
                                            <span class="fs-14 fw-bold text-danger">1</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-border-color-50">
                                            <span class="fs-14 fw-semibold text-secondary-50">Banana Shake</span>
                                            <span class="fs-14 fw-bold text-danger">3</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-border-color-50">
                                            <span class="fs-14 fw-semibold text-secondary-50">Chicken Tandoori</span>
                                            <span class="fs-14 fw-bold text-danger">5</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-border-color-50">
                                            <span class="fs-14 fw-semibold text-secondary-50">Thai Chicken Masala</span>
                                            <span class="fs-14 fw-bold text-danger">5</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-border-color-50">
                                            <span class="fs-14 fw-semibold text-secondary-50">Chicken Club Sandwich</span>
                                            <span class="fs-14 fw-bold text-danger">6</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center pb-3 border-bottom border-border-color-50">
                                            <span class="fs-14 fw-semibold text-secondary-50">Shrimp Fried Rice</span>
                                            <span class="fs-14 fw-bold text-danger">2</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-xxl-4 col-md-6">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                        <h3 class="mb-0 text-text-secondary-50">Staff Performance Score</h3>
                                        
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
                                    
                                    <ul class="p-0 m-0 list-unstyled last-child-none">
                                        <li class="d-flex justify-content-between align-items-center border-bottom border-border-color-50" style="padding-bottom: 13.5px; margin-bottom: 13.5px;">
                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                <img src="/assets/images/user-84.png" class="rounded-circle" style="width: 24px;" alt="user">
                                                <span class="fs-14 fw-medium">Jonathon Ronan</span>
                                            </div>
                                            <span class="fs-14 fw-medium">98</span> 
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center border-bottom border-border-color-50" style="padding-bottom: 13.5px; margin-bottom: 13.5px;">
                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                <img src="/assets/images/user-81.png" class="rounded-circle" style="width: 24px;" alt="user">
                                                <span class="fs-14 fw-medium">Angela Carter</span>
                                            </div>
                                            <span class="fs-14 fw-medium">97</span> 
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center border-bottom border-border-color-50" style="padding-bottom: 13.5px; margin-bottom: 13.5px;">
                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                <img src="/assets/images/user-82.png" class="rounded-circle" style="width: 24px;" alt="user">
                                                <span class="fs-14 fw-medium">Walter White</span>
                                            </div>
                                            <span class="fs-14 fw-medium">96</span> 
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center border-bottom border-border-color-50" style="padding-bottom: 13.5px; margin-bottom: 13.5px;">
                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                <img src="/assets/images/user-83.png" class="rounded-circle" style="width: 24px;" alt="user">
                                                <span class="fs-14 fw-medium">Gary Simon</span>
                                            </div>
                                            <span class="fs-14 fw-medium">88</span> 
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center border-bottom border-border-color-50" style="padding-bottom: 13.5px; margin-bottom: 13.5px;">
                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                <img src="/assets/images/user-109.png" class="rounded-circle" style="width: 24px;" alt="user">
                                                <span class="fs-14 fw-medium">Zinia Anderson</span>
                                            </div>
                                            <span class="fs-14 fw-medium">85</span> 
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center border-bottom border-border-color-50" style="padding-bottom: 13.5px; margin-bottom: 13.5px;">
                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                <img src="/assets/images/user-81.png" class="rounded-circle" style="width: 24px;" alt="user">
                                                <span class="fs-14 fw-medium">Loren Walter</span>
                                            </div>
                                            <span class="fs-14 fw-medium">82</span> 
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center border-bottom border-border-color-50" style="padding-bottom: 13.5px; margin-bottom: 13.5px;">
                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                <img src="/assets/images/user-135.png" class="rounded-circle" style="width: 24px;" alt="user">
                                                <span class="fs-14 fw-medium">Jessy Pinkman</span>
                                            </div>
                                            <span class="fs-14 fw-medium">80</span> 
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center border-bottom border-border-color-50" style="padding-bottom: 13.5px; margin-bottom: 13.5px;">
                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                <img src="/assets/images/user-139.png" class="rounded-circle" style="width: 24px;" alt="user">
                                                <span class="fs-14 fw-medium">Handy Curter</span>
                                            </div>
                                            <span class="fs-14 fw-medium">77</span> 
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center border-bottom border-border-color-50" style="padding-bottom: 13.5px; margin-bottom: 13.5px;">
                                            <div class="d-flex align-items-center" style="gap: 8px;">
                                                <img src="/assets/images/user-138.png" class="rounded-circle" style="width: 24px;" alt="user">
                                                <span class="fs-14 fw-medium">Skyler Lorensa</span>
                                            </div>
                                            <span class="fs-14 fw-medium">75</span> 
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-md-6">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                        <h3 class="mb-0 text-text-secondary-50">Revenue By Branches</h3>
                                        
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
                                    
                                    <div class="ext-center" style="margin: 60px 0;">
                                        <div id="revenue_by_branches_map"></div>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled">
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/united-states-3.png" style="width: 24px;" alt="united-states">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-medium lh-1">United States</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 6px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 85%; height: 6px; background-color: #757DFF;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">85%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/japan.png" style="width: 24px;" alt="japan">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-medium lh-1">Japan</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 6px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 65%; height: 6px; background-color: #0F79F3;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">65%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/australia-2.png" style="width: 24px;" alt="australia">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-medium lh-1">Australia</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 6px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 45%; height: 6px; background-color: #9135E8;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">45%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/germany-2.png" style="width: 24px;" alt="germany">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-medium lh-1">Germany</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 6px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 75%; height: 6px; background-color: #25B003;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">75%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-md-12">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-20">
                                        <h3 class="mb-0 text-text-secondary-50">Tickets</h3>
                                        
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
                                    
                                    <div class="default-table-area style-two campaigns-table tickets-table">
                                        <div class="table-responsive">
                                            <table class="table border-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="fs-12 fw-medium text-body-color-50 border-border-color-50" style="padding-top: 15.5px; padding-bottom: 15.5px;">#3242</td>
                                                        <td class="border-border-color-50 ps-4" style="padding-top: 15.5px; padding-bottom: 15.5px;">
                                                            <h4 class="mb-0 fs-14 fw-semibold text-body-color-50 mb-1">Order delayed for 5 mins</h4>
                                                            <span class="fs-12 fw-medium text-body">Updated on: 10 Nov, 2025</span>
                                                        <td class="border-border-color-50" style="padding-top: 15.5px; padding-bottom: 15.5px;">
                                                            <span class="d-inline-block bg-success-80 border-success-80 border rounded-pill text-success-60 fs-12 fw-medium" style="padding: 2px 15px; line-height: 130%;">Solved</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-medium text-body-color-50 border-border-color-50" style="padding-top: 15.5px; padding-bottom: 15.5px;">#3243</td>
                                                        <td class="border-border-color-50 ps-4" style="padding-top: 15.5px; padding-bottom: 15.5px;">
                                                            <h4 class="mb-0 fs-14 fw-semibold text-body-color-50 mb-1">Provide rotten Burger</h4>
                                                            <span class="fs-12 fw-medium text-body">Updated on: 10 Nov, 2025</span>
                                                        <td class="border-border-color-50" style="padding-top: 15.5px; padding-bottom: 15.5px;">
                                                            <span class="d-inline-block bg-primary-70 border-primary-70 border rounded-pill text-primary fs-12 fw-medium" style="padding: 2px 15px; line-height: 130%;">Pending</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-medium text-body-color-50 border-border-color-50" style="padding-top: 15.5px; padding-bottom: 15.5px;">#3244</td>
                                                        <td class="border-border-color-50 ps-4" style="padding-top: 15.5px; padding-bottom: 15.5px;">
                                                            <h4 class="mb-0 fs-14 fw-semibold text-body-color-50 mb-1">Too much salt in pizza</h4>
                                                            <span class="fs-12 fw-medium text-body">Updated on: 10 Nov, 2025</span>
                                                        <td class="border-border-color-50" style="padding-top: 15.5px; padding-bottom: 15.5px;">
                                                            <span class="d-inline-block bg-success-80 border-success-80 border rounded-pill text-success-60 fs-12 fw-medium" style="padding: 2px 15px; line-height: 130%;">Solved</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-medium text-body-color-50 border-border-color-50" style="padding-top: 15.5px; padding-bottom: 15.5px;">#3245</td>
                                                        <td class="border-border-color-50 ps-4" style="padding-top: 15.5px; padding-bottom: 15.5px;">
                                                            <h4 class="mb-0 fs-14 fw-semibold text-body-color-50 mb-1">Order delayed for 5 mins</h4>
                                                            <span class="fs-12 fw-medium text-body">Updated on: 10 Nov, 2025</span>
                                                        <td class="border-border-color-50" style="padding-top: 15.5px; padding-bottom: 15.5px;">
                                                            <span class="d-inline-block bg-success-80 border-success-80 border rounded-pill text-success-60 fs-12 fw-medium" style="padding: 2px 15px; line-height: 130%;">Solved</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-medium text-body-color-50 border-border-color-50" style="padding-top: 15.5px; padding-bottom: 15.5px;">#3246</td>
                                                        <td class="border-border-color-50 ps-4" style="padding-top: 15.5px; padding-bottom: 15.5px;">
                                                            <h4 class="mb-0 fs-14 fw-semibold text-body-color-50 mb-1">Delivery man misbehaved</h4>
                                                            <span class="fs-12 fw-medium text-body">Updated on: 10 Nov, 2025</span>
                                                        <td class="border-border-color-50" style="padding-top: 15.5px; padding-bottom: 15.5px;">
                                                            <span class="d-inline-block bg-primary-70 border-primary-70 border rounded-pill text-primary fs-12 fw-medium" style="padding: 2px 15px; line-height: 130%;">Pending</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-medium text-body-color-50 border-border-color-50" style="padding-top: 15.5px; padding-bottom: 15.5px;">#3247</td>
                                                        <td class="border-border-color-50 ps-4" style="padding-top: 15.5px; padding-bottom: 15.5px;">
                                                            <h4 class="mb-0 fs-14 fw-semibold text-body-color-50 mb-1">App doesn’t work</h4>
                                                            <span class="fs-12 fw-medium text-body">Updated on: 10 Nov, 2025</span>
                                                        <td class="border-border-color-50" style="padding-top: 15.5px; padding-bottom: 15.5px;">
                                                            <span class="d-inline-block bg-success-80 border-success-80 border rounded-pill text-success-60 fs-12 fw-medium" style="padding: 2px 15px; line-height: 130%;">Solved</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <h3 class="mb-0 text-secondary-50">Customer Ratings</h3>
                                <div class="dropdown select-dropdown">
                                    <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Today
                                    </button>
                                    
                                    <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">Today</button>
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
                            <div class="default-table-area style-two campaigns-table customer-ratings-table">
                                <div class="table-responsive">
                                    <table class="table border-0">
                                        <thead>
                                            <tr class="border-bottom">
                                                <th scope="col" class=" bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">USER ID</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">CUSTOMER NAME</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">RATINGS</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">REVIEWS</span>
                                                </th>
                                                <th scope="col" class="bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">DATE</span>
                                                </th>
                                                <th scope="col" class="text-end bg-transparent text-body fw-medium">
                                                    <span class="fs-10 text-body-color-60 fw-bold letter-spacing-1">ACTION</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50 border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">#001</td>
                                                <td class="border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-80.png" class="rounded-circle" style="width: 30px; height: 30px;" alt="order">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Joanna Watson</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="text-danger ri-star-fill"></i>
                                                        <span class="fs-12 fw-semibold text-body position-relative top-1">5.0</span>
                                                    </div>
                                                </td>
                                                <td class="border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">
                                                    <h4 class="fs-14 fw-semibold text-body mb-1">Amazing Ambiance and Delicious Food!</h4>
                                                    <p class="fs-12" style="max-width: 617px;">Trezo was a fantastic dining experience. The ambiance is warm and inviting, perfect for a date night or celebration. I ordered the truffle pasta, which was rich and perfectly seasoned. The service was impeccable, and the staff made us feel like family. Highly recommend! </p>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">13 Nov, 24</td> 
                                                <td class="text-end border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">
                                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50 border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">#002</td>
                                                <td class="border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-81.png" class="rounded-circle" style="width: 30px; height: 30px;" alt="order">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Jenelia Anderson</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="text-danger ri-star-fill"></i>
                                                        <span class="fs-12 fw-semibold text-body position-relative top-1">4.9</span>
                                                    </div>
                                                </td>
                                                <td class="border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">
                                                    <h4 class="fs-14 fw-semibold text-body mb-1">Best Brunch Spot in Town</h4>
                                                    <p class="fs-12" style="max-width: 617px;">Visited Trezo for brunch with friends, and it exceeded our expectations. The avocado toast was fresh, and their mimosas were spot-on. Our server was attentive without being intrusive. Definitely coming back!</p>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">14 Nov, 24</td> 
                                                <td class="text-end border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">
                                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50 border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">#001</td>
                                                <td class="border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-83.png" class="rounded-circle" style="width: 30px; height: 30px;" alt="order">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Jonathon Ronan</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="text-danger ri-star-fill"></i>
                                                        <span class="fs-12 fw-semibold text-body position-relative top-1">4.9</span>
                                                    </div>
                                                </td>
                                                <td class="border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">
                                                    <h4 class="fs-14 fw-semibold text-body mb-1">Good Food, Slow Service</h4>
                                                    <p class="fs-12" style="max-width: 617px;">The food at Trezo was delicious, but the service was a bit slow. We had to wait a while for our appetizers, and our main course was delayed. It’s a nice spot, but they could work on speeding up their service.</p>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">12 Nov, 24</td> 
                                                <td class="text-end border-border-color-50" style="padding-top: 14px; padding-bottom: 14px;">
                                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
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
