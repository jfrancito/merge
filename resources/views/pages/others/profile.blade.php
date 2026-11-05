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
                        <h3 class="mb-0">Profile</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Social</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Profile</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-xxl-9">
                            <div class="position-relative">
                                <img src="assets/images/profile-bg.jpg" class="rounded-top-3" alt="profile-bg">
                                <div class="position-absolute" style="bottom: 25px; right: 25px;">
                                    <a href="#" class="btn btn-outline-light text-white hover rounded-2">
                                        Update Cover Photo
                                    </a>
                                </div>
                            </div>
                            <div class="card bg-white border-0 rounded-3 mb-4 rounded-top-0">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between flex-wrap gap-3">
                                        <div class="d-flex align-items-end">
                                            <div class="flex-shrink-0 position-relative mt-minus-110">
                                                <img src="assets/images/user-68.jpg" class="rounded-circle border border-2 wh-160" alt="user">
                                                <img src="assets/images/check.svg" class="position-absolute bottom-0 end-0" alt="check">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="fs-24 mb-1">Alice Johnson</h4>
                                                <span class="fs-15 fw-medium">Product designer</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="btn btn-outline-light text-body fw-medium fs-16 px-4 hover hover-bg">
                                                <i class="ri-edit-line fw-medium fs-18 me-1"></i>
                                                <span>Edit</span>
                                            </a>
                                            <a href="#" class="btn btn-primary fw-medium fs-16 px-4 ms-3">
                                                <i class="ri-share-fill fw-medium fs-18 me-1"></i>
                                                <span>Share</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav nav-tabs profile-tabs border-0 justify-content-center gap-2 mb-4" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link border-1 border-primary rounded-2 fw-medium active" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline-tab-pane" type="button" role="tab" aria-controls="timeline-tab-pane" aria-selected="true">Timeline</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link border-1 border-primary rounded-2 fw-medium" id="about-tab" data-bs-toggle="tab" data-bs-target="#about-tab-pane" type="button" role="tab" aria-controls="about-tab-pane" aria-selected="false">About</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link border-1 border-primary rounded-2 fw-medium" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity-tab-pane" type="button" role="tab" aria-controls="activity-tab-pane" aria-selected="false">Activity</button>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-0 pb-4">
                                            <div class="p-4 pb-2">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                                    <h3 class="mb-0">Friends</h3>
                                                    <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                                        <option selected="">This Month</option>
                                                        <option value="1">Last Month</option>
                                                        <option value="2">Last Year</option>
                                                    </select>
                                                </div>

                                                <form class="position-relative default-src-form">
                                                    <input type="text" class="form-control rounded-2" placeholder="Search here">
                                                    <i class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y fs-18">search</i>
                                                </form>
                                            </div>
        
                                            <div class="default-table-area style-two">
                                                <div class="table-responsive">
                                                    <table class="table align-middle border-0">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 position-relative">
                                                                            <img src="assets/images/user-7.jpg" class="wh-44 rounded-circle" alt="user">
                                                                            <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Laura Martinez</h6>
                                                                            <span class="fs-12 text-body">laura@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pt-1">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 position-relative">
                                                                            <img src="assets/images/user-6.jpg" class="wh-44 rounded-circle" alt="user">
                                                                            <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Alex Davis</h6>
                                                                            <span class="fs-12 text-body">alex@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end pt-1">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 position-relative">
                                                                            <img src="assets/images/user-8.jpg" class="wh-44 rounded-circle" alt="user">
                                                                            <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Mark Thompson</h6>
                                                                            <span class="fs-12 text-body">mark@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 position-relative">
                                                                            <img src="assets/images/user-9.jpg" class="wh-44 rounded-circle" alt="user">
                                                                            <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Rachel White</h6>
                                                                            <span class="fs-12 text-body">rachel@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 position-relative">
                                                                            <img src="assets/images/user-10.jpg" class="wh-44 rounded-circle" alt="user">
                                                                            <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Kevin Lee</h6>
                                                                            <span class="fs-12 text-body">kevin@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pt-1">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 position-relative">
                                                                            <img src="assets/images/user-11.jpg" class="wh-44 rounded-circle" alt="user">
                                                                            <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Lenore Crum</h6>
                                                                            <span class="fs-12 text-body">crum@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end pt-1">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 position-relative">
                                                                            <img src="assets/images/user-12.jpg" class="wh-44 rounded-circle" alt="user">
                                                                            <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2"></div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Paul Bartlett</h6>
                                                                            <span class="fs-12 text-body">bartlett@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 position-relative">
                                                                            <img src="assets/images/user-13.jpg" class="wh-44 rounded-circle" alt="user">
                                                                            <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Nikki Lowe</h6>
                                                                            <span class="fs-12 text-body">lowe@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 position-relative">
                                                                            <img src="assets/images/user-14.jpg" class="wh-44 rounded-circle" alt="user">
                                                                            <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Milton Laskowski</h6>
                                                                            <span class="fs-12 text-body">laskowski@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 position-relative">
                                                                            <img src="assets/images/user-15.jpg" class="wh-44 rounded-circle" alt="user">
                                                                            <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2"></div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Ethel Hillen</h6>
                                                                            <span class="fs-12 text-body">hillen@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="timeline-tab-pane" role="tabpanel" aria-labelledby="timeline-tab" tabindex="0">
                                            <div class="card bg-white border-0 rounded-3 mb-4">
                                                <div class="card-body p-4">
                                                    <h3 class="mb-3 mb-lg-4">Create Post</h3>
                                                    <form>
                                                        <div class="mb-4">
                                                            <textarea class="form-control" rows="6" placeholder="What's on your mind, Alice Johnson?"></textarea>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <button class="btn btn-primary py-2 px-3 align-items-center d-flex fs-16 fw-medium">
                                                                <i class="material-symbols-outlined text-white me-2">send</i>
                                                                <span class="py-1 d-none d-sm-inline-block">Publish Post</span>
                                                            </button>
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover">
                                                                <i class="ri-emotion-line"></i>
                                                            </button>
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover">
                                                                <i class="ri-link-m"></i>
                                                            </button>
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover">
                                                                <i class="ri-mic-line"></i>
                                                            </button>
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover">
                                                                <i class="ri-image-line"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="card bg-white border-0 rounded-3 mb-4">
                                                <div class="card-body p-4">
                                                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                                        <a href="profile" class="d-flex align-items-center text-decoration-none">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/user-6.jpg" class="wh-44 rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                <h6 class="mb-0 fs-14 fw-medium">Cynthia Baggett</h6>
                                                                <span class="fs-13 text-body">05 mins ago</span>
                                                            </div>
                                                        </a>
                                                        <div class="dropdown action-opt">
                                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i data-feather="more-horizontal"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="save"></i>
                                                                        Save Post
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="eye-off"></i>
                                                                        Hide Post
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="flag"></i>
                                                                        Report Photo
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="lock"></i>
                                                                        Block Cynthia
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                    <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions.</p>
                                                    <div class="border-top border-bottom py-2 my-4">
                                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover align-items-center d-flex">
                                                                <i class="ri-thumb-up-line"></i>
                                                                <span class="fs-14 ms-2">10 Likes</span>
                                                            </button>
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover align-items-center d-flex">
                                                                <i class="ri-chat-4-line"></i>
                                                                <span class="fs-14 ms-2">0 Comments</span>
                                                            </button>
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover align-items-center d-flex">
                                                                <i class="ri-share-line"></i>
                                                                <span class="fs-14 ms-2">0 Share</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <form>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex align-items-center text-decoration-none w-100">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-68.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3 position-relative top-2">
                                                                    <input type="text" class="form-control" placeholder="Type something....">
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-3 ms-3">
                                                                <button class="p-0 bg-primary border-0 wh-44 lh-56 rounded-2">
                                                                    <i class="material-symbols-outlined text-white">send</i>
                                                                </button>
                                                                <button class="p-0 bg-transparent border-0 fs-20 text-body hover">
                                                                    <i class="ri-emotion-line"></i>
                                                                </button>
                                                                <button class="p-0 bg-transparent border-0 fs-20 text-body hover">
                                                                    <i class="ri-link-m"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="card bg-white border-0 rounded-3 mb-4">
                                                <div class="card-body p-4">
                                                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                                        <a href="profile" class="d-flex align-items-center text-decoration-none">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/user-7.jpg" class="wh-44 rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                <h6 class="mb-0 fs-14 fw-medium">Douglas Hairston</h6>
                                                                <span class="fs-13 text-body">1 hour ago</span>
                                                            </div>
                                                        </a>
                                                        <div class="dropdown action-opt">
                                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i data-feather="more-horizontal"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="save"></i>
                                                                        Save Post
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="eye-off"></i>
                                                                        Hide Post
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="flag"></i>
                                                                        Report Photo
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="lock"></i>
                                                                        Block Cynthia
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of lorem ipsum.</p>
                                                    <div class="border-top border-bottom py-2 my-4">
                                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover align-items-center d-flex">
                                                                <i class="ri-thumb-up-line"></i>
                                                                <span class="fs-14 ms-2">42 Likes</span>
                                                            </button>
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover align-items-center d-flex">
                                                                <i class="ri-chat-4-line"></i>
                                                                <span class="fs-14 ms-2">2 Comments</span>
                                                            </button>
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover align-items-center d-flex">
                                                                <i class="ri-share-line"></i>
                                                                <span class="fs-14 ms-2">1 Share</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <form>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex align-items-center text-decoration-none w-100">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-68.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3 position-relative top-2">
                                                                    <input type="text" class="form-control" placeholder="Type something....">
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-3 ms-3">
                                                                <button class="p-0 bg-primary border-0 wh-44 lh-56 rounded-2">
                                                                    <i class="material-symbols-outlined text-white">send</i>
                                                                </button>
                                                                <button class="p-0 bg-transparent border-0 fs-20 text-body hover">
                                                                    <i class="ri-emotion-line"></i>
                                                                </button>
                                                                <button class="p-0 bg-transparent border-0 fs-20 text-body hover">
                                                                    <i class="ri-link-m"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="card bg-white border-0 rounded-3 mb-4">
                                                <div class="card-body p-4">
                                                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                                        <a href="profile" class="d-flex align-items-center text-decoration-none">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/user-8.jpg" class="wh-44 rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                <h6 class="mb-0 fs-14 fw-medium">Olivia John</h6>
                                                                <span class="fs-13 text-body">1 day ago</span>
                                                            </div>
                                                        </a>
                                                        <div class="dropdown action-opt">
                                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i data-feather="more-horizontal"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="save"></i>
                                                                        Save Post
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="eye-off"></i>
                                                                        Hide Post
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="flag"></i>
                                                                        Report Photo
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="lock"></i>
                                                                        Block Cynthia
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                                                    <div class="border-top border-bottom py-2 my-4">
                                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover align-items-center d-flex">
                                                                <i class="ri-thumb-up-line"></i>
                                                                <span class="fs-14 ms-2">100 Likes</span>
                                                            </button>
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover align-items-center d-flex">
                                                                <i class="ri-chat-4-line"></i>
                                                                <span class="fs-14 ms-2">16 Comments</span>
                                                            </button>
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover align-items-center d-flex">
                                                                <i class="ri-share-line"></i>
                                                                <span class="fs-14 ms-2">5 Share</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <form>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex align-items-center text-decoration-none w-100">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-68.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3 position-relative top-2">
                                                                    <input type="text" class="form-control" placeholder="Type something....">
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-3 ms-3">
                                                                <button class="p-0 bg-primary border-0 wh-44 lh-56 rounded-2">
                                                                    <i class="material-symbols-outlined text-white">send</i>
                                                                </button>
                                                                <button class="p-0 bg-transparent border-0 fs-20 text-body hover">
                                                                    <i class="ri-emotion-line"></i>
                                                                </button>
                                                                <button class="p-0 bg-transparent border-0 fs-20 text-body hover">
                                                                    <i class="ri-link-m"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="card bg-white border-0 rounded-3 mb-4">
                                                <div class="card-body p-4">
                                                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-2">
                                                        <a href="profile" class="d-flex align-items-center text-decoration-none">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/user-8.jpg" class="wh-44 rounded-circle" alt="user">
                                                            </div>
                                                            <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                <h6 class="mb-0 fs-14 fw-medium">Olivia John</h6>
                                                                <span class="fs-13 text-body">1 day ago</span>
                                                            </div>
                                                        </a>
                                                        <div class="dropdown action-opt">
                                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i data-feather="more-horizontal"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="save"></i>
                                                                        Save Post
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="eye-off"></i>
                                                                        Hide Post
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="flag"></i>
                                                                        Report Photo
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i data-feather="lock"></i>
                                                                        Block Cynthia
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <p>Our Author Products</p>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-sm-6">
                                                            <a href="product-details">
                                                                <img src="assets/images/product-6.jpg" class="rounded-3" alt="product">
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-6 mt-4 mt-sm-0">
                                                            <a href="product-details">
                                                                <img src="assets/images/product-7.jpg" class="rounded-3" alt="product">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="border-top border-bottom py-2 my-4">
                                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover align-items-center d-flex">
                                                                <i class="ri-thumb-up-line"></i>
                                                                <span class="fs-14 ms-2">150 Likes</span>
                                                            </button>
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover align-items-center d-flex">
                                                                <i class="ri-chat-4-line"></i>
                                                                <span class="fs-14 ms-2">17 Comments</span>
                                                            </button>
                                                            <button class="p-0 bg-transparent border-0 fs-20 text-body hover align-items-center d-flex">
                                                                <i class="ri-share-line"></i>
                                                                <span class="fs-14 ms-2">7 Share</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <form>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex align-items-center text-decoration-none w-100">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/user-68.jpg" class="wh-44 rounded-circle" alt="user">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3 position-relative top-2">
                                                                    <input type="text" class="form-control" placeholder="Type something....">
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-3 ms-3">
                                                                <button class="p-0 bg-primary border-0 wh-44 lh-56 rounded-2">
                                                                    <i class="material-symbols-outlined text-white">send</i>
                                                                </button>
                                                                <button class="p-0 bg-transparent border-0 fs-20 text-body hover">
                                                                    <i class="ri-emotion-line"></i>
                                                                </button>
                                                                <button class="p-0 bg-transparent border-0 fs-20 text-body hover">
                                                                    <i class="ri-link-m"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="about-tab-pane" role="tabpanel" aria-labelledby="about-tab" tabindex="0">
                                            <div class="card bg-white border-0 rounded-3 mb-4">
                                                <div class="card-body p-4">
                                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 border-bottom pb-4 mb-4">
                                                        <h4 class="fs-18 mb-0">About Me</h4>
                                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="material-symbols-outlined fs-20 text-body hover">more_horiz</i>
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
                                                                        <i data-feather="edit"></i>
                                                                        Edit
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
                        
                                                    <h4 class="fs-16 fw-medium mb-2">Introduction</h4>
                                                    <p class="mb-4" style="max-width: 691px;">Alice Johnson, a visionary UX/UI designer, blends creativity with user-centric design principles to craft seamless digital experiences. With a passion for innovation and a knack for understanding user needs, [Your Name] has become a driving force in the ever-evolving landscape of digital design. This 5000-word biography aims to delve into Alice's journey, from humble beginnings to becoming a recognized name in the realm of user experience and interface design.</p>
                        
                                                    <h4 class="fs-16 fw-medium mb-2">Professional Beginnings</h4>
                                                    <p class="mb-4" style="max-width: 691px;">Upon graduating, Alice embarked on their professional journey, eager to make an impact in the world of design. They initially gained experience working at VivoTech, where they collaborated with cross-functional teams to deliver user-centric solutions for various clients. This early exposure provided invaluable insights into the complexities of design processes and solidified Alice's commitment to enhancing user experiences.</p>
                        
                                                    <h4 class="fs-16 fw-medium mb-2 pb-1">Expertise in UX/UI Design</h4>
                                                    <p style="max-width: 691px;">Driven by a desire for continuous growth, Alice delved deeper into the nuances of UX/UI design, staying abreast of emerging trends, technologies, and methodologies. They immersed themselves in user research, wireframing, prototyping, and usability testing, refining their craft with each project.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="activity-tab-pane" role="tabpanel" aria-labelledby="activity-tab" tabindex="0">
                                            <div class="card bg-white border-0 rounded-3 mb-4">
                                                <div class="card-body p-4">
                                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                                        <h3 class="mb-3 mb-lg-4">Recent Activity</h3>
                                                        <div class="dropdown action-opt ms-2 position-relative top-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
                                                            <button class="p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="material-symbols-outlined fs-20 text-body hover">more_horiz</i>
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
                                                                        <i data-feather="edit"></i>
                                                                        Edit
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
                                                    <div class="position-relative timeline-item">
                                                        <span class="time-line-date">Just now</span>
                                                        
                                                        <div class="border-style-for-timeline">
                                                            <h4 class="fs-14 fw-medium mb-2">Weekly Stand-Up Meetings:</h4>
                                                            <p class="fs-13">We continued our weekly stand-up meetings where team members provided updates on their current tasks, discussed any roadblocks, and coordinated efforts for the week ahead.</p>
                                                            <p>By: <span class="text-primary">Olivia Rodriguez</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative timeline-item">
                                                        <span class="time-line-date">1 day ago</span>
                                                        
                                                        <div class="border-style-for-timeline dot-2">
                                                            <h4 class="fs-14 fw-medium mb-2">Project Kickoff Session:</h4>
                                                            <p class="fs-13">The session included introductions, a review of project goals and objectives, and initial planning discussions.</p>
                                                            <p>By: <span class="text-primary">Isabella Cooper</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative timeline-item">
                                                        <span class="time-line-date">2 days ago</span>
                                                        
                                                        <div class="border-style-for-timeline dot-3">
                                                            <h4 class="fs-14 fw-medium mb-2">Team Building Workshop:</h4>
                                                            <p class="fs-13">Last Friday, we conducted a team building workshop focused on improving communication and collaboration among team members. Activities included team challenges, icebreakers, and open discussions.</p>
                                                            <p>By: <span class="text-primary">Lucas Morgan</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative timeline-item">
                                                        <span class="time-line-date">3 days ago</span>
                                                        
                                                        <div class="border-style-for-timeline dot-4 pb-0">
                                                            <h4 class="fs-14 fw-medium mb-2">Lunch and Learn Session:</h4>
                                                            <p class="fs-13">We organized a lunch and learn session on March 15th where a guest speaker from the industry discussed emerging trends in our field. It was an insightful session that sparked valuable discussions among team members.</p>
                                                            <p>By: <span class="text-primary">Ethan Parker</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3">
                            <div class="row">
                                <div class="col-xxl-12 col-md-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4">
                                            <h3 class="mb-4">Profile Intro</h3>
        
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="flex-shrink-0">
                                                    <img src="assets/images/user-68.jpg" class="rounded-circle border border-2 wh-75" alt="user">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="fs-17 mb-1 fw-semibold">Alice Johnson</h4>
                                                    <span class="fs-14">Product designer</span>
                                                </div>
                                            </div>
        
                                            <h4 class="fw-semibold fs-14 mb-2">About Me</h4>
                                            <p>Molestie tincidunt ut consequat a urna tortor. Vitae velit ac nisl velit mauris placerat nisi placerat. Pellentesque viverra lorem malesuada nunc tristique sapien. Imperdiet sit hendrerit tincidunt bibendum donec adipiscing.</p>
                                            <h4 class="fw-semibold fs-14 mb-2 pb-1">Social Profile</h4>
                                            <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-2">
                                                <li>
                                                    <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #3a559f;">
                                                        <i class="ri-facebook-fill"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #03a9f4;">
                                                        <i class="ri-twitter-x-line"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #007ab9;">
                                                        <i class="ri-linkedin-fill"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.google.com/" target="_blank" class="text-decoration-none wh-30 d-inline-block lh-30 text-center rounded-circle text-white transition-y" style="background-color: #2196f3;">
                                                        <i class="ri-mail-line"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-0 pb-4">
                                            <div class="p-4">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                                    <h3 class="mb-0">Followers</h3>
                                                    <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                                        <option selected="">This Month</option>
                                                        <option value="1">Last Month</option>
                                                        <option value="2">Last Year</option>
                                                    </select>
                                                </div>
                                            </div>
        
                                            <div class="default-table-area style-two">
                                                <div class="table-responsive">
                                                    <table class="table align-middle border-0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="pt-1">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <img src="assets/images/user-6.jpg" class="wh-44 rounded-circle" alt="user">
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Alex Davis</h6>
                                                                            <span class="fs-12 text-body">alex@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end pt-1">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <img src="assets/images/user-7.jpg" class="wh-44 rounded-circle" alt="user">
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Laura Martinez</h6>
                                                                            <span class="fs-12 text-body">laura@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <img src="assets/images/user-8.jpg" class="wh-44 rounded-circle" alt="user">
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Mark Thompson</h6>
                                                                            <span class="fs-12 text-body">mark@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <img src="assets/images/user-9.jpg" class="wh-44 rounded-circle" alt="user">
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Rachel White</h6>
                                                                            <span class="fs-12 text-body">rachel@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <img src="assets/images/user-10.jpg" class="wh-44 rounded-circle" alt="user">
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Kevin Lee</h6>
                                                                            <span class="fs-12 text-body">kevin@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-0 pb-4">
                                            <div class="p-4">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                                    <h3 class="mb-0">Following</h3>
                                                    <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                                        <option selected="">This Month</option>
                                                        <option value="1">Last Month</option>
                                                        <option value="2">Last Year</option>
                                                    </select>
                                                </div>
                                            </div>
        
                                            <div class="default-table-area style-two">
                                                <div class="table-responsive">
                                                    <table class="table align-middle border-0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="pt-1">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <img src="assets/images/user-11.jpg" class="wh-44 rounded-circle" alt="user">
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Lenore Crum</h6>
                                                                            <span class="fs-12 text-body">crum@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end pt-1">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <img src="assets/images/user-12.jpg" class="wh-44 rounded-circle" alt="user">
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Paul Bartlett</h6>
                                                                            <span class="fs-12 text-body">bartlett@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <img src="assets/images/user-13.jpg" class="wh-44 rounded-circle" alt="user">
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Nikki Lowe</h6>
                                                                            <span class="fs-12 text-body">lowe@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <img src="assets/images/user-14.jpg" class="wh-44 rounded-circle" alt="user">
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Milton Laskowski</h6>
                                                                            <span class="fs-12 text-body">laskowski@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <img src="assets/images/user-15.jpg" class="wh-44 rounded-circle" alt="user">
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2 position-relative top-2">
                                                                            <h6 class="mb-0 fs-14 fw-medium">Ethel Hillen</h6>
                                                                            <span class="fs-12 text-body">hillen@trezo.com</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="my-profile" class="wh-35 d-inline-block border text-center lh-35 rounded-circle text-decoration-none hover-bg">
                                                                        <i class="ri-arrow-right-up-line fs-18"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-6">
                                    <div class="card bg-white border-0 rounded-3 mb-4">
                                        <div class="card-body p-4 pb-2">
                                            <h3 class="mb-lg-4 mb-3">Photos</h3>
                                            <div class="row" style="--bs-gutter-x: 15px;">
                                                <div class="col-lg-4 col-sm-4">
                                                    <a href="profile" class="d-block mb-3">
                                                        <img src="assets/images/product-6.jpg" class="rounded-2" alt="product">
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 col-sm-4">
                                                    <a href="profile" class="d-block mb-3">
                                                        <img src="assets/images/product-7.jpg" class="rounded-2" alt="product">
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 col-sm-4">
                                                    <a href="profile" class="d-block mb-3">
                                                        <img src="assets/images/product-8.jpg" class="rounded-2" alt="product">
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 col-sm-4">
                                                    <a href="profile" class="d-block mb-3">
                                                        <img src="assets/images/product-9.jpg" class="rounded-2" alt="product">
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 col-sm-4">
                                                    <a href="profile" class="d-block mb-3">
                                                        <img src="assets/images/product-10.jpg" class="rounded-2" alt="product">
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 col-sm-4">
                                                    <a href="profile" class="d-block mb-3">
                                                        <img src="assets/images/product-11.jpg" class="rounded-2" alt="product">
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 col-sm-4">
                                                    <a href="profile" class="d-block mb-3">
                                                        <img src="assets/images/product-12.jpg" class="rounded-2" alt="product">
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 col-sm-4">
                                                    <a href="profile" class="d-block mb-3">
                                                        <img src="assets/images/product-13.jpg" class="rounded-2" alt="product">
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 col-sm-4">
                                                    <a href="profile" class="d-block mb-3">
                                                        <img src="assets/images/product-14.jpg" class="rounded-2" alt="product">
                                                    </a>
                                                </div>
                                            </div>
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
