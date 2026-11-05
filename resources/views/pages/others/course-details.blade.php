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
                        <h3 class="mb-0">Course Details</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">LMS</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Course Details</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div class="p-4">
                                <h3 class="mb-0">Courses</h3>
                            </div>

                            <div class="default-table-area style-two all-projects pb-4">
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
                                                            <img src="assets/images/user-42.jpg" class="wh-34 rounded-circle" alt="user">
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
                                                    <div class="d-flex align-items-center gap-2">
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
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Tables Of Content</h3>

                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <div class="accordion course-accordion" id="accordionExample">
                                        <div class="accordion-item border-0 rounded-3 mb-3">
                                            <h2 class="accordion-header rounded-3">
                                                <button class="accordion-button fs-15 fw-semibold text-secondary p-4 bg-body-bg rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Introduction to Cybersecurity
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                                <div class="accordion-body pt-0">
                                                    <ul class="ps-0 mb-0 list-unstyled">
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">info</i>
                                                                <span class="ms-2">Course Introduction</span>
                                                            </div>
                                                            <span>2m 24s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">play_circle</i>
                                                                <span class="ms-2">Cyber Security Introduction</span>
                                                            </div>
                                                            <span>0m 46s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">list </i>
                                                                <span class="ms-2">What is Cyber Security and the CIA Triad</span>
                                                            </div>
                                                            <span>3m 32s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">star</i>
                                                                <span class="ms-2">Threat Actors: Who are They?</span>
                                                            </div>
                                                            <span>2m 2s</span>
                                                        </li>
                                                        <li class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">hotel_class </i>
                                                                <span class="ms-2">Types of Threat Actors</span>
                                                            </div>
                                                            <span>2m 13s</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item border-0 rounded-3 mb-3">
                                            <h2 class="accordion-header rounded-3">
                                                <button class="accordion-button fs-15 fw-semibold text-secondary p-4 bg-body-bg rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                    Secure Networking
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                <div class="accordion-body pt-0">
                                                    <ul class="ps-0 mb-0 list-unstyled">
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">info</i>
                                                                <span class="ms-2">Network Security Introduction</span>
                                                            </div>
                                                            <span>2m 24s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">hotel_class</i>
                                                                <span class="ms-2">Introduction to Wired and Wireless Networks</span>
                                                            </div>
                                                            <span>0m 46s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">list </i>
                                                                <span class="ms-2">Wired Network Vulnerabilities and How to Protect Wired Networks</span>
                                                            </div>
                                                            <span>3m 32s</span>
                                                        </li>
                                                        <li class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">star</i>
                                                                <span class="ms-2">Wireless Network Vulnerabilities and How to Protect Wireless Networks</span>
                                                            </div>
                                                            <span>2m 2s</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item border-0 rounded-3 mb-3">
                                            <h2 class="accordion-header rounded-3">
                                                <button class="accordion-button fs-15 fw-semibold text-secondary p-4 bg-body-bg rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                    Secure E-Mail
                                                </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                <div class="accordion-body pt-0">
                                                    <ul class="ps-0 mb-0 list-unstyled">
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">info</i>
                                                                <span class="ms-2">E-Mail Security Introduction</span>
                                                            </div>
                                                            <span>2m 24s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">play_circle</i>
                                                                <span class="ms-2">E-Mail: Overview and Importance</span>
                                                            </div>
                                                            <span>0m 46s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">list </i>
                                                                <span class="ms-2">Phishing: Techniques, Implications and How to Spot</span>
                                                            </div>
                                                            <span>3m 32s</span>
                                                        </li>
                                                        <li class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">star</i>
                                                                <span class="ms-2">Understanding E-Mail Headers for Verification</span>
                                                            </div>
                                                            <span>2m 2s</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item border-0 rounded-3 mb-3">
                                            <h2 class="accordion-header rounded-3">
                                                <button class="accordion-button fs-15 fw-semibold text-secondary p-4 bg-body-bg rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                    Secure Internet Browsing
                                                </button>
                                            </h2>
                                            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                <div class="accordion-body pt-0">
                                                    <ul class="ps-0 mb-0 list-unstyled">
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">info</i>
                                                                <span class="ms-2">Internet Security Introduction</span>
                                                            </div>
                                                            <span>2m 24s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">play_circle</i>
                                                                <span class="ms-2">Exploring Web-Based Threats</span>
                                                            </div>
                                                            <span>0m 46s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">list </i>
                                                                <span class="ms-2">Typo Squatting: Risks and Mitigation</span>
                                                            </div>
                                                            <span>3m 32s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">star</i>
                                                                <span class="ms-2">Watering Hole Attacks: Tactics and Countermeasures</span>
                                                            </div>
                                                            <span>2m 2s</span>
                                                        </li>
                                                        <li class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">hotel_class </i>
                                                                <span class="ms-2">Secure Browsing Best Practices</span>
                                                            </div>
                                                            <span>2m 13s</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item border-0 rounded-3">
                                            <h2 class="accordion-header rounded-3">
                                                <button class="accordion-button fs-15 fw-semibold text-secondary p-4 bg-body-bg rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                                    Device Security & Password Management
                                                </button>
                                            </h2>
                                            <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                <div class="accordion-body pt-0">
                                                    <ul class="ps-0 mb-0 list-unstyled">
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">info</i>
                                                                <span class="ms-2">Device Security Introduction</span>
                                                            </div>
                                                            <span>2m 24s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">play_circle</i>
                                                                <span class="ms-2">Securing Computers, Laptops, and Mobile Devices</span>
                                                            </div>
                                                            <span>0m 46s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">list </i>
                                                                <span class="ms-2">Password Best Practices</span>
                                                            </div>
                                                            <span>3m 32s</span>
                                                        </li>
                                                        <li class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">star</i>
                                                                <span class="ms-2">Multi-Factor Authentication (MFA)</span>
                                                            </div>
                                                            <span>2m 2s</span>
                                                        </li>
                                                        <li class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-outlined fs-20 text-primary position-relative top-1">hotel_class </i>
                                                                <span class="ms-2">Keeping Devices Up-to-Date</span>
                                                            </div>
                                                            <span>2m 13s</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 text-center">
                                    <div class="card bg-primary border-0 rounded-3 text-center d-inline-block mt-4 mt-lg-0">
                                        <div class="card-body p-4 p-sm-5 mx-xxl-5 rounded-10">
                                            <h3 class="fs-20 mb-2 text-white">Unlock Library</h3>
                                            <p class="text-white mb-4">Get access to all videos in the library</p>
                                            <a href="#" class="btn btn-primary bg-white bg-opacity-10 text-white fs-16 py-2 py-md-3 px-3 px-md-4 fw-medium mb-3">
                                                Sign Up - Only $120/mo 
                                            </a>
                                            <p class="fs-14 text-white">Have an account? <a href="#" class="fw-semibold text-white text-decoration-none">Login</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-4">Course Instructor</h3>

                                    <div class="d-flex align-items-center mb-4">
                                        <div class="flex-shrink-0">
                                            <img src="assets/images/user-69.jpg" class="wh-100 rounded-circle" alt="user">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="fs-17 fw-medium mb-1">Aliva Cohen</h4>
                                            <span>aliva@trezo.com</span>
                                        </div>
                                    </div>

                                    <span class="d-block fw-medium mb-2 text-secondary">Course Description</span>
                                    <p class="mb-4">This course is designed for beginners who want to learn the fundamentals of the Python programming language. The course covers basic syntax, data types, control structures, and an introduction to object-oriented programming. Participants will have hands-on coding exercises to reinforce their learning.</p>

                                    <span class="d-block fw-medium mb-2 text-secondary">Course Description</span>
                                    <span class="d-block">Start Date: August 01, 2024</span>
                                    <span class="d-block mb-4">End Date: December 30, 2024</span>

                                    <span class="d-block fw-medium mb-2 text-secondary">Status</span>
                                    <p>The course is currently in progress. Students are actively engaged in the learning materials, and the instructor is providing guidance and support.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h3 class="mb-0">Enrolled Students</h3>
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

                                    <div class="default-table-area style-two top-instructors pb-4">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0 w-md-100">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>#A1217</td>
                                                        <td>
                                                            <a href="my-profile" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-25.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Olivia Clark</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>olivia@trezo.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#A1364</td>
                                                        <td>
                                                            <a href="my-profile" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-26.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Ava Turner</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>ava@trezo.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#A2951</td>
                                                        <td>
                                                            <a href="my-profile" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-27.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Lucas Morgan</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>lucas@trezo.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#A7342</td>
                                                        <td>
                                                            <a href="my-profile" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-28.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Isabella Cooper</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>isabella@trezo.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#A1217</td>
                                                        <td>
                                                            <a href="my-profile" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-29.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Isabella Cooper</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>isabella@trezo.com</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <div class="d-flex align-items-center mb-3">
                                        <ul class="pe-4 mb-0 list-unstyled d-flex gap-2">
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                        </ul>
                                        <div class="progress w-100 rounded-pill" role="progressbar" aria-label="Example 5px high" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height: 5px; background-color: #EFF2FF;">
                                            <div class="progress-bar rounded-pill" style="width: 100%"></div>
                                        </div>
                                        <span class="ms-4">359</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <ul class="pe-4 mb-0 list-unstyled d-flex gap-2">
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                            </li>
                                        </ul>
                                        <div class="progress w-100 rounded-pill" role="progressbar" aria-label="Example 5px high" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="height: 5px; background-color: #EFF2FF;">
                                            <div class="progress-bar rounded-pill" style="width: 90%"></div>
                                        </div>
                                        <span class="ms-4">208</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <ul class="pe-4 mb-0 list-unstyled d-flex gap-2">
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                            </li>
                                        </ul>

                                        <div class="progress w-100 rounded-pill" role="progressbar" aria-label="Example 5px high" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: 5px; background-color: #EFF2FF;">
                                            <div class="progress-bar rounded-pill" style="width: 80%"></div>
                                        </div>
                                        <span class="ms-4">124</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <ul class="pe-4 mb-0 list-unstyled d-flex gap-2">
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                            </li>
                                        </ul>

                                        <div class="progress w-100 rounded-pill" role="progressbar" aria-label="Example 5px high" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="height: 5px; background-color: #EFF2FF;">
                                            <div class="progress-bar rounded-pill" style="width: 70%"></div>
                                        </div>
                                        <span class="ms-4">89</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <ul class="pe-4 mb-0 list-unstyled d-flex gap-2">
                                            <li>
                                                <i class="ri-star-fill text-warning fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line text-gray-light fs-20"></i>
                                            </li>
                                        </ul>

                                        <div class="progress w-100 rounded-pill" role="progressbar" aria-label="Example 5px high" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 5px; background-color: #EFF2FF;">
                                            <div class="progress-bar rounded-pill" style="width: 60%"></div>
                                        </div>
                                        <span class="ms-4">4</span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-center mt-4 mt-lg-0">
                                        <h1 class="fs-40 mb-2">4.28</h1>
                                        <ul class="ps-0 mb-3 list-unstyled d-flex gap-2 justify-content-center">
                                            <li>
                                                <i class="ri-star-fill text-warning fs-30"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-30"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-30"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill text-warning fs-30"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line text-light fs-30"></i>
                                            </li>
                                        </ul>
                                        <span class="ms-4">of 3250 Reviews</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="mb-3 mb-lg-4">
                                <h3 class="mb-0">Manage Reviews</h3>
                            </div>

                            <div class="default-table-area manage-reviews-table">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">Reviewer</th>
                                                <th scope="col">Review</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-6.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Olivia Clark</h6>
                                                            <span class="text-body">olivia@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-7.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Zephyr Zing</h6>
                                                            <span class="text-body">zephyr@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-half-fill fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-8.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Nova Nectar</h6>
                                                            <span class="text-body">nova@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-line fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-9.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Isabella Chang</h6>
                                                            <span class="text-body">isabella@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-half-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-line fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-10.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Alina Bennett</h6>
                                                            <span class="text-body">alina@trezo.com</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-lg-center flex-wrap gap-1 mb-2">
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                        <i class="ri-star-fill fs-18 text-warning"></i>
                                                    </div>
                                                    <p class="mw-380">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit.</p>
                                                </td>
                                                <td>
                                                    <span class="d-block">17 Dec 2024</span>
                                                    <span class="d-block">08:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Published</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approved">
                                                            <i class="material-symbols-outlined fs-16 text-primary">download_done</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                                                            <i class="material-symbols-outlined fs-16 text-body">reply</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
    
                                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                    <span class="fs-13 fw-medium">Items per pages: 5</span>
    
                                    <div class="d-flex align-items-center">
                                        <span class="fs-13 fw-medium me-2">1 - 5 of 12</span>
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="course-details" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="course-details" aria-label="Next">
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

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-sm-flex justify-content-between  mb-4">
                                <h3 class="mb-0">Write Feedback Here:</h3>
                                <ul class="ps-0 mb-0 list-unstyled d-flex gap-2 justify-content-center ratings">
                                    <li class="rating">
                                        <i class="ri-star-fill fs-20"></i>
                                    </li>
                                    <li class="rating">
                                        <i class="ri-star-fill fs-20"></i>
                                    </li>
                                    <li class="rating">
                                        <i class="ri-star-fill fs-20"></i>
                                    </li>
                                    <li class="rating">
                                        <i class="ri-star-fill fs-20"></i>
                                    </li>
                                    <li class="rating">
                                        <i class="ri-star-fill fs-20"></i>
                                    </li>
                                </ul>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Your Name</label>
                                            <input type="text" class="form-control h-55 text-dark" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Your Email</label>
                                            <input type="email" class="form-control h-55 text-dark" placeholder="Your Email">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Your Phone No</label>
                                            <input type="number" class="form-control h-55 text-dark" placeholder="Your Phone No">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Your Subject</label>
                                            <input type="email" class="form-control h-55 text-dark" placeholder="Your Subject">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Write Comment</label>
                                            <textarea class="form-control" placeholder="Write Comment" cols="30" rows="10" data-gramm="false" wt-ignore-input="true"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn btn-primary text-white fw-semibold py-3 px-5">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
