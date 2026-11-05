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
                    <div class="row justify-content-center">
                        <div class="col-xl-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4" style="padding-bottom: 0 !important;">
                                    <div class="mb-3 mb-lg-4">
                                        <h3 class="mb-0">Projects Overview</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-sm-6">
                                            <div class="card bg-primary bg-opacity-10 border-primary border-opacity-10 rounded-3 mb-4 stats-box style-three">
                                                <div class="card-body p-4">
                                                    <div class="d-flex align-items-center mb-19">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-symbols-outlined fs-40 text-primary">folder_open</i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <span>Total Projects</span>
                                                            <h3 class="fs-20 mt-1 mb-0">1235</h3>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                                        <span class="fs-12">Projects this month</span>
                                                        <span class="count up fw-medium ms-0">+10%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-sm-6">
                                            <div class="card bg-danger bg-opacity-10 border-danger border-opacity-10 rounded-3 mb-4 stats-box style-three">
                                                <div class="card-body p-4">
                                                    <div class="d-flex align-items-center mb-19">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-symbols-outlined fs-40 text-danger">stacks</i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <span>Active Projects</span>
                                                            <h3 class="fs-20 mt-1 mb-0">425</h3>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                                        <span class="fs-12">Projects this month</span>
                                                        <span class="count up fw-medium ms-0">+5.75%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-sm-6">
                                            <div class="card bg-success bg-opacity-10 border-success border-opacity-10 rounded-3 mb-4 stats-box style-three">
                                                <div class="card-body p-4">
                                                    <div class="d-flex align-items-center mb-19">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-symbols-outlined fs-40 text-success">assignment_turned_in</i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <span>Finished Projects</span>
                                                            <h3 class="fs-20 mt-1 mb-0">135</h3>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                                        <span class="fs-12">Projects this month</span>
                                                        <span class="count down fw-medium ms-0">-15%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-sm-6">
                                            <div class="card bg-primary-div bg-opacity-10 border-primary-div border-opacity-10 rounded-3 mb-4 stats-box style-three">
                                                <div class="card-body p-4">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-symbols-outlined fs-40 text-primary-div">group</i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <span>Team Members</span>
                                                            <h3 class="fs-20 mt-1 mb-0">65+</h3>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                                        <span class="fs-12">Hard Worker</span>
                                                        <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                            <li>
                                                                <a href="my-profile">
                                                                    <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                </a>
                                                            </li>
                                                            <li class="ms-m-15">
                                                                <a href="my-profile">
                                                                    <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                </a>
                                                            </li>
                                                            <li class="ms-m-15">
                                                                <a href="my-profile">
                                                                    <img src="/assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                </a>
                                                            </li>
                                                            <li class="ms-m-15">
                                                                <a href="my-profile">
                                                                    <img src="/assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                </a>
                                                            </li>
                                                            <li class="ms-m-15">
                                                                <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+55</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Projects Roadmap</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>This Week</option>
                                            <option value="1">This Month</option>
                                            <option value="2">This Year</option>
                                        </select>
                                    </div>

                                    <div style="margin-top: -25px; margin-left: -10px; margin-bottom: -25px;">
                                        <div id="projects_roadmap"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xl-7 col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Projects Progress</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-110" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>Last 6 Month</option>
                                            <option value="1">Last 8 Month</option>
                                            <option value="2">Last 12 Month</option>
                                        </select>
                                    </div>

                                    <div style="margin-bottom: -20px; margin-left: -13px; margin-top: -8px;">
                                        <div id="projects_progress"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h3 class="mb-0">My Tasks</h3>
                                            <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                                <option selected>All Tasks</option>
                                                <option value="1">This Month</option>
                                                <option value="2">This Year</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="default-table-area style-two my-tasks">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                <label class="position-relative top-2 ms-2" for="flexCheckDefault">Project Name</label>
                                                            </div>
                                                        </th>
                                                        <th scope="col">Deadline</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                                <label class="fw-medium fs-14 position-relative top-0 ms-2" for="flexCheckDefault2">Web Development</label>
                                                            </div>
                                                        </td>
                                                        <td>10 Jan 2024</td>
                                                        <td>
                                                            <span class="badge bg-info bg-opacity-10 text-info p-2 fs-12 fw-normal">Completed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                                <label class="fw-medium fs-14 position-relative top-0 ms-2" for="flexCheckDefault3">UX/UI Design</label>
                                                            </div>
                                                        </td>
                                                        <td>05 Feb 2024</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">In Progress</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                                <label class="fw-medium fs-14 position-relative top-0 ms-2" for="flexCheckDefault4">React Development</label>
                                                            </div>
                                                        </td>
                                                        <td>28 Mar 2024</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-25 text-danger p-2 fs-12 fw-normal">Cancelled</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                                <label class="fw-medium fs-14 position-relative top-0 ms-2" for="flexCheckDefault6">Python Research</label>
                                                            </div>
                                                        </td>
                                                        <td>09 Mar 2024</td>
                                                        <td>
                                                            <span class="badge bg-warning bg-opacity-10 text-warning p-2 fs-12 fw-normal">Pending</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
            
                                        <div class="p-4 pt-lg-4">
                                            <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                                <span class="fs-12 fw-medium">Items per pages: 5</span>
                
                                                <div class="d-flex align-items-center">
                                                    <span class="fs-12 fw-medium me-2">1 - 5 of 12</span>
                                                    <nav aria-label="Page navigation example">
                                                        <ul class="pagination mb-0 justify-content-center">
                                                            <li class="page-item">
                                                                <a class="page-link icon" href="project-management" aria-label="Previous">
                                                                    <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                                </a>
                                                            </li>
                                                            <li class="page-item">
                                                                <a class="page-link icon" href="project-management" aria-label="Next">
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
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
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
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+04</a>
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
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+07</a>
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
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+15</a>
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
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile">
                                                                <img src="/assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+03</a>
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
                                        <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
        
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="project-management" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link active" href="project-management">1</a></li>
                                                <li class="page-item"><a class="page-link" href="project-management">2</a></li>
                                                <li class="page-item"><a class="page-link" href="project-management">3</a></li>
                                                <li class="page-item"><a class="page-link" href="project-management">4</a></li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="project-management" aria-label="Next">
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

                    <div class="row justify-content-center">
                        <div class="col-xxl-4 col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Project Analysis</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>Last 7 Days</option>
                                            <option value="1">This Month</option>
                                            <option value="2">This Year</option>
                                        </select>
                                    </div>

                                    <div id="project_analysis"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xxl-4 col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0 pb-4">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h3 class="mb-0">Team Members</h3>
                                            <div class="dropdown action-opt">
                                                <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i data-feather="more-horizontal"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:;">
                                                            <i data-feather="clock"></i>
                                                            Today
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:;">
                                                            <i data-feather="pie-chart"></i>
                                                            Last 7 Days
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:;">
                                                            <i data-feather="rotate-cw"></i>
                                                            Last Month
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:;">
                                                            <i data-feather="calendar"></i>
                                                            Last 1 Year
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:;">
                                                            <i data-feather="bar-chart"></i>
                                                            All Time
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:;">
                                                            <i data-feather="eye"></i>
                                                            View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:;">
                                                            <i data-feather="trash"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="default-table-area style-two team-members">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Tasks</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="border-0 py-3 pb-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-20.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Olivia Clark</h6>
                                                                    <span class="fs-12">Head of HR</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="border-0 py-3 pb-0">55</td>
                                                        <td class="border-0 py-3 pb-0">
                                                            <div class="progress bg-opacity-10 bg-primary" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                                                <div class="progress-bar rounded-pill" style="width: 50%; height: 5px;">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-0 py-3 pb-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-21.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Alexander Garcia</h6>
                                                                    <span class="fs-12">Product Manager</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="border-0 py-3 pb-0">125</td>
                                                        <td class="border-0 py-3 pb-0">
                                                            <div class="progress bg-opacity-10 bg-success" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                                                <div class="progress-bar bg-success rounded-pill" style="width: 50%; height: 5px;">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-0 py-3 pb-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-22.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Chloe Lewis</h6>
                                                                    <span class="fs-12">UX/UI Designer</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="border-0 py-3 pb-0">78</td>
                                                        <td class="border-0 py-3 pb-0">
                                                            <div class="progress bg-opacity-10 bg-primary-div" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                                                <div class="progress-bar rounded-pill bg-primary-div" style="width: 50%; height: 5px;">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-0 py-3 pb-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-23.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Ava Turner</h6>
                                                                    <span class="fs-12">Python Developer</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="border-0 py-3 pb-0">95</td>
                                                        <td class="border-0 py-3 pb-0">
                                                            <div class="progress bg-opacity-10 bg-danger" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                                                <div class="progress-bar bg-danger rounded-pill" style="width: 50%; height: 5px;">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-0 py-3 pb-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-24.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Ryan Flores</h6>
                                                                    <span class="fs-12">WP Developer</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="border-0 py-3 pb-0">134</td>
                                                        <td class="border-0 py-3 pb-0">
                                                            <div class="progress bg-opacity-10 bg-primary" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                                                <div class="progress-bar rounded-pill" style="width: 50%; height: 5px;">
                                                                </div>
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

                        <div class="col-xxl-4 col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="mb-3 mb-lg-4">
                                        <h3 class="mb-0">Working Schedule</h3>
                                    </div>
                                    <div class="calendar-wraps">
                                        <div id="calendari"></div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3 mt-sm-0 mb-3">
                                        <span class="fw-medium">Upcoming Events:</span>
                                        <div class="swiper-pagination1 text-end" style="width: 100px;"></div>
                                    </div>

                                    <div class="swiper upcoming-events-slide">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide cursor">
                                                <div class="position-relative d-flex">
                                                    <span class="wh-11 bg-primary rounded-1 d-inline-block position-relative top-1"></span>
                                                    <div>
                                                        <h4 class="fs-12 fw-semibold text-secondary mb-0 ms-1"> Pythons Unleashed: A Development Expedition</h4>
                                                        <p class="fs-12"><span class="text-primary">April 15, 2024</span> -  12.00 PM - 6.00 PM</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide cursor">
                                                <div class="position-relative d-flex">
                                                    <span class="wh-11 bg-primary rounded-1 d-inline-block position-relative top-1"></span>
                                                    <div>
                                                        <h4 class="fs-12 fw-semibold text-secondary mb-0 ms-1"> Big Data Analytics</h4>
                                                        <p class="fs-12"><span class="text-primary">15 Mar 2024</span> -  01.00 PM - 7.00 PM</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide cursor">
                                                <div class="position-relative d-flex">
                                                    <span class="wh-11 bg-primary rounded-1 d-inline-block position-relative top-1"></span>
                                                    <div>
                                                        <h4 class="fs-12 fw-semibold text-secondary mb-0 ms-1">Introduction to Blockchain</h4>
                                                        <p class="fs-12"><span class="text-primary">10 Mar 2024</span> -  02.00 PM - 9.00 PM</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h3 class="mb-0">To Do List</h3>
                                            <form class="position-relative table-src-form me-0">
                                                <input type="text" class="form-control" placeholder="Search here">
                                                <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                            </form>
                                        </div>
                                    </div>
        
                                    <div class="default-table-area style-two to-do-list padding-style">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault7">
                                                                <label class="position-relative top-2 ms-1" for="flexCheckDefault7">ID</label>
                                                            </div>
                                                        </th>
                                                        <th scope="col">Task Title</th>
                                                        <th scope="col">Assigned To</th>
                                                        <th scope="col">Due Date</th>
                                                        <th scope="col">Priority</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-body">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                                <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#854</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="project-overview" class="text-body">Network Infrastructure</a>
                                                        </td>
                                                        <td>Oliver Clark</td>
                                                        <td class="text-body">30 Apr 2024</td>
                                                        <td class="text-body">High</td>
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
                                                        <td class="text-body">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault8">
                                                                <label class="position-relative top-2 ms-1" for="flexCheckDefault8">#853</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="project-overview" class="text-body">Cloud Migration</a>
                                                        </td>
                                                        <td>Ethan Baker</td>
                                                        <td class="text-body">25 Apr 2024</td>
                                                        <td class="text-body">Low</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Pending</span>
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
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault9">
                                                                <label class="position-relative top-2 ms-1" for="flexCheckDefault9">#852</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="project-overview" class="text-body">Website Revamp</a>
                                                        </td>
                                                        <td>Sophia Carter</td>
                                                        <td class="text-body">20 Apr 2024</td>
                                                        <td class="text-body">Medium</td>
                                                        <td>
                                                            <span class="badge bg-primary-div bg-opacity-10 text-primary-div p-2 fs-12 fw-normal">In Progress</span>
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
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault10">
                                                                <label class="position-relative top-2 ms-1" for="flexCheckDefault10">#851</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="project-overview" class="text-body">Mobile Application</a>
                                                        </td>
                                                        <td>Ava Cooper</td>
                                                        <td class="text-body">15 Apr 2024</td>
                                                        <td class="text-body">High</td>
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
                                                        <td class="text-body">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault11">
                                                                <label class="position-relative top-2 ms-1" for="flexCheckDefault11">#850</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="project-overview" class="text-body">System Deployment</a>
                                                        </td>
                                                        <td>Isabella Evans</td>
                                                        <td class="text-body">10 Apr 2024</td>
                                                        <td class="text-body">Low</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-25 text-danger p-2 fs-12 fw-normal">Cancelled</span>
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
            
                                        <div class="p-4 text-end">
                                            <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                                <span class="py-sm-1 d-block">
                                                    <i class="ri-add-line"></i>
                                                    <span>Add New Task</span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Tasks Overview</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>Last 7 Days</option>
                                            <option value="1">This Month</option>
                                            <option value="2">This Year</option>
                                        </select>
                                    </div>

                                    <div id="tasks_overview4"></div>
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
