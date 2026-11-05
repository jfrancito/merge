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
                        <h3 class="mb-0">Connections</h3>

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
                                    <span class="fw-medium">Connections</span>
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
                                    <a href="/connections" class="btn btn-primary border border-primary bg-primary text-white py-2 px-3 fw-semibold">Connections</a>
                                </li>
                                <li>
                                    <a href="/privacy-policy" class="btn btn-primary border border-primary bg-transparent text-primary py-2 px-3 fw-semibold">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="/terms-conditions" class="btn btn-primary border border-primary bg-transparent text-primary py-2 px-3 fw-semibold">Terms & Conditions</a>
                                </li>
                            </ul>
                            
                            <h4 class="fs-18 mb-2">Connected Accounts</h4>

                            <div class="default-table-area connected-table border-bottom pb-3 mb-4">
                                <div class="table-responsive">
                                    <table class="table align-middle border-0">
                                        <tbody>
                                            <tr>
                                                <td class="ps-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/google2.svg" alt="google2">
                                                        <div class="ms-3">
                                                            <span class="fw-semibold text-dark">Google</span>
                                                            <p class="fs-14 text-body fw-normal">Calendar and Contacts</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <a href="/connections/" class="text-decoration-none text-primary fs-14">Click to Disconnect</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/slack.svg" alt="slack">
                                                        <div class="ms-3">
                                                            <span class="fw-semibold text-dark">Slack</span>
                                                            <p class="fs-14 text-body fw-normal">Communications</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <a href="/connections/" class="text-decoration-none text-primary fs-14">Click to Disconnect</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/git.svg" alt="git">
                                                        <div class="ms-3">
                                                            <span class="fw-semibold text-dark">Github</span>
                                                            <p class="fs-14 text-body fw-normal">Manage your Git repositories</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <a href="/connections/" class="text-decoration-none text-primary fs-14">Click to Disconnect</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/mailchimp.svg" alt="mailchimp">
                                                        <div class="ms-3">
                                                            <span class="fw-semibold text-dark">Mailchimp</span>
                                                            <p class="fs-14 text-body fw-normal">Email marketing service</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <a href="/connections/" class="text-decoration-none text-primary fs-14">Click to Disconnect</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/asana.svg" alt="asana">
                                                        <div class="ms-3">
                                                            <span class="fw-semibold text-dark">Asana</span>
                                                            <p class="fs-14 text-body fw-normal">Communication</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <a href="/connections/" class="text-decoration-none text-primary fs-14">Click to Disconnect</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <h4 class="fs-18 mb-2">Social Accounts</h4>

                            <div class="default-table-area connected-table">
                                <div class="table-responsive">
                                    <table class="table align-middle border-0">
                                        <tbody>
                                            <tr>
                                                <td class="ps-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/facebook3.svg" alt="facebook2">
                                                        <div class="ms-3">
                                                            <span class="fw-semibold text-dark">Facebook</span>
                                                            <p class="fs-14 text-body fw-normal">Calendar and Contacts</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <a href="/connections/" class="text-decoration-none text-primary fs-14">Click to Disconnect</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/twitter.svg" alt="twitter">
                                                        <div class="ms-3">
                                                            <span class="fw-semibold text-dark">Twitter</span>
                                                            <p class="fs-14 text-body fw-normal">Communications</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <a href="/connections/" class="text-decoration-none text-primary fs-14">Click to Disconnect</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/instagram.svg" alt="instagram">
                                                        <div class="ms-3">
                                                            <span class="fw-semibold text-dark">Instagram</span>
                                                            <p class="fs-14 text-body fw-normal">Manage your Git repositories</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <a href="/connections/" class="text-decoration-none text-primary fs-14">Click to Disconnect</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/dribbble2.svg" alt="dribbble2">
                                                        <div class="ms-3">
                                                            <span class="fw-semibold text-dark">Dribbble</span>
                                                            <p class="fs-14 text-body fw-normal">Email marketing service</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <a href="/connections/" class="text-decoration-none text-primary fs-14">Click to Disconnect</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/behance.svg" alt="behance">
                                                        <div class="ms-3">
                                                            <span class="fw-semibold text-dark">Behance</span>
                                                            <p class="fs-14 text-body fw-normal">Communication</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <a href="/connections/" class="text-decoration-none text-primary fs-14">Click to Disconnect</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
