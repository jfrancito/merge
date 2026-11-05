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
                        <h3 class="mb-0">Event Details</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Events</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Event Details</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="mb-4">
                        <img src="assets/images/event-details.jpg" class="rounded-3" alt="event-details">
                    </div>

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Event Details</h3>
                                    <h4 class="fs-14 fw-semibold mb-2 pb-1">Annual Conference 2024</h4>
                                    <p class="mb-4">The Annual Conference 2024 is a flagship event organized by ABC Corporation. This conference aims to bring together industry leaders, experts, and enthusiasts to discuss the latest trends, innovations, and challenges in our field. Participants can expect insightful keynote sessions, engaging panel discussions, and valuable networking opportunities field. Participants can expect insightful keynote sessions.</p>

                                    <div class="row">
                                        <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined d-inline-block wh-70 lh-70 text-center fs-35 text-primary bg-gary-light rounded-circle bg-for-dark-mode">schedule</i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-14 fw-semibold mb-1">Time</h4>
                                                    <span>01 Dec 2024, 09:00 AM</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined d-inline-block wh-70 lh-70 text-center fs-35 text-info bg-gary-light rounded-circle bg-for-dark-mode">place</i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-14 fw-semibold mb-1">Location</h4>
                                                    <span>Convention Center</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined d-inline-block wh-70 lh-70 text-center fs-35 text-primary-div bg-gary-light rounded-circle bg-for-dark-mode">event_seat</i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-14 fw-semibold mb-1">TiEvent Seatme</h4>
                                                    <span>50</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-wrap gap-2 border-top pt-4">
                                        <button class="btn btn-primary fs-15 fw-medium py-2 px-4">
                                            <div class="d-flex align-items-center py-1">
                                                <i class="material-symbols-outlined me-2 text-white">local_activity</i>
                                                <span>Get Ticket</span>
                                            </div>
                                        </button>
                                        <button class="btn btn-primary bg-transparent border fs-15 fw-medium py-2 px-4 text-body hover-bg">
                                            <div class="d-flex align-items-center py-1">
                                                <i class="material-symbols-outlined me-2 text-body">event</i>
                                                <span>Add To Calendar</span>
                                            </div>
                                        </button>
                                        <button class="btn btn-primary bg-transparent border fs-15 fw-medium py-2 px-4 text-body hover-bg">
                                            <div class="d-flex align-items-center py-1">
                                                <i class="material-symbols-outlined me-2 text-body">favorite_border</i>
                                                <span>5937</span>
                                            </div>
                                        </button>
                                        <button class="btn btn-primary bg-transparent border fs-15 fw-medium py-2 px-4 text-body hover-bg">
                                            <div class="d-flex align-items-center py-1">
                                                <i class="material-symbols-outlined me-2 text-body">share</i>
                                                <span>2582</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Event Info</h3>
                                    <span class="d-block mb-3"><span class="text-secondary">08:00 AM</span> - Registration</span>
                                    <span class="d-block mb-3"><span class="text-secondary">09:00 AM</span> - Opening Keynote</span>
                                    <span class="d-block mb-3"><span class="text-secondary">10:30 AM</span> - Panel Discussion: Future Trends</span>
                                    <span class="d-block mb-3"><span class="text-secondary">12:00 PM</span> - Lunch Break</span>
                                    <span class="d-block mb-3"><span class="text-secondary">02:00 PM</span> - Interactive Workshops</span>
                                    <span class="d-block mb-3"><span class="text-secondary">04:30 PM</span> - Networking Reception</span>

                                    <h3 class="mb-3 mb-lg-3 pt-2">Registration Information</h3>
                                    <span class="d-block mb-2">Early Bird Registration Deadline: 15 November 2024</span>
                                    <span class="d-block mb-2">Standard Registration Deadline: 30 November 2024</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">About This Event</h3>
                                    <p>Pellentesque viverra lorem malesuada nunc tristique sapien. Imperdiet sit hendrerit tincidunt bibendum donec adipiscing. Tellus non morbi nascetur cursus etiam facilisis mi. Dolor aliquam sed amet aliquam venenatis. Ac viverra interdum tortor enim. Molestie tincidunt ut consequat a urna tortor. Vitae velit ac nisl velit mauris.</p>
                                    <p>Imperdiet sit hendrerit tincidunt bibendum donec adipiscing. Tellus non morbi nascetur cursus etiam facilisis mi. Dolor aliquam sed amet aliquam venenatis. Ac viverra interdum tortor enim. Molestie tincidunt ut.</p>
                                    <ul class="text-primary mb-0 pt-2">
                                        <li class="mb-2 pb-1">
                                            <span class="text-body">Pellentesque viverra lorem malesuada nunc tristique sapien.</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="text-body">Imperdiet sit hendrerit tincidunt bibendum donec adipiscing.</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="text-body">Tellus non morbi nascetur cursus etiam facilisis mi.</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="text-body">Imperdiet sit hendrerit tincidunt bibendum donec adipiscing.</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="default-table-area speaker-table">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Speaker</th>
                                                        <th scope="col">Topic</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="assets/images/user-1.jpg" class="wh-40 rounded-3" alt="user-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14 mb-0">Sarah Johnson</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-body">Opening Keynote</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="assets/images/user-2.jpg" class="wh-40 rounded-3" alt="user-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14 mb-0">Russell Colon</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-body">Panel Discussion: Future Trends</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="assets/images/user-3.jpg" class="wh-40 rounded-3" alt="user-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14 mb-0">Cynthia Baggett</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-body">Interactive Workshops</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="assets/images/user-4.jpg" class="wh-40 rounded-3" alt="user-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14 mb-0">Raymond Nguyen</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-body">Networking Reception</td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
