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
                        <h3 class="mb-0">Teams</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Project Management</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Teams</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-60.jpg" class="wh-65 rounded-circle border border-2" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                <h4 class="fs-16 fw-semibold mb-1">Ava Turner</h4>
                                                <span>Team Leader</span>
                                            </div>
                                        </div>

                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-symbols-outlined fs-20 text-body hover">more_horiz</i>
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
                                    <span class="d-block py-2 px-3 text-center rounded-pill fw-medium text-secondary mb-3 bg-for-dark-mode" style="background-color: #F3E8FF;">Project Management</span>
                                    <span class="d-block text-center text-body mb-3">Team Members</span>
                                    <div class="d-flex flex-wrap justify-content-center mb-3">
                                        <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                            <img src="assets/images/user-52.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                            <img src="assets/images/user-54.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-55.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-56.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                    </div>
                                    <div class="mb-4 pb-md-2">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="fw-medium d-block">New Order</span>
                                            <span class="fw-medium d-block">85%</span>
                                        </div>
                                        <div class="progress bg-primary bg-opacity-10" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 85%; height: 4px;"></div>
                                        </div>
                                    </div>
                                    <a href="project-overview" class="btn btn-outline-primary fw-medium w-100 py-2 rounded-3">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-61.jpg" class="wh-65 rounded-circle border border-2" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                <h4 class="fs-16 fw-semibold mb-1">Ethan Parker</h4>
                                                <span>Team Leader</span>
                                            </div>
                                        </div>

                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-symbols-outlined fs-20 text-body hover">more_horiz</i>
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
                                    <span class="d-block py-2 px-3 text-center rounded-pill fw-medium text-secondary mb-3 bg-for-dark-mode" style="background-color: #DAEBFF;">eCommerce Theme</span>
                                    <span class="d-block text-center text-body mb-3">Team Members</span>
                                    <div class="d-flex flex-wrap justify-content-center mb-3">
                                        <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                            <img src="assets/images/user-52.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                            <img src="assets/images/user-54.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-55.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-56.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                    </div>
                                    <div class="mb-4 pb-md-2">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="fw-medium d-block">New Order</span>
                                            <span class="fw-medium d-block">45%</span>
                                        </div>
                                        <div class="progress bg-primary bg-opacity-10" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 45%; height: 4px;"></div>
                                        </div>
                                    </div>
                                    <a href="project-overview" class="btn btn-outline-primary fw-medium w-100 py-2 rounded-3">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-62.jpg" class="wh-65 rounded-circle border border-2" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                <h4 class="fs-16 fw-semibold mb-1">Isabella</h4>
                                                <span>Team Leader</span>
                                            </div>
                                        </div>

                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-symbols-outlined fs-20 text-body hover">more_horiz</i>
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
                                    <span class="d-block py-2 px-3 text-center rounded-pill fw-medium text-secondary mb-3 bg-for-dark-mode" style="background-color: #D8FFC8;">Shopify Theme Dev</span>
                                    <span class="d-block text-center text-body mb-3">Team Members</span>
                                    <div class="d-flex flex-wrap justify-content-center mb-3">
                                        <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                            <img src="assets/images/user-52.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                            <img src="assets/images/user-54.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-55.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-56.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                    </div>
                                    <div class="mb-4 pb-md-2">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="fw-medium d-block">New Order</span>
                                            <span class="fw-medium d-block">70%</span>
                                        </div>
                                        <div class="progress bg-primary bg-opacity-10" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 70%; height: 4px;"></div>
                                        </div>
                                    </div>
                                    <a href="project-overview" class="btn btn-outline-primary fw-medium w-100 py-2 rounded-3">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-63.jpg" class="wh-65 rounded-circle border border-2" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                <h4 class="fs-16 fw-semibold mb-1">Thompson</h4>
                                                <span>Team Leader</span>
                                            </div>
                                        </div>

                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-symbols-outlined fs-20 text-body hover">more_horiz</i>
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
                                    <span class="d-block py-2 px-3 text-center rounded-pill fw-medium text-secondary mb-3 bg-for-dark-mode" style="background-color: #FFE8D4;">Oito - HTM</span>
                                    <span class="d-block text-center text-body mb-3">Team Members</span>
                                    <div class="d-flex flex-wrap justify-content-center mb-3">
                                        <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                            <img src="assets/images/user-52.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                            <img src="assets/images/user-54.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-55.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-56.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                    </div>
                                    <div class="mb-4 pb-md-2">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="fw-medium d-block">New Order</span>
                                            <span class="fw-medium d-block">90%</span>
                                        </div>
                                        <div class="progress bg-primary bg-opacity-10" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 90%; height: 4px;"></div>
                                        </div>
                                    </div>
                                    <a href="project-overview" class="btn btn-outline-primary fw-medium w-100 py-2 rounded-3">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-64.jpg" class="wh-65 rounded-circle border border-2" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                <h4 class="fs-16 fw-semibold mb-1">Lucas</h4>
                                                <span>Team Leader</span>
                                            </div>
                                        </div>

                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-symbols-outlined fs-20 text-body hover">more_horiz</i>
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
                                    <span class="d-block py-2 px-3 text-center rounded-pill fw-medium text-secondary mb-3 bg-for-dark-mode" style="background-color: #D8FFC8;">Tanus - Template</span>
                                    <span class="d-block text-center text-body mb-3">Team Members</span>
                                    <div class="d-flex flex-wrap justify-content-center mb-3">
                                        <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                            <img src="assets/images/user-52.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                            <img src="assets/images/user-54.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-55.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-56.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                    </div>
                                    <div class="mb-4 pb-md-2">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="fw-medium d-block">New Order</span>
                                            <span class="fw-medium d-block">75%</span>
                                        </div>
                                        <div class="progress bg-primary bg-opacity-10" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 75%; height: 4px;"></div>
                                        </div>
                                    </div>
                                    <a href="project-overview" class="btn btn-outline-primary fw-medium w-100 py-2 rounded-3">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-64.jpg" class="wh-65 rounded-circle border border-2" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                <h4 class="fs-16 fw-semibold mb-1">Morgan</h4>
                                                <span>Team Leader</span>
                                            </div>
                                        </div>

                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-symbols-outlined fs-20 text-body hover">more_horiz</i>
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
                                    <span class="d-block py-2 px-3 text-center rounded-pill fw-medium text-secondary mb-3 bg-for-dark-mode" style="background-color: #F3E8FF;">Delft - TypeScript</span>
                                    <span class="d-block text-center text-body mb-3">Team Members</span>
                                    <div class="d-flex flex-wrap justify-content-center mb-3">
                                        <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                            <img src="assets/images/user-52.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                            <img src="assets/images/user-54.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-55.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-56.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                    </div>
                                    <div class="mb-4 pb-md-2">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="fw-medium d-block">New Order</span>
                                            <span class="fw-medium d-block">65%</span>
                                        </div>
                                        <div class="progress bg-primary bg-opacity-10" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 65%; height: 4px;"></div>
                                        </div>
                                    </div>
                                    <a href="project-overview" class="btn btn-outline-primary fw-medium w-100 py-2 rounded-3">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-66.jpg" class="wh-65 rounded-circle border border-2" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                <h4 class="fs-16 fw-semibold mb-1">Sophia</h4>
                                                <span>Team Leader</span>
                                            </div>
                                        </div>

                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-symbols-outlined fs-20 text-body hover">more_horiz</i>
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
                                    <span class="d-block py-2 px-3 text-center rounded-pill fw-medium text-secondary mb-3 bg-for-dark-mode" style="background-color: #DAEBFF;">Trezo - Angular</span>
                                    <span class="d-block text-center text-body mb-3">Team Members</span>
                                    <div class="d-flex flex-wrap justify-content-center mb-3">
                                        <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                            <img src="assets/images/user-52.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                            <img src="assets/images/user-54.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-55.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-56.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                    </div>
                                    <div class="mb-4 pb-md-2">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="fw-medium d-block">New Order</span>
                                            <span class="fw-medium d-block">95%</span>
                                        </div>
                                        <div class="progress bg-primary bg-opacity-10" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 95%; height: 4px;"></div>
                                        </div>
                                    </div>
                                    <a href="project-overview" class="btn btn-outline-primary fw-medium w-100 py-2 rounded-3">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-67.jpg" class="wh-65 rounded-circle border border-2" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                <h4 class="fs-16 fw-semibold mb-1">Rodriguez</h4>
                                                <span>Team Leader</span>
                                            </div>
                                        </div>

                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-symbols-outlined fs-20 text-body hover">more_horiz</i>
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
                                    <span class="d-block py-2 px-3 text-center rounded-pill fw-medium text-secondary mb-3 bg-for-dark-mode" style="background-color: #F3E8FF;">eLearniv - React</span>
                                    <span class="d-block text-center text-body mb-3">Team Members</span>
                                    <div class="d-flex flex-wrap justify-content-center mb-3">
                                        <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                            <img src="assets/images/user-52.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                            <img src="assets/images/user-54.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-55.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                        <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                            <img src="assets/images/user-56.jpg" class="wh-40 rounded-circle border border-2" alt="user">
                                        </a>
                                    </div>
                                    <div class="mb-4 pb-md-2">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="fw-medium d-block">New Order</span>
                                            <span class="fw-medium d-block">80%</span>
                                        </div>
                                        <div class="progress bg-primary bg-opacity-10" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 80%; height: 4px;"></div>
                                        </div>
                                    </div>
                                    <a href="project-overview" class="btn btn-outline-primary fw-medium w-100 py-2 rounded-3">View Details</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                        <span class="fs-12 fw-medium">Showing 09 of 30 Results</span>
        
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="teams" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link active" href="teams">1</a></li>
                                                <li class="page-item"><a class="page-link" href="teams">2</a></li>
                                                <li class="page-item"><a class="page-link" href="teams">3</a></li>
                                                <li class="page-item"><a class="page-link" href="teams">4</a></li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="teams" aria-label="Next">
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
