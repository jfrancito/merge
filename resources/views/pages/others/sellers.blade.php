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
                        <h3 class="mb-0">Sellers</h3>

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
                                    <span class="fw-medium">Sellers</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <form class="position-relative table-src-form me-0">
                                    <input type="text" class="form-control" placeholder="Search here">
                                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                </form>
                                <a href="create-seller" class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg">
                                    <span class="py-sm-1 d-block">
                                        <i class="ri-add-line d-none d-sm-inline-block"></i>
                                        <span>Add New Seller</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
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
                                    <div class="d-flex align-items-center mb-0">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">TechMaster Store</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/seller-2.png" class="wh-52" alt="seller">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="#" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Ethan Parker</a>
                                                <span class="d-block">ethan@trezo.com</span>
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
                                        <span class="text-secondary ms-1">01 Nov 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Item Stock:</span>
                                        <span class="text-secondary ms-1">39</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Wallet Balance:</span>
                                        <span class="text-secondary ms-1">$6,756.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Revenue:</span>
                                        <span class="text-secondary ms-1">$4,645.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">RisionTech Outlet</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/seller-3.png" class="wh-52" alt="seller">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="#" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Isabella</a>
                                                <span class="d-block">isabella@trezo.com</span>
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
                                        <span class="text-secondary ms-1">30 Sep 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Item Stock:</span>
                                        <span class="text-secondary ms-1">75</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Wallet Balance:</span>
                                        <span class="text-secondary ms-1">$5,550.00</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Revenue:</span>
                                        <span class="text-secondary ms-1">$4,350.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">ComfotLiving</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/seller-4.png" class="wh-52" alt="seller">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="#" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Thompson</a>
                                                <span class="d-block">thompson@trezo.com</span>
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
                                        <span class="text-secondary ms-1">02 Aug 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Item Stock:</span>
                                        <span class="text-secondary ms-1">99</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Wallet Balance:</span>
                                        <span class="text-secondary ms-1">$2,100.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Revenue:</span>
                                        <span class="text-secondary ms-1">$1,500.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">SportFit Store</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/seller-5.png" class="wh-52" alt="seller">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="#" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Lucas</a>
                                                <span class="d-block">lucas@trezo.com</span>
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
                                        <span class="text-secondary ms-1">22 July 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Item Stock:</span>
                                        <span class="text-secondary ms-1">350</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Wallet Balance:</span>
                                        <span class="text-secondary ms-1">$15,250.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Revenue:</span>
                                        <span class="text-secondary ms-1">$10,200.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">Velas Store</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/seller-6.png" class="wh-52" alt="seller">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="#" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Morgan</a>
                                                <span class="d-block">morgan@trezo.com</span>
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
                                        <span class="text-secondary ms-1">10 Jun 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Item Stock:</span>
                                        <span class="text-secondary ms-1">200</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Wallet Balance:</span>
                                        <span class="text-secondary ms-1">$10,500.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Revenue:</span>
                                        <span class="text-secondary ms-1">$5,458.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">Herna Store</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/seller-7.png" class="wh-52" alt="seller">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="#" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Sophia</a>
                                                <span class="d-block">sophia@trezo.com</span>
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
                                        <span class="text-secondary ms-1">16 Feb 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Item Stock:</span>
                                        <span class="text-secondary ms-1">80</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Wallet Balance:</span>
                                        <span class="text-secondary ms-1">$2,580.00</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Revenue:</span>
                                        <span class="text-secondary ms-1">$1,500.00</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">Dona Store</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/seller-8.png" class="wh-52" alt="seller">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="#" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Rodriguez</a>
                                                <span class="d-block">rodriguez@trezo.com</span>
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
                                        <span class="text-secondary ms-1">12 May 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Item Stock:</span>
                                        <span class="text-secondary ms-1">150</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Wallet Balance:</span>
                                        <span class="text-secondary ms-1">$9,000.00</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Revenue:</span>
                                        <span class="text-secondary ms-1">$6,000.00</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">Willi Dav Store</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/seller-9.png" class="wh-52" alt="seller">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="#" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Olivia Taylor</a>
                                                <span class="d-block">olivia@trezo.com</span>
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
                                        <span class="text-secondary ms-1">10 Apr 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Item Stock:</span>
                                        <span class="text-secondary ms-1">75</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Wallet Balance:</span>
                                        <span class="text-secondary ms-1">$7,500.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Revenue:</span>
                                        <span class="text-secondary ms-1">$4,500.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">Donne Store</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/seller-10.png" class="wh-52" alt="seller">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="#" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">David Smith</a>
                                                <span class="d-block">david@trezo.com</span>
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
                                        <span class="text-secondary ms-1">03 Dec 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Item Stock:</span>
                                        <span class="text-secondary ms-1">500</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Wallet Balance:</span>
                                        <span class="text-secondary ms-1">$18,500.00</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Revenue:</span>
                                        <span class="text-secondary ms-1">$13,200.00</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">RichMaster Store</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/seller-11.png" class="wh-52" alt="seller">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="#" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Alice Johnson</a>
                                                <span class="d-block">alice@trezo.com</span>
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
                                        <span class="text-secondary ms-1">23 Mar 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Item Stock:</span>
                                        <span class="text-secondary ms-1">50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Wallet Balance:</span>
                                        <span class="text-secondary ms-1">$6,300.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Revenue:</span>
                                        <span class="text-secondary ms-1">$4,000.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">Dajon Store</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/seller-12.png" class="wh-52" alt="seller">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="#" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Emily Brown</a>
                                                <span class="d-block">emily@trezo.com</span>
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
                                        <span class="text-secondary ms-1">20 Jan 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Item Stock:</span>
                                        <span class="text-secondary ms-1">99</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Wallet Balance:</span>
                                        <span class="text-secondary ms-1">$3,699.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span>Revenue:</span>
                                        <span class="text-secondary ms-1">$2,599.50</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <span>Store:</span>
                                        <span class="text-secondary ms-1">Barbahall Store</span>
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
