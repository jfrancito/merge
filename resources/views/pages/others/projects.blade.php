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
                        <h3 class="mb-0">File Manager</h3>

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
                                    <span class="fw-medium">File Manager</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Projects</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xl-3 col-lg-3 col-md-4">
                            <div class="card bg-white border-0 rounded-3 rounded-bottom-0">
                                <div class="card-body p-4">
                                    <form class="position-relative default-src-form mb-4 pb-1">
                                        <input type="text" class="form-control rounded-1" placeholder="Search">
                                        <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y fs-18">search</i>
                                    </form>
                                    
                                    <ul class="ps-0 mb-0 list-unstyled">
                                        <li class="mb-4">
                                            <a href="file-manager" class="d-flex align-items-center text-decoration-none justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <i class="material-symbols-outlined fs-18 position-relative top-1 me-2 text-primary">inbox</i>
                                                    <span class="fw-semibold">My Drive</span>
                                                </div>
                                                <span>6</span>
                                            </a>
                                            <ul class="mb-0 list-unstyled file-subdown">
                                                <li>
                                                    <a href="assets-manager" class="text-decoration-none">Assets</a>
                                                </li>
                                                <li>
                                                    <a href="projects" class="text-decoration-none text-primary">Projects</a>
                                                </li>
                                                <li>
                                                    <a href="personal" class="text-decoration-none">Personal</a>
                                                </li>
                                                <li>
                                                    <a href="applications" class="text-decoration-none">Applications</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="mb-4">
                                            <a href="documents" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2 text-success">description</i>
                                                <span class="fw-medium">Documents</span> 
                                            </a>
                                        </li>
                                        <li class="mb-4">
                                            <a href="media" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2 text-info">perm_media</i>
                                                <span class="fw-medium">Media</span> 
                                            </a>
                                        </li>
                                        <li class="mb-4">
                                            <a href="recents" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2 text-primary-div">schedule</i>
                                                <span class="fw-medium">Recents</span> 
                                            </a>
                                        </li>
                                        <li class="mb-4">
                                            <a href="drive-important" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2 text-warning">grade</i>
                                                <span class="fw-medium">Important</span> 
                                            </a>
                                        </li>
                                        <li class="mb-4">
                                            <a href="drive-spam" class="d-flex align-items-center text-decoration-none justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <i class="material-symbols-outlined fs-18 position-relative top-1 me-2 text-primary">report_gmailerrorred</i>
                                                    <span class="fw-medium">Spam</span> 
                                                </div>
                                                <span>10</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="drive-trash" class="d-flex align-items-center text-decoration-none justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <i class="material-symbols-outlined fs-18 position-relative top-1 me-2 text-danger">delete</i>
                                                    <span class="fw-medium">Trash</span> 
                                                </div>
                                                <span>15</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card bg-white border-0 rounded-3 rounded-top-0 border-top mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-15">Storage Status</h4>
                                    <span class="fs-13 d-block mb-2">% 50 GB used of 100 GB</span>
                                    <div class="progress bg-primary bg-opacity-10" style="height: 4px;" role="progressbar" aria-label="Primary example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-primary" style="width: 50%; height: 4px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-8">
                            <div class="row justify-content-center">
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input p-0" type="checkbox" value="" id="flexCheckDefault1">
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
                                            <div class="d-flex align-items-center py-4 my-3">
                                                <img src="assets/images/png.png" alt="png">
                                                <span class="fs-15 fw-bold text-secondary ms-2">ET Template</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-13 text-secondary">159  Files</span>
                                                <span class="fs-13 text-secondary">4.5 GB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input p-0" type="checkbox" value="" id="flexCheckDefault2">
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
                                            <div class="d-flex align-items-center py-4 my-3">
                                                <img src="assets/images/jpg.png" alt="jpg">
                                                <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">React Template</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-13 text-secondary">522  Files</span>
                                                <span class="fs-13 text-secondary">5.5 GB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input p-0" type="checkbox" value="" id="flexCheckDefault3">
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
                                            <div class="d-flex align-items-center py-4 my-3">
                                                <img src="assets/images/txt.png" alt="txt">
                                                <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">Material UI</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-13 text-secondary">995  Files</span>
                                                <span class="fs-13 text-secondary">7.5 GB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input p-0" type="checkbox" value="" id="flexCheckDefault4">
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
                                            <div class="d-flex align-items-center py-4 my-3">
                                                <img src="assets/images/pdf.png" alt="txt">
                                                <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">WP Themes</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-13 text-secondary">39  Files</span>
                                                <span class="fs-13 text-secondary">3.8 GB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input p-0" type="checkbox" value="" id="flexCheckDefault5">
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
                                            <div class="d-flex align-items-center py-4 my-3">
                                                <img src="assets/images/xl4.png" alt="xl4">
                                                <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">Personal Photos</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-13 text-secondary">159  Files</span>
                                                <span class="fs-13 text-secondary">4.5 GB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input p-0" type="checkbox" value="" id="flexCheckDefault6">
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
                                            <div class="d-flex align-items-center py-4 my-3">
                                                <img src="assets/images/doc.png" alt="doc">
                                                <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">Mobile Apps</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-13 text-secondary">357  Files</span>
                                                <span class="fs-13 text-secondary">8.5 GB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input p-0" type="checkbox" value="" id="flexCheckDefault7">
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
                                            <div class="d-flex align-items-center py-4 my-3">
                                                <img src="assets/images/png.png" alt="png">
                                                <span class="fs-15 fw-bold text-secondary ms-2">Important Files</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-13 text-secondary">159  Files</span>
                                                <span class="fs-13 text-secondary">4.5 GB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input p-0" type="checkbox" value="" id="flexCheckDefault8">
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
                                            <div class="d-flex align-items-center py-4 my-3">
                                                <img src="assets/images/jpg.png" alt="jpg">
                                                <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">Angular Template</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-13 text-secondary">522  Files</span>
                                                <span class="fs-13 text-secondary">5.5 GB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input p-0" type="checkbox" value="" id="flexCheckDefault9">
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
                                            <div class="d-flex align-items-center py-4 my-3">
                                                <img src="assets/images/txt.png" alt="txt">
                                                <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">Projects</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-13 text-secondary">995  Files</span>
                                                <span class="fs-13 text-secondary">7.5 GB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input p-0" type="checkbox" value="" id="flexCheckDefault10">
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
                                            <div class="d-flex align-items-center py-4 my-3">
                                                <img src="assets/images/pdf.png" alt="txt">
                                                <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">Documents</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-13 text-secondary">39  Files</span>
                                                <span class="fs-13 text-secondary">3.8 GB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input p-0" type="checkbox" value="" id="flexCheckDefault11">
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
                                            <div class="d-flex align-items-center py-4 my-3">
                                                <img src="assets/images/xl4.png" alt="xl4">
                                                <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">Media</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-13 text-secondary">75  Files</span>
                                                <span class="fs-13 text-secondary">2.2 GB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input p-0" type="checkbox" value="" id="flexCheckDefault12">
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
                                            <div class="d-flex align-items-center py-4 my-3">
                                                <img src="assets/images/jpg.png" alt="jpg">
                                                <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">Applications</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-13 text-secondary">357  Files</span>
                                                <span class="fs-13 text-secondary">8.5 GB</span>
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
