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
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <div class="mb-3 mb-md-4">
                                <h3 class="fs-20 fw-semibold mb-1">School Overview Dashboard</h3>
                                <p style="line-height: 1.4;">Manage Students, Teachers, and School Data Seamlessly!</p>
                            </div>
                        </div>
                        <div class="col-md-5 text-md-end mb-4">
                            <div class="d-inline-block rounded-1" style="border: 1px solid #DDE4FF; background-color: #ECF0FF; padding: 1px 10px;">
                                <i class="ri-calendar-line text-primary"></i>
                                <span id="digital_date" class="text-primary ms-1"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-8">
                            <div class="card-group custom-shadow mb-4 rounded-3">
                                <div class="card border-border-color bg-white rounded-start-3">
                                    <div class="card-body custom-padding-30 mx-xl-2">
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/total-students.svg" alt="total-students">
                                            </div>
                                            <div class="flex-grow-1 ms-md-3 ms-1">
                                                <span class="d-block mb-1">Total Students</span>
                                                <h3 class="fs-20 fw-semibold mb-0">12,560</h3>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="ri-arrow-right-up-line d-inline-block text-center rounded-1 fs-18 text-success-50" style="width: 26px; height: 26px; line-height: 26px; background-color: #D8FFC8;"></i>
                                            <p class="ms-2"><span class="text-secondary fw-medium">+12%</span> last year</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border-border-color bg-white">
                                    <div class="card-body custom-padding-30 mx-xl-2">
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/total-teachers.svg" alt="total-students">
                                            </div>
                                            <div class="flex-grow-1 ms-md-3 ms-1">
                                                <span class="d-block mb-1">Total Teachers</span>
                                                <h3 class="fs-20 fw-semibold mb-0">780</h3>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="ri-arrow-right-down-line d-inline-block text-center rounded-1 fs-18 text-danger-50" style="width: 26px; height: 26px; line-height: 26px; background-color: #FFE1DD;"></i>
                                            <p class="ms-2"><span class="text-secondary fw-medium">-10%</span> last year</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border-border-color bg-white rounded-end-3">
                                    <div class="card-body custom-padding-30 mx-xl-2">
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/attendance-today.svg" alt="attendance-today">
                                            </div>
                                            <div class="flex-grow-1 ms-md-3 ms-1">
                                                <span class="d-block mb-1">Attendance Today</span>
                                                <h3 class="fs-20 fw-semibold mb-0">1,425</h3>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="ri-arrow-right-up-line d-inline-block text-center rounded-1 fs-18 text-success-50" style="width: 26px; height: 26px; line-height: 26px; background-color: #D8FFC8;"></i>
                                            <p class="ms-2"><span class="text-secondary fw-medium">+25%</span> last year</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="custom-padding-30">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-1 pb-3">
                                        <h3 class="mb-0 fw-semibold">Upcoming Events</h3>
                                        <div class="swiper-pagination-upcoming-events text-end" style="width: 200px;"></div>
                                    </div>

                                    <div class="swiper upcoming-events-slide-two">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="bg-body-bg p-3 rounded-3" style="margin-top: 2px;">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-1">
                                                        <span class="text-secondary fs-16 fw-medium">Science Fair</span>
                                                        <span>November 25, 2024</span>
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between">
                                                        <span class="text-secondary d-flex align-items-center">
                                                            <i class="ri-time-line fs-16 me-2"></i>
                                                            <span>9:00 AM - 3:00 PM</span>
                                                        </span>
                                                        <span class="text-secondary d-flex align-items-center">
                                                            <i class="ri-map-pin-line fs-16 me-2"></i>
                                                            <span>Auditorium</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="bg-body-bg p-3 rounded-3" style="margin-top: 2px;">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-1">
                                                        <span class="text-secondary fs-16 fw-medium">Science Fair</span>
                                                        <span>November 28, 2024</span>
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between">
                                                        <span class="text-secondary d-flex align-items-center">
                                                            <i class="ri-time-line fs-16 me-2"></i>
                                                            <span>9:00 AM - 3:00 PM</span>
                                                        </span>
                                                        <span class="text-secondary d-flex align-items-center">
                                                            <i class="ri-map-pin-line fs-16 me-2"></i>
                                                            <span>California</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="bg-body-bg p-3 rounded-3" style="margin-top: 2px;">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-1">
                                                        <span class="text-secondary fs-16 fw-medium">Science Fair</span>
                                                        <span>November 25, 2024</span>
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between">
                                                        <span class="text-secondary d-flex align-items-center">
                                                            <i class="ri-time-line fs-16 me-2"></i>
                                                            <span>9:00 AM - 3:00 PM</span>
                                                        </span>
                                                        <span class="text-secondary d-flex align-items-center">
                                                            <i class="ri-map-pin-line fs-16 me-2"></i>
                                                            <span>Auditorium</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="bg-body-bg p-3 rounded-3" style="margin-top: 2px;">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between mb-1">
                                                        <span class="text-secondary fs-16 fw-medium">Science Fair</span>
                                                        <span>November 28, 2024</span>
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between">
                                                        <span class="text-secondary d-flex align-items-center">
                                                            <i class="ri-time-line fs-16 me-2"></i>
                                                            <span>9:00 AM - 3:00 PM</span>
                                                        </span>
                                                        <span class="text-secondary d-flex align-items-center">
                                                            <i class="ri-map-pin-line fs-16 me-2"></i>
                                                            <span>California</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-7">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="custom-padding-30">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-4">
                                        <h3 class="mb-0">Attendance Analytics</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color bg-transparent" aria-label="Default select example">
                                            <option selected="">This year</option>
                                            <option value="1">Last 2 year</option>
                                            <option value="1">Last 3 year</option>
                                        </select>
                                    </div>

                                    <div style="margin: -6px -1px -26px -17px;">
                                        <div id="attendance_analytics"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4 custom-padding-30 pt-0 px-0">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 custom-padding-30 border-bottom pb-4 custom-padding-30">
                                    <h3 class="mb-0">Teachers</h3>
                                    <a href="#" class="text-decoration-none">
                                        <span>View All</span>
                                        <i class="ri-arrow-right-s-line fs-18 position-relative top-1"></i>
                                    </a>
                                </div>
    
                                <div class="default-table-area style-three teachers">
                                    <div class="table-responsive">
                                        <table class="table align-middle border-0">
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th scope="col" class="bg-transparent">Name</th>
                                                    <th scope="col" class="bg-transparent text-end">Subject</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-1.jpg" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2">
                                                                <h4 class="fs-14 fw-medium mb-0">Sarah W.</h4>
                                                                <span class="fs-12 text-body">sarah@trezo.com</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="fw-medium text-end">Mathematics</td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-2.jpg" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2">
                                                                <h4 class="fs-14 fw-medium mb-0">Michael T.</h4>
                                                                <span class="fs-12 text-body">michael@trezo.com</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="fw-medium text-end">English</td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-3.jpg" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2">
                                                                <h4 class="fs-14 fw-medium mb-0">Emily J.</h4>
                                                                <span class="fs-12 text-body">emily@trezo.com</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="fw-medium text-end">History</td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-4.jpg" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2">
                                                                <h4 class="fs-14 fw-medium mb-0">David A.</h4>
                                                                <span class="fs-12 text-body">david@trezo.com</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="fw-medium text-end">Art</td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-5.jpg" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2">
                                                                <h4 class="fs-14 fw-medium mb-0">Jessica M.</h4>
                                                                <span class="fs-12 text-body">jessica@trezo.com</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="fw-medium text-end">Music</td> 
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-4 col-md-6">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="custom-padding-30">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-4">
                                        <h3 class="mb-0">Students Overview</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected="">Last Month</option>
                                            <option value="1">Last Year</option>
                                            <option value="2">Last 2 Year</option>
                                        </select>
                                    </div>

                                    <div style="margin: -5px -9px -27px -16px;" class="pb-5">
                                        <div id="students_overview"></div>
                                    </div>

                                    <div class="">
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="d-flex">
                                                <div class="text-center rounded-1" style="background-color: #DAEBFF; width: 42px; height: 42px; line-height: 42px;">
                                                    <img src="/assets/images/boys.svg" alt="boys">
                                                </div>
                                                <div class="ms-2">
                                                    <span class="d-block">Boys</span>
                                                    <h3 class="fs-20 fw-semibold mb-0">980</h3>
                                                </div>
                                            </div>
                                            <div class="d-flex ms-5">
                                                <div class="text-center rounded-1" style="background-color: #FFE8D4; width: 42px; height: 42px; line-height: 42px;">
                                                    <img src="/assets/images/girls.svg" alt="boys">
                                                </div>
                                                <div class="ms-2">
                                                    <span class="d-block">Girls</span>
                                                    <h3 class="fs-20 fw-semibold mb-0">675</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="custom-padding-30">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-5">
                                        <h3 class="mb-0">New Admissions</h3>
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
                                    <div style="margin: -8px 0 -13px 0;">
                                        <div id="new_admission"></div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-3 justify-content-center mt-5">
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block rounded-circle bg-success" style="width: 11px; height: 11px;"></span>
                                            <span class="ms-2">Mathematics: <span class="fw-semibold">455</span></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block rounded-circle bg-danger" style="width: 11px; height: 11px;"></span>
                                            <span class="ms-2">English: <span class="fw-semibold">375</span></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block rounded-circle bg-primary-div" style="width: 11px; height: 11px;"></span>
                                            <span class="ms-2">History: <span class="fw-semibold">220</span></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block rounded-circle bg-primary" style="width: 11px; height: 11px;"></span>
                                            <span class="ms-2">Art: <span class="fw-semibold">180</span></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block rounded-circle bg-info bg-opacity-50" style="width: 11px; height: 11px;"></span>
                                            <span class="ms-2">Music: <span class="fw-semibold">45</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-12">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 custom-padding-30">
                                    <h3 class="mb-0">Notice Board</h3>
                                    <a href="/school" class="text-decoration-none">
                                        <span>View All</span>
                                        <i class="ri-arrow-right-s-line fs-18 position-relative top-1"></i>
                                    </a>
                                </div>
    
                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center border-bottom custom-padding-30 pt-0 pb-3 mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="text-center bg-primary-div rounded-circle" style="width: 40px; height: 40px; line-height: 40px;">
                                                <img src="/assets/images/notice-board-icon-1.svg" alt="notice-board-icon">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="fs-14 fw-medium mb-0">Science Fair Registration</h4>
                                            <p class="fs-12 mb-0">Registration for the annual Science Fair</p>
                                            <div class="d-flex align-items-center">
                                                <i class="ri-calendar-line text-primary"></i>
                                                <span class="fw-semibold fs-12 text-primary ms-1">October 28, 2024</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="/school" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read text-decoration-none border" style="width: 43px; height: 43px; line-height: 42px;">
                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                    </a>
                                </div>
                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center border-bottom custom-padding-30 pt-0 pb-3 mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="text-center bg-primary rounded-circle" style="width: 40px; height: 40px; line-height: 37px;">
                                                <img src="/assets/images/notice-board-icon-2.svg" alt="notice-board-icon">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="fs-14 fw-medium mb-0">Parent-Teacher Meeting</h4>
                                            <p class="fs-12 mb-0">The Parent-Teacher meeting for Term 1 will take place</p>
                                            <div class="d-flex align-items-center">
                                                <i class="ri-calendar-line text-primary"></i>
                                                <span class="fw-semibold fs-12 text-primary ms-1">November 1, 2024</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="/school" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read text-decoration-none border" style="width: 43px; height: 43px; line-height: 42px;">
                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                    </a>
                                </div>
                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center border-bottom custom-padding-30 pt-0 pb-3 mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="text-center bg-danger rounded-circle" style="width: 40px; height: 40px; line-height: 37px;">
                                                <img src="/assets/images/notice-board-icon-3.svg" alt="notice-board-icon">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="fs-14 fw-medium mb-0">Winter Sports Tryouts</h4>
                                            <p class="fs-12 mb-0">Tryouts for the winter sports teams will begin on</p>
                                            <div class="d-flex align-items-center">
                                                <i class="ri-calendar-line text-primary"></i>
                                                <span class="fw-semibold fs-12 text-primary ms-1">November 12, 2024</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="/school" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read text-decoration-none border" style="width: 43px; height: 43px; line-height: 42px;">
                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                    </a>
                                </div>
                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center custom-padding-30 pt-0">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="text-center bg-primary rounded-circle" style="width: 40px; height: 40px; line-height: 40px;">
                                                <img src="/assets/images/notice-board-icon-4.svg" alt="notice-board-icon">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="fs-14 fw-medium mb-0">School Holiday Reminder</h4>
                                            <p class="fs-12 mb-0">A reminder that school will be closed on November</p>
                                            <div class="d-flex align-items-center">
                                                <i class="ri-calendar-line text-primary"></i>
                                                <span class="fw-semibold fs-12 text-primary ms-1">November 28, 2024</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="/school" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read text-decoration-none border" style="width: 43px; height: 43px; line-height: 42px;">
                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card custom-shadow rounded-3 bg-white border mb-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 custom-padding-30 border-bottom pb-4 custom-padding-30">
                            <h3 class="mb-0">Students List</h3>
                            <div class="d-flex align-items-center">
                                <form class="position-relative table-src-form">
                                    <input type="text" class="form-control border-0" id="SearchControl" style="width: 265px;" placeholder="Search for a name....">
                                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                </form>
                                <div class="dropdown action-opt">
                                    <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i data-feather="more-vertical"></i>
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

                        <div class="default-table-area style-three employee-list for-data-table">
                            <div class="table-responsive">
                                <table class="table align-middle border-0" id="myTable">
                                    <thead class="border-bottom">
                                        <tr>
                                            <th scope="col" class="bg-transparent">ID</th>
                                            <th scope="col" class="bg-transparent">Name</th>
                                            <th scope="col" class="bg-transparent">Subjects</th>
                                            <th scope="col" class="bg-transparent">Class</th>
                                            <th scope="col" class="bg-transparent">Contact</th>
                                            <th scope="col" class="bg-transparent">Results</th>
                                            <th scope="col" class="bg-transparent">Status</th>
                                            <th scope="col" class="bg-transparent">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-medium">#101</td> 
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-6.jpg" class="rounded-circle" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h4 class="fs-14 fw-medium mb-0">Emily Johnson</h4>
                                                        <span class="fs-12 text-body">emily@gmail.com</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Math</td> 
                                            <td>5A</td> 
                                            <td>(555) 123-4567</td> 
                                            <td>89% Overall (A)</td> 
                                            <td>
                                                <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Passed</span>
                                            </td> 
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-primary">visibility</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-body">edit</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-danger">delete</i>
                                                    </button>
                                                </div>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">#102</td> 
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-7.jpg" class="rounded-circle" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h4 class="fs-14 fw-medium mb-0">Michael Thompson</h4>
                                                        <span class="fs-12 text-body">lmichael@gmail.com</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>English</td> 
                                            <td>8B</td> 
                                            <td>(555) 234-5678</td> 
                                            <td>32% Overall (F)</td> 
                                            <td>
                                                <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Fail</span>
                                            </td> 
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-primary">visibility</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-body">edit</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-danger">delete</i>
                                                    </button>
                                                </div>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">#103</td> 
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-8.jpg" class="rounded-circle" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h4 class="fs-14 fw-medium mb-0">Sarah Williams</h4>
                                                        <span class="fs-12 text-body">sarah@gmail.com</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Geography</td> 
                                            <td>4C</td> 
                                            <td>(555) 345-6789</td> 
                                            <td>92% Overall (A+)</td> 
                                            <td>
                                                <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Dropped</span>
                                            </td> 
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-primary">visibility</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-body">edit</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-danger">delete</i>
                                                    </button>
                                                </div>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">#104</td> 
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-9.jpg" class="rounded-circle" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h4 class="fs-14 fw-medium mb-0">David Anderson</h4>
                                                        <span class="fs-12 text-body">david@gmail.com</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Physics</td> 
                                            <td>6A</td> 
                                            <td>(555) 456-7890</td> 
                                            <td>85% Overall (B+)</td> 
                                            <td>
                                                <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Passed</span>
                                            </td> 
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-primary">visibility</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-body">edit</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-danger">delete</i>
                                                    </button>
                                                </div>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">#105</td> 
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-10.jpg" class="rounded-circle" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h4 class="fs-14 fw-medium mb-0">Jessica Martinez</h4>
                                                        <span class="fs-12 text-body">jessica@gmail.com</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>History</td> 
                                            <td>7B</td> 
                                            <td>(555) 567-8901</td> 
                                            <td>25% Overall (F)</td> 
                                            <td>
                                                <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Fail</span>
                                            </td> 
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-primary">visibility</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-body">edit</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-danger">delete</i>
                                                    </button>
                                                </div>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">#106</td> 
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-11.jpg" class="rounded-circle" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h4 class="fs-14 fw-medium mb-0">James Lee</h4>
                                                        <span class="fs-12 text-body">james@gmail.com</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Biology</td> 
                                            <td>5B</td> 
                                            <td>(555) 678-9012</td> 
                                            <td>88% Overall (A)</td> 
                                            <td>
                                                <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Passed</span>
                                            </td> 
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-primary">visibility</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-body">edit</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-danger">delete</i>
                                                    </button>
                                                </div>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">#107</td> 
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-12.jpg" class="rounded-circle" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h4 class="fs-14 fw-medium mb-0">Ethan Clark</h4>
                                                        <span class="fs-12 text-body">ethan@gmail.com</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Music</td> 
                                            <td>8A</td> 
                                            <td>(555) 789-0123</td> 
                                            <td>93% Overall (A+)</td> 
                                            <td>
                                                <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Dropped</span>
                                            </td> 
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-primary">visibility</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-body">edit</i>
                                                    </button>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                        <i class="material-symbols-outlined fs-18 text-danger">delete</i>
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