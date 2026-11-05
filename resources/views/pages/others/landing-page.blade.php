<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Trezo - Laravel Admin Dashboard Template</title>
        <!-- Styles -->
        @include('partials.styles')
    </head>
    <body data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0">
        @include('partials.preloader')

        <!-- Start Navbar Area -->
        @include('partials.navbar')
        <!-- End Navbar Area -->

        <!-- Start Banner Area -->
        <div class="banner-area bg-img pb-0" id="home">
            <div class="container position-relative z-1">
                <div class="banner-content text-center pb-75">
                    <h1 class="fs-60 mb-3 pb-md-3">Insights On-the-Go: Access Your Dashboard Anywhere, Anytime</h1>
                    <p class="fs-18 m-auto mb-3 pb-md-3 mw-740">Our intuitive interface transforms complex data into actionable insights, empowering you to make informed decisions with confidence.</p>
                    <a href="pricing-plan" class="btn btn-primary py-2 px-4 fs-16 fw-medium rounded-3">
                        <i class="ri-user-line fs-18"></i>
                        <span class="ms-1">Get started - It is free</span>
                    </a>
                </div>
                <div class="banner-img-wrap text-center">
                    <img src="assets/images/landing/banner-img.png" alt="banner-img">
                </div>

                <img src="assets/images/landing/shape-3.png" class="shape shape-7" alt="shape">
                <img src="assets/images/landing/shape-4.png" class="shape shape-8" alt="shape">
                <img src="assets/images/landing/shape-5.png" class="shape shape-9" alt="shape">
                <img src="assets/images/landing/shape-6.png" class="shape shape-10" alt="shape">
            </div>
        </div>
        <!-- End Banner Area -->

        <!-- Start Key Features Area -->
        <div class="key-features-area pt-150 pb-125 position-relative z-2" id="features">
            <div class="container">
                <div class="section-title">
                    <span class="top-title">
                        <span>Key Features</span>
                    </span>
                    <h2>Discover What Sets Us Apart: Highlighted Dashboard Functions</h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="key-features-single-item">
                            <i class="material-symbols-outlined wh-87 bg-primary bg-opacity-25 d-inline-block text-primary">stacks</i>
                            <h3>Real-Time Updates</h3>
                            <p>Provide real-time updates and notifications to keep users informed about important events, changes, or updates within the system.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="key-features-single-item">
                            <i class="material-symbols-outlined wh-87 bg-primary-div bg-opacity-25 d-inline-block text-primary-div">frame_source</i>
                            <h3>Quality Code</h3>
                            <p>These features include adherence to coding standards, robust error handling mechanisms, efficient algorithms, scalability, maintainability, and readability.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="key-features-single-item">
                            <i class="material-symbols-outlined wh-87 bg-danger bg-opacity-25 d-inline-block text-danger">support_agent</i>
                            <h3>24/7 Customer Support</h3>
                            <p>Our 24/7 customer support is dedicated to providing round-the-clock assistance, ensuring that help is always available whenever our customers need it.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Key Features Area -->

        <!-- Start Tailor Area -->
        <div class="tailor-area position-relative z-1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="tailor-img">
                            <img src="assets/images/landing/tailor-img.png" alt="tailor">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="tailor-content">
                            <h2>Tailor Your Dashboard: Unleash the Power of Customizable Widgets</h2>
                            <ul class="ps-0 mb-0 list-unstyled">
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="material-symbols-outlined fs-20 text-primary">done_outline</i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h3>Tailored Display</h3>
                                            <p>Easily arrange, resize, and configure widgets to showcase the data most relevant to your workflow.</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="material-symbols-outlined fs-20 text-primary">done_outline</i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h3>Personalized Insights</h3>
                                            <p>Customize widget content and visualization options to match your specific preferences and priorities.</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="material-symbols-outlined fs-20 text-primary">done_outline</i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h3>Flexibility and Versatility</h3>
                                            <p>Adapt widgets to evolving business needs by adjusting layouts, styles, and data sources with ease.</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="material-symbols-outlined fs-20 text-primary">done_outline</i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h3>Seamless Integration</h3>
                                            <p>Integrate widgets seamlessly with other dashboard components and external systems for a cohesive user experience.</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <img src="assets/images/landing/shape-1.png" class="shape shape-1" alt="shape">
            <img src="assets/images/landing/shape-2.png" class="shape shape-2" alt="shape">
        </div>
        <!-- End Tailor Area -->

        <!-- End Testimonials Area -->
        <div class="testimonials-area pt-150" id="testimonials">
            <div class="container">
                <div class="section-title mw-630">
                    <span class="top-title">
                        <span>Testimonials</span>
                    </span>
                    <h2>Inspiring Feedback: What Users Love About Trezo Dashboard</h2>
                </div>
                <div class="masonrow">
					<div class="item">
						<div class="single-testimonials">
							<ul class="reating ps-0 list-unstyled">
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
							</ul>
							<p>Trezo Dashboard Template has transformed how we manage our data. Its intuitive design and customizable features have streamlined our analytics process, enabling us to make informed decisions faster than ever before.</p>

							<div class="d-flex align-items-center review-info">
								<div class="review">
									<img src="assets/images/landing/testimonial-1.jpg" class="rounded-circle wh-50" alt="testimonial">
								</div>
								<div class="ms-3">
									<h4>Sarah Thompson</h4>
									<span>Data Analyst</span>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="single-testimonials">
							<ul class="reating ps-0 list-unstyled">
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-half-fill"></i>
								</li>
							</ul>
							<p>As a developer, I appreciate the flexibility and robustness of Trezo Dashboard Template. It offers a wide range of features that cater to our diverse needs, and its clean codebase has made customization a breeze. Highly recommended!</p>

							<div class="d-flex align-items-center review-info">
								<div class="review">
									<img src="assets/images/landing/testimonial-2.jpg" class="rounded-circle wh-50" alt="testimonial">
								</div>
								<div class="ms-3">
									<h4>John Smith</h4>
									<span>Software Engineer</span>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="single-testimonials">
							<ul class="reating ps-0 list-unstyled">
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-line"></i>
								</li>
							</ul>
							<p>Trezo Dashboard Template has been a lifesaver for our organization. It's helped us streamline our reporting processes and communicate insights effectively across departments. The time saved has allowed us to focus more on strategic initiatives.</p>

							<div class="d-flex align-items-center review-info">
								<div class="review">
									<img src="assets/images/landing/testimonial-3.jpg" class="rounded-circle wh-50" alt="testimonial">
								</div>
								<div class="ms-3">
									<h4>Alex Rodriguez</h4>
									<span>Marketing Director</span>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="single-testimonials">
							<ul class="reating ps-0 list-unstyled">
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-half-fill"></i>
								</li>
								<li>
									<i class="ri-star-line"></i>
								</li>
							</ul>
							<p>I can't recommend Trezo Dashboard Template enough. It's helped us gain a deeper understanding of our business metrics and identify areas for improvement. The responsive support team is an added bonus, always ready to assist whenever we need it.</p>

							<div class="d-flex align-items-center review-info">
								<div class="review">
									<img src="assets/images/landing/testimonial-4.jpg" class="rounded-circle wh-50" alt="testimonial">
								</div>
								<div class="ms-3">
									<h4>Kevin Brown</h4>
									<span>Jessica Martinez</span>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="single-testimonials">
							<ul class="reating ps-0 list-unstyled">
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
							</ul>
							<p>Using Trezo Dashboard Template has been a game-changer for our team. The ability to customize widgets to suit our specific needs has allowed us to gain deeper insights into our performance metrics and drive business growth.</p>

							<div class="d-flex align-items-center review-info">
								<div class="review">
									<img src="assets/images/landing/testimonial-5.jpg" class="rounded-circle wh-50" alt="testimonial">
								</div>
								<div class="ms-3">
									<h4>Olivia Adams</h4>
									<span>Marketing Coordinator</span>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="single-testimonials">
							<ul class="reating ps-0 list-unstyled">
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-fill"></i>
								</li>
								<li>
									<i class="ri-star-line"></i>
								</li>
								<li>
									<i class="ri-star-line"></i>
								</li>
							</ul>
							<p>As a startup, we needed a dashboard solution that was both powerful and cost-effective. Trezo Dashboard Template checked all the boxes for us. It's helped us stay agile and competitive in a fast-paced market.</p>

							<div class="d-flex align-items-center review-info">
								<div class="review">
									<img src="assets/images/landing/testimonial-6.jpg" class="rounded-circle wh-50" alt="testimonial">
								</div>
								<div class="ms-3">
									<h4>Daniel Lee</h4>
									<span>Co-founder, StartupX</span>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
        <!-- End Testimonials Area -->

        <!-- End Our Team Area -->
        <div class="our-team-area pt-125 position-relative z-1" id="ourteam">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 mb-lg-5">
                    <div class="section-title ms-0 text-start mw-630 mb-0">
                        <span class="top-title">
                            <span>Our Team</span>
                        </span>
                        <h2>Introducing Our Exceptional Team. Meet the Minds Driving Our Success</h2>
                    </div>
    
                    <div class="team-controller d-flex gap-3">
                        <div class="controller-icon prev">
                            <i class="ri-arrow-left-line"></i>
                        </div>
                        <div class="controller-icon next">
                            <i class="ri-arrow-right-line"></i>
                        </div>
                    </div>
                </div>
                
                <div class="swiper team-slide">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="our-team-single-item">
                                <div class="team-img">
                                    <img src="assets/images/landing/team-1.jpg" alt="team">
                                </div>
                                <div class="team-content d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3>Michael Johnson</h3>
                                        <span>CEO</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-3">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="our-team-single-item">
                                <div class="team-img">
                                    <img src="assets/images/landing/team-2.jpg" alt="team">
                                </div>
                                <div class="team-content d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3>Emily Davis</h3>
                                        <span>Project Manager</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-3">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="our-team-single-item">
                                <div class="team-img">
                                    <img src="assets/images/landing/team-3.jpg" alt="team">
                                </div>
                                <div class="team-content d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3>Daniel Lee</h3>
                                        <span>Sales Team Lead</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-3">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="our-team-single-item">
                                <div class="team-img">
                                    <img src="assets/images/landing/team-1.jpg" alt="team">
                                </div>
                                <div class="team-content d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3>Michael Johnson</h3>
                                        <span>CEO</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-3">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="our-team-single-item">
                                <div class="team-img">
                                    <img src="assets/images/landing/team-2.jpg" alt="team">
                                </div>
                                <div class="team-content d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3>Emily Davis</h3>
                                        <span>Project Manager</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-3">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="our-team-single-item">
                                <div class="team-img">
                                    <img src="assets/images/landing/team-3.jpg" alt="team">
                                </div>
                                <div class="team-content d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3>Daniel Lee</h3>
                                        <span>Sales Team Lead</span>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-3">
                                        <li>
                                            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-twitter-x-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <img src="assets/images/landing/shape-1.png" class="shape shape-3" alt="shape">
            <img src="assets/images/landing/shape-2.png" class="shape shape-4" alt="shape">
        </div>
        <!-- End Our Team Area -->

        <!-- Start FAQ Area -->
        <div class="faq-arae position-relative z-1 pt-125" id="fqss">
            <div class="container">
                <div class="section-title mw-630">
                    <span class="top-title">
                        <span>FAQ’s</span>
                    </span>
                    <h2>Inspiring Feedback: What Users Love About Trezo Dashboard</h2>
                </div>

                <div class="accordion faq-wrapper mw-740 m-auto" id="accordionExample">
                    <div class="accordion-item mb-3 border-0 bg-white">
                        <h2 class="accordion-header">
                            <button class="accordion-button text-secondary bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                What is Trezo?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3 border-0 bg-white">
                        <h2 class="accordion-header">
                            <button class="accordion-button text-secondary bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                What features does Trezo offer?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3 border-0 bg-white">
                        <h2 class="accordion-header">
                            <button class="accordion-button text-secondary bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                How can Trezo benefit my team?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3 border-0 bg-white">
                        <h2 class="accordion-header">
                            <button class="accordion-button text-secondary bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree4" aria-expanded="false" aria-controls="collapseThree4">
                                Is Trezo suitable for small businesses?
                            </button>
                        </h2>
                        <div id="collapseThree4" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3 border-0 bg-white">
                        <h2 class="accordion-header">
                            <button class="accordion-button text-secondary bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree5" aria-expanded="false" aria-controls="collapseThree5">
                                Can I customize Trezo to fit my team's specific needs?
                            </button>
                        </h2>
                        <div id="collapseThree5" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3 border-0 bg-white">
                        <h2 class="accordion-header">
                            <button class="accordion-button text-secondary bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree6" aria-expanded="false" aria-controls="collapseThree6">
                                Is Trezo cloud-based or on-premises?
                            </button>
                        </h2>
                        <div id="collapseThree6" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-0 border-0 bg-white">
                        <h2 class="accordion-header">
                            <button class="accordion-button text-secondary bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree7" aria-expanded="false" aria-controls="collapseThree7">
                                Does Trezo integrate with other tools?
                            </button>
                        </h2>
                        <div id="collapseThree7" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>Trezo is a comprehensive project management software designed to help teams streamline their workflow, collaborate effectively, and achieve project success.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End FAQ Area -->
        
        <!-- Start Contact Us Area -->
        <div class="contact-us-area pt-150 position-relative z-2" id="contact">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="contact-us-img mb-4 mb-lg-0">
                            <img src="assets/images/landing/contact-us.jpg" alt="contact-us">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-us-form ms-xl-4">
                            <span class="top-title">
                                <span>Contact Us</span>
                            </span>
                            <h2>Introducing Our Exceptional Team. Meet the Minds Driving Our Success</h2>
                            <form>
                                <div class="form-group mb-4">
                                    <label class="label text-secondary">Full Name</label>
                                    <input type="text" class="form-control bg-transparent h-55" placeholder="Your full name">
                                </div>
                                <div class="form-group mb-4">
                                    <label class="label text-secondary">Email Address</label>
                                    <input type="email" class="form-control bg-transparent h-55" placeholder="Your email address">
                                </div>
                                <div class="form-group mb-4">
                                    <label class="label text-secondary">Phone Number</label>
                                    <input type="text" class="form-control bg-transparent h-55" placeholder="Your phone number">
                                </div>
                                <div class="form-group mb-4">
                                    <label class="label text-secondary">Subject</label>
                                    <select class="form-select form-control bg-transparent h-55" aria-label="Default select example">
                                        <option selected>Select your subject</option>
                                        <option value="1">Help Dask</option>
                                        <option value="2">LMS</option>
                                        <option value="3">CRM</option>
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="label text-secondary">Phone Number</label>
                                    <textarea rows="5" class="form-control bg-transparent" placeholder="Write your message..."></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary py-2 px-4 w-100">
                                        <i class="ri-refresh-line fs-18 text-white position-relative top-1 me-1"></i>
                                        <span>Send</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contact Us Area -->

        <!-- Start Unlock Area -->
        <div class="unlock-area ptb-150 position-relative z-1" id="admin">
            <div class="container">
                <div class="border-bottom pb-150">
                    <div class="row">
                        <div class="unlock-content">
                            <h2>Unlock a world of possibilities with Trezo Dashboard.</h2>
                            <p>Experience the difference with Trezo Dashboard. Sign up for a free trial today and see how our intuitive platform can revolutionize your data analysis process.</p>
                            <a href="pricing-plan" class="btn btn-primary-div py-2 px-4 fs-16 fw-medium rounded-3 text-white">
                                <i class="ri-user-line fs-18"></i>
                                <span class="ms-1">Get started - It is free</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <img src="assets/images/landing/shape-1.png" class="shape shape-5" alt="shape">
            <img src="assets/images/landing/shape-2.png" class="shape shape-6" alt="shape">
        </div>
        <!-- End Unlock Area -->

        <!-- Start Forter Area -->
        <div class="footers-area pb-125 position-relative z-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="footer-single-item mb-4">
                            <a href="#" class="footer-logo d-inline-block mb-4">
                                <img src="assets/images/landing/logo.svg" alt="logo">
                            </a>
                            <p class="mb-4 pb-lg-2">With customizable dashboards tailored to your needs, collaborate effortlessly with your team and stay ahead with real-time updates.</p>

                            <ul class="ps-0 mb-0 list-unstyled d-flex flex-wrap gap-3">
                                <li>
                                    <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                        <i class="ri-facebook-fill"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.twitter.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                        <i class="ri-twitter-x-line"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                        <i class="ri-linkedin-fill"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.dribbble.com/" target="_blank" class="text-decoration-none fs-20 text-primary">
                                        <i class="ri-dribbble-line"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="footer-single-item mb-4 ms-lg-5 ps-lg-5">
                            <h3 class="mb-md-4 mb-3 fw-semibold">Our Products</h3>
                            <ul class="ps-0 mb-0 list-unstyled">
                                <li class="mb-2 pb-1">
                                    <a href="#" class="text-decoration-none">Trezo Dashboard</a>
                                </li>
                                <li class="mb-2 pb-1">
                                    <a href="#" class="text-decoration-none">Tagus Admin</a>
                                </li>
                                <li class="mb-2 pb-1">
                                    <a href="#" class="text-decoration-none">eCademy LMS</a>
                                </li>
                                <li class="mb-0">
                                    <a href="#" class="text-decoration-none">Admash Template</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="footer-single-item mb-4 ms-lg-5 ps-lg-4">
                            <h3 class="mb-md-4 mb-3 fw-semibold">Quick Links</h3>
                            <ul class="ps-0 mb-0 list-unstyled">
                                <li class="mb-2 pb-1">
                                    <a href="#" class="text-decoration-none">Home</a>
                                </li>
                                <li class="mb-2 pb-1">
                                    <a href="#" class="text-decoration-none">Features</a>
                                </li>
                                <li class="mb-2 pb-1">
                                    <a href="#" class="text-decoration-none">Testimonials</a>
                                </li>
                                <li class="mb-0">
                                    <a href="#" class="text-decoration-none">Our Team</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="footer-single-item mb-4">
                            <h3 class="mb-md-4 mb-3 fw-semibold">Privacy Policy</h3>
                            <ul class="ps-0 mb-0 list-unstyled">
                                <li class="mb-2 pb-1">
                                    <a href="#" class="text-decoration-none">Terms & Conditions</a>
                                </li>
                                <li class="mb-2 pb-1">
                                    <a href="#" class="text-decoration-none">Cookie Policy</a>
                                </li>
                                <li class="mb-2 pb-1">
                                    <a href="#" class="text-decoration-none">Notice at Collection</a>
                                </li>
                                <li class="mb-0">
                                    <a href="#" class="text-decoration-none">Privacy Policy</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Forter Area -->

        <!-- Start CopyRight Area -->
        <div class="copyright-area bg-white text-center py-4">
            <div class="container">
                <p class="fs-14">© <span class="text-primary-div">Trezo</span> is Proudly Owned by <a href="https://envytheme.com/" target="_blank" class="text-decoration-none text-primary">EnvyTheme</a></p>
            </div>
        </div>
        <!-- End CopyRight Area -->

        <!-- Start Back To Up Area -->
		<button type="button" id="backtotop"> 
			<i class="ri-arrow-up-s-line"></i>
		</button>
		<!-- End Back To Up Area -->

        @include('partials.scripts')
    </body>
</html>
