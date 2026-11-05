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
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <h3 class="mb-0">Seller Details</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">eCommerce</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Seller Details</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4 pb-0">
                            <h3 class="mb-lg-4 mb-3">Seller Overview</h3>

                            <div class="row">
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-primary bg-opacity-10 border-primary border-opacity-10 rounded-3 mb-4 stats-box style-three">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-35">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined fs-40 text-primary">settings_account_box </i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span>Total Orders</span>
                                                    <h3 class="fs-20 mt-1 mb-0">7051</h3>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                                <span class="fs-13">Order this month</span>
                                                <span class="count up fw-medium ms-0">+0.75%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-danger bg-opacity-10 border-danger border-opacity-10 rounded-3 mb-4 stats-box style-three">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-35">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined fs-40 text-danger"> settings_timelapse</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span>Total Earnings</span>
                                                    <h3 class="fs-20 mt-1 mb-0">$23.91k</h3>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                                <span class="fs-13">Earnings this month</span>
                                                <span class="count down fw-medium ms-0">-1.25%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-success bg-opacity-10 border-success border-opacity-10 rounded-3 mb-4 stats-box style-three">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-35">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined fs-40 text-success">assignment_return</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span>Total Refunds</span>
                                                    <h3 class="fs-20 mt-1 mb-0">178</h3>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                                <span class="fs-13">Refunds this month</span>
                                                <span class="count up fw-medium ms-0">+4.75%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-primary-div bg-opacity-10 border-primary-div border-opacity-10 rounded-3 mb-4 stats-box style-three">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-35">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined fs-40 text-primary-div">discover_tune</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span>Conversion Rate</span>
                                                    <h3 class="fs-20 mt-1 mb-0">12.21%</h3>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                                <span class="fs-13">Conversion rate this month</span>
                                                <span class="count up fw-medium ms-0">+1.11%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-3 col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/seller-1.png" class="wh-52" alt="seller">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="#" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Ava Turner</a>
                                                <span class="d-block">turner@trezo.com</span>
                                            </div>
                                        </div>

                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-symbols-outlined fs-24 text-body hover">more_horiz</i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="eye"></i>
                                                        View All 
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="edit"></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="trash-2"></i>
                                                        Delete One
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="lock"></i>
                                                        Block
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Last Sale Date:</span>
                                        <span class="text-secondary ms-1">25 Nov 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Item Stock:</span>
                                        <span class="text-secondary ms-1">50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Wallet Balance:</span>
                                        <span class="text-secondary ms-1">$9,999.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Revenue:</span>
                                        <span class="text-secondary ms-1">$5,999.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">TechMaster Store</span>
                                    </div>

                                    <h4 class="fw-medium fs-15 mb-2">Contact Support</h4>
                                    <form>
                                        <textarea rows="5" class="form-control" placeholder="Type here"></textarea>
                                        <button type="submit" class="btn btn-primary fw-medium fs-16 py-2 px-4 mt-3">
                                            <div class="d-flex align-items-center">
                                                <i class="material-symbols-outlined me-2 text-white">send</i>
                                                <span class="py-1 d-inline-block text-white">Submit Now</span>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-9 col-lg-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Revenue: $23.91k</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90 d-sm-none" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected="">This Week</option>
                                            <option value="1">This Month</option>
                                            <option value="2">This Year</option>
                                        </select>
                                    </div>

                                    <div id="revenue_ch"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <ul class="nav nav-tabs border-0 gap-3 mb-lg-4 mb-3 seller-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link border-0 bg-body-bg text-secondary fw-medium fs-16 rounded-3 py- px-md-5 px-4 active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" type="button" role="tab" aria-controls="all-tab-pane" aria-selected="true">
                                        <span class="d-inline-block py-1">All Products</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link border-0 bg-body-bg text-secondary fw-medium fs-16 rounded-3 py- px-md-5 px-4" id="published-tab" data-bs-toggle="tab" data-bs-target="#published-tab-pane" type="button" role="tab" aria-controls="published-tab-pane" aria-selected="false">
                                        <span class="d-inline-block py-1">Published Products</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link border-0 bg-body-bg text-secondary fw-medium fs-16 rounded-3 py- px-md-5 px-4" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draft-tab-pane" type="button" role="tab" aria-controls="draft-tab-pane" aria-selected="false">
                                        <span class="d-inline-block py-1">Draft Products</span>
                                    </button>
                                </li>
                            </ul>

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-lg-4 mb-3">
                                <form class="position-relative table-src-form me-0">
                                    <input type="text" class="form-control" placeholder="Search here">
                                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                </form>
                                <a href="create-product" class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg">
                                    <span class="py-sm-1 d-block">
                                        <i class="ri-add-line d-none d-sm-inline-block fs-18"></i>
                                        <span>Add New Product</span>
                                    </span>
                                </a>
                            </div>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                                    <div class="default-table-area all-products">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Order</th>
                                                        <th scope="col">Stock</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Rating</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-body">#JAN-999</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-1.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Smart Band</h6>
                                                                    <span class="fs-12 text-body">20 Mar 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Watch</td>
                                                        <td class="text-secondary">$35.00</td>
                                                        <td class="text-secondary">75</td>
                                                        <td class="text-secondary">750</td>
                                                        <td class="text-secondary">$2,625</td>
                                                        <td class="text-secondary">5.00 (141 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-998</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-2.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Headphone</h6>
                                                                    <span class="fs-12 text-body">07 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Electronics</td>
                                                        <td class="text-secondary">$49.00</td>
                                                        <td class="text-secondary">25</td>
                                                        <td class="text-secondary">825</td>
                                                        <td class="text-secondary">$1,225</td>
                                                        <td class="text-secondary">5.00 (69 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Draft</span>
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
                                                        <td class="text-body">#JAN-997</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-3.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">iPhone 15 Plus</h6>
                                                                    <span class="fs-12 text-body">06 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Apple</td>
                                                        <td class="text-secondary">$99.00</td>
                                                        <td class="text-secondary">55</td>
                                                        <td class="text-danger">Stock Out</td>
                                                        <td class="text-secondary">$5,445</td>
                                                        <td class="text-secondary">5.00 (99 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-996</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-4.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Bluetooth Speaker</h6>
                                                                    <span class="fs-12 text-body">05 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Google</td>
                                                        <td class="text-secondary">$59.00</td>
                                                        <td class="text-secondary">40</td>
                                                        <td class="text-secondary">535</td>
                                                        <td class="text-secondary">$2,360</td>
                                                        <td class="text-secondary">4.00 (75 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-995</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-5.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Airbuds 2nd Gen</h6>
                                                                    <span class="fs-12 text-body">04 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Headphone</td>
                                                        <td class="text-secondary">$79.00</td>
                                                        <td class="text-secondary">56</td>
                                                        <td class="text-secondary">460</td>
                                                        <td class="text-secondary">$4,424</td>
                                                        <td class="text-secondary">5.00 (158 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Draft</span>
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
                                                        <td class="text-body">#JAN-999</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-1.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Smart Band</h6>
                                                                    <span class="fs-12 text-body">20 Mar 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Watch</td>
                                                        <td class="text-secondary">$35.00</td>
                                                        <td class="text-secondary">75</td>
                                                        <td class="text-secondary">750</td>
                                                        <td class="text-secondary">$2,625</td>
                                                        <td class="text-secondary">5.00 (141 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-998</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-2.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Headphone</h6>
                                                                    <span class="fs-12 text-body">07 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Electronics</td>
                                                        <td class="text-secondary">$49.00</td>
                                                        <td class="text-secondary">25</td>
                                                        <td class="text-secondary">825</td>
                                                        <td class="text-secondary">$1,225</td>
                                                        <td class="text-secondary">5.00 (69 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Draft</span>
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
                                                        <td class="text-body">#JAN-997</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-3.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">iPhone 15 Plus</h6>
                                                                    <span class="fs-12 text-body">06 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Apple</td>
                                                        <td class="text-secondary">$99.00</td>
                                                        <td class="text-secondary">55</td>
                                                        <td class="text-danger">Stock Out</td>
                                                        <td class="text-secondary">$5,445</td>
                                                        <td class="text-secondary">5.00 (99 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-996</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-4.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Bluetooth Speaker</h6>
                                                                    <span class="fs-12 text-body">05 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Google</td>
                                                        <td class="text-secondary">$59.00</td>
                                                        <td class="text-secondary">40</td>
                                                        <td class="text-secondary">535</td>
                                                        <td class="text-secondary">$2,360</td>
                                                        <td class="text-secondary">4.00 (75 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-995</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-5.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Airbuds 2nd Gen</h6>
                                                                    <span class="fs-12 text-body">04 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Headphone</td>
                                                        <td class="text-secondary">$79.00</td>
                                                        <td class="text-secondary">56</td>
                                                        <td class="text-secondary">460</td>
                                                        <td class="text-secondary">$4,424</td>
                                                        <td class="text-secondary">5.00 (158 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Draft</span>
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
            
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                            <span class="fs-13 fw-medium">Items per pages: 10</span>
            
                                            <div class="d-flex align-items-center">
                                                <span class="fs-13 fw-medium me-2">1 - 10 of 12</span>
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination mb-0 justify-content-center">
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="course-details" aria-label="Previous">
                                                                <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="course-details" aria-label="Next">
                                                                <i class="material-symbols-outlined">keyboard_arrow_right</i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="published-tab-pane" role="tabpanel" aria-labelledby="published-tab" tabindex="0">
                                    <div class="default-table-area all-products">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Order</th>
                                                        <th scope="col">Stock</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Rating</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-body">#JAN-999</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-1.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Smart Band</h6>
                                                                    <span class="fs-12 text-body">20 Mar 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Watch</td>
                                                        <td class="text-secondary">$35.00</td>
                                                        <td class="text-secondary">75</td>
                                                        <td class="text-secondary">750</td>
                                                        <td class="text-secondary">$2,625</td>
                                                        <td class="text-secondary">5.00 (141 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-998</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-2.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Headphone</h6>
                                                                    <span class="fs-12 text-body">07 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Electronics</td>
                                                        <td class="text-secondary">$49.00</td>
                                                        <td class="text-secondary">25</td>
                                                        <td class="text-secondary">825</td>
                                                        <td class="text-secondary">$1,225</td>
                                                        <td class="text-secondary">5.00 (69 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Draft</span>
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
                                                        <td class="text-body">#JAN-997</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-3.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">iPhone 15 Plus</h6>
                                                                    <span class="fs-12 text-body">06 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Apple</td>
                                                        <td class="text-secondary">$99.00</td>
                                                        <td class="text-secondary">55</td>
                                                        <td class="text-danger">Stock Out</td>
                                                        <td class="text-secondary">$5,445</td>
                                                        <td class="text-secondary">5.00 (99 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-996</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-4.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Bluetooth Speaker</h6>
                                                                    <span class="fs-12 text-body">05 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Google</td>
                                                        <td class="text-secondary">$59.00</td>
                                                        <td class="text-secondary">40</td>
                                                        <td class="text-secondary">535</td>
                                                        <td class="text-secondary">$2,360</td>
                                                        <td class="text-secondary">4.00 (75 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-995</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-5.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Airbuds 2nd Gen</h6>
                                                                    <span class="fs-12 text-body">04 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Headphone</td>
                                                        <td class="text-secondary">$79.00</td>
                                                        <td class="text-secondary">56</td>
                                                        <td class="text-secondary">460</td>
                                                        <td class="text-secondary">$4,424</td>
                                                        <td class="text-secondary">5.00 (158 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Draft</span>
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
                                                        <td class="text-body">#JAN-999</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-1.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Smart Band</h6>
                                                                    <span class="fs-12 text-body">20 Mar 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Watch</td>
                                                        <td class="text-secondary">$35.00</td>
                                                        <td class="text-secondary">75</td>
                                                        <td class="text-secondary">750</td>
                                                        <td class="text-secondary">$2,625</td>
                                                        <td class="text-secondary">5.00 (141 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-998</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-2.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Headphone</h6>
                                                                    <span class="fs-12 text-body">07 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Electronics</td>
                                                        <td class="text-secondary">$49.00</td>
                                                        <td class="text-secondary">25</td>
                                                        <td class="text-secondary">825</td>
                                                        <td class="text-secondary">$1,225</td>
                                                        <td class="text-secondary">5.00 (69 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Draft</span>
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
                                                        <td class="text-body">#JAN-997</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-3.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">iPhone 15 Plus</h6>
                                                                    <span class="fs-12 text-body">06 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Apple</td>
                                                        <td class="text-secondary">$99.00</td>
                                                        <td class="text-secondary">55</td>
                                                        <td class="text-danger">Stock Out</td>
                                                        <td class="text-secondary">$5,445</td>
                                                        <td class="text-secondary">5.00 (99 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-996</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-4.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Bluetooth Speaker</h6>
                                                                    <span class="fs-12 text-body">05 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Google</td>
                                                        <td class="text-secondary">$59.00</td>
                                                        <td class="text-secondary">40</td>
                                                        <td class="text-secondary">535</td>
                                                        <td class="text-secondary">$2,360</td>
                                                        <td class="text-secondary">4.00 (75 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-995</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-5.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Airbuds 2nd Gen</h6>
                                                                    <span class="fs-12 text-body">04 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Headphone</td>
                                                        <td class="text-secondary">$79.00</td>
                                                        <td class="text-secondary">56</td>
                                                        <td class="text-secondary">460</td>
                                                        <td class="text-secondary">$4,424</td>
                                                        <td class="text-secondary">5.00 (158 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Draft</span>
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
            
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                            <span class="fs-13 fw-medium">Items per pages: 10</span>
            
                                            <div class="d-flex align-items-center">
                                                <span class="fs-13 fw-medium me-2">1 - 10 of 12</span>
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination mb-0 justify-content-center">
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="course-details" aria-label="Previous">
                                                                <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="course-details" aria-label="Next">
                                                                <i class="material-symbols-outlined">keyboard_arrow_right</i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="draft-tab-pane" role="tabpanel" aria-labelledby="draft-tab" tabindex="0">
                                    <div class="default-table-area all-products">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Order</th>
                                                        <th scope="col">Stock</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Rating</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-body">#JAN-999</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-1.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Smart Band</h6>
                                                                    <span class="fs-12 text-body">20 Mar 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Watch</td>
                                                        <td class="text-secondary">$35.00</td>
                                                        <td class="text-secondary">75</td>
                                                        <td class="text-secondary">750</td>
                                                        <td class="text-secondary">$2,625</td>
                                                        <td class="text-secondary">5.00 (141 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Published</span>
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
                                                        <td class="text-body">#JAN-998</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-2.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Headphone</h6>
                                                                    <span class="fs-12 text-body">07 Jun 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-secondary">Electronics</td>
                                                        <td class="text-secondary">$49.00</td>
                                                        <td class="text-secondary">25</td>
                                                        <td class="text-secondary">825</td>
                                                        <td class="text-secondary">$1,225</td>
                                                        <td class="text-secondary">5.00 (69 reviews)</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Draft</span>
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
            
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                            <span class="fs-13 fw-medium">Items per pages: 10</span>
            
                                            <div class="d-flex align-items-center">
                                                <span class="fs-13 fw-medium me-2">1 - 10 of 12</span>
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination mb-0 justify-content-center">
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="course-details" aria-label="Previous">
                                                                <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="course-details" aria-label="Next">
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
