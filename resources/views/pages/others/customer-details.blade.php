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
                        <h3 class="mb-0">Customer Details</h3>

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
                                    <span class="fw-medium">Customer Details</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-xxl-9 col-lg-8 col-md-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Transactions History</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected="">Last Month</option>
                                            <option value="1">Last Month</option>
                                            <option value="2">Last Year</option>
                                        </select>
                                    </div>
        
                                    <div class="default-table-area recent-orders">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Order ID</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Rewards</th>
                                                        <th scope="col">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>#JAN-121</td>
                                                        <td>
                                                            <span class="badge bg-warning bg-opacity-10 text-warning p-2 fs-12 fw-normal">Pending</span>
                                                        </td>
                                                        <td>$6,855.00</td>
                                                        <td>$12.00</td>
                                                        <td>14 Jan 2024</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#JAN-120</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Successful</span>
                                                        </td>
                                                        <td>$258.00</td>
                                                        <td>$9.00</td>
                                                        <td>13 Jan 2024</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#JAN-119</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Rejected</span>
                                                        </td>
                                                        <td>$3,890.00</td>
                                                        <td>$11.00</td>
                                                        <td>12 Jan 2024</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#JAN-118</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Successful</span>
                                                        </td>
                                                        <td>$2,500.00</td>
                                                        <td>$23.42</td>
                                                        <td>11 Jan 2024</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#JAN-117</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Successful</span>
                                                        </td>
                                                        <td>$8,200.00</td>
                                                        <td>$10.84</td>
                                                        <td>10 Jan 2024</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#JAN-116</td>
                                                        <td>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Rejected</span>
                                                        </td>
                                                        <td>$640.00</td>
                                                        <td>$3.21</td>
                                                        <td>09 Jan 2024</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#JAN-115</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Successful</span>
                                                        </td>
                                                        <td>$9,100.00</td>
                                                        <td>$43.21</td>
                                                        <td>08 Jan 2024</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#JAN-114</td>
                                                        <td>
                                                            <span class="badge bg-warning bg-opacity-10 text-warning p-2 fs-12 fw-normal">Pending</span>
                                                        </td>
                                                        <td>$7,300.00</td>
                                                        <td>$42.42</td>
                                                        <td>07 Jan 2024</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#JAN-113</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Successful</span>
                                                        </td>
                                                        <td>$2,800.00</td>
                                                        <td>$11.21</td>
                                                        <td>06 Jan 2024</td>
                                                    </tr>
                                                    <tr>
                                                        <td>#JAN-112</td>
                                                        <td>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Successful</span>
                                                        </td>
                                                        <td>$6,600.00</td>
                                                        <td>$14.32</td>
                                                        <td>05 Jan 2024</td>
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
                                                            <a class="page-link icon" href="customer-details" aria-label="Previous">
                                                                <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="customer-details" aria-label="Next">
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
                        <div class="col-xxl-3 col-lg-4 col-md-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3 mb-lg-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-60.jpg" class="wh-65 rounded-circle border border-2" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                <h4 class="fs-16 fw-semibold mb-1">Ava Turner</h4>
                                                <span>Team Leader</span>
                                            </div>
                                        </div>

                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-symbols-outlined fs-20 text-body hover">more_horiz</i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="eye"></i>
                                                        View All 
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="edit"></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="trash-2"></i>
                                                        Delete One
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="lock"></i>
                                                        Block
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <span>Account ID:</span>
                                        <span class="d-block fw-medium text-secondary mt-1">ID-12174123</span>
                                    </div>
                                    <div class="mb-3">
                                        <span>Billing Email:</span>
                                        <span class="d-block fw-medium text-secondary mt-1">ava@trezo.com</span>
                                    </div>
                                    <div class="mb-3">
                                        <span>Delivery Address:</span>
                                        <span class="d-block fw-medium text-secondary mt-1">715 Maple St, Hamletville, England</span>
                                    </div>
                                    <div class="mb-3">
                                        <span>Language:</span>
                                        <span class="d-block fw-medium text-secondary mt-1">English, Spanish</span>
                                    </div>
                                    <div>
                                        <span>Latest Transaction:</span>
                                        <span class="d-block fw-medium text-secondary mt-1">#JAN-121</span>
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
