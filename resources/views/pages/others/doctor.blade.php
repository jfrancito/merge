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
        @include('partials.sidebar_two')

        <div class="container-fluid p-0">
			<div class="main-content d-flex flex-column p-0 overflow-hidden">
				<!-- Start Header Area -->
				@include('partials.horizontal_menubar')
				<!-- End Header Area -->

				<div class="main-content-container overflow-hidden" style="padding-left: 12px; padding-right: 12px;">
                    <div class="card border-0 p-4 p-xl-0 rounded-3 position-relative mx-auto" style="background: linear-gradient(272deg, #1F64F1 31.27%, #123A8B 98.4%); max-width: 1306px;">
                        <div class="mx-auto w-100" style="max-width: 1120px;">
                            <div class="d-flex flex-wrap justify-content-between align-items-center align-items-xl-end">
                                <div class="py-xl-5">
                                    <span class="fs-18 text-white">Good Morning</span>
                                    <h2 class="fs-28 fw-800 text-white mt-2 mt-sm-2 my-2">Dr. Olivia John</h2>
                                    <div class="d-flex align-items-center gap-1 mb-1 mb-sm-2">
                                        <img src="/assets/images/heart.png" alt="heart">
                                        <span class="text-white fs-12 fw-semibold">CARDIO SPECIALIST</span>
                                    </div>
                                    <p class="mb-4" style="color: #B1BBC8;">Today you have <span class="text-white">15</span> Consultations and <span class="text-white">12</span> Operations.</p>
                                </div>
                                <img src="/assets/images/andrew-rashel.png" class="mt-3 mt-sm-0" alt="andrew-rashel">
                            </div>
                            <img src="/assets/images/shape-11.png" class="position-absolute bottom-0 end-0" alt="shape">
                        </div>
                    </div>
                    <div class="mx-auto" style="max-width: 1120px; margin-top: -22px;">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 me-3">
                                            <span class="d-block mb-2">Appointments</span>
                                            <h2 class="mb-2 fw-900 fs-28">32</h2>
                                            <span class="d-inline-block bg-danger bg-opacity-10 border-danger border px-2 rounded-pill text-danger fs-12 fw-medium">-0.04%</span>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/appointments-icon.svg" alt="appointments-icon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 me-3">
                                            <span class="d-block mb-2">Patients</span>
                                            <h2 class="mb-2 fw-900 fs-28">334</h2>
                                            <span class="d-inline-block bg-success bg-opacity-10 border-success border px-2 rounded-pill text-success fs-12 fw-medium">+7%</span>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/patients-icon.svg" alt="patients-icon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 me-3">
                                            <span class="d-block mb-2">Operations</span>
                                            <h2 class="mb-2 fw-900 fs-28">12</h2>
                                            <span class="d-inline-block bg-success bg-opacity-10 border-success border px-2 rounded-pill text-success fs-12 fw-medium">+5.4%</span>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/operations-icon.svg" alt="operations-icon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card border-0 rounded-3 bg-white p-4 mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 me-3">
                                            <span class="d-block mb-2">Earnings</span>
                                            <h2 class="mb-2 fw-900 fs-28">$312</h2>
                                            <span class="d-inline-block bg-danger bg-opacity-10 border-danger border px-2 rounded-pill text-danger fs-12 fw-medium">-1.4%</span>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/earnings-icon.svg" alt="earnings-icon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-xl-8">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6">
                                        <div class="card bg-white border-0 rounded-3 mb-4">
                                            <div class="card-body p-4">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 mb-lg-4">
                                                    <h3 class="mb-0">Patient Retention</h3>
            
                                                    <div class="dropdown select-dropdown">
                                                        <button class="bg-transparent border text-body rounded-2 p-0 border-0 dot" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        
                                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3" style="width: 195px;">
                                                            <li>
                                                                <button class="dropdown-item text-secondary py-2 px-3">This Day</button>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-secondary py-2 px-3">This Week</button>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-secondary py-2 px-3">This Month</button>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-secondary py-2 px-3">This Year</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div style="margin: -24px -4px -20px -18px;">
                                                    <div id="patient_retention"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="card bg-white border-0 rounded-3 mb-4">
                                            <div class="card-body p-4">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 mb-lg-4">
                                                    <h3 class="mb-0">Patient Distribution</h3>
            
                                                    <div class="dropdown select-dropdown">
                                                        <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Today
                                                        </button>
                                                      
                                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                            <li>
                                                                <button class="dropdown-item text-secondary py-2 px-3">This Day</button>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-secondary py-2 px-3">This Week</button>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-secondary py-2 px-3">This Month</button>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-secondary py-2 px-3">This Year</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div style="margin-top: -14px;">
                                                    <div id="patient_distribution"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border-0 rounded-3 p-4 mb-4" style="background: linear-gradient(90deg, #4936F5 0%, #4737D6 100%);">
                                    <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between">
                                        <h3 class="fs-20 text-white mb-0" style="max-width: 300px; line-height: 1.6;">Upgrade Plan To Manage 20K+ Patients</h3>
                                        <div class="">
                                            <img src="/assets/images/upgrade.png" alt="upgrade">
                                        </div>
                                    </div>
                                </div>

                                <div class="card bg-white border-0 rounded-3 mb-4">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 mb-lg-4">
                                            <h3 class="mb-0">Income Vs Expense</h3>
    
                                            <div class="dropdown select-dropdown">
                                                <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    This Month
                                                </button>
                                              
                                                <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                    <li>
                                                        <button class="dropdown-item text-secondary py-2 px-3">This Day</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-secondary py-2 px-3">This Week</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-secondary py-2 px-3">This Month</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-secondary py-2 px-3">This Year</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div style="margin: -24px -24px -20px -17px;">
                                            <div id="income_vs_expense"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12">
                                <div class="card bg-white border-0 rounded-3 mb-4">
                                    <div class="card-body p-4">
                                        <div class="calendar-container">
                                            <div class="d-flex gap-1 justify-content-between align-items-center mb-3 mb-lg-4">
                                                <h3 class="fs-18 fw-semibold letter-spacing-1 mb-0">Today’s Schedule</h3>
                                                <div>
                                                    <!-- <div class="d-flex align-items-center bg-border-color py-2 px-2 rounded-2 for-dark-digital-date">
                                                        <div id="digital_date_schedule"></div>
                                                        <i class="ri-calendar-2-line ms-2"></i>
                                                    </div> -->
                                                    <div class="datepicker-wrap" id="date_pikar_pop">
                                                        <div class="datepicker-container position-relative">
                                                            <input type="text" id="date-input" value="11/30/2024"/>
                                                            <div class="datepicker" id="datepicker"></div>
                                                            <i class="ri-calendar-2-line ms-2"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="calendar-header d-none">
                                                <button id="prevMonth">Prev</button>
                                                <select id="monthSelect"></select>
                                                <select id="yearSelect"></select>
                                                <button id="nextMonth">Next</button>
                                            </div>
                                            <table class="calendar-table" id="wait_until_the_dom_is_fully_loaded">
                                                <thead>
                                                    <tr>
                                                        <th>Sun</th>
                                                        <th>Mon</th>
                                                        <th>Tue</th>
                                                        <th>Wed</th>
                                                        <th>Thu</th>
                                                        <th>Fri</th>
                                                        <th>Sat</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="calendarBody">
                                                    <!-- Calendar days will be dynamically generated here -->
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="pt-4 mb-4 all-inline-border-for-dark" style="border-bottom: 1px dashed #D5D9E2;"></div>

                                        <div style="max-height: 585.66px;" data-simplebar>
                                            <div class="p-4 rounded-3 position-relative z-1 mb-4 schedule-for-dark" style="background-color: #DDE4FF;">
                                                <span class="text-secondary fw-semibold d-block">10:00 AM</span>
                                                <p class="mb-2">Appointment With Cardiac Patient</p>
                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="/assets/images/user-82.png" class="rounded-circle border border-color-white" style="width: 25px; height: 25px;" alt="user">
                                                    <span class="fw-semibold ms-1">Jonathon Ronan</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <button class="btn bg-white text-primary fw-semibold hover-bg">View Details</button>
                                                    <div class="bg-primary text-center rounded-circle" style="width: 28px; height: 28px; line-height: 34px;">
                                                        <span class="material-symbols-outlined fs-18 text-white">notifications</span>
                                                    </div>
                                                </div>
                                                <img src="/assets/images/shape-12.png" class="position-absolute top-0 end-0 z-n1" alt="shape">
                                            </div>
                                            <div class="p-4 rounded-3 position-relative z-1 mb-4 schedule-for-dark" style="background-color: #DAEBFF;">
                                                <span class="text-secondary fw-semibold d-block">12:00 PM</span>
                                                <p class="mb-2">Major Cardiac Surgery of the patient</p>
                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="/assets/images/user-84.png" class="rounded-circle border border-color-white" style="width: 25px; height: 25px;" alt="user">
                                                    <span class="fw-semibold ms-1">Walter White</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <button class="btn bg-white text-card-bg-c fw-semibold hover-bg">View Details</button>
                                                    <div class="bg-white text-center rounded-circle" style="width: 28px; height: 28px; line-height: 34px;">
                                                        <span class="material-symbols-outlined fs-18 text-card-bg-c">notifications</span>
                                                    </div>
                                                </div>
                                                <img src="/assets/images/shape-12.png" class="position-absolute top-0 end-0 z-n1" alt="shape">
                                            </div>
                                            <div class="p-4 rounded-3 position-relative z-1 mb-4 schedule-for-dark" style="background-color: #C8FFE1;">
                                                <span class="text-secondary fw-semibold d-block">02:00 PM</span>
                                                <p class="mb-2">Board Meeting With</p>
                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="/assets/images/user-83.png" class="rounded-circle border border-color-white" style="width: 25px; height: 25px;" alt="user">
                                                    <span class="fw-semibold ms-1">Jessy Pinkman</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <button class="btn bg-white text-success fw-semibold hover-bg">View Details</button>
                                                    <div class="bg-white text-center rounded-circle" style="width: 28px; height: 28px; line-height: 34px;">
                                                        <span class="material-symbols-outlined fs-18 text-success">notifications</span>
                                                    </div>
                                                </div>
                                                <img src="/assets/images/shape-12.png" class="position-absolute top-0 end-0 z-n1" alt="shape">
                                            </div>
                                            <div class="p-4 rounded-3 position-relative z-1 mb-0 schedule-for-dark" style="background-color: #DDE4FF;">
                                                <span class="text-secondary fw-semibold d-block">10:00 AM</span>
                                                <p class="mb-2">Appointment With Cardiac Patient</p>
                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="/assets/images/user-85.png" class="rounded-circle border border-color-white" style="width: 25px; height: 25px;" alt="user">
                                                    <span class="fw-semibold ms-1">Jonathon Ronan</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <button class="btn bg-white text-primary fw-semibold hover-bg">View Details</button>
                                                    <div class="bg-white text-center rounded-circle" style="width: 28px; height: 28px; line-height: 34px;">
                                                        <span class="material-symbols-outlined fs-18 text-primary">notifications</span>
                                                    </div>
                                                </div>
                                                <img src="/assets/images/shape-12.png" class="position-absolute top-0 end-0 z-n1" alt="shape">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8 col-xl-9">
                                <div class="card bg-white border-0 rounded-3 mb-4">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h3 class="mb-0">My Recent Patient</h3>
                                            <div class="dropdown select-dropdown">
                                                <button class="dropdown-toggle bg-border-color border text-body rounded-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    This Week
                                                </button>
                                              
                                                <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                    <li>
                                                        <button class="dropdown-item text-secondary py-2 px-3">This Day</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-secondary py-2 px-3">This Week</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-secondary py-2 px-3">This Month</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-secondary py-2 px-3">This Year</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="default-table-area style-two campaigns-table latest-transaction-table">
                                            <div class="table-responsive">
                                                <table class="table align-middle border-0">
                                                    <thead>
                                                        <tr class="border-bottom">
                                                            <th scope="col" class=" bg-transparent text-body fw-medium">
                                                                <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">ID</span>
                                                            </th>
                                                            <th scope="col" class="bg-transparent text-body fw-medium">
                                                                <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">PATIENT NAME</span>
                                                            </th>
                                                            <th scope="col" class="bg-transparent text-body fw-medium">
                                                                <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">DISEASE</span>
                                                            </th>
                                                            <th scope="col" class="bg-transparent text-body fw-medium">
                                                                <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">PAYMENT STATUS</span>
                                                            </th>
                                                            <th scope="col" class="bg-transparent text-body fw-medium">
                                                                <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">STATUS</span>
                                                            </th>
                                                            <th scope="col" class="text-end bg-transparent text-body fw-medium">
                                                                <span class="fs-10 fw-bold letter-spacing-1 text-body-color-60">ACTION</span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="fs-12 fw-semibold text-body-color-50">#001</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-81.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <h4 class="fs-14 fw-semibold mb-0" style="color: #23272E;">Johhna Loren</h4>
                                                                        <span class="fs-12 text-body">loren123@gmail.com</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="fs-12 fw-semibold text-body-color-50">Heart Attack</td>
                                                            <td class="fs-12 fw-semibold text-body-color-50">Paid</td>
                                                            <td>
                                                                <span class="d-inline-block px-2 bg-success bg-opacity-10 text-success border border-success rounded-pill fs-12 fw-medium">Completed</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="dropdown action-opt">
                                                                    <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i data-feather="more-horizontal"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                        <li>
                                                                            <a class="dropdown-item" href="javascript:;">
                                                                                <i data-feather="edit"></i>
                                                                                Edit
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fs-12 fw-semibold text-body-color-50">#002</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-80.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <h4 class="fs-14 fw-semibold mb-0" style="color: #23272E;">Skyler White</h4>
                                                                        <span class="fs-12 text-body">skyqueen@gmail.com</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="fs-12 fw-semibold text-body-color-50">Chest Pain</td>
                                                            <td class="fs-12 fw-semibold text-body-color-50">Paid</td>
                                                            <td>
                                                                <span class="d-inline-block px-2 bg-primary-div bg-opacity-10 text-primary-div border border-primary-div rounded-pill fs-12 fw-medium">Pending</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="dropdown action-opt">
                                                                    <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i data-feather="more-horizontal"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                        <li>
                                                                            <a class="dropdown-item" href="javascript:;">
                                                                                <i data-feather="edit"></i>
                                                                                Edit
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fs-12 fw-semibold text-body-color-50">#003</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-82.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <h4 class="fs-14 fw-semibold mb-0" style="color: #23272E;">Jonathon Watson</h4>
                                                                        <span class="fs-12 text-body">jona2134@gmail.com</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="fs-12 fw-semibold text-body-color-50">Breathing Issue</td>
                                                            <td class="fs-12 fw-semibold text-body-color-50">Unpaid</td>
                                                            <td>
                                                                <span class="d-inline-block px-2 bg-danger bg-opacity-10 text-danger border border-danger rounded-pill fs-12 fw-medium">Failed</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="dropdown action-opt">
                                                                    <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i data-feather="more-horizontal"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                        <li>
                                                                            <a class="dropdown-item" href="javascript:;">
                                                                                <i data-feather="edit"></i>
                                                                                Edit
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fs-12 fw-semibold text-body-color-50">#004</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-83.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <h4 class="fs-14 fw-semibold mb-0" style="color: #23272E;">Walter White</h4>
                                                                        <span class="fs-12 text-body">puzzleworld@gmail.com</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="fs-12 fw-semibold text-body-color-50">Heart Surgery</td>
                                                            <td class="fs-12 fw-semibold text-body-color-50">Paid</td>
                                                            <td>
                                                                <span class="d-inline-block px-2 bg-success bg-opacity-10 text-success border border-success rounded-pill fs-12 fw-medium">Completed</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="dropdown action-opt">
                                                                    <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i data-feather="more-horizontal"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                        <li>
                                                                            <a class="dropdown-item" href="javascript:;">
                                                                                <i data-feather="edit"></i>
                                                                                Edit
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fs-12 fw-semibold text-body-color-50">#005</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/assets/images/user-84.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <h4 class="fs-14 fw-semibold mb-0" style="color: #23272E;">David Carlen</h4>
                                                                        <span class="fs-12 text-body">liveslong@gmail.com</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="fs-12 fw-semibold text-body-color-50">CVD</td>
                                                            <td class="fs-12 fw-semibold text-body-color-50">Unpaid</td>
                                                            <td>
                                                                <span class="d-inline-block px-2 bg-primary-div bg-opacity-10 text-primary-div border border-primary-div rounded-pill fs-12 fw-medium">Pending</span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="dropdown action-opt">
                                                                    <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i data-feather="more-horizontal"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                        <li>
                                                                            <a class="dropdown-item" href="javascript:;">
                                                                                <i data-feather="edit"></i>
                                                                                Edit
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
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
    
                                            <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                                                <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
                
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination mb-0 justify-content-center">
                                                        <li class="page-item">
                                                            <button class="page-link icon hover-bg" aria-label="Previous">
                                                                <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                            </button>
                                                        </li>
                                                        <li class="page-item">
                                                            <button class="page-link active">1</button>
                                                        </li>
                                                        <li class="page-item">
                                                            <button class="page-link">2</button>
                                                        </li>
                                                        <li class="page-item">
                                                            <button class="page-link">3</button></li>
                                                        <li class="page-item"><a class="page-link">4</a>
                                                        </li>
                                                        <li class="page-item">
                                                            <button class="page-link icon hover-bg" aria-label="Next">
                                                                <i class="material-symbols-outlined">keyboard_arrow_right</i>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-3">
                                <div class="card bg-white border-0 rounded-3 mb-4">
                                    <div class="card-body p-4">
                                        <h3 class="mb-4">Recent Lab Report</h3>

                                        <div class="last-child-none" style="max-height: 407px;" data-simplebar>
                                            <div class=" child border-bottom pb-3 mb-3 d-flex flex-wrap gap-2 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                    <img src="/assets/images/pdf.png" style="width: 30px; height: 30px;" alt="pdf">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h3 class="fw-semibold fs-14 mb-0">Blood Report.pdf</h3>
                                                        <span class="fs-12">submitted by <span class="text-secondary">Andrew</span></span>
                                                    </div>
                                                </div>
                                                <button class="p-0 border-0 bg-transparent text-primary">
                                                    <span class="material-symbols-outlined">download</span>
                                                </button>
                                            </div>
                                            <div class=" child border-bottom pb-3 mb-3 d-flex flex-wrap gap-2 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                    <img src="/assets/images/jpg.png" style="width: 30px; height: 30px;" alt="pdf">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h3 class="fw-semibold fs-14 mb-0">X-ray Report.jpg</h3>
                                                        <span class="fs-12">submitted by <span class="text-secondary">Joanna</span></span>
                                                    </div>
                                                </div>
                                                <button class="p-0 border-0 bg-transparent text-primary">
                                                    <span class="material-symbols-outlined">download</span>
                                                </button>
                                            </div>
                                            <div class=" child border-bottom pb-3 mb-3 d-flex flex-wrap gap-2 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                    <img src="/assets/images/pdf.png" style="width: 30px; height: 30px;" alt="pdf">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h3 class="fw-semibold fs-14 mb-0">Creatinine.pdf</h3>
                                                        <span class="fs-12">submitted by <span class="text-secondary">David</span></span>
                                                    </div>
                                                </div>
                                                <button class="p-0 border-0 bg-transparent text-primary">
                                                    <span class="material-symbols-outlined">download</span>
                                                </button>
                                            </div>
                                            <div class=" child border-bottom pb-3 mb-3 d-flex flex-wrap gap-2 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                    <img src="/assets/images/pdf.png" style="width: 30px; height: 30px;" alt="pdf">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h3 class="fw-semibold fs-14 mb-0">Blood Report.pdf</h3>
                                                        <span class="fs-12">submitted by <span class="text-secondary">Zinia</span></span>
                                                    </div>
                                                </div>
                                                <button class="p-0 border-0 bg-transparent text-primary">
                                                    <span class="material-symbols-outlined">download</span>
                                                </button>
                                            </div>
                                            <div class=" child border-bottom pb-3 mb-3 d-flex flex-wrap gap-2 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                    <img src="/assets/images/doc.png" style="width: 30px; height: 30px;" alt="pdf">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h3 class="fw-semibold fs-14 mb-0">Blood Report.pdf</h3>
                                                        <span class="fs-12">submitted by <span class="text-secondary">Andrew</span></span>
                                                    </div>
                                                </div>
                                                <button class="p-0 border-0 bg-transparent text-primary">
                                                    <span class="material-symbols-outlined">download</span>
                                                </button>
                                            </div>
                                            <div class=" child border-bottom pb-3 mb-3 d-flex flex-wrap gap-2 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                    <img src="/assets/images/pdf.png" style="width: 30px; height: 30px;" alt="pdf">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h3 class="fw-semibold fs-14 mb-0">ECG Report.doc</h3>
                                                        <span class="fs-12">submitted by <span class="text-secondary">Bella</span></span>
                                                    </div>
                                                </div>
                                                <button class="p-0 border-0 bg-transparent text-primary">
                                                    <span class="material-symbols-outlined">download</span>
                                                </button>
                                            </div>
                                            <div class=" child border-bottom pb-3 mb-3 d-flex flex-wrap gap-2 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                    <img src="/assets/images/pdf.png" style="width: 30px; height: 30px;" alt="pdf">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h3 class="fw-semibold fs-14 mb-0">Blood Report.pdf</h3>
                                                        <span class="fs-12">submitted by <span class="text-secondary">Jonathon</span></span>
                                                    </div>
                                                </div>
                                                <button class="p-0 border-0 bg-transparent text-primary">
                                                    <span class="material-symbols-outlined">download</span>
                                                </button>
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
                <footer class="footer-area bg-white text-center rounded-top-7 mx-auto w-100" style="max-width: 1120px;">
                    <p class="fs-14">© <span class="text-primary-div">Trezo</span> is Proudly Owned by <a href="https://envytheme.com/" target="_blank" class="text-decoration-none text-primary">EnvyTheme</a></p>
                </footer>
                <!-- End Footer Area -->
			</div>
		</div>

        
        @include('partials.theme_settings')
        @include('partials.scripts')
    </body>
</html>
