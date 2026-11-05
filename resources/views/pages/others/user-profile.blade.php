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
                        <h3 class="mb-0">Profile</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Profile</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Profile</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="position-relative">
                        <img src="assets/images/profile-bg.jpg" class="rounded-top-3" alt="profile-bg">
                        <div class="position-absolute for-rtl-position" style="bottom: 25px; right: 25px;">
                            <a href="#" class="btn btn-outline-light text-white hover rounded-2">
                                Update Cover Photo
                            </a>
                        </div>
                    </div>
                    <div class="card bg-white border-0 rounded-3 mb-4 rounded-top-0">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-end">
                                    <div class="flex-shrink-0 position-relative mt-minus-110">
                                        <img src="assets/images/user-68.jpg" class="rounded-circle border border-2 wh-160" alt="user">
                                        <img src="assets/images/check.svg" class="position-absolute bottom-0 end-0" alt="check">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="fs-24 mb-1">Alice Johnson</h4>
                                        <span class="fs-15 fw-medium">Product designer</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="#" class="btn btn-outline-light text-body fw-medium fs-16 px-4 hover hover-bg">
                                        <i class="ri-edit-line fw-medium fs-18 me-1"></i>
                                        <span>Edit</span>
                                    </a>
                                    <a href="#" class="btn btn-primary fw-medium fs-16 px-4 ms-3">
                                        <i class="ri-share-fill fw-medium fs-18 me-1"></i>
                                        <span>Share</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
                        <a href="user-profile" class="btn btn-primary py-2 px-3 fw-medium">Profile</a>
                        <a href="teams-2" class="btn btn-outline-primary py-2 px-3 fw-medium">Team</a>
                        <a href="my-projects" class="btn btn-outline-primary py-2 px-3 fw-medium">Projects</a>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 border-bottom pb-4 mb-4">
                                        <h4 class="fs-18 mb-0">About Me</h4>
                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-symbols-outlined fs-20 text-body hover">more_horiz</i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="eye"></i>
                                                        View All 
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="edit"></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="trash-2"></i>
                                                        Delete One
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="lock"></i>
                                                        Block
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
        
                                    <h4 class="fs-16 fw-medium mb-2">Introduction</h4>
                                    <p class="mb-4" style="max-width: 691px;">Alice Johnson, a visionary UX/UI designer, blends creativity with user-centric design principles to craft seamless digital experiences. With a passion for innovation and a knack for understanding user needs, [Your Name] has become a driving force in the ever-evolving landscape of digital design. This 5000-word biography aims to delve into Alice's journey, from humble beginnings to becoming a recognized name in the realm of user experience and interface design.</p>
        
                                    <h4 class="fs-16 fw-medium mb-2">Professional Beginnings</h4>
                                    <p class="mb-4" style="max-width: 691px;">Upon graduating, Alice embarked on their professional journey, eager to make an impact in the world of design. They initially gained experience working at VivoTech, where they collaborated with cross-functional teams to deliver user-centric solutions for various clients. This early exposure provided invaluable insights into the complexities of design processes and solidified Alice's commitment to enhancing user experiences.</p>
        
                                    <h4 class="fs-16 fw-medium mb-2 pb-1">Expertise in UX/UI Design</h4>
                                    <p style="max-width: 691px;">Driven by a desire for continuous growth, Alice delved deeper into the nuances of UX/UI design, staying abreast of emerging trends, technologies, and methodologies. They immersed themselves in user research, wireframing, prototyping, and usability testing, refining their craft with each project.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h3 class="mb-0">Followers</h3>
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

                                    <div class="default-table-area style-two top-instructors">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="pt-1">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-6.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Alex Davis</h6>
                                                                    <span class="fs-12 text-body">alex@trezo.com</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-end pt-1">
                                                            <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-7.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Laura Martinez</h6>
                                                                    <span class="fs-12 text-body">laura@trezo.com</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-8.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Mark Thompson</h6>
                                                                    <span class="fs-12 text-body">mark@trezo.com</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-9.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Rachel White</h6>
                                                                    <span class="fs-12 text-body">rachel@trezo.com</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-10.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Kevin Lee</h6>
                                                                    <span class="fs-12 text-body">kevin@trezo.com</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-11.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Anne Dew</h6>
                                                                    <span class="fs-12 text-body">anne@trezo.com</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                <i class="ri-arrow-right-up-line fs-18"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                            <span class="fs-12 fw-medium">Items per pages: 6</span>
            
                                            <div class="d-flex align-items-center">
                                                <span class="fs-12 fw-medium me-2">1 - 6 of 12</span>
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination mb-0 justify-content-center">
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="team-members" aria-label="Previous">
                                                                <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="team-members" aria-label="Next">
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
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                    <h3 class="mb-0">My Projects</h3>
                                    <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                        <option selected>This Week</option>
                                        <option value="1">This Month</option>
                                        <option value="2">This Year</option>
                                    </select>
                                </div>
                            </div>

                            <div class="default-table-area style-two all-projects">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Project Name</th>
                                                <th scope="col">Client</th>
                                                <th scope="col">Assignees</th>
                                                <th scope="col">Budget</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">End Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">#854</td>
                                                <td>
                                                    <a href="project-overview">Project CyberSphere</a>
                                                </td>
                                                <td>NovaTech Solutions</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pew Smith">
                                                                <img src="assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$4,500</td>
                                                <td class="text-body">25 Mar 2024</td>
                                                <td class="text-body">25 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Finished</span>
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
                                                <td class="text-body">#855</td>
                                                <td>
                                                    <a href="project-overview">Digital Oasis Initiative</a>
                                                </td>
                                                <td>AlphaWave Innovations</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$6,800</td>
                                                <td class="text-body">20 Mar 2024</td>
                                                <td class="text-body">20 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">In Progress</span>
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
                                                <td class="text-body">#856</td>
                                                <td>
                                                    <a href="project-overview">CloudScape Evolution</a>
                                                </td>
                                                <td>InnovateIQ Inc.</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$2,500</td>
                                                <td class="text-body">15 Mar 2024</td>
                                                <td class="text-body">15 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-primary-div bg-opacity-10 text-primary-div p-2 fs-12 fw-normal">Pending</span>
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
                                                <td class="text-body">#857</td>
                                                <td>
                                                    <a href="project-overview">Data Dynamo Drive</a>
                                                </td>
                                                <td>BlueSky Technologies</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pew Smith">
                                                                <img src="assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$7,500</td>
                                                <td class="text-body">10 Mar 2024</td>
                                                <td class="text-body">10 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">In Progress</span>
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
                                                <td class="text-body">#858</td>
                                                <td>
                                                    <a href="project-overview">QuantumLeap Quest</a>
                                                </td>
                                                <td>NexGen Systems</td>
                                                <td>
                                                    <ul class="ps-0 mb-0 list-unstyled d-flex align-items-center">
                                                        <li>
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alex">
                                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Juhon">
                                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="my-profile" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Staven">
                                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                            </a>
                                                        </li>
                                                        <li class="ms-m-15">
                                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-body">$3,400</td>
                                                <td class="text-body">05 Mar 2024</td>
                                                <td class="text-body">05 Apr 2024</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Finished</span>
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
    
                                <div class="p-4 pt-lg-4">
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                        <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
        
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="team-members" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link active" href="team-members">1</a></li>
                                                <li class="page-item"><a class="page-link" href="team-members">2</a></li>
                                                <li class="page-item"><a class="page-link" href="team-members">3</a></li>
                                                <li class="page-item"><a class="page-link" href="team-members">4</a></li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="team-members" aria-label="Next">
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
