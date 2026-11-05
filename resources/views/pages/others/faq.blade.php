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
                        <h3 class="mb-0">FAQ’s</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Front Pages</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">FAQ’s</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body py-md-5 p-4">
                            <div class="text-center mw-548 m-auto mb-5">
                                <h3 class="fs-24">Frequently Asked Questions</h3>
                                <p>Trezo offers customization options to tailor the platform to your team's unique requirements. You can customize workflows, templates, and dashboards to align with your processes.</p>
                            </div>

                            <div class="accordion faq-wrapper mw-740 m-auto" id="accordionExample">
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            What is Trezo?
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            What features does Trezo offer?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            How can Trezo benefit my team?
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree4" aria-expanded="false" aria-controls="collapseThree4">
                                            Is Trezo suitable for small businesses?
                                        </button>
                                    </h2>
                                    <div id="collapseThree4" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree5" aria-expanded="false" aria-controls="collapseThree5">
                                            Can I customize Trezo to fit my team's specific needs?
                                        </button>
                                    </h2>
                                    <div id="collapseThree5" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree6" aria-expanded="false" aria-controls="collapseThree6">
                                            Is Trezo cloud-based or on-premises?
                                        </button>
                                    </h2>
                                    <div id="collapseThree6" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree7" aria-expanded="false" aria-controls="collapseThree7">
                                            Does Trezo integrate with other tools?
                                        </button>
                                    </h2>
                                    <div id="collapseThree7" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree8" aria-expanded="false" aria-controls="collapseThree8">
                                            How secure is Trezo?
                                        </button>
                                    </h2>
                                    <div id="collapseThree8" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree9" aria-expanded="false" aria-controls="collapseThree9">
                                            Can I try Trezo before purchasing?
                                        </button>
                                    </h2>
                                    <div id="collapseThree9" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree10" aria-expanded="false" aria-controls="collapseThree10">
                                            What type of customer support does Trezo provide?
                                        </button>
                                    </h2>
                                    <div id="collapseThree10" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree11" aria-expanded="false" aria-controls="collapseThree11">
                                            How do I get started with Trezo?
                                        </button>
                                    </h2>
                                    <div id="collapseThree11" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree12" aria-expanded="false" aria-controls="collapseThree12">
                                            Does Trezo offer training for new users?
                                        </button>
                                    </h2>
                                    <div id="collapseThree12" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree13" aria-expanded="false" aria-controls="collapseThree13">
                                            Is Trezo GDPR compliant?
                                        </button>
                                    </h2>
                                    <div id="collapseThree13" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree14" aria-expanded="false" aria-controls="collapseThree14">
                                            Does Trezo offer a mobile app?
                                        </button>
                                    </h2>
                                    <div id="collapseThree14" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree15" aria-expanded="false" aria-controls="collapseThree15">
                                            How does billing work for Trezo?
                                        </button>
                                    </h2>
                                    <div id="collapseThree15" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree16" aria-expanded="false" aria-controls="collapseThree16">
                                            Can I cancel my Trezo subscription at any time?
                                        </button>
                                    </h2>
                                    <div id="collapseThree16" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree17" aria-expanded="false" aria-controls="collapseThree17">
                                            Can I track time spent on tasks with Trezo?
                                        </button>
                                    </h2>
                                    <div id="collapseThree17" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree18" aria-expanded="false" aria-controls="collapseThree18">
                                            Does Trezo offer recurring task capabilities?
                                        </button>
                                    </h2>
                                    <div id="collapseThree18" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-3 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree19" aria-expanded="false" aria-controls="collapseThree19">
                                            Does Trezo offer Gantt chart functionality?
                                        </button>
                                    </h2>
                                    <div id="collapseThree19" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-0 border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button text-secondary bg-body collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree20" aria-expanded="false" aria-controls="collapseThree20">
                                            Can I generate custom reports in Trezo?
                                        </button>
                                    </h2>
                                    <div id="collapseThree20" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
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
