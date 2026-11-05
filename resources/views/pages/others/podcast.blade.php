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

				<div class="main-content-container overflow-hidden" id="audio_control2">
                    <div class="row">
                        <div class="col-xxl-8">
                            <div class="border-0 rounded-3 border position-relative z-1 mb-4 play-for-rtl" style="background: linear-gradient(84deg, #23272E 3.5%, #526077 94.93%);">
                                <div class="swiper-pagination-mastering-digital-marketing"></div>
                                <div class="swiper mastering-digital-marketing-slide">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="card-body px-4" style="padding-top: 37px; padding-bottom: 24px;">
                                                <span class="bg-body-color-50 d-inline-block text-white fd-12 fw-medium rounded-pill mb-2" style="padding: 0 11px;">Featured</span>
                                                <h3 class="fs-28 fw-medium text-body-bg mb-1">Mastering Digital Marketing</h3>
                                                <p class="text-light" style="max-width: 370px; margin-bottom: 18px;">Learn the latest digital marketing strategies with insights from SEO expert James Lee.</p>
                                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                                    <div class="d-flex align-items-center rounded-pill" style="border: 1px solid #64748B; padding: 3.5px 12px;">
                                                        <span class="fs-14 fw-semibold text-body-bg">Host:</span>
                                                        <span class="ms-2 text-body-bg">Sarah J.</span>
                                                    </div>
                                                    <div class="d-flex align-items-center rounded-pill" style="border: 1px solid #64748B; padding: 3.5px 12px;">
                                                        <span class="fs-14 fw-semibold text-body-bg">Guest:</span>
                                                        <span class="ms-2 text-body-bg">James Lee, SEO Expert</span>
                                                    </div>
                                                </div>

                                                <div class="audio-player-for-wave" style="padding: 47px 0;">
                                                    <div class="d-sm-flex align-items-center">
                                                        <button class="play-button border-0 rounded-circle d-inline-block" style="background-color: #C2CDFF; width: 44px; height: 44px; line-height: 43px;">
                                                            <i class="play-icon ri-play-large-fill text-primary fs-28 position-relative" style="left: 2px;"></i>
                                                        </button>
                                                        <div class="ms-sm-3 mt-3 mt-sm-0">
                                                            <div class="d-flex align-items-center justify-content-between width-form-mobile" style="width: 325px;">
                                                                <div class="wave-container d-flex align-items-end">
                                                                    <!-- Wave Bars -->
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <!-- Add more wave bars as needed -->
                                                                </div>
                                                                <span class="duration text-white">00:00</span>
                                                            </div>
                                                            <div class="progress" role="progressbar" aria-label="Audio Progress" style="height: 4px; background-color: #8695AA;">
                                                                <div class="progress-bar" style="width: 0%; height: 4px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <audio class="audio-element" src="https://cldup.com/qR72ozoaiQ.mp3" style="left: 0;"></audio>
                                                </div>
                                                
                                                
                                                <div class="d-flex flex-wrap gap-4 align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-customer-service-line fs-28 text-primary lh-1 position-relative top-2"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <span class="text-light fs-12 fw-semibold lh-1">Listens</span>
                                                            <span class="d-block text-white fs-14 fw-medium lh-1">8,200</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-thumb-up-line fs-28 text-primary lh-1 position-relative top-2"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <span class="text-light fs-12 fw-semibold lh-1">Likes</span>
                                                            <span class="d-block text-white fs-14 fw-medium lh-1">1,500</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-share-line fs-28 text-primary lh-1 position-relative top-2"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <span class="text-light fs-12 fw-semibold lh-1">Shares</span>
                                                            <span class="d-block text-white fs-14 fw-medium lh-1">350</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-bookmark-line fs-28 text-primary lh-1 position-relative top-2"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <span class="text-light fs-12 fw-semibold lh-1">Save for</span>
                                                            <span class="d-block text-white fs-14 fw-medium lh-1">Later</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="/assets/images/shape-15.png" class="position-absolute bottom-0 end-0 z-n1 for-rtl-shape d-none d-md-block" alt="shape">
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="card-body px-4" style="padding-top: 37px; padding-bottom: 24px;">
                                                <span class="bg-body-color-50 d-inline-block text-white fd-12 fw-medium rounded-pill mb-2" style="padding: 0 11px;">Featured</span>
                                                <h3 class="fs-28 fw-medium text-body-bg mb-1">Content Marketing Essentials</h3>
                                                <p class="text-light" style="max-width: 370px; margin-bottom: 18px;">This episode covers creating impactful content that resonates with audiences.</p>
                                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                                    <div class="d-flex align-items-center rounded-pill" style="border: 1px solid #64748B; padding: 3.5px 12px;">
                                                        <span class="fs-14 fw-semibold text-body-bg">Host:</span>
                                                        <span class="ms-2 text-body-bg">Tom R.</span>
                                                    </div>
                                                    <div class="d-flex align-items-center rounded-pill" style="border: 1px solid #64748B; padding: 3.5px 12px;">
                                                        <span class="fs-14 fw-semibold text-body-bg">Guest:</span>
                                                        <span class="ms-2 text-body-bg">Lisa Kim</span>
                                                    </div>
                                                </div>

                                                <div class="audio-player-for-wave" style="padding: 47px 0;">
                                                    <div class="d-sm-flex align-items-center">
                                                        <button class="play-button border-0 rounded-circle d-inline-block" style="background-color: #C2CDFF; width: 44px; height: 44px; line-height: 43px;">
                                                            <i class="play-icon ri-play-large-fill text-primary fs-28 position-relative" style="left: 2px;"></i>
                                                        </button>
                                                        <div class="ms-sm-3 mt-3 mt-sm-0">
                                                            <div class="d-flex align-items-center justify-content-between width-form-mobile" style="width: 325px;">
                                                                <div class="wave-container d-flex align-items-end">
                                                                    <!-- Wave Bars -->
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <!-- Add more wave bars as needed -->
                                                                </div>
                                                                <span class="duration text-white">00:00</span>
                                                            </div>
                                                            <div class="progress" role="progressbar" aria-label="Audio Progress" style="height: 4px; background-color: #8695AA;">
                                                                <div class="progress-bar" style="width: 0%; height: 4px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <audio class="audio-element" src="https://cldup.com/qR72ozoaiQ.mp3" style="left: 0;"></audio>
                                                </div>
                                                
                                                <div class="d-flex flex-wrap gap-4 align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-customer-service-line fs-28 text-primary lh-1 position-relative top-2"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <span class="text-light fs-12 fw-semibold lh-1">Listens</span>
                                                            <span class="d-block text-white fs-14 fw-medium lh-1">8,200</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-thumb-up-line fs-28 text-primary lh-1 position-relative top-2"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <span class="text-light fs-12 fw-semibold lh-1">Likes</span>
                                                            <span class="d-block text-white fs-14 fw-medium lh-1">1,500</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-share-line fs-28 text-primary lh-1 position-relative top-2"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <span class="text-light fs-12 fw-semibold lh-1">Shares</span>
                                                            <span class="d-block text-white fs-14 fw-medium lh-1">350</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-bookmark-line fs-28 text-primary lh-1 position-relative top-2"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <span class="text-light fs-12 fw-semibold lh-1">Save for</span>
                                                            <span class="d-block text-white fs-14 fw-medium lh-1">Later</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="/assets/images/shape-16.png" class="position-absolute bottom-0 end-0 z-n1 for-rtl-shape d-none d-md-block" alt="shape">
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="card-body px-4" style="padding-top: 37px; padding-bottom: 24px;">
                                                <span class="bg-body-color-50 d-inline-block text-white fd-12 fw-medium rounded-pill mb-2" style="padding: 0 11px;">Featured</span>
                                                <h3 class="fs-28 fw-medium text-body-bg mb-1">Social Media Trends</h3>
                                                <p class="text-light" style="max-width: 370px; margin-bottom: 18px;">Learn the latest digital marketing strategies with insights from SEO expert James Lee.</p>
                                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                                    <div class="d-flex align-items-center rounded-pill" style="border: 1px solid #64748B; padding: 3.5px 12px;">
                                                        <span class="fs-14 fw-semibold text-body-bg">Host:</span>
                                                        <span class="ms-2 text-body-bg">Amanda G.</span>
                                                    </div>
                                                    <div class="d-flex align-items-center rounded-pill" style="border: 1px solid #64748B; padding: 3.5px 12px;">
                                                        <span class="fs-14 fw-semibold text-body-bg">Guest:</span>
                                                        <span class="ms-2 text-body-bg">David Chen</span>
                                                    </div>
                                                </div>

                                                <div class="audio-player-for-wave" style="padding: 47px 0;">
                                                    <div class="d-sm-flex align-items-center">
                                                        <button class="play-button border-0 rounded-circle d-inline-block" style="background-color: #C2CDFF; width: 44px; height: 44px; line-height: 43px;">
                                                            <i class="play-icon ri-play-large-fill text-primary fs-28 position-relative" style="left: 2px;"></i>
                                                        </button>
                                                        <div class="ms-sm-3 mt-3 mt-sm-0">
                                                            <div class="d-flex align-items-center justify-content-between width-form-mobile" style="width: 325px;">
                                                                <div class="wave-container d-flex align-items-end">
                                                                    <!-- Wave Bars -->
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <span class="wave-bar d-none-form-mobile"></span>
                                                                    <!-- Add more wave bars as needed -->
                                                                </div>
                                                                <span class="duration text-white">00:00</span>
                                                            </div>
                                                            <div class="progress" role="progressbar" aria-label="Audio Progress" style="height: 4px; background-color: #8695AA;">
                                                                <div class="progress-bar" style="width: 0%; height: 4px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <audio class="audio-element" src="https://cldup.com/qR72ozoaiQ.mp3" style="left: 0;"></audio>
                                                </div>
                                                
                                                <div class="d-flex flex-wrap gap-4 align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-customer-service-line fs-28 text-primary lh-1 position-relative top-2"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <span class="text-light fs-12 fw-semibold lh-1">Listens</span>
                                                            <span class="d-block text-white fs-14 fw-medium lh-1">8,200</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-thumb-up-line fs-28 text-primary lh-1 position-relative top-2"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <span class="text-light fs-12 fw-semibold lh-1">Likes</span>
                                                            <span class="d-block text-white fs-14 fw-medium lh-1">1,500</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-share-line fs-28 text-primary lh-1 position-relative top-2"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <span class="text-light fs-12 fw-semibold lh-1">Shares</span>
                                                            <span class="d-block text-white fs-14 fw-medium lh-1">350</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-bookmark-line fs-28 text-primary lh-1 position-relative top-2"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <span class="text-light fs-12 fw-semibold lh-1">Save for</span>
                                                            <span class="d-block text-white fs-14 fw-medium lh-1">Later</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="/assets/images/shape-17.png" class="position-absolute bottom-0 end-0 z-n1 for-rtl-shape d-none d-md-block" alt="shape">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4" style="padding-bottom: 24px;">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 custom-padding-30 position-relative pb-3" style="top: -5px;">
                                    <h3 class="mb-0 fs-18 fw-semibold">Popular Hosts</h3>
                                    <button class="bg-transparent border-0 p-0 d-flex align-items-center text-decoration-none position-relative right-for-rtl text-body" style="right: -8px;">
                                        <span>View All</span>
                                        <i class="ri-arrow-right-s-line fs-24 position-relative top-1 lh-1 text-body"></i>
                                    </button>
                                </div>

                                <div class="default-table-area style-three popular-hosts">
                                    <div class="table-responsive">
                                        <table class="table align-middle border-0">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-124.png" style="width: 40px; height: 40px;" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-10">
                                                                <h4 class="fs-14 fw-medium mb-0">Sarah W.</h4>
                                                                <span class="fs-12 text-body fw-normal">Marketing</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="d-block fs-14 fw-medium">25</span>
                                                        <span class="d-block fs-12 fw-normal text-body">Hosted</span>
                                                    </td> 
                                                    <td class="text-end">
                                                        <button class="border-0 text-primary follow-button fs-14" style="background-color: #ECF0FF; padding: 4.5px 10px; border-radius: 4px;">
                                                            <span class="follow-text position-relative" style="top: -1px;">Follow</span>
                                                        </button>
                                                    </td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-125.png" style="width: 40px; height: 40px;" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-10">
                                                                <h4 class="fs-14 fw-medium mb-0">Tom R.</h4>
                                                                <span class="fs-12 text-body fw-normal">Blogging</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="d-block fs-14 fw-medium">30</span>
                                                        <span class="d-block fs-12 fw-normal text-body">Hosted</span>
                                                    </td> 
                                                    <td class="text-end">
                                                        <button class="border-0 text-primary follow-button fs-14" style="background-color: #ECF0FF; padding: 4.5px 10px; border-radius: 4px;">
                                                            <span class="follow-text position-relative" style="top: -1px;">Follow</span>
                                                        </button>
                                                    </td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-126.png" style="width: 40px; height: 40px;" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-10">
                                                                <h4 class="fs-14 fw-medium mb-0">Amanda G.</h4>
                                                                <span class="fs-12 text-body fw-normal">Branding</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="d-block fs-14 fw-medium">28</span>
                                                        <span class="d-block fs-12 fw-normal text-body">Hosted</span>
                                                    </td> 
                                                    <td class="text-end">
                                                        <button class="border-0 text-primary follow-button fs-14 followed" style="background-color: #ECF0FF; padding: 4.5px 10px; border-radius: 4px;">
                                                            <span class="follow-text position-relative" style="top: -1px;">Following</span>
                                                        </button>
                                                    </td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-127.png" style="width: 40px; height: 40px;" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-10">
                                                                <h4 class="fs-14 fw-medium mb-0">Lisa Kim</h4>
                                                                <span class="fs-12 text-body fw-normal">Storytelling</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="d-block fs-14 fw-medium">20</span>
                                                        <span class="d-block fs-12 fw-normal text-body">Hosted</span>
                                                    </td> 
                                                    <td class="text-end">
                                                        <button class="border-0 text-primary follow-button fs-14" style="background-color: #ECF0FF; padding: 4.5px 10px; border-radius: 4px;">
                                                            <span class="follow-text position-relative" style="top: -1px;">Follow</span>
                                                        </button>
                                                    </td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-128.png" style="width: 40px; height: 40px;" class="rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-10">
                                                                <h4 class="fs-14 fw-medium mb-0">David C.</h4>
                                                                <span class="fs-12 text-body fw-normal">Social Media</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="d-block fs-14 fw-medium">18</span>
                                                        <span class="d-block fs-12 fw-normal text-body">Hosted</span>
                                                    </td> 
                                                    <td class="text-end">
                                                        <button class="border-0 text-primary follow-button fs-14" style="background-color: #ECF0FF; padding: 4.5px 10px; border-radius: 4px;">
                                                            <span class="follow-text position-relative" style="top: -1px;">Follow</span>
                                                        </button>
                                                    </td> 
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4" style="padding-bottom: 16px;">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 custom-padding-30 position-relative pb-3" style="top: -5px;">
                                    <h3 class="mb-0 fs-18 fw-semibold">Recently Played</h3>
                                    <button class="bg-transparent border-0 p-0 d-flex align-items-center text-decoration-none position-relative right-for-rtl text-body" style="right: -8px;">
                                        <span>View All</span>
                                        <i class="ri-arrow-right-s-line fs-24 position-relative top-1 lh-1 text-body"></i>
                                    </button>
                                </div>

                                <div class="default-table-area style-three recently-played">
                                    <div class="table-responsive">
                                        <table class="table align-middle border-0">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <button class="p-0 border-0 bg-transparent me-3">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/played-1.jpg" style="width: 34px; height: 34px;" class="rounded-1" alt="played">
                                                                </div>
                                                                <div class="flex-grow-1 ms-10">
                                                                    <h4 class="fs-14 fw-medium mb-0">Mastering Digital Marketing</h4>
                                                                    <span class="fs-12 text-body fw-normal">Sarah Johnson</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="d-block fs-14 fw-normal text-body">Played 40 min. ago</span>
                                                    </td> 
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-customer-service-line text-primary fs-18"></i>
                                                            <span class="d-block fs-14 fw-normal text-body ms-10">8,200</span>
                                                        </div>
                                                    </td> 
                                                    <td>
                                                        <button class="favorite-button border-0 text-body-color-60 fs-14 bg-transparent p-0">
                                                            <span class="favorite-icon position-relative">
                                                                <i class="ri-heart-line fs-20"></i>
                                                                <i class="ri-heart-fill fs-20 position-absolute top-50 start-50 translate-middle text-primary"></i>
                                                            </span>
                                                        </button>
                                                    </td> 
                                                    <td>
                                                        <span class="text-body">45:30</span>
                                                    </td> 
                                                    <td>
                                                        <div class="dropdown action-opt">
                                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i data-feather="more-horizontal"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="plus"></i>
                                                                        Add To Playlist
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="file"></i>
                                                                        Go To Album
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="speaker"></i>
                                                                        View Credits
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <button class="p-0 border-0 bg-transparent me-3">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/played-2.jpg" style="width: 34px; height: 34px;" class="rounded-1" alt="played">
                                                                </div>
                                                                <div class="flex-grow-1 ms-10">
                                                                    <h4 class="fs-14 fw-medium mb-0">Content Marketing Essentials</h4>
                                                                    <span class="fs-12 text-body fw-normal">Tom Richards</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="d-block fs-14 fw-normal text-body">Played 1 h. ago</span>
                                                    </td> 
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-customer-service-line text-primary fs-18"></i>
                                                            <span class="d-block fs-14 fw-normal text-body ms-10">9,500</span>
                                                        </div>
                                                    </td> 
                                                    <td>
                                                        <button class="favorite-button border-0 text-body-color-60 fs-14 bg-transparent p-0">
                                                            <span class="favorite-icon position-relative">
                                                                <i class="ri-heart-line fs-20"></i>
                                                                <i class="ri-heart-fill fs-20 position-absolute top-50 start-50 translate-middle text-primary"></i>
                                                            </span>
                                                        </button>
                                                    </td> 
                                                    <td>
                                                        <span class="text-body">25:50</span>
                                                    </td> 
                                                    <td>
                                                        <div class="dropdown action-opt">
                                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i data-feather="more-horizontal"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="plus"></i>
                                                                        Add To Playlist
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="file"></i>
                                                                        Go To Album
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="speaker"></i>
                                                                        View Credits
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <button class="p-0 border-0 bg-transparent me-3">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/played-3.jpg" style="width: 34px; height: 34px;" class="rounded-1" alt="played">
                                                                </div>
                                                                <div class="flex-grow-1 ms-10">
                                                                    <h4 class="fs-14 fw-medium mb-0">Social Media Trends for 2024</h4>
                                                                    <span class="fs-12 text-body fw-normal">David Chen</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="d-block fs-14 fw-normal text-body">Played 1 day ago</span>
                                                    </td> 
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-customer-service-line text-primary fs-18"></i>
                                                            <span class="d-block fs-14 fw-normal text-body ms-10">7,400</span>
                                                        </div>
                                                    </td> 
                                                    <td>
                                                        <button class="favorite-button border-0 text-body-color-60 fs-14 bg-transparent p-0">
                                                            <span class="favorite-icon position-relative">
                                                                <i class="ri-heart-line fs-20"></i>
                                                                <i class="ri-heart-fill fs-20 position-absolute top-50 start-50 translate-middle text-primary"></i>
                                                            </span>
                                                        </button>
                                                    </td> 
                                                    <td>
                                                        <span class="text-body">30:20</span>
                                                    </td> 
                                                    <td>
                                                        <div class="dropdown action-opt">
                                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i data-feather="more-horizontal"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="plus"></i>
                                                                        Add To Playlist
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="file"></i>
                                                                        Go To Album
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="speaker"></i>
                                                                        View Credits
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <button class="p-0 border-0 bg-transparent me-3">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/played-4.jpg" style="width: 34px; height: 34px;" class="rounded-1" alt="played">
                                                                </div>
                                                                <div class="flex-grow-1 ms-10">
                                                                    <h4 class="fs-14 fw-medium mb-0">Building Brand Loyalty</h4>
                                                                    <span class="fs-12 text-body fw-normal">Michael Young</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="d-block fs-14 fw-normal text-body">Played 2 days ago</span>
                                                    </td> 
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-customer-service-line text-primary fs-18"></i>
                                                            <span class="d-block fs-14 fw-normal text-body ms-10">10,200</span>
                                                        </div>
                                                    </td> 
                                                    <td>
                                                        <button class="favorite-button border-0 text-body-color-60 fs-14 bg-transparent p-0">
                                                            <span class="favorite-icon position-relative">
                                                                <i class="ri-heart-line fs-20"></i>
                                                                <i class="ri-heart-fill fs-20 position-absolute top-50 start-50 translate-middle text-primary"></i>
                                                            </span>
                                                        </button>
                                                    </td> 
                                                    <td>
                                                        <span class="text-body">15:35</span>
                                                    </td> 
                                                    <td>
                                                        <div class="dropdown action-opt">
                                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i data-feather="more-horizontal"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="plus"></i>
                                                                        Add To Playlist
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="file"></i>
                                                                        Go To Album
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="speaker"></i>
                                                                        View Credits
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <button class="p-0 border-0 bg-transparent me-3">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/played-5.jpg" style="width: 34px; height: 34px;" class="rounded-1" alt="played">
                                                                </div>
                                                                <div class="flex-grow-1 ms-10">
                                                                    <h4 class="fs-14 fw-medium mb-0">Content Creation Techniques</h4>
                                                                    <span class="fs-12 text-body fw-normal">Lisa Kim</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="d-block fs-14 fw-normal text-body">Played 3 days ago</span>
                                                    </td> 
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-customer-service-line text-primary fs-18"></i>
                                                            <span class="d-block fs-14 fw-normal text-body ms-10">9,300</span>
                                                        </div>
                                                    </td> 
                                                    <td>
                                                        <button class="favorite-button border-0 text-body-color-60 fs-14 bg-transparent p-0">
                                                            <span class="favorite-icon position-relative">
                                                                <i class="ri-heart-line fs-20"></i>
                                                                <i class="ri-heart-fill fs-20 position-absolute top-50 start-50 translate-middle text-primary"></i>
                                                            </span>
                                                        </button>
                                                    </td> 
                                                    <td>
                                                        <span class="text-body">18:45</span>
                                                    </td> 
                                                    <td>
                                                        <div class="dropdown action-opt">
                                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i data-feather="more-horizontal"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="plus"></i>
                                                                        Add To Playlist
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="file"></i>
                                                                        Go To Album
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="speaker"></i>
                                                                        View Credits
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td> 
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <button class="p-0 border-0 bg-transparent me-3">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/played-6.jpg" style="width: 34px; height: 34px;" class="rounded-1" alt="played">
                                                                </div>
                                                                <div class="flex-grow-1 ms-10">
                                                                    <h4 class="fs-14 fw-medium mb-0">The Future of AI in Marketing</h4>
                                                                    <span class="fs-12 text-body fw-normal">Tom Richards</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="d-block fs-14 fw-normal text-body">Played 4 days ago</span>
                                                    </td> 
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-customer-service-line text-primary fs-18"></i>
                                                            <span class="d-block fs-14 fw-normal text-body ms-10">6,300</span>
                                                        </div>
                                                    </td> 
                                                    <td>
                                                        <button class="favorite-button border-0 text-body-color-60 fs-14 bg-transparent p-0">
                                                            <span class="favorite-icon position-relative">
                                                                <i class="ri-heart-line fs-20"></i>
                                                                <i class="ri-heart-fill fs-20 position-absolute top-50 start-50 translate-middle text-primary"></i>
                                                            </span>
                                                        </button>
                                                    </td> 
                                                    <td>
                                                        <span class="text-body">22:15</span>
                                                    </td> 
                                                    <td>
                                                        <div class="dropdown action-opt">
                                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i data-feather="more-horizontal"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="plus"></i>
                                                                        Add To Playlist
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="file"></i>
                                                                        Go To Album
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="speaker"></i>
                                                                        View Credits
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td> 
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4 custom-padding-30 pb-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 position-relative mb-3" style="top: -5px;">
                                    <h3 class="mb-0 fs-18 fw-semibold">Player</h3>
                                    <div class="dropdown action-opt right-for-rtl" style="right: -8px;">
                                        <button class="btn bg-transparent p-0 text-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical" style="stroke: #64748B;"></i>
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
    
                                <div style="margin-bottom: 20px;">
                                    <img src="/assets/images/player.png" class="rounded-3 d-lg-none w-100" alt="player">
                                    <div class="bg-img rounded-3 d-none d-lg-block" style="background-image: url(/assets/images/player.png); background-position: top center; height: 201px;"></div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 20px;">
                                    <div class="">
                                        <h4 class="fs-14 fw-medium text-secondary mb-0">Building an Online Presence</h4>
                                        <span class="fs-12">Ethan Cooper</span>
                                    </div>

                                    <button class="favorite-button border-0 text-body-color-60 fs-14 bg-transparent p-0">
                                        <span class="favorite-icon position-relative">
                                            <i class="ri-heart-line fs-20"></i>
                                            <i class="ri-heart-fill fs-20 position-absolute top-50 start-50 translate-middle text-primary"></i>
                                        </span>
                                    </button>
                                </div>

                                <div class="audio-player" id="audio_control">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span id="current-time" class="fs-12">0:00</span>
                                        <span id="duration" class="fs-12">0:00</span>
                                    </div>
                                    <div class="progress mb-3" style="height: 4px">
                                        <div class="progress-bar" id="progress-bar" style="width: 0%; height: 4px;"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button id="shuffle" class="bg-transparent p-0 lh-1 border-0" style="color: #9CAAFF;">
                                            <i class="ri-shuffle-line fs-20"></i>
                                        </button>
                                        <div class="d-flex gap-1">
                                            <button id="rewind" class="bg-transparent p-0 lh-1 border-0" style="color: #9CAAFF;">
                                                <i class="ri-skip-left-fill fs-30"></i>
                                            </button>
                                            <button id="previous" class="bg-transparent p-0 lh-1 border-0" style="color: #9CAAFF;">
                                                <i class="ri-arrow-left-s-fill fs-30"></i>
                                            </button>
                                            <button id="play-pause" class="p-0 lh-1 border-0 text-primary rounded-circle" style="background-color: #ECF0FF; width: 44px; height: 44px;">
                                                <i class="ri-play-fill fs-30 position-relative"></i>
                                            </button>
                                            <button id="next" class="bg-transparent p-0 lh-1 border-0" style="color: #9CAAFF;">
                                                <i class="ri-arrow-right-s-fill fs-30"></i>
                                            </button>
                                            <button id="fast-forward" class="bg-transparent p-0 lh-1 border-0" style="color: #9CAAFF;">
                                                <i class="ri-skip-right-fill fs-30"></i>
                                            </button>
                                        </div>
                                        <button id="restart" class="bg-transparent p-0 lh-1 border-0" style="color: #9CAAFF;">
                                            <i class="ri-reset-right-line fs-20"></i>
                                        </button>
                                    </div>
                                </div>
                                  
                                <audio id="audio" src="https://cldup.com/qR72ozoaiQ.mp3"></audio>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-8">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4 custom-padding-30" style="padding-bottom: 18px;">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 position-relative pb-3" style="top: -5px;">
                                    <h3 class="mb-0 fs-18 fw-semibold">Most Popular</h3>
                                    <button class="bg-transparent border-0 p-0 d-flex align-items-center text-decoration-none position-relative right-for-rtl text-body" style="right: -8px;">
                                        <span>View All</span>
                                        <i class="ri-arrow-right-s-line fs-24 position-relative top-1 lh-1 text-body"></i>
                                    </button>
                                </div>

                                <ul class="nav nav-tabs gap-2 most-popular-tabs border-0 mb-20" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link bg-border-color rounded-pill fs-12 fw-medium text-body border-0 active" id="marketing-tab" data-bs-toggle="tab" data-bs-target="#marketing-tab-pane" type="button" role="tab" aria-controls="marketing-tab-pane" aria-selected="true">Marketing</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link bg-border-color rounded-pill fs-12 fw-medium text-body border-0" id="content-tab" data-bs-toggle="tab" data-bs-target="#content-tab-pane" type="button" role="tab" aria-controls="content-tab-pane" aria-selected="false">Content</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link bg-border-color rounded-pill fs-12 fw-medium text-body border-0" id="social-tab" data-bs-toggle="tab" data-bs-target="#social-tab-pane" type="button" role="tab" aria-controls="social-tab-pane" aria-selected="false">Social</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link bg-border-color rounded-pill fs-12 fw-medium text-body border-0" id="analytics-tab" data-bs-toggle="tab" data-bs-target="#analytics-tab-pane" type="button" role="tab" aria-controls="analytics-tab-pane" aria-selected="false">Analytics</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link bg-border-color rounded-pill fs-12 fw-medium text-body border-0" id="customer-tab" data-bs-toggle="tab" data-bs-target="#customer-tab-pane" type="button" role="tab" aria-controls="customer-tab-pane" aria-selected="false">Customer</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link bg-border-color rounded-pill fs-12 fw-medium text-body border-0" id="trends-tab" data-bs-toggle="tab" data-bs-target="#trends-tab-pane" type="button" role="tab" aria-controls="trends-tab-pane" aria-selected="false">Trends</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="marketing-tab-pane" role="tabpanel" aria-labelledby="marketing-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-7.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Influencer Marketing</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Amanda Garcia</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">6,300</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4 active">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-8.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Data for Better Ads</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: David Chen</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,500</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-9.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Boosting Engagement</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Lisa Kim</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,300</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-10.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Real Engagement Metrics</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Sarah Johnson</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,700</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-11.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">SEO for E-Commerce</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Johnson</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,900</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-12.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Podcast Marketing 101</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Amanda</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,400</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="content-tab-pane" role="tabpanel" aria-labelledby="content-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-10.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Real Engagement Metrics</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Sarah Johnson</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,700</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-11.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">SEO for E-Commerce</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Johnson</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,900</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-12.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Podcast Marketing 101</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Amanda</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,400</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-7.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Influencer Marketing</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Amanda Garcia</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,500</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4 active">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-8.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Data for Better Ads</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: David Chen</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,500</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-9.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Boosting Engagement</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Lisa Kim</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,300</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="social-tab-pane" role="tabpanel" aria-labelledby="social-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-7.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Influencer Marketing</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Amanda Garcia</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,500</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-11.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">SEO for E-Commerce</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Johnson</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,900</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-12.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Podcast Marketing 101</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Amanda</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,400</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4 active">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-8.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Data for Better Ads</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: David Chen</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,500</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-9.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Boosting Engagement</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Lisa Kim</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,300</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-10.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Real Engagement Metrics</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Sarah Johnson</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,700</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="analytics-tab-pane" role="tabpanel" aria-labelledby="analytics-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-10.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Real Engagement Metrics</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Sarah Johnson</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,700</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-11.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">SEO for E-Commerce</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Johnson</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,900</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-12.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Podcast Marketing 101</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Amanda</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,400</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-7.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Influencer Marketing</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Amanda Garcia</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,500</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4 active">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-8.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Data for Better Ads</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: David Chen</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,500</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-9.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Boosting Engagement</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Lisa Kim</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,300</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="customer-tab-pane" role="tabpanel" aria-labelledby="customer-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-7.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Influencer Marketing</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Amanda Garcia</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,500</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-11.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">SEO for E-Commerce</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Johnson</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,900</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-12.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Podcast Marketing 101</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Amanda</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,400</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4 active">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-8.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Data for Better Ads</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: David Chen</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,500</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-9.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Boosting Engagement</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Lisa Kim</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,300</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-10.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Real Engagement Metrics</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Sarah Johnson</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,700</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="trends-tab-pane" role="tabpanel" aria-labelledby="trends-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-10.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Real Engagement Metrics</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Sarah Johnson</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,700</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-11.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">SEO for E-Commerce</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Johnson</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,900</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-12.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Podcast Marketing 101</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Amanda</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,400</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-7.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Influencer Marketing</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Amanda Garcia</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,500</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4 active">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-8.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Data for Better Ads</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: David Chen</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">8,500</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="position-relative single-play mb-4">
                                                    <div class="position-relative bg-img rounded-3" style="background-image: url(/assets/images/played-9.jpg); height: 183px;">
                                                        <div class="position-absolute bottom-0 start-0 ps-3 pb-3">
                                                            <button class="p-0 border-0 bg-primary rounded-circle audio-play-btn" style="width: 44px; height: 44px; line-height: 29px;">
                                                                <audio class="track">
                                                                    <source src="https://cldup.com/qR72ozoaiQ.mp3" type="audio/mpeg" />
                                                                </audio>
                                                                <div class="player-container style-two">
                                                                    <div class="play-pause">Play</div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h3 class="fs-14 fw-medium mt-3 mb-2">Boosting Engagement</h3>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="fs-12">By: Lisa Kim</span>
                                                        <div class="d-flex align-items-center ms-4">
                                                            <i class="ri-customer-service-line text-primary fs-15 lh-1"></i>
                                                            <span class="d-block fs-12 fw-normal text-body ms-10">9,300</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4 pb-4">
                                <div class="d-flex justify-content-between align-items-center gap-2 position-relative custom-padding-30" style="top: -5px;">
                                    <h3 class="mb-0 fs-18 fw-semibold">Upcoming Episodes</h3>
                                    <div class="dropdown action-opt right-for-rtl" style="right: -8px;">
                                        <button class="btn bg-transparent p-0 text-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical" style="stroke: #64748B;"></i>
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
    
                                <div class="last-child-none">
                                    <div class="d-flex gap-2 justify-content-between align-items-center border-bottom border-body-bg custom-padding-30 pt-0 child" style="margin-bottom: 13.5px; padding-bottom: 13.5px;">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="text-center bg-primary-div rounded-circle" style="width: 40px; height: 40px; line-height: 40px;">
                                                    <img src="/assets/images/notice-board-icon-1.svg" alt="notice-board-icon">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-10">
                                                <h4 class="fs-14 fw-medium mb-0">AI for Content Strategy</h4>
                                                <p class="fs-12 mb-0">Amanda Garcia</p>
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-calendar-line text-primary"></i>
                                                    <span class="fw-medium fs-12 text-primary ms-1">October 20, 2024</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="rounded-circle d-inline-block text-center hover-bg for-dark-read text-decoration-none border bg-transparent" style="width: 43px; height: 43px; line-height: 42px; color: #B1BBC8;">
                                            <i class="ri-arrow-right-up-line fs-24"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-between align-items-center border-bottom border-body-bg custom-padding-30 pt-0 child" style="margin-bottom: 13.5px; padding-bottom: 13.5px;">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="text-center bg-primary rounded-circle" style="width: 40px; height: 40px; line-height: 37px;">
                                                    <img src="/assets/images/notice-board-icon-2.svg" alt="notice-board-icon">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-10">
                                                <h4 class="fs-14 fw-medium mb-0">Secrets to Viral Marketing</h4>
                                                <p class="fs-12 mb-0">Sarah Johnson</p>
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-calendar-line text-primary"></i>
                                                    <span class="fw-medium fs-12 text-primary ms-1">October 25, 2024</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="rounded-circle d-inline-block text-center hover-bg for-dark-read text-decoration-none border bg-transparent" style="width: 43px; height: 43px; line-height: 42px; color: #B1BBC8;">
                                            <i class="ri-arrow-right-up-line fs-24"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-between align-items-center border-bottom border-body-bg custom-padding-30 pt-0 child" style="margin-bottom: 13.5px; padding-bottom: 13.5px;">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="text-center bg-danger rounded-circle" style="width: 40px; height: 40px; line-height: 37px;">
                                                    <img src="/assets/images/notice-board-icon-3.svg" alt="notice-board-icon">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-10">
                                                <h4 class="fs-14 fw-medium mb-0">Social Media Strategy</h4>
                                                <p class="fs-12 mb-0">David Chen</p>
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-calendar-line text-primary"></i>
                                                    <span class="fw-medium fs-12 text-primary ms-1">October 28, 2024</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="rounded-circle d-inline-block text-center hover-bg for-dark-read text-decoration-none border bg-transparent" style="width: 43px; height: 43px; line-height: 42px; color: #B1BBC8;">
                                            <i class="ri-arrow-right-up-line fs-24"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-between align-items-center border-bottom border-body-bg custom-padding-30 pt-0 child" style="margin-bottom: 13.5px; padding-bottom: 13.5px;">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="text-center bg-card-bg-c rounded-circle" style="width: 40px; height: 40px; line-height: 40px;">
                                                    <img src="/assets/images/notice-board-icon-4.svg" alt="notice-board-icon">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-10">
                                                <h4 class="fs-14 fw-medium mb-0">Content Trends for 2025</h4>
                                                <p class="fs-12 mb-0">Tom Richards</p>
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-calendar-line text-primary"></i>
                                                    <span class="fw-medium fs-12 text-primary ms-1">November 3, 2024</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="rounded-circle d-inline-block text-center hover-bg for-dark-read text-decoration-none border bg-transparent" style="width: 43px; height: 43px; line-height: 42px; color: #B1BBC8;">
                                            <i class="ri-arrow-right-up-line fs-24"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card custom-shadow rounded-3 bg-white border mb-4">
                                <div class="overflow-hidden rounded-3">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-1 custom-padding-30 pb-4 position-relative z-1" style="top: -5px;">
                                        <div class="">
                                            <div class="d-flex align-items-center">
                                                <h3 class="fs-20 fw-semibold mb-0 pe-2">$3,425.78</h3>
                                                <span class="text-success-50 px-2 d-inline-block rounded-1 ms-0 fs-12" style="background-color: #D8FFC8; padding: 0.5px 0;">+9.1%</span>
                                            </div>
                                            <span>Today’s Earnings</span>
                                        </div>
                                        <div class="dropdown action-opt right-for-rtl" style="right: -8px;">
                                            <button class="btn bg-transparent p-0 text-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-vertical" style="stroke: #64748B;"></i>
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
                                            </ul>
                                        </div>
                                    </div>

                                    <div style="margin: -53px -11px -35px -13px;">
                                        <div id="todays_earnings"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-5 col-xxl-6 col-lg-5">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4 custom-padding-30 position-relative">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 position-relative pb-4" style="top: -5px;">
                                    <h3 class="mb-0 fs-18 fw-semibold">Listener Analytics</h3>
                                    <div class="dropdown select-dropdown without-border position-relative" style="right: -5px;">
                                        <button class="dropdown-toggle bg-transparent border text-body rounded-2" style="padding-right: 20px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Last 28 days
                                        </button>
                                      
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Last 28 days</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Last 48 days</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Last 90 days</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Last Year</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div style="margin: -29px -27px -28px -16px;">
                                    <div id="listener_analytics"></div>
                                </div>

                                <div class="position-absolute position-for-mobile" style="top: 92px; right: 30px;">
                                    <div class="d-flex align-items-center">
                                        <div style="margin: 0 0 0 0;">
                                            <div id="sales_by_gender_2"></div>
                                        </div>
                                        <ul class="ps-0 mb-0 list-unstyled last-child-none" style="margin-left: -110px;">
                                            <li class="d-flex align-items-center mb-2">
                                                <span class="d-inline-block bg-primary-div rounded-circle" style="width: 10px; height: 10px; margin-right: 7px;"></span>
                                                <span class="fs-12 text-secondary">Men: <span class="fw-medium">75%</span></span>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <span class="d-inline-block bg-card-bg-c rounded-circle" style="width: 10px; height: 10px; margin-right: 7px;"></span>
                                                <span class="fs-12 text-secondary">Woman: <span class="fw-medium">25%</span></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-xxl-6 col-lg-7">
                            <div class="card custom-shadow rounded-3 bg-white border mb-4" style="padding-bottom: 18px;">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 position-relative custom-padding-30" style="top: -5px; padding-bottom: 12px;">
                                    <h3 class="mb-0 fs-18 fw-semibold">Top Podcasts</h3>
                                    <div class="dropdown select-dropdown without-border position-relative" style="right: -5px;">
                                        <button class="dropdown-toggle bg-transparent border text-body rounded-2" style="padding-right: 20px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Last 28 days
                                        </button>
                                      
                                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow py-3">
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Last 28 days</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Last 48 days</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Last 90 days</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-secondary py-2 px-3">Last Year</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="default-table-area style-three style-two top-podcasts">
                                    <div class="table-responsive">
                                        <table class="table align-middle border-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="bg-body-bg" style="padding-top: 6.5px; padding-bottom: 6.5px;">
                                                        <span class="fs-12 fw-medium text-body">Name</span>
                                                    </th>
                                                    <th scope="col" class="bg-body-bg" style="padding-top: 6.5px; padding-bottom: 6.5px;">
                                                        <span class="fs-12 fw-medium text-body">Episodes</span>
                                                    </th>
                                                    <th scope="col" class="bg-body-bg" style="padding-top: 6.5px; padding-bottom: 6.5px;">
                                                        <span class="fs-12 fw-medium text-body">Earnings</span>
                                                    </th>
                                                    <th scope="col" class="bg-body-bg" style="padding-top: 6.5px; padding-bottom: 6.5px;">
                                                        <span class="fs-12 fw-medium text-body">Ratings</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-129.png" class="wh-44 rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-10 position-relative top-2">
                                                                <h6 class="mb-0 fs-14 fw-medium">Tom Richards</h6>
                                                                <span class="fs-12 text-body">Content Strategist</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fs-14 fw-medium text-secondary">95</span>
                                                    </td>
                                                    <td>
                                                        <span class="fs-14 fw-medium text-secondary">$125,000</span>
                                                    </td>
                                                    <td>
                                                        <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-half-line text-rating-color fs-15"></i>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-130.png" class="wh-44 rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-10 position-relative top-2">
                                                                <h6 class="mb-0 fs-14 fw-medium">Amanda Garcia</h6>
                                                                <span class="fs-12 text-body">Social Media</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fs-14 fw-medium text-secondary">110</span>
                                                    </td>
                                                    <td>
                                                        <span class="fs-14 fw-medium text-secondary">$140,000</span>
                                                    </td>
                                                    <td>
                                                        <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-half-line text-rating-color fs-15"></i>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-131.png" class="wh-44 rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-10 position-relative top-2">
                                                                <h6 class="mb-0 fs-14 fw-medium">Lisa Kim</h6>
                                                                <span class="fs-12 text-body">Branding Consultant</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fs-14 fw-medium text-secondary">85</span>
                                                    </td>
                                                    <td>
                                                        <span class="fs-14 fw-medium text-secondary">$160,000</span>
                                                    </td>
                                                    <td>
                                                        <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-rating-color fs-15"></i>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-132.png" class="wh-44 rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-10 position-relative top-2">
                                                                <h6 class="mb-0 fs-14 fw-medium">Michael Young</h6>
                                                                <span class="fs-12 text-body">Data Analytics</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fs-14 fw-medium text-secondary">130</span>
                                                    </td>
                                                    <td>
                                                        <span class="fs-14 fw-medium text-secondary">$90,000</span>
                                                    </td>
                                                    <td>
                                                        <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-half-line text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-rating-color fs-15"></i>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="/assets/images/user-133.png" class="wh-44 rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-10 position-relative top-2">
                                                                <h6 class="mb-0 fs-14 fw-medium">Ravi Patel</h6>
                                                                <span class="fs-12 text-body">SEO & SEM</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fs-14 fw-medium text-secondary">75</span>
                                                    </td>
                                                    <td>
                                                        <span class="fs-14 fw-medium text-secondary">$85,000</span>
                                                    </td>
                                                    <td>
                                                        <ul class="ps-0 mb-0 list-unstyled d-flex gap-1">
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-fill text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-rating-color fs-15"></i>
                                                            </li>
                                                            <li>
                                                                <i class="ri-star-line text-rating-color fs-15"></i>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
