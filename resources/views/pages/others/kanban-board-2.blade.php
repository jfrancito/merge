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
                        <h3 class="mb-0">Kanban Board</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Apps</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Kanban Board</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 kanban-for-dark">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="mb-0 fs-16 fw-medium">To Do</h4>
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
                                    <div class="rounded-3 mb-4" style="background-color: #F3E8FF; padding: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fs-14 fw-semibold">Project Requirements</h4>
                                            <button class="material-symbols-outlined fs-20 text-body hover border-0 p-0 bg-transparent">edit</button>
                                        </div>
                                        <p>A brief description of the project, its objectives, and its importance to the organization.</p>
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="d-flex">
                                                <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                    <img src="assets/images/user-30.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                    <img src="assets/images/user-31.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                    <img src="assets/images/user-32.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                            </div>
                                            <span class="text-primary">5 days left</span>
                                        </div>
                                    </div>
                                    <div class="rounded-3 mb-4" style="background-color: #DAEBFF; padding: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fs-14 fw-semibold">WordPress Theme</h4>
                                            <button class="material-symbols-outlined fs-20 text-body hover border-0 p-0 bg-transparent">edit</button>
                                        </div>
                                        <p>A brief description of the project, its objectives, and its importance to the organization.</p>
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="d-flex">
                                                <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                    <img src="assets/images/user-30.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                    <img src="assets/images/user-31.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                            </div>
                                            <span class="text-primary">7 days left</span>
                                        </div>
                                    </div>
                                    <div class="rounded-3 mb-4" style="background-color: #D8FFC8; padding: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fs-14 fw-semibold">UX/UI Design</h4>
                                            <button class="material-symbols-outlined fs-20 text-body hover border-0 p-0 bg-transparent">edit</button>
                                        </div>
                                        <p>A brief description of the project, its objectives, and its importance to the organization.</p>
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="d-flex">
                                                <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                    <img src="assets/images/user-30.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                    <img src="assets/images/user-31.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                    <img src="assets/images/user-32.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                            </div>
                                            <span class="text-primary">10 days left</span>
                                        </div>
                                    </div>
                                    <div class="rounded-3 mb-4" style="background-color: #FFE8D4; padding: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fs-14 fw-semibold">Project Analysis</h4>
                                            <button class="material-symbols-outlined fs-20 text-body hover border-0 p-0 bg-transparent">edit</button>
                                        </div>
                                        <p>A brief description of the project, its objectives, and its importance to the organization.</p>
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="d-flex">
                                                <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                    <img src="assets/images/user-30.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                    <img src="assets/images/user-31.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                            </div>
                                            <span class="text-primary">14 days left</span>
                                        </div>
                                    </div>
                                    <div class="rounded-3 mb-4" style="background-color: #DDE4FF; padding: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fs-14 fw-semibold">Competitor Research</h4>
                                            <button class="material-symbols-outlined fs-20 text-body hover border-0 p-0 bg-transparent">edit</button>
                                        </div>
                                        <p>A brief description of the project, its objectives, and its importance to the organization.</p>
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="d-flex">
                                                <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                    <img src="assets/images/user-30.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                    <img src="assets/images/user-31.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                    <img src="assets/images/user-32.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                            </div>
                                            <span class="text-primary">15 days left</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                        <span class="py-sm-1 d-block">
                                            <i class="ri-add-line d-none d-sm-inline-block"></i>
                                            <span>Add New Card</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 kanban-for-dark">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="mb-0 fs-16 fw-medium">Doing</h4>
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
                                    <div class="rounded-3 mb-4" style="background-color: #FFE8D4; padding: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fs-14 fw-semibold">React Template</h4>
                                            <button class="material-symbols-outlined fs-20 text-body hover border-0 p-0 bg-transparent">edit</button>
                                        </div>
                                        <p>A brief description of the project, its objectives, and its importance to the organization.</p>
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="d-flex">
                                                <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                    <img src="assets/images/user-30.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                    <img src="assets/images/user-31.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                            </div>
                                            <span class="text-danger">3 days left</span>
                                        </div>
                                    </div>
                                    <div class="rounded-3 mb-4" style="background-color: #F3E8FF; padding: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fs-14 fw-semibold">Laravel Project</h4>
                                            <button class="material-symbols-outlined fs-20 text-body hover border-0 p-0 bg-transparent">edit</button>
                                        </div>
                                        <p>A brief description of the project, its objectives, and its importance to the organization.</p>
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="d-flex">
                                                <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                    <img src="assets/images/user-30.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                    <img src="assets/images/user-31.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                    <img src="assets/images/user-32.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                            </div>
                                            <span class="text-primary">5 days left</span>
                                        </div>
                                    </div>
                                    <div class="rounded-3 mb-4" style="background-color: #FFE1DD; padding: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fs-14 fw-semibold">Project Requirements</h4>
                                            <button class="material-symbols-outlined fs-20 text-body hover border-0 p-0 bg-transparent">edit</button>
                                        </div>
                                        <p>A brief description of the project, its objectives, and its importance to the organization.</p>
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="d-flex">
                                                <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                    <img src="assets/images/user-30.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                            </div>
                                            <span class="text-primary">7 days left</span>
                                        </div>
                                    </div>
                                    <div class="rounded-3 mb-4" style="background-color: #D8FFC8; padding: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fs-14 fw-semibold">UX/UI Design</h4>
                                            <button class="material-symbols-outlined fs-20 text-body hover border-0 p-0 bg-transparent">edit</button>
                                        </div>
                                        <p>A brief description of the project, its objectives, and its importance to the organization.</p>
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="d-flex">
                                                <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                    <img src="assets/images/user-30.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                    <img src="assets/images/user-31.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                            </div>
                                            <span class="text-primary">9 days left</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                        <span class="py-sm-1 d-block">
                                            <i class="ri-add-line d-none d-sm-inline-block"></i>
                                            <span>Add New Card</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 kanban-for-dark">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="mb-0 fs-16 fw-medium">Done</h4>
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
                                    <div class="rounded-3 mb-4" style="background-color: #DDE4FF; padding: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fs-14 fw-semibold">Admin Template</h4>
                                            <button class="material-symbols-outlined fs-20 text-body hover border-0 p-0 bg-transparent">edit</button>
                                        </div>
                                        <p>A brief description of the project, its objectives, and its importance to the organization.</p>
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="d-flex">
                                                <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                    <img src="assets/images/user-30.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                    <img src="assets/images/user-31.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                    <img src="assets/images/user-32.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                            </div>
                                            <span class="text-primary">3 days left</span>
                                        </div>
                                    </div>
                                    <div class="rounded-3 mb-4" style="background-color: #F3E8FF; padding: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fs-14 fw-semibold">eCommerce Template</h4>
                                            <button class="material-symbols-outlined fs-20 text-body hover border-0 p-0 bg-transparent">edit</button>
                                        </div>
                                        <p>A brief description of the project, its objectives, and its importance to the organization.</p>
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="d-flex">
                                                <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                    <img src="assets/images/user-30.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                    <img src="assets/images/user-31.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                            </div>
                                            <span class="text-primary">7 days left</span>
                                        </div>
                                    </div>
                                    <div class="rounded-3 mb-4" style="background-color: #D8FFC8; padding: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fs-14 fw-semibold">Shopify Theme</h4>
                                            <button class="material-symbols-outlined fs-20 text-body hover border-0 p-0 bg-transparent">edit</button>
                                        </div>
                                        <p>A brief description of the project, its objectives, and its importance to the organization.</p>
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="d-flex">
                                                <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                    <img src="assets/images/user-30.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                    <img src="assets/images/user-31.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                                <a href="my-profile" class="ms-m-15" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                    <img src="assets/images/user-32.jpg" class="wh-34 rounded-circle border border-2 border-color-white" alt="user">
                                                </a>
                                            </div>
                                            <span class="text-primary">10 days left</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                        <span class="py-sm-1 d-block">
                                            <i class="ri-add-line d-none d-sm-inline-block"></i>
                                            <span>Add New Card</span>
                                        </span>
                                    </button>
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
