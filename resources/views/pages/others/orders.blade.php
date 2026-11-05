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
                        <h3 class="mb-0">Orders</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">eCommerce</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Orders</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                                <form class="position-relative table-src-form me-0">
                                    <input type="text" class="form-control" placeholder="Search here">
                                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y">search</i>
                                </form>
                                <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                    <span class="py-sm-1 d-block">
                                        <i class="ri-add-line d-none d-sm-inline-block"></i>
                                        <span>Add New Customer</span>
                                    </span>
                                </button>
                            </div>

                            <div class="default-table-area recent-orders">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">Order ID</th>
                                                <th scope="col">Customer</th>
                                                <th scope="col">Items</th>
                                                <th scope="col">Created</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Vendor</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#JAN-2345</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-1.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Sarah Johnson</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>120</td>
                                                <td>12 Jan, 2024</td>
                                                <td>$10,490</td>
                                                <td>Dennis Matthews</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Shipped</span>
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
                                                <td>#JAN-1323</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-2.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Michael Smith</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>62</td>
                                                <td>08 Jan, 2024</td>
                                                <td>$6,575</td>
                                                <td>Kathryn Turner</td>
                                                <td>
                                                    <span class="badge bg-info bg-opacity-10 text-info p-2 fs-12 fw-normal">Confirmed</span>
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
                                                <td>#DEC-1234</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-3.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Emily Brown</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>49</td>
                                                <td>13 Dec, 2023</td>
                                                <td>$12,870</td>
                                                <td>John Valdez</td>
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
                                                <td>#DEC-3567</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-4.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Jason Lee</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>25</td>
                                                <td>05 Dec, 2023</td>
                                                <td>$7,895</td>
                                                <td>Douglas Harvey</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Shipped</span>
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
                                                <td>#DEC-1098</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-5.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Ashley Davis</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>82</td>
                                                <td>01 Dec, 2023</td>
                                                <td>$4,680</td>
                                                <td>Susan Rader</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Rejected</span>
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
                                                <td>#JAN-2345</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-1.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Sarah Johnson</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>120</td>
                                                <td>12 Jan, 2024</td>
                                                <td>$10,490</td>
                                                <td>Dennis Matthews</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Shipped</span>
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
                                                <td>#JAN-1323</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-2.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Michael Smith</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>62</td>
                                                <td>08 Jan, 2024</td>
                                                <td>$6,575</td>
                                                <td>Kathryn Turner</td>
                                                <td>
                                                    <span class="badge bg-info bg-opacity-10 text-info p-2 fs-12 fw-normal">Confirmed</span>
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
                                                <td>#DEC-1234</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-3.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Emily Brown</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>49</td>
                                                <td>13 Dec, 2023</td>
                                                <td>$12,870</td>
                                                <td>John Valdez</td>
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
                                                <td>#DEC-3567</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-4.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Jason Lee</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>25</td>
                                                <td>05 Dec, 2023</td>
                                                <td>$7,895</td>
                                                <td>Douglas Harvey</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">Shipped</span>
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
                                                <td>#DEC-1098</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-5.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14">Ashley Davis</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>82</td>
                                                <td>01 Dec, 2023</td>
                                                <td>$4,680</td>
                                                <td>Susan Rader</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Rejected</span>
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
                                    <span class="fs-13 fw-medium">Items per pages: 10</span>
    
                                    <div class="d-flex align-items-center">
                                        <span class="fs-13 fw-medium me-2">1 - 10 of 12</span>
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="orders" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="orders" aria-label="Next">
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
