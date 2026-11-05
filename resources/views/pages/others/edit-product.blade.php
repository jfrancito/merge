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
                        <h3 class="mb-0">Edit Product</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">eCommerce</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Edit Product</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-xxl-8 col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Add A Product</h3>
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Product Title</label>
                                                    <input type="text" class="form-control h-55" value="E.g. Google Pixel 7 Pro">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 ol-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Product Type</label>
                                                    <select class="form-select form-control h-55" aria-label="Default select example">
                                                        <option selected>Digital Product</option>
                                                        <option value="1">Select</option>
                                                        <option value="2">Physical Product</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">SKU</label>
                                                    <input type="text" class="form-control h-55" value="E.g. ABC-12345">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Product Type</label>
                                                    <select class="form-select form-control h-55" aria-label="Default select example">
                                                        <option selected>Emburo</option>
                                                        <option value="1">Select</option>
                                                        <option value="2">Fediz</option>
                                                        <option value="3">Debilop</option>
                                                        <option value="4">Canin</option>
                                                        <option value="5">Daxa</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary fs-14">Product Description</label>
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
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Regular Price</label>
                                                    <input type="text" class="form-control h-55" value="E.g. $99">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Sale Price</label>
                                                    <input type="text" class="form-control h-55" value="E.g. $29">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Publish Schedule</label>
                                                    <input type="date" class="form-control h-55">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Product in Stock</label>
                                                    <input type="text" class="form-control h-55" value="E.g. 17">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Product ID</label>
                                                    <input type="text" class="form-control h-55" value="E.g. #JAN-2345">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Discount / Offer</label>
                                                    <input type="text" class="form-control h-55" placeholder="E.g. $20">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Available Date</label>
                                                    <input type="date" class="form-control h-55">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">End Date</label>
                                                    <input type="date" class="form-control h-55">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Upload Product Images</label>
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
                                            <div class="col-lg-12">
                                                <div class="d-flex flex-wrap gap-3">
                                                    <button class="btn btn-danger py-2 px-4 fw-medium fs-16 text-white">Cancel</button>
                                                    <button class="btn btn-primary py-2 px-4 fw-medium fs-16"> <i class="ri-add-line text-white fw-medium"></i> Create Product</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Product Category & Tags</h3>

                                    <form>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Category</label>
                                                    <select class="form-select form-control h-55" aria-label="Default select example">
                                                        <option selected>watch</option>
                                                        <option value="1">Select</option>
                                                        <option value="2">headphone</option>
                                                        <option value="3">mobile</option>
                                                        <option value="4">speaker</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Vendor</label>
                                                    <select class="form-select form-control h-55" aria-label="Default select example">
                                                        <option selected>Dennis Matthews</option>
                                                        <option value="1">Select</option>
                                                        <option value="2">Susan Rader</option>
                                                        <option value="3">Douglas Harvey</option>
                                                        <option value="4">John Valdez</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-6">
                                                <div class="form-group mb-4">
                                                    <label class="label text-secondary">Collection</label>
                                                    <select class="form-select form-control h-55" aria-label="Default select example">
                                                        <option selected>Collection 1</option>
                                                        <option value="1">Select</option>
                                                        <option value="2">Collection 2</option>
                                                        <option value="3">Collection 3</option>
                                                        <option value="4">Collection 4</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-6">
                                                <div class="form-group mb-0">
                                                    <label class="label text-secondary">Tags</label>
                                                    <select class="form-select form-control h-55" aria-label="Default select example">
                                                        <option selected>watch</option>
                                                        <option value="1">Select</option>
                                                        <option value="2">headphone</option>
                                                        <option value="3">mobile</option>
                                                        <option value="4">speaker</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h3 class="mb-3 mb-lg-4">Other Options</h3>

                                    <form>
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary">Title</label>
                                            <input type="text" class="form-control h-55" value="E.g. Google Pixel 7 Pro">
                                        </div>
                                        <div class="form-group mb-0">
                                            <label class="label text-secondary">Description</label>
                                            <textarea rows="6" class="form-control" placeholder="Type here...."></textarea>
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
