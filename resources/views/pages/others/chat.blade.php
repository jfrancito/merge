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
                        <h3 class="mb-0">Chat</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Apps</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Chat</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="mb-4">
                                        <h4 class="fw-medium fs-16 mb-0 mb-3">Messages</h4>
                                        <form class="position-relative default-src-form">
                                            <input type="text" class="form-control rounded-1" placeholder="Search here">
                                            <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y fs-18">search</i>
                                        </form>
                                    </div>

                                    <ul class="nav nav-tabs justify-content-between chat-tabs mb-4" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link p-0 border-0 fw-medium text-body rounded-0 pb-2 active" id="all-message-tab" data-bs-toggle="tab" data-bs-target="#all-message-tab-pane" type="button" role="tab" aria-controls="all-message-tab-pane" aria-selected="true">All Message</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link p-0 border-0 fw-medium text-body rounded-0 pb-2" id="group-chat-tab" data-bs-toggle="tab" data-bs-target="#group-chat-tab-pane" type="button" role="tab" aria-controls="group-chat-tab-pane" aria-selected="false">Group Chat</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link p-0 border-0 fw-medium text-body rounded-0 pb-2" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts-tab-pane" type="button" role="tab" aria-controls="contacts-tab-pane" aria-selected="false">Contacts</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="all-message-tab-pane" role="tabpanel" aria-labelledby="all-message-tab" tabindex="0">
                                            <div class="max-h-497" data-simplebar>
                                                <span class="mb-3 d-block fw-medium fs-12">
                                                    <i class="ri-pushpin-line fs-14"></i>
                                                    <span class="ms-1">PINNED</span>
                                                </span>
                                                <ul class="ps-0 mb-4 list-unstyled chat-list">
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-48.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Sarah Smith</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Hello every one. Are you reday for meetig</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">Just Now</span>
                                                            <span class="fs-12 fw-medium bg-primary text-white rounded-circle wh-16 lh-16 d-inline-block text-center">2</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom border-color-gray pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-49.jpg" class="wh-48 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1">
                                                                <h4 class="fs-16 fw-semibold mb-1">Michael Johnson</h4>
                                                                <span class="text-success">Typing...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">10:20 AM</span>
                                                            <i class="ri-check-double-line fs-16 text-primary"></i>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-50.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-warning border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Sarah Smith</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Voice message...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">9:30 AM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-51.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">David Martinez</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Excellent work...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">3:20 PM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-52.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">David Martinez</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Excellent work...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">3:20 PM</span>
                                                            <span class="fs-12 fw-medium bg-primary text-white rounded-circle wh-16 lh-16 d-inline-block text-center">5</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <span class="mb-3 d-block fw-medium fs-12">
                                                    <i class="ri-chat-poll-line fs-16"></i>
                                                    <span class="ms-1">ALL MESSAGE</span>
                                                </span>
                                                <ul class="ps-0 mb-0 list-unstyled chat-list">
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-53.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Jessica Taylor</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Hello! Mr..</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">12:00 AM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-54.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Christopher Lee</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Very good...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">8:30 PM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-55.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Amanda Rodriguez</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">That’s cool...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">2:20 PM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-56.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Daniel Garcia</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Good morning!</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">10:00 PM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-57.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Jennifer Thomas</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Hi John!</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">11:10 AM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-58.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Elizabeth Clark</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Sounds good...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">12:30 PM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-59.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">William Lewis</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">How are you?</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">11:20 AM</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="group-chat-tab-pane" role="tabpanel" aria-labelledby="group-chat-tab" tabindex="0">
                                            <div class="max-h-497" data-simplebar>
                                                <span class="mb-3 d-block fw-medium fs-12">
                                                    <i class="ri-pushpin-line fs-14"></i>
                                                    <span class="ms-1">PINNED</span>
                                                </span>
                                                <ul class="ps-0 mb-4 list-unstyled chat-list">
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/wordpress.png" class="wh-45 rounded-circle" alt="wordpress">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Wordpress</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Hello every one. Are you reday for meetig</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">Just Now</span>
                                                            <span class="fs-12 fw-medium bg-primary text-white rounded-circle wh-16 lh-16 d-inline-block text-center">2</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom border-color-gray pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/html.png" class="wh-48 rounded-circle" alt="html">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1">
                                                                <h4 class="fs-16 fw-semibold mb-1">HTML</h4>
                                                                <span class="text-success">Typing...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">10:20 AM</span>
                                                            <i class="ri-check-double-line fs-16 text-primary"></i>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/question-and-answer.png" class="wh-45 rounded-circle" alt="question-and-answer">
                                                                <div class="position-absolute p-1 bg-warning border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">QA TEST</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Voice message...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">9:30 AM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/social-media.png" class="wh-45 rounded-circle" alt="social-media">
                                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Digital Marketing</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Excellent work...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">3:20 PM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-52.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Team David</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Excellent work...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">3:20 PM</span>
                                                            <span class="fs-12 fw-medium bg-primary text-white rounded-circle wh-16 lh-16 d-inline-block text-center">5</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <span class="mb-3 d-block fw-medium fs-12">
                                                    <i class="ri-chat-poll-line fs-16"></i>
                                                    <span class="ms-1">ALL MESSAGE</span>
                                                </span>
                                                <ul class="ps-0 mb-0 list-unstyled chat-list">
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-53.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Jessica Taylor</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Hello! Mr..</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">12:00 AM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-54.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Christopher Lee</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Very good...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">8:30 PM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-55.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Amanda Rodriguez</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">That’s cool...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">2:20 PM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-56.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Daniel Garcia</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Good morning!</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">10:00 PM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-57.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Jennifer Thomas</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Hi John!</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">11:10 AM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-58.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Elizabeth Clark</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Sounds good...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">12:30 PM</span>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-59.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">William Lewis</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">How are you?</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12">11:20 AM</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="contacts-tab-pane" role="tabpanel" aria-labelledby="contacts-tab" tabindex="0">
                                            <div class="max-h-497" data-simplebar>
                                                <span class="mb-3 d-block fw-medium fs-12">
                                                    <i class="ri-pushpin-line fs-14"></i>
                                                    <span class="ms-1">PINNED</span>
                                                </span>
                                                <ul class="ps-0 mb-4 list-unstyled chat-list">
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-48.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Sarah Smith</h4>
                                                                <span class="d-inline-block text-truncate text-danger" style="max-width: 150px;">Missed Call</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">Just Now</span>
                                                            <div class="d-flex gap-1 justify-content-between">
                                                                <i class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                                <i class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom border-color-gray pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-49.jpg" class="wh-48 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1">
                                                                <h4 class="fs-16 fw-semibold mb-1">Michael Johnson</h4>
                                                                <span class="text-success">Received Call</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">10:20 AM</span>
                                                            <div class="d-flex gap-1 justify-content-between">
                                                                <i class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                                <i class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-50.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-warning border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Sarah Smith</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Voice message...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">9:30 AM</span>
                                                            <div class="d-flex gap-1 justify-content-between">
                                                                <i class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                                <i class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-51.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">David Martinez</h4>
                                                                <span class="d-inline-block text-truncate text-success" style="max-width: 150px;">Received Call</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">3:20 PM</span>
                                                            <div class="d-flex gap-1 justify-content-between">
                                                                <i class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                                <i class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-52.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">David Martinez</h4>
                                                                <span class="d-inline-block text-truncate text-success" style="max-width: 150px;">Received Call</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">3:20 PM</span>
                                                            <div class="d-flex gap-1 justify-content-between">
                                                                <i class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                                <i class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <span class="mb-3 d-block fw-medium fs-12">
                                                    <i class="ri-chat-poll-line fs-16"></i>
                                                    <span class="ms-1">ALL MESSAGE</span>
                                                </span>
                                                <ul class="ps-0 mb-0 list-unstyled chat-list">
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-53.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Jessica Taylor</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Hello! Mr..</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">12:00 AM</span>
                                                            <div class="d-flex gap-1 justify-content-between">
                                                                <i class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                                <i class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-54.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Christopher Lee</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Very good...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">8:30 PM</span>
                                                            <div class="d-flex gap-1 justify-content-between">
                                                                <i class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                                <i class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-55.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Amanda Rodriguez</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">That’s cool...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">2:20 PM</span>
                                                            <div class="d-flex gap-1 justify-content-between">
                                                                <i class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                                <i class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-56.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Daniel Garcia</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Good morning!</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">10:00 PM</span>
                                                            <div class="d-flex gap-1 justify-content-between">
                                                                <i class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                                <i class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-57.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Jennifer Thomas</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Hi John!</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">11:10 AM</span>
                                                            <div class="d-flex gap-1 justify-content-between">
                                                                <i class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                                <i class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-58.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">Elizabeth Clark</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">Sounds good...</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">12:30 PM</span>
                                                            <div class="d-flex gap-1 justify-content-between">
                                                                <i class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                                <i class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex justify-content-between align-items-center cursor">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 position-relative">
                                                                <img src="assets/images/user-59.jpg" class="wh-45 rounded-circle" alt="user">
                                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                                <h4 class="fs-16 fw-semibold mb-1">William Lewis</h4>
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">How are you?</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="d-block fs-12 mb-1">11:20 AM</span>
                                                            <div class="d-flex gap-1 justify-content-between">
                                                                <i class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                                <i class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8 col-xl-7 col-lg-7 col-md-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap ga-2 border-bottom pb-4 mb-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 position-relative">
                                                <img src="assets/images/user-49.jpg" class="wh-52 rounded-circle" alt="user">
                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                            </div>
                                            <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                <h4 class="fs-16 fw-semibold mb-1">Michael Johnson</h4>
                                                <span>Active now</span>
                                            </div>
                                        </div>
                                        <ul class="ps-0 mb-0 list-unstyled chat-call-option d-flex gap-1 gap-xl-3">
                                            <li>
                                                <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Audio Call">
                                                    <i class="ri-phone-line fs-16 text-body hover"></i>
                                                </button>
                                            </li>
                                            <li>
                                                <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Video Call">
                                                    <i class="ri-vidicon-fill fs-16 text-body hover"></i>
                                                </button>
                                            </li>
                                            <li>
                                                <div class="dropdown action-opt" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                                    <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-2-fill fs-16 text-body hover"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                        <li>
                                                            <a class="dropdown-item" href="my-profile">
                                                                <i data-feather="eye"></i>
                                                                View Profile 
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;">
                                                                <i data-feather="trash-2"></i>
                                                                Delete Chat
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;">
                                                                <i data-feather="lock"></i>
                                                                Block
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <span class="d-block fs-12 mb-2">2023-11-10 09:15 AM</span>
                                    
                                    <ul class="mb-0 list-unstyled chat-details max-h-419" data-simplebar>
                                        <li class="mb-4">
                                            <div class="d-sm-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="assets/images/user-49.jpg" class="wh-48 rounded-circle" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-sm-3 mt-3 mt-sm-0">
                                                    <div class="d-flex align-items-center">
                                                        <p>Hey Micheals, have you had a chance to check out the new admin dashboard?</p>

                                                        <div class="dropdown action-opt ms-2">
                                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-2-fill text-secondary"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="corner-up-right"></i>
                                                                        Reply
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete You
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete Everyone
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <span class="fs-12 d-block">19:04 PM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4 ms-auto own-chat">
                                            <div class="d-sm-flex text-end">
                                                <div class="flex-grow-1 mb-3 mb-sm-0">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="dropdown action-opt me-2">
                                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-2-fill text-secondary"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="corner-up-right"></i>
                                                                        Reply
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete You
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete Everyone
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        
                                                        <p>Oh, you mean the one for project management?</p>
                                                    </div>
                                                    <span class="fs-12 d-block">09:20 AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4">
                                            <div class="d-sm-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="assets/images/user-49.jpg" class="wh-48 rounded-circle" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-sm-3 mt-3 mt-sm-0">
                                                    <div class="d-flex align-items-center">
                                                        <p>Yeah, that's the one! It's got a sleek Material Design, and the features are pretty robust.</p>

                                                        <div class="dropdown action-opt ms-2">
                                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-2-fill text-secondary"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="corner-up-right"></i>
                                                                        Reply
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete You
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete Everyone
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <span class="fs-12 d-block">09:20 AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4 ms-auto own-chat">
                                            <div class="d-sm-flex text-end">
                                                <div class="flex-grow-1 mb-3 mb-sm-0">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="dropdown action-opt me-2">
                                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-2-fill text-secondary"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="corner-up-right"></i>
                                                                        Reply
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete You
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete Everyone
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        
                                                        <p>Nice! What features are you finding interesting?</p>
                                                    </div>
                                                    <span class="fs-12 d-block">09:21 AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4">
                                            <div class="d-sm-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="assets/images/user-49.jpg" class="wh-48 rounded-circle" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-sm-3 mt-3 mt-sm-0">
                                                    <div class="d-flex align-items-center">
                                                        <p>Well, it has a project overview with all the key metrics on the landing page – project</p>

                                                        <div class="dropdown action-opt ms-2">
                                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-2-fill text-secondary"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="corner-up-right"></i>
                                                                        Reply
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete You
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete Everyone
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <span class="fs-12 d-block">09:22 AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4 ms-auto own-chat">
                                            <div class="d-sm-flex text-end">
                                                <div class="flex-grow-1 mb-3 mb-sm-0">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="dropdown action-opt me-2">
                                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-2-fill text-secondary"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="corner-up-right"></i>
                                                                        Reply
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete You
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete Everyone
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        
                                                        <p>That sounds handy. How about the task management features?</p>
                                                    </div>
                                                    <span class="fs-12 d-block">09:21 AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4">
                                            <div class="d-sm-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="assets/images/user-49.jpg" class="wh-48 rounded-circle" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-sm-3 mt-3 mt-sm-0">
                                                    <div class="d-flex align-items-center">
                                                        <p>Oh, they've got this Kanban board for task management. You can drag and drop tasks between columns – it's so intuitive.</p>

                                                        <div class="dropdown action-opt ms-2">
                                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-2-fill text-secondary"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="corner-up-right"></i>
                                                                        Reply
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete You
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete Everyone
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <span class="fs-12 d-block">09:30 AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4 ms-auto own-chat">
                                            <div class="d-sm-flex text-end">
                                                <div class="flex-grow-1 mb-3 mb-sm-0">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="dropdown action-opt me-2">
                                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-2-fill text-secondary"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="corner-up-right"></i>
                                                                        Reply
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete You
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="trash-2"></i>
                                                                        Delete Everyone
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        
                                                        <p>Sweet! What about team collaboration?</p>
                                                    </div>
                                                    <span class="fs-12 d-block">09:31AM</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="d-sm-flex justify-content-between align-items-center bg-gary-light for-dark rounded-3 p-4">
                                        <div class="d-flex gap-3 justify-content-center justify-content-sm-start">
                                            <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Emoji">
                                                <i class="ri-emotion-laugh-line fs-18 text-body"></i>
                                            </button>
                                            <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Link">
                                                <i class="ri-link-m fs-18 text-body"></i>
                                            </button>
                                            <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voice">
                                                <i class="ri-mic-line fs-18 text-body"></i>
                                            </button>
                                            <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Image">
                                                <i class="ri-image-line fs-18 text-body"></i>
                                            </button>
                                        </div>
                                        <form action="" class="w-100 ps-sm-4 ps-xxl-4 ms-xxl-3 mt-3 mt-sm-0 position-relative">
                                            <input type="text" class="form-control rounded-1 border-0 text-dark h-55" placeholder="Type your message">
                                            <button class="p-0 border-0 bg-transparent position-absolute top-50 end-0 translate-middle-y pe-3 d-sm-none">
                                                <i class="material-symbols-outlined fs-24 text-primary">send</i>
                                            </button>
                                        </form>
                                        <button class="p-0 border-0 bg-primary d-none d-sm-block rounded-1 ms-3">
                                            <i class="material-symbols-outlined fs-24 text-white wh-55 lh-55 d-inline-block">send</i>
                                        </button>
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
