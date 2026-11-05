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
                        <h3 class="mb-0">Team Members</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">User</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Team Members</span>
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
                                <a href="add-user" class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg">
                                    <span class="py-sm-1 d-block">
                                        <i class="ri-add-line d-none d-sm-inline-block"></i>
                                        <span>Add New User</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-60.jpg" class="wh-65 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="my-profile" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Ava Turner</a>
                                                <span class="d-block">Business Analyst</span>
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
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Joined Date:</span>
                                        <span class="ms-1">01 Jan 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Email Address:</span>
                                        <span class="ms-1">turner@trezo.com</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Phone Number:</span>
                                        <span class="ms-1">+1 555-445-4455</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span class="text-secondary">Location:</span>
                                        <span class="ms-1">Washington D.C</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-61.jpg" class="wh-65 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="my-profile" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">
                                                    Ethan Parker</a>
                                                <span class="d-block">Project Manager</span>
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
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Joined Date:</span>
                                        <span class="ms-1">10 Jan 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Email Address:</span>
                                        <span class="ms-1">parker@trezo.com</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Phone Number:</span>
                                        <span class="ms-1">+1 555-445-7788</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span class="text-secondary">Location:</span>
                                        <span class="ms-1">San Diego</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-62.jpg" class="wh-65 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="my-profile" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Isabella Lee</a>
                                                <span class="d-block">Team Leader</span>
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
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Joined Date:</span>
                                        <span class="ms-1">20 Jan 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Email Address:</span>
                                        <span class="ms-1">lee@trezo.com</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Phone Number:</span>
                                        <span class="ms-1">+1 555-333-2288</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span class="text-secondary">Location:</span>
                                        <span class="ms-1">Los Angeles</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-63.jpg" class="wh-65 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="my-profile" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">
                                                    Thompson Torres</a>
                                                <span class="d-block">Designer</span>
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
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Joined Date:</span>
                                        <span class="ms-1">01 Feb 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Email Address:</span>
                                        <span class="ms-1">torres@trezo.com</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Phone Number:</span>
                                        <span class="ms-1">+1 555-444-3355</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span class="text-secondary">Location:</span>
                                        <span class="ms-1">Boston</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-64.jpg" class="wh-65 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="my-profile" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Lucas Lyon</a>
                                                <span class="d-block">Technical Writer</span>
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
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Joined Date:</span>
                                        <span class="ms-1">10 Feb 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Email Address:</span>
                                        <span class="ms-1">lucas@trezo.com</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Phone Number:</span>
                                        <span class="ms-1">+1 555-455-9966</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span class="text-secondary">Location:</span>
                                        <span class="ms-1">Chicago</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-65.jpg" class="wh-65 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="my-profile" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Morgan Sturges</a>
                                                <span class="d-block">Data Analyst</span>
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
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Joined Date:</span>
                                        <span class="ms-1">01 Mar 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Email Address:</span>
                                        <span class="ms-1">morgan@trezo.com</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Phone Number:</span>
                                        <span class="ms-1">+1 555-225-7755</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span class="text-secondary">Location:</span>
                                        <span class="ms-1">Las Vegas</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-66.jpg" class="wh-65 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="my-profile" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">
                                                    Sophia McNeel</a>
                                                <span class="d-block">Sales Representative</span>
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
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Joined Date:</span>
                                        <span class="ms-1">15 Mar 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Email Address:</span>
                                        <span class="ms-1">sophia@trezo.com</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Phone Number:</span>
                                        <span class="ms-1">+1 555-444-8822</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span class="text-secondary">Location:</span>
                                        <span class="ms-1">San Francisco</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-67.jpg" class="wh-65 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="my-profile" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Rodriguez Meade</a>
                                                <span class="d-block">Manager</span>
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
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Joined Date:</span>
                                        <span class="ms-1">01 Apr 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Email Address:</span>
                                        <span class="ms-1">meade@trezo.com</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Phone Number:</span>
                                        <span class="ms-1">+1 555-455-4411</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span class="text-secondary">Location:</span>
                                        <span class="ms-1">Houston</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-68.jpg" class="wh-65 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="my-profile" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Michael Mackenzie</a>
                                                <span class="d-block">Web Developer</span>
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
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Joined Date:</span>
                                        <span class="ms-1">10 Apr 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Email Address:</span>
                                        <span class="ms-1">michael@trezo.com</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Phone Number:</span>
                                        <span class="ms-1">+1 555-555-9922</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span class="text-secondary">Location:</span>
                                        <span class="ms-1">Oklahoma City</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-69.jpg" class="wh-65 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="my-profile" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Charles Tharp</a>
                                                <span class="d-block">Accountant</span>
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
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Joined Date:</span>
                                        <span class="ms-1">01 May 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Email Address:</span>
                                        <span class="ms-1">charles@trezo.com</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Phone Number:</span>
                                        <span class="ms-1">+1 555-433-2255</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span class="text-secondary">Location:</span>
                                        <span class="ms-1">Austin</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-60.jpg" class="wh-65 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="my-profile" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Tina Bell</a>
                                                <span class="d-block">Executive Assistant</span>
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
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Joined Date:</span>
                                        <span class="ms-1">10 May 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Email Address:</span>
                                        <span class="ms-1">tina@trezo.com</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Phone Number:</span>
                                        <span class="ms-1">+1 555-444-3399</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span class="text-secondary">Location:</span>
                                        <span class="ms-1">Portland</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-61.jpg" class="wh-65 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <a href="my-profile" class="text-decoration-none text-secondary fw-medium fs-16 mb-1">Melvin Larocque</a>
                                                <span class="d-block">Business Analyst</span>
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
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Joined Date:</span>
                                        <span class="ms-1">01 Jun 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Email Address:</span>
                                        <span class="ms-1">melvin@trezo.com</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <span class="text-secondary">Phone Number:</span>
                                        <span class="ms-1">+1 555-445-5855</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4">
                                        <span class="text-secondary">Location:</span>
                                        <span class="ms-1">San Diego</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                    </ul>
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
