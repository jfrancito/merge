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
                        <h3 class="mb-0">Clients</h3>

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
                                    <span class="fw-medium">Clients</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-body pe-3 pb-3 bg-for-dark-mode">
                                            <img src="assets/images/client-1.jpg" class="wh-80 rounded-3" alt="client">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-20 pb-0">
                                        <h4 class="mb-1 fs-16 fw-semibold">CodeCraft</h4>
                                        <span>info@codecraft.com</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Name:</span>
                                            <span class="fw-medium text-secondary">Olivia Taylor</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Phone:</span>
                                            <span class="fw-medium text-secondary">(555) 555-5555</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="fw-medium">Projects:</span>
                                            <span class="fw-medium text-secondary">12</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <a href="chat" class="btn btn-primary py-2 fw-medium">Message</a>
                                        <a href="project-overview" class="btn btn-outline-primary py-2 fw-medium ms-3">View Project</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-body pe-3 pb-3 bg-for-dark-mode">
                                            <img src="assets/images/client-2.jpg" class="wh-80 rounded-3" alt="client">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-20 pb-0">
                                        <h4 class="mb-1 fs-16 fw-semibold">ByteSavvy</h4>
                                        <span>info@bytesavvy.com</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Name:</span>
                                            <span class="fw-medium text-secondary">David Smith</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Phone:</span>
                                            <span class="fw-medium text-secondary">(555) 123-4567</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="fw-medium">Projects:</span>
                                            <span class="fw-medium text-secondary">16</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <a href="chat" class="btn btn-primary py-2 fw-medium">Message</a>
                                        <a href="project-overview" class="btn btn-outline-primary py-2 fw-medium ms-3">View Project</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-body pe-3 pb-3 bg-for-dark-mode">
                                            <img src="assets/images/client-3.jpg" class="wh-80 rounded-3" alt="client">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-20 pb-0">
                                        <h4 class="mb-1 fs-16 fw-semibold">DataTech</h4>
                                        <span>info@datatech.com</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Name:</span>
                                            <span class="fw-medium text-secondary">Alice Johnson</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Phone:</span>
                                            <span class="fw-medium text-secondary">(555) 234-5678</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="fw-medium">Projects:</span>
                                            <span class="fw-medium text-secondary">07</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <a href="chat" class="btn btn-primary py-2 fw-medium">Message</a>
                                        <a href="project-overview" class="btn btn-outline-primary py-2 fw-medium ms-3">View Project</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-body pe-3 pb-3 bg-for-dark-mode">
                                            <img src="assets/images/client-4.jpg" class="wh-80 rounded-3" alt="client">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-20 pb-0">
                                        <h4 class="mb-1 fs-16 fw-semibold">CyberByte</h4>
                                        <span>info@cyberbyte.com</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Name:</span>
                                            <span class="fw-medium text-secondary">Emily Brown</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Phone:</span>
                                            <span class="fw-medium text-secondary">(555) 345-6789</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="fw-medium">Projects:</span>
                                            <span class="fw-medium text-secondary">05</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <a href="chat" class="btn btn-primary py-2 fw-medium">Message</a>
                                        <a href="project-overview" class="btn btn-outline-primary py-2 fw-medium ms-3">View Project</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-body pe-3 pb-3 bg-for-dark-mode">
                                            <img src="assets/images/client-5.jpg" class="wh-80 rounded-3" alt="client">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-20 pb-0">
                                        <h4 class="mb-1 fs-16 fw-semibold">NetGen</h4>
                                        <span>info@netgen.com</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Name:</span>
                                            <span class="fw-medium text-secondary">James Wilson</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Phone:</span>
                                            <span class="fw-medium text-secondary">(555) 456-7890</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="fw-medium">Projects:</span>
                                            <span class="fw-medium text-secondary">14</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <a href="chat" class="btn btn-primary py-2 fw-medium">Message</a>
                                        <a href="project-overview" class="btn btn-outline-primary py-2 fw-medium ms-3">View Project</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-body pe-3 pb-3 bg-for-dark-mode">
                                            <img src="assets/images/client-6.jpg" class="wh-80 rounded-3" alt="client">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-20 pb-0">
                                        <h4 class="mb-1 fs-16 fw-semibold">TechFuse</h4>
                                        <span>info@techfuse.com</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Name:</span>
                                            <span class="fw-medium text-secondary">Michael Jones</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Phone:</span>
                                            <span class="fw-medium text-secondary">(555) 567-8901</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="fw-medium">Projects:</span>
                                            <span class="fw-medium text-secondary">18</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <a href="chat" class="btn btn-primary py-2 fw-medium">Message</a>
                                        <a href="project-overview" class="btn btn-outline-primary py-2 fw-medium ms-3">View Project</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-body pe-3 pb-3 bg-for-dark-mode">
                                            <img src="assets/images/client-7.jpg" class="wh-80 rounded-3" alt="client">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-20 pb-0">
                                        <h4 class="mb-1 fs-16 fw-semibold">CodeGen</h4>
                                        <span>info@codegen.com</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Name:</span>
                                            <span class="fw-medium text-secondary">Sophia Martinez</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Phone:</span>
                                            <span class="fw-medium text-secondary">(555) 678-9012</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="fw-medium">Projects:</span>
                                            <span class="fw-medium text-secondary">34</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <a href="chat" class="btn btn-primary py-2 fw-medium">Message</a>
                                        <a href="project-overview" class="btn btn-outline-primary py-2 fw-medium ms-3">View Project</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-body pe-3 pb-3 bg-for-dark-mode">
                                            <img src="assets/images/client-8.jpg" class="wh-80 rounded-3" alt="client">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-20 pb-0">
                                        <h4 class="mb-1 fs-16 fw-semibold">WebWiz</h4>
                                        <span>info@webwiz.com</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Name:</span>
                                            <span class="fw-medium text-secondary">William Davis</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Phone:</span>
                                            <span class="fw-medium text-secondary">(555) 789-0123</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="fw-medium">Projects:</span>
                                            <span class="fw-medium text-secondary">08</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <a href="chat" class="btn btn-primary py-2 fw-medium">Message</a>
                                        <a href="project-overview" class="btn btn-outline-primary py-2 fw-medium ms-3">View Project</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-body pe-3 pb-3 bg-for-dark-mode">
                                            <img src="assets/images/client-9.jpg" class="wh-80 rounded-3" alt="client">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-20 pb-0">
                                        <h4 class="mb-1 fs-16 fw-semibold">ByteTech</h4>
                                        <span>info@bytetech.com</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Name:</span>
                                            <span class="fw-medium text-secondary">Ava Anderson</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Phone:</span>
                                            <span class="fw-medium text-secondary">(555) 890-1234</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="fw-medium">Projects:</span>
                                            <span class="fw-medium text-secondary">03</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <a href="chat" class="btn btn-primary py-2 fw-medium">Message</a>
                                        <a href="project-overview" class="btn btn-outline-primary py-2 fw-medium ms-3">View Project</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-body pe-3 pb-3 bg-for-dark-mode">
                                            <img src="assets/images/client-10.jpg" class="wh-80 rounded-3" alt="client">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-20 pb-0">
                                        <h4 class="mb-1 fs-16 fw-semibold">CloudFlex</h4>
                                        <span>info@cloudflex.com</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Name:</span>
                                            <span class="fw-medium text-secondary">Ethan Thomas</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Phone:</span>
                                            <span class="fw-medium text-secondary">(555) 901-2345</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="fw-medium">Projects:</span>
                                            <span class="fw-medium text-secondary">10</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <a href="chat" class="btn btn-primary py-2 fw-medium">Message</a>
                                        <a href="project-overview" class="btn btn-outline-primary py-2 fw-medium ms-3">View Project</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-body pe-3 pb-3 bg-for-dark-mode">
                                            <img src="assets/images/client-11.jpg" class="wh-80 rounded-3" alt="client">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-20 pb-0">
                                        <h4 class="mb-1 fs-16 fw-semibold">WebWorx</h4>
                                        <span>info@webWorx.com</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Name:</span>
                                            <span class="fw-medium text-secondary">Isabella Clark</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Phone:</span>
                                            <span class="fw-medium text-secondary">(555) 012-3456</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="fw-medium">Projects:</span>
                                            <span class="fw-medium text-secondary">25</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <a href="chat" class="btn btn-primary py-2 fw-medium">Message</a>
                                        <a href="project-overview" class="btn btn-outline-primary py-2 fw-medium ms-3">View Project</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-body pe-3 pb-3 bg-for-dark-mode">
                                            <img src="assets/images/client-12.jpg" class="wh-80 rounded-3" alt="client">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-20 pb-0">
                                        <h4 class="mb-1 fs-16 fw-semibold">TechSync</h4>
                                        <span>info@techsync.com</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <ul class="ps-0 mb-4 list-unstyled">
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Name:</span>
                                            <span class="fw-medium text-secondary">Alexander Lewis</span>
                                        </li>
                                        <li class="mb-2 pb-1">
                                            <span class="fw-medium">Phone:</span>
                                            <span class="fw-medium text-secondary">(555) 210-9876</span>
                                        </li>
                                        <li class="mb-0">
                                            <span class="fw-medium">Projects:</span>
                                            <span class="fw-medium text-secondary">15</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <a href="chat" class="btn btn-primary py-2 fw-medium">Message</a>
                                        <a href="project-overview" class="btn btn-outline-primary py-2 fw-medium ms-3">View Project</a>
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
