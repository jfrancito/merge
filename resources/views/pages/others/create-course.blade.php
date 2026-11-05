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
                        <h3 class="mb-0">Create Course</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">LMS</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Create Course</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-4">Add Course</h3>

                                    <form>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Title</label>
                                                    <input type="text" class="form-control h-55 text-secondary" placeholder="Write title">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary fs-14">Your Email</label>
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
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Price</label>
                                                    <input type="text" class="form-control h-55 text-secondary" placeholder="Write price">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Price</label>
                                                    <input type="date" class="form-control h-55 text-secondary">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Price</label>
                                                    <input type="date" class="form-control h-55 text-secondary">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Instructor</label>
                                                    <select class="form-select form-control text-dark h-55 cursor" aria-label="Default select example">
                                                        <option selected>Select</option>
                                                        <option value="1">Olivia Clark</option>
                                                        <option value="2">Ava Turner</option>
                                                        <option value="3">Lucas Morgan</option>
                                                        <option value="4">Isabella Cooper</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Tags</label>
                                                    <select class="form-select form-control text-dark h-55 cursor" aria-label="Default select example">
                                                        <option selected>Select</option>
                                                        <option value="1">Technology </option>
                                                        <option value="2">Science</option>
                                                        <option value="3">Health & Wellness</option>
                                                        <option value="4">Education</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="label text-secondary">Project Preview Image</label>
                                                    <div class="form-control h-100 text-center position-relative p-4 p-lg-5">
                                                        <div class="product-upload">
                                                            <label for="file-upload" class="file-upload mb-0">
                                                                <i class="ri-folder-image-line bg-primary bg-opacity-10 p-2 rounded-1 text-primary"></i>
                                                                <span class="d-block text-body fs-14">Drag and drop an image or <span class="text-primary text-decoration-underline">Browse</span></span>
                                                            </label>
                                                            <input id="file-upload" type="file">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-4">Add Course</h3>

                                    <form>
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Lesson Title</label>
                                            <input type="text" class="form-control h-55" placeholder="Write Lesson Title">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Lesson Time</label>
                                            <input type="time" class="form-control h-55">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Lesson Description</label>
                                            <textarea rows="5" class="form-control" placeholder="Type here...."></textarea>
                                        </div>
                                        <div class="d-flex flex-wrap gap-3 justify-content-between">
                                            <button class="btn btn-danger fs-16 fw-medium text-white py-2 px-4">
                                                <span class="d-inline-block py-1">Save Course</span>
                                            </button>
                                            <button class="btn btn-primary fs-16 fw-medium text-white py-2 px-4">
                                                <i class="ri-add-line text-white fw-medium fs-18"></i>
                                                <span class="d-inline-block py-1">Add More Field</span>
                                            </button>
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
