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
                        <h3 class="mb-0">Checkout</h3>

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
                                    <span class="fw-medium">Checkout</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-xxl-8 col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-lg-4 mb-3">Billing Information</h3>

                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="label text-secondary">Customer Name</label>
                                                <input type="text" class="form-control h-55" placeholder="Enter Customer Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="label text-secondary">Phone Number</label>
                                                <input type="text" class="form-control h-55" placeholder="Enter Phone Number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="label text-secondary">Email Address</label>
                                                <input type="email" class="form-control h-55" placeholder="Enter Email Address">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="label text-secondary">State</label>
                                                <select class="form-select form-control h-55" aria-label="Default select example">
                                                    <option selected>State</option>
                                                    <option value="1">Florida</option>
                                                    <option value="2">Wisconsin</option>
                                                    <option value="3">Washington</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="label text-secondary">City</label>
                                                <select class="form-select form-control h-55" aria-label="Default select example">
                                                    <option selected>State</option>
                                                    <option value="1">New York</option>
                                                    <option value="2">Tokyo</option>
                                                    <option value="3">Amsterdam</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="label text-secondary">ZIP / Postcode</label>
                                                <input type="text" class="form-control h-55" placeholder="Enter zip postcode">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="label text-secondary">Street Address</label>
                                                <input type="text" class="form-control h-55" placeholder="Enter Street Address">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="label text-secondary">Country</label>
                                                <select class="form-select form-control h-55" aria-label="Default select example">
                                                    <option selected>Select</option>
                                                    <option value="1">USA</option>
                                                    <option value="2">Canada</option>
                                                    <option value="3">Spain</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-4">
                                                <label class="label text-secondary">Order Note (optional)</label>
                                                <textarea rows="6" class="form-control" placeholder="Write your note here...."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="d-flex flex-wrap gap-3">
                                                <button class="btn btn-danger py-2 px-4 fw-medium fs-16 text-white">Cancel</button>
                                                <button class="btn btn-primary py-2 px-4 fw-medium fs-16"> <i class="ri-add-line text-white fw-medium"></i> Create Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Order Summary</h3>
                                    <div class="default-table-area mb-3 mb-lg-4">
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
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Payment Method</h3>

                                    <form>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Payment Card</label>
                                                    <select class="form-select form-control h-55" aria-label="Default select example">
                                                        <option selected>Select</option>
                                                        <option value="1">PayPal</option>
                                                        <option value="2">Helcim</option>
                                                        <option value="3">Square</option>
                                                        <option value="4">Stripe</option>
                                                        <option value="4">Stax</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Card Number</label>
                                                    <input type="text" class="form-control h-55" placeholder="Enter Card Number">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Expiration Date</label>
                                                    <input type="date" class="form-control h-55">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-6">
                                                <div class="form-group mb-0">
                                                    <label class="label text-secondary">Security Code</label>
                                                    <input type="text" class="form-control h-55" placeholder="Enter Security Code">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
