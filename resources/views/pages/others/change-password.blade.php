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
                        <h3 class="mb-0">Change Password</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Settings</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Change Password</span>
                                </li>
                            </ol>
                        </nav>
                    </div>
                   
                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <ul class="ps-0 mb-4 list-unstyled d-flex flex-wrap gap-2 gap-lg-3">
                                <li>
                                    <a href="/account-settings" class="btn btn-primary border border-primary bg-transparent text-primary py-2 px-3 fw-semibold">Account Settings</a>
                                </li>
                                <li>
                                    <a href="/change-password" class="btn btn-primary border border-primary bg-primary text-white py-2 px-3 fw-semibold">Change Password</a>
                                </li>
                                <li>
                                    <a href="/connections" class="btn btn-primary border border-primary bg-transparent text-primary py-2 px-3 fw-semibold">Connections</a>
                                </li>
                                <li>
                                    <a href="/privacy-policy" class="btn btn-primary border border-primary bg-transparent text-primary py-2 px-3 fw-semibold">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="/terms-conditions" class="btn btn-primary border border-primary bg-transparent text-primary py-2 px-3 fw-semibold">Terms & Conditions</a>
                                </li>
                            </ul>
                            
                            <form>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Old Password</label>
                                            <div class="form-group">
                                                <div class="password-wrapper position-relative">
                                                    <input type="password" id="password" class="form-control h-55 text-dark" value="@password#">
                                                    <i style="color: #A9A9C8; font-size: 16px; right: 15px;" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">New Password</label>
                                            <div class="form-group">
                                                <div class="password-wrapper position-relative">
                                                    <input type="password" id="password" class="form-control h-55 text-dark" value="@password#">
                                                    <i style="color: #A9A9C8; font-size: 16px; right: 15px;" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Confirm Password</label>
                                            <div class="form-group">
                                                <div class="password-wrapper position-relative">
                                                    <input type="password" id="password" class="form-control h-55 text-dark" value="@password#">
                                                    <i style="color: #A9A9C8; font-size: 16px; right: 15px;" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group d-flex gap-3 align-items-center">
                                            <button type="submit" class="btn btn-primary py-2 px-4 fw-medium fs-16"> <i class="ri-check-line text-white fw-medium"></i> Change Password</button>
                                            <a href="#" class="text-danger fs-16 text-decoration-none">Forgot Password?</a>
                                        </div>
                                    </div>
                                </div>     
                            </form>
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
