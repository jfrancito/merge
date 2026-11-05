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
                        <h3 class="mb-0">User</h3>

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
                                    <span class="fw-medium">User</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                                <form class="position-relative table-src-form me-0">
                                    <input type="text" class="form-control" placeholder="Search here">
                                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                </form>
                                <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                    <span class="py-sm-1 d-block">
                                        <i class="ri-add-line d-none d-sm-inline-block"></i>
                                        <span>Add New User</span>
                                    </span>
                                </button>
                            </div>

                            <div class="default-table-area default-table-width">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input position-relative top-1" type="checkbox" value="" id="flexCheckDefault7">
                                                        <label class="position-relative top-4 ms-1" for="flexCheckDefault7">ID</label>
                                                    </div>
                                                </th>
                                                <th scope="col">User</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Project Access</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#999</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-42.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Sarah Johnson</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>sarah@trezo.com</td>
                                                <td class="text-body">Project Manager</td>
                                                <td class="text-body">
                                                    <span class="text-truncate d-inline-block" style="width: 200px;">Hotel Management System, Python</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
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
                                                <td class="text-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#998</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-43.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Carolyn Barnes</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>carolyn@trezo.com</td>
                                                <td class="text-body">Developer</td>
                                                <td class="text-body">
                                                    <span class="text-truncate d-inline-block" style="width: 200px;">Project Monitoring, Project Alpho</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
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
                                                <td class="text-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#997</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-44.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Donna Miller</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>donna@trezo.com</td>
                                                <td class="text-body">Business Analyst</td>
                                                <td class="text-body">
                                                    <span class="text-truncate d-inline-block" style="width: 200px;">Aegis Accounting Service, Beja Banking</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Deactive</span>
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
                                                <td class="text-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#996</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-45.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Barbara Cross</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>barbara@trezo.com</td>
                                                <td class="text-body">UI/UX Designer</td>
                                                <td class="text-body">
                                                    <span class="text-truncate d-inline-block" style="width: 200px;">Aoriv AI Design, Vaxo App Design</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
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
                                                <td class="text-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#995</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-46.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Rebecca Block</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>rebecca@trezo.com</td>
                                                <td class="text-body">QA Tester</td>
                                                <td class="text-body">
                                                    <span class="text-truncate d-inline-block" style="width: 200px;">Product Development, Trezo Dashboard</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Deactive</span>
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
                                                <td class="text-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#994</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-47.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Ramiro McCarty</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>ramiro@trezo.com</td>
                                                <td class="text-body">Admin</td>
                                                <td class="text-body">
                                                    <span class="text-truncate d-inline-block" style="width: 200px;">Hotel Management System, Python</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
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
                                                <td class="text-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#993</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-48.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Robert Fairweather</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>robert@trezo.com</td>
                                                <td class="text-body">Editor</td>
                                                <td class="text-body">
                                                    <span class="text-truncate d-inline-block" style="width: 200px;">Project Monitoring, Project Alpho</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
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
                                                <td class="text-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#992</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-49.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Marcelino Haddock</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>marcelino@trezo.com</td>
                                                <td class="text-body">Project Manager</td>
                                                <td class="text-body">
                                                    <span class="text-truncate d-inline-block" style="width: 200px;">egis Accounting Service, Beja Banking</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
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
                                                <td class="text-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#991</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-50.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Thomas Wilson</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>thomas@trezo.com</td>
                                                <td class="text-body">UI/UX Designer</td>
                                                <td class="text-body">
                                                    <span class="text-truncate d-inline-block" style="width: 200px;">Aoriv AI Design, Vaxo App Design</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Active</span>
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
                                                <td class="text-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#990</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-51.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Nathaniel Hulsey</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>nathaniel@trezo.com</td>
                                                <td class="text-body">Web Developer</td>
                                                <td class="text-body">
                                                    <span class="text-truncate d-inline-block" style="width: 200px;">Product Development, Trezo Dashboard</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Deactive</span>
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
                                    <span class="fs-12 fw-medium">Showing 10 of 30 Results</span>
    
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination mb-0 justify-content-center">
                                            <li class="page-item">
                                                <a class="page-link icon" href="user" aria-label="Previous">
                                                    <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link active" href="user">1</a></li>
                                            <li class="page-item"><a class="page-link" href="user">2</a></li>
                                            <li class="page-item"><a class="page-link" href="user">3</a></li>
                                            <li class="page-item"><a class="page-link" href="user">4</a></li>
                                            <li class="page-item">
                                                <a class="page-link icon" href="user" aria-label="Next">
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
