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
                        <h3 class="mb-0">Pricing</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Front Pages</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Pricing</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 position-relative">
                                    <div class="row align-items-center">
                                        <div class="col-lg-6">
                                            <span class="border py-2 px-3 rounded-3 d-inline-block mb-3">Standard</span>
                                            <h2 class="fs-36 fw-medium mb-2 mb-lg-3">$89.<sub class="fs-24 fw-normal bottom-0">99</sub></h2>
                                            <p class="fw-medium mb-2 mb-lg-4 pb-lg-1">For individual user</p>
                                            <a href="#" class="btn btn-primary fs-16 fw-medium pe-3 rounded-3">
                                                <i class="ri-arrow-right-s-line fs-20 position-relative top-1"></i>
                                                <span>Buy Now</span>
                                            </a>
                                        </div>
                                        <div class="col-lg-6">
                                            <ul class="ps-0 mb-0 mt-3 mt-lg-0 list-unstyled priceing-border">
                                                <li class="mb-2">
                                                    <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                                    <span class="ms-2">Advanced Dashboard</span>
                                                </li>
                                                <li class="mb-2">
                                                    <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                                    <span class="ms-2">Task Management</span>
                                                </li>
                                                <li class="mb-2">
                                                    <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                                    <span class="ms-2">File Storage (5GB)</span>
                                                </li>
                                                <li class="mb-2">
                                                    <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                                    <span class="ms-2">Email Integration</span>
                                                </li>
                                                <li class="mb-2">
                                                    <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                                    <span class="ms-2">Mobile App Access</span>
                                                </li>
                                                <li>
                                                    <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                                    <span class="ms-2">Custom Branding</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <span class="btn btn-danger p-2 d-inline-block text-white position-absolute popular-tag fs-12">Most Popular</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 position-relative">
                                    <div class="row align-items-center">
                                        <div class="col-lg-6">
                                            <span class="border py-2 px-3 rounded-3 d-inline-block mb-3">Premium</span>
                                            <h2 class="fs-36 fw-medium mb-2 mb-lg-3">$119.<sub class="fs-24 fw-normal bottom-0">99</sub></h2>
                                            <p class="fw-medium mb-2 mb-lg-4 pb-lg-1">For team of 10 users</p>
                                            <a href="#" class="btn btn-primary fs-16 fw-medium pe-3 rounded-3">
                                                <i class="ri-arrow-right-s-line fs-20 position-relative top-1"></i>
                                                <span>Buy Now</span>
                                            </a>
                                        </div>
                                        <div class="col-lg-6">
                                            <ul class="ps-0 mb-0 mt-3 mt-lg-0 list-unstyled priceing-border">
                                                <li class="mb-2">
                                                    <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                                    <span class="ms-2">Advanced Dashboard</span>
                                                </li>
                                                <li class="mb-2">
                                                    <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                                    <span class="ms-2">Task Management</span>
                                                </li>
                                                <li class="mb-2">
                                                    <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                                    <span class="ms-2">File Storage (Unlimited)</span>
                                                </li>
                                                <li class="mb-2">
                                                    <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                                    <span class="ms-2">Custom Reporting</span>
                                                </li>
                                                <li class="mb-2">
                                                    <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                                    <span class="ms-2">24/7 Premium Support</span>
                                                </li>
                                                <li>
                                                    <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                                    <span class="ms-2">White-label Solution</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 pt-4">
                        <h3 class="mb-0">Pricing Plan 2</h3>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 position-relative">
                                    <div class="text-center mb-4">
                                        <span class="border py-2 px-3 rounded-3 d-inline-block mb-3">Basic</span>
                                        <h2 class="fs-36 fw-medium mb-2 mb-lg-3">$29 <sub class="fs-16 fw-normal bottom-0 text-body">/ per month</sub></h2>
                                        <p class="fw-medium mb-2 mb-lg-4 pb-lg-1">For individual user</p>
                                        <a href="#" class="btn btn-primary fs-16 fw-medium pe-3 rounded-3 w-100">
                                            <i class="ri-arrow-right-s-line fs-20 position-relative top-1"></i>
                                            <span>Buy Now</span>
                                        </a>
                                    </div>
                                    
                                    <ul class="ps-0 mb-0 mt-3 mt-lg-0 list-unstyled">
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Basic Dashboard</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Task Management/span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">File Storage (5GB)</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Basic Reporting</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Email Integration</span>
                                        </li>
                                        <li>
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Basic Support</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 position-relative">
                                    <div class="text-center mb-4">
                                        <span class="border py-2 px-3 rounded-3 d-inline-block mb-3">Standard</span>
                                        <h2 class="fs-36 fw-medium mb-2 mb-lg-3">$49. <sub class="fs-16 fw-normal bottom-0 text-body">/ per month</sub></h2>
                                        <p class="fw-medium mb-2 mb-lg-4 pb-lg-1">For team of 10 users</p>
                                        <a href="#" class="btn btn-primary fs-16 fw-medium pe-3 rounded-3 w-100">
                                            <i class="ri-arrow-right-s-line fs-20 position-relative top-1"></i>
                                            <span>Buy Now</span>
                                        </a>
                                    </div>
                                    
                                    <ul class="ps-0 mb-0 mt-3 mt-lg-0 list-unstyled">
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Advanced Dashboard</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Task Management</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">File Storage (10GB)</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Advanced Reporting</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Email Integration</span>
                                        </li>
                                        <li>
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Priority Support</span>
                                        </li>
                                    </ul>

                                    <img src="assets/images/popular.svg" class="position-absolute populartsgs" alt="popular">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4 position-relative">
                                    <div class="text-center mb-4">
                                        <span class="border py-2 px-3 rounded-3 d-inline-block mb-3">Premium</span>
                                        <h2 class="fs-36 fw-medium mb-2 mb-lg-3">$79. <sub class="fs-16 fw-normal bottom-0 text-body">/ per month</sub></h2>
                                        <p class="fw-medium mb-2 mb-lg-4 pb-lg-1">For team of 15 users</p>
                                        <a href="#" class="btn btn-primary fs-16 fw-medium pe-3 rounded-3 w-100">
                                            <i class="ri-arrow-right-s-line fs-20 position-relative top-1"></i>
                                            <span>Buy Now</span>
                                        </a>
                                    </div>
                                    
                                    <ul class="ps-0 mb-0 mt-3 mt-lg-0 list-unstyled">
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Customizable Dashboard</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Task Management</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">File Storage (Unlimited)</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Custom Reporting</span>
                                        </li>
                                        <li class="mb-2">
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">Email Integration</span>
                                        </li>
                                        <li>
                                            <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                            <span class="ms-2">24/7 Premium Support</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 pt-4">
                        <h3 class="mb-0">Pricing Plan 3</h3>
                    </div>

                    <div class="card-group">
                        <div class="card bg-white border-0 mb-4">
                            <div class="card-body p-4 position-relative priceing-border style-two">
                                <div class="text-center mb-4">
                                    <span class="border py-2 px-3 rounded-3 d-inline-block mb-3">Basic</span>
                                    <h2 class="fs-36 fw-medium mb-2 mb-lg-3">$29 <sub class="fs-16 fw-normal bottom-0 text-body">/ per month</sub></h2>
                                    <p class="fw-medium mb-2 mb-lg-4 pb-lg-1">For individual user</p>
                                    <a href="#" class="btn btn-primary fs-16 fw-medium pe-3 rounded-3 w-100">
                                        <i class="ri-arrow-right-s-line fs-20 position-relative top-1"></i>
                                        <span>Buy Now</span>
                                    </a>
                                </div>
                                
                                <ul class="ps-0 mb-0 mt-3 mt-lg-0 list-unstyled">
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Basic Dashboard</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Task Management/span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">File Storage (5GB)</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Basic Reporting</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Email Integration</span>
                                    </li>
                                    <li>
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Basic Support</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    
                        <div class="card bg-white border-0 mb-4">
                            <div class="card-body p-4 position-relative priceing-border style-two">
                                <div class="text-center mb-4">
                                    <span class="border py-2 px-3 rounded-3 d-inline-block mb-3">Standard</span>
                                    <h2 class="fs-36 fw-medium mb-2 mb-lg-3">$49. <sub class="fs-16 fw-normal bottom-0 text-body">/ per month</sub></h2>
                                    <p class="fw-medium mb-2 mb-lg-4 pb-lg-1">For team of 10 users</p>
                                    <a href="#" class="btn btn-primary fs-16 fw-medium pe-3 rounded-3 w-100">
                                        <i class="ri-arrow-right-s-line fs-20 position-relative top-1"></i>
                                        <span>Buy Now</span>
                                    </a>
                                </div>
                                
                                <ul class="ps-0 mb-0 mt-3 mt-lg-0 list-unstyled">
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Advanced Dashboard</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Task Management</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">File Storage (10GB)</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Advanced Reporting</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Email Integration</span>
                                    </li>
                                    <li>
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Priority Support</span>
                                    </li>
                                </ul>

                                <img src="assets/images/popular.svg" class="position-absolute populartsgs" alt="popular">
                            </div>
                        </div>
                    
                        <div class="card bg-white border-0 mb-4">
                            <div class="card-body p-4 position-relative priceing-border style-two">
                                <div class="text-center mb-4">
                                    <span class="border py-2 px-3 rounded-3 d-inline-block mb-3">Premium</span>
                                    <h2 class="fs-36 fw-medium mb-2 mb-lg-3">$79. <sub class="fs-16 fw-normal bottom-0 text-body">/ per month</sub></h2>
                                    <p class="fw-medium mb-2 mb-lg-4 pb-lg-1">For team of 15 users</p>
                                    <a href="#" class="btn btn-primary fs-16 fw-medium pe-3 rounded-3 w-100">
                                        <i class="ri-arrow-right-s-line fs-20 position-relative top-1"></i>
                                        <span>Buy Now</span>
                                    </a>
                                </div>
                                
                                <ul class="ps-0 mb-0 mt-3 mt-lg-0 list-unstyled">
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Customizable Dashboard</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Task Management</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">File Storage (Unlimited)</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Custom Reporting</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">Email Integration</span>
                                    </li>
                                    <li>
                                        <i class="ri-check-line fs-20 text-success position-relative top-2"></i>
                                        <span class="ms-2">24/7 Premium Support</span>
                                    </li>
                                </ul>
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
