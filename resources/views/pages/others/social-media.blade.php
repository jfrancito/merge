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
                        <div class="col-xxl-6">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                        <div class="p-4">
                                            <img src="/assets/images/instagram.png" class="mb-3" alt="instagram">
                                            <h2 class="fs-36 fw-medium mb-0 lh-1">345k</h2>
                                            <span class="text-body-color-60 d-block mb-4">Followers</span>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="fs-12">This Month</span>
                                                <span class="d-flex align-items-center text-success-50 rounded-1" style="background-color: #D8FFC8; padding: 0.6px 4px;">
                                                    <i class="ri-arrow-up-line fs-12"></i>
                                                    <span class="fs-12" style="margin-left: 3px;">3.5%</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                        <div class="p-4">
                                            <img src="/assets/images/linkedin.png" class="mb-3" alt="linkedin">
                                            <h2 class="fs-36 fw-medium mb-0 lh-1">56.3k</h2>
                                            <span class="text-body-color-60 d-block mb-4">Followers</span>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="fs-12">This Month</span>
                                                <span class="d-flex align-items-center rounded-1" style="background-color: #FFE1DD; padding: 0.6px 4px; color: #D71C00;">
                                                    <i class="ri-arrow-down-line fs-12"></i>
                                                    <span class="fs-12" style="margin-left: 3px;">2.1%</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                        <div class="p-4">
                                            <img src="/assets/images/tiktok.png" class="mb-3" alt="tiktok">
                                            <h2 class="fs-36 fw-medium mb-0 lh-1">132k</h2>
                                            <span class="text-body-color-60 d-block mb-4">Followers</span>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="fs-12">This Month</span>
                                                <span class="d-flex align-items-center text-success-50 rounded-1" style="background-color: #D8FFC8; padding: 0.6px 4px;">
                                                    <i class="ri-arrow-up-line fs-12"></i>
                                                    <span class="fs-12" style="margin-left: 3px;">6.3%</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                        <div class="p-4">
                                            <img src="/assets/images/facebook.png" class="mb-3" alt="facebook">
                                            <h2 class="fs-36 fw-medium mb-0 lh-1">98.5k</h2>
                                            <span class="text-body-color-60 d-block mb-4">Followers</span>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="fs-12">This Month</span>
                                                <span class="d-flex align-items-center text-success-50 rounded-1" style="background-color: #D8FFC8; padding: 0.6px 4px;">
                                                    <i class="ri-arrow-up-line fs-12"></i>
                                                    <span class="fs-12" style="margin-left: 3px;">2.6%</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                        <div class="p-4">
                                            <img src="/assets/images/x.png" class="mb-3" alt="instagram">
                                            <h2 class="fs-36 fw-medium mb-0 lh-1">75.2k</h2>
                                            <span class="text-body-color-60 d-block mb-4">Followers</span>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="fs-12">This Month</span>
                                                <span class="d-flex align-items-center text-success-50 rounded-1" style="background-color: #D8FFC8; padding: 0.6px 4px;">
                                                    <i class="ri-arrow-up-line fs-12"></i>
                                                    <span class="fs-12" style="margin-left: 3px;">3.5%</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                        <div class="p-4">
                                            <img src="/assets/images/youtube.png" class="mb-3" alt="youtube">
                                            <h2 class="fs-36 fw-medium mb-0 lh-1">84.7k</h2>
                                            <span class="text-body-color-60 d-block mb-4">Followers</span>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="fs-12">This Month</span>
                                                <span class="d-flex align-items-center rounded-1" style="background-color: #FFE1DD; padding: 0.6px 4px; color: #D71C00;">
                                                    <i class="ri-arrow-down-line fs-12"></i>
                                                    <span class="fs-12" style="margin-left: 3px;">5.2%</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="p-4">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                                        <div>
                                            <h3 class="fs-20 fw-semibold mb-0">Linkedin Net Followers</h3>
                                            <span class="text-body-color-60">Net followers growth: +275</span>
                                        </div>
                                        <div class="dropdown select-dropdown">
                                            <button class="dropdown-toggle bg-transparent border text-body rounded-2" style="padding-right: 39px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Last Week
                                            </button>
                                          
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
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
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
                                        <div>
                                            <h3 class="fs-14 fw-medium mb-0">56,100</h3>
                                            <span class="fs-12">Starting Followers</span>
                                        </div>
                                        <div>
                                            <h3 class="fs-14 fw-medium mb-0">300</h3>
                                            <span class="fs-12">New Followers</span>
                                        </div>
                                        <div>
                                            <h3 class="fs-14 fw-medium mb-0">25</h3>
                                            <span class="fs-12">Unfollows</span>
                                        </div>
                                        <div>
                                            <h3 class="fs-14 fw-medium mb-0">56,375</h3>
                                            <span class="fs-12">Ending Followers</span>
                                        </div>
                                    </div>
                                    
                                    <div style="margin: -24px -10px -28px -17px;">
                                        <div id="linkedin_net_followers"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-4 col-md-6">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4 pb-3">
                                <div class="p-4">
                                    <div class="d-flex justify-content-between align-items-center gap-1 mb-3 mb-lg-4">
                                        <div>
                                            <h3 class="mb-0 fs-20 fw-semibold">Suggestions</h3>
                                            <span class="text-body-color-60 fw-normal fs-14">People may you know</span>
                                        </div>

                                        <div class="dropdown select-dropdown">
                                            <button class="bg-transparent border text-body rounded-2 p-0 border-0 dot" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-2-fill" style="font-size: 22px;"></i>
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
                                    <div class="last-child-none">
                                        <div class="d-flex justify-content-between align-items-center child mb-20">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-113.png" class="rounded-circle" style="width: 44px; height: 44px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-10">
                                                    <h4 class="fs-14 fw-medium mb-0">Sophia Adams</h4>
                                                    <span class="fs-12">12 mutual friends</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-1">
                                                <button class=" bg-transparent p-0 d-inline-block border border-danger rounded-circle text-danger hover-bg-danger border-opacity-50" style="width: 34px; height: 34px; line-height: 32px;">
                                                    <i class="ri-delete-bin-7-line fs-16"></i>
                                                </button>
                                                <button class=" bg-transparent p-0 d-inline-block border border-primary rounded-circle text-primary hover-bg border-opacity-50" style="width: 34px; height: 34px; line-height: 32px;">
                                                    <i class="ri-user-add-line fs-16"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center child mb-20">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-114.png" class="rounded-circle" style="width: 44px; height: 44px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-10">
                                                    <h4 class="fs-14 fw-medium mb-0">Liam Roberts</h4>
                                                    <span class="fs-12">8 mutual friends</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-1">
                                                <button class=" bg-transparent p-0 d-inline-block border border-danger rounded-circle text-danger hover-bg-danger border-opacity-50" style="width: 34px; height: 34px; line-height: 32px;">
                                                    <i class="ri-delete-bin-7-line fs-16"></i>
                                                </button>
                                                <button class=" bg-transparent p-0 d-inline-block border border-primary rounded-circle text-primary hover-bg border-opacity-50" style="width: 34px; height: 34px; line-height: 32px;">
                                                    <i class="ri-user-add-line fs-16"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center child mb-20">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-115.png" class="rounded-circle" style="width: 44px; height: 44px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-10">
                                                    <h4 class="fs-14 fw-medium mb-0">Olivia Martinez</h4>
                                                    <span class="fs-12">15 mutual friends</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-1">
                                                <button class=" bg-transparent p-0 d-inline-block border border-danger rounded-circle text-danger hover-bg-danger border-opacity-50" style="width: 34px; height: 34px; line-height: 32px;">
                                                    <i class="ri-delete-bin-7-line fs-16"></i>
                                                </button>
                                                <button class=" bg-transparent p-0 d-inline-block border border-primary rounded-circle text-primary hover-bg border-opacity-50" style="width: 34px; height: 34px; line-height: 32px;">
                                                    <i class="ri-user-add-line fs-16"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center child mb-20">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-116.png" class="rounded-circle" style="width: 44px; height: 44px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-10">
                                                    <h4 class="fs-14 fw-medium mb-0">Ethan Clarke</h4>
                                                    <span class="fs-12">10 mutual friends</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-1">
                                                <button class=" bg-transparent p-0 d-inline-block border border-danger rounded-circle text-danger hover-bg-danger border-opacity-50" style="width: 34px; height: 34px; line-height: 32px;">
                                                    <i class="ri-delete-bin-7-line fs-16"></i>
                                                </button>
                                                <button class=" bg-transparent p-0 d-inline-block border border-primary rounded-circle text-primary hover-bg border-opacity-50" style="width: 34px; height: 34px; line-height: 32px;">
                                                    <i class="ri-user-add-line fs-16"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center child mb-20">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-117.png" class="rounded-circle" style="width: 44px; height: 44px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-10">
                                                    <h4 class="fs-14 fw-medium mb-0">Isabella Cruz</h4>
                                                    <span class="fs-12">7 mutual friends</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-1">
                                                <button class=" bg-transparent p-0 d-inline-block border border-danger rounded-circle text-danger hover-bg-danger border-opacity-50" style="width: 34px; height: 34px; line-height: 32px;">
                                                    <i class="ri-delete-bin-7-line fs-16"></i>
                                                </button>
                                                <button class=" bg-transparent p-0 d-inline-block border border-primary rounded-circle text-primary hover-bg border-opacity-50" style="width: 34px; height: 34px; line-height: 32px;">
                                                    <i class="ri-user-add-line fs-16"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4 pb-3">
                                <div class="p-4">
                                    <div class="d-flex justify-content-between align-items-center gap-1 mb-3 mb-lg-4">
                                        <div>
                                            <h3 class="mb-0 fs-20 fw-semibold">Followers by Gender</h3>
                                            <span class="text-body-color-60 fw-normal fs-14">Understand your audience better!</span>
                                        </div>

                                        <div class="dropdown select-dropdown">
                                            <button class="bg-transparent border text-body rounded-2 p-0 border-0 dot" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-2-fill" style="font-size: 22px;"></i>
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
                                    <div class="text-center mb-3">
                                        <h3 class="fs-16 fw-medium mb-0">54,500</h3>
                                        <span class="fs-12">Total Followers</span>
                                    </div>
                                    <div style="margin: 0 0 0 0;">
                                        <div id="followers_by_gender"></div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 mt-2 pt-1 justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <span class="d-inline-block bg-primary rounded-circle position-relative top-2" style="width: 10px; height: 10px;"></span>
                                            <div class="ms-10">
                                                <span class="fw-medium text-secondary d-block lh-1">55%</span>
                                                <span class="fs-12">Male Followers</span>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <span class="d-inline-block bg-primary-div rounded-circle position-relative top-2" style="width: 10px; height: 10px;"></span>
                                            <div class="ms-10">
                                                <span class="fw-medium text-secondary d-block lh-1">43%</span>
                                                <span class="fs-12">Female Followers</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-12">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4 recent-instagram-for-dark-mode" id="send_private_massage">
                                <div class="d-flex justify-content-between align-items-center gap-1 mb-3 mb-lg-4 p-4 pb-0">
                                    <div>
                                        <h3 class="mb-0 fs-20 fw-semibold">Recent Instagram Followers</h3>
                                        <span class="text-body-color-60 fw-normal fs-14">Check out your latest followers</span>
                                    </div>

                                    <div class="dropdown select-dropdown">
                                        <button class="bg-transparent border text-body rounded-2 p-0 border-0 dot" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill" style="font-size: 22px;"></i>
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
                                <div class="last-child-none pt-lg-2 pb-4">
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center child px-4" style="padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px solid #F6F7F9;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/user-118.png" class="rounded-circle" style="width: 34px; height: 34px;" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-10">
                                                <h4 class="fs-14 fw-medium mb-0">Mason Lee</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <button class="d-inline-block border-0 rounded-1 text-primary-50 hover-bg fs-12 lh-1" style="padding: 6.5px 10px; background-color: #ECF0FF;">
                                                Follow Back
                                            </button>

                                            <div class="option-item position-relative">
                                                <i class="ri-message-2-line fs-18 lh-1 position-relative top-1 search-btn d-inline-block border-0 rounded-1 text-primary-div-50 hover-bg fs-12 lh-1 cursor"  style="padding: 3.5px 4px; background-color: #F3E8FF;"></i>
                                                <i class="close-btn ri-close-line fs-18 lh-1 position-absolute top-50 end-0 translate-middle-y search-btn d-inline-block border-0 rounded-1 text-primary-div-50 hover-bg fs-12 lh-1 cursor" style="padding: 3.5px 4px; background-color: #F3E8FF;"></i> 
                                                
                                                <div class="search-overlay search-popup position-absolute end-0" style="width: 250px;">
                                                    <div class="bg-white p-3 box-shadow rounded-3 position-relative z-1">
                                                        <form class="search-form position-relative">
                                                            <input type="text" class="search-input form-control" name="search" placeholder="Send a private massage">
            
                                                            <button class="search-button bg-transparent p-0 border-0 position-absolute top-50 end-0 translate-middle-y pe-3 text-primary" type="button">
                                                                <i class="ri-send-plane-2-line"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center child px-4" style="padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px solid #F6F7F9;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/user-119.png" class="rounded-circle" style="width: 34px; height: 34px;" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-10">
                                                <h4 class="fs-14 fw-medium mb-0">Mia Patel</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <button class="d-inline-block border-0 rounded-1 text-primary-50 hover-bg fs-12 lh-1" style="padding: 6.5px 10px; background-color: #ECF0FF;">
                                                Follow Back
                                            </button>
                                            <div class="option-item position-relative">
                                                <i class="ri-message-2-line fs-18 lh-1 position-relative top-1 search-btn d-inline-block border-0 rounded-1 text-primary-div-50 hover-bg fs-12 lh-1 cursor"  style="padding: 3.5px 4px; background-color: #F3E8FF;"></i>
                                                <i class="close-btn ri-close-line fs-18 lh-1 position-absolute top-50 end-0 translate-middle-y search-btn d-inline-block border-0 rounded-1 text-primary-div-50 hover-bg fs-12 lh-1 cursor" style="padding: 3.5px 4px; background-color: #F3E8FF;"></i> 
                                                
                                                <div class="search-overlay search-popup position-absolute end-0" style="width: 250px;">
                                                    <div class="bg-white p-3 box-shadow rounded-3 position-relative z-1">
                                                        <form class="search-form position-relative">
                                                            <input type="text" class="search-input form-control" name="search" placeholder="Send a private massage">
            
                                                            <button class="search-button bg-transparent p-0 border-0 position-absolute top-50 end-0 translate-middle-y pe-3 text-primary" type="button">
                                                                <i class="ri-send-plane-2-line"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center child px-4" style="padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px solid #F6F7F9;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/user-120.png" class="rounded-circle" style="width: 34px; height: 34px;" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-10">
                                                <h4 class="fs-14 fw-medium mb-0">James Nguyen</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <button class="d-inline-block border-0 rounded-1 text-primary-50 hover-bg fs-12 lh-1" style="padding: 6.5px 10px; background-color: #ECF0FF;">
                                                Follow Back
                                            </button>
                                            <div class="option-item position-relative">
                                                <i class="ri-message-2-line fs-18 lh-1 position-relative top-1 search-btn d-inline-block border-0 rounded-1 text-primary-div-50 hover-bg fs-12 lh-1 cursor"  style="padding: 3.5px 4px; background-color: #F3E8FF;"></i>
                                                <i class="close-btn ri-close-line fs-18 lh-1 position-absolute top-50 end-0 translate-middle-y search-btn d-inline-block border-0 rounded-1 text-primary-div-50 hover-bg fs-12 lh-1 cursor" style="padding: 3.5px 4px; background-color: #F3E8FF;"></i> 
                                                
                                                <div class="search-overlay search-popup position-absolute end-0" style="width: 250px;">
                                                    <div class="bg-white p-3 box-shadow rounded-3 position-relative z-1">
                                                        <form class="search-form position-relative">
                                                            <input type="text" class="search-input form-control" name="search" placeholder="Send a private massage">
            
                                                            <button class="search-button bg-transparent p-0 border-0 position-absolute top-50 end-0 translate-middle-y pe-3 text-primary" type="button">
                                                                <i class="ri-send-plane-2-line"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center child px-4" style="padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px solid #F6F7F9;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/user-121.png" class="rounded-circle" style="width: 34px; height: 34px;" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-10">
                                                <h4 class="fs-14 fw-medium mb-0">Benjamin Kim</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <button class="d-inline-block border-0 rounded-1 text-primary-50 hover-bg fs-12 lh-1" style="padding: 6.5px 10px; background-color: #ECF0FF;">
                                                Follow Back
                                            </button>
                                            <div class="option-item position-relative">
                                                <i class="ri-message-2-line fs-18 lh-1 position-relative top-1 search-btn d-inline-block border-0 rounded-1 text-primary-div-50 hover-bg fs-12 lh-1 cursor"  style="padding: 3.5px 4px; background-color: #F3E8FF;"></i>
                                                <i class="close-btn ri-close-line fs-18 lh-1 position-absolute top-50 end-0 translate-middle-y search-btn d-inline-block border-0 rounded-1 text-primary-div-50 hover-bg fs-12 lh-1 cursor" style="padding: 3.5px 4px; background-color: #F3E8FF;"></i> 
                                                
                                                <div class="search-overlay search-popup position-absolute end-0" style="width: 250px;">
                                                    <div class="bg-white p-3 box-shadow rounded-3 position-relative z-1">
                                                        <form class="search-form position-relative">
                                                            <input type="text" class="search-input form-control" name="search" placeholder="Send a private massage">
            
                                                            <button class="search-button bg-transparent p-0 border-0 position-absolute top-50 end-0 translate-middle-y pe-3 text-primary" type="button">
                                                                <i class="ri-send-plane-2-line"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center child px-4" style="padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px solid #F6F7F9;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/user-122.png" class="rounded-circle" style="width: 34px; height: 34px;" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-10">
                                                <h4 class="fs-14 fw-medium mb-0">Elijah Watson</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <button class="d-inline-block border-0 rounded-1 text-primary-50 hover-bg fs-12 lh-1" style="padding: 6.5px 10px; background-color: #ECF0FF;">
                                                Follow Back
                                            </button>
                                            <div class="option-item position-relative">
                                                <i class="ri-message-2-line fs-18 lh-1 position-relative top-1 search-btn d-inline-block border-0 rounded-1 text-primary-div-50 hover-bg fs-12 lh-1 cursor"  style="padding: 3.5px 4px; background-color: #F3E8FF;"></i>
                                                <i class="close-btn ri-close-line fs-18 lh-1 position-absolute top-50 end-0 translate-middle-y search-btn d-inline-block border-0 rounded-1 text-primary-div-50 hover-bg fs-12 lh-1 cursor" style="padding: 3.5px 4px; background-color: #F3E8FF;"></i> 
                                                
                                                <div class="search-overlay search-popup position-absolute end-0" style="width: 250px;">
                                                    <div class="bg-white p-3 box-shadow rounded-3 position-relative z-1">
                                                        <form class="search-form position-relative">
                                                            <input type="text" class="search-input form-control" name="search" placeholder="Send a private massage">
            
                                                            <button class="search-button bg-transparent p-0 border-0 position-absolute top-50 end-0 translate-middle-y pe-3 text-primary" type="button">
                                                                <i class="ri-send-plane-2-line"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center child px-4" style="padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px solid #F6F7F9;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/user-123.png" class="rounded-circle" style="width: 34px; height: 34px;" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-10">
                                                <h4 class="fs-14 fw-medium mb-0">Daniel Flores</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <button class="d-inline-block border-0 rounded-1 text-primary-50 hover-bg fs-12 lh-1" style="padding: 6.5px 10px; background-color: #ECF0FF;">
                                                Follow Back
                                            </button>
                                            <div class="option-item position-relative">
                                                <i class="ri-message-2-line fs-18 lh-1 position-relative top-1 search-btn d-inline-block border-0 rounded-1 text-primary-div-50 hover-bg fs-12 lh-1 cursor"  style="padding: 3.5px 4px; background-color: #F3E8FF;"></i>
                                                <i class="close-btn ri-close-line fs-18 lh-1 position-absolute top-50 end-0 translate-middle-y search-btn d-inline-block border-0 rounded-1 text-primary-div-50 hover-bg fs-12 lh-1 cursor" style="padding: 3.5px 4px; background-color: #F3E8FF;"></i> 
                                                
                                                <div class="search-overlay search-popup position-absolute end-0" style="width: 250px;">
                                                    <div class="bg-white p-3 box-shadow rounded-3 position-relative z-1">
                                                        <form class="search-form position-relative">
                                                            <input type="text" class="search-input form-control" name="search" placeholder="Send a private massage">
            
                                                            <button class="search-button bg-transparent p-0 border-0 position-absolute top-50 end-0 translate-middle-y pe-3 text-primary" type="button">
                                                                <i class="ri-send-plane-2-line"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-8 col-md-8">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="p-4">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                                        <div>
                                            <h3 class="fs-20 fw-semibold mb-0">Facebook Campaign Overview</h3>
                                            <span class="text-body-color-60">Track campaign success at a glance!</span>
                                        </div>
                                        <div class="dropdown select-dropdown">
                                            <button class="dropdown-toggle bg-transparent border text-body rounded-2" style="padding-right: 39px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Sep 1 - Sep 30
                                            </button>
                                          
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Sep 1 - Sep 30</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Jun 1 - Jun 30</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">Apr 1 - Apr 30</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-secondary py-2 px-3">May 1 - May 30</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center mb-4 lh-1">
                                        <i class="ri-bookmark-line fs-16" style="color: #FF4023;"></i>
                                        <span class="ms-1 fs-16 fw-medium text-secondary">Summer Sale Boost</span>
                                    </div>
                                    
                                    <div class="row align-items-center">
                                        <div class="col-lg-9 col-sm-8">
                                            <div style="margin: -4px -10px -26px -17px;">
                                                <div id="facebook_campaign_overview"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-4">
                                            <div class="last-child-none ms-xxl-3 d-flex d-sm-block flex-wrap gap-2 justify-content-between mt-4 mt-sm-0">
                                                <div class="d-flex child mb-4">
                                                    <span class="d-inline-block bg-primary rounded-circle position-relative top-2" style="width: 10px; height: 10px;"></span>
                                                    <div class="ms-10">
                                                        <span class="fw-medium text-secondary d-block lh-1">45,000</span>
                                                        <span class="fs-12">Impressions</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex child mb-4">
                                                    <span class="d-inline-block bg-success rounded-circle position-relative top-2" style="width: 10px; height: 10px;"></span>
                                                    <div class="ms-10">
                                                        <span class="fw-medium text-secondary d-block lh-1">4,200</span>
                                                        <span class="fs-12">Clicks</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex child mb-4">
                                                    <span class="d-inline-block bg-danger rounded-circle position-relative top-2" style="width: 10px; height: 10px;"></span>
                                                    <div class="ms-10">
                                                        <span class="fw-medium text-secondary d-block lh-1">9.3%</span>
                                                        <span class="fs-12">CTR</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex child mb-4">
                                                    <span class="d-inline-block rounded-circle position-relative top-2" style="width: 10px; height: 10px; background-color: #BF85FB;"></span>
                                                    <div class="ms-10">
                                                        <span class="fw-medium text-secondary d-block lh-1">$5.50</span>
                                                        <span class="fs-12">Cost per Conversion</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-4">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4 py-2">
                                <div class="p-4 text-center">
                                    <h3 class="fs-24 fw-medium mb-2">Upgrade Your Plan!</h3>
                                    <p class="fs-14 mb-3 pb-1 mx-auto" style="line-height: 1.44; max-width: 307px;">Access advanced features, enhanced support, and exclusive tools designed to help you achieve more.</p>
                                    <div class="mb-3">
                                        <img src="/assets/images/upgrade-2.png" alt="upgrade">
                                    </div>
                                    <a href="/pricing-plan" class="btn btn-primary rounded-3 fs-16 fw-medium" style="padding: 7px 21px;">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-fire-fill fs-18"></i>
                                            <span class="ms-10">Upgrade Plan</span>
                                        </div>
                                    </a>
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
