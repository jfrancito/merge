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
                        <h3 class="mb-0">Events List</h3>

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
                                    <span class="fw-medium">Events List</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-lg-4 mb-3">
                                <form class="position-relative table-src-form me-0">
                                    <input type="text" class="form-control" placeholder="Search here">
                                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                </form>
                                <a href="create-an-event" class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg">
                                    <span class="py-sm-1 d-block">
                                        <i class="ri-add-line d-none d-sm-inline-block fs-18"></i>
                                        <span>Add New Event</span>
                                    </span>
                                </a>
                            </div>

                            <div class="default-table-area all-products">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">Event ID</th>
                                                <th scope="col">Event</th>
                                                <th scope="col">Date and Time</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Organizer</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">#JAN-258</td>
                                                <td>
                                                    <a href="event-details" class="d-flex align-items-center">
                                                        <img src="assets/images/event-1.jpg" class="wh-40 rounded-3" alt="event-1">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Annual Conference 2024</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">01 Dec 2024 09:00 AM</td>
                                                <td class="text-secondary">Convention Center</td>
                                                <td class="text-secondary">ABC Corporation</td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Happening</span>
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
                                                <td class="text-body">#JAN-648</td>
                                                <td>
                                                    <a href="event-details" class="d-flex align-items-center">
                                                        <img src="assets/images/event-2.jpg" class="wh-40 rounded-3" alt="event-1">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Leadership Summit 2024</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">10 Dec 2024 03:00 AM</td>
                                                <td class="text-secondary">Online</td>
                                                <td class="text-secondary">Marketing Pros</td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Happening</span>
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
                                                <td class="text-body">#JAN-945</td>
                                                <td>
                                                    <a href="event-details" class="d-flex align-items-center">
                                                        <img src="assets/images/event-3.jpg" class="wh-40 rounded-3" alt="event-1">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Product Launch Webinar</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">15 Dec 2024 06:00 PM</td>
                                                <td class="text-secondary">City Sky Lounge</td>
                                                <td class="text-secondary">Tech Solutions Inc.</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Past</span>
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
                                                <td class="text-body">#JAN-186</td>
                                                <td>
                                                    <a href="event-details" class="d-flex align-items-center">
                                                        <img src="assets/images/event-4.jpg" class="wh-40 rounded-3" alt="event-1">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">AI in Healthcare Symposium</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">20 Dec 2024 09:00 AM</td>
                                                <td class="text-secondary">Training Center</td>
                                                <td class="text-secondary">Startup Hub</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Upcoming</span>
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
                                                <td class="text-body">#JAN-439</td>
                                                <td>
                                                    <a href="event-details" class="d-flex align-items-center">
                                                        <img src="assets/images/event-5.jpg" class="wh-40 rounded-3" alt="event-1">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Tech Summit 2024</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">25 Dec 2024 02:30 PM</td>
                                                <td class="text-secondary">Tech Park Auditorium</td>
                                                <td class="text-secondary">Community Foundation</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Upcoming</span>
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
                                                <td class="text-body">#JAN-752</td>
                                                <td>
                                                    <a href="event-details" class="d-flex align-items-center">
                                                        <img src="assets/images/event-6.jpg" class="wh-40 rounded-3" alt="event-1">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Startup Pitch Day</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">30 Dec 2024 11:00 AM</td>
                                                <td class="text-secondary">Grand Hotel Ballroom</td>
                                                <td class="text-secondary">FutureTech Solutions</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Upcoming</span>
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
                                                <td class="text-body">#JAN-658</td>
                                                <td>
                                                    <a href="event-details" class="d-flex align-items-center">
                                                        <img src="assets/images/event-7.jpg" class="wh-40 rounded-3" alt="event-1">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Workshop: Digital Marketing</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">01 Jan 2024 07:00 AM</td>
                                                <td class="text-secondary">Innovation Hub</td>
                                                <td class="text-secondary">Leadership Institute</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Upcoming</span>
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
                                                <td class="text-body">#JAN-951</td>
                                                <td>
                                                    <a href="event-details" class="d-flex align-items-center">
                                                        <img src="assets/images/event-8.jpg" class="wh-40 rounded-3" alt="event-1">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Charity Gala Dinner</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">10 Jan 2024 03:00PM</td>
                                                <td class="text-secondary">Medical Center</td>
                                                <td class="text-secondary">XYZ Innovations</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Upcoming</span>
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
                                                <td class="text-body">#JAN-357</td>
                                                <td>
                                                    <a href="event-details" class="d-flex align-items-center">
                                                        <img src="assets/images/event-9.jpg" class="wh-40 rounded-3" alt="event-1">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Web Development Seminar</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">20 Jan 2024 01:00 PM</td>
                                                <td class="text-secondary">Corporate HQ</td>
                                                <td class="text-secondary">DTech Institute</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Past</span>
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
                                                <td class="text-body">#JAN-851</td>
                                                <td>
                                                    <a href="event-details" class="d-flex align-items-center">
                                                        <img src="assets/images/event-10.jpg" class="wh-40 rounded-3" alt="event-1">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Networking Mixer</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">30 Jan 2024 10:00 AM</td>
                                                <td class="text-secondary">Online</td>
                                                <td class="text-secondary">ABC Corporation</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Upcoming</span>
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

                                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                    <span>Items per pages: 10</span>

                                    <div class="d-flex align-items-center">
                                        <span class="me-2">1 - 10 of 12</span>
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="events-list" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="events-list" aria-label="Next">
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
