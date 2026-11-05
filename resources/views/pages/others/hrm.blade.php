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
                    <div class="row">
                        <div class="col-md-7">
                            <div class="mb-4">
                                <h3 class="fs-20 fw-semibold mb-1">Welcome Back, <span class="text-primary">Olivia!</span></h3>
                                <p style="line-height: 1.4;">Monitor and manage employee performance, attendance and more in one place.</p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="d-flex flex-wrap gap-2 justify-content-md-end mb-4">
                                <a href="/pricing-plan" class="btn d-flex align-items-center gap-1" style="background-color: #F3E8FF; color: #7C24CC; padding: 3.5px 11px;">
                                    <i class="ri-vip-crown-line fs-18 lh-1" style="color: #7C24CC;"></i>
                                    <span>Plan Upgrade</span>
                                </a>
                                <button class="btn d-flex align-items-center gap-1" style="background-color: #FFE8D4; color: #C52B09; padding: 3.5px 11px;">
                                    <i class="ri-file-download-line fs-18 lh-1 position-relative top-1" style="color: #C52B09;"></i>
                                    <span>Export Reports</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="custom-padding-30 position-relative">
                                    <div class="d-flex align-items-center mb-4 pb-2">
                                        <div class="flex-shrink-0">
                                            <div class="text-center rounded-2 bg-primary-50" style="width: 44px; height: 44px; line-height: 44px;">
                                                <img src="/assets/images/icon-employees.svg" alt="icon-employees">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="d-block mb-1">Total Employees</span>
                                            <h3 class="fw-medium fs-20 mb-0">15,720</h3>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <i class="ri-arrow-right-up-line d-inline-block text-center rounded-1 fs-18 text-success-50" style="width: 26px; height: 26px; line-height: 26px; background-color: #D8FFC8;"></i>
                                        <p class="ms-2"><span class="text-secondary fw-medium">+12%</span> last year</p>
                                    </div>

                                    <div id="total_employees" class="chart-position top-50 translate-middle-y"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="custom-padding-30 position-relative">
                                    <div class="d-flex align-items-center mb-4 pb-2">
                                        <div class="flex-shrink-0">
                                            <div class="text-center rounded-2 bg-danger-50" style="width: 44px; height: 44px; line-height: 44px;">
                                                <img src="/assets/images/icon-resigned.svg" alt="icon-resigned">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="d-block mb-1">Resigned Employees</span>
                                            <h3 class="fw-medium fs-20 mb-0">3,18</h3>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <i class="ri-arrow-right-down-line d-inline-block text-center rounded-1 fs-18 text-danger-50" style="width: 26px; height: 26px; line-height: 26px; background-color: #FFE8D4;"></i>
                                        <p class="ms-2"><span class="text-secondary fw-medium">-5%</span> last year</p>
                                    </div>

                                    <div id="resigned_employees" class="chart-position top-50 translate-middle-y"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="custom-padding-30 position-relative">
                                    <div class="d-flex align-items-center mb-4 pb-2">
                                        <div class="flex-shrink-0">
                                            <div class="text-center rounded-2 bg-primary-div-50" style="width: 44px; height: 44px; line-height: 44px;">
                                                <img src="/assets/images/icon-employees.svg" alt="icon-employees">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="d-block mb-1">New Employees</span>
                                            <h3 class="fw-medium fs-20 mb-0">8,24</h3>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <i class="ri-arrow-right-up-line d-inline-block text-center rounded-1 fs-18 text-success-50" style="width: 26px; height: 26px; line-height: 26px; background-color: #D8FFC8;"></i>
                                        <p class="ms-2"><span class="text-secondary fw-medium">+10%</span> last year</p>
                                    </div>

                                    <div id="new_employees" class="chart-position top-50 translate-middle-y me-1 mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="custom-padding-30">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3" style="padding-bottom: 33px;">
                                        <h3 class="mb-0">Employee Attendance Trends</h3>
                                        <div class="position-relative">
                                            <input type="text" class="form-control bg-body-bg position-relative" id="range_datepicker" style="width: 230px; height: 36px; padding-left: 35px;" placeholder="29/10/2024 - 28/11/2024"/>
                                            <i class="ri-calendar-line position-absolute top-50 start-0 translate-middle-y ps-3"></i>
                                        </div>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap justify-content-between gap-2 lh-1 employee-attendance-list" style="padding-bottom: 45px;">
                                        <li>Avg. Daily Attend: <span class="fw-semibold">320</span></li>
                                        <li>High. Attend: <span class="fw-semibold">340</span> (October 5th)</li>
                                        <li>Low. Attend: <span class="fw-semibold">290</span> (October 1st)</li>
                                    </ul>
                                    <div style="margin: -24px 13px -21px -18px;">
                                        <div id="employee_attendance_trends"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="custom-padding-30">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                        <h3 class="mb-0">Employee Work Format</h3>
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
                                    <div style="margin: -8px 0 -18px 0;">
                                        <div id="employee_work_format"></div>
                                    </div>
                                </div>
                                <ul class="ps-0 mb-0 list-unstyled">
                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3" style="padding: 0 30px;">
                                        <div class="d-flex align-items-center" style="width: 175px;">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="d-inline-block bg-danger-50" style="width: 8px; height: 8px;"></span>
                                                    <span class="fw-medium text-secondary">Remote</span>
                                                </div>
                                            </div>
                                            <span class="flex-shrink-0 d-flex align-items-center text-success-60">
                                                <div class="d-flex">
                                                    34% 
                                                    <i class="material-symbols-outlined fs-18 ms-1 position-relative top-1">trending_up</i>
                                                </div>
                                            </span>
                                        </div>
                                        <span class="fw-bold text-secondary">120</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3" style="padding: 0 30px;">
                                        <div class="d-flex align-items-center" style="width: 175px;">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="d-inline-block bg-primary-50" style="width: 8px; height: 8px;"></span>
                                                    <span class="fw-medium text-secondary">In-office</span>
                                                </div>
                                            </div>
                                            <span class="flex-shrink-0 d-flex align-items-center text-danger-50">
                                                <div class="d-flex">
                                                    46%
                                                    <i class="material-symbols-outlined fs-18 ms-1 position-relative top-1">trending_down</i>
                                                </div>
                                            </span>
                                        </div>
                                        <span class="fw-bold text-secondary">160</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3" style="padding: 0 30px;">
                                        <div class="d-flex align-items-center" style="width: 175px;">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="d-inline-block bg-success-60" style="width: 8px; height: 8px;"></span>
                                                    <span class="fw-medium text-secondary">Hybrid</span>
                                                </div>
                                            </div>
                                            <span class="flex-shrink-0 d-flex align-items-center text-success-60">
                                                <div class="d-flex">
                                                    15% 
                                                    <i class="material-symbols-outlined fs-18 ms-1 position-relative top-1">trending_up</i>
                                                </div>
                                            </span>
                                        </div>
                                        <span class="fw-bold text-secondary">50</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center mb-3" style="padding: 0 30px;">
                                        <div class="d-flex align-items-center" style="width: 175px;">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="d-inline-block bg-primary-div-50" style="width: 8px; height: 8px;"></span>
                                                    <span class="ms-1 fw-medium text-secondary">Shift</span>
                                                </div>
                                            </div>
                                            <span class="flex-shrink-0 d-flex align-items-center text-danger-50">
                                                <div class="d-flex">
                                                    05% 
                                                    <i class="material-symbols-outlined fs-18 ms-1 position-relative top-1">trending_down</i>
                                                </div>
                                            </span>
                                        </div>
                                        <span class="fw-bold text-secondary">20</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-4">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="custom-padding-30">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3" style="padding-bottom: 30px;">
                                        <h3 class="mb-0">Employee Salary</h3> 
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

                                    <div class="d-flex align-items-center mb-4 mb-md-5">
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary-50 bg-opacity-10 text-center rounded-1" style="width: 42px; height: 42px; line-height: 42px;">
                                                <img src="/assets/images/icon-total-payroll.svg" alt="icon-total-payroll">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="d-block mb-1">Total Payroll</span>
                                            <h3 class="mb-0 fs-20 fw-semibold">$450,000</h3>
                                        </div>
                                    </div>

                                    <div style="margin: -30px -10px -26px -12px;">
                                        <div id="employee_salary"></div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 gap-xxl-4 mt-md-5 mt-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bg-success-60 bg-opacity-10 text-center rounded-1" style="width: 42px; height: 42px; line-height: 37px;">
                                                    <img src="/assets/images/icon-salary-paid.svg" alt="icon-salary-paid">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="d-block mb-1">Salary Paid</span>
                                                <h3 class="fs-20 fw-semibold">$395k</h3>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bg-danger-50 bg-opacity-10 text-center rounded-1" style="width: 42px; height: 42px; line-height: 42px;">
                                                    <img src="/assets/images/icon-salary-pending.svg" alt="icon-salary-paid">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="d-block mb-1">Salary Pending</span>
                                                <h3 class="fs-20 fw-semibold">$60k</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 custom-padding-30 border-bottom pb-4">
                                        <h3 class="mb-0">Employee Leave Request</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color bg-transparent" aria-label="Default select example">
                                            <option selected="">Last 30 days</option>
                                            <option value="1">Last 90 days</option>
                                            <option value="1">Last 1 year</option>
                                        </select>
                                    </div>
        
                                    <div class="default-table-area style-three employee-leave-request">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead class="border-bottom">
                                                    <tr>
                                                        <th scope="col" class="bg-transparent">Employee</th>
                                                        <th scope="col" class="bg-transparent">Leave Type</th>
                                                        <th scope="col" class="bg-transparent">Days</th>
                                                        <th scope="col" class="bg-transparent">Status</th>
                                                        <th scope="col" class="bg-transparent">Action</th>
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
                                                                    <h4 class="fs-14 fw-medium mb-0">John Doe</h4>
                                                                    <span class="fs-12 text-body">Marketing</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>Vacation</td> 
                                                        <td>3</td> 
                                                        <td>
                                                            <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Approved</span>
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
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-2.jpg" class="rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-medium mb-0">Jane Smith</h4>
                                                                    <span class="fs-12 text-body">HR</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>Sick Leave</td> 
                                                        <td>2</td> 
                                                        <td>
                                                            <span class="badge bg-warning bg-opacity-10 text-warning p-2 fs-12 fw-normal">Pending</span>
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
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-3.jpg" class="rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-medium mb-0">Alex Johnson</h4>
                                                                    <span class="fs-12 text-body">Developer</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>Maternity Leave</td> 
                                                        <td>4</td> 
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Rejected</span>
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
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-4.jpg" class="rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-medium mb-0">Emily Davis</h4>
                                                                    <span class="fs-12 text-body">UX Designer</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>Vacation</td> 
                                                        <td>2</td> 
                                                        <td>
                                                            <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Approved</span>
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
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-5.jpg" class="rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-medium mb-0">Michael Brown</h4>
                                                                    <span class="fs-12 text-body">Finance</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>Personal Leave</td> 
                                                        <td>1</td> 
                                                        <td>
                                                            <span class="badge bg-warning bg-opacity-10 text-warning p-2 fs-12 fw-normal">Pending</span>
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
            
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 custom-padding-30 pt-4">
                                            <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/hrm" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/hrm">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/hrm">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/hrm">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/hrm">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/hrm" aria-label="Next">
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
                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 custom-padding-30 border-bottom pb-4">
                                <h3 class="mb-0">Employee List</h3>
                                <div class="d-flex align-items-center">
                                    <form class="position-relative table-src-form">
                                        <input type="text" id="SearchControl" class="form-control border-0" style="width: 265px;" placeholder="Search for a name....">
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
                                                <th scope="col">ID</th>
                                                <th scope="col">Employee</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Position</th>
                                                <th scope="col">Joining Date</th>
                                                <th scope="col">Salary</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-medium">EMP001</td> 
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-6.jpg" class="rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-medium mb-0">Olivia Turner</h4>
                                                            <span class="fs-12 text-body">olivia@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Marketing</td> 
                                                <td>Marketing Lead</td> 
                                                <td>Jan 15, 2020</td> 
                                                <td>$85,000</td> 
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Active</span>
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
                                                <td class="fw-medium">EMP002</td> 
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-7.jpg" class="rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-medium mb-0">Liam Bennett</h4>
                                                            <span class="fs-12 text-body">liam@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Human Resources</td> 
                                                <td>HR Manager</td> 
                                                <td>Mar 10, 2021</td> 
                                                <td>$75,000</td> 
                                                <td>
                                                    <span class="badge bg-primary-div bg-opacity-10 text-primary-div p-2 fs-12 fw-normal">On Leave</span>
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
                                                <td class="fw-medium">EMP003</td> 
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-8.jpg" class="rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-medium mb-0">Sophia Myers</h4>
                                                            <span class="fs-12 text-body">sophia@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>IT</td> 
                                                <td>Software Engineer</td> 
                                                <td>Feb 22, 2019</td> 
                                                <td>$95,000</td> 
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Active</span>
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
                                                <td class="fw-medium">EMP004</td> 
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-9.jpg" class="rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-medium mb-0">Ethan Collins</h4>
                                                            <span class="fs-12 text-body">ethan@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Sales</td> 
                                                <td>Sales Manager</td> 
                                                <td>Apr 12, 2022</td> 
                                                <td>$90,000</td> 
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Active</span>
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
                                                <td class="fw-medium">EMP005</td> 
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-10.jpg" class="rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-medium mb-0">Isabella Reed</h4>
                                                            <span class="fs-12 text-body">isabella@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Finance</td> 
                                                <td>Financial Analyst</td> 
                                                <td>Aug 05, 2020</td> 
                                                <td>$80,000</td> 
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Resigned</span>
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
                                                <td class="fw-medium">EMP006</td> 
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-11.jpg" class="rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-medium mb-0">Sophia Myers</h4>
                                                            <span class="fs-12 text-body">sophia@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>IT</td> 
                                                <td>Software Engineer</td> 
                                                <td>Feb 22, 2019</td> 
                                                <td>$95,000</td> 
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Active</span>
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
                                                <td class="fw-medium">EMP007</td> 
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-12.jpg" class="rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-medium mb-0">Isabella Reed</h4>
                                                            <span class="fs-12 text-body">isabella@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Finance</td> 
                                                <td>Financial Analyst</td> 
                                                <td>Aug 05, 2020</td> 
                                                <td>$80,000</td> 
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Resigned</span>
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
                                                <td class="fw-medium">EMP008</td> 
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-13.jpg" class="rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-medium mb-0">Olivia Turner</h4>
                                                            <span class="fs-12 text-body">olivia@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Marketing</td> 
                                                <td>Marketing Lead</td> 
                                                <td>Jan 15, 2020</td> 
                                                <td>$85,000</td> 
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Active</span>
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
                                                <td class="fw-medium">EMP009</td> 
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-14.jpg" class="rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-medium mb-0">Liam Bennett</h4>
                                                            <span class="fs-12 text-body">liam@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Human Resources</td> 
                                                <td>HR Manager</td> 
                                                <td>Mar 10, 2021</td> 
                                                <td>$75,000</td> 
                                                <td>
                                                    <span class="badge bg-primary-div bg-opacity-10 text-primary-div p-2 fs-12 fw-normal">On Leave</span>
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
                                                <td class="fw-medium">EMP0010</td> 
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-15.jpg" class="rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-medium mb-0">Ethan Collins</h4>
                                                            <span class="fs-12 text-body">ethan@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Sales</td> 
                                                <td>Sales Manager</td> 
                                                <td>Apr 12, 2022</td> 
                                                <td>$90,000</td> 
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Active</span>
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