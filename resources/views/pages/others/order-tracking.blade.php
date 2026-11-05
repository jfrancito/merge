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
                        <h3 class="mb-0">Order Tracking</h3>

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
                                    <span class="fw-medium">Order Tracking</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-xxl-8 col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                        <div>
                                            <h3 class="text-secondary mb-4">Order ID #2435679</h3>
                                            <span class="d-block mb-2">IBAN: EST6049283742809</span>
                                            <span class="d-block">Date: 26 Mar 2024</span>
                                        </div>
                                        <h3 class="text-secondary mb-0">Tracking ID: 000346798254</h3>
                                    </div>

                                    <div class="d-flex justify-content-between tracking-step style-two flex-wrap gap-3 my-lg-5 my-4">
                                        <div>
                                            <span class="text-secondary fw-semibold count text-center mb-3 bg-white">01</span>
                                            <span class="d-block text-secondary fw-semibold fs-16 mb-1">Order Placed</span>
                                            <span>22 Mar 2024 - 11:35AM</span>
                                        </div>
                                        <div>
                                            <span class="text-secondary fw-semibold count text-center mb-3 bg-white">02</span>
                                            <span class="d-block text-secondary fw-semibold fs-16 mb-1">Packed</span>
                                            <span>23 Mar 2024 - 10:35AM</span>
                                        </div>
                                        <div>
                                            <span class="text-secondary fw-semibold count text-center mb-3 bg-white">03</span>
                                            <span class="d-block text-secondary fw-semibold fs-16 mb-1">Shipped</span>
                                            <span>24 Mar 2024 - 3:45PM</span>
                                        </div>
                                        <div>
                                            <span class="text-white fw-semibold count text-center mb-3 active">04</span>
                                            <span class="d-block text-secondary fw-semibold fs-16 mb-1">Delivered</span>
                                            <span>25 Mar 2024 - 2:21PM</span>
                                        </div>
                                    </div>

                                    <span class="fw-semibold text-secondary mb-2 pb-1 d-block">View Details:</span>
                                    <span class="mb-2 pb-1 d-block">25 Mar 2024 - 2:21PM: <span class="text-secondary">Your order delivered.</span></span>
                                    <span class="mb-2 pb-1 d-block">24 Mar 2024 - 3:45PM: <span class="text-secondary">Your order shipped.</span></span>
                                    <span class="mb-2 pb-1 d-block">23 Mar 2024 - 10:35AM: <span class="text-secondary">Your order is on the way for deliver.</span></span>
                                    <span class="d-block">22 Mar 2024 - 11:35AM: <span class="text-secondary">Your order is now on warehouse. It’s being ready for shipped.</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Order Summary</h3>

                                    <div class="default-table-area">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Description</th>
                                                        <th scope="col" class="text-end">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Grand Total :</td>
                                                        <td class="text-end">$1,105.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Discount :</td>
                                                        <td class="text-end">-$105.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tax :</td>
                                                        <td class="text-end">$75.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-secondary fw-medium">Subtotal :</td>
                                                        <td class="text-secondary fw-medium text-end">$1,000.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Shipping Charge :</td>
                                                        <td class="text-end">$80.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Coupon Charge :</td>
                                                        <td class="text-secondary text-end">$20.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-secondary fw-medium">Total :</td>
                                                        <td class="text-secondary fw-medium text-end">$900.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
