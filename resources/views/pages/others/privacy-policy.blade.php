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
                        <h3 class="mb-0">Privacy Policy</h3>

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
                                    <span class="fw-medium">Privacy Policy</span>
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
                                    <a href="/change-password" class="btn btn-primary border border-primary bg-transparent text-primary py-2 px-3 fw-semibold">Change Password</a>
                                </li>
                                <li>
                                    <a href="/connections" class="btn btn-primary border border-primary bg-transparent text-primary py-2 px-3 fw-semibold">Connections</a>
                                </li>
                                <li>
                                    <a href="/privacy-policy" class="btn btn-primary border border-primary bg-primary text-white py-2 px-3 fw-semibold">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="/terms-conditions" class="btn btn-primary border border-primary bg-transparent text-primary py-2 px-3 fw-semibold">Terms & Conditions</a>
                                </li>
                            </ul>
                            
                            <h4 class="fs-18 mb-4">Security :</h4>
                            
                            <ul class="ps-0 mb-0 list-unstyled">
                                <li class="mb-4">
                                    <h4 class="fw-semibold fs-14">Two-factor Authentication</h4>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of.</p>
                                </li>
                                <li class="mb-4">
                                    <h4 class="fw-semibold fs-14">Secondary Verification</h4>
                                    <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing.</p>
                                </li>
                                <li class="mb-4">
                                    <h4 class="fw-semibold fs-14">Backup Codes</h4>
                                    <p>Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of lorem ipsum.</p>
                                </li>
                                <li class="mb-4">
                                    <h4 class="fw-semibold fs-14">Desktop, Email, Chat, Purchase Notifications</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</p>
                                </li>
                                <li class="mb-4">
                                    <h4 class="fw-semibold fs-14">Delete This Account :</h4>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                                </li>
                                <li class="d-flex gap-3">
                                    <button class="btn btn-danger fw-semibold text-white bg-danger border-0 py-3 px-4">Cancel</button>
                                    <button class="btn btn-primary fw-semibold text-white bg-primary border-0 py-3 px-4">Close & Delete This Account</button>
                                </li>
                            </ul>
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
