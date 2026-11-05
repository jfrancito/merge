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
                        <h3 class="mb-0">Invoice Details</h3>

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
                                    <span class="fw-medium">Invoice Details</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-lg-4 col-sm-4 col-md-4">
                                    <div class="mb-4">
                                        <p class="mb-4">Invoice Number: <span class="text-secondary">#1346</span></p>
                                        <p class="mb-1">Invoice To:</p>
                                        <p class="mb-1 text-secondary">Shannon Nelson</p>
                                        <p class="mb-1 text-secondary">4545 Seth Street Ballinger, TX 78965</p>
                                        <p class="mb-1 text-secondary">+1 444 556 8899</p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 col-md-4">
                                    <div class="mb-4 text-center">
                                        <img src="assets/images/qr-code.svg" class="wh-150" alt="qr-code">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 col-md-4">
                                    <div class="mb-4 text-sm-end">
                                        <p class="mb-4">Date: <span class="text-secondary">01 Dec 2024</span></p>
                                        <p class="mb-1">Pay To:</p>
                                        <p class="mb-1">Mercedes Foreman</p>
                                        <p class="mb-1">458 Friendship Lane Walnut Creek, CA 5828</p>
                                        <p class="mb-1">+1 444 888 0055</p>
                                    </div>
                                </div>
                            </div>

                            <div class="default-table-area all-products">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Item Description</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">01</td>
                                                <td class="text-secondary fw-medium">High-performance laptop with the latest specifications</td>
                                                <td class="text-body">4</td>
                                                <td class="text-body">$80</td>
                                                <td class="text-body">$320</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">02</td>
                                                <td class="text-secondary fw-medium">Complete set of ergonomic office furniture including a desk and chair</td>
                                                <td class="text-body">3</td>
                                                <td class="text-body">$45</td>
                                                <td class="text-body">$135</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">03</td>
                                                <td class="text-secondary fw-medium">Custom web development services including design, coding, and testing</td>
                                                <td class="text-body">5</td>
                                                <td class="text-body">$30</td>
                                                <td class="text-body">$150</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">04</td>
                                                <td class="text-secondary fw-medium">Expert consultation for developing and executing marketing strategies</td>
                                                <td class="text-body">1</td>
                                                <td class="text-body">$56</td>
                                                <td class="text-body">$56</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">05</td>
                                                <td class="text-secondary fw-medium">Design services for creating logos, graphics, and promotional materials</td>
                                                <td class="text-body">4</td>
                                                <td class="text-body">$90</td>
                                                <td class="text-body">$360</td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">06</td>
                                                <td class="text-secondary fw-medium">Purchase of networking equipment, including routers and switches</td>
                                                <td class="text-body">2</td>
                                                <td class="text-body">$75</td>
                                                <td class="text-body">$150</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Sub total:</td>
                                                <td class="text-body">$1,171</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Tax (5%)</td>
                                                <td class="text-body">$58.55</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="fw-medium text-secondary">Grand Total</td>
                                                <td class="text-secondary">$1,229.55</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
                                <button class="btn btn-danger py-2 px-4 fw-medium fs-16 text-white">Print</button>
                                <button class="btn btn-primary py-2 px-4 fw-medium fs-16"> <i class="ri-download-2-line text-white fw-medium"></i> Download</button>
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
