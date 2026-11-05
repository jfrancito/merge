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
                        <h3 class="mb-0">Refunds</h3>

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
                                    <span class="fw-medium">Refunds</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 mb-md-4">
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
                                                <th scope="col">ID</th>
                                                <th scope="col">Customer</th>
                                                <th scope="col">Date</th>
                                                <th scope="col" class="text-end">No. Order Returned</th>
                                                <th scope="col" class="text-end">No. Order Refunded</th>
                                                <th scope="col" class="text-end">No. Order Replaced</th>
                                                <th scope="col" class="text-end">Total Refunded	</th>
                                                <th scope="col" class="text-end">Total Replaced</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">#999</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-6.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Oliver Khan</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">19 Jun 2024</td>
                                                <td class="text-secondary text-end">2</td>
                                                <td class="text-secondary text-end">1</td>
                                                <td class="text-secondary text-end">0</td>
                                                <td class="text-secondary text-end">$42.00</td>
                                                <td class="text-secondary text-end">$50.00</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">#998</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-7.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Marcia Baker</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">19 Jun 2024</td>
                                                <td class="text-secondary text-end">1</td>
                                                <td class="text-secondary text-end">1</td>
                                                <td class="text-secondary text-end">0</td>
                                                <td class="text-secondary text-end">$32.00</td>
                                                <td class="text-secondary text-end">$54.00</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">#997</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-8.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Carolyn Barnes</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">20 Jun 2024</td>
                                                <td class="text-secondary text-end">2</td>
                                                <td class="text-secondary text-end">7</td>
                                                <td class="text-secondary text-end">4</td>
                                                <td class="text-secondary text-end">$53.00</td>
                                                <td class="text-secondary text-end">$67.00</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">#996</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-9.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Donna Miller</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">21 Jun 2024</td>
                                                <td class="text-secondary text-end">3</td>
                                                <td class="text-secondary text-end">1</td>
                                                <td class="text-secondary text-end">2</td>
                                                <td class="text-secondary text-end">$42.00</td>
                                                <td class="text-secondary text-end">$56.00</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">#995</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-10.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Barbara Cross</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">22 Jun 2024</td>
                                                <td class="text-secondary text-end">5</td>
                                                <td class="text-secondary text-end">2</td>
                                                <td class="text-secondary text-end">7</td>
                                                <td class="text-secondary text-end">$24.00</td>
                                                <td class="text-secondary text-end">$45.00</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">#994</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-11.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Rebecca Block</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">23 Jun 2024</td>
                                                <td class="text-secondary text-end">5</td>
                                                <td class="text-secondary text-end">6</td>
                                                <td class="text-secondary text-end">2</td>
                                                <td class="text-secondary text-end">$53.00</td>
                                                <td class="text-secondary text-end">$56.00</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">#993</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-12.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Ramiro McCarty</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">24 Jun 2024</td>
                                                <td class="text-secondary text-end">2</td>
                                                <td class="text-secondary text-end">6</td>
                                                <td class="text-secondary text-end">1</td>
                                                <td class="text-secondary text-end">$52.00</td>
                                                <td class="text-secondary text-end">$67.00</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">#992</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-13.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Robert Fairweather</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">25 Jun 2024</td>
                                                <td class="text-secondary text-end">6</td>
                                                <td class="text-secondary text-end">5</td>
                                                <td class="text-secondary text-end">4</td>
                                                <td class="text-secondary text-end">$42.00</td>
                                                <td class="text-secondary text-end">$46.00</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">#991</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-14.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Marcelino Haddock</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">26 Jun 2024</td>
                                                <td class="text-secondary text-end">7</td>
                                                <td class="text-secondary text-end">2</td>
                                                <td class="text-secondary text-end">5</td>
                                                <td class="text-secondary text-end">$44.00</td>
                                                <td class="text-secondary text-end">$68.00</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">#990</td>
                                                <td>
                                                    <a href="my-profile" class="d-flex align-items-center">
                                                        <img src="assets/images/user-15.jpg" class="wh-40 rounded-circle" alt="user">
                                                        <div class="ms-2 ps-1">
                                                            <h6 class="fw-medium fs-14 mb-0">Thomas Wilson</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-secondary">27 Jun 2024</td>
                                                <td class="text-secondary text-end">5</td>
                                                <td class="text-secondary text-end">1</td>
                                                <td class="text-secondary text-end">6</td>
                                                <td class="text-secondary text-end">$99.00</td>
                                                <td class="text-secondary text-end">$742.00</td>
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
                                                    <a class="page-link icon" href="refunds" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="refunds" aria-label="Next">
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
