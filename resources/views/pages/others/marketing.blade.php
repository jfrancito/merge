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
                        <div class="col-sm-6 col-xxl-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 me-3">
                                            <span class="d-block mb-1">Ad Spend</span>
                                            <h2 class="text-secondary fs-32">$1,528</h2>
                                            <span class="d-inline-block bg-success bg-opacity-10 border-success border px-2 rounded-pill text-success mb-1 fs-12 fw-medium">+5.4%</span>
                                            <p class="fs-12">vs previous 30 days</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/ads.gif" style="width: 60px;" alt="ads">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 me-3">
                                            <span class="d-block mb-1">Cost Per Thousand</span>
                                            <h2 class="text-secondary fs-32">$3.95</h2>
                                            <span class="d-inline-block bg-danger bg-opacity-10 border-danger border px-2 rounded-pill text-danger mb-1 fs-12 fw-medium">-1.4%</span>
                                            <p class="fs-12">vs previous 30 days</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/video-advertising.gif" style="width: 60px;" alt="video-advertising">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 me-3">
                                            <span class="d-block mb-1">Cost Per Click</span>
                                            <h2 class="text-secondary fs-32">$0.15</h2>
                                            <span class="d-inline-block bg-danger bg-opacity-10 border-danger border px-2 rounded-pill text-danger mb-1 fs-12 fw-medium">-0.04%</span>
                                            <p class="fs-12">vs previous 30 days</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/call-to-action.gif" style="width: 60px;" alt="call-to-action">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 me-3">
                                            <span class="d-block mb-1">Click Through Rate</span>
                                            <h2 class="text-secondary fs-32">$2.95</h2>
                                            <span class="d-inline-block bg-success bg-opacity-10 border-success border px-2 rounded-pill text-success mb-1 fs-12 fw-medium">+7%</span>
                                            <p class="fs-12">vs previous 30 days</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/banner.gif" style="width: 60px;" alt="banner">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0">Performance Overview</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color" aria-label="Default select example">
                                            <option selected>Last Week</option>
                                            <option value="1">Last 60 Days</option>
                                            <option value="2">Last 90 Days</option>
                                        </select>
                                    </div>
                                    <div style="margin: -25px -10px -17px -17px;">
                                        <div id="performance_overview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="border-0 rounded-3 mb-4 text-center" style="background: linear-gradient(150deg, #827CD8 0.57%, #2D2761 95.93%);">
                                <div class="card-body p-4 text-center">
                                    <span class="fs-24 d-block text-white">Have You Tried Our</span>
                                    <h3 class="fs-24 text-white">New Mobile App?</h3>
                                    <div class="py-4 mb-3">
                                        <img src="/assets/images/app.png" alt="app">
                                    </div>
                                    <a href="#" class="d-inline-block py-2 px-3 btn btn-primary">
                                        Download Mobile App
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="border-0 rounded-3 mb-4 for-dark" style="background-color: #EBDCD5;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0">Highlights</h3>
                                        <span class="fs-12" style="color: #82716F;">Last 7 days</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled">
                                        <li class="d-flex justify-content-between border-bottom pb-3 mb-3" style="border-color: #E3D1C9 !important;">
                                            <div class="d-flex align-items-center">
                                                <i class="ri-star-fill fs-17" style="color: #FD5812;"></i>
                                                <span class="ms-2" style="color: #82716F;">Average Client Rating</span>
                                            </div>
                                            <span style="color: #463938;"><i class="ri-arrow-up-line text-success fs-16"></i> 4.9/5.0</span>
                                        </li>
                                        <li class="d-flex justify-content-between border-bottom pb-3 mb-3" style="border-color: #E3D1C9 !important;">
                                            <div class="d-flex align-items-center">
                                                <i class="ri-instagram-fill fs-17" style="color: #FD5812;"></i>
                                                <span class="ms-2" style="color: #82716F;">Instagram Followers</span>
                                            </div>
                                            <span style="color: #463938;"><i class="ri-arrow-down-line text-danger fs-16"></i> 630K</span>
                                        </li>
                                        <li class="d-flex justify-content-between border-bottom pb-3 mb-3" style="border-color: #E3D1C9 !important;">
                                            <div class="d-flex align-items-center">
                                                <i class="ri-facebook-fill fs-17" style="color: #FD5812;"></i>
                                                <span class="ms-2" style="color: #82716F;">Facebook Followers</span>
                                            </div>
                                            <span style="color: #463938;"><i class="ri-arrow-up-line text-success fs-16"></i> 630K</span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <i class="ri-google-fill fs-17" style="color: #FD5812;"></i>
                                                <span class="ms-2" style="color: #82716F;">Google Ads CPC</span>
                                            </div>
                                            <span style="color: #463938;"><i class="ri-arrow-up-line text-success fs-16"></i> $3.58</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="mb-3 mb-lg-30">
                                        <h3 class="mb-0">Channels</h3>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled">
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/facebook.svg" style="width: 31px;" alt="facebook">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Facebook</h4>
                                                            <span class="fs-12">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #DDE4FF;" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 50%; height: 8px; background-color: #757DFF;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">50%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/dribbble.svg" style="width: 31px;" alt="dribbble">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Dribbble</h4>
                                                            <span class="fs-12">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #DAEBFF;" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 75%; height: 8px; background-color: #5DA8FF;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">75%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/instagram.svg" style="width: 31px;" alt="instagram">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Instagram</h4>
                                                            <span class="fs-12">Reel</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #FFE8D4;" role="progressbar" aria-label="Example with label" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 30%; height: 8px; background-color: #FE7A36;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">30%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/behance.svg" style="width: 31px;" alt="behance">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Behance</h4>
                                                            <span class="fs-12">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #F3E8FF;" role="progressbar" aria-label="Example with label" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 80%; height: 8px; background-color: #BF85FB;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">80%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/figma.svg" style="width: 31px;" alt="figma">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Figma</h4>
                                                            <span class="fs-12">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #DAEBFF;" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 50%; height: 8px; background-color: #5DA8FF;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">50%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/google2.svg" style="width: 31px;" alt="google">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Google</h4>
                                                            <span class="fs-12">SEO & PPC</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #D8FFC8;" role="progressbar" aria-label="Example with label" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 20%; height: 8px; background-color: #58F229;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">20%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                                        <h3 class="mb-0">Campaigns</h3>
                                        <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <span class="py-sm-1 d-block">
                                                <i class="ri-add-line d-none d-sm-inline-block"></i>
                                                <span>Add Campaigns</span>
                                            </span>
                                        </button>
                                    </div>

                                    <style>
                                        .nav-tabs .nav-item .nav-link.active {
                                            color: #4936F5 !important;
                                        }
                                    </style>

                                    <ul class="nav nav-tabs bg-transparent border-bottom gap-2 gap-sm-5 pb-4" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link p-0 bg-transparent border-0 fs-12 fw-medium text-body active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" type="button" role="tab" aria-controls="all-tab-pane" aria-selected="true">ALL (05)</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link p-0 bg-transparent border-0 fs-12 fw-medium text-body" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tab-pane" type="button" role="tab" aria-controls="pending-tab-pane" aria-selected="false">PENDING(05)</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link p-0 bg-transparent border-0 fs-12 fw-medium text-body" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed-tab-pane" type="button" role="tab" aria-controls="completed-tab-pane" aria-selected="false">COMPLETED(07)</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                                            <div class="default-table-area style-two campaigns-table">
                                                <div class="table-responsive">
                                                    <table class="table align-middle border-0">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-danger ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1">Christmas Eve</h4>
                                                                        <span class="fs-12">From 10 Oct - 15 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/facebook4.svg" alt="facebook">
                                                                        <img src="/assets/images/instagram2.svg" alt="instagram">
                                                                        <img src="/assets/images/google3.svg" alt="facebook">
                                                                        <img src="/assets/images/linkedin2.svg" alt="facebook">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-danger bg-opacity-10 rounded-2 text-danger">Live Now</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/users-list" class="wh-34 lh-34 rounded-circle d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white" style="background-color: #3A4252;">+3</a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-danger ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1">Teacher’s Day</h4>
                                                                        <span class="fs-12">From 08 Oct - 12 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/facebook4.svg" alt="facebook">
                                                                        <img src="/assets/images/instagram2.svg" alt="instagram">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Reviewing</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-25.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-26.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-27.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-primary ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1">ThanksGiving</h4>
                                                                        <span class="fs-12">From 01 Oct - 05 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/facebook4.svg" alt="facebook">
                                                                        <img src="/assets/images/google3.svg" alt="facebook">
                                                                        <img src="/assets/images/linkedin2.svg" alt="facebook">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-primary bg-opacity-10 rounded-2 text-primary">Paused</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-25.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-28.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-primary-div ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1">Team Gateway</h4>
                                                                        <span class="fs-12">From 05 Oct - 17 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/google3.svg" alt="facebook">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-danger bg-opacity-10 rounded-2 text-danger">Live Now</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-30.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-31.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-32.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-success ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1 text-secondary">Halloween</h4>
                                                                        <span class="fs-12">From 20 Oct - 31 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/facebook4.svg" alt="facebook">
                                                                        <img src="/assets/images/instagram2.svg" alt="instagram">
                                                                        <img src="/assets/images/google3.svg" alt="facebook">
                                                                        <img src="/assets/images/linkedin2.svg" alt="facebook">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Reviewing</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pending-tab-pane" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
                                            <div class="default-table-area style-two campaigns-table">
                                                <div class="table-responsive">
                                                    <table class="table align-middle border-0">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-primary ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1">ThanksGiving</h4>
                                                                        <span class="fs-12">From 01 Oct - 05 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/facebook4.svg" alt="facebook">
                                                                        <img src="/assets/images/google3.svg" alt="facebook">
                                                                        <img src="/assets/images/linkedin2.svg" alt="facebook">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Reviewing</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-25.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-28.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-primary-div ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1">Team Gateway</h4>
                                                                        <span class="fs-12">From 05 Oct - 17 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/google3.svg" alt="facebook">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Reviewing</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-30.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-31.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-32.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-success ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1 text-secondary">Halloween</h4>
                                                                        <span class="fs-12">From 20 Oct - 31 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/facebook4.svg" alt="facebook">
                                                                        <img src="/assets/images/instagram2.svg" alt="instagram">
                                                                        <img src="/assets/images/google3.svg" alt="facebook">
                                                                        <img src="/assets/images/linkedin2.svg" alt="facebook">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Reviewing</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-danger ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1">Christmas Eve</h4>
                                                                        <span class="fs-12">From 10 Oct - 15 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/facebook4.svg" alt="facebook">
                                                                        <img src="/assets/images/instagram2.svg" alt="instagram">
                                                                        <img src="/assets/images/google3.svg" alt="facebook">
                                                                        <img src="/assets/images/linkedin2.svg" alt="facebook">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Reviewing</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/users-list" class="wh-34 lh-34 rounded-circle d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white" style="background-color: #3A4252;">+3</a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-danger ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1">Teacher’s Day</h4>
                                                                        <span class="fs-12">From 08 Oct - 12 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/facebook4.svg" alt="facebook">
                                                                        <img src="/assets/images/instagram2.svg" alt="instagram">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Reviewing</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-25.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-26.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-27.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="completed-tab-pane" role="tabpanel" aria-labelledby="completed-tab" tabindex="0">
                                            <div class="default-table-area style-two campaigns-table">
                                                <div class="table-responsive">
                                                    <table class="table align-middle border-0">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-danger ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1">Christmas Eve</h4>
                                                                        <span class="fs-12">From 10 Oct - 15 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/facebook4.svg" alt="facebook">
                                                                        <img src="/assets/images/instagram2.svg" alt="instagram">
                                                                        <img src="/assets/images/google3.svg" alt="facebook">
                                                                        <img src="/assets/images/linkedin2.svg" alt="facebook">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-danger bg-opacity-10 rounded-2 text-danger">Live Now</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/users-list" class="wh-34 lh-34 rounded-circle d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white" style="background-color: #3A4252;">+3</a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-danger ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1">Teacher’s Day</h4>
                                                                        <span class="fs-12">From 08 Oct - 12 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/facebook4.svg" alt="facebook">
                                                                        <img src="/assets/images/instagram2.svg" alt="instagram">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-danger bg-opacity-10 rounded-2 text-danger">Live Now</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-25.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-26.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-27.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-primary ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1">ThanksGiving</h4>
                                                                        <span class="fs-12">From 01 Oct - 05 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/facebook4.svg" alt="facebook">
                                                                        <img src="/assets/images/google3.svg" alt="facebook">
                                                                        <img src="/assets/images/linkedin2.svg" alt="facebook">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-danger bg-opacity-10 rounded-2 text-danger">Live Now</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-25.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-28.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-primary-div ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1">Team Gateway</h4>
                                                                        <span class="fs-12">From 05 Oct - 17 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/google3.svg" alt="facebook">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-danger bg-opacity-10 rounded-2 text-danger">Live Now</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-30.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-31.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-32.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="border-start border-2 border-success ps-3 py-2">
                                                                        <h4 class="fs-14 fw-semibold mb-1 text-secondary">Halloween</h4>
                                                                        <span class="fs-12">From 20 Oct - 31 Oct, 24</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-3 gap-xl-2 gap-xxl-3 flex-wrap">
                                                                        <img src="/assets/images/facebook4.svg" alt="facebook">
                                                                        <img src="/assets/images/instagram2.svg" alt="instagram">
                                                                        <img src="/assets/images/google3.svg" alt="facebook">
                                                                        <img src="/assets/images/linkedin2.svg" alt="facebook">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="d-inline-block py-1 px-2 bg-danger bg-opacity-10 rounded-2 text-danger">Live Now</span>
                                                                </td>
                                                                <td>
                                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                                        <li>
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                        <li class="ms-m-15">
                                                                            <a href="/my-profile">
                                                                                <img src="/assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                        <i class="ri-arrow-right-line"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <div class="mb-4">
                                                <h3 style="margin-bottom: -2px;">External Links</h3>
                                            </div>

                                            <ul class="ps-0 mb-0 list-unstyled">
                                                <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <img src="/assets/images/google3.svg" style="width: 18px;" alt="google3">
                                                        <span class="text-primary fw-medium ms-2">Google Ad Analytics</span>
                                                    </div>
                                                    <a href="/marketing" class="text-decoration-none">
                                                        <i class="ri-external-link-line fs-20"></i>
                                                    </a>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <img src="/assets/images/instagram2.svg" style="width: 18px;" alt="google3">
                                                        <span class="text-primary fw-medium ms-2">Instagram Ads</span>
                                                    </div>
                                                    <a href="/marketing" class="text-decoration-none">
                                                        <i class="ri-external-link-line fs-20"></i>
                                                    </a>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <img src="/assets/images/facebook4.svg" style="width: 18px;" alt="google3">
                                                        <span class="text-primary fw-medium ms-2">Facebook Ads</span>
                                                    </div>
                                                    <a href="/marketing" class="text-decoration-none">
                                                        <i class="ri-external-link-line fs-20"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="rounded-3 mb-4 for-dark" style="background-color: #DDE4FF;">
                                        <div class="card-body p-4">
                                            <div class="mb-4">
                                                <h3 class="mb-0">Instagram Campaigns <span class="bg-danger bg-opacity-10 text-danger fs-12 py-1 px-2 rounded-1">Live Now</span></h3>
                                            </div>

                                            <div class="d-flex justify-content-between mb-3">
                                                <div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="d-inline-block rounded-circle bg-primary-div position-relative top-1" style="width: 10px; height: 10px;"></span>
                                                        <span class="ms-2">Campaign Budget</span>
                                                    </div>
                                                    <h3 class="fs-24 mb-0">$3200</h3>
                                                </div>
                                                <div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="d-inline-block rounded-circle bg-danger position-relative top-1" style="width: 10px; height: 10px;"></span>
                                                        <span class="ms-2">Followers Goal</span>
                                                    </div>
                                                    <h3 class="fs-24 mb-0">140,000</h3>
                                                </div>
                                            </div>
                                            
                                            <div style="margin: -55px -11px -30px -12px;">
                                                <div id="instagram_campaigns"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="border-0 rounded-3 mb-4 text-center" style="background: linear-gradient(162deg, #D7B5FD 3.82%, #9947F5 98.54%);">
                                <div class="card-body p-4 text-center">
                                    <span class="fs-24 d-block text-secondary">Want To Try</span>
                                    <h3 class="fs-24 text-secondary">New Marketing <br> Tool?</h3>
                                    <div class="py-4 mb-3">
                                        <img src="/assets/images/marketing-tool.png" alt="marketing-tool">
                                    </div>
                                    <a href="/contact" class="d-inline-block py-2 px-4 btn btn-primary border-0" style="background-color: #6A22A7;">
                                        Contact Us
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0">Instagram Subscriber</h3>
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

                                    <div style="margin: -25px -28px -16px -17px;">
                                        <div id="instagram_subscriber"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen w-100 p-lg-5">
                        <div class="modal-content">
                            <div class="modal-header border-0 p-4 p-md-5 pb-0">
                                <h1 class="modal-title fs-24" id="exampleModalLabel">Create Campaigns</h1>
                                <button type="button" class="btn-close campaigns-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4 p-md-5">
                                <ul class="tabs create-campaigns-tabs d-flex flex-wrap justify-content-between gap-2 list-unstyled pb-0">
                                    <li class="tab active">
                                        <button class="nav-link fs-12 fw-medium text-secondary border-0">
                                            CAMPAIGN DETAILS
                                        </button>
                                    </li>
                                    <li class="tab">
                                        <button class="nav-link fs-12 fw-medium text-secondary border-0">
                                            CREATIVE UPLOADS
                                        </button>
                                    </li>
                                    <li class="tab">
                                        <button class="nav-link fs-12 fw-medium text-secondary border-0">
                                            AUDIENCES
                                        </button>
                                    </li>
                                    <li class="tab">
                                        <button class="nav-link fs-12 fw-medium text-secondary border-0">
                                            BUDGET ESTIMATES
                                        </button>
                                    </li>
                                    <li class="tab">
                                        <button class="nav-link fs-12 fw-medium text-secondary border-0">
                                            COMPLETED
                                        </button>
                                    </li>
                                    <li class="tab">
                                        <button class="nav-link fs-12 fw-medium text-secondary border-0">
                                            VIEW CAMPAIGN
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content-wrap">
                                    <div class="tab-contents active back-none">
                                        <form class="campaign-stepper-content m-auto" style="max-width: 625px;">
                                            <h3 class="fs-18 mb-3 mb-md-5">Campaign Details</h3>
                
                                            <div class="mb-5">
                                                <label class="fw-semibold mb-2">Campaign Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control bg-border-color h-55 fs-16" placeholder="Christmas Eve">
                                            </div>
                                            <div class="mb-5">
                                                <label class="fw-semibold mb-2">Company Logo <span class="text-danger">*</span></label>
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                        <label for="imageUpload"></label>
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview" style="background-image: url(https://angular.envytheme.com/trezo-mt/images/admin.png);"></div>
                                                    </div>
                                                </div>
                                                <span class="fs-14 d-block mt-4">Allowed file types: png, jpg, jpeg. Max size: 1 MB</span>
                                            </div>
                                            <div class="mb-5">
                                                <label class="fw-semibold mb-2">Campaign Goal <span class="text-danger">*</span></label>
                                                
                                                <label for="radio5" class="custom-radio style-two mb-3 pb-3 border-bottom">
                                                    <input checked type="radio" class="form-check-input" name="radio" id="radio5"/>
                                                    <div class="radio-content">
                                                        <span class="fw-medium text-secondary mb-1 d-block">Get more visitors</span>
                                                        <p>Increase impression traffic onto the platform</p>
                                                    </div>
                                                </label>
                                                <label for="radio6" class="custom-radio style-two mb-3 pb-3 border-bottom">
                                                    <input type="radio" class="form-check-input" name="radio" id="radio6"/>
                                                    <div class="radio-content">
                                                        <span class="fw-medium text-secondary mb-1 d-block">Get more messages on chat</span>
                                                        <p>Increase community interaction and communication</p>
                                                    </div>
                                                </label>
                                                <label for="radio7" class="custom-radio style-two mb-3 pb-3 border-bottom">
                                                    <input type="radio" class="form-check-input" name="radio" id="radio7"/>
                                                    <div class="radio-content">
                                                        <span class="fw-medium text-secondary mb-1 d-block">Get more calls</span>
                                                        <p>Boost telecommunication feedback to provide precise and accurate information</p>
                                                    </div>
                                                </label>
                                                <label for="radio8" class="custom-radio style-two mb-3 pb-3 border-bottom">
                                                    <input type="radio" class="form-check-input" name="radio" id="radio8"/>
                                                    <div class="radio-content">
                                                        <span class="fw-medium text-secondary mb-1 d-block">Get more likes</span>
                                                        <p>Increase positive interactivity on social media platforms</p>
                                                    </div>
                                                </label>
                                                <label for="radio9" class="custom-radio style-two mb-3 pb-3 border-bottom">
                                                    <input type="radio" class="form-check-input" name="radio" id="radio9"/>
                                                    <div class="radio-content">
                                                        <span class="fw-medium text-secondary mb-1 d-block">Lead generation</span>
                                                        <p>Collect contact information for potential customers</p>
                                                    </div>
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <div class="tab-contents">
                                        <form class="campaign-stepper-content m-auto" style="max-width: 625px;">
                                            <h3 class="fs-18 mb-4">Upload Files</h3>
                        
                                            <div class="mb-5 only-file-upload">
                                                <div class="d-flex align-items-center position-relative z-1 bg-border-color p-4 rounded-2" style="border: 2px dashed #5DA8FF;">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/upload.png" alt="upload">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h4 class="fs-16">Drop campaign files here or click to upload.</h4>
                                                        <p>Upload upto 12 files, max size each file: 5MB.</p>
                                                    </div>
                                                    <label class="position-absolute top-0 bottom-0 start-0 end-0 cursor" id="upload-container">
                                                        <input class="form__file bottom-0" id="upload-files" type="file" multiple="multiple">
                                                    </label>
                                                </div>
                                                <div id="files-list-container"></div>
                                            </div>
                    
                                            <h3 class="fs-18 mb-4">Uploaded Files</h3>
                    
                                            <div class="mb-5">
                                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center border-bottom pb-4 mb-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/pdf.png" style="width: 35px;" alt="pdf">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h4 class="fs-16 mb-0">Campaign Requirements</h4>
                                                            <p>Increase impression traffic onto the platform</p>
                                                        </div>
                                                    </div>
                    
                                                    <div class="dropdown action-opt">
                                                        <button class="btn p-2 bg-border-color" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span>Edit</span>
                                                            <i data-feather="chevron-down"></i>
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
                                                </div>
                                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center border-bottom pb-4 mb-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/doc.png" style="width: 35px;" alt="doc">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h4 class="fs-16 mb-0">Campaign’s mission and vision</h4>
                                                            <p>Increase impression traffic onto the platform</p>
                                                        </div>
                                                    </div>
                    
                                                    <div class="dropdown action-opt">
                                                        <button class="btn p-2 bg-border-color" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span>Edit</span>
                                                            <i data-feather="chevron-down"></i>
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
                                                </div>
                                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center border-bottom pb-4 mb-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/xl4.png" style="width: 35px;" alt="xl4">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h4 class="fs-16 mb-0">Campaign Banner</h4>
                                                            <p>Increase impression traffic onto the platform</p>
                                                        </div>
                                                    </div>
                    
                                                    <div class="dropdown action-opt">
                                                        <button class="btn p-2 bg-border-color" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span>Edit</span>
                                                            <i data-feather="chevron-down"></i>
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
                                                </div>
                                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center border-bottom pb-4 mb-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/jpg.png" style="width: 35px;" alt="pdf">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h4 class="fs-16 mb-0">Campaign Image</h4>
                                                            <p>Increase impression traffic onto the platform</p>
                                                        </div>
                                                    </div>
                    
                                                    <div class="dropdown action-opt">
                                                        <button class="btn p-2 bg-border-color" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span>Edit</span>
                                                            <i data-feather="chevron-down"></i>
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
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                
                                    <div class="tab-contents">
                                        <div class="campaign-stepper-content m-auto" style="max-width: 625px;">
                                            <h3 class="fs-18 mb-4">Configure Audiences</h3>
                        
                                            <div class="mb-5">
                                                <label class="fw-semibold mb-3">Gender</label>
                                                <div class="row">
                                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                                        <label for="radio" class="custom-radio">
                                                            <input checked type="radio" class="form-check-input" name="radio" id="radio"/>
                                                            <div class="radio-content">
                                                                <span class="fw-medium text-secondary">All</span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                                        <label for="radio2" class="custom-radio">
                                                            <input type="radio" class="form-check-input" name="radio" id="radio2"/>
                                                            <div class="radio-content">
                                                                <span class="fw-medium text-secondary">Male</span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="radio3" class="custom-radio">
                                                            <input type="radio" class="form-check-input" name="radio" id="radio3"/>
                                                            <div class="radio-content">
                                                                <span class="fw-medium text-secondary">Female</span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="mb-5">
                                                <label class="fw-semibold mb-3">Age</label>
                                                <input type="text" class="single-slider" name="age" value="" data-from="40"/>
                                            </div>
                    
                                            <div class="mb-5">
                                                <label class="fw-semibold mb-3">Location</label>
                                                <div class="form-group mb-4">
                                                    <div class="tag-container p-1 rounded-3 form-control h-auto p-0 bg-border-color" id="tagContainer" style="border: 2px dashed #5DA8FF;">
                                                        <input type="text" id="tagInput" class="form-control h-60 border-0 bg-border-color" placeholder="Type and press Enter">
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="mb-5">
                                                <label class="fw-semibold mb-3">Media</label>
                                                <div class="form-group mb-4">
                                                    <div class="tag-container p-1 rounded-3 form-control h-auto p-0 bg-border-color" id="MediaContainer" style="border: 2px dashed #5DA8FF;">
                                                        <input type="text" id="MediaInput" class="form-control h-60 border-0 bg-border-color" placeholder="Type and press Enter">
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="mb-5">
                                                <label class="fw-semibold mb-3">Add Team Member</label>
                                                <div class="form-group mb-4">
                                                    <div class="tag-container p-1 rounded-3 form-control h-auto p-0 bg-border-color" id="AddTeamMemberContainer" style="border: 2px dashed #5DA8FF;">
                                                        <input type="text" id="AddTeamMemberInput" class="form-control h-60 border-0 bg-border-color" placeholder="Type and press Enter">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                
                                    <div class="tab-contents">
                                        <form class="campaign-stepper-content m-auto" style="max-width: 625px;">
                                            <h3 class="fs-18 mb-4">Budget Estimates</h3>
                        
                                            <div class="mb-5">
                                                <label class="fw-semibold mb-3">Budgets Estimates</label>
                                                <div class="row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="radio4" class="custom-radio">
                                                            <input checked type="radio" class="form-check-input" name="radio" id="radio4"/>
                                                            <div class="radio-content">
                                                                <span class="fw-medium text-secondary mb-1 d-block">Continuous Duration</span>
                                                                <p>Your Ad will run continuously for a daily budget.</p>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="radio10" class="custom-radio">
                                                            <input type="radio" class="form-check-input" name="radio" id="radio10"/>
                                                            <div class="radio-content">
                                                                <span class="fw-medium text-secondary mb-1 d-block">Fixed Duration</span>
                                                                <p>Your Ad will run only specified dates only.</p>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="mb-5">
                                                <label class="fw-semibold mb-3">Daily Budget</label>
                                                <input type="text" class="slider" name="cash_end" value="" data-from="1000" />
                                            </div>
                                        </form>
                                    </div>
                
                                    <div class="tab-contents">
                                        <div class="campaign-stepper-content m-auto text-center mb-5" style="max-width: 625px;">
                                            <div class="mb-4">
                                                <img src="/assets/images/interface-welcome.png" alt="interface-welcome">
                                            </div>
                    
                                            <h3 class="fs-24 mb-3">Campaign Completed!</h3>
                                            <p class="mx-auto mb-4" style="max-width: 463px;">You will receive an email with with the summary of your newly created campaign!</p>
                                            
                                            <div class="d-flex flex-wrap justify-content-center gap-2 gap-sm-4">
                                                <button class="btn btn-secondary">Create New Campaign <i class="ri-arrow-right-line text-white"></i></button>
                                                <button class="btn btn-primary">View Campaign <i class="ri-arrow-right-line text-white"></i></button>
                                            </div>
                                        </div>
                                    </div>
                
                                    <div class="tab-contents continue-none">
                                        <div class="campaign-stepper-content">
                                            <div class="d-flex align-items-center mb-4 mb-md-5">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/christmas.png" alt="christmas">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h3 class="fs-24">Christmas Eve</h3>
                                                    <span class="fs-16 fw-medium">From 10 Oct - 15 Oct, 24</span>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="card border p-4 bg-border-color rounded-3 mb-4">
                                                        <div class="d-flex justify-content-between align-items-center border-bottom border-body-bg pb-3 mb-3">
                                                            <h4 class="fs-18 mb-0">Campaign Goal:</h4>
                            
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
                                                        <h4 class="fw-medium fs-14">Get more visitors</h4>
                                                        <p>Increase impression traffic onto the platform</p>
                                                    </div>
                                                    <div class="card border p-4 bg-border-color rounded-3 mb-4">
                                                        <div class="d-flex justify-content-between align-items-center border-bottom border-body-bg pb-3 mb-3">
                                                            <h4 class="fs-18 mb-0">Team Members:</h4>
                            
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
                                                        <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-3">
                                                            <li>
                                                                <button class="border-0 p-2 bg-body-bg d-flex align-items-center rounded-2">
                                                                    <img src="/assets/images/user-90.png" class="border border-white rounded-circle" alt="user">
                                                                    <span class="fw-medium ms-2 text-secondary">Jonathon Ronan</span>
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button class="border-0 p-2 bg-body-bg d-flex align-items-center rounded-2">
                                                                    <img src="/assets/images/user-91.png" class="border border-white rounded-circle" alt="user">
                                                                    <span class="fw-medium ms-2 text-secondary">Walter White</span>
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="card border p-4 bg-border-color rounded-3 mb-4">
                                                        <div class="d-flex justify-content-between align-items-center border-bottom border-body-bg pb-3 mb-3">
                                                            <h4 class="fs-18 mb-0">Audiences</h4>
                            
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
                                                        
                                                        <ul class="ps-0 mb-0 list-unstyled">
                                                            <li class="border-bottom pb-2 mb-2 border-body-bg">
                                                                <span class="text-secondary fw-medium">Gender:</span> All
                                                            </li>
                                                            <li class="border-bottom pb-2 mb-2 border-body-bg">
                                                                <span class="text-secondary fw-medium">Age Range:</span> 18-60
                                                            </li>
                                                            <li class="border-bottom pb-2 mb-2 border-body-bg">
                                                                <span class="text-secondary fw-medium">Location:</span> Canada, USA
                                                            </li>
                                                            <li>
                                                                <span class="text-secondary fw-medium">Media:</span>Facebook, Instagram
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="card border p-4 bg-border-color rounded-3 mb-4">
                                                        <div class="d-flex justify-content-between align-items-center border-bottom border-body-bg pb-3 mb-3">
                                                            <h4 class="fs-18 mb-0">Uploaded Files</h4>
                            
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
                                                        
                                                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center border-bottom border-body-bg pb-4 mb-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/pdf.png" style="width: 35px;" alt="pdf">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h4 class="fs-16 mb-0">Campaign Requirements</h4>
                                                                    <p>Increase impression traffic onto the platform</p>
                                                                </div>
                                                            </div>
                            
                                                            <button class="bg-white rounded-circle border-0" style="width: 30px; height: 30px;">
                                                                <i class="ri-download-2-line text-primary fs-16"></i>
                                                            </button>
                                                        </div>
                                                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center border-bottom border-body-bg pb-4 mb-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/doc.png" style="width: 35px;" alt="doc">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h4 class="fs-16 mb-0">Campaign’s mission and vision</h4>
                                                                    <p>Increase impression traffic onto the platform</p>
                                                                </div>
                                                            </div>
                            
                                                            <button class="bg-white rounded-circle border-0" style="width: 30px; height: 30px;">
                                                                <i class="ri-download-2-line text-primary fs-16"></i>
                                                            </button>
                                                        </div>
                                                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center border-bottom border-body-bg pb-4 mb-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/xl4.png" style="width: 35px;" alt="xl4">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h4 class="fs-16 mb-0">Campaign Banner</h4>
                                                                    <p>Increase impression traffic onto the platform</p>
                                                                </div>
                                                            </div>
                            
                                                            <button class="bg-white rounded-circle border-0" style="width: 30px; height: 30px;">
                                                                <i class="ri-download-2-line text-primary fs-16"></i>
                                                            </button>
                                                        </div>
                                                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/jpg.png" style="width: 35px;" alt="pdf">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h4 class="fs-16 mb-0">Campaign Image</h4>
                                                                    <p>Increase impression traffic onto the platform</p>
                                                                </div>
                                                            </div>
                            
                                                            <button class="bg-white rounded-circle border-0" style="width: 30px; height: 30px;">
                                                                <i class="ri-download-2-line text-primary fs-16"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                
                                    <!-- Navigation buttons -->
                                    <div class="buttons d-flex justify-content-between m-auto" style="max-width: 625px;">
                                        <button id="prevButton" class="btn btn-secondary"><i class="ri-arrow-left-line text-white"></i> Back</button>
                                        <button id="nextButton" class="btn btn-primary">Continue <i class="ri-arrow-right-line text-white"></i></button>
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