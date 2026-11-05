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
                        <h3 class="mb-0">Project Overview</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Project Management</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Project Overview</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="fs-18 mb-3">Shopify Theme Development</h3>
                                    <div class="bg-primary p-4 rounded-3 mb-2">
                                        <div class="d-flex justify-content-between flex-wrap gap-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined wh-45 lh-45 text-white text-center rounded-circle" style="background-color: #4936F5;">for_you</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 position-relative">
                                                    <span class="fw-medium text-white d-block mb-1">Client</span>
                                                    <h4 class="fs-16 text-white mb-0">Innovatech</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined wh-45 lh-45 text-white text-center rounded-circle" style="background-color: #4936F5;">for_you</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 position-relative">
                                                    <span class="fw-medium text-white d-block mb-1">Budget</span>
                                                    <h4 class="fs-16 text-white mb-0">$25,500</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined wh-45 lh-45 text-white text-center rounded-circle" style="background-color: #4936F5;">for_you</i>
                                                </div>
                                                <div class="flex-grow-1 ms-2 position-relative">
                                                    <span class="fw-medium text-white d-block mb-1">Duration</span>
                                                    <h4 class="fs-16 text-white mb-0">360 hrs</h4>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="progress bg-light" style="height: 7px;" role="progressbar" aria-label="danger example" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-danger" style="width: 65%; height: 7px;"></div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span class="fw-medium d-block text-body-bg">Progress</span>
                                                <span class="fw-medium d-block text-body-bg">65%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                                        <span>Project Started: Mar 01, 2024</span>
                                        <span>Project Deadline: Jun 25, 2024</span>
                                    </div>
                                    <h4 class="fs-14">Project Details</h4>
                                    <p>Vestibulum euismod nisi vitae orci placerat, vitae vehicula eros dictum. Phasellus ut pharetra felis. Nulla facilisi. Nullam congue semper nunc, at sodales magna laoreet id. Nullam et lacus vitae ligula pretium suscipit. Fusce nec viverra enim. Sed feugiat gravida nibh sit amet suscipit. Integer tempor sapien eget metus lacinia, nec finibus lacus tincidunt. Sed sodales tellus nec metus aliquam, nec dignissim arcu lobortis.</p>
                                    <ul class="mb-0">
                                        <li class="mb-2">Outline the boundaries and deliverables of the project.</li>
                                        <li class="mb-2">List team members, their roles, and responsibilities.</li>
                                        <li class="mb-2">Specify the technology stack and tools to be used for development.</li>
                                        <li class="mb-2">Break down the project into manageable phases or sprints.</li>
                                        <li class="mb-0">Outline the design phase, including wireframing, prototyping</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h3 class="mb-0">Recent Activity</h3>
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
                        <div class="col-lg-6 col-md-6">
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

                                    <div id="projects_roadmap2"></div>
                                </div>
                            </div>
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4" style="padding-bottom: 0 !important;">
                                    <div class="mb-3 mb-lg-4">
                                        <h3 class="mb-0">Projects Overview</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-sm-6">
                                            <div class="card bg-primary bg-opacity-10 border-primary border-opacity-10 rounded-3 mb-4 stats-box style-three">
                                                <div class="card-body p-4">
                                                    <div class="d-flex align-items-center mb-35">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-symbols-outlined fs-40 text-primary">folder_open</i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <span>Active Projects</span>
                                                            <h3 class="fs-20 mt-1 mb-0">425</h3>
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
                                                    <div class="d-flex align-items-center mb-35">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-symbols-outlined fs-40 text-danger">stacks</i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <span>Total Projects</span>
                                                            <h3 class="fs-20 mt-1 mb-0">1235</h3>
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
                                                    <div class="d-flex align-items-center mb-35">
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
                                                    <div class="d-flex align-items-center mb-4">
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
                                                                <a href="my-profile">
                                                                    <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                </a>
                                                            </li>
                                                            <li class="ms-m-15">
                                                                <a href="my-profile">
                                                                    <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                </a>
                                                            </li>
                                                            <li class="ms-m-15">
                                                                <a href="my-profile">
                                                                    <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                                </a>
                                                            </li>
                                                            <li class="ms-m-15">
                                                                <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+55</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                                    <img src="assets/images/user-20.jpg" class="wh-44 rounded-circle" alt="user">
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
                                                                    <img src="assets/images/user-21.jpg" class="wh-44 rounded-circle" alt="user">
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
                                                                    <img src="assets/images/user-22.jpg" class="wh-44 rounded-circle" alt="user">
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
                                                                    <img src="assets/images/user-23.jpg" class="wh-44 rounded-circle" alt="user">
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
                                                                    <img src="assets/images/user-24.jpg" class="wh-44 rounded-circle" alt="user">
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
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-6">
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
        
                                    <div class="default-table-area style-two to-do-list padding-style">
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
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Tasks Overview</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>Last 7 Days</option>
                                            <option value="1">This Month</option>
                                            <option value="2">This Year</option>
                                        </select>
                                    </div>

                                    <div id="tasks_overview"></div>
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
