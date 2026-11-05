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
                        <h3 class="mb-0">Create Project</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Project Management</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Create Project</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                                    <h3 class="mb-0">Create a new project</h3>
                                </div>

                                <form>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label class="label">Project Name</label>
                                                <input type="text" class="form-control" placeholder="Write project name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label class="label">Project ID</label>
                                                <input type="text" class="form-control" placeholder="Write project ID">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label class="label">Start Date</label>
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label class="label">End Date</label>
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-4">
                                                <label class="label">Project Description</label>
                                                <textarea rows="5" class="form-control" placeholder="Type here......"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label class="label">Budget</label>
                                                <input type="text" class="form-control" placeholder="Enter budget">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label class="label">Priority Status</label>
                                                <select class="form-select form-control" aria-label="Default select example">
                                                    <option selected>Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label class="label">Categories</label>
                                                <select class="form-select form-control" aria-label="Default select example">
                                                    <option selected>Select</option>
                                                    <option value="1">WP</option>
                                                    <option value="2">HTML</option>
                                                    <option value="2">Vue</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label class="label">Project Manager</label>
                                                <select class="form-select form-control" aria-label="Default select example">
                                                    <option selected>Select</option>
                                                    <option value="1">Alex</option>
                                                    <option value="2">Staven</option>
                                                    <option value="2">Juhon</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label class="label">Add team Members</label>
                                                <select class="form-select form-control" aria-label="Default select example">
                                                    <option selected>Select</option>
                                                    <option value="1">Alex</option>
                                                    <option value="2">Staven</option>
                                                    <option value="2">Juhon</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label class="label">Project Tags</label>
                                                <select class="form-select form-control" aria-label="Default select example">
                                                    <option selected>Select</option>
                                                    <option value="1">HTML</option>
                                                    <option value="2">WP</option>
                                                    <option value="2">Vue</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label class="label">Project Preview Image</label>
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
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label class="label">Attached File</label>
                                                <div class="form-control h-100 text-center position-relative p-4 p-lg-5">
                                                    <div class="product-upload">
                                                        <label for="file-upload" class="file-upload mb-0">
                                                            <i class="ri-file-line bg-primary bg-opacity-10 p-2 rounded-1 text-primary"></i>
                                                            <span class="d-block text-body fs-14">Drag and drop a file or <span class="text-primary text-decoration-underline">Browse</span></span>
                                                        </label>
                                                        <input id="file-upload" type="file">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="d-flex flex-wrap gap-3">
                                                <button class="btn btn-danger py-2 px-4 fw-medium fs-16 text-white">Cancel</button>
                                                <button class="btn btn-primary py-2 px-4 fw-medium fs-16"> <i class="ri-add-line text-white fw-medium"></i> Create Project</button>
                                            </div>
                                        </div>
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
