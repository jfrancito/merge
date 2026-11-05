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
                        <h3 class="mb-0">Cart</h3>

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
                                    <span class="fw-medium">Cart</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-xxl-8 col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-lg-4 mb-3">
                                        <h3 class="mb-0">Your Order</h3>
                                        <h3 class="mb-0">Customer ID : 357951</h3>
                                    </div>
                                    <div class="default-table-area all-carts mb-3 mb-lg-4">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Order ID</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-secondary">#JAN-2345</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-1.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14 mb-0">Smart Band</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="product-quantity">
                                                                <div class="add-to-cart-counter">
                                                                    <input type="button" class="minusBtn" value="-">
                                                                    <input type="text" size="25" value="1" class="count"> 
                                                                    <input type="button" class="plusBtn" value="+">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-body">$80.00</td>
                                                        <td class="text-body">$80.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-secondary">#JAN-1323</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-2.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14 mb-0">Headphone</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="product-quantity">
                                                                <div class="add-to-cart-counter">
                                                                    <input type="button" class="minusBtn" value="-">
                                                                    <input type="text" size="25" value="7" class="count"> 
                                                                    <input type="button" class="plusBtn" value="+">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-body">$150.00</td>
                                                        <td class="text-body">$450.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-secondary">#DEC-1234</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-3.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14 mb-0">iPhone 15 Plus</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="product-quantity">
                                                                <div class="add-to-cart-counter">
                                                                    <input type="button" class="minusBtn" value="-">
                                                                    <input type="text" size="25" value="1" class="count"> 
                                                                    <input type="button" class="plusBtn" value="+">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-body">$750.00</td>
                                                        <td class="text-body">$750.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-secondary">#DEC-3567</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-4.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14 mb-0">Bluetooth Speaker</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="product-quantity">
                                                                <div class="add-to-cart-counter">
                                                                    <input type="button" class="minusBtn" value="-">
                                                                    <input type="text" size="25" value="5" class="count"> 
                                                                    <input type="button" class="plusBtn" value="+">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-body">$15.00</td>
                                                        <td class="text-body">$75.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-secondary">#DEC-1098</td>
                                                        <td>
                                                            <a href="product-details" class="d-flex align-items-center">
                                                                <img src="assets/images/product-5.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14 mb-0">Airbuds 2nd Gen</h6>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="product-quantity">
                                                                <div class="add-to-cart-counter">
                                                                    <input type="button" class="minusBtn" value="-">
                                                                    <input type="text" size="25" value="2" class="count"> 
                                                                    <input type="button" class="plusBtn" value="+">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-body">$25.00</td>
                                                        <td class="text-body">$50.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="mw-430">
                                        <input type="text" class="form-control h-55" placeholder="Coupon code">
                                        <button type="submit" class="btn btn-primary py-2 px-md-4 px-3 fa-16 fw-medium mt-lg-4 mt-3">
                                            <div class="d-flex align-items-center py-md-1">
                                                <i class="material-symbols-outlined me-1 text-white">done_all</i>
                                                <span>Apply</span>
                                            </div>
                                        </button>
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

                                    <form>
                                        <div class="form-group">
                                            <label class="label fs-15 fw-bold text-secondary">Add A Note</label>
                                            <textarea rows="5" class="form-control" placeholder="Write here"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary py-2 px-md-4 px-3 fa-16 fw-medium mt-lg-4 mt-3">
                                            <div class="d-flex align-items-center py-md-1">
                                                <i class="material-symbols-outlined me-1 text-white">add</i>
                                                <span>Proceed To Shipping</span>
                                            </div>
                                        </button>
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
