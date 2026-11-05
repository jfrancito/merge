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
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="card border-0 rounded-3 bg-white position-relative z-1 mb-4" style="padding: 10px;">
                                <div class="row g-2" style="--bs-gutter-x: 10px;">
                                    <div class="col-md-4">
                                        <div class="card border-0 rounded-3 bg-primary-70 position-relative z-1 welcome-for-hotel" style="padding: 20px;">
                                            <div class="d-flex d-md-block justify-content-between align-items-center">
                                                <div>
                                                    <span class="d-block">New Bookings</span>
                                                    <h3 class="fs-28 fw-900 mt-6 mb-11 lh-1">1540</h3>
                                                    <div>
                                                        <span class="d-inline-block bg-card-text-c border-danger-50 border px-2 rounded-pill text-danger-50 fs-12 fw-medium">-4.15%</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end" style="margin-top: -15px;">
                                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-end" style="width: 79px; height: 79px;">
                                                        <img src="/assets/images/add-event2.svg" alt="add-event2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-0 rounded-3 bg-card-text-c position-relative z-1 welcome-for-hotel" style="padding: 20px;">
                                            <div class="d-flex d-md-block justify-content-between align-items-center">
                                                <div>
                                                    <span class="d-block">Check In</span>
                                                    <h3 class="fs-28 fw-900 mt-6 mb-11 lh-1">245</h3>
                                                    <div>
                                                        <span class="d-inline-block bg-success-80 border-success-60 border px-2 rounded-pill text-success-60 fs-12 fw-medium">+3.4%</span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-end" style="margin-top: -15px;">
                                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-end" style="width: 79px; height: 79px;">
                                                        <img src="/assets/images/check-in-desk.svg" alt="check-in-desk">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-0 rounded-3 bg-primary-div-60 position-relative z-1 welcome-for-hotel" style="padding: 20px;">
                                            <div class="d-flex d-md-block justify-content-between align-items-center">
                                                <div>
                                                    <span class="d-block">Check Out</span>
                                                    <h3 class="fs-28 fw-900 mt-6 mb-11 lh-1">315</h3>
                                                    <div>
                                                        <span class="d-inline-block bg-card-text-c border-danger-50 border px-2 rounded-pill text-danger-50 fs-12 fw-medium">-1.4%</span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-end" style="margin-top: -15px;">
                                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-end" style="width: 79px; height: 79px;">
                                                        <img src="/assets/images/point.svg" alt="point">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-lg-6">
                                    <div class="card bg-white border-0 rounded-3">
                                        <div class="p-25">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-0">
                                                <h3 class="mb-0">Rooms Availability</h3>
                                                <div class="dropdown select-dropdown">
                                                    <button class="dropdown-toggle border text-body rounded-2 bg-gray-100" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Daily
                                                    </button>
                                                    
                                                    <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                        <li>
                                                            <button class="dropdown-item text-secondary py-2 px-3">Daily</button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-secondary py-2 px-3">Weekly</button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-secondary py-2 px-3">Monthly</button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-secondary py-2 px-3">Yearly</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <div style="margin: -17px 0 0 0;">
                                                <div id="rooms_availability_chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card border-0 rounded-3" style="background-color: #1F64F1;">
                                        <div class="p-25">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-20">
                                                <h3 class="mb-0 text-white">Guest Activity</h3>
                                                <div class="dropdown select-dropdown">
                                                    <button class="dropdown-toggle border text-white rounded-2 bg-gray-100 after-opacity" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #ffffff1a !important; border: none !important;">
                                                        Daily
                                                    </button>
                                                    
                                                    <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                        <li>
                                                            <button class="dropdown-item text-secondary py-2 px-3">Daily</button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-secondary py-2 px-3">Weekly</button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-secondary py-2 px-3">Monthly</button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-secondary py-2 px-3">Yearly</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <div style="margin: -20px -20px -20px -12px;">
                                                <div id="guest_activity_chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 rounded-3 bg-white position-relative z-1 mb-4 p-25">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-1">
                                    <h3 class="mb-0">Upcoming VIP Reservations</h3>
                                    <div class="dropdown select-dropdown">
                                        <button class="dropdown-toggle border text-body rounded-2 bg-gray-100" data-bs-toggle="dropdown" aria-expanded="false">
                                            Monthly
                                        </button>
                                        
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Weekly</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Monthly</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Yearly</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="default-table-area style-two upcoming-vip-reservations-table">
                                    <div class="table-responsive">
                                        <table class="table align-middle border-0">
                                            <thead>
                                                <tr class="border-bottom">
                                                    <th scope="col" class="bg-transparent text-body fw-medium">
                                                        <span class="fs-10 text-body fw-bold letter-spacing-1">CODE</span>
                                                    </th>
                                                    <th scope="col" class="bg-transparent text-body fw-medium">
                                                        <span class="fs-10 text-body fw-bold letter-spacing-1">ROOM</span>
                                                    </th>
                                                    <th scope="col" class="bg-transparent text-body fw-medium">
                                                        <span class="fs-10 text-body fw-bold letter-spacing-1">CUSTOMER</span>
                                                    </th>
                                                    <th scope="col" class="bg-transparent text-body fw-medium">
                                                        <span class="fs-10 text-body fw-bold letter-spacing-1">DURATION</span>
                                                    </th>
                                                    <th scope="col" class="text-end bg-transparent text-body fw-medium">
                                                        <span class="fs-10 text-body fw-bold letter-spacing-1 opacity-0">ACTION</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="fs-12 fw-semibold text-body">TRZ-32</td>
                                                    <td>
                                                        <a href="/room-details" class="fs-14 fw-semibold text-secondary">Duluxe Room - G - 3215</a>
                                                    </td>
                                                    <td class="fs-12 fw-semibold text-body-color-50">Angela Carter</td>
                                                    <td>
                                                        <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">10 Dec - 15 Dec</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                            </button>
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
                                                            </button>
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fs-12 fw-semibold text-body">TRZ-34</td>
                                                    <td>
                                                        <a href="/room-details" class="fs-14 fw-semibold text-secondary">Sweet Suite - S - 1265</a>
                                                    </td>
                                                    <td class="fs-12 fw-semibold text-body-color-50">Walter White</td>
                                                    <td>
                                                        <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">12 Dec - 16 Dec</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                            </button>
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
                                                            </button>
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fs-12 fw-semibold text-body">TRZ-42</td>
                                                    <td>
                                                        <a href="/room-details" class="fs-14 fw-semibold text-secondary">The Queensland - Q32</a>
                                                    </td>
                                                    <td class="fs-12 fw-semibold text-body-color-50">Zennifer Loren</td>
                                                    <td>
                                                        <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">15 Dec - 20 Dec</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                            </button>
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
                                                            </button>
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fs-12 fw-semibold text-body">TRZ-15</td>
                                                    <td>
                                                        <a href="/room-details" class="fs-14 fw-semibold text-secondary">Sweet Suite - S - 3214</a>
                                                    </td>
                                                    <td class="fs-12 fw-semibold text-body-color-50">Johna Mandala</td>
                                                    <td>
                                                        <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">11 Dec - 14 Dec</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                            </button>
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
                                                            </button>
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fs-12 fw-semibold text-body">TRZ-29</td>
                                                    <td>
                                                        <a href="/room-details" class="fs-14 fw-semibold text-secondary">Duluxe Room - F - 7213</a>
                                                    </td>
                                                    <td class="fs-12 fw-semibold text-body-color-50">Viktor James</td>
                                                    <td>
                                                        <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">10 Dec - 15 Dec</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                            </button>
                                                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                                <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
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
    
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-10">
                                        <span class="fs-12 fw-medium">Showing 5 of 36 Results</span>
        
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
                                                    <button class="page-link">3</button>
                                                </li>
                                                <li class="page-item">
                                                    <button class="page-link">4</button>
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
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="p-25">
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3 mb-4">
                                        <h3 class="fs-18 fw-bold mb-0">Recent Bookings</h3>
                                        <div>
                                            <div class="d-flex align-items-center bg-gray-100 py-2 px-3 rounded-2 for-dark-digital-date">
                                                <div id="digital_date_schedule_bookings"></div>
                                                <i class="ri-calendar-2-line ms-2 fs-18 lh-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="calendar-container style-three">
                                        <div class="calendar-header">
                                            <button id="prevMonth" class="change-btn">
                                                <i class="ri-arrow-left-s-line"></i>
                                            </button>
                                            <div id="month-year" class="month-year-display fs-14 fw-medium text-secondary">
                                                <!-- Month and year will be inserted here -->
                                            </div>
                                            <button id="nextMonth" class="change-btn">
                                                <i class="ri-arrow-right-s-line"></i>
                                            </button>
                                        </div>
                                      
                                        <table class="calendar-table">
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
                                            <tbody id="calendar-body">
                                                <!-- Calendar days will be dynamically generated here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="p-25 pt-0 pe-0">
                                    <div class="last-child-none pe-4 recent-room-bookings" data-simplebar="" style="height: 505px;">
                                        <a href="/room-details" class="mb-3 pb-3 border-bottom border-border-color child d-flex justify-content-between align-items-center flex-wrap gap-3 text-decoration-none">
                                            <div class="d-flex align-items-center" style="gap: 15px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/room-5.jpg" class="rounded-1" style="max-width: 80px;" alt="room">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h3 class="fs-14 fw-semibold mb-6">Duluxe Room - G - 3215</h3>
                                                    <span class="d-block fs-12 mb-9 text-body">Booked by Angela Carter</span>
                                                    <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">10 Dec - 15 Dec</span>
                                                </div>
                                            </div>
                                            <i class="ri-arrow-right-line wh-30 d-flex d-lg-none d-xxl-flex justify-content-center align-items-center bg-border-color rounded-circle hover-bg"></i>
                                        </a>
                                        <a href="/room-details" class="mb-3 pb-3 border-bottom border-border-color child d-flex justify-content-between align-items-center flex-wrap gap-3 text-decoration-none">
                                            <div class="d-flex align-items-center" style="gap: 15px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/room-6.jpg" class="rounded-1" style="max-width: 80px;" alt="room">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h3 class="fs-14 fw-semibold mb-6">The Garden Suite 101</h3>
                                                    <span class="d-block fs-12 mb-9 text-body">Booked by Jack Smith</span>
                                                    <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">12 Dec - 16 Dec</span>
                                                </div>
                                            </div>
                                            <i class="ri-arrow-right-line wh-30 d-flex d-lg-none d-xxl-flex justify-content-center align-items-center bg-border-color rounded-circle hover-bg"></i>
                                        </a>
                                        <a href="/room-details" class="mb-3 pb-3 border-bottom border-border-color child d-flex justify-content-between align-items-center flex-wrap gap-3 text-decoration-none">
                                            <div class="d-flex align-items-center" style="gap: 15px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/room-7.jpg" class="rounded-1" style="max-width: 80px;" alt="room">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h3 class="fs-14 fw-semibold mb-6">The Tranquil S-02</h3>
                                                    <span class="d-block fs-12 mb-9 text-body">Booked by Jennifer Anderson</span>
                                                    <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">15 Dec - 20 Dec</span>
                                                </div>
                                            </div>
                                            <i class="ri-arrow-right-line wh-30 d-flex d-lg-none d-xxl-flex justify-content-center align-items-center bg-border-color rounded-circle hover-bg"></i>
                                        </a>
                                        <a href="/room-details" class="mb-3 pb-3 border-bottom border-border-color child d-flex justify-content-between align-items-center flex-wrap gap-3 text-decoration-none">
                                            <div class="d-flex align-items-center" style="gap: 15px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/room-8.jpg" class="rounded-1" style="max-width: 80px;" alt="room">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h3 class="fs-14 fw-semibold mb-6">The Queen - X - 231</h3>
                                                    <span class="d-block fs-12 mb-9 text-body">Booked by Angela Carter</span>
                                                    <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">11 Dec - 14 Dec</span>
                                                </div>
                                            </div>
                                            <i class="ri-arrow-right-line wh-30 d-flex d-lg-none d-xxl-flex justify-content-center align-items-center bg-border-color rounded-circle hover-bg"></i>
                                        </a>
                                        <a href="/room-details" class="mb-3 pb-3 border-bottom border-border-color child d-flex justify-content-between align-items-center flex-wrap gap-3 text-decoration-none">
                                            <div class="d-flex align-items-center" style="gap: 15px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/room-5.jpg" class="rounded-1" style="max-width: 80px;" alt="room">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h3 class="fs-14 fw-semibold mb-6">Duluxe Room - G - 3215</h3>
                                                    <span class="d-block fs-12 mb-9 text-body">Booked by Angela Carter</span>
                                                    <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">10 Dec - 15 Dec</span>
                                                </div>
                                            </div>
                                            <i class="ri-arrow-right-line wh-30 d-flex d-lg-none d-xxl-flex justify-content-center align-items-center bg-border-color rounded-circle hover-bg"></i>
                                        </a>
                                        <a href="/room-details" class="mb-3 pb-3 border-bottom border-border-color child d-flex justify-content-between align-items-center flex-wrap gap-3 text-decoration-none">
                                            <div class="d-flex align-items-center" style="gap: 15px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/room-6.jpg" class="rounded-1" style="max-width: 80px;" alt="room">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h3 class="fs-14 fw-semibold mb-6">The Garden Suite 101</h3>
                                                    <span class="d-block fs-12 mb-9 text-body">Booked by Jack Smith</span>
                                                    <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">12 Dec - 16 Dec</span>
                                                </div>
                                            </div>
                                            <i class="ri-arrow-right-line wh-30 d-flex d-lg-none d-xxl-flex justify-content-center align-items-center bg-border-color rounded-circle hover-bg"></i>
                                        </a>
                                        <a href="/room-details" class="mb-3 pb-3 border-bottom border-border-color child d-flex justify-content-between align-items-center flex-wrap gap-3 text-decoration-none">
                                            <div class="d-flex align-items-center" style="gap: 15px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/room-7.jpg" class="rounded-1" style="max-width: 80px;" alt="room">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h3 class="fs-14 fw-semibold mb-6">The Tranquil S-02</h3>
                                                    <span class="d-block fs-12 mb-9 text-body">Booked by Jennifer Anderson</span>
                                                    <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">15 Dec - 20 Dec</span>
                                                </div>
                                            </div>
                                            <i class="ri-arrow-right-line wh-30 d-flex d-lg-none d-xxl-flex justify-content-center align-items-center bg-border-color rounded-circle hover-bg"></i>
                                        </a>
                                        <a href="/room-details" class="mb-3 pb-3 border-bottom border-border-color child d-flex justify-content-between align-items-center flex-wrap gap-3 text-decoration-none">
                                            <div class="d-flex align-items-center" style="gap: 15px;">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/room-8.jpg" class="rounded-1" style="max-width: 80px;" alt="room">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h3 class="fs-14 fw-semibold mb-6">The Queen - X - 231</h3>
                                                    <span class="d-block fs-12 mb-9 text-body">Booked by Angela Carter</span>
                                                    <span class="bg-border-color-50 fs-12 fw-medium text-primary d-inline-block rounded-1" style="padding: 3px 8px;">11 Dec - 14 Dec</span>
                                                </div>
                                            </div>
                                            <i class="ri-arrow-right-line wh-30 d-flex d-lg-none d-xxl-flex justify-content-center align-items-center bg-border-color rounded-circle hover-bg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-0 rounded-3 bg-white position-relative z-1 mb-4 p-25 popular-rooms-bg">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                            <h3 class="mb-0">Popular Rooms</h3>
                            <div class="">
                                <div class="swiper-pagination-popular-rooms"></div>
                            </div>
                        </div>
                        
                        <div class="swiper popular-rooms-slide">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <a href="/room-details" class="text-decoration-none position-relative d-block">
                                        <img src="/assets/images/room-1.jpg" class="rounded-3" alt="room">

                                        <h3 class="mt-3 mb-6 fs-16 fw-semibold hover">The Velvet - F - 32045</h3>
                                        <span class="text-body">Code <strong class="fw-semibold">SJ-32056</strong></span>
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="d-inline-block bg-card-text-c border-danger-50 border px-2 rounded-pill text-danger-50 fs-12 fw-medium">Booked</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="/room-details" class="text-decoration-none position-relative d-block">
                                        <img src="/assets/images/room-2.jpg" class="rounded-3" alt="room">

                                        <h3 class="mt-3 mb-6 fs-16 fw-semibold hover">Duluxe Room - G - 3215</h3>
                                        <span class="text-body">Code <strong class="fw-semibold">SJ-32056</strong></span>
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="d-inline-block bg-success-80 border-success-60 border px-2 rounded-pill text-success-60 fs-12 fw-medium">Available</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="/room-details" class="text-decoration-none position-relative d-block">
                                        <img src="/assets/images/room-3.jpg" class="rounded-3" alt="room">

                                        <h3 class="mt-3 mb-6 fs-16 fw-semibold hover">The Garden Suite 101</h3>
                                        <span class="text-body">Code <strong class="fw-semibold">SJ-32056</strong></span>
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="d-inline-block bg-card-text-c border-danger-50 border px-2 rounded-pill text-danger-50 fs-12 fw-medium">Booked</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="/room-details" class="text-decoration-none position-relative d-block">
                                        <img src="/assets/images/room-4.jpg" class="rounded-3" alt="room">

                                        <h3 class="mt-3 mb-6 fs-16 fw-semibold hover">The Tranquil S-02</h3>
                                        <span class="text-body">Code <strong class="fw-semibold">SJ-32056</strong></span>
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="d-inline-block bg-success-80 border-success-60 border px-2 rounded-pill text-success-60 fs-12 fw-medium">Available</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="/room-details" class="text-decoration-none position-relative d-block">
                                        <img src="/assets/images/room-1.jpg" class="rounded-3" alt="room">

                                        <h3 class="mt-3 mb-6 fs-16 fw-semibold hover">The Velvet - F - 32045</h3>
                                        <span class="text-body">Code <strong class="fw-semibold">SJ-32056</strong></span>
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="d-inline-block bg-card-text-c border-danger-50 border px-2 rounded-pill text-danger-50 fs-12 fw-medium">Booked</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="/room-details" class="text-decoration-none position-relative d-block">
                                        <img src="/assets/images/room-2.jpg" class="rounded-3" alt="room">

                                        <h3 class="mt-3 mb-6 fs-16 fw-semibold hover">Duluxe Room - G - 3215</h3>
                                        <span class="text-body">Code <strong class="fw-semibold">SJ-32056</strong></span>
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="d-inline-block bg-success-80 border-success-60 border px-2 rounded-pill text-success-60 fs-12 fw-medium">Available</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="/room-details" class="text-decoration-none position-relative d-block">
                                        <img src="/assets/images/room-3.jpg" class="rounded-3" alt="room">

                                        <h3 class="mt-3 mb-6 fs-16 fw-semibold hover">The Garden Suite 101</h3>
                                        <span class="text-body">Code <strong class="fw-semibold">SJ-32056</strong></span>
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="d-inline-block bg-card-text-c border-danger-50 border px-2 rounded-pill text-danger-50 fs-12 fw-medium">Booked</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="/room-details" class="text-decoration-none position-relative d-block">
                                        <img src="/assets/images/room-4.jpg" class="rounded-3" alt="room">

                                        <h3 class="mt-3 mb-6 fs-16 fw-semibold hover">The Tranquil S-02</h3>
                                        <span class="text-body">Code <strong class="fw-semibold">SJ-32056</strong></span>
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="d-inline-block bg-success-80 border-success-60 border px-2 rounded-pill text-success-60 fs-12 fw-medium">Available</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-1">
                                <h3 class="mb-0">Customer Reviews</h3>
                                <div class="dropdown select-dropdown">
                                    <button class="dropdown-toggle border text-body rounded-2 bg-gray-100" data-bs-toggle="dropdown" aria-expanded="false">
                                        Top Rated
                                    </button>
                                    
                                    <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">5 Star</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">4 Star</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">3 Star</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">2 Star</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-secondary py-2 px-3">1 Star</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="default-table-area style-two campaigns-table customer-ratings-table px-20">
                                <div class="table-responsive">
                                    <table class="table border-0">
                                        <thead>
                                            <tr class="border-bottom">
                                                <th scope="col" class=" bg-transparent">
                                                    <span class="fs-10 text-body fw-bold letter-spacing-1">USER ID</span>
                                                </th>
                                                <th scope="col" class="bg-transparent">
                                                    <span class="fs-10 text-body fw-bold letter-spacing-1">CUSTOMER NAME</span>
                                                </th>
                                                <th scope="col" class="bg-transparent">
                                                    <span class="fs-10 text-body fw-bold letter-spacing-1">RATINGS</span>
                                                </th>
                                                <th scope="col" class="bg-transparent">
                                                    <span class="fs-10 text-body fw-bold letter-spacing-1">REVIEWS</span>
                                                </th>
                                                <th scope="col" class="bg-transparent">
                                                    <span class="fs-10 text-body fw-bold letter-spacing-1">DATE</span>
                                                </th>
                                                <th scope="col" class="text-end bg-transparent opacity-0">
                                                    <span class="fs-10 text-body fw-bold letter-spacing-1">ACTION</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50 border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">#001</td>
                                                <td class="border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-166.png" class="rounded-circle" style="width: 30px; height: 30px;" alt="order">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Joanna Watson</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="text-danger ri-star-fill"></i>
                                                        <span class="fs-12 fw-semibold text-body position-relative top-1">5.0</span>
                                                    </div>
                                                </td>
                                                <td class="border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">
                                                    <h4 class="fs-12 fw-semibold text-secondary mb-1">Amazing Ambiance and Delicious Food!</h4>
                                                    <p class="fs-12 text-body" style="max-width: 617px; line-height: 1.8;">Trezo was a fantastic dining experience. The ambiance is warm and inviting, perfect for a date night or celebration. I ordered the truffle pasta, which was rich and perfectly seasoned. The service was impeccable, and the staff made us feel like family. Highly recommend! </p>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">13 Nov, 25</td> 
                                                <td class="text-end border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">
                                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50 border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">#002</td>
                                                <td class="border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-167.png" class="rounded-circle" style="width: 30px; height: 30px;" alt="order">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Jenelia Anderson</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="text-danger ri-star-fill"></i>
                                                        <span class="fs-12 fw-semibold text-body position-relative top-1">4.9</span>
                                                    </div>
                                                </td>
                                                <td class="border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">
                                                    <h4 class="fs-12 fw-semibold text-secondary mb-1">Best Brunch Spot in Town</h4>
                                                    <p class="fs-12 text-body" style="max-width: 617px; line-height: 1.8;">Visited Trezo for brunch with friends, and it exceeded our expectations. The avocado toast was fresh, and their mimosas were spot-on. Our server was attentive without being intrusive. Definitely coming back!</p>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">14 Nov, 25</td> 
                                                <td class="text-end border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">
                                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fs-12 fw-semibold text-body-color-50 border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">#001</td>
                                                <td class="border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-168.png" class="rounded-circle" style="width: 30px; height: 30px;" alt="order">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h4 class="fs-14 fw-semibold mb-0 text-secondary-50">Jonathon Ronan</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="text-danger ri-star-fill"></i>
                                                        <span class="fs-12 fw-semibold text-body position-relative top-1">4.0</span>
                                                    </div>
                                                </td>
                                                <td class="border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">
                                                    <h4 class="fs-12 fw-semibold text-secondary mb-1">Good Food, Slow Service</h4>
                                                    <p class="fs-12 text-body" style="max-width: 617px; line-height: 1.8;">The food at Trezo was delicious, but the service was a bit slow. We had to wait a while for our appetizers, and our main course was delayed. It’s a nice spot, but they could work on speeding up their service.</p>
                                                </td>
                                                <td class="fs-12 fw-semibold text-body border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">12 Nov, 25</td> 
                                                <td class="text-end border-border-color-50" style="padding-top: 17px; padding-bottom: 17px;">
                                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary-div-50">edit</i>
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

                                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-3">
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
                                                <button class="page-link">3</button>
                                            </li>
                                            <li class="page-item">
                                                <button class="page-link">4</button>
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
