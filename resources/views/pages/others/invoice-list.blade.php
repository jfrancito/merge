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
                        <h3 class="mb-0">Invoices</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Invoice</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Invoices</span>
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
                                <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                    <option selected>This Month</option>
                                    <option value="1">Last Month</option>
                                    <option value="2">Last Year</option>
                                </select>
                            </div> 

                            <div class="default-table-area all-products">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">Invoice ID</th>
                                                <th scope="col">Customer</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Issued Date</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Wallet Balance</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">#JAN-158</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-6.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Marcia Baker</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">marcia@trezo.com</td>
                                                <td class="text-secondary">10 Nov 2024</td>
                                                <td class="text-secondary">$5,000</td>
                                                <td class="text-secondary">6</td>
                                                <td class="text-secondary">$2,000</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print">
                                                            <i class="material-symbols-outlined fs-16 text-body">print</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-325</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-7.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Carolyn Barnes</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">barnes@trezo.com</td>
                                                <td class="text-secondary">11 Nov 2024</td>
                                                <td class="text-secondary">$8,750</td>
                                                <td class="text-secondary">10</td>
                                                <td class="text-secondary">$4,500</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print">
                                                            <i class="material-symbols-outlined fs-16 text-body">print</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-286</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-8.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Donna Miller</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">donna@trezo.com</td>
                                                <td class="text-secondary">12 Nov 2024</td>
                                                <td class="text-secondary">$3,200</td>
                                                <td class="text-secondary">6</td>
                                                <td class="text-secondary">$1,550</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print">
                                                            <i class="material-symbols-outlined fs-16 text-body">print</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-463</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-9.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Barbara Cross</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">cross@trezo.com</td>
                                                <td class="text-secondary">13 Nov 2024</td>
                                                <td class="text-secondary">$3,750</td>
                                                <td class="text-secondary">4</td>
                                                <td class="text-secondary">$2,490</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print">
                                                            <i class="material-symbols-outlined fs-16 text-body">print</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-998</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-10.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Rebecca Block</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">block@trezo.com</td>
                                                <td class="text-secondary">14 Nov 2024</td>
                                                <td class="text-secondary">$6,000</td>
                                                <td class="text-secondary">2</td>
                                                <td class="text-secondary">$3,599</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print">
                                                            <i class="material-symbols-outlined fs-16 text-body">print</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-436</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-11.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Ramiro McCarty</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">ramiro@trezo.com</td>
                                                <td class="text-secondary">15 Nov 2024</td>
                                                <td class="text-secondary">$9,200</td>
                                                <td class="text-secondary">8</td>
                                                <td class="text-secondary">$5,800</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print">
                                                            <i class="material-symbols-outlined fs-16 text-body">print</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-860</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-12.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Robert Fairweather</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">robert@trezo.com</td>
                                                <td class="text-secondary">16 Nov 2024</td>
                                                <td class="text-secondary">$2,500</td>
                                                <td class="text-secondary">6</td>
                                                <td class="text-secondary">$1,200</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print">
                                                            <i class="material-symbols-outlined fs-16 text-body">print</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-491</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-13.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Marcelino Haddock</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">haddock@trezo.com</td>
                                                <td class="text-secondary">17 Nov 2024</td>
                                                <td class="text-secondary">$7,300</td>
                                                <td class="text-secondary">9</td>
                                                <td class="text-secondary">$4,850</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print">
                                                            <i class="material-symbols-outlined fs-16 text-body">print</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-125</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-14.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Thomas Wilson</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">wildon@trezo.com</td>
                                                <td class="text-secondary">18 Nov 2024</td>
                                                <td class="text-secondary">$4,800</td>
                                                <td class="text-secondary">5</td>
                                                <td class="text-secondary">$2,300</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print">
                                                            <i class="material-symbols-outlined fs-16 text-body">print</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#JAN-579</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/user-15.jpg" class="wh-40 rounded-3" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Nathaniel Hulsey</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">hulsey@trezo.com</td>
                                                <td class="text-secondary">19 Nov 2024</td>
                                                <td class="text-secondary">$6,500</td>
                                                <td class="text-secondary">6</td>
                                                <td class="text-secondary">$4,560</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print">
                                                            <i class="material-symbols-outlined fs-16 text-body">print</i>
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
                                    <span class="fs-13 fw-medium">Items per pages: 10</span>

                                    <div class="d-flex align-items-center">
                                        <span class="fs-13 fw-medium me-2">1 - 10 of 12</span>
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="invoice-list" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="invoice-list" aria-label="Next">
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
