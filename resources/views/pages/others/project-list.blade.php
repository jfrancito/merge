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
                        <h3 class="mb-0">Project List</h3>

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
                                    <span class="fw-medium">Project List</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                    <h3 class="mb-0">All Projects</h3>
                                    <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                        <option selected>This Week</option>
                                        <option value="1">This Month</option>
                                        <option value="2">This Year</option>
                                    </select>
                                </div>
                            </div>

                            <div class="default-table-area style-two all-projects">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Project Name</th>
                                                <th scope="col">Client</th>
                                                <th scope="col">Assignees</th>
                                                <th scope="col">Budget</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">End Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">#854</td>
                                                <td>
                                                    <a href="project-overview">Project CyberSphere</a>
                                                </td>
                                                <td>NovaTech Solutions</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pew Smith">
                                                                <img src="assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$4,500</td>
                                                <td class="text-body">25 Mar 2024</td>
                                                <td class="text-body">25 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Finished</span>
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
                                                <td class="text-body">#855</td>
                                                <td>
                                                    <a href="project-overview">Digital Oasis Initiative</a>
                                                </td>
                                                <td>AlphaWave Innovations</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$6,800</td>
                                                <td class="text-body">20 Mar 2024</td>
                                                <td class="text-body">20 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">In Progress</span>
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
                                                <td class="text-body">#856</td>
                                                <td>
                                                    <a href="project-overview">CloudScape Evolution</a>
                                                </td>
                                                <td>InnovateIQ Inc.</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$2,500</td>
                                                <td class="text-body">15 Mar 2024</td>
                                                <td class="text-body">15 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-primary-div bg-opacity-10 text-primary-div p-2 fs-12 fw-normal">Pending</span>
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
                                                <td class="text-body">#857</td>
                                                <td>
                                                    <a href="project-overview">Data Dynamo Drive</a>
                                                </td>
                                                <td>BlueSky Technologies</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pew Smith">
                                                                <img src="assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$7,500</td>
                                                <td class="text-body">10 Mar 2024</td>
                                                <td class="text-body">10 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">In Progress</span>
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
                                                <td class="text-body">#858</td>
                                                <td>
                                                    <a href="project-overview">QuantumLeap Quest</a>
                                                </td>
                                                <td>NexGen Systems</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$3,400</td>
                                                <td class="text-body">05 Mar 2024</td>
                                                <td class="text-body">05 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Finished</span>
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
                                                <td class="text-body">#849</td>
                                                <td>
                                                    <a href="project-overview">Product Development</a>
                                                </td>
                                                <td>NovaTech Solutions</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pew Smith">
                                                                <img src="assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$4,500</td>
                                                <td class="text-body">25 Mar 2024</td>
                                                <td class="text-body">25 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Finished</span>
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
                                                <td class="text-body">#848</td>
                                                <td>
                                                    <a href="project-overview">Python Upgrade</a>
                                                </td>
                                                <td>AlphaWave Innovations</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$6,800</td>
                                                <td class="text-body">20 Mar 2024</td>
                                                <td class="text-body">20 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">In Progress</span>
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
                                                <td class="text-body">#847</td>
                                                <td>
                                                    <a href="project-overview">Project Monitoring</a>
                                                </td>
                                                <td>InnovateIQ Inc.</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$2,500</td>
                                                <td class="text-body">15 Mar 2024</td>
                                                <td class="text-body">15 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-primary-div bg-opacity-10 text-primary-div p-2 fs-12 fw-normal">Pending</span>
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
                                                <td class="text-body">#846</td>
                                                <td>
                                                    <a href="project-overview">Project Alpho</a>
                                                </td>
                                                <td>BlueSky Technologies</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pew Smith">
                                                                <img src="assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$7,500</td>
                                                <td class="text-body">10 Mar 2024</td>
                                                <td class="text-body">10 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">In Progress</span>
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
                                                <td class="text-body">#845</td>
                                                <td>
                                                    <a href="project-overview">Dashboard Design</a>
                                                </td>
                                                <td>NexGen Systems</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$3,400</td>
                                                <td class="text-body">05 Mar 2024</td>
                                                <td class="text-body">05 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Finished</span>
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
    
                                <div class="p-4 pt-lg-4">
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                        <span class="fs-12 fw-medium">Showing 10 of 30 Results</span>
        
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="project-list" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link active" href="project-list">1</a></li>
                                                <li class="page-item"><a class="page-link" href="project-list">2</a></li>
                                                <li class="page-item"><a class="page-link" href="project-list">3</a></li>
                                                <li class="page-item"><a class="page-link" href="project-list">4</a></li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="project-list" aria-label="Next">
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
