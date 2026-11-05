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
                                                    <span class="fw-semibold text-primary">My Drive</span>
                                                </div>
                                                <span>6</span>
                                            </a>
                                            <ul class="mb-0 list-unstyled file-subdown">
                                                <li>
                                                    <a href="assets-manager" class="text-decoration-none">assets-manager</a>
                                                </li>
                                                <li>
                                                    <a href="projects" class="text-decoration-none">Projects</a>
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
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 pb-0">
                                    <h3 class="mb-4">My Drive</h3>

                                    <div class="row justify-content-center">
                                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                                            <div class="card bg-primary bg-opacity-10 border-0 rounded-3 mb-4 file-for-dark">
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
                                                        <i class="material-symbols-outlined fs-45 text-primary">folder_open</i>
                                                        <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">assets-manager</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-13 text-secondary">387 Files</span>
                                                        <span class="fs-13 text-secondary">4.5 GB</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                                            <div class="card bg-danger bg-opacity-10 border-0 rounded-3 mb-4 file-for-dark">
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
                                                        <i class="material-symbols-outlined fs-45 text-danger">news</i>
                                                        <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">Projects</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-13 text-secondary">123 Files</span>
                                                        <span class="fs-13 text-secondary">1.4 GB</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                                            <div class="card bg-success bg-opacity-10 border-0 rounded-3 mb-4 file-for-dark">
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
                                                        <i class="material-symbols-outlined fs-45 text-success">folder</i>
                                                        <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">Personal</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-13 text-secondary">435 Files</span>
                                                        <span class="fs-13 text-secondary">5.2 GB</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                                            <div class="card bg-primary-div bg-opacity-10 border-0 rounded-3 mb-4 file-for-dark">
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
                                                        <i class="material-symbols-outlined fs-45 text-primary-div">folder_open</i>
                                                        <span class="fs-15 fw-bold text-secondary ms-2 position-relative top-2">Templates</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-13 text-secondary">431 Files</span>
                                                        <span class="fs-13 text-secondary">1.3 GB</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Recent Files</h3>
                                        <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                            <span class="py-sm-1 d-block">
                                                <i class="ri-add-line d-none d-sm-inline-block"></i>
                                                <span>Add New File</span>
                                            </span>
                                        </button>
                                    </div>

                                    <div class="default-table-area recent-files">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">File Name</th>
                                                        <th scope="col">Owner</th>
                                                        <th scope="col">Listed Date</th>
                                                        <th scope="col">File Type</th>
                                                        <th scope="col">File Size</th>
                                                        <th scope="col">File Items</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <a href="file-manager" class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-28 text-warning">folder</i>
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14 position-relative top-1">Dashboard Design</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>Linda Maddox</td>
                                                        <td>Nov 20, 2024</td>
                                                        <td>.pdf</td>
                                                        <td>1.2 GB</td>
                                                        <td>69</td>
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
                                                        <td>
                                                            <a href="file-manager" class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-28 text-warning">folder</i>
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14 position-relative top-1">Important Documents</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>Juanita Lavigne</td>
                                                        <td>Nov 18, 2024</td>
                                                        <td>.zip</td>
                                                        <td>2.6 GB</td>
                                                        <td>236</td>
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
                                                        <td>
                                                            <a href="file-manager" class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-28 text-warning">folder</i>
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14 position-relative top-1">Product Design</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>Roy Pope</td>
                                                        <td>Nov 17, 2024</td>
                                                        <td>.psd</td>
                                                        <td>3.2 GB</td>
                                                        <td>365</td>
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
                                                        <td>
                                                            <a href="file-manager" class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-28 text-warning">folder</i>
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14 position-relative top-1">Dashboard Design File</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>Cecil Jones</td>
                                                        <td>Nov 15, 2024</td>
                                                        <td>.fig</td>
                                                        <td>1 GB</td>
                                                        <td>25</td>
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
                                                        <td>
                                                            <a href="file-manager" class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-28 text-warning">folder</i>
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14 position-relative top-1">Media Files</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>Trudy Venegas</td>
                                                        <td>Nov 14, 2024</td>
                                                        <td>.jpg</td>
                                                        <td>1.5 GB</td>
                                                        <td>153</td>
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
                                                        <td>
                                                            <a href="file-manager" class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-28 text-warning">folder</i>
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14 position-relative top-1">Graphic Design File</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>Sharilyn Goodall</td>
                                                        <td>Nov 13, 2024</td>
                                                        <td>.png</td>
                                                        <td>1.6 GB</td>
                                                        <td>142</td>
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
                                                        <td>
                                                            <a href="file-manager" class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-28 text-warning">folder</i>
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14 position-relative top-1">Personal Photo</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>Annie Carver</td>
                                                        <td>Nov 09, 2024</td>
                                                        <td>.gif</td>
                                                        <td>1.2 GB</td>
                                                        <td>175</td>
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
                                                        <td>
                                                            <a href="file-manager" class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-28 text-warning">folder</i>
                                                                <div class="ms-2">
                                                                    <h6 class="fw-medium fs-14 position-relative top-1">Audio File</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>Winona Etzel</td>
                                                        <td>Nov 08, 2024</td>
                                                        <td>.mp3</td>
                                                        <td>1.3 GB</td>
                                                        <td>136</td>
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
                                            <span class="fs-12 fw-medium">Showing 8 of 30 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="file-manager" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="file-manager">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="file-manager">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="file-manager">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="file-manager">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="file-manager" aria-label="Next">
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
