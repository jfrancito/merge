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
                        <h3 class="mb-0">Instructors</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">LMS</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Instructors</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 p-4">
                                <form class="position-relative table-src-form me-0">
                                    <input type="text" class="form-control" placeholder="Search here">
                                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                </form>
                                <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                    <span class="py-sm-1 d-block">
                                        <i class="ri-add-line d-none d-sm-inline-block"></i>
                                        <span>Add New Instructors</span>
                                    </span>
                                </button>
                            </div>

                            <div class="default-table-area style-two all-projects">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Courses</th>
                                                <th scope="col">Total Earnings</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Ratings</th>
                                                <th scope="col">Status</th>
                                                <th scope="col" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">#A1217</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-25.jpg" class="wh-44 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                            <h6 class="mb-0 fs-14 fw-medium text-secondary">Olivia Clark</h6>
                                                            <span class="fs-13 text-body">Big Data</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">55</td>
                                                <td class="text-body">$6855.00</td>
                                                <td class="text-body">olivia@trezo.com</td>
                                                <td class="text-body">
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center gap-1">
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
                                                <td class="text-body">#A1364</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-26.jpg" class="wh-44 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                            <h6 class="mb-0 fs-14 fw-medium text-secondary">Ava Turner</h6>
                                                            <span class="fs-13 text-body">UX/UI</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">120</td>
                                                <td class="text-body">$258.00</td>
                                                <td class="text-body">ava@trezo.com</td>
                                                <td class="text-body">
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-half-fill text-rating-color fs-16"></i>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Deactive</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center gap-1">
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
                                                <td class="text-body">#A2951</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-27.jpg" class="wh-44 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                            <h6 class="mb-0 fs-14 fw-medium text-secondary">Lucas Morgan</h6>
                                                            <span class="fs-13 text-body">Developer</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">86</td>
                                                <td class="text-body">$3890.00</td>
                                                <td class="text-body">lucas@trezo.com</td>
                                                <td class="text-body">
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-line text-rating-color fs-16"></i>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center gap-1">
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
                                                <td class="text-body">#A7342</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-28.jpg" class="wh-44 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                            <h6 class="mb-0 fs-14 fw-medium text-secondary">Isabella Cooper</h6>
                                                            <span class="fs-13 text-body">Designer</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">75</td>
                                                <td class="text-body">$2500.00</td>
                                                <td class="text-body">isabella@trezo.com</td>
                                                <td class="text-body">
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-half-fill text-rating-color fs-16"></i>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center gap-1">
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
                                                <td class="text-body">#A1217</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-29.jpg" class="wh-44 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                            <h6 class="mb-0 fs-14 fw-medium text-secondary">Olivia Clark</h6>
                                                            <span class="fs-13 text-body">Big Data</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">55</td>
                                                <td class="text-body">$6855.00</td>
                                                <td class="text-body">olivia@trezo.com</td>
                                                <td class="text-body">
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center gap-1">
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
                                                <td class="text-body">#A1364</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-30.jpg" class="wh-44 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                            <h6 class="mb-0 fs-14 fw-medium text-secondary">Ava Turner</h6>
                                                            <span class="fs-13 text-body">UX/UI</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">120</td>
                                                <td class="text-body">$258.00</td>
                                                <td class="text-body">ava@trezo.com</td>
                                                <td class="text-body">
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-half-fill text-rating-color fs-16"></i>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Deactive</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center gap-1">
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
                                                <td class="text-body">#A2951</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-31.jpg" class="wh-44 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                            <h6 class="mb-0 fs-14 fw-medium text-secondary">Lucas Morgan</h6>
                                                            <span class="fs-13 text-body">Developer</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">86</td>
                                                <td class="text-body">$3890.00</td>
                                                <td class="text-body">lucas@trezo.com</td>
                                                <td class="text-body">
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-line text-rating-color fs-16"></i>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center gap-1">
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
                                                <td class="text-body">#A7342</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-32.jpg" class="wh-44 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                            <h6 class="mb-0 fs-14 fw-medium text-secondary">Isabella Cooper</h6>
                                                            <span class="fs-13 text-body">Designer</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">75</td>
                                                <td class="text-body">$2500.00</td>
                                                <td class="text-body">isabella@trezo.com</td>
                                                <td class="text-body">
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-half-fill text-rating-color fs-16"></i>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center gap-1">
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
                                                <td class="text-body">#A1217</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-33.jpg" class="wh-44 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                            <h6 class="mb-0 fs-14 fw-medium text-secondary">Olivia Clark</h6>
                                                            <span class="fs-13 text-body">Big Data</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">55</td>
                                                <td class="text-body">$6855.00</td>
                                                <td class="text-body">olivia@trezo.com</td>
                                                <td class="text-body">
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center gap-1">
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
                                                <td class="text-body">#A1364</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-34.jpg" class="wh-44 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                            <h6 class="mb-0 fs-14 fw-medium text-secondary">Ava Turner</h6>
                                                            <span class="fs-13 text-body">UX/UI</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">120</td>
                                                <td class="text-body">$258.00</td>
                                                <td class="text-body">ava@trezo.com</td>
                                                <td class="text-body">
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-fill text-rating-color fs-16"></i>
                                                        </li>
                                                        <li>
                                                            <i class="ri-star-half-fill text-rating-color fs-16"></i>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Deactive</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center gap-1">
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
    
                                <div class="p-4 pt-lg-4">
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                        <span class="fs-12 fw-medium">Showing 10 of 30 Results</span>
        
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="instructors" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link active" href="instructors">1</a></li>
                                                <li class="page-item"><a class="page-link" href="instructors">2</a></li>
                                                <li class="page-item"><a class="page-link" href="instructors">3</a></li>
                                                <li class="page-item"><a class="page-link" href="instructors">4</a></li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="instructors" aria-label="Next">
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
