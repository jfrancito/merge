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
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4 position-relative">
                                <div class="card-body p-4">
                                    <h3 class="mb-0">Congratulations, <span class="text-primary">Olivia!</span></h3>
                                    <p>Best agent of the month</p>
                                    <h3 class="mb-0 fs-20 text-primary">1.5k+</h3>
                                    <p>Ticket Solved</p>
                                    <a href="my-profile" class="btn btn-primary fw-medium">View Profile</a>
                                </div>
                                <img src="/assets/images/congratulations.gif" class="congratulations wh-150 position-absolute" alt="congratulations">
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-xxl-6 col-md-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-3">
                                            <span class="mb-1 d-block">Tickets Resolved</span>
                                            <h3 class="mb-0 fs-20">2.4k</h3>
                                            <div id="tickets_resolved" style="margin: -11px 0;"></div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fs-12">This Month</span>
                                                <i class="material-symbols-outlined text-success">trending_up</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xxl-6 col-md-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-3">
                                            <span class="mb-1 d-block">Tickets In Progress</span>
                                            <h3 class="mb-0 fs-20">1.35k</h3>
                                            <div id="in_progress" style="margin: -11px 0;"></div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fs-12">This Month</span>
                                                <i class="material-symbols-outlined text-danger">trending_down</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xxl-6 col-md-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-3">
                                            <span class="mb-1 d-block">Tickets Due</span>
                                            <h3 class="mb-0 fs-20">980</h3>
                                            <div id="tickets_due" style="margin: -11px 0;"></div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fs-12">This Month</span>
                                                <i class="material-symbols-outlined text-danger">trending_down</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xxl-6 col-md-6 col-sm-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-3">
                                            <span class="mb-1 d-block">Tickets New Open</span>
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
                        </div>
                        <div class="col-lg-8">
                            <div class="row mb-4">
                                <div class="col-lg-12 col-xxl-8 col-sm-8 pe-sm-0 custom-p1 custom-xxxl-10">
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

                                            <div style="margin-top: -20px; margin-left: -15px; margin-bottom: -22px;">
                                                <div id="tickets_status"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xxl-4 col-sm-4 ps-sm-0 custom-p2 custom-xxxl-2">
                                    <div class="card bg-white border-0 rounded-3 rounded-start-0 position-relative border-start h-100">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-end mb-3 mb-lg-4 d-none d-sm-flex">
                                                <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                                    <option selected>This Week</option>
                                                    <option value="1">This Month</option>
                                                    <option value="2">This Year</option>
                                                </select>
                                            </div>
                                            <h4 class="fw-normal fs-18 mb-1">Avg. 1.5k</h4>
                                            <p class="mb-4">Tickets Weekly Solved</p>
                                            <div class="d-flex d-sm-block d-lg-flex d-xxl-block justify-content-between flex-wrap gap-2">
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
                            <div class="row">
                                <div class="col-lg-12 col-xxl-6">
                                    <div class="card bg-primary border-0 rounded-3 position-relative mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                                <h3 class="mb-0 text-white">Customer Satisfaction</h3>
                                                <select class="form-select month-select form-control p-0 h-auto border-0 w-90 text-white bg-transparent" style="background-position: right 0 center; background-image: url(/assets/images/down-white.svg);" aria-label="Default select example">
                                                    <option class="text-secondary" selected>Last Month</option>
                                                    <option class="text-secondary" value="1">Last Year</option>
                                                </select>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div id="customer_satisfaction" style="margin-bottom: -16px;"></div>
                                                <img src="/assets/images/satisfaction.png" alt="satisfaction">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xxl-6">
                                    <div class="card bg-white border-0 rounded-3 overflow-hidden mb-4">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                                <h3 class="mb-0">Response Time</h3>
                                                <select class="form-select month-select form-control p-0 h-auto border-0 w-99" style="background-position: right 0 center;" aria-label="Default select example">
                                                    <option selected>Last 30 Days</option>
                                                    <option value="1">Last 40 Days</option>
                                                    <option value="2">Last 50 Days</option>
                                                    <option value="3">Last 60 Days</option>
                                                    <option value="4">Last 90 Days</option>
                                                </select>
                                            </div>

                                            <div class="position-relative" style="height: 136px;">
                                                <p class="d-flex align-items-center mb-0 justify-content-center gap-1"><span class="fs-18 fw-bold text-body">1</span> hrs <span class="fs-18 fw-bold text-body">:22</span> mins</p>
                                            </div>

                                            <div style="left: 0; right: 0; bottom: -41px; position: absolute; margin-left: -12px; margin-right: -10px;">
                                                <div id="response_time"></div>
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
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">#854</td>
                                                <td>
                                                    <a href="agents" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="/assets/images/user-42.jpg" class="wh-34 rounded-circle" alt="user">
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
                                                            <img src="/assets/images/user-43.jpg" class="wh-34 rounded-circle" alt="user">
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
                                                            <img src="/assets/images/user-44.jpg" class="wh-34 rounded-circle" alt="user">
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
                                                            <img src="/assets/images/user-45.jpg" class="wh-34 rounded-circle" alt="user">
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
                                                            <img src="/assets/images/user-46.jpg" class="wh-34 rounded-circle" alt="user">
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
                                                            <img src="/assets/images/user-47.jpg" class="wh-34 rounded-circle" alt="user">
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
                                        <span class="fs-12 fw-medium">Showing 6 of 30 Results</span>
        
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="help-desk" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link active" href="help-desk">1</a></li>
                                                <li class="page-item"><a class="page-link" href="help-desk">2</a></li>
                                                <li class="page-item"><a class="page-link" href="help-desk">3</a></li>
                                                <li class="page-item"><a class="page-link" href="help-desk">4</a></li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="help-desk" aria-label="Next">
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
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card bg-white border-0 rounded-3 overflow-hidden mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-4">
                                        <h3 class="mb-0">New Tickets vs Solved Tickets</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-99" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>Last 7 Days</option>
                                            <option value="1">Last 30 Days</option>
                                            <option value="2">Last 50 Days</option>
                                            <option value="3">Last 60 Days</option>
                                            <option value="4">Last 90 Days</option>
                                        </select>
                                    </div>

                                    <div style="margin-bottom: -15px; margin-left: -10px; margin-top: -5px;">
                                        <div id="new_tickets_vs_solved_tickets"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h3 class="mb-0">Recent Customer Ratings</h3>
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

                                    <div class="default-table-area style-two recent-customer-ratings">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Ratings</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-25.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Olivia Clark</h6>
                                                                    <span class="fs-12 text-body">Big Data</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>28 April, 2024</td>
                                                        <td>
                                                            <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-26.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Ethan Parker</h6>
                                                                    <span class="fs-12 text-body">Python</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>25 April, 2024</td>
                                                        <td>
                                                            <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-half-fill text-rating-color fs-16"></i>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-27.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Ava Turner</h6>
                                                                    <span class="fs-12 text-body">UX/UI</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>23 April, 2024</td>
                                                        <td>
                                                            <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-line text-rating-color fs-16"></i>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-28.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Lucas Morgan</h6>
                                                                    <span class="fs-12 text-body">Developer</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>20 April, 2024</td>
                                                        <td>
                                                            <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-half-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-line text-rating-color fs-16"></i>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="instructors" class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-29.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                    <h6 class="mb-0 fs-14 fw-medium">Isabella Cooper</h6>
                                                                    <span class="fs-12 text-body">Designer</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>15 April, 2024</td>
                                                        <td>
                                                            <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-fill text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-line text-rating-color fs-16"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="ri-star-line text-rating-color fs-16"></i>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                            <span class="fs-12 fw-medium">Items per pages: 5</span>
            
                                            <div class="d-flex align-items-center">
                                                <span class="fs-12 fw-medium me-2">1 - 5 of 12</span>
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination mb-0 justify-content-center">
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="lms" aria-label="Previous">
                                                                <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="lms" aria-label="Next">
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
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
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
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Support Overview</h3>
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
