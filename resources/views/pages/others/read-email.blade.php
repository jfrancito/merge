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
                        <h3 class="mb-0">Read Email</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Apps</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Read Email</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xl-4 col-lg-3 col-md-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <form class="position-relative default-src-form mb-3 pb-1">
                                        <input type="text" class="form-control rounded-1" placeholder="Search">
                                        <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y fs-18">search</i>
                                    </form>
                                    <a href="compose" class="btn btn-primary fs-16 fw-medium text-center d-block py-2 mb-4">
                                        <div class="d-flex align-items-center justify-content-center py-lg-1">
                                            <i class="material-symbols-outlined fs-18 me-2">edit</i>
                                            <span>Compose</span>
                                        </div>
                                    </a>
                                    
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-3">
                                            <a href="inbox" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2 text-primary">inbox</i>
                                                <span class="fw-semibold text-primary">Inbox</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="started" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">star_rate</i>
                                                <span class="fw-medium">Started</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="snoozed" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">alarm</i>
                                                <span class="fw-medium">Snoozed</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="sent" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">send</i>
                                                <span class="fw-medium">Sent</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="drafts" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">draft</i>
                                                <span class="fw-medium">Drafts</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="important" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">bookmark</i>
                                                <span class="fw-medium">Important</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="chat" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">auto_read_pause</i>
                                                <span class="fw-medium">Chats</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="javascript:void(0);" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">schedule_send</i>
                                                <span class="fw-medium">Scheduled</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="all-mail" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">forward_to_inbox</i>
                                                <span class="fw-medium">All Mail</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="spam" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">live_help</i>
                                                <span class="fw-medium">Spam</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="trash" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">delete</i>
                                                <span class="fw-medium">Trash</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="javascript:void(0);" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">account_circle</i>
                                                <span class="fw-medium">Personal</span> 
                                            </a>
                                        </li>
                                        <li class="mb-0">
                                            <a href="javascript:void(0);" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">trip</i>
                                                <span class="fw-medium">Company</span> 
                                            </a>
                                        </li>
                                    </ul>

                                    <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                        <span class="py-sm-1 d-block">
                                            <i class="ri-add-line d-none d-sm-inline-block"></i>
                                            <span>Add New Label</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-9 col-md-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap border-bottom pb-3 mb-4">
                                        <h3 class="fs-16 fw-semibold mb-0">Sales Review Meeting</h3>
                                        <div class="d-flex position-relative top-3">
                                            <button class="pe-0 border-0 bg-transparent ms-4 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Archive">
                                                <i class="material-symbols-outlined fs-20 text-body hover">archive</i>
                                            </button>
                                            <button class="pe-0 border-0 bg-transparent ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Help">
                                                <i class="material-symbols-outlined fs-20 text-body hover">help_clinic</i>
                                            </button>
                                            <button class="pe-0 border-0 bg-transparent ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tresh">
                                                <i class="material-symbols-outlined fs-20 text-body hover">delete</i>
                                            </button>
                                            <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                                <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="material-symbols-outlined fs-20 text-body hover">more_vert</i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);">
                                                            <i data-feather="eye"></i>
                                                            View All 
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);">
                                                            <i data-feather="trash-2"></i>
                                                            Delete One
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);">
                                                            <i data-feather="lock"></i>
                                                            Block
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-4 pb-md-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/user-48.jpg" class="wh-45 rounded-circle" alt="user">
                                            </div>
                                            <div class="flex-grow-1 ms-3 position-relative top-2">
                                                <h4 class="mb-0 fs-14 fw-semibold">Sarah Smith</h4>
                                                <span>sarah@gmail.com</span>
                                            </div>
                                        </div>
                                        <span><i class="ri-star-line fs-18 text-body me-1"></i> 26 March,2024</span>
                                    </div>

                                    <div class="ps-sm-5 ms-sm-2">
                                        <h5 class="fs-14 fw-semibold mb-3 mb-md-4">Subject: Re: Quarterly Sales Review Meeting</h5>
                                        <span class="fw-medium text-secondary d-block mb-4">Hi Smith,</span>
                                        <p>Great, I'll go ahead and send out the calendar invite shortly.</p>
                                        <p>Regarding the agenda, I think your suggestions are spot on. I'll add them to the agenda and circulate it to everyone before the meeting so they can come prepared.</p>
                                        <p>Additionally, I think it would be beneficial to have a brief update on any new products or promotions that are launching in the next quarter. This will give us a comprehensive view of our sales strategy moving forward.</p>
                                        <p>Let me know if you think that's a valuable addition to the agenda.</p>
                                        <div class="border-bottom pb-4 mb-4 mt-4 mt-md-5">
                                            <h5 class="fs-14 fw-medium mb-2">Best regards,</h5>
                                            <h5 class="fs-14 fw-medium mb-0">Olivia Parker</h5>
                                        </div>
                                        <div class="d-flex flex-wrap gap-3">
                                            <button class="btn btn-primary fs-16 fw-medium px-3">Reply</button>
                                            <button class="btn btn-outline-primary fs-16 fw-medium px-3">Forward</button>
                                        </div>
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
