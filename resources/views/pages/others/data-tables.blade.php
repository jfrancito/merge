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
                        <h3 class="mb-0">Data Table</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Tables</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Data Table</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                <h3 class="mb-0">User List</h3>
                                <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                    <option selected>This Week</option>
                                    <option value="1">This Month</option>
                                    <option value="2">This Year</option>
                                </select>
                            </div>

                            <div class="default-table-area all-products">
                                <div class="table-responsive">
                                    <table class="table align-middle" id="myTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">User ID</th>
                                                <th scope="col">User</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Projects</th>
                                                <th scope="col">Join Date</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">#JAN-158</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-6.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Marcia Baker</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">marcia@trezo.com</td>
                                                <td class="text-secondary">Washington D.C</td>
                                                <td class="text-secondary">+1 555-445-4455</td>
                                                <td class="text-secondary">6</td>
                                                <td class="text-secondary">01 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-325</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-7.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Carolyn Barnes</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">barnes@trezo.com</td>
                                                <td class="text-secondary">Chicago</td>
                                                <td class="text-secondary">+1 555-455-9966</td>
                                                <td class="text-secondary">10</td>
                                                <td class="text-secondary">02 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-286</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-8.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Donna Miller</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">donna@trezo.com</td>
                                                <td class="text-secondary">Oklahoma City</td>
                                                <td class="text-secondary">+1 555-555-9922</td>
                                                <td class="text-secondary">6</td>
                                                <td class="text-secondary">03 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-463</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-9.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Barbara Cross</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">cross@trezo.com</td>
                                                <td class="text-secondary">San Diego</td>
                                                <td class="text-secondary">+1 555-445-7788</td>
                                                <td class="text-secondary">4</td>
                                                <td class="text-secondary">04 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-998</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-10.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Rebecca Block</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">block@trezo.com</td>
                                                <td class="text-secondary">Los Angeles</td>
                                                <td class="text-secondary">+1 555-333-2288</td>
                                                <td class="text-secondary">2</td>
                                                <td class="text-secondary">05 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-436</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-11.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Ramiro McCarty</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">ramiro@trezo.com</td>
                                                <td class="text-secondary">Las Vegas</td>
                                                <td class="text-secondary">+1 555-445-4455</td>
                                                <td class="text-secondary">8</td>
                                                <td class="text-secondary">06 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-860</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-12.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Robert Fairweather</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">robert@trezo.com</td>
                                                <td class="text-secondary">San Francisco</td>
                                                <td class="text-secondary">+1 555-555-9922</td>
                                                <td class="text-secondary">6</td>
                                                <td class="text-secondary">07 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-491</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-13.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Marcelino Haddock</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">haddock@trezo.com</td>
                                                <td class="text-secondary">Washington D.C</td>
                                                <td class="text-secondary">+1 555-455-9966</td>
                                                <td class="text-secondary">9</td>
                                                <td class="text-secondary">08 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-125</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-14.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Thomas Wilson</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">wildon@trezo.com</td>
                                                <td class="text-secondary">San Diego</td>
                                                <td class="text-secondary">+1 555-333-2288</td>
                                                <td class="text-secondary">5</td>
                                                <td class="text-secondary">10 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-579</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-15.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Nathaniel Hulsey</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">hulsey@trezo.com</td>
                                                <td class="text-secondary">Chicago</td>
                                                <td class="text-secondary">+1 555-445-7788</td>
                                                <td class="text-secondary">6</td>
                                                <td class="text-secondary">11 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-158</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-6.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Marcia Baker</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">marcia@trezo.com</td>
                                                <td class="text-secondary">Washington D.C</td>
                                                <td class="text-secondary">+1 555-445-4455</td>
                                                <td class="text-secondary">6</td>
                                                <td class="text-secondary">01 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-325</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-7.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Carolyn Barnes</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">barnes@trezo.com</td>
                                                <td class="text-secondary">Chicago</td>
                                                <td class="text-secondary">+1 555-455-9966</td>
                                                <td class="text-secondary">10</td>
                                                <td class="text-secondary">02 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-286</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-8.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Donna Miller</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">donna@trezo.com</td>
                                                <td class="text-secondary">Oklahoma City</td>
                                                <td class="text-secondary">+1 555-555-9922</td>
                                                <td class="text-secondary">6</td>
                                                <td class="text-secondary">03 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-463</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-9.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Barbara Cross</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">cross@trezo.com</td>
                                                <td class="text-secondary">San Diego</td>
                                                <td class="text-secondary">+1 555-445-7788</td>
                                                <td class="text-secondary">4</td>
                                                <td class="text-secondary">04 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-998</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-10.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Rebecca Block</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">block@trezo.com</td>
                                                <td class="text-secondary">Los Angeles</td>
                                                <td class="text-secondary">+1 555-333-2288</td>
                                                <td class="text-secondary">2</td>
                                                <td class="text-secondary">05 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-436</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-11.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Ramiro McCarty</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">ramiro@trezo.com</td>
                                                <td class="text-secondary">Las Vegas</td>
                                                <td class="text-secondary">+1 555-445-4455</td>
                                                <td class="text-secondary">8</td>
                                                <td class="text-secondary">06 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-860</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-12.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Robert Fairweather</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">robert@trezo.com</td>
                                                <td class="text-secondary">San Francisco</td>
                                                <td class="text-secondary">+1 555-555-9922</td>
                                                <td class="text-secondary">6</td>
                                                <td class="text-secondary">07 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-491</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-13.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Marcelino Haddock</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">haddock@trezo.com</td>
                                                <td class="text-secondary">Washington D.C</td>
                                                <td class="text-secondary">+1 555-455-9966</td>
                                                <td class="text-secondary">9</td>
                                                <td class="text-secondary">08 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-125</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-14.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Thomas Wilson</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">wildon@trezo.com</td>
                                                <td class="text-secondary">San Diego</td>
                                                <td class="text-secondary">+1 555-333-2288</td>
                                                <td class="text-secondary">5</td>
                                                <td class="text-secondary">10 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-579</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-15.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Nathaniel Hulsey</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">hulsey@trezo.com</td>
                                                <td class="text-secondary">Chicago</td>
                                                <td class="text-secondary">+1 555-445-7788</td>
                                                <td class="text-secondary">6</td>
                                                <td class="text-secondary">11 Dec 2024</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
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
