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

				<div class="container-fluid">
            <div class="main-content d-flex flex-column">
                <!-- Start Header Area -->
                <header class="header-area bg-white mb-4 rounded-bottom-15" id="header-area">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-sm-6">
                            <div class="left-header-content">
                                <ul class="d-flex align-items-center ps-0 mb-0 list-unstyled justify-content-center justify-content-sm-start">
                                    <li>
                                        <button class="header-burger-menu bg-transparent p-0 border-0" id="header-burger-menu">
                                            <span class="material-symbols-outlined">menu</span>
                                        </button>
                                    </li>
                                    <li>
                                        <form class="src-form position-relative">
                                            <input type="text" class="form-control" placeholder="Search here.....">
                                            <button type="submit" class="src-btn position-absolute top-50 end-0 translate-middle-y bg-transparent p-0 border-0">
                                                <span class="material-symbols-outlined">search</span>
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <div class="dropdown notifications apps">
                                            <button class="btn btn-secondary border-0 p-0 position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="material-symbols-outlined">apps</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-lg p-0 border-0 py-4 px-3 max-h-312" data-simplebar>
                                                <div class="notification-menu d-flex flex-wrap justify-content-between gap-4">
                                                    <a href="https://www.figma.com/" target="_blank" class="dropdown-item p-0 text-center">
                                                        <img src="assets/images/figma.svg" class="wh-25" alt="united-states">
                                                        <span>Figma</span>
                                                    </a>
                                                    <a href="https://www.dribbble.com/" target="_blank" class="dropdown-item p-0 text-center">
                                                        <img src="assets/images/dribbble.svg" class="wh-25" alt="united-states">
                                                        <span>Dribbble</span>
                                                    </a>
                                                    <a href="https://www.spotify.com/" target="_blank" class="dropdown-item p-0 text-center">
                                                        <img src="assets/images/spotify.svg" class="wh-25" alt="united-states">
                                                        <span>Spotify</span>
                                                    </a>
                                                    <a href="https://www.github.com/" target="_blank" class="dropdown-item p-0 text-center">
                                                        <img src="assets/images/github.svg" class="wh-25" alt="united-states">
                                                        <span>Github</span>
                                                    </a>
                                                    <a href="https://www.google.com/drive/" target="_blank" class="dropdown-item p-0 text-center">
                                                        <img src="assets/images/gdrive.svg" class="wh-25" alt="united-states">
                                                        <span>GDrive</span>
                                                    </a>
                                                    <a href="https://www.trello.com/" target="_blank" class="dropdown-item p-0 text-center">
                                                        <img src="assets/images/trello.svg" class="wh-25" alt="united-states">
                                                        <span>Trello</span>
                                                    </a>
                                                    <a href="https://www.slak.com/" target="_blank" class="dropdown-item p-0 text-center">
                                                        <img src="assets/images/slak.svg" class="wh-25" alt="united-states">
                                                        <span>Slak</span>
                                                    </a>
                                                    <a href="https://www.pinterest.com/" target="_blank" class="dropdown-item p-0 text-center">
                                                        <img src="assets/images/pinterest.svg" class="wh-25" alt="united-states">
                                                        <span>Pinterest</span>
                                                    </a>
                                                    <a href="https://www.facebook.com/" target="_blank" class="dropdown-item p-0 text-center">
                                                        <img src="assets/images/facebook.svg" class="wh-25" alt="united-states">
                                                        <span>Facebook</span>
                                                    </a>
                                                    <a href="https://www.linkedin.com/" target="_blank" class="dropdown-item p-0 text-center">
                                                        <img src="assets/images/linkedin.svg" class="wh-25" alt="united-states">
                                                        <span>Linkedin</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-8 col-sm-6">
                            <div class="right-header-content mt-2 mt-sm-0">
                                <ul class="d-flex align-items-center justify-content-center justify-content-sm-end ps-0 mb-0 list-unstyled">
                                    <li class="header-right-item">
                                        <div class="light-dark">
                                            <button class="switch-toggle settings-btn dark-btn p-0 bg-transparent" id="switch-toggle">
                                                <span class="dark"><i class="material-symbols-outlined">light_mode</i></span> 
                                                <span class="light"><i class="material-symbols-outlined">dark_mode</i></span>
                                            </button>
                                        </div>
                                    </li>
                                    <li class="header-right-item">
                                        <div class="dropdown notifications language">
                                            <button class="btn btn-secondary dropdown-toggle border-0 p-0 position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="material-symbols-outlined">translate</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-lg p-0 border-0 dropdown-menu-end">
                                                <span class="fw-semibold fs-15 text-secondary title">Choose Language</span>
                                                <div class="max-h-275" data-simplebar>
                                                    <div class="notification-menu">
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/usa.svg" class="wh-30 rounded-circle" alt="united-states">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <span class="text-secondary fw-medium fs-14">English</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="notification-menu">
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/canada.svg" class="wh-30 rounded-circle" alt="spain">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <span class="text-secondary fw-medium fs-14">Canada</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="notification-menu">
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/germany.svg" class="wh-30 rounded-circle" alt="spain">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <span class="text-secondary fw-medium fs-14">Germany</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="notification-menu">
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/portugal.svg" class="wh-30 rounded-circle" alt="portugal">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <span class="text-secondary fw-medium fs-14">Portugal</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="notification-menu mb-0">
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/spain.svg" class="wh-30 rounded-circle" alt="spain">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <span class="text-secondary fw-medium fs-14">Spain</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="header-right-item">
                                        <button class="fullscreen-btn bg-transparent p-0 border-0" id="fullscreen-button">
                                            <i class="material-symbols-outlined text-body">fullscreen</i>
                                        </button>
                                    </li>
                                    <li class="header-right-item">
                                        <div class="dropdown notifications noti">
                                            <button class="btn btn-secondary border-0 p-0 position-relative badge" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="material-symbols-outlined">notifications</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-lg p-0 border-0 p-0 dropdown-menu-end">
                                                <div class="d-flex justify-content-between align-items-center title">
                                                    <span class="fw-semibold fs-15 text-secondary">Notifications <span class="fw-normal text-body fs-14">(03)</span></span>
                                                    <button class="p-0 m-0 bg-transparent border-0 fs-14 text-primary">Clear All</button>
                                                </div> 

                                                <div class="max-h-217" data-simplebar>
                                                    <div class="notification-menu">
                                                        <a href="notification" class="dropdown-item">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <i class="material-symbols-outlined text-primary">sms</i>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <p>You have requested to <span class="fw-semibold">withdrawal</span></p>
                                                                    <span class="fs-13">2 hrs ago</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="notification-menu unseen">
                                                        <a href="notification" class="dropdown-item">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <i class="material-symbols-outlined text-info">person</i>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <p>A new user added in Trezo</p>
                                                                    <span class="fs-13">3 hrs ago</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="notification-menu">
                                                        <a href="notification" class="dropdown-item">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <i class="material-symbols-outlined text-success">mark_email_unread</i>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <p>You have requested to <span class="fw-semibold">withdrawal</span></p>
                                                                    <span class="fs-13">1 day ago</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="notification-menu">
                                                        <a href="notification" class="dropdown-item">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <i class="material-symbols-outlined text-primary">sms</i>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <p>You have requested to <span class="fw-semibold">withdrawal</span></p>
                                                                    <span class="fs-13">2 hrs ago</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="notification-menu unseen">
                                                        <a href="notification" class="dropdown-item">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <i class="material-symbols-outlined text-info">person</i>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <p>A new user added in Trezo</p>
                                                                    <span class="fs-13">3 hrs ago</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="notification-menu">
                                                        <a href="notification" class="dropdown-item">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <i class="material-symbols-outlined text-success">mark_email_unread</i>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <p>You have requested to <span class="fw-semibold">withdrawal</span></p>
                                                                    <span class="fs-13">1 day ago</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>

                                                <a href="notification" class="dropdown-item text-center text-primary d-block view-all fw-medium rounded-bottom-3">
                                                    <span>See All Notifications </span>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="header-right-item">
                                        <div class="dropdown admin-profile">
                                            <div class="d-xxl-flex align-items-center bg-transparent border-0 text-start p-0 cursor dropdown-toggle" data-bs-toggle="dropdown">
                                                <div class="flex-shrink-0">
                                                    <img class="rounded-circle wh-40 administrator" src="assets/images/administrator.jpg" alt="admin">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-none d-xxl-block">
                                                            <div class="d-flex align-content-center">
                                                                <h3>Olivia</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="dropdown-menu border-0 bg-white dropdown-menu-end">
                                                <div class="d-flex align-items-center info">
                                                    <div class="flex-shrink-0">
                                                        <img class="rounded-circle wh-30 administrator" src="assets/images/administrator.jpg" alt="admin">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h3 class="fw-medium">William John</h3>
                                                        <span class="fs-12">Marketing Manager</span>
                                                    </div>
                                                </div>
                                                <ul class="admin-link ps-0 mb-0 list-unstyled">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center text-body" href="my-profile">
                                                            <i class="material-symbols-outlined">account_circle</i>
                                                            <span class="ms-2">My Profile</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center text-body" href="chat">
                                                            <i class="material-symbols-outlined">chat</i>
                                                            <span class="ms-2">Messages</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center text-body" href="to-do-list">
                                                            <i class="material-symbols-outlined">format_list_bulleted </i>
                                                            <span class="ms-2">My Task</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center text-body" href="my-profile">
                                                            <i class="material-symbols-outlined">credit_card </i>
                                                            <span class="ms-2">Billing</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <ul class="admin-link ps-0 mb-0 list-unstyled">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center text-body" href="settings">
                                                            <i class="material-symbols-outlined">settings </i>
                                                            <span class="ms-2">Settings</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center text-body" href="tickets">
                                                            <i class="material-symbols-outlined">support</i>
                                                            <span class="ms-2">Support</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center text-body" href="lock-screen">
                                                            <i class="material-symbols-outlined">lock</i>
                                                            <span class="ms-2">Lock Screen</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center text-body" href="login">
                                                            <i class="material-symbols-outlined">logout</i>
                                                            <span class="ms-2">Logout</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="header-right-item">
                                        <button class="theme-settings-btn p-0 border-0 bg-transparent" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                                            <i class="material-symbols-outlined" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Click On Theme Settings">settings</i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- End Header Area -->

                <div class="main-content-container overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <h3 class="mb-0">Tickets</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">HelpDesk</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Tickets</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-3">
                                    <span>Tickets Resolved</span>
                                    <h3 class="mb-0 fs-20">2.4k</h3>
                                    <div id="tickets_resolved" style="margin: -11px 0;"></div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fs-12">This Month</span>
                                        <i class="material-symbols-outlined text-success">trending_up</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-3">
                                    <span>In Progress</span>
                                    <h3 class="mb-0 fs-20">1.35k</h3>
                                    <div id="in_progress" style="margin: -11px 0;"></div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fs-12">This Month</span>
                                        <i class="material-symbols-outlined text-danger">trending_down</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-3">
                                    <span>Tickets Due</span>
                                    <h3 class="mb-0 fs-20">980</h3>
                                    <div id="tickets_due" style="margin: -11px 0;"></div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fs-12">This Month</span>
                                        <i class="material-symbols-outlined text-danger">trending_down</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-3">
                                    <span>Tickets New Open</span>
                                    <h3 class="mb-0 fs-20">3.25k</h3>
                                    <div id="tickets_new_open" style="margin: -11px 0;"></div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fs-12">This Month</span>
                                        <i class="material-symbols-outlined text-success">trending_up</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                                <h3 class="mb-0">All Tickets</h3>
                                <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                    <span class="py-sm-1 d-block">
                                        <i class="ri-add-line d-none d-sm-inline-block"></i>
                                        <span>Add New Ticket</span>
                                    </span>
                                </button>
                            </div>

                            <div class="default-table-area all-projects">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Ticket Title</th>
                                                <th scope="col">Requester</th>
                                                <th scope="col">Assigned To</th>
                                                <th scope="col">Created Date</th>
                                                <th scope="col">Due Date</th>
                                                <th scope="col">Priority</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-body">#854</td>
                                                <td>
                                                    <a href="ticket-details" class="fw-medium">Network Infrastructure</a>
                                                </td>
                                                <td class="text-secondary">Walter Frazier</td>
                                                <td class="text-secondary">Oliver Clark</td>
                                                <td class="text-secondary">20 Apr 2024</td>
                                                <td class="text-secondary">30 Apr 2024</td>
                                                <td class="text-secondary">High</td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Finished</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#853</td>
                                                <td>
                                                    <a href="ticket-details" class="fw-medium">Cloud Migration</a>
                                                </td>
                                                <td class="text-secondary">Kimberly Anderson</td>
                                                <td class="text-secondary">Ethan Baker</td>
                                                <td class="text-secondary">21 Apr 2024</td>
                                                <td class="text-secondary">25 Apr 2024</td>
                                                <td class="text-secondary">Low</td>
                                                <td>
                                                    <span class="badge bg-warning bg-opacity-10 text-warning p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#852</td>
                                                <td>
                                                    <a href="ticket-details" class="fw-medium">Website Revamp</a>
                                                </td>
                                                <td class="text-secondary">Roscoe Guerrero</td>
                                                <td class="text-secondary">Sophia Carter</td>
                                                <td class="text-secondary">17 Apr 2024</td>
                                                <td class="text-secondary">20 Apr 2024</td>
                                                <td class="text-secondary">Medium</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">In Progress</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#851</td>
                                                <td>
                                                    <a href="ticket-details" class="fw-medium">System Deployment</a>
                                                </td>
                                                <td class="text-secondary">Robert Stewart</td>
                                                <td class="text-secondary">Ava Cooper</td>
                                                <td class="text-secondary">10 Apr 2024</td>
                                                <td class="text-secondary">15 Apr 2024</td>
                                                <td class="text-secondary">High</td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Finished</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#850</td>
                                                <td>
                                                    <a href="ticket-details" class="fw-medium">System Deployment</a>
                                                </td>
                                                <td class="text-secondary">Dustin Fritch</td>
                                                <td class="text-secondary">Isabella Evans</td>
                                                <td class="text-secondary">05 Apr 2024</td>
                                                <td class="text-secondary">10 Apr 2024</td>
                                                <td class="text-secondary">Low</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Cancelled</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#849</td>
                                                <td>
                                                    <a href="ticket-details" class="fw-medium">Login Issues</a>
                                                </td>
                                                <td class="text-secondary">Walter Frazier</td>
                                                <td class="text-secondary">Oliver Clark</td>
                                                <td class="text-secondary">20 Apr 2024</td>
                                                <td class="text-secondary">30 Apr 2024</td>
                                                <td class="text-secondary">High</td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Finished</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#848</td>
                                                <td>
                                                    <a href="ticket-details" class="fw-medium">Email Configuration</a>
                                                </td>
                                                <td class="text-secondary">Kimberly Anderson</td>
                                                <td class="text-secondary">Ethan Baker</td>
                                                <td class="text-secondary">17 Apr 2024</td>
                                                <td class="text-secondary">25 Apr 2024</td>
                                                <td class="text-secondary">Low</td>
                                                <td>
                                                    <span class="badge bg-warning bg-opacity-10 text-warning p-2 fs-12 fw-normal">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#847</td>
                                                <td>
                                                    <a href="ticket-details" class="fw-medium">Application Error</a>
                                                </td>
                                                <td class="text-secondary">Roscoe Guerrero</td>
                                                <td class="text-secondary">Sophia Carter</td>
                                                <td class="text-secondary">17 Apr 2024</td>
                                                <td class="text-secondary">20 Apr 2024</td>
                                                <td class="text-secondary">Medium</td>
                                                <td>
                                                    <span class="badge bg-success bg-opacity-10 text-success p-2 fs-12 fw-normal">In Progress</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#846</td>
                                                <td>
                                                    <a href="ticket-details" class="fw-medium">Software Installation</a>
                                                </td>
                                                <td class="text-secondary">Robert Stewart</td>
                                                <td class="text-secondary">Ava Cooper</td>
                                                <td class="text-secondary">10 Apr 2024</td>
                                                <td class="text-secondary">15 Apr 2024</td>
                                                <td class="text-secondary">High</td>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 fs-12 fw-normal">Finished</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td class="text-body">#855</td>
                                                <td>
                                                    <a href="ticket-details" class="fw-medium">System Upgrade</a>
                                                </td>
                                                <td class="text-secondary">Dustin Fritch</td>
                                                <td class="text-secondary">Isabella Evans</td>
                                                <td class="text-secondary">05 Apr 2024</td>
                                                <td class="text-secondary">10 Apr 2024</td>
                                                <td class="text-secondary">Low</td>
                                                <td>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 fs-12 fw-normal">Cancelled</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-primary">visibility</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-body">edit</i>
                                                        </button>
                                                        <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                                            <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                                                        </button>
                                                    </div>
                                                </td> 
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
    
                                <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap">
                                    <span class="fs-13 fw-medium">Items per pages: 5</span>
    
                                    <div class="d-flex align-items-center">
                                        <span class="fs-13 fw-medium me-2">1 - 5 of 12</span>
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0 justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link icon" href="course-details" aria-label="Previous">
                                                        <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link icon" href="course-details" aria-label="Next">
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

                <div class="flex-grow-1"></div>

                <!-- Start Footer Area -->
                <footer class="footer-area bg-white text-center rounded-top-7">
                    <p class="fs-14">© <span class="text-primary-div">Trezo</span> is Proudly Owned by <a href="https://envytheme.com/" target="_blank" class="text-decoration-none text-primary">EnvyTheme</a></p>
                </footer>
                <!-- End Footer Area -->
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
