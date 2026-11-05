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
                    <div class="rounded-3 position-relative z-1 manage-nft" style="background: linear-gradient(92deg, #23272E 7.31%, #3F5272 97.89%); padding: 60px 40px 150px;">

                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <div class="flex-grow-1 me-3">
                                <img src="/assets/images/shape-8.png" class="position-absolute top-0 end-0" alt="shape">
                                <h3 class="fs-28 text-white">Manage Your NFT From One Place</h3>
                                <p style="color: #B1BBC8;">The world’s first and largest digital marketplace for discover, collect, sell and create your own NFTs.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <button class="btn btn-primary py-2 p-4 position-relative z-1" data-bs-toggle="modal" data-bs-target="#exampleModal">Create NFT</button>
                            </div>
                        </div>
                    </div>

                    <div class="px-2 px-sm-5 position-relative mb-4">
                        <div class="swiper nft-slide">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                        <a href="#" class="d-block  mb-3 text-decoration-none position-relative">
                                            <img src="/assets/images/nft-1.gif" class="rounded-3" alt="nft">
                                            <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                Place Bid
                                            </span>
                                        </a>
        
                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                            <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-76.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span class="fs-12">NFT ID: 35246</span>
                                                    <h4 class="fw-semibold fs-14 mb-0">Christmas Eve</h4>
                                                </div>
                                            </a>
                                            <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                        </div>
        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="#" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-grow-1">
                                                    <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">9.75 ETH</span></span>
                                                    <h4 class="fw-semibold fs-14 mb-0">5.50 ETH</h4>
                                                </div>
                                            </a>
                                            <button class="bg-transparent p-0 border-0">
                                                <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                <span class="text-secondary fs-12 fw-semibold">9.2<span class="text-body">/10</span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                        <a href="#" class="d-block mb-3 text-decoration-none position-relative">
                                            <img src="/assets/images/nft-2.png" class="rounded-3" alt="nft">
                                            <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                Place Bid
                                            </span>
                                        </a>
        
                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                            <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-77.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span class="fs-12">NFT ID: 35247</span>
                                                    <h4 class="fw-semibold fs-14 mb-0">Rotating Panda</h4>
                                                </div>
                                            </a>
                                            <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                        </div>
        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="#" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-grow-1">
                                                    <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">10.75 ETH</span></span>
                                                    <h4 class="fw-semibold fs-14 mb-0">12.50 ETH</h4>
                                                </div>
                                            </a>
                                            <button class="bg-transparent p-0 border-0">
                                                <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                <span class="text-secondary fs-12 fw-semibold">9.5<span class="text-body">/10</span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                        <a href="#" class="d-block  mb-3 text-decoration-none position-relative">
                                            <img src="/assets/images/nft-3.gif" class="rounded-3" alt="nft">
                                            <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                Place Bid
                                            </span>
                                        </a>
        
                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                            <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-76.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span class="fs-12">NFT ID: 35249</span>
                                                    <h4 class="fw-semibold fs-14 mb-0">Cookies Live</h4>
                                                </div>
                                            </a>
                                            <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                        </div>
        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="#" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-grow-1">
                                                    <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">17.75 ETH</span></span>
                                                    <h4 class="fw-semibold fs-14 mb-0">20.50 ETH</h4>
                                                </div>
                                            </a>
                                            <button class="bg-transparent p-0 border-0">
                                                <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                <span class="text-secondary fs-12 fw-semibold">9.3<span class="text-body">/10</span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                        <a href="#" class="d-block  mb-3 text-decoration-none position-relative">
                                            <img src="/assets/images/nft-4.gif" class="rounded-3" alt="nft">
                                            <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                Place Bid
                                            </span>
                                        </a>
        
                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                            <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-78.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span class="fs-12">NFT ID: 35248</span>
                                                    <h4 class="fw-semibold fs-14 mb-0">World Savior</h4>
                                                </div>
                                            </a>
                                            <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                        </div>
        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="#" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-grow-1">
                                                    <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">9.75 ETH</span></span>
                                                    <h4 class="fw-semibold fs-14 mb-0">10.50 ETH</h4>
                                                </div>
                                            </a>
                                            <button class="bg-transparent p-0 border-0">
                                                <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                <span class="text-secondary fs-12 fw-semibold">9.7<span class="text-body">/10</span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                        <a href="#" class="d-block  mb-3 text-decoration-none position-relative">
                                            <img src="/assets/images/nft-1.gif" class="rounded-3" alt="nft">
                                            <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                Place Bid
                                            </span>
                                        </a>
        
                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                            <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-76.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span class="fs-12">NFT ID: 35246</span>
                                                    <h4 class="fw-semibold fs-14 mb-0">Christmas Eve</h4>
                                                </div>
                                            </a>
                                            <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                        </div>
        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="#" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-grow-1">
                                                    <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">9.75 ETH</span></span>
                                                    <h4 class="fw-semibold fs-14 mb-0">5.50 ETH</h4>
                                                </div>
                                            </a>
                                            <button class="bg-transparent p-0 border-0">
                                                <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                <span class="text-secondary fs-12 fw-semibold">9.2<span class="text-body">/10</span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                        <a href="#" class="d-block mb-3 text-decoration-none position-relative">
                                            <img src="/assets/images/nft-2.png" class="rounded-3" alt="nft">
                                            <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                Place Bid
                                            </span>
                                        </a>
        
                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                            <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-77.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span class="fs-12">NFT ID: 35247</span>
                                                    <h4 class="fw-semibold fs-14 mb-0">Rotating Panda</h4>
                                                </div>
                                            </a>
                                            <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                        </div>
        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="#" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-grow-1">
                                                    <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">10.75 ETH</span></span>
                                                    <h4 class="fw-semibold fs-14 mb-0">12.50 ETH</h4>
                                                </div>
                                            </a>
                                            <button class="bg-transparent p-0 border-0">
                                                <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                <span class="text-secondary fs-12 fw-semibold">9.5<span class="text-body">/10</span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                        <a href="#" class="d-block  mb-3 text-decoration-none position-relative">
                                            <img src="/assets/images/nft-3.gif" class="rounded-3" alt="nft">
                                            <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                Place Bid
                                            </span>
                                        </a>
        
                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                            <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-76.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span class="fs-12">NFT ID: 35249</span>
                                                    <h4 class="fw-semibold fs-14 mb-0">Cookies Live</h4>
                                                </div>
                                            </a>
                                            <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                        </div>
        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="#" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-grow-1">
                                                    <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">17.75 ETH</span></span>
                                                    <h4 class="fw-semibold fs-14 mb-0">20.50 ETH</h4>
                                                </div>
                                            </a>
                                            <button class="bg-transparent p-0 border-0">
                                                <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                <span class="text-secondary fs-12 fw-semibold">9.3<span class="text-body">/10</span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                        <a href="#" class="d-block  mb-3 text-decoration-none position-relative">
                                            <img src="/assets/images/nft-4.gif" class="rounded-3" alt="nft">
                                            <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                Place Bid
                                            </span>
                                        </a>
        
                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                            <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-shrink-0">
                                                    <img src="/assets/images/user-78.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <span class="fs-12">NFT ID: 35248</span>
                                                    <h4 class="fw-semibold fs-14 mb-0">World Savior</h4>
                                                </div>
                                            </a>
                                            <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                        </div>
        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="#" class="d-flex align-items-center text-decoration-none">
                                                <div class="flex-grow-1">
                                                    <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">9.75 ETH</span></span>
                                                    <h4 class="fw-semibold fs-14 mb-0">10.50 ETH</h4>
                                                </div>
                                            </a>
                                            <button class="bg-transparent p-0 border-0">
                                                <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                <span class="text-secondary fs-12 fw-semibold">9.7<span class="text-body">/10</span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="nft-controller">
                            <div class="controller-icon prev">
                                <i class="ri-arrow-left-line"></i>
                            </div>
                            <div class="controller-icon next">
                                <i class="ri-arrow-right-line"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-4 col-lg-4">
                            <div class="card bg-white border-0 p-4 mb-4 rounded-10">
                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-1">
                                    <span class="d-block mb-1">Ethereum Rate</span>
                                    <div class="dropdown action-opt text-center">
                                        <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow">
                                            <li>
                                                <a class="dropdown-item" href="javascript:;">
                                                    <i data-feather="edit"></i>
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:;">
                                                    <i data-feather="eye"></i>
                                                    View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:;">
                                                    <i data-feather="trash"></i>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div  class="d-flex align-items-center mb-2">
                                    <h3 class="fs-32 fw-bold text-secondary mb-0">$1,528</h3>
                                    <span class="fw-medium fs-12 text-success bg-success bg-opacity-10 border border-success px-2 rounded-pill ms-2">
                                        +5.4% 
                                        <i class="ri-arrow-up-line"></i>
                                    </span>
                                </div> 

                                <span class="fs-12 d-block mb-4">Vs previous 30 days</span>

                                <ul class="nav nav-tabs justify-content-between ethereum-rate-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="ethereum1-tab" data-bs-toggle="tab" data-bs-target="#ethereum1-tab-pane" type="button" role="tab" aria-controls="ethereum1-tab-pane" aria-selected="true">1D</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="ethereum2-tab" data-bs-toggle="tab" data-bs-target="#ethereum2-tab-pane" type="button" role="tab" aria-controls="ethereum2-tab-pane" aria-selected="false">5D</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="ethereum3-tab" data-bs-toggle="tab" data-bs-target="#ethereum3-tab-pane" type="button" role="tab" aria-controls="ethereum3-tab-pane" aria-selected="false">1M</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="ethereum4-tab" data-bs-toggle="tab" data-bs-target="#ethereum4-tab-pane" type="button" role="tab" aria-controls="ethereum4-tab-pane" aria-selected="false">6M</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="ethereum5-tab" data-bs-toggle="tab" data-bs-target="#ethereum5-tab-pane" type="button" role="tab" aria-controls="ethereum5-tab-pane" aria-selected="false">1Y</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="ethereum1-tab-pane" role="tabpanel" aria-labelledby="ethereum1-tab" tabindex="0">
                                        <div style="margin: -30px -5px 0 -21px;">
                                            <div id="ethereum_rate"></div>
                                        </div>
                                        <ul class="ps-0 mb-0 list-unstyled mt-30">
                                            <li class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="fs-12 fw-bold">11:30 AM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,605.08</span>
                                                <span class="fs-12 fw-medium text-success">+5.4% </span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="fs-12 fw-bold">01:20 PM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,615.50</span>
                                                <span class="fs-12 fw-medium text-danger">-3.21%</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <span class="fs-12 fw-bold">11:30 AM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,831.13</span>
                                                <span class="fs-12 fw-medium text-success">+7.32%</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="ethereum2-tab-pane" role="tabpanel" aria-labelledby="ethereum2-tab" tabindex="0">
                                        <div style="margin: -30px -5px 0 -21px;">
                                            <div id="ethereum_rate2"></div>
                                        </div>
                                        <ul class="ps-0 mb-0 list-unstyled mt-30">
                                            <li class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="fs-12 fw-bold">11:30 AM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,605.08</span>
                                                <span class="fs-12 fw-medium text-success">+5.4% </span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="fs-12 fw-bold">01:20 PM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,615.50</span>
                                                <span class="fs-12 fw-medium text-danger">-3.21%</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <span class="fs-12 fw-bold">11:30 AM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,831.13</span>
                                                <span class="fs-12 fw-medium text-success">+7.32%</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="ethereum3-tab-pane" role="tabpanel" aria-labelledby="ethereum3-tab" tabindex="0">
                                        <div style="margin: -30px -5px 0 -21px;">
                                            <div id="ethereum_rate3"></div>
                                        </div>
                                        <ul class="ps-0 mb-0 list-unstyled mt-30">
                                            <li class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="fs-12 fw-bold">11:30 AM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,605.08</span>
                                                <span class="fs-12 fw-medium text-success">+5.4% </span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="fs-12 fw-bold">01:20 PM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,615.50</span>
                                                <span class="fs-12 fw-medium text-danger">-3.21%</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <span class="fs-12 fw-bold">11:30 AM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,831.13</span>
                                                <span class="fs-12 fw-medium text-success">+7.32%</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="ethereum4-tab-pane" role="tabpanel" aria-labelledby="ethereum4-tab" tabindex="0">
                                        <div style="margin: -30px -5px 0 -21px;">
                                            <div id="ethereum_rate4"></div>
                                        </div>
                                        <ul class="ps-0 mb-0 list-unstyled mt-30">
                                            <li class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="fs-12 fw-bold">11:30 AM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,605.08</span>
                                                <span class="fs-12 fw-medium text-success">+5.4% </span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="fs-12 fw-bold">01:20 PM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,615.50</span>
                                                <span class="fs-12 fw-medium text-danger">-3.21%</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <span class="fs-12 fw-bold">11:30 AM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,831.13</span>
                                                <span class="fs-12 fw-medium text-success">+7.32%</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="ethereum5-tab-pane" role="tabpanel" aria-labelledby="ethereum5-tab" tabindex="0">
                                        <div style="margin: -30px -5px 0 -21px;">
                                            <div id="ethereum_rate5"></div>
                                        </div>
                                        <ul class="ps-0 mb-0 list-unstyled mt-30">
                                            <li class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="fs-12 fw-bold">11:30 AM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,605.08</span>
                                                <span class="fs-12 fw-medium text-success">+5.4% </span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center mb-4">
                                                <span class="fs-12 fw-bold">01:20 PM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,615.50</span>
                                                <span class="fs-12 fw-medium text-danger">-3.21%</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center">
                                                <span class="fs-12 fw-bold">11:30 AM</span>
                                                <span class="fs-12 fw-semibold text-secondary">$3,831.13</span>
                                                <span class="fs-12 fw-medium text-success">+7.32%</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8 col-lg-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                                        <h3 class="mb-0">Active Auctions</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color" aria-label="Default select example">
                                            <option selected>Monthly</option>
                                            <option value="1">Yearly</option>
                                        </select>
                                    </div>
                                    <div class="default-table-area style-two campaigns-table">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr class="border-bottom">
                                                        <th scope="col" class=" bg-transparent text-body fw-medium">
                                                            <span class="fs-12">ITEM</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">OPEN PRICE</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">YOUR OFFER</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">RECENT OFFER</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">TIME LEFT</span>
                                                        </th>
                                                        <th scope="col" class="text-end bg-transparent text-body fw-medium">
                                                            <span class="fs-12">VIEW</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/nft-5.gif" class="rounded-3" style="width: 50px; height: 50px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Christmas Eve</h4>
                                                                    <span class="fs-12">by John Lira</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">11.75 ETH</td>
                                                        <td class="fs-12 fw-semibold text-body">10.00 ETH</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="/assets/images/user-80.png" style="width: 22px;" class="border border-1 box-shadow border-color-white rounded-circle" alt="user">
                                                                <span class="text-body fs-12 fw-semibold ms-2">10.08 ETH</span>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">2h : 43m : 21s</td>
                                                        <td class="text-end">
                                                            <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/nft-6.gif" class="rounded-3" style="width: 50px; height: 50px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Rotating Flower</h4>
                                                                    <span class="fs-12">by WalterW.</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">9.25 ETH</td>
                                                        <td class="fs-12 fw-semibold text-body">6.10 ETH</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="/assets/images/user-81.png" style="width: 22px;" class="border border-1 box-shadow border-color-white rounded-circle" alt="user">
                                                                <span class="text-body fs-12 fw-semibold ms-2">7.15 ETH</span>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">1h : 21m : 12s</td>
                                                        <td class="text-end">
                                                            <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/nft-7.png" class="rounded-3" style="width: 50px; height: 50px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Windows Art</h4>
                                                                    <span class="fs-12">by Christino</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">17.24 ETH</td>
                                                        <td class="fs-12 fw-semibold text-body">11.75 ETH</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="/assets/images/user-82.png" style="width: 22px;" class="border border-1 box-shadow border-color-white rounded-circle" alt="user">
                                                                <span class="text-body fs-12 fw-semibold ms-2">14.11 ETH</span>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">43m : 21s</td>
                                                        <td class="text-end">
                                                            <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/nft-8.png" class="rounded-3" style="width: 50px; height: 50px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">3D Logo</h4>
                                                                    <span class="fs-12">by Hater</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">12.12 ETH</td>
                                                        <td class="fs-12 fw-semibold text-body">10.24 ETH</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="/assets/images/user-83.png" style="width: 22px;" class="border border-1 box-shadow border-color-white rounded-circle" alt="user">
                                                                <span class="text-body fs-12 fw-semibold ms-2">12.08 ETH</span>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">1h : 23m : 17s</td>
                                                        <td class="text-end">
                                                            <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/nft-9.png" class="rounded-3" style="width: 50px; height: 50px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Awesome Bird</h4>
                                                                    <span class="fs-12">by Liveslong</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">8.15 ETH</td>
                                                        <td class="fs-12 fw-semibold text-body">7.15 ETH</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="/assets/images/user-84.png" style="width: 22px;" class="border border-1 box-shadow border-color-white rounded-circle" alt="user">
                                                                <span class="text-body fs-12 fw-semibold ms-2">8.08 ETH</span>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">4h : 14m : 54s</td>
                                                        <td class="text-end">
                                                            <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                                            <span class="fs-12 fw-medium">Showing 05 of 30 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/nft" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/nft">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/nft">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/nft">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/nft">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/nft" aria-label="Next">
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
                        <div class="col-lg-8 col-xxl-9">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                                <h3 class="mb-0">Featured NFT Artworks</h3>
                                <div class="nft-controller">
                                    <div class="controller-icon prev position-static" style="transform: unset;">
                                        <i class="ri-arrow-left-line"></i>
                                    </div>
                                    <div class="controller-icon next position-static" style="transform: unset;">
                                        <i class="ri-arrow-right-line"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper nft-slide-two mb-4">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                            <a href="#" class="d-block  mb-3 text-decoration-none position-relative">
                                                <img src="/assets/images/nft-10.png" class="rounded-3" alt="nft">
                                                <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                    Place Bid
                                                </span>
                                            </a>
            
                                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                                <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-76.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <span class="fs-12">NFT ID: 35246</span>
                                                        <h4 class="fw-semibold fs-14 mb-0">Christmas Eve</h4>
                                                    </div>
                                                </a>
                                                <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                            </div>
            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="#" class="d-flex align-items-center text-decoration-none">
                                                    <div class="flex-grow-1 ms-2">
                                                        <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">9.75 ETH</span></span>
                                                        <h4 class="fw-semibold fs-14 mb-0">5.50 ETH</h4>
                                                    </div>
                                                </a>
                                                <button class="bg-transparent p-0 border-0">
                                                    <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                    <span class="text-secondary fs-12 fw-semibold">9.2<span class="text-body">/10</span></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                            <a href="#" class="d-block mb-3 text-decoration-none position-relative">
                                                <img src="/assets/images/nft-11.png" class="rounded-3" alt="nft">
                                                <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                    Place Bid
                                                </span>
                                            </a>
            
                                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                                <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-77.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <span class="fs-12">NFT ID: 35247</span>
                                                        <h4 class="fw-semibold fs-14 mb-0">Humming Bird</h4>
                                                    </div>
                                                </a>
                                                <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                            </div>
            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="#" class="d-flex align-items-center text-decoration-none">
                                                    <div class="flex-grow-1 ms-2">
                                                        <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">10.75 ETH</span></span>
                                                        <h4 class="fw-semibold fs-14 mb-0">12.50 ETH</h4>
                                                    </div>
                                                </a>
                                                <button class="bg-transparent p-0 border-0">
                                                    <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                    <span class="text-secondary fs-12 fw-semibold">9.5<span class="text-body">/10</span></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                            <a href="#" class="d-block  mb-3 text-decoration-none position-relative">
                                                <img src="/assets/images/nft-12.png" class="rounded-3" alt="nft">
                                                <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                    Place Bid
                                                </span>
                                            </a>
            
                                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                                <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-85.png" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <span class="fs-12">NFT ID: 35228</span>
                                                        <h4 class="fw-semibold fs-14 mb-0">Naughty Pool</h4>
                                                    </div>
                                                </a>
                                                <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                            </div>
            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="#" class="d-flex align-items-center text-decoration-none">
                                                    <div class="flex-grow-1 ms-2">
                                                        <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">8.75 ETH</span></span>
                                                        <h4 class="fw-semibold fs-14 mb-0">9.50 ETH</h4>
                                                    </div>
                                                </a>
                                                <button class="bg-transparent p-0 border-0">
                                                    <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                    <span class="text-secondary fs-12 fw-semibold">9.7<span class="text-body">/10</span></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                            <a href="#" class="d-block  mb-3 text-decoration-none position-relative">
                                                <img src="/assets/images/nft-10.png" class="rounded-3" alt="nft">
                                                <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                    Place Bid
                                                </span>
                                            </a>
            
                                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                                <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-76.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <span class="fs-12">NFT ID: 35246</span>
                                                        <h4 class="fw-semibold fs-14 mb-0">Christmas Eve</h4>
                                                    </div>
                                                </a>
                                                <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                            </div>
            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="#" class="d-flex align-items-center text-decoration-none">
                                                    <div class="flex-grow-1 ms-2">
                                                        <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">9.75 ETH</span></span>
                                                        <h4 class="fw-semibold fs-14 mb-0">5.50 ETH</h4>
                                                    </div>
                                                </a>
                                                <button class="bg-transparent p-0 border-0">
                                                    <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                    <span class="text-secondary fs-12 fw-semibold">9.2<span class="text-body">/10</span></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                            <a href="#" class="d-block mb-3 text-decoration-none position-relative">
                                                <img src="/assets/images/nft-11.png" class="rounded-3" alt="nft">
                                                <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                    Place Bid
                                                </span>
                                            </a>
            
                                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                                <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-77.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <span class="fs-12">NFT ID: 35247</span>
                                                        <h4 class="fw-semibold fs-14 mb-0">Humming Bird</h4>
                                                    </div>
                                                </a>
                                                <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                            </div>
            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="#" class="d-flex align-items-center text-decoration-none">
                                                    <div class="flex-grow-1 ms-2">
                                                        <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">10.75 ETH</span></span>
                                                        <h4 class="fw-semibold fs-14 mb-0">12.50 ETH</h4>
                                                    </div>
                                                </a>
                                                <button class="bg-transparent p-0 border-0">
                                                    <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                    <span class="text-secondary fs-12 fw-semibold">9.5<span class="text-body">/10</span></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="bg-white rounded-3 border-0 p-3 place-bid for-dark-card">
                                            <a href="#" class="d-block  mb-3 text-decoration-none position-relative">
                                                <img src="/assets/images/nft-12.png" class="rounded-3" alt="nft">
                                                <span class="btn btn-primary py-2 px-3 d-inline-block fs-16 fw-medium position-absolute top-50 start-50 translate-middle opacity-0">
                                                    Place Bid
                                                </span>
                                            </a>
            
                                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                                <a href="c/reator-details" class="d-flex align-items-center text-decoration-none">
                                                    <div class="flex-shrink-0">
                                                        <img src="/assets/images/user-85.png" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <span class="fs-12">NFT ID: 35228</span>
                                                        <h4 class="fw-semibold fs-14 mb-0">Naughty Pool</h4>
                                                    </div>
                                                </a>
                                                <img src="/assets/images/verify.svg" class="cursor" alt="verify" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Verified"> 
                                            </div>
            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="#" class="d-flex align-items-center text-decoration-none">
                                                    <div class="flex-grow-1 ms-2">
                                                        <span class="fs-12 d-block mb-1">Highest Bid: <span class="fw-semibold text-secondary">8.75 ETH</span></span>
                                                        <h4 class="fw-semibold fs-14 mb-0">9.50 ETH</h4>
                                                    </div>
                                                </a>
                                                <button class="bg-transparent p-0 border-0">
                                                    <i class="ri-heart-fill fs-20 position-relative top-2" style="color: #EE3E08;"></i>
                                                    <span class="text-secondary fs-12 fw-semibold">9.7<span class="text-body">/10</span></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xxl-3">
                            <div class="for-dark rounded-3 p-4 text-center mb-4" style="background: linear-gradient(153deg, #FAD2D2 0%, #6FA3EC 100%);">
                               <div class="py-2">
                                    <h3 class="fs-20 fw-normal">Have You Tried Our</h3>
                                    <h3 class="fs-20 mb-1">New Mobile App?</h3>
                                    <div class="py-4 py-xxl-5">
                                        <img src="/assets/images/app-2.png" alt="app">
                                    </div>
                                    <a href="#" class="btn btn-primary py-2 px-3 fs-16 fw-medium">
                                        Download App
                                    </a>
                               </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-8 col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                                        <h3 class="mb-0">Most Popular Sellers</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color" aria-label="Default select example">
                                            <option selected>Monthly</option>
                                            <option value="1">Yearly</option>
                                        </select>
                                    </div>
                                    <div class="default-table-area style-two campaigns-table">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr class="border-bottom">
                                                        <th scope="col" class=" bg-transparent text-body fw-medium">
                                                            <span class="fs-12">SELLERS</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">DELIVERIES</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">EARNINGS</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">RATINGS</span>
                                                        </th>
                                                        <th scope="col" class="text-end bg-transparent text-body fw-medium">
                                                            <span class="fs-12">VIEW</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-81.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Christmas Eve</h4>
                                                                    <span class="fs-12">Queensland</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">6240</td>
                                                        <td class="fs-12 fw-semibold text-body">624 ETH</td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <span class="text-body">5.0</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-80.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Skyler White</h4>
                                                                    <span class="fs-12">Neverdies</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">5135</td>
                                                        <td class="fs-12 fw-semibold text-body">597 ETH</td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-half-fill text-warning"></i>
                                                                <span class="text-body">4.9</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-82.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Jonathon Watson</h4>
                                                                    <span class="fs-12">Emoticons</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">4321</td>
                                                        <td class="fs-12 fw-semibold text-body">413 ETH</td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-half-fill text-warning"></i>
                                                                <span class="text-body">4.8</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-83.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Walter White</h4>
                                                                    <span class="fs-12">Puzzleworld</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">3124</td>
                                                        <td class="fs-12 fw-semibold text-body">321 ETH</td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-half-fill text-warning"></i>
                                                                <span class="text-body">4.0</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-84.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">David Carlen</h4>
                                                                    <span class="fs-12">Liveslong</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">2137</td>
                                                        <td class="fs-12 fw-semibold text-body">246 ETH</td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-fill text-warning"></i>
                                                                <i class="ri-star-half-fill text-warning"></i>
                                                                <span class="text-body">4.5</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="#" class="rounded-circle d-inline-block text-center fs-18 hover-bg for-dark-read" style="background-color: #ECEEF2; width: 30px; height: 30px; line-height: 30px;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                                            <span class="fs-12 fw-medium">Showing 8 of 30 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/nft" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/nft">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/nft">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/nft">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/nft">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/nft" aria-label="Next">
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
                        <div class="col-xxl-4 col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                        <h3 class="mb-0">Worldwide Top Creators</h3>
                                        <div class="dropdown action-opt">
                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-horizontal"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="clock"></i>
                                                        Today
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="pie-chart"></i>
                                                        Last 7 Days
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="rotate-cw"></i>
                                                        Last Month
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="calendar"></i>
                                                        Last 1 Year
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="bar-chart"></i>
                                                        All Time
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="eye"></i>
                                                        View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="trash"></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="text-center" style="margin: 49px 0;">
                                        <div id="worldwide_top_creators_map"></div>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled">
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/united-states-3.png" style="width: 24px;" alt="united-states">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-12 fw-semibold lh-1">United States</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 85%; height: 8px; background-color: #757DFF;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">85%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/japan.png" style="width: 24px;" alt="japan">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-12 fw-semibold lh-1">Japan</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 65%; height: 8px; background-color: #0F79F3;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">65%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/australia-2.png" style="width: 24px;" alt="australia">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-12 fw-semibold lh-1">Australia</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 45%; height: 8px; background-color: #9135E8;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">45%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/germany-2.png" style="width: 24px;" alt="germany">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-12 fw-semibold lh-1">Germany</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 75%; height: 8px; background-color: #25B003;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">75%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-3 col-sm-6 order-2 order-xxl-1">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="mb-4 d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                        <h3 class="mb-0">Top Collections</h3>
                                        <a href="#" class="text-decoration-none text-primary fs-12">View More</a>
                                    </div>

                                    <div class="swiper top-collections-slide">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="position-relative z-1">
                                                    <a href="#" class="d-block position-relative">
                                                        <img src="/assets/images/collections.png" class="rounded-3" alt="collections">
                                                        <img src="/assets/images/collections.gif" class="rounded-3 position-absolute top-0 start-0 end-0 bottom-0" alt="collections">
                                                    </a>
                                                    <div class="position-absolute bottom-0 start-50 translate-middle-x w-100 p-2">
                                                        <div class="rounded-3 p-3 d-flex justify-content-between align-items-center" style="background: rgba(35, 39, 46, 0.70); backdrop-filter: blur(6px);">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 position-relative">
                                                                    <img src="/assets/images/user-76.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                                    <img src="/assets/images/verify-2.svg" style="width: 15px;" class="position-absolute top-100 start-100 translate-middle" alt="verify">
                                                                </div>
                                                                <div class="flex-grow-1 ms-4 position-relative top-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-white">Christmas Eve</h4>
                                                                    <span class="fs-12" style="color: #B1BBC8;">3250 Items</span>
                                                                </div>
                                                            </div>
                                                            <a href="#" class="d-inline-block text-secondary text-center rounded-circle text-decoration-none fs-16 hover-bg" style="width: 30px; height: 30px; line-height: 30px; background-color: #8695AA;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="position-relative z-1">
                                                    <a href="#" class="d-block position-relative">
                                                        <img src="/assets/images/collections-2.png" class="rounded-3" alt="collections">
                                                    </a>
                                                    <div class="position-absolute bottom-0 start-50 translate-middle-x w-100 p-2">
                                                        <div class="rounded-3 p-3 d-flex justify-content-between align-items-center" style="background: rgba(35, 39, 46, 0.70); backdrop-filter: blur(6px);">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 position-relative">
                                                                    <img src="/assets/images/user-76.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                                    <img src="/assets/images/verify-2.svg" style="width: 15px;" class="position-absolute top-100 start-100 translate-middle" alt="verify">
                                                                </div>
                                                                <div class="flex-grow-1 ms-4 position-relative top-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-white">Walking Brain</h4>
                                                                    <span class="fs-12" style="color: #B1BBC8;">2230 Items</span>
                                                                </div>
                                                            </div>
                                                            <a href="#" class="d-inline-block text-secondary text-center rounded-circle text-decoration-none fs-16 hover-bg" style="width: 30px; height: 30px; line-height: 30px; background-color: #8695AA;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="position-relative z-1">
                                                    <a href="#" class="d-block position-relative">
                                                        <img src="/assets/images/collections-3.png" class="rounded-3" alt="collections">
                                                    </a>
                                                    <div class="position-absolute bottom-0 start-50 translate-middle-x w-100 p-2">
                                                        <div class="rounded-3 p-3 d-flex justify-content-between align-items-center" style="background: rgba(35, 39, 46, 0.70); backdrop-filter: blur(6px);">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 position-relative">
                                                                    <img src="/assets/images/user-76.gif" class="rounded-circle" style="width: 27px; height: 27px;" alt="user">
                                                                    <img src="/assets/images/verify-2.svg" style="width: 15px;" class="position-absolute top-100 start-100 translate-middle" alt="verify">
                                                                </div>
                                                                <div class="flex-grow-1 ms-4 position-relative top-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0 text-white">Flying Flower</h4>
                                                                    <span class="fs-12" style="color: #B1BBC8;">8536 Items</span>
                                                                </div>
                                                            </div>
                                                            <a href="#" class="d-inline-block text-secondary text-center rounded-circle text-decoration-none fs-16 hover-bg" style="width: 30px; height: 30px; line-height: 30px; background-color: #8695AA;">
                                                                <i class="ri-arrow-right-line"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-pagination-top-collections text-center mt-2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-lg-12 order-1 order-xxl-2">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                                        <h3 class="mb-0">Top NFTs</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color" aria-label="Default select example">
                                            <option selected>Monthly</option>
                                            <option value="1">Yearly</option>
                                        </select>
                                    </div>

                                    <div class="default-table-area style-two top-nfts-table">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr class="border-bottom">
                                                        <th scope="col" class=" bg-transparent text-body fw-medium">
                                                            <span class="fs-12">SELLERS</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">VOLUME</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">FLOW PRICE</span>
                                                        </th>
                                                        <th scope="col" class="text-end bg-transparent text-body fw-medium">
                                                            <span class="fs-12">STATUS</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/sellers-1.gif" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Christmas Eve</h4>
                                                                    <span class="fs-12">Queensland</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">6240</td>
                                                        <td class="fs-12 fw-semibold text-body">624 ETH</td>
                                                        <td class="text-end">
                                                            <span class="bg-success text-success py-1 px-3 border border-success rounded-pill bg-opacity-10 fs-12">+5.4%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/sellers-2.gif" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Walking Brain</h4>
                                                                    <span class="fs-12">@neverdies</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">5135</td>
                                                        <td class="fs-12 fw-semibold text-body">597 ETH</td>
                                                        <td class="text-end">
                                                            <span class="bg-danger text-danger py-1 px-3 border border-danger rounded-pill bg-opacity-10 fs-12">-3.2%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/sellers-3.gif" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Flying Flower</h4>
                                                                    <span class="fs-12">@emoticons</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">4321</td>
                                                        <td class="fs-12 fw-semibold text-body">413 ETH</td>
                                                        <td class="text-end">
                                                            <span class="bg-success text-success py-1 px-3 border border-success rounded-pill bg-opacity-10 fs-12">+2.5%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/sellers-4.gif" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Living Robot</h4>
                                                                    <span class="fs-12">@puzzleworld</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">3124</td>
                                                        <td class="fs-12 fw-semibold text-body">321 ETH</td>
                                                        <td class="text-end">
                                                            <span class="bg-danger text-danger py-1 px-3 border border-danger rounded-pill bg-opacity-10 fs-12">-1.5%</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/sellers-5.gif" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-1">Thumbs Up</h4>
                                                                    <span class="fs-12">@liveslong</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">2137</td>
                                                        <td class="fs-12 fw-semibold text-body">246 ETH</td>
                                                        <td class="text-end">
                                                            <span class="bg-success text-success py-1 px-3 border border-success rounded-pill bg-opacity-10 fs-12">+5.4%</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                                            <span class="fs-12 fw-medium">Showing 8 of 30 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/nft" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/nft">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/nft">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/nft">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/nft">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/nft" aria-label="Next">
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
                        <div class="col-xxl-3 col-sm-6 order-3 order-xxl-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                                        <h3 class="mb-0">History Of Bids</h3>
                                        <div class="dropdown action-opt">
                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="clock"></i>
                                                        Today
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="pie-chart"></i>
                                                        Last 7 Days
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="rotate-cw"></i>
                                                        Last Month
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="calendar"></i>
                                                        Last 1 Year
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="bar-chart"></i>
                                                        All Time
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="eye"></i>
                                                        View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="trash"></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="default-table-area style-two history-of-bids">
                                        <div class="table-responsive" data-simplebar>
                                            <table class="table align-middle border-0">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-86.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Johhna Loren</h4>
                                                                    <span class="fs-12">@queensland</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body text-end">624 ETH</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-87.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Zara Loren</h4>
                                                                    <span class="fs-12">@queensland</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body text-end">121.1 ETH</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-88.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Walter White</h4>
                                                                    <span class="fs-12">@queensland</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body text-end">24.78 ETH</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-89.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Viktor James</h4>
                                                                    <span class="fs-12">@queensland</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body text-end">72.8 ETH</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-90.png" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Zinia Loren</h4>
                                                                    <span class="fs-12">@queensland</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body text-end">986 ETH</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-60.jpg" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">ALex Dew</h4>
                                                                    <span class="fs-12">@queensland</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body text-end">4857 ETH</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-61.jpg" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Juhon Smith</h4>
                                                                    <span class="fs-12">@queensland</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body text-end">7854 ETH</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-62.jpg" class="rounded-circle" style="width: 32px; height: 32px;" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Kilva Dew</h4>
                                                                    <span class="fs-12">@queensland</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body text-end">9864 ETH</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen w-100 p-lg-5">
                        <div class="modal-content">
                            <div class="modal-header border-0 p-4 p-md-5 pb-0 border-bottom">
                                <h1 class="modal-title fs-24" id="exampleModalLabel">Create NFT</h1>
                                <button type="button" class="btn-close campaigns-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4 p-md-5">
                                <form class="campaign-stepper-content m-auto" style="max-width: 1208px;">
                                    <h3 class="fs-18 mb-4">Upload Image, Video, Audio, or 3D Model</h3>
                
                                    <div class="mb-4 only-file-upload">
                                        <div class="d-flex align-items-center position-relative z-1 bg-border-color p-4 rounded-2" style="border: 2px dashed #5DA8FF;">
                                            <div class="flex-shrink-0">
                                                <img src="/assets/images/upload.png" alt="upload">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="fs-16">Drop campaign files here or click to upload.</h4>
                                                <p>Upload upto 12 files, max size each file: 5MB.</p>
                                            </div>
                                            <label class="position-absolute top-0 bottom-0 start-0 end-0 cursor" id="upload-container">
                                                <input class="form__file bottom-0" id="upload-files" type="file" multiple="multiple">
                                            </label>
                                        </div>
                                        <div id="files-list-container"></div>
                                    </div>
            
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-border-color h-55 fs-16" placeholder="Christmas Eve">
                                    </div>

                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Description</label>
                                        <textarea class="form-control bg-border-color fs-16" rows="5" placeholder="Enter Description"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-4">
                                                <label class="fw-semibold mb-2">Item Price</label>
                                                <input type="text" class="form-control bg-border-color h-55 fs-16" placeholder="12.50 ETH">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-4">
                                                <label class="fw-semibold mb-2">Size</label>
                                                <input type="text" class="form-control bg-border-color h-55 fs-16" placeholder="2.50 MB">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-4">
                                                <label class="fw-semibold mb-2">Properties</label>
                                                <input type="text" class="form-control bg-border-color h-55 fs-16" placeholder="Enter Link">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">External Link</label>
                                        <textarea class="form-control bg-border-color fs-16" rows="5" placeholder="Enter Description"></textarea>
                                    </div>

                                    <div class="d-flex flex-wrap gap-3 mb-4">
                                        <div class="d-flex align-items-center form-check style">
                                            <div class="flex-shrink-0">
                                                <input class="form-check-input" type="radio" style="width: 20px; height: 20px;" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <label class="form-check-label ps-0 fs-14 fw-medium text-secondary" for="flexRadioDefault1">
                                                    Put On Sale
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center form-check style">
                                            <div class="flex-shrink-0">
                                                <input class="form-check-input" type="radio" style="width: 20px; height: 20px;" name="flexRadioDefault" id="flexRadioDefault2">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <label class="form-check-label ps-0 fs-14 fw-medium text-secondary" for="flexRadioDefault2">
                                                    Instant Sale Price
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center form-check style">
                                            <div class="flex-shrink-0">
                                                <input class="form-check-input" type="radio" style="width: 20px; height: 20px;" name="flexRadioDefault" id="flexRadioDefault3">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <label class="form-check-label ps-0 fs-14 fw-medium text-secondary" for="flexRadioDefault3">
                                                    Unlock One Purchased
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary py-2 px-4">Create NFT</button>
                                    </div>
                                </form>
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