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
                        <h3 class="mb-0">Edit Invoice</h3>

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
                                    <span class="fw-medium">Edit Invoice</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <form class="mb-4">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Invoice ID</label>
                                            <input type="text" class="form-control h-55" value="#JAN-2345" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Status</label>
                                            <select class="form-select form-control h-55" aria-label="Default select example">
                                                <option selected>Paid</option>
                                                <option value="1">Status</option>
                                                <option value="2">Unpaid</option>
                                                <option value="3">Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Date</label>
                                            <input type="date" class="form-control h-55">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Due Date</label>
                                            <input type="date" class="form-control h-55">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-0 border p-4 rounded-3 position-relative">
                                            <p class="mb-4 text-secondary fw-medium">From:</p>
                                            <p class="mb-1 fw-medium text-secondary">Olivia John</p>
                                            <p class="mb-1 text-body">olivia@trezo.com</p>
                                            <p class="mb-1 text-body">4545 Seth Street Ballinger, TX 78965</p>
                                            <p class="mb-0 text-body">+1 444 556 8899</p>
                                            <button type="submit" class="btn border-primary text-primary position-absolute hover-bg" style="right: 24px; top: 24px;">
                                                <i class="ri-pencil-line"></i>
                                                Change
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mt-4 mt-md-0 border p-4 rounded-3 position-relative h-md-100">
                                            <p class="mb-4 text-secondary fw-medium">To:</p>
                                            <p class="mb-1 fw-medium text-secondary">Alina Smith</p>
                                            <p class="mb-1 text-body">smith@trezo.com</p>
                                            <p class="mb-1 text-body">4545 Seth Street Ballinger, TX 78965</p>
                                            <p class="mb-0 text-body">+1 444 556 8899</p>
                                            <button type="submit" class="btn border-primary text-primary position-absolute hover-bg" style="right: 24px; top: 24px;">
                                                <i class="ri-add-line"></i>
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">1</td>
                                                <td>
                                                    <input type="text" class="form-control h-55" value="Apple MacBook Pro 16.2' with M3 Pro Chip">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control h-55" value="4">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control h-55" value="$80.00">
                                                </td>
                                                <td class="text-body">$320.00</td>
                                                <td>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                        <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">2</td>
                                                <td>
                                                    <input type="text" class="form-control h-55" value="SAMSUNG Galaxy Tab A9+ Tablet 11'">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control h-55" value="3">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control h-55" value="$45.00">
                                                </td>
                                                <td class="text-body">$135.00</td>
                                                <td>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                        <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-body">3</td>
                                                <td>
                                                    <input type="text" class="form-control h-55" value="Apple iPhone 15 Pro Max (512 GB)">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control h-55" value="5">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control h-55" value="$30.00">
                                                </td>
                                                <td class="text-body">$150.00</td>
                                                <td>
                                                    <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                        <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <button class="btn btn-primary">
                                                        <i class="ri-add-line text-white"></i>
                                                        Add Item
                                                    </button>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <label class="text-secondary label">Discount(%)</label>
                                                    <input type="text" class="form-control h-55" value="0.54">
                                                </td>
                                                <td>
                                                    <label class="text-secondary label">Tax(%)</label>
                                                    <input type="text" class="form-control h-55" value="0.22">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-body">Sub total:</td>
                                                <td class="text-body">$971.00</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-body">Tax (5%)</td>
                                                <td class="text-body">$5.00</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-body">Discount (0%)</td>
                                                <td class="text-body">- $5.00</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="fw-medium text-secondary">Grand Total</td>
                                                <td class="text-secondary">$971.00</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
                                <button class="btn btn-danger py-2 px-4 fw-medium fs-16 text-white">Cancel</button>
                                <button class="btn btn-primary py-2 px-4 fw-medium fs-16"> <i class="ri-add-line text-white fw-medium"></i> Create</button>
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
