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
                        <h3 class="mb-0">Widgets</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Widgets</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box position-relative">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between">
                                        <div class="mb-35">
                                            <span>Revenue Growth</span>
                                            <h3 class="fs-20 mt-1 mb-0">$32,420</h3>
                                        </div>
                                        <div id="revenue_growth" class="chart-position"></div>
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                        <span class="count up fw-medium ms-0">+10%</span>
                                        <span class="fs-12">Last 7 days</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box position-relative">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between">
                                        <div class="mb-35">
                                            <span>Lead Conversion</span>
                                            <h3 class="fs-20 mt-1 mb-0">48.79%</h3>
                                        </div>
                                        <div id="lead_conversion" class="chart-position"></div>
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                        <span class="count fw-medium ms-0">-15%</span>
                                        <span class="fs-12">Last 30 days </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box position-relative">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between">
                                        <div class="mb-35">
                                            <span>Total Orders</span>
                                            <h3 class="fs-20 mt-1 mb-0">$72,458</h3>
                                        </div>
                                        <div id="total_orders2" class="chart-position"></div>
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                        <span class="count up fw-medium ms-0">+25%</span>
                                        <span class="fs-12">Last 90 days</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box position-relative">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between">
                                        <div class="mb-35">
                                            <span>Annual Profit</span>
                                            <h3 class="fs-20 mt-1 mb-0">$879.6k</h3>
                                        </div>
                                        <div id="annual_profit" class="chart-position"></div>
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                                        <span class="count up fw-medium ms-0">+30%</span>
                                        <span class="fs-12">Last 12 months</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-3">
                                    <span>Tickets Resolved</span>
                                    <h3 class="mb-0 fs-20">2.4k</h3>
                                    <div id="tickets_resolved" style="margin: -11px 0;"></div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fs-12">This Month</span>
                                        <i class="material-symbols-outlined text-success">trending_up</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-3">
                                    <span>In Progress</span>
                                    <h3 class="mb-0 fs-20">1.35k</h3>
                                    <div id="in_progress" style="margin: -11px 0;"></div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fs-12">This Month</span>
                                        <i class="material-symbols-outlined text-danger">trending_down</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-3">
                                    <span>Tickets Due</span>
                                    <h3 class="mb-0 fs-20">980</h3>
                                    <div id="tickets_due" style="margin: -11px 0;"></div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fs-12">This Month</span>
                                        <i class="material-symbols-outlined text-danger">trending_down</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-3">
                                    <span>Tickets New Open</span>
                                    <h3 class="mb-0 fs-20">3.25k</h3>
                                    <div id="tickets_new_open" style="margin: -11px 0;"></div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fs-12">This Month</span>
                                        <i class="material-symbols-outlined text-success">trending_up</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
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
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                        <div>
                                            <div class="d-flex">
                                                <span>Total Customers</span>
                                                <span class="count up">+5.4</span>
                                            </div>
                                            <h3 class="fs-20 mt-1 mb-0">1,528</h3>
                                        </div>
                                        <span class="fs-12">Last 7 days</span>
                                    </div>
                                    <div style="max-width: 290px; margin: auto; margin-top: -32px; margin-bottom: -19px;">
                                        <div id="total_customers"></div>
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                        <span class="fs-12">1 June</span>
                                        <span class="fs-12">7 June</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                        <div>
                                            <div class="d-flex">
                                                <span>Total Orders</span>
                                                <span class="count">-7.6%</span>
                                            </div>
                                            <h3 class="fs-20 mt-1 mb-0">$72,458</h3>
                                        </div>
                                        <span class="fs-12">Last 7 days</span>
                                    </div>
                                    <div style="max-width: 153px; margin: auto; margin-top: -24px;  margin-bottom: -14px;">
                                        <div id="total_orders1"></div>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled stats-list">
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span class="title">Completed</span>
                                            <span>62%</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span class="title">Pending payment</span>
                                            <span>38%</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4 stats-box">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                        <div>
                                            <div class="d-flex">
                                                <span>Total Revenue</span>
                                                <span class="count up">+10%</span>
                                            </div>
                                            <h3 class="fs-20 mt-1 mb-0">$165,458</h3>
                                        </div>
                                        <span class="fs-12">Last 30 days</span>
                                    </div>
                                    <div style="max-width: 196px; margin: auto; margin-top: -22px; margin-bottom: -13px;">
                                        <div id="total_evenue"></div>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled stats-list">
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span class="title">Fashion</span>
                                            <span>75%</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span class="title">Others</span>
                                            <span>25%</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                                                <a href="my-profile.html">
                                                                    <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                </a>
                                                            </li>
                                                            <li class="ms-m-15">
                                                                <a href="my-profile.html">
                                                                    <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                </a>
                                                            </li>
                                                            <li class="ms-m-15">
                                                                <a href="my-profile.html">
                                                                    <img src="/assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                </a>
                                                            </li>
                                                            <li class="ms-m-15">
                                                                <a href="my-profile.html">
                                                                    <img src="/assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                </a>
                                                            </li>
                                                            <li class="ms-m-15">
                                                                <a href="user-list.html" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+55</a>
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
                                                    <a href="course-details.html" class="btn border-color-white text-white py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg">
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
                                                    <a href="course-details.html" class="btn border-color-white text-white py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg">
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

                                    <div style="margin: -5px -9px -28px -16px;">
                                        <div id="project_analysis"></div>
                                    </div>
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
