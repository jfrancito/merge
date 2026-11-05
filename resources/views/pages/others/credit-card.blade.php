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
                    <div class="row g-4 mb-4">
                        <div class="col-lg-8">
                            <div class="card border-0 rounded-3 bg-white p-25 bg-img debit-card-bg-for-dark-mode" style="background-image: url(/assets/images/debit-card-bg.jpg);">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                    <h3 class="mb-0">My Cards</h3>

                                    <button class="btn btn-outline-primary d-flex align-items-center gap-1 hover-bg" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="material-symbols-outlined fs-22">add</i>
                                        <span>Add Card</span>
                                    </button>
                                </div>

                                <div class="row g-4">
                                    <div class="col-sm-6">
                                        <div class="bg-img p-4 rounded-3" style="background-image: url(/assets/images/debit-card-2.jpg);">
                                            <div class="d-flex align-content-center justify-content-between">
                                                <div>
                                                    <span class="text-white fs-12 fw-medium d-block mb-12">Credit Card</span>
                                                    <img src="/assets/images/board-1.png" alt="board">
                                                </div>
                                                <i class="ri-visa-fill fs-35 text-white lh-1"></i>
                                            </div>
                                            
                                            <h3 class="fw-semibold text-white mb-12 d-flex gap-1 lh-1" style="margin-top: 40px;">
                                                <span>****</span><span>****</span><span>****</span><span>1784</span>
                                            </h3>
                                            <div class="d-flex align-content-center justify-content-between">
                                                <span class="text-white">Russell McCray</span>
                                                <span class="text-white fs-12">EXP : 12/30</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="bg-img p-4 rounded-3" style="background-image: url(/assets/images/debit-card-3.jpg);">
                                            <div class="d-flex align-content-center justify-content-between">
                                                <div>
                                                    <span class="text-white fs-12 fw-medium d-block mb-12">Credit Card</span>
                                                    <img src="/assets/images/board-1.png" alt="board">
                                                </div>
                                                <i class="ri-mastercard-fill fs-35 text-white lh-1"></i>
                                            </div>
                                            
                                            <h3 class="fw-semibold text-white mb-12 d-flex gap-1 lh-1" style="margin-top: 40px;">
                                                <span>****</span><span>****</span><span>****</span><span>1794</span>
                                            </h3>
                                            <div class="d-flex align-content-center justify-content-between">
                                                <span class="text-white">Russell McCray</span>
                                                <span class="text-white fs-12">EXP : 12/30</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Card Add -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" style="max-width: 738px;">
                                        <div class="modal-content p-4 p-md-5">
                                            <div class="modal-header p-0 border-0">
                                                <h3 class="mb-0">Add Card Detail</h3>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0 pt-4">
                                                <form>
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
                        </div>
                        <div class="col-lg-4">
                            <div class="row g-4">
                                <div class="col-lg-12 col-sm-6">
                                    <div class="card border-0 rounded-3 p-25 wallet-for-dark-mode" style="background: linear-gradient(90deg, #daebff, #fff);">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="flex-grow-1">
                                                <span class="d-block">Total Balance</span>
                                                <h3 class="fs-20 mt-6" style="margin-top: 5px; margin-bottom: 22px;">$20,507</h3>
                                                <div class="d-flex align-items-center" style="gap: 10px;">
                                                    <span class="d-inline-block bg-success-80 border-success-60 border px-2 rounded-pill text-success-60 fs-12 fw-medium">+28.5%</span>
                                                    <span class="fs-12">Last Month</span>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="material-symbols-outlined d-flex align-items-center justify-content-center fs-35 text-card-bg-c rounded-circle" style="width: 75px; height: 75px; background-color: #daebff;"> account_balance_wallet</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-6">
                                    <div class="card border-0 rounded-3 p-25 wallet-for-dark-mode" style="background: linear-gradient(90deg, #f3e8ff, #fff);">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="flex-grow-1">
                                                <span class="d-block">Total Expense</span>
                                                <h3 class="fs-20 mt-6" style="margin-top: 5px; margin-bottom: 22px;">$18,950</h3>
                                                <div class="d-flex align-items-center" style="gap: 10px;">
                                                    <span class="d-inline-block bg-danger-70 border-danger-80 border px-2 rounded-pill text-danger-80 fs-12 fw-medium">-18.1%</span>
                                                    <span class="fs-12">Last Month</span>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <i class="material-symbols-outlined d-flex align-items-center justify-content-center fs-35 text-primary-div rounded-circle" style="width: 75px; height: 75px; background-color: #f3e8ff;"> payments</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-lg-4">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <h3 class="mb-4">Cards With Amount</h3>
        
                                <div style="margin: -25px 0 -20px -10px;">
                                    <div id="cards_with_amount_chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card border-0 rounded-3 bg-white" style="padding: 10px;">
                                <div class="bg-success-90 p-25 rounded-3 mb-10 daily-limit-form-dark-mode">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <span class="d-block">Daily Limit</span>
                                            <h3 class="mb-0 fs-20 mt-6">$5,000<sub class="fs-14 fw-normal bottom-0 text-body">/$2250</sub></h3>
                                        </div>
                                        <span class="d-inline-block bg-danger-70 border-danger-80 border px-2 rounded-pill text-danger-80 fs-12 fw-medium">-45.9%</span>
                                    </div>

                                    <div class="progress-responsive mt-14">
                                        <div class="progress rounded-pill" style="height: 10px; background-color: #B2FF97;" role="progressbar" aria-label="Example with label" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar rounded-pill" style="width: 85%; height: 10px; background-color: #37d80a;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-success rounded-3 mb-0 position-relative z-1" style="padding: 18px 25px;">
                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                        <div class="flex-shrink-0">
                                            <img src="/assets/images/avatar-with-laptop.png" alt="avatar-with-laptop">
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="d-block text-white">Get a Platinum Card</span>
                                            <span class="text-white mt-6 d-block">For <span class="fw-bold fs-20">Free</span></span>
                                        </div>
                                    </div>

                                    <img src="/assets/images/4dots.png" class="position-absolute bottom-0 end-0" alt="4dots">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <h3 class="mb-4">Quick Transfer</h3>
        
                                <form class="quick-transfer">
                                    <div class="form-group mb-20">
                                        <label class="fs-12 mb-8">Card Number</label>
                                        <input type="text" class="form-control" value="**** **** **** 1580">
                                    </div>
                                    <div class="form-group">
                                        <label class="fs-12 mb-8">Transfer Amount</label>
                                        <div class="position-relative z-1">
                                            <input type="text" class="form-control" value="$1,580">
                                            <button class="btn btn-primary d-flex justify-content-center align-items-center position-absolute top-50 end-0 translate-middle-y" style="width: 51px; height: 51px;">
                                                <i class="material-symbols-outlined">send_money</i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-xxl-9">
                            <div class="card bg-white border-0 rounded-3">
                                <div class="card-body p-0">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 p-4">
                                        <h3 class="mb-0">Recent Transactions</h3>
                                        <div class="dropdown select-dropdown">
                                            <button class="dropdown-toggle border text-body rounded-2 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                                Last 30 Days
                                            </button>
                                            
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Last 7 Days</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Last 15 Days</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Last 30 Days</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
        
                                    <div class="default-table-area style-two recent-transactions py-19">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-secondary">Date</th>
                                                        <th scope="col" class="text-secondary">Description</th>
                                                        <th scope="col" class="text-secondary">Category</th>
                                                        <th scope="col" class="text-secondary">Amount ($)</th>
                                                        <th scope="col" class="text-secondary">Status</th>
                                                        <th scope="col" class="text-secondary">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-body">30 Apr 2025</td> 
                                                        <td class="text-body">Starbucks Coffee</td> 
                                                        <td class="text-body">Dining</td> 
                                                        <td class="text-body">$500,000</td>
                                                        <td>
                                                            <span class="d-inline-block bg-success-60 bg-opacity-10 border-success-60 border rounded-pill text-success-60 fs-12 fw-medium" style="padding: 1px 10px;">Completed</span>
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
                                                        <td class="text-body">29 Apr 2025</td> 
                                                        <td class="text-body">Whole Foods</td> 
                                                        <td class="text-body">Groceries</td> 
                                                        <td class="text-body">$90.50</td>
                                                        <td>
                                                            <span class="d-inline-block bg-card-bg-c bg-opacity-10 border-card-bg-c border rounded-pill text-card-bg-c fs-12 fw-medium" style="padding: 1px 10px;">Pending</span>
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
                                                        <td class="text-body">28 Apr 2025</td> 
                                                        <td class="text-body">Gas Station</td> 
                                                        <td class="text-body">Transportation</td> 
                                                        <td class="text-body">$15.00</td>
                                                        <td>
                                                            <span class="d-inline-block bg-danger-50 bg-opacity-10 border-danger-50 border rounded-pill text-danger-50 fs-12 fw-medium" style="padding: 1px 10px;">Cancelled</span>
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
                                                        <td class="text-body">27 Apr 2025</td> 
                                                        <td class="text-body">Electric Bill</td> 
                                                        <td class="text-body">Utilities</td> 
                                                        <td class="text-body">$150.00</td>
                                                        <td>
                                                            <span class="d-inline-block bg-success-60 bg-opacity-10 border-success-60 border rounded-pill text-success-60 fs-12 fw-medium" style="padding: 1px 10px;">Completed</span>
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
                                                        <td class="text-body">26 Apr 2025</td> 
                                                        <td class="text-body">Spotify Subscription</td> 
                                                        <td class="text-body">Entertainment</td> 
                                                        <td class="text-body">$10.00</td>
                                                        <td>
                                                            <span class="d-inline-block bg-danger-80 bg-opacity-10 border-danger-80 border rounded-pill text-danger-80 fs-12 fw-medium" style="padding: 1px 10px;">Rejected</span>
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
                                                        <td class="text-body">25 Apr 2025</td> 
                                                        <td class="text-body">Football Ticket</td> 
                                                        <td class="text-body">Sports</td> 
                                                        <td class="text-body">$99.99</td>
                                                        <td>
                                                            <span class="d-inline-block bg-success-60 bg-opacity-10 border-success-60 border rounded-pill text-success-60 fs-12 fw-medium" style="padding: 1px 10px;">Completed</span>
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
            
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap p-4 pt-3">
                                            <span class="fs-13">Showing 6 of 36 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                        <ul class="pagination mb-0 justify-content-center">
                                            <li class="page-item">
                                                <button class="page-link icon hover-bg" aria-label="Previous">
                                                    <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                </button>
                                            </li>
                                            <li class="page-item">
                                                <button class="page-link active">1</button>
                                            </li>
                                            <li class="page-item">
                                                <button class="page-link">2</button>
                                            </li>
                                            <li class="page-item">
                                                <button class="page-link">3</button>
                                            </li>
                                            <li class="page-item">
                                                <button class="page-link">4</button>
                                            </li>
                                            <li class="page-item">
                                                <button class="page-link icon hover-bg" aria-label="Next">
                                                    <i class="material-symbols-outlined">keyboard_arrow_right</i>
                                                </button>
                                            </li>
                                        </ul>
                                    </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3">
                            <div class="row g-4">
                                <div class="col-xxl-12 col-sm-6">
                                    <div class="card border-0 rounded-3 bg-white p-25">
                                        <h3 class="mb-4">Credit Utilization Ratio</h3>
                
                                        <div style="margin: -20px 0 -22px 0;">
                                            <div id="credit_utilization_ratio_chart"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-sm-6">
                                    <div class="card border-0 rounded-3 bg-white p-25">
                                        <h3 class="mb-4">Monthly Spending</h3>
                
                                        <div style="margin: -20px 0 -22px 0;">
                                            <div id="monthly_spending_chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-xxl-4 col-md-12 col-lg-6">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                    <h3 class="mb-0">Spending Breakdown</h3>
                                    
                                    <div class="dropdown select-dropdown">
                                        <button class="bg-transparent border text-body rounded-2 p-0 border-0 dot" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill" style="font-size: 22px;"></i>
                                        </button>
                                        
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3" style="width: 195px;">
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Day</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Week</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Month</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Year</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
        
                                <div style="margin: -4px 0 -4px 0;">
                                    <div id="spending_breakdown_chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                    <h3 class="mb-0">Interest Charge & Fees</h3>
                                    
                                    <div class="dropdown select-dropdown">
                                        <button class="bg-transparent border text-body rounded-2 p-0 border-0 dot" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill" style="font-size: 22px;"></i>
                                        </button>
                                        
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3" style="width: 195px;">
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Day</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Week</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Month</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Year</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
        
                                <div style="margin: -19px 0 -17px 0;">
                                    <div id="interest_charge_fees_chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6 col-lg-12">
                            <div class="card border-0 rounded-3 bg-white p-25">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                    <h3 class="mb-0">Statistics</h3>
                                    
                                    <div class="dropdown select-dropdown">
                                        <button class="bg-transparent border text-body rounded-2 p-0 border-0 dot" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill" style="font-size: 22px;"></i>
                                        </button>
                                        
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3" style="width: 195px;">
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Day</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Week</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Month</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">This Year</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
        
                                <div style="margin: -18px 0 -16px 0;">
                                    <div id="statistics_chart"></div>
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
