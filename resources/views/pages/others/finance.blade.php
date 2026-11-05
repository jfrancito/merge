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
                    <div class="row">
                        <div class="col-sm-6 col-xxl-3">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex mb-4">
                                        <div class="flex-grow-1">
                                            <span class="d-block mb-1">Total Income</span>
                                            <h4 class="fs-20 mb-0">$531,200</h4>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <i class="ri-money-dollar-circle-line fs-24 text-success for dark-bg d-inline-block text-center rounded-circle" style="width: 60px; height: 60px; line-height: 60px; background-color: #ECF0FF;"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="d-inline-block px-3 bg-success bg-opacity-10 text-success border border-success rounded-pill fs-12 fw-medium">+35.5%</span>
                                        <span class="ms-2 fs-12">Last 30 days</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex mb-4">
                                        <div class="flex-grow-1">
                                            <span class="d-block mb-1">Total Expenses</span>
                                            <h4 class="fs-20 mb-0">$251,952</h4>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <i class="ri-wallet-2-line fs-24 text-primary-div for dark-bg d-inline-block text-center rounded-circle" style="width: 60px; height: 60px; line-height: 60px; background-color: #ECF0FF;"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="d-inline-block px-3 bg-danger bg-opacity-10 text-danger border border-danger rounded-pill fs-12 fw-medium">-28.5%</span>
                                        <span class="ms-2 fs-12">Last 30 days</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex mb-4">
                                        <div class="flex-grow-1">
                                            <span class="d-block mb-1">Accounts Receivable</span>
                                            <h4 class="fs-20 mb-0">$15,990</h4>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <i class="ri-shopping-bag-2-line fs-24 text-primary for dark-bg d-inline-block text-center rounded-circle" style="width: 60px; height: 60px; line-height: 60px; background-color: #ECF0FF;"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="d-inline-block px-3 bg-danger bg-opacity-10 text-danger border border-danger rounded-pill fs-12 fw-medium">-5.8%</span>
                                        <span class="ms-2 fs-12">Last 30 days</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex mb-4">
                                        <div class="flex-grow-1">
                                            <span class="d-block mb-1">Account Payable</span>
                                            <h4 class="fs-20 mb-0">$14,580</h4>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <i class="ri-currency-line fs-24 text-primary for dark-bg d-inline-block text-center rounded-circle" style="width: 60px; height: 60px; line-height: 60px; background-color: #ECF0FF;"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="d-inline-block px-3 bg-danger bg-opacity-10 text-danger border border-danger rounded-pill fs-12 fw-medium">-10.1%</span>
                                        <span class="ms-2 fs-12">Last 30 days</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                                        <h3 class="mb-0">Static</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color bg-transparent" aria-label="Default select example">
                                            <option selected="">Monthly</option>
                                            <option value="1">Last 90 days</option>
                                            <option value="1">Last 1 year</option>
                                        </select>
                                    </div>
                                    
                                    <div style="margin: -25px -9px -20px -16px;">
                                        <div id="static"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-md-6 col-lg-12">
                                    <div class="card border-0 rounded-3 bg-white mb-4">
                                        <div class="card-body p-4">
                                            <span class="d-block mb-3">Cash at End of the Month</span>
                                            <div style="margin: -37px 0 -5px 0;">
                                                <div id="cash_at_end_of_the_month" style="width: 300px; height:166px;" class="m-auto"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12">
                                    <div class="card bg-white border-0 rounded-3 mb-4 stats-box">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
                                                <div>
                                                    <div class="d-flex align-items-center">
                                                        <span>Weekly Expenses</span>
                                                        <span class="d-inline-block px-2 bg-danger bg-opacity-10 text-danger border border-danger rounded-pill fs-12 fw-medium ms-2">-5.1%</span>
                                                    </div>
                                                    <h3 class="fs-20 mt-1 mb-0">$1,200</h3>
                                                </div>
                                                <span class="fs-12">Last 7 days</span>
                                            </div>
                                            <div style="margin: -25px -11px -28px -2px;">
                                                <div id="weekly_expenses"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-4">
                            <div class="row">
                                <div class="col-md-6 col-xxl-12">
                                    <div class="card border-0 rounded-3 mb-4" style="background: linear-gradient(120deg, #343A46 0%, #23272E 99.29%);">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between flex-wrap gap-2 mb-4">
                                                <h3 class="fs-18 mb-0 text-white">Income Source</h3>
                                                <span class="fs-12 text-white">Last 30 days</span>
                                            </div>
        
                                            <div style="margin: -51px 0 -5px 0;">
                                                <div id="income_source" class="mx-auto" style="width: 300px; height: 250px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xxl-12">
                                    <div class="card bg-white border-0 rounded-3 mb-4 stats-box">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between flex-wrap gap-2 mb-4">
                                                <div>
                                                    <div class="d-flex align-items-center">
                                                        <span>Net Profit</span>
                                                        <span class="d-inline-block px-2 bg-success bg-opacity-10 text-success border border-success rounded-pill fs-12 fw-medium ms-2">+7.6%</span>
                                                    </div>
                                                    <h3 class="fs-20 mt-1 mb-0">$42,458</h3>
                                                </div>
                                                <span class="fs-12">Last 7 days</span>
                                            </div>
                                            <div style="margin: -24px -20px -28px -18px;">
                                                <div id="net_profit"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-0">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-4">
                                        <h3 class="mb-0">Transaction History</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color bg-transparent" aria-label="Default select example">
                                            <option selected="">Last 30 days</option>
                                            <option value="1">Last 90 days</option>
                                            <option value="1">Last 1 year</option>
                                        </select>
                                    </div>
        
                                    <div class="default-table-area style-two transaction-history">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                </div>
                                                                <span class="ms-1"><span class="fs-12 fw-bold">Transaction</span> ID</span>
                                                            </div>
                                                        </th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Description</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Type</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                                </div>
                                                                <span class="ms-1 text-secondary">#TID0015</span>
                                                            </div>
                                                        </td>
                                                        <td>2024-10-01</td> 
                                                        <td>Payment from Client</td> 
                                                        <td class="text-primary">$5,000</td> 
                                                        <td>Income</td> 
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
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                                </div>
                                                                <span class="ms-1 text-secondary">#TID0099</span>
                                                            </div>
                                                        </td>
                                                        <td>2024-09-28</td> 
                                                        <td>Office Supplies</td> 
                                                        <td class="text-primary">$10,000</td> 
                                                        <td>Expense</td> 
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
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                                </div>
                                                                <span class="ms-1 text-secondary">#TID0145</span>
                                                            </div>
                                                        </td>
                                                        <td>2024-09-25</td> 
                                                        <td>Website Maintenance</td> 
                                                        <td class="text-primary">$35,000</td> 
                                                        <td>Expense</td> 
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
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                                </div>
                                                                <span class="ms-1 text-secondary">#TID0247</span>
                                                            </div>
                                                        </td>
                                                        <td>2024-09-22</td> 
                                                        <td>Payment from Client</td> 
                                                        <td class="text-primary">$2,000</td> 
                                                        <td>Income</td> 
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
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                                </div>
                                                                <span class="ms-1 text-secondary">#TID0299</span>
                                                            </div>
                                                        </td>
                                                        <td>2024-09-20</td> 
                                                        <td>Advertising Campaign</td> 
                                                        <td class="text-primary">$15,500</td> 
                                                        <td>Expense</td> 
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
            
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap p-4">
                                            <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/finance" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/finance">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/finance">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/finance">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/finance">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/finance" aria-label="Next">
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
                    <div class="row">
                        <div class="col-xxl-8 col-lg-7">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="card-body p-4 pb-0">
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
                                        <h3 class="mb-0">Card</h3>
                                        <button class="btn btn-outline-primary hover-bg fs-14 fw-medium" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="ri-add-line"></i>
                                            <span>Add Card</span>
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 mb-4">
                                            <div class="bg-img p-4 rounded-3" style="background-image: url(/assets/images/debit-card.png);">
                                                <div class="d-flex align-content-center justify-content-between mb-4">
                                                    <span class="text-white fs-12 fw-medium">Debit Card</span>
                                                    <img src="/assets/images/debit.svg" alt="debit">
                                                </div>
                                                <img class="mb-4" src="/assets/images/board-1.png" alt="board">
                                                <h3 class="fw-semibold text-white mb-5 pb-md-4 d-flex gap-3"><span>5322</span><span>0520</span><span>0744</span><span>1794</span></h3>
                                                <div class="d-flex align-content-center justify-content-between">
                                                    <span class="text-white">David Farrior</span>
                                                    <span class="text-white fs-12 fw-medium">EXP : 12/30</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-4">
                                            <div class="bg-img p-4 rounded-3" style="background-image: url(/assets/images/virtual-card.png);">
                                                <div class="d-flex align-content-center justify-content-between mb-4">
                                                    <span class="text-white fs-12 fw-medium">Debit Card</span>
                                                    <img src="/assets/images/virtual.svg" alt="debit">
                                                </div>
                                                <img class="mb-4" src="/assets/images/board-1.png" alt="board">
                                                <h3 class="fw-semibold text-white mb-5 pb-md-4 d-flex gap-3"><span>....</span><span>....</span><span>....</span><span>1794</span></h3>
                                                <div class="d-flex align-content-center justify-content-between">
                                                    <span class="text-white">David Farrior</span>
                                                    <span class="text-white fs-12 fw-medium">EXP : 12/30</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-lg-5">
                            <div class="card border-0 rounded-3 bg-white mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-4">Expense Breakdown</h3>
                                    <div style="margin: -70px 0 0 0;">
                                        <div id="expense_breakdown" class="mx-auto" style="width: 376px; height: 345px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Card Add -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width: 738px;">
                            <div class="modal-content p-4 p-md-5">
                                <div class="modal-header p-0 border-0">
                                    <h3 class="mb-0">Add Card Detail</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0 pt-4">
                                    <form action="">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-4">
                                                    <label class="label text-secondary">Full Name</label>
                                                    <input type="text" class="form-control h-55" placeholder="Enter name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-4">
                                                    <label class="label text-secondary">Card Number</label>
                                                    <input type="text" class="form-control h-55" placeholder="Enter card number">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-4">
                                                    <label class="label text-secondary">Expiry Date</label>
                                                    <input type="date" class="form-control h-55">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-4">
                                                    <label class="label text-secondary">CVV</label>
                                                    <input type="number" class="form-control h-55" placeholder="212">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer border-0 p-0">
                                    <button type="button" class="btn btn-danger text-white px-3" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary hover-bg px-3">Add Card</button>
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