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
                        <h3 class="mb-0">My Profile</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">My Profile</span>
                                </li>
                            </ol>
                        </nav>
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
                                            <span>Total Projects</span>
                                            <h3 class="mb-0 fs-20">22.5k+</h3>
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
                                            <span>Total Orders</span>
                                            <h3 class="mb-0 fs-20">25k+</h3>
                                            <div class="py-3">
                                                <div class="wh-77 lh-97 text-center m-auto bg-primary-div bg-opacity-25 rounded-circle">
                                                    <i class="material-symbols-outlined fs-32 text-primary-div">orders</i>
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
                                            <span>Total Revenue</span>
                                            <h3 class="mb-0 fs-20">$34.5m+</h3>
                                            <div class="py-3">
                                                <div class="wh-77 lh-97 text-center m-auto bg-danger bg-opacity-25 rounded-circle">
                                                    <i class="material-symbols-outlined fs-32 text-danger">payments</i>
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
                    <div class="row">
                        <div class="col-xxl-3">
                            <div class="row">
                                <div class="col-xxl-12 col-md-6 col-lg-4">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <h3 class="mb-3 mb-lg-4">Profile Intro</h3>
        
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-70.png" class="rounded-circle border border-2 wh-75" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-17 mb-1 fw-semibold">Olivia John</h4>
                                                    <span class="fs-14">Marketing Manager</span>
                                                </div>
                                            </div>
        
                                            <h4 class="fw-semibold fs-14 mb-2">About Me</h4>
                                            <p>Molestie tincidunt ut consequat a urna tortor. Vitae velit ac nisl velit mauris placerat nisi placerat. Pellentesque viverra lorem malesuada nunc tristique sapien. Imperdiet sit hendrerit tincidunt bibendum donec adipiscing.</p>
                                            <h4 class="fw-semibold fs-14 mb-2 pb-1">Social Profile</h4>
                                            <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                                <li>
                                                    <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                        <i class="ri-facebook-fill"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                        <i class="ri-twitter-x-line"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                        <i class="ri-linkedin-fill"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                        <i class="ri-mail-line"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-6 col-lg-4">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <h3 class="mb-3 mb-lg-4">Profile Information</h3>
                                            <ul class="ps-0 mb-0 list-unstyled">
                                                <li class="d-flex align-items-center mb-2 pb-1">
                                                    <span>User ID:</span>
                                                    <span class="text-secondary fw-medium ms-1">7001</span>
                                                </li>
                                                <li class="d-flex align-items-center mb-2 pb-1">
                                                    <span>Full Name:</span>
                                                    <span class="text-secondary fw-medium ms-1">Olivia John</span>
                                                </li>
                                                <li class="d-flex align-items-center mb-2 pb-1">
                                                    <span>Email:</span>
                                                    <span class="text-secondary fw-medium ms-1">olivia@trezo.com</span>
                                                </li>
                                                <li class="d-flex align-items-center mb-2 pb-1">
                                                    <span>Role:</span>
                                                    <span class="text-secondary fw-medium ms-1">Administrator</span>
                                                </li>
                                                <li class="d-flex align-items-center mb-2 pb-1">
                                                    <span>Location:</span>
                                                    <span class="text-secondary fw-medium ms-1">New York, USA</span>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <span>Join Date:</span>
                                                    <span class="text-secondary fw-medium ms-1">10 May 2022</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-6 col-lg-4">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <h3 class="mb-3 mb-lg-4">Additional Information</h3>
                                            <ul class="ps-0 mb-0 list-unstyled">
                                                <li class="d-flex align-items-center mb-2 pb-1">
                                                    <span>Phone:</span>
                                                    <span class="text-secondary fw-medium ms-1">+1 444 266 5599</span>
                                                </li>
                                                <li class="d-flex align-items-center mb-2 pb-1">
                                                    <span>Address:</span>
                                                    <span class="text-secondary fw-medium ms-1">84 S. Arrowhead Court Branford</span>
                                                </li>
                                                <li class="d-flex align-items-center mb-2 pb-1">
                                                    <span>Orders:</span>
                                                    <span class="text-secondary fw-medium ms-1">696</span>
                                                </li>
                                                <li class="d-flex align-items-center mb-2 pb-1">
                                                    <span>Products:</span>
                                                    <span class="text-secondary fw-medium ms-1">9240</span>
                                                </li>
                                                <li class="d-flex align-items-center mb-2 pb-1">
                                                    <span>Events:</span>
                                                    <span class="text-secondary fw-medium ms-1">5</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-9">
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

                                    <div id="project_analysis2"></div>
                                </div>
                            </div>

                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h3 class="mb-0">To Do List</h3>
                                            <form class="position-relative table-src-form me-0">
                                                <input type="text" class="form-control" placeholder="Search here">
                                                <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                            </form>
                                        </div>
                                    </div>
        
                                    <div class="default-table-area style-two to-do-list">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault7">
                                                                <label class="position-relative top-2 ms-1" for="flexCheckDefault7">ID</label>
                                                            </div>
                                                        </th>
                                                        <th scope="col">Task Title</th>
                                                        <th scope="col">Assigned To</th>
                                                        <th scope="col">Due Date</th>
                                                        <th scope="col">Priority</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-body">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                                <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#854</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="project-overview" class="text-body">Network Infrastructure</a>
                                                        </td>
                                                        <td>Oliver Clark</td>
                                                        <td class="text-body">30 Apr 2024</td>
                                                        <td class="text-body">High</td>
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
                                                        <td class="text-body">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault8">
                                                                <label class="position-relative top-2 ms-1" for="flexCheckDefault8">#853</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="project-overview" class="text-body">Cloud Migration</a>
                                                        </td>
                                                        <td>Ethan Baker</td>
                                                        <td class="text-body">25 Apr 2024</td>
                                                        <td class="text-body">Low</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Pending</span>
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
                                                        <td class="text-body">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault9">
                                                                <label class="position-relative top-2 ms-1" for="flexCheckDefault9">#852</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="project-overview" class="text-body">Website Revamp</a>
                                                        </td>
                                                        <td>Sophia Carter</td>
                                                        <td class="text-body">20 Apr 2024</td>
                                                        <td class="text-body">Medium</td>
                                                        <td>
                                                            <span class="badge bg-primary-div bg-opacity-10 text-primary-div p-2 fs-12 fw-normal">In Progress</span>
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
                                                        <td class="text-body">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault10">
                                                                <label class="position-relative top-2 ms-1" for="flexCheckDefault10">#851</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="project-overview" class="text-body">Mobile Application</a>
                                                        </td>
                                                        <td>Ava Cooper</td>
                                                        <td class="text-body">15 Apr 2024</td>
                                                        <td class="text-body">High</td>
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
                                                        <td class="text-body">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault11">
                                                                <label class="position-relative top-2 ms-1" for="flexCheckDefault11">#850</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="project-overview" class="text-body">System Deployment</a>
                                                        </td>
                                                        <td>Isabella Evans</td>
                                                        <td class="text-body">10 Apr 2024</td>
                                                        <td class="text-body">Low</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-25 text-danger p-2 fs-12 fw-normal">Cancelled</span>
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
            
                                        <div class="p-4 text-end">
                                            <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                                <span class="py-sm-1 d-block">
                                                    <i class="ri-add-line"></i>
                                                    <span>Add New Task</span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h3 class="mb-3 mb-lg-4">Recent Activity</h3>
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
                                    <div class="position-relative timeline-item">
                                        <span class="time-line-date">Just now</span>
                                        
                                        <div class="border-style-for-timeline">
                                            <h4 class="fs-14 fw-medium mb-2">Weekly Stand-Up Meetings:</h4>
                                            <p class="fs-13">We continued our weekly stand-up meetings where team members provided updates on their current tasks, discussed any roadblocks, and coordinated efforts for the week ahead.</p>
                                            <p>By: <span class="text-primary">Olivia Rodriguez</span></p>
                                        </div>
                                    </div>
                                    <div class="position-relative timeline-item">
                                        <span class="time-line-date">1 day ago</span>
                                        
                                        <div class="border-style-for-timeline dot-2">
                                            <h4 class="fs-14 fw-medium mb-2">Project Kickoff Session:</h4>
                                            <p class="fs-13">The session included introductions, a review of project goals and objectives, and initial planning discussions.</p>
                                            <p>By: <span class="text-primary">Isabella Cooper</span></p>
                                        </div>
                                    </div>
                                    <div class="position-relative timeline-item">
                                        <span class="time-line-date">2 days ago</span>
                                        
                                        <div class="border-style-for-timeline dot-3">
                                            <h4 class="fs-14 fw-medium mb-2">Team Building Workshop:</h4>
                                            <p class="fs-13">Last Friday, we conducted a team building workshop focused on improving communication and collaboration among team members. Activities included team challenges, icebreakers, and open discussions.</p>
                                            <p>By: <span class="text-primary">Lucas Morgan</span></p>
                                        </div>
                                    </div>
                                    <div class="position-relative timeline-item">
                                        <span class="time-line-date">3 days ago</span>
                                        
                                        <div class="border-style-for-timeline dot-4 pb-0">
                                            <h4 class="fs-14 fw-medium mb-2">Lunch and Learn Session:</h4>
                                            <p class="fs-13">We organized a lunch and learn session on March 15th where a guest speaker from the industry discussed emerging trends in our field. It was an insightful session that sparked valuable discussions among team members.</p>
                                            <p>By: <span class="text-primary">Ethan Parker</span></p>
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
