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
                        <h3 class="mb-0">Reports</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">HelpDesk</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Reports</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 overflow-hidden mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-4">
                                        <h3 class="mb-0">New vs Solved</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-99" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>Last 7 Days</option>
                                            <option value="1">Last 30 Days</option>
                                            <option value="2">Last 50 Days</option>
                                            <option value="3">Last 60 Days</option>
                                            <option value="4">Last 90 Days</option>
                                        </select>
                                    </div>

                                    <div id="new_vs_solved"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row mb-4">
                                <div class="col-lg-9 col-sm-8 pe-sm-0">
                                    <div class="card bg-white border-0 rounded-3 rounded-end-0 position-relative">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                                <h3 class="mb-0">Tickets Status</h3>
                                                <select class="form-select month-select form-control p-0 h-auto border-0 w-90 d-sm-none" style="background-position: right 0 center;" aria-label="Default select example">
                                                    <option selected>This Week</option>
                                                    <option value="1">This Month</option>
                                                    <option value="2">This Year</option>
                                                </select>
                                            </div>

                                            <div id="tickets_status"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-4 ps-sm-0">
                                    <div class="card bg-white border-0 rounded-3 rounded-start-0 position-relative border-start h-100">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-end mb-3 mb-lg-4 d-none d-sm-block">
                                                <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                                    <option selected>This Week</option>
                                                    <option value="1">This Month</option>
                                                    <option value="2">This Year</option>
                                                </select>
                                            </div>
                                            <h4 class="fw-normal fs-18 mb-1">Avg. 1.5k</h4>
                                            <p class="mb-4">Tickets Weekly Solved</p>
                                            <div class="d-flex d-sm-block justify-content-between flex-wrap gap-2">
                                                <div class="mb-3 pb-md-1">
                                                    <div class="mb-1">
                                                        <span class="wh-11 bg-primary rounded-1 d-inline-block position-relative top-1"></span>
                                                        <span>Solved</span>
                                                    </div>
                                                    <h4 class="fw-medium fs-18 mb-1">1.5k</h4>
                                                </div>
                                                <div class="mb-3 pb-md-1">
                                                    <div class="mb-1">
                                                        <span class="wh-11 bg-primary rounded-1 d-inline-block position-relative top-1"></span>
                                                        <span>In Progress</span>
                                                    </div>
                                                    <h4 class="fw-medium fs-18 mb-1">4.7k</h4>
                                                </div>
                                                <div class="mb-3 pb-md-1">
                                                    <div class="mb-1">
                                                        <span class="wh-11 bg-primary-div rounded-1 d-inline-block position-relative top-1"></span>
                                                        <span>Pending</span>
                                                    </div>
                                                    <h4 class="fw-medium fs-18 mb-1">780</h4>
                                                </div>
                                                <div>
                                                    <div class="mb-1">
                                                        <span class="wh-11 bg-danger rounded-1 d-inline-block position-relative top-1"></span>
                                                        <span>Others</span>
                                                    </div>
                                                    <h4 class="fw-medium fs-18 mb-1">320</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
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

                                    <div id="tasks_overview3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-primary border-0 rounded-3 position-relative mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0 text-white">Customer Satisfaction</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90 text-white bg-transparent" style="background-position: right 0 center; color: #fff !important;" aria-label="Default select example">
                                            <option class="text-secondary" selected>Last Month</option>
                                            <option class="text-secondary" value="1">Last Year</option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="customer_satisfaction2" style="margin-bottom: -16px;"></div>
                                        <img src="assets/images/satisfaction.png" alt="satisfaction">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 overflow-hidden mb-4">
                                <div class="card-body p-0">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-4 pb-0">
                                        <h3 class="mb-0">Response Time</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-99" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>Last 30 Days</option>
                                            <option value="1">Last 40 Days</option>
                                            <option value="2">Last 50 Days</option>
                                            <option value="3">Last 60 Days</option>
                                            <option value="4">Last 90 Days</option>
                                        </select>
                                    </div>

                                    <div id="response_time2" style="margin-bottom: -38px; margin-left: -20px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                    <h3 class="mb-0">Performance of Agents</h3>
                                    <select class="form-select month-select form-control p-0 h-auto border-0 w-110" style="background-position: right 0 center;" aria-label="Default select example">
                                        <option selected>Last 30 Days</option>
                                        <option value="1">Last 60 Days</option>
                                        <option value="2">Last 90 Days</option>
                                    </select>
                                </div>
                            </div>

                            <div class="default-table-area style-two all-projects">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Agent Name</th>
                                                <th scope="col">Total Tickets</th>
                                                <th scope="col">Open Tickets</th>
                                                <th scope="col">Resolved Tickets</th>
                                                <th scope="col">Avg. Resolution Time</th>
                                                <th scope="col">Satisfaction Rate</th>
                                                <th scope="col">Availability</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">#854</td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-42.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Oliver Khan</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">230</td>
                                                <td class="text-body">20</td>
                                                <td class="text-body">75</td>
                                                <td class="text-body">2.5 hours</td>
                                                <td>
                                                    <div id="status1" style="margin: -15px 0;"></div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Available</span>
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
                                                <td class="text-body">#853</td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-43.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Ava Cooper</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">180</td>
                                                <td class="text-body">16</td>
                                                <td class="text-body">35</td>
                                                <td class="text-body">1.4 hours</td>
                                                <td>
                                                    <div id="status2" style="margin: -15px 0;"></div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Available</span>
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
                                                <td class="text-body">#852</td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-44.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Isabella Evans</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">150</td>
                                                <td class="text-body">35</td>
                                                <td class="text-body">45</td>
                                                <td class="text-body">3.2 hours</td>
                                                <td>
                                                    <div id="status3" style="margin: -15px 0;"></div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Available</span>
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
                                                <td class="text-body">#851</td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-45.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Mia Hughes</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">75</td>
                                                <td class="text-body">86</td>
                                                <td class="text-body">25</td>
                                                <td class="text-body">4.5 hours</td>
                                                <td>
                                                    <div id="status4" style="margin: -15px 0;"></div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Available</span>
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
                                                <td class="text-body">#850</td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-46.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Noah Mitchell</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">320</td>
                                                <td class="text-body">90</td>
                                                <td class="text-body">10</td>
                                                <td class="text-body">3.8 hours</td>
                                                <td>
                                                    <div id="status5" style="margin: -15px 0;"></div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Not Available</span>
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
                                                <td class="text-body">#849</td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-47.jpg" class="wh-34 rounded-circle" alt="user">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 position-relative top-1">
                                                            <h6 class="mb-0 fs-14 fw-medium">Sophia Carter</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-body">120</td>
                                                <td class="text-body">55</td>
                                                <td class="text-body">20</td>
                                                <td class="text-body">5.3 hours</td>
                                                <td>
                                                    <div id="status6" style="margin: -15px 0;"></div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Available</span>
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
                                        <span class="fs-13 fw-medium">Items per pages: 6</span>
    
                                        <div class="d-flex align-items-center">
                                            <span class="fs-13 fw-medium me-2">1 - 6 of 12</span>
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="agents" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="agents" aria-label="Next">
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
