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
                        <h3 class="mb-0">Compose</h3>

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
                                    <span class="fw-medium">Compose</span>
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
                                        <h3 class="fs-16 fw-semibold mb-0">New Message</h3>
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

                                    <form>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary fs-14">To</label>
                                                    <select class="form-select form-control h-55" aria-label="Default select example">
                                                        <option selected>To</option>
                                                        <option value="1">james@trezo.com</option>
                                                        <option value="2">andy@trezo.com</option>
                                                        <option value="3">mateo@trezo.com</option>
                                                        <option value="4">luca@trezo.com</option>
                                                        <option value="5">luca@trezo.com</option>
                                                        <option value="6">tomato@trezo.com</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary fs-14">Cc</label>
                                                    <select class="form-select form-control h-55" aria-label="Default select example">
                                                        <option selected>Cc</option>
                                                        <option value="1">james@trezo.com</option>
                                                        <option value="2">andy@trezo.com</option>
                                                        <option value="3">mateo@trezo.com</option>
                                                        <option value="4">luca@trezo.com</option>
                                                        <option value="5">luca@trezo.com</option>
                                                        <option value="6">tomato@trezo.com</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary fs-14">Bcc</label>
                                                    <select class="form-select form-control h-55" aria-label="Default select example">
                                                        <option selected>Bcc</option>
                                                        <option value="1">james@trezo.com</option>
                                                        <option value="2">andy@trezo.com</option>
                                                        <option value="3">mateo@trezo.com</option>
                                                        <option value="4">luca@trezo.com</option>
                                                        <option value="5">luca@trezo.com</option>
                                                        <option value="6">tomato@trezo.com</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary fs-14">Subject</label>
                                                    <input type="text" class="form-control h-55" placeholder="Write your subject...">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary fs-14">Description</label>
                                                    <div id="standalone-container">
                                                        <div id="toolbar-container" class="rounded-top-2">
                                                            <span class="ql-formats">
                                                                <select class="ql-font"></select>
                                                                <select class="ql-size"></select>
                                                            </span>
                                                            <span class="ql-formats">
                                                                <button class="ql-bold"></button>
                                                                <button class="ql-italic"></button>
                                                                <button class="ql-underline"></button>
                                                                <button class="ql-strike"></button>
                                                            </span>
                                                            <span class="ql-formats">
                                                                <button class="ql-blockquote"></button>
                                                                <button class="ql-code-block"></button>
                                                            </span>
                                                            <span class="ql-formats">
                                                                <button class="ql-list" value="ordered"></button>
                                                                <button class="ql-list" value="bullet"></button>
                                                                <button class="ql-indent" value="-1"></button>
                                                                <button class="ql-indent" value="+1"></button>
                                                            </span>
                                                            <span class="ql-formats">
                                                                <button class="ql-link"></button>
                                                                <button class="ql-image"></button>
                                                                <button class="ql-video"></button>
                                                            </span>
                                                        </div>
                                                        <div id="editor-container" style="height: 250px; border-color: #D5D9E2;" class="rounded-bottom-2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                                    <button class="btn btn-primary text-white fw-semibold py-2 px-4 me-4" type="submit">
                                                        Send
                                                    </button>
                                                    <div class="position-relative top-3 d-flex align-items-baseline flex-wrap gap-sm-0">
                                                        <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Text">
                                                            <i class="material-symbols-outlined fs-20 text-body hover">text_fields_alt</i>
                                                        </button>
                                                        <button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="File">
                                                            <i class="material-symbols-outlined fs-20 text-body hover">attach_file</i>
                                                        </button>
                                                        <button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Link">
                                                            <i class="material-symbols-outlined fs-20 text-body hover">link</i>
                                                        </button>
                                                        <button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Mood">
                                                            <i class="material-symbols-outlined fs-20 text-body hover">mood</i>
                                                        </button>
                                                        <button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Drive">
                                                            <i class="material-symbols-outlined fs-20 text-body hover">add_to_drive</i>
                                                        </button>
                                                        <button class="p-0 border-0 bg-transparent ms-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pen">
                                                            <i class="material-symbols-outlined fs-20 text-body hover">ink_pen</i>
                                                        </button>
                                                        <div class="dropdown action-opt ms-3 position-relative top-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Option">
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
                                            </div>
                                        </div>
                                    </form>
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
