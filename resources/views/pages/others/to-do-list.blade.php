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
                        <h3 class="mb-0">To Do List</h3>

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
                                    <span class="fw-medium">To Do List</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 p-4">
                                <form class="position-relative table-src-form me-0">
                                    <input type="text" class="form-control" placeholder="Search here">
                                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                </form>
                                <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                    <span class="py-sm-1 d-block">
                                        <i class="ri-add-line d-none d-sm-inline-block"></i>
                                        <span>Add New Task</span>
                                    </span>
                                </button>
                            </div>

                            <div class="default-table-area style-two default-table-width">
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
                                            <tr>
                                                <td class="text-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault12">#849</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="project-overview" class="text-body">Hotel Management System</a>
                                                </td>
                                                <td>Shawn Kennedy</td>
                                                <td class="text-body">30 Apr 2024</td>
                                                <td class="text-body">High</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-25 text-success p-2 fs-12 fw-normal">Finished</span>
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
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault13">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault13">#848</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="project-overview" class="text-body">Send Proposal to APR Ltd</a>
                                                </td>
                                                <td>Roberto Cruz</td>
                                                <td class="text-body">25 Apr 2024</td>
                                                <td class="text-body">Low</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-25 text-danger p-2 fs-12 fw-normal">Pending</span>
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
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault14">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault14">#847</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="project-overview" class="text-body">Python Upgrade</a>
                                                </td>
                                                <td>Juli Johnson</td>
                                                <td class="text-body">20 Apr 2024</td>
                                                <td class="text-body">Medium</td>
                                                <td>
                                                    <span class="badge bg-primary-div bg-opacity-25 text-primary-div p-2 fs-12 fw-normal">In Progress</span>
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
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault15">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault15">#846</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="project-overview" class="text-body">Schedule meeting with Trezo</a>
                                                </td>
                                                <td>Catalina Engles</td>
                                                <td class="text-body">15 Apr 2024</td>
                                                <td class="text-body">High</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-25 text-success p-2 fs-12 fw-normal">Finished</span>
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
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault16">
                                                        <label class="position-relative top-2 ms-1" for="flexCheckDefault16">#845</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="project-overview" class="text-body">Engineering Lite Touch</a>
                                                </td>
                                                <td>Louis Nagle</td>
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
                                <div class="p-4 pt-lg-4">
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                        <span class="fs-12 fw-medium">Showing 10 of 30 Results</span>
        
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="to-do-list" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link active" href="to-do-list">1</a></li>
                                                <li class="page-item"><a class="page-link" href="to-do-list">2</a></li>
                                                <li class="page-item"><a class="page-link" href="to-do-list">3</a></li>
                                                <li class="page-item"><a class="page-link" href="to-do-list">4</a></li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="to-do-list" aria-label="Next">
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
