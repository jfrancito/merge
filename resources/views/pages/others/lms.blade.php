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
                        <div class="col-xxl-6">
                            <div class="card bg-primary border-0 rounded-3 welcome-box style-two mb-4 position-relative">
                                <div class="card-body py-38 px-4">
                                    <div class="mb-5">
                                        <h3 class="text-white fw-semibold">Welcome Back, <span class="text-danger-div">Olivia!</span></h3>
                                        <p class="text-light">Your progress this week is Awesome.</p>
                                    </div>

                                    <div class="d-flex align-items-center flex-wrap gap-4 gap-xxl-5">
                                        <div class="d-flex align-items-center welcome-status-item style-two">
                                            <div class="flex-shrink-0">
                                                <i class="material-symbols-outlined">airplay</i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="text-white fw-semibold mb-0 fs-16">75h</h5>
                                                <p class="text-light">Hours Spent</p>
                                            </div>
                                        </div>
                                    
                                        <div class="d-flex align-items-center welcome-status-item style-two">
                                            <div class="flex-shrink-0">
                                                <i class="material-symbols-outlined icon-bg two">local_library</i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="text-white fw-semibold mb-0 fs-16">15</h5>
                                                <p class="text-light">Course Completed</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <img src="/assets/images/welcome-2.gif" class="welcome-2 d-none d-sm-block" alt="welcome">
                            </div>
                        </div>
                        <div class="col-xxl-6">
                            <div class="row justify-content-center">
                                <div class="col-lg-4 col-sm-4">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <span>Total Courses</span>
                                            <h3 class="mb-0 fs-20">45.6k</h3>
                                            <div class="py-3">
                                                <div class="wh-77 lh-97 text-center m-auto bg-primary bg-opacity-25 rounded-circle">
                                                    <i class="material-symbols-outlined fs-32 text-primary">auto_stories</i>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fs-12">This Month</span>
                                                <i class="material-symbols-outlined text-success">timeline</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <span>Total Enrolled</span>
                                            <h3 class="mb-0 fs-20">75k+</h3>
                                            <div class="py-3">
                                                <div class="wh-77 lh-97 text-center m-auto bg-primary-div bg-opacity-25 rounded-circle">
                                                    <i class="material-symbols-outlined fs-32 text-primary-div">collections_bookmark</i>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fs-12">This Month</span>
                                                <i class="material-symbols-outlined text-danger">trending_down</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <span>Total Mentors</span>
                                            <h3 class="mb-0 fs-20">1.5k</h3>
                                            <div class="py-3">
                                                <div class="wh-77 lh-97 text-center m-auto bg-danger bg-opacity-25 rounded-circle">
                                                    <i class="material-symbols-outlined fs-32 text-danger">group</i>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fs-12">This Month</span>
                                                <i class="material-symbols-outlined text-success">trending_up</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xxl-7 col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Student’s Interested Topics</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-110" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>Last 6 Month</option>
                                            <option value="1">Last 8 Month</option>
                                            <option value="2">Last 12 Month</option>
                                        </select>
                                    </div>

                                    <div id="student_interested_topics"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-5 col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h3 class="mb-0">Top Instructors</h3>
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

                                    <div class="default-table-area style-two top-instructors">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Courses</th>
                                                        <th scope="col">Ratings</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-25.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Olivia Clark</h6>
                                                                    <span class="fs-12 text-body">Big Data</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>55</td>
                                                        <td>
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
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-26.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Ava Turner</h6>
                                                                    <span class="fs-12 text-body">UX/UI</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>120</td>
                                                        <td>
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
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-27.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Lucas Morgan</h6>
                                                                    <span class="fs-12 text-body">Developer</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>86</td>
                                                        <td>
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
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-28.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Isabella Cooper</h6>
                                                                    <span class="fs-12 text-body">Designer</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>75</td>
                                                        <td>
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
                                                                    <i class="ri-star-half-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-line text-rating-color fs-16"></i>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                            <span class="fs-12 fw-medium">Items per pages: 5</span>
            
                                            <div class="d-flex align-items-center">
                                                <span class="fs-12 fw-medium me-2">1 - 5 of 12</span>
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination mb-0 justify-content-center">
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="lms" aria-label="Previous">
                                                                <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="lms" aria-label="Next">
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
                    <div class="row justify-content-center">
                        <div class="col-xxl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h3 class="mb-0">Student’s Progress</h3>
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

                                    <div class="default-table-area style-two top-instructors">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Course Name</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <h6 class="mb-0 fs-14 fw-medium">Olivia Clark</h6>
                                                            </a>
                                                        </td>
                                                        <td class="text-body">Web Design</td>
                                                        <td>
                                                            <div class="progress bg-opacity-10 bg-primary" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                                                <div class="progress-bar rounded-pill" style="width: 50%; height: 5px;">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <h6 class="mb-0 fs-14 fw-medium">Alexander Garcia</h6>
                                                            </a>
                                                        </td>
                                                        <td class="text-body">Python Dev.</td>
                                                        <td>
                                                            <div class="progress bg-opacity-10 bg-success" role="progressbar" aria-label="Example with label" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                                                <div class="progress-bar bg-success rounded-pill" style="width: 80%; height: 5px;">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <h6 class="mb-0 fs-14 fw-medium">Chloe Lewis</h6>
                                                            </a>
                                                        </td>
                                                        <td class="text-body">Front-end</td>
                                                        <td>
                                                            <div class="progress bg-opacity-10 bg-primary-div" role="progressbar" aria-label="Example with label" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                                                <div class="progress-bar rounded-pill bg-primary-div" style="width: 30%; height: 5px;">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <h6 class="mb-0 fs-14 fw-medium">Ava Turner</h6>
                                                            </a>
                                                        </td>
                                                        <td class="text-body">Back-end</td>
                                                        <td>
                                                            <div class="progress bg-opacity-10 bg-danger" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                                                <div class="progress-bar bg-danger rounded-pill" style="width: 50%; height: 5px;">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <h6 class="mb-0 fs-14 fw-medium">Ryan Flores</h6>
                                                            </a>
                                                        </td>
                                                        <td class="text-body">Data Analytics</td>
                                                        <td>
                                                            <div class="progress bg-opacity-10 bg-primary" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                                                <div class="progress-bar rounded-pill" style="width: 50%; height: 5px;">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <h6 class="mb-0 fs-14 fw-medium">John Doe</h6>
                                                            </a>
                                                        </td>
                                                        <td class="text-body">Plugin Dev.</td>
                                                        <td>
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

                                    <div class="p-4">
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                            <span class="fs-12 fw-medium">Items per pages: 5</span>
            
                                            <div class="d-flex align-items-center">
                                                <span class="fs-12 fw-medium me-2">1 - 5 of 12</span>
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination mb-0 justify-content-center">
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="lms" aria-label="Previous">
                                                                <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="lms" aria-label="Next">
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
                        <div class="col-xxl-4 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h3 class="mb-0">Group Lessons</h3>
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

                                    <div class="default-table-area style-two top-instructors">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="pt-1">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <div class="d-flex">
                                                                        <a href="my-profile">
                                                                            <img src="/assets/images/user-30.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                        <a href="my-profile" class="ms-m-20">
                                                                            <img src="/assets/images/user-31.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                        <a href="my-profile" class="ms-m-20">
                                                                            <img src="/assets/images/user-32.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <a href="project-list" class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Digital Marketing</h6>
                                                                    <span class="fs-12 text-body">15 March, 2024</span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td class="text-end pt-1">
                                                            <a href="project-list" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <div class="d-flex">
                                                                        <a href="my-profile">
                                                                            <img src="/assets/images/user-33.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                        <a href="my-profile" class="ms-m-20">
                                                                            <img src="/assets/images/user-34.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                        <a href="my-profile" class="ms-m-20">
                                                                            <img src="/assets/images/user-35.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <a href="project-list" class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Web Development</h6>
                                                                    <span class="fs-12 text-body">10 March, 2024</span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="project-list" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <div class="d-flex">
                                                                        <a href="my-profile">
                                                                            <img src="/assets/images/user-36.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                        <a href="my-profile" class="ms-m-20">
                                                                            <img src="/assets/images/user-37.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                        <a href="my-profile" class="ms-m-20">
                                                                            <img src="/assets/images/user-38.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <a href="project-list" class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">UX/UI Design</h6>
                                                                    <span class="fs-12 text-body">05 March, 2024</span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="project-list" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <div class="d-flex">
                                                                        <a href="my-profile">
                                                                            <img src="/assets/images/user-39.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                        <a href="my-profile" class="ms-m-20">
                                                                            <img src="/assets/images/user-40.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                        <a href="my-profile" class="ms-m-20">
                                                                            <img src="/assets/images/user-41.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <a href="project-list" class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Content Writer</h6>
                                                                    <span class="fs-12 text-body">02 March, 2024</span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="project-list" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <div class="d-flex">
                                                                        <a href="my-profile">
                                                                            <img src="/assets/images/user-25.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                        <a href="my-profile" class="ms-m-20">
                                                                            <img src="/assets/images/user-28.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                        <a href="my-profile" class="ms-m-20">
                                                                            <img src="/assets/images/user-31.jpg" class="wh-44 rounded-circle border border-2 border-color-white" alt="user">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <a href="project-list" class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Wordpress</h6>
                                                                    <span class="fs-12 text-body">07 March, 2024</span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="project-list" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                            <span class="fs-12 fw-medium">Items per pages: 5</span>
            
                                            <div class="d-flex align-items-center">
                                                <span class="fs-12 fw-medium me-2">1 - 5 of 12</span>
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination mb-0 justify-content-center">
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="lms" aria-label="Previous">
                                                                <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="lms" aria-label="Next">
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
                        <div class="col-xxl-4 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Enrolled by Countries</h3>

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
                                    <div class="text-center pt-4 mb-4 pb-1">
                                        <img src="/assets/images/map.svg" alt="map">
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled sales_by_locations mt-4">
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/usa.svg" class="wh-30 rounded-circle" alt="usa">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">United States</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: 85%">
                                                        <span class="count fw-medium text-body">85%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/germany.svg" class="wh-30 rounded-circle" alt="germany">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">Germany</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: 75%">
                                                        <span class="count fw-medium text-body">75%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/united-kingdom.svg" class="wh-30 rounded-circle" alt="united-kingdom">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">United Kingdom</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: 40%">
                                                        <span class="count fw-medium text-body">40%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/canada.svg" class="wh-30 rounded-circle" alt="canada">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">Canada</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: 10%">
                                                        <span class="count fw-medium text-body">10%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                    <h3 class="mb-0">Courses</h3>
                                    <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                        <option selected>All Courses</option>
                                        <option value="1">UI/UX</option>
                                        <option value="2">Wordpress</option>
                                    </select>
                                </div>
                            </div>

                            <div class="default-table-area style-two all-projects">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Course Name</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Instructor</th>
                                                <th scope="col">Enrolled</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">End Date</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">#854</td>
                                                <td>
                                                    <a href="course-details">Cybersecurity Awareness</a>
                                                </td>
                                                <td>Technology</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-42.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Oliver Khan</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">180</td>
                                                <td class="text-body">25 Mar 2024</td>
                                                <td class="text-body">25 Apr 2024</td>
                                                <td>$49.99</td>
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
                                                <td class="text-body">#853</td>
                                                <td>
                                                    <a href="course-details">Python Programming</a>
                                                </td>
                                                <td>Science</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-43.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Ava Cooper</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">250</td>
                                                <td class="text-body">20 Mar 2024</td>
                                                <td class="text-body">20 Apr 2024</td>
                                                <td>$30.99</td>
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
                                                <td class="text-body">#852</td>
                                                <td>
                                                    <a href="course-details">Big Data Analytics</a>
                                                </td>
                                                <td>Health and Wellness</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-44.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Isabella Evans</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">320</td>
                                                <td class="text-body">15 Mar 2024</td>
                                                <td class="text-body">15 Apr 2024</td>
                                                <td>$69.99</td>
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
                                                <td class="text-body">#851</td>
                                                <td>
                                                    <a href="course-details">Introduction to Blockchain</a>
                                                </td>
                                                <td>Education</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-45.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Mia Hughes</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">135</td>
                                                <td class="text-body">10 Mar 2024</td>
                                                <td class="text-body">10 Apr 2024</td>
                                                <td>$99.99</td>
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
                                                <td class="text-body">#850</td>
                                                <td>
                                                    <a href="course-details">Network Administration</a>
                                                </td>
                                                <td>Food and Cooking</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-46.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Noah Mitchell</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">460</td>
                                                <td class="text-body">05 Mar 2024</td>
                                                <td class="text-body">05 Apr 2024</td>
                                                <td>$79.99</td>
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
                                                    <a href="course-details">Artificial Intelligence</a>
                                                </td>
                                                <td>Lifestyle and Fashion</td>
                                                <td>
                                                    <a href="instructors" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-47.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Sophia Carter</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">515</td>
                                                <td class="text-body">10 Mar 2024</td>
                                                <td class="text-body">15 Apr 2024</td>
                                                <td>$86.99</td>
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
                                        <span class="fs-12 fw-medium">Showing 6 of 30 Results</span>
        
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="lms" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link active" href="lms">1</a></li>
                                                <li class="page-item"><a class="page-link" href="lms">2</a></li>
                                                <li class="page-item"><a class="page-link" href="lms">3</a></li>
                                                <li class="page-item"><a class="page-link" href="lms">4</a></li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="lms" aria-label="Next">
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
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4 overflow-hidden">
                                <div class="card-body p-0">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                            <h3 class="mb-0">Courses Sales</h3>
                                            <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                                <option selected>This Month</option>
                                                <option value="1">UI/UX</option>
                                                <option value="2">Wordpress</option>
                                            </select>
                                        </div>

                                        <div class="stats-box pt-4 position-relative" style="height: 232px;">
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                <h3 class="fs-20 mb-0 me-4">$57.2k</h3>
                                                <span class="count up fw-medium ms-0">+10%</span>
                                            </div>
                                        </div>

                                        <div style="left: 0; right: 0; bottom: -41px; position: absolute; margin-left: -12px; margin-right: -10px;">
                                            <div id="courses_sales"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4 overflow-hidden">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Time Spent</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>This Week</option>
                                            <option value="1">This Month</option>
                                            <option value="2">This Year</option>
                                        </select>
                                    </div>

                                    <div style="margin-top: -20px; margin-left: -12px; margin-bottom: -20px;">
                                        <div id="time_spent"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="swiper courses-slide">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="card bg-card-bg-c bg-primary border-0 rounded-3 mb-4 overflow-hidden position-relative">
                                            <div class="card-body p-4">
                                                <h3 class="mb-0 text-card-text-c fw-semibold">Our Top Courses</h3>

                                                <div class="d-flex align-items-center py-3">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/courses-1.jpg" class="wh-130-113 rounded-3" alt="courses">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <span class="d-block mb-2 text-white">Python Programming</span>
                                                        <h3 class="mb-0 fs-20 text-white">$35.99</h3>
                                                    </div>
                                                </div>

                                                <h3 class="mb-2 fs-20 text-white">Course content</h3>
                                                <ul class="ps-0 mb-3 list-unstyled d-flex flex-wrap gap-2 gap-sm-0 list-dot">
                                                    <li class="text-white">10 sections</li>
                                                    <li class="text-white">45 lectures</li>
                                                    <li class="text-white">25h 50m</li>
                                                </ul>

                                                <div class="text-end">
                                                    <a href="course-details" class="btn border-color-white text-white py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg">
                                                        <span class="py-sm-1 d-block">
                                                            <i class="ri-add-line"></i>
                                                            <span>View Details</span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                            <img src="/assets/images/shape.png" class="position-absolute top-0 end-0" alt="shape">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card bg-card-bg-c bg-primary border-0 rounded-3 mb-4 overflow-hidden position-relative">
                                            <div class="card-body p-4">
                                                <h3 class="mb-0 text-card-text-c fw-semibold">Our Top Courses</h3>

                                                <div class="d-flex align-items-center py-3">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/event-5.jpg" class="wh-130-113 rounded-3" alt="courses">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <span class="d-block mb-2 text-white">Basic Python</span>
                                                        <h3 class="mb-0 fs-20 text-white">$49.99</h3>
                                                    </div>
                                                </div>

                                                <h3 class="mb-2 fs-20 text-white">Course content</h3>
                                                <ul class="ps-0 mb-3 list-unstyled d-flex flex-wrap gap-2 gap-sm-0 list-dot">
                                                    <li class="text-white">12 sections</li>
                                                    <li class="text-white">46 lectures</li>
                                                    <li class="text-white">30h 50m</li>
                                                </ul>

                                                <div class="text-end">
                                                    <a href="course-details" class="btn border-color-white text-white py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg">
                                                        <span class="py-sm-1 d-block">
                                                            <i class="ri-add-line"></i>
                                                            <span>View Details</span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                            <img src="/assets/images/shape.png" class="position-absolute top-0 end-0" alt="shape">
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-pagination2 text-center"></div>
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
