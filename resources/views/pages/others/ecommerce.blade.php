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
					<div class="row justify-content-center">
						<div class="col-lg-8">
							<div
								class="card bg-primary border-0 rounded-3 welcome-box mb-4"
							>
								<div class="card-body p-4">
									<div class="row align-items-center">
										<div class="col-lg-8 col-md-8 col-sm-8">
											<div class="border-bottom">
												<h3
													class="text-white fw-semibold mb-1"
												>
													Good Morning,
													<span
														class="text-danger-div"
														>Olivia!</span
													>
												</h3>
												<p class="text-light">
													Here's what's happening with
													your store today.
												</p>
											</div>

											<div
												class="d-flex align-items-center flex-wrap gap-4 gap-xxl-5"
											>
												<div
													class="d-flex align-items-center welcome-status-item"
												>
													<div class="flex-shrink-0">
														<i
															class="material-symbols-outlined"
															>shopping_bag</i
														>
													</div>
													<div
														class="flex-grow-1 ms-3"
													>
														<h5
															class="text-white fw-semibold mb-0"
														>
															86 New orders
														</h5>
														<p class="text-light">
															Awaiting processing
														</p>
													</div>
												</div>

												<div
													class="d-flex align-items-center welcome-status-item"
												>
													<div class="flex-shrink-0">
														<i
															class="material-symbols-outlined icon-bg"
															>chat_error</i
														>
													</div>
													<div
														class="flex-grow-1 ms-3"
													>
														<h5
															class="text-white fw-semibold mb-0"
														>
															35 Products
														</h5>
														<p class="text-light">
															Out of stock
														</p>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4">
											<div
												class="welcome-img text-center text-sm-end mt-4 mt-sm-0"
											>
												<img
													src="assets/images/welcome.png"
													alt="welcome"
												/>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card bg-white border-0 rounded-3 mb-4">
								<div class="card-body p-4">
									<div
										class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30"
									>
										<h3 class="mb-0">Total Sales</h3>
										<select
											class="form-select month-select form-control"
											aria-label="Default select example"
										>
											<option selected>Monthly</option>
											<option value="1">Weekly</option>
											<option value="2">Today</option>
											<option value="3">Yearly</option>
										</select>
									</div>

									<div
										style="
											margin-bottom: -15px;
											margin-left: -10px;
											margin-top: -5px;
										"
									>
										<div id="top_sales"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row justify-content-center">
								<div class="col-md-4 col-lg-12">
									<div
										class="card bg-white border-0 rounded-3 mb-4 stats-box"
									>
										<div class="card-body p-4">
											<div
												class="d-flex justify-content-between flex-wrap gap-2"
											>
												<div>
													<div class="d-flex">
														<span
															>Total Orders</span
														>
														<span class="count"
															>-7.6%</span
														>
													</div>
													<h3 class="fs-20 mt-1 mb-0">
														$72,458
													</h3>
												</div>
												<span class="fs-12"
													>Last 7 days</span
												>
											</div>
											<div
												style="
													max-width: 153px;
													margin: auto;
													margin-top: -24px;
													margin-bottom: -14px;
												"
											>
												<div id="total_orders1"></div>
											</div>
											<ul
												class="ps-0 mb-0 list-unstyled stats-list"
											>
												<li
													class="d-flex justify-content-between align-items-center"
												>
													<span class="title"
														>Completed</span
													>
													<span>62%</span>
												</li>
												<li
													class="d-flex justify-content-between align-items-center"
												>
													<span class="title"
														>Pending payment</span
													>
													<span>38%</span>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-lg-12">
									<div
										class="card bg-white border-0 rounded-3 mb-4 stats-box"
									>
										<div class="card-body p-4">
											<div
												class="d-flex justify-content-between flex-wrap gap-2"
											>
												<div>
													<div class="d-flex">
														<span
															>Total
															Customers</span
														>
														<span class="count up"
															>+5.4</span
														>
													</div>
													<h3 class="fs-20 mt-1 mb-0">
														1,528
													</h3>
												</div>
												<span class="fs-12"
													>Last 7 days</span
												>
											</div>
											<div
												style="
													max-width: 290px;
													margin: auto;
													margin-top: -32px;
													margin-bottom: -19px;
												"
											>
												<div id="total_customers"></div>
											</div>
											<div
												class="d-flex justify-content-between flex-wrap gap-2"
											>
												<span class="fs-12"
													>1 June</span
												>
												<span class="fs-12"
													>7 June</span
												>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-lg-12">
									<div
										class="card bg-white border-0 rounded-3 mb-4 stats-box"
									>
										<div class="card-body p-4">
											<div
												class="d-flex justify-content-between flex-wrap gap-2"
											>
												<div>
													<div class="d-flex">
														<span
															>Total Revenue</span
														>
														<span class="count up"
															>+10%</span
														>
													</div>
													<h3 class="fs-20 mt-1 mb-0">
														$165,458
													</h3>
												</div>
												<span class="fs-12"
													>Last 30 days</span
												>
											</div>
											<div
												style="
													max-width: 196px;
													margin: auto;
													margin-top: -22px;
													margin-bottom: -13px;
												"
											>
												<div id="total_evenue"></div>
											</div>
											<ul
												class="ps-0 mb-0 list-unstyled stats-list"
											>
												<li
													class="d-flex justify-content-between align-items-center"
												>
													<span class="title"
														>Fashion</span
													>
													<span>75%</span>
												</li>
												<li
													class="d-flex justify-content-between align-items-center"
												>
													<span class="title"
														>Others</span
													>
													<span>25%</span>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Sales by Locations</h3>

                                        <div class="dropdown select-dropdown">
                                            <button class="bg-transparent border text-body rounded-2 p-0 border-0 dot" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill"></i>
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
                                    <div class="text-center" style="margin: 30px 0;">
                                        <div id="sales_by_locations_map"></div>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled sales_by_locations mt-4">
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/usa.svg" class="wh-30 rounded-circle" alt="usa">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">United States</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: 85%">
                                                        <span class="count fw-medium text-body">85%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/germany.svg" class="wh-30 rounded-circle" alt="germany">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">Germany</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: 75%">
                                                        <span class="count fw-medium text-body">75%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/united-kingdom.svg" class="wh-30 rounded-circle" alt="united-kingdom">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">United Kingdom</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: 40%">
                                                        <span class="count fw-medium text-body">40%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/canada.svg" class="wh-30 rounded-circle" alt="canada">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">Canada</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: 10%">
                                                        <span class="count fw-medium text-body">10%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/portugal.svg" class="wh-30 rounded-circle" alt="portugal">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">Portugal</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="05" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: 05%">
                                                        <span class="count fw-medium text-body">05%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/spain.svg" class="wh-30 rounded-circle" alt="spain">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="fw-medium d-block mb-2">Spain</span>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: 15%">
                                                        <span class="count fw-medium text-body">15%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4">
                                        <h3 class="mb-0">Top Selling Products</h3>
                                        <div class="dropdown select-dropdown">
                                            <button class="dropdown-toggle bg-transparent border text-body rounded-2" style="padding-right: 39px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Today
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

                                    <div class="default-table-area top-selling-products">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Order</th>
                                                        <th scope="col">Stock</th>
                                                        <th scope="col">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <a href="product-details.html" class="d-flex align-items-center">
                                                                <img src="assets/images/product-1.jpg" class="wh-40 rounded-3" alt="product-1">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Smart Band</h6>
                                                                    <span class="fs-12 text-body">20 Mar 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>$35.00</td>
                                                        <td>75</td>
                                                        <td>750</td>
                                                        <td>$2,625</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="product-details.html" class="d-flex align-items-center">
                                                                <img src="assets/images/product-2.jpg" class="wh-40 rounded-3" alt="product-2">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Headphone</h6>
                                                                    <span class="fs-12 text-body">12 Jan 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>$49.00</td>
                                                        <td>25</td>
                                                        <td>825</td>
                                                        <td>$1,225</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="product-details.html" class="d-flex align-items-center">
                                                                <img src="assets/images/product-3.jpg" class="wh-40 rounded-3" alt="product-3">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">iPhone 15 Plus</h6>
                                                                    <span class="fs-12 text-body">08 Jan 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>$99.00</td>
                                                        <td>55</td>
                                                        <td class="text-danger">Stock Out</td>
                                                        <td>$5,445</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="product-details.html" class="d-flex align-items-center">
                                                                <img src="assets/images/product-4.jpg" class="wh-40 rounded-3" alt="product-4">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Bluetooth Speaker</h6>
                                                                    <span class="fs-12 text-body">04 Jan 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>$59.00</td>
                                                        <td>40</td>
                                                        <td>535</td>
                                                        <td>$2,360</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="product-details.html" class="d-flex align-items-center">
                                                                <img src="assets/images/product-5.jpg" class="wh-40 rounded-3" alt="product-5">
                                                                <div class="ms-2 ps-1">
                                                                    <h6 class="fw-medium fs-14">Airbuds 2nd Gen</h6>
                                                                    <span class="fs-12 text-body">01 Jan 2024</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>$79.00</td>
                                                        <td>56</td>
                                                        <td>460</td>
                                                        <td>$4,424</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
            
                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                            <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="index.html" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="index.html">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="index.html">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="index.html">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="index.html">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="index.html" aria-label="Next">
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

					<div class="row justify-content-center">
						<div class="col-xl-7 col-xxl-8 col-lg-7">
							<div class="card bg-white border-0 rounded-3 mb-4">
								<div class="card-body p-4">
									<div
										class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4"
									>
										<h3 class="mb-0">Recent Orders</h3>
										<div class="d-flex">
											<form
												class="position-relative table-src-form"
											>
												<input
													type="text"
													class="form-control"
													placeholder="Search here"
												/>
												<i
													class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y"
													>search</i
												>
											</form>
											<select
												class="form-select month-select form-control"
												aria-label="Default select example"
											>
												<option selected>
													Show All
												</option>
												<option value="1">
													Weekly
												</option>
												<option value="2">
													Monthly
												</option>
												<option value="3">
													Yearly
												</option>
											</select>
										</div>
									</div>

									<div
										class="default-table-area recent-orders"
									>
										<div class="table-responsive">
											<table class="table align-middle">
												<thead>
													<tr>
														<th scope="col">
															Order ID
														</th>
														<th scope="col">
															Customer
														</th>
														<th scope="col">
															Created
														</th>
														<th scope="col">
															Total
														</th>
														<th scope="col">
															Status
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>#JAN-2345</td>
														<td>
															<a
																href="my-profile"
																class="d-flex align-items-center"
															>
																<img
																	src="assets/images/user-1.jpg"
																	class="wh-40 rounded-3"
																	alt="user"
																/>
																<div
																	class="ms-2 ps-1"
																>
																	<h6
																		class="fw-medium fs-14"
																	>
																		Sarah
																		Johnson
																	</h6>
																</div>
															</a>
														</td>
														<td>12 Jan, 2024</td>
														<td>$10,490</td>
														<td>
															<span
																class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal"
																>Shipped</span
															>
														</td>
													</tr>
													<tr>
														<td>#JAN-1323</td>
														<td>
															<a
																href="my-profile"
																class="d-flex align-items-center"
															>
																<img
																	src="assets/images/user-2.jpg"
																	class="wh-40 rounded-3"
																	alt="user"
																/>
																<div
																	class="ms-2 ps-1"
																>
																	<h6
																		class="fw-medium fs-14"
																	>
																		Michael
																		Smith
																	</h6>
																</div>
															</a>
														</td>
														<td>08 Jan, 2024</td>
														<td>$6,575</td>
														<td>
															<span
																class="badge bg-info bg-opacity-10 text-info p-2 fs-12 fw-normal"
																>Confirmed</span
															>
														</td>
													</tr>
													<tr>
														<td>#DEC-1234</td>
														<td>
															<a
																href="my-profile"
																class="d-flex align-items-center"
															>
																<img
																	src="assets/images/user-3.jpg"
																	class="wh-40 rounded-3"
																	alt="user"
																/>
																<div
																	class="ms-2 ps-1"
																>
																	<h6
																		class="fw-medium fs-14"
																	>
																		Emily
																		Brown
																	</h6>
																</div>
															</a>
														</td>
														<td>13 Dec, 2023</td>
														<td>$12,870</td>
														<td>
															<span
																class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal"
																>Pending</span
															>
														</td>
													</tr>
													<tr>
														<td>#DEC-3567</td>
														<td>
															<a
																href="my-profile"
																class="d-flex align-items-center"
															>
																<img
																	src="assets/images/user-4.jpg"
																	class="wh-40 rounded-3"
																	alt="user"
																/>
																<div
																	class="ms-2 ps-1"
																>
																	<h6
																		class="fw-medium fs-14"
																	>
																		Jason
																		Lee
																	</h6>
																</div>
															</a>
														</td>
														<td>05 Dec, 2023</td>
														<td>$7,895</td>
														<td>
															<span
																class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal"
																>Shipped</span
															>
														</td>
													</tr>
													<tr>
														<td>#DEC-1098</td>
														<td>
															<a
																href="my-profile"
																class="d-flex align-items-center"
															>
																<img
																	src="assets/images/user-5.jpg"
																	class="wh-40 rounded-3"
																	alt="user"
																/>
																<div
																	class="ms-2 ps-1"
																>
																	<h6
																		class="fw-medium fs-14"
																	>
																		Ashley
																		Davis
																	</h6>
																</div>
															</a>
														</td>
														<td>01 Dec, 2023</td>
														<td>$4,680</td>
														<td>
															<span
																class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal"
																>Rejected</span
															>
														</td>
													</tr>
												</tbody>
											</table>
										</div>

										<div
											class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap"
										>
											<span class="fs-12 fw-medium"
												>Showing 5 of 30 Results</span
											>

											<nav
												aria-label="Page navigation example"
											>
												<ul
													class="pagination mb-0 justify-content-center"
												>
													<li class="page-item">
														<a
															class="page-link icon"
															href="index"
															aria-label="Previous"
														>
															<i
																class="material-symbols-outlined"
																>keyboard_arrow_left</i
															>
														</a>
													</li>
													<li class="page-item">
														<a
															class="page-link active"
															href="index"
															>1</a
														>
													</li>
													<li class="page-item">
														<a
															class="page-link"
															href="index"
															>2</a
														>
													</li>
													<li class="page-item">
														<a
															class="page-link"
															href="index"
															>3</a
														>
													</li>
													<li class="page-item">
														<a
															class="page-link"
															href="index"
															>4</a
														>
													</li>
													<li class="page-item">
														<a
															class="page-link icon"
															href="index"
															aria-label="Next"
														>
															<i
																class="material-symbols-outlined"
																>keyboard_arrow_right</i
															>
														</a>
													</li>
												</ul>
											</nav>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-5 col-xxl-4 col-lg-5">
							<div class="card bg-white border-0 rounded-3 mb-4">
								<div class="card-body p-4">
									<div
										class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4"
									>
										<h3 class="mb-0">Order Summary</h3>
										<select
											class="form-select month-select form-control"
											aria-label="Default select example"
										>
											<option selected>Today</option>
											<option value="1">Weekly</option>
											<option value="2">Monthly</option>
											<option value="3">Yearly</option>
										</select>
									</div>

									<div class="pt-4" id="order_summery"></div>

									<ul
										class="ps-0 mb-0 list-unstyled sales_by_locations style-two"
									>
										<li>
											<span class="fw-medium d-block mb-2"
												>Completed Order</span
											>
											<div
												class="progress"
												role="progressbar"
												aria-label="Success example"
												aria-valuenow="60"
												aria-valuemin="0"
												aria-valuemax="100"
											>
												<div
													class="progress-bar bg-success"
													style="width: 60%"
												>
													<span
														class="count fw-medium text-body"
														>60%</span
													>
												</div>
											</div>
										</li>
										<li>
											<span class="fw-medium d-block mb-2"
												>New Order</span
											>
											<div
												class="progress"
												role="progressbar"
												aria-label="Primary example"
												aria-valuenow="30"
												aria-valuemin="0"
												aria-valuemax="100"
											>
												<div
													class="progress-bar bg-primary"
													style="width: 30%"
												>
													<span
														class="count fw-medium text-body"
														>30%</span
													>
												</div>
											</div>
										</li>
										<li>
											<span class="fw-medium d-block mb-2"
												>Pending Order</span
											>
											<div
												class="progress"
												role="progressbar"
												aria-label="Example with label"
												aria-valuenow="10"
												aria-valuemin="0"
												aria-valuemax="100"
											>
												<div
													class="progress-bar bg-primary-div"
													style="width: 10%"
												>
													<span
														class="count fw-medium text-body"
														>10%</span
													>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<div class="row justify-content-center">
						<div class="col-xl-5 col-xxl-4 col-lg-5">
							<div class="card bg-white border-0 rounded-3 mb-4">
								<div class="card-body p-4">
									<div
										class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4"
									>
										<h3 class="mb-0">
											Recent Transactions
										</h3>

										<div class="dropdown action-opt">
											<button
												class="btn bg-transparent p-0"
												type="button"
												data-bs-toggle="dropdown"
												aria-expanded="false"
											>
												<i
													data-feather="more-horizontal"
												></i>
											</button>
											<ul
												class="dropdown-menu dropdown-menu-end bg-white border box-shadow"
											>
												<li>
													<a
														class="dropdown-item"
														href="javascript:;"
													>
														<i
															data-feather="clock"
														></i>
														Today
													</a>
												</li>
												<li>
													<a
														class="dropdown-item"
														href="javascript:;"
													>
														<i
															data-feather="pie-chart"
														></i>
														Last 7 Days
													</a>
												</li>
												<li>
													<a
														class="dropdown-item"
														href="javascript:;"
													>
														<i
															data-feather="rotate-cw"
														></i>
														Last Month
													</a>
												</li>
												<li>
													<a
														class="dropdown-item"
														href="javascript:;"
													>
														<i
															data-feather="calendar"
														></i>
														Last 1 Year
													</a>
												</li>
												<li>
													<a
														class="dropdown-item"
														href="javascript:;"
													>
														<i
															data-feather="bar-chart"
														></i>
														All Time
													</a>
												</li>
												<li>
													<a
														class="dropdown-item"
														href="javascript:;"
													>
														<i
															data-feather="eye"
														></i>
														View
													</a>
												</li>
												<li>
													<a
														class="dropdown-item"
														href="javascript:;"
													>
														<i
															data-feather="trash"
														></i>
														Delete
													</a>
												</li>
											</ul>
										</div>
									</div>

									<ul class="ps-0 mb-0 list-unstyled">
										<li
											class="d-flex align-items-center justify-content-between mb-3 pb-3"
										>
											<div
												class="d-flex align-items-center"
											>
												<div class="flex-shrink-0">
													<i
														class="material-symbols-outlined icon-circle bg-primary bg-opacity-10 text-primary text-center rounded-circle wh-40 lh-40"
														>credit_card</i
													>
												</div>
												<div class="flex-grow-1 ms-2">
													<h6
														class="fw-medium fs16 mb-0"
													>
														Master Card
													</h6>
													<span class="fs-12"
														>23 Dec 2023 - 3:20
														pm</span
													>
												</div>
											</div>
											<span
												class="fs-14 fw-medium text-success"
												>+1,520</span
											>
										</li>
										<li
											class="d-flex align-items-center justify-content-between mb-3 pb-3"
										>
											<div
												class="d-flex align-items-center"
											>
												<div class="flex-shrink-0">
													<i
														class="material-symbols-outlined icon-circle bg-danger bg-opacity-10 text-danger text-center rounded-circle wh-40 lh-40"
														>redeem</i
													>
												</div>
												<div class="flex-grow-1 ms-2">
													<h6
														class="fw-medium fs16 mb-0"
													>
														Paypal
													</h6>
													<span class="fs-12"
														>23 Dec 2023 - 3:20
														pm</span
													>
												</div>
											</div>
											<span
												class="fs-14 fw-medium text-danger"
												>-2,250</span
											>
										</li>
										<li
											class="d-flex align-items-center justify-content-between mb-3 pb-3"
										>
											<div
												class="d-flex align-items-center"
											>
												<div class="flex-shrink-0">
													<i
														class="material-symbols-outlined icon-circle bg-primary-div bg-opacity-10 text-primary-div text-center rounded-circle wh-40 lh-40"
														>account_balance</i
													>
												</div>
												<div class="flex-grow-1 ms-2">
													<h6
														class="fw-medium fs16 mb-0"
													>
														Wise
													</h6>
													<span class="fs-12"
														>23 Dec 2023 - 3:20
														pm</span
													>
												</div>
											</div>
											<span
												class="fs-14 fw-medium text-success"
												>+3,560</span
											>
										</li>
										<li
											class="d-flex align-items-center justify-content-between mb-3 pb-3"
										>
											<div
												class="d-flex align-items-center"
											>
												<div class="flex-shrink-0">
													<i
														class="material-symbols-outlined icon-circle bg-info bg-opacity-10 text-info text-center rounded-circle wh-40 lh-40"
														>currency_ruble</i
													>
												</div>
												<div class="flex-grow-1 ms-2">
													<h6
														class="fw-medium fs16 mb-0"
													>
														Payoneer
													</h6>
													<span class="fs-12"
														>23 Dec 2023 - 3:20
														pm</span
													>
												</div>
											</div>
											<span
												class="fs-14 fw-medium text-success"
												>+6,500</span
											>
										</li>
										<li
											class="d-flex align-items-center justify-content-between"
										>
											<div
												class="d-flex align-items-center"
											>
												<div class="flex-shrink-0">
													<i
														class="material-symbols-outlined icon-circle bg-primary bg-opacity-10 text-primary text-center rounded-circle wh-40 lh-40"
														>credit_score</i
													>
												</div>
												<div class="flex-grow-1 ms-2">
													<h6
														class="fw-medium fs16 mb-0"
													>
														Credit Card
													</h6>
													<span class="fs-12"
														>23 Dec 2023 - 3:20
														pm</span
													>
												</div>
											</div>
											<span
												class="fs-14 fw-medium text-danger"
												>+4,320</span
											>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<div class="col-xl-7 col-xxl-8 col-lg-7">
							<div class="card bg-white border-0 rounded-3 mb-4">
								<div class="card-body p-4">
									<div
										class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-4"
									>
										<h3 class="mb-0">
											Returning Customer Rate
										</h3>
										<select
											class="form-select month-select form-control"
											aria-label="Default select example"
										>
											<option selected>Month</option>
											<option value="1">Weekly</option>
											<option value="2">Monthly</option>
											<option value="3">Yearly</option>
										</select>
									</div>

									<div id="returning_customer_rate"></div>
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
