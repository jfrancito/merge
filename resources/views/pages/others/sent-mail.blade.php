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
                        <h3 class="mb-0">Sent Mail</h3>

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
                                    <span class="fw-medium">Sent Mail</span>
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
                                        <li class="mb-3 pb-1 d-flex justify-content-between align-items-center">
                                            <a href="inbox" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">inbox</i>
                                                <span class="fw-semibold">Inbox</span> 
                                            </a>
                                            <span class="fs-13">10</span>
                                        </li>
                                        <li class="mb-3 pb-1">
                                            <a href="starred" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">star_rate</i>
                                                <span class="fw-medium">Started</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3 pb-1">
                                            <a href="snoozed" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">alarm</i>
                                                <span class="fw-medium">Snoozed</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3 pb-1">
                                            <a href="sent-mail" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2 text-primary">send</i>
                                                <span class="fw-medium text-primary">Sent</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3 pb-1">
                                            <a href="draft" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">draft</i>
                                                <span class="fw-medium">Drafts</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3 pb-1">
                                            <a href="important" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">bookmark</i>
                                                <span class="fw-medium">Important</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3 pb-1">
                                            <a href="chat" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">auto_read_pause</i>
                                                <span class="fw-medium">Chats</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3 pb-1">
                                            <a href="javascript:void(0);" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">schedule_send</i>
                                                <span class="fw-medium">Scheduled</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3 pb-1">
                                            <a href="inbox" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">forward_to_inbox</i>
                                                <span class="fw-medium">All Mail</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3 pb-1">
                                            <a href="spam" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">live_help</i>
                                                <span class="fw-medium">Spam</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3 pb-1">
                                            <a href="trash-email" class="d-flex align-items-center text-decoration-none">
                                                <i class="material-symbols-outlined fs-18 position-relative top-1 me-2">delete</i>
                                                <span class="fw-medium">Trash</span> 
                                            </a>
                                        </li>
                                        <li class="mb-3 pb-1">
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
                                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap pb-4 border-bottom">
                                        <div class="d-flex position-relative top-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <div class="form-check-label">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-danger dropdown-toggle p-0 border-0 ps-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false"></button>

                                                        <ul class="dropdown-menu bg-white box-shadow" style="border: 1px solid #F6F7F9;">
                                                            <li><a class="dropdown-item fs-13" href="#">All</a></li>
                                                            <li><a class="dropdown-item fs-13" href="#">None</a></li>
                                                            <li><a class="dropdown-item fs-13" href="#">Read</a></li>
                                                            <li><a class="dropdown-item fs-13" href="#">Unread</a></li>
                                                            <li><a class="dropdown-item fs-13" href="#">Starred</a></li>
                                                            <li><a class="dropdown-item fs-13" href="#">Untarred</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
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
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <span class="fs-12 fw-medium me-2">1 - 5 of 12</span>
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination mb-0 justify-content-center">
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="index" aria-label="Previous">
                                                                <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link icon" href="index" aria-label="Next">
                                                                <i class="material-symbols-outlined">keyboard_arrow_right</i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <i class="material-symbols-outlined">menu</i>
                                                <button type="button" class="btn btn-danger dropdown-toggle p-0 border-0 ps-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                                </button>
    
                                                <ul class="dropdown-menu bg-white box-shadow dropdown-menu-end" style="border: 1px solid #F6F7F9;">
                                                    <li><a class="dropdown-item fs-13" href="#">All</a></li>
                                                    <li><a class="dropdown-item fs-13" href="#">None</a></li>
                                                    <li><a class="dropdown-item fs-13" href="#">Read</a></li>
                                                    <li><a class="dropdown-item fs-13" href="#">Unread</a></li>
                                                    <li><a class="dropdown-item fs-13" href="#">Starred</a></li>
                                                    <li><a class="dropdown-item fs-13" href="#">Untarred</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="default-table-area email-list">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <tbody>
                                                    <tr>
                                                        <td class="ps-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-4">
                                                                    <input class="form-check-input wh-20" type="checkbox" value="" id="flexCheckDefault2">
                                                                </div>
                                                                <i class="material-symbols-outlined fs-20 text-body position-relative top-1">send</i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fs-14 fw-medium">Google</span>
                                                        </td>
                                                        <td>
                                                            <a href="read-email" class="w-330 d-inline-block text-truncate text-secondary">2-Step Verification Turn Off <span class="text-body">- Integer nec arcu ac nisi...</span></a>
                                                        </td>
                                                        <td class="text-end pe-0 fs-12">
                                                            <span>20 JULY 2024</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-4">
                                                                    <input class="form-check-input wh-20" type="checkbox" value="" id="flexCheckDefault3">
                                                                </div>
                                                                <i class="material-symbols-outlined fs-20 text-body position-relative top-1">send</i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fs-14 fw-medium">Facebook</span>
                                                        </td>
                                                        <td>
                                                            <a href="read-email" class="w-330 d-inline-block text-truncate text-secondary">Friend Request <span class="text-body">- Sed in libero eget lorem fermentum...</span></a>
                                                        </td>
                                                        <td class="text-end pe-0 fs-12">
                                                            <span>21 JULY 2024</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-4">
                                                                    <input class="form-check-input wh-20" type="checkbox" value="" id="flexCheckDefault4">
                                                                </div>
                                                                <i class="material-symbols-outlined fs-20 text-body position-relative top-1">send</i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fs-14 fw-medium">Linkedin</span>
                                                        </td>
                                                        <td>
                                                            <a href="read-email" class="w-330 d-inline-block text-truncate text-secondary">Travel Information <span class="text-body">- Vivamus vestibulum ligula in mauris...</span></a>
                                                        </td>
                                                        <td class="text-end pe-0 fs-12">
                                                            <span>22 JULY 2024</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-4">
                                                                    <input class="form-check-input wh-20" type="checkbox" value="" id="flexCheckDefault5">
                                                                </div>
                                                                <i class="material-symbols-outlined fs-20 text-body position-relative top-1">send</i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fs-14 fw-medium">Ethan Parker</span>
                                                        </td>
                                                        <td>
                                                            <a href="read-email" class="w-330 d-inline-block text-truncate text-secondary">Leave Application <span class="text-body">- Integer nec arcu ac nisi...</span></a>
                                                        </td>
                                                        <td class="text-end pe-0 fs-12">
                                                            <span>23 JULY 2024</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-4">
                                                                    <input class="form-check-input wh-20" type="checkbox" value="" id="flexCheckDefault6">
                                                                </div>
                                                                <i class="material-symbols-outlined fs-20 text-body position-relative top-1">send</i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fs-14 fw-medium">Dribbble</span>
                                                        </td>
                                                        <td>
                                                            <a href="read-email" class="w-330 d-inline-block text-truncate text-secondary">Design Inspiration <span class="text-body">- Sed in libero eget lorem fermentum...</span></a>
                                                        </td>
                                                        <td class="text-end pe-0 fs-12">
                                                            <span>24 JULY 2024</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-4">
                                                                    <input class="form-check-input wh-20" type="checkbox" value="" id="flexCheckDefault7">
                                                                </div>
                                                                <i class="material-symbols-outlined fs-20 text-body position-relative top-1">send</i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fs-14 fw-medium">Instagram</span>
                                                        </td>
                                                        <td>
                                                            <a href="read-email" class="w-330 d-inline-block text-truncate text-secondary">Training Schedule <span class="text-body">- Vivamus vestibulum ligula in mauris...</span></a>
                                                        </td>
                                                        <td class="text-end pe-0 fs-12">
                                                            <span>25 JULY 2024</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-4">
                                                                    <input class="form-check-input wh-20" type="checkbox" value="" id="flexCheckDefault8">
                                                                </div>
                                                                <i class="material-symbols-outlined fs-20 text-body position-relative top-1">send</i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fs-14 fw-medium">Isabella Cooper</span>
                                                        </td>
                                                        <td>
                                                            <a href="read-email" class="w-330 d-inline-block text-truncate text-secondary">Internal Auditor <span class="text-body">- Sed in libero eget lorem fermentum...</span></a>
                                                        </td>
                                                        <td class="text-end pe-0 fs-12">
                                                            <span>26 JULY 2024</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-4">
                                                                    <input class="form-check-input wh-20" type="checkbox" value="" id="flexCheckDefault9">
                                                                </div>
                                                                <i class="material-symbols-outlined fs-20 text-body position-relative top-1">send</i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fs-14 fw-medium">Google</span>
                                                        </td>
                                                        <td>
                                                            <a href="read-email" class="w-330 d-inline-block text-truncate text-secondary">Password Changed <span class="text-body">- Integer nec arcu ac nisi...</span></a>
                                                        </td>
                                                        <td class="text-end pe-0 fs-12">
                                                            <span>27 JULY 2024</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-4">
                                                                    <input class="form-check-input wh-20" type="checkbox" value="" id="flexCheckDefault10">
                                                                </div>
                                                                <i class="material-symbols-outlined fs-20 text-body position-relative top-1">send</i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fs-14 fw-medium">Olivia Rodriguez</span>
                                                        </td>
                                                        <td>
                                                            <a href="read-email" class="w-330 d-inline-block text-truncate text-secondary">Virtual Training <span class="text-body">- Vivamus vestibulum ligula in mauris...</span></a>
                                                        </td>
                                                        <td class="text-end pe-0 fs-12">
                                                            <span>28 JULY 2024</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-4">
                                                                    <input class="form-check-input wh-20" type="checkbox" value="" id="flexCheckDefault11">
                                                                </div>
                                                                <i class="material-symbols-outlined fs-20 text-body position-relative top-1">send</i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fs-14 fw-medium">YouTube</span>
                                                        </td>
                                                        <td>
                                                            <a href="read-email" class="w-330 d-inline-block text-truncate text-secondary">New Subscriber <span class="text-body">- Sed in libero eget lorem fermentum...</span></a>
                                                        </td>
                                                        <td class="text-end pe-0 fs-12">
                                                            <span>29 JULY 2024</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ps-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-4">
                                                                    <input class="form-check-input wh-20" type="checkbox" value="" id="flexCheckDefault12">
                                                                </div>
                                                                <i class="material-symbols-outlined fs-20 text-body position-relative top-1">send</i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fs-14 fw-medium">Google</span>
                                                        </td>
                                                        <td>
                                                            <a href="read-email" class="w-330 d-inline-block text-truncate text-secondary">Security Alert <span class="text-body">- Vivamus vestibulum ligula in mauris...</span></a>
                                                        </td>
                                                        <td class="text-end pe-0 fs-12">
                                                            <span>30 JULY 2024</span>
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
