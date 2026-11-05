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
                        <h3 class="mb-0">Reviews</h3>

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
                                    <span class="fw-medium">Reviews</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 mb-md-4">
                                <form class="position-relative table-src-form me-0">
                                    <input type="text" class="form-control" placeholder="Search here">
                                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                </form>
                                <select class="form-select month-select form-control" aria-label="Default select example">
                                    <option selected>Show All</option>
                                    <option value="1">Weekly</option>
                                    <option value="2">Monthly</option>
                                    <option value="3">Yearly</option>
                                </select>
                            </div>

                            <div class="default-table-area manage-reviews-table">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">Reviewer</th>
                                                <th scope="col">Review</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-6.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Olivia Clark</h6>
                                                            <span class="text-body">olivia@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <a href="product-details" class="d-flex align-items-center text-secondary hover">
                                                        <img src="assets/images/product-1.jpg" class="rounded-3 wh-40" alt="product">
                                                        <span class="fs-15 fw-medium ms-2">Smart Band</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-7.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Zephyr Zing</h6>
                                                            <span class="text-body">zephyr@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-half-fill fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <a href="product-details" class="d-flex align-items-center text-secondary hover">
                                                        <img src="assets/images/product-2.jpg" class="rounded-3 wh-40" alt="product">
                                                        <span class="fs-15 fw-medium ms-2">Headphone</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-8.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Nova Nectar</h6>
                                                            <span class="text-body">nova@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-line fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <a href="product-details" class="d-flex align-items-center text-secondary hover">
                                                        <img src="assets/images/product-3.jpg" class="rounded-3 wh-40" alt="product">
                                                        <span class="fs-15 fw-medium ms-2">iPhone 15 Plus</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-9.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Isabella Chang</h6>
                                                            <span class="text-body">isabella@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-half-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-line fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <a href="product-details" class="d-flex align-items-center text-secondary hover">
                                                        <img src="assets/images/product-4.jpg" class="rounded-3 wh-40" alt="product">
                                                        <span class="fs-15 fw-medium ms-2">Bluetooth Speaker</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-10.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Alina Bennett</h6>
                                                            <span class="text-body">alina@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <a href="product-details" class="d-flex align-items-center text-secondary hover">
                                                        <img src="assets/images/product-5.jpg" class="rounded-3 wh-40" alt="product">
                                                        <span class="fs-15 fw-medium ms-2">Airbuds 2nd Gen</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Published</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-6.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Olivia Clark</h6>
                                                            <span class="text-body">olivia@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <a href="product-details" class="d-flex align-items-center text-secondary hover">
                                                        <img src="assets/images/product-1.jpg" class="rounded-3 wh-40" alt="product">
                                                        <span class="fs-15 fw-medium ms-2">Smart Band</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-7.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Zephyr Zing</h6>
                                                            <span class="text-body">zephyr@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-half-fill fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <a href="product-details" class="d-flex align-items-center text-secondary hover">
                                                        <img src="assets/images/product-2.jpg" class="rounded-3 wh-40" alt="product">
                                                        <span class="fs-15 fw-medium ms-2">Headphone</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-8.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Nova Nectar</h6>
                                                            <span class="text-body">nova@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-line fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <a href="product-details" class="d-flex align-items-center text-secondary hover">
                                                        <img src="assets/images/product-3.jpg" class="rounded-3 wh-40" alt="product">
                                                        <span class="fs-15 fw-medium ms-2">iPhone 15 Plus</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-9.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Isabella Chang</h6>
                                                            <span class="text-body">isabella@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-half-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-line fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <a href="product-details" class="d-flex align-items-center text-secondary hover">
                                                        <img src="assets/images/product-4.jpg" class="rounded-3 wh-40" alt="product">
                                                        <span class="fs-15 fw-medium ms-2">Bluetooth Speaker</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-10.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Alina Bennett</h6>
                                                            <span class="text-body">alina@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <a href="product-details" class="d-flex align-items-center text-secondary hover">
                                                        <img src="assets/images/product-5.jpg" class="rounded-3 wh-40" alt="product">
                                                        <span class="fs-15 fw-medium ms-2">Airbuds 2nd Gen</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Published</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
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
                                                    <a class="page-link icon" href="reviews" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="reviews" aria-label="Next">
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
