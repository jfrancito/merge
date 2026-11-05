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
                        <h3 class="mb-0">Timeline</h3>

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
                                    <span class="fw-medium">Timeline</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <h3 class="mb-0">Basic Timeline</h3>
                            </div>
                            <div class="position-relative timeline-item">
                                <span class="time-line-date">Just now</span>
                                
                                <div class="border-style-for-timeline">
                                    <h4 class="fs-14 fw-medium mb-2">Weekly Stand-Up Meetings:</h4>
                                    <p class="fs-13 mb-4">We continued our weekly stand-up meetings where team members provided updates on their current tasks, discussed any roadblocks, and coordinated efforts for the week ahead.</p>
                                    <ul class="ps-0 mb-3 list-unstyled d-flex align-items-center">
                                        <li>
                                            <a href="my-profile">
                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                            </a>
                                        </li>
                                        <li class="ms-m-15">
                                            <a href="my-profile">
                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                            </a>
                                        </li>
                                        <li class="ms-m-15">
                                            <a href="my-profile">
                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                            </a>
                                        </li>
                                        <li class="ms-m-15">
                                            <a href="my-profile">
                                                <img src="assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                            </a>
                                        </li>
                                        <li class="ms-m-15">
                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                        </li>
                                    </ul>
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
                                    <p class="fs-13 mb-4">Last Friday, we conducted a team building workshop focused on improving communication and collaboration among team members. Activities included team challenges, icebreakers, and open discussions.</p>
                                    <ul class="ps-0 mb-3 list-unstyled d-flex align-items-center">
                                        <li>
                                            <a href="my-profile">
                                                <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                            </a>
                                        </li>
                                        <li class="ms-m-15">
                                            <a href="my-profile">
                                                <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                            </a>
                                        </li>
                                        <li class="ms-m-15">
                                            <a href="my-profile">
                                                <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                            </a>
                                        </li>
                                        <li class="ms-m-15">
                                            <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                        </li>
                                    </ul>
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

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <h3 class="mb-0">Advanced Timeline</h3>
                            </div>
                            <div class="timeline-wrap">
                                <div class="timeline-item-2 mb-5">
                                    <div class="text p-4 rounded-3">
                                        <h3 class="fs-14 fw-medium text-primary">Weekly Stand-Up Meetings:</h3>
                                        <p>We continued our weekly stand-up meetings where team members provided updates on their current tasks, discussed any roadblocks, and coordinated efforts for the week ahead.</p>
                                        <ul class="ps-0 mb-3 list-unstyled d-flex align-items-center">
                                            <li>
                                                <a href="my-profile">
                                                    <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                </a>
                                            </li>
                                            <li class="ms-m-15">
                                                <a href="my-profile">
                                                    <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                </a>
                                            </li>
                                            <li class="ms-m-15">
                                                <a href="my-profile">
                                                    <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                </a>
                                            </li>
                                            <li class="ms-m-15">
                                                <a href="my-profile">
                                                    <img src="assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                </a>
                                            </li>
                                            <li class="ms-m-15">
                                                <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                            </li>
                                        </ul>
                                        <span class="d-block text-primary"><span class="text-body fw-medium">By:</span> Olivia Rodriguez</span>
                                    </div>
    
                                    <div class="icon">
                                        <div></div>
                                    </div>
    
                                    <div class="time">
                                        <time>12:00 AM, 25 Mar, 2024</time>
                                    </div>
                                </div>
    
                                <div class="timeline-item-2 mb-5">
                                    <div class="text p-4 rounded-3">
                                        <h3 class="fs-14 fw-medium text-primary">Project Kickoff Session:</h3>
                                        <p>Briefly explain the purpose of the kickoff session and its importance in setting the project on the right track. Discuss any assumptions made about the scope and clarify</p>
                                        <span class="d-block text-primary"><span class="text-body fw-medium">By:</span> Olivia Rodriguez</span>
                                    </div>
    
                                    <div class="icon two">
                                        <div></div>
                                    </div>
    
                                    <div class="time">
                                        <time>04:00 PM, 24 Mar, 2024</time>
                                    </div>
                                </div>
    
                                <div class="timeline-item-2 mb-5">
                                    <div class="text p-4 rounded-3">
                                        <h3 class="fs-14 fw-medium text-primary">Team Building Workshop:</h3>
                                        <p>Arrange for a suitable venue and ensure that any necessary materials or resources are readily available. Start the workshop with a fun icebreaker activity to help team members</p>
                                        <ul class="ps-0 mb-3 list-unstyled d-flex align-items-center">
                                            <li>
                                                <a href="my-profile">
                                                    <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                </a>
                                            </li>
                                            <li class="ms-m-15">
                                                <a href="my-profile">
                                                    <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                </a>
                                            </li>
                                            <li class="ms-m-15">
                                                <a href="my-profile">
                                                    <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                </a>
                                            </li>
                                            <li class="ms-m-15">
                                                <a href="my-profile">
                                                    <img src="assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                </a>
                                            </li>
                                            <li class="ms-m-15">
                                                <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                            </li>
                                        </ul>
                                        <span class="d-block text-primary"><span class="text-body fw-medium">By:</span> Olivia Rodriguez</span>
                                    </div>
                                    <div class="icon three">
                                        <div></div>
                                    </div>
                                    <div class="time">
                                        <time>02 PM, 23 Mar, 2024</time>
                                    </div>
                                </div>
    
                                <div class="timeline-item-2">
                                    <div class="text p-4 rounded-3">
                                        <h3 class="fs-14 fw-medium text-primary">Lunch & Learning Session:</h3>
                                        <p>Determine a convenient time and date for the session, ideally during a lunch break or over a lunch hour. Start the session on time and welcome all participants.</p>
                                        <ul class="ps-0 mb-3 list-unstyled d-flex align-items-center">
                                            <li>
                                                <a href="my-profile">
                                                    <img src="assets/images/user-16.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                </a>
                                            </li>
                                            <li class="ms-m-15">
                                                <a href="my-profile">
                                                    <img src="assets/images/user-17.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                </a>
                                            </li>
                                            <li class="ms-m-15">
                                                <a href="my-profile">
                                                    <img src="assets/images/user-18.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                </a>
                                            </li>
                                            <li class="ms-m-15">
                                                <a href="my-profile">
                                                    <img src="assets/images/user-19.jpg" class="wh-34 lh-34 rounded-circle border border-1 border-color-white" alt="user">
                                                </a>
                                            </li>
                                            <li class="ms-m-15">
                                                <a href="user-list" class="wh-34 lh-34 rounded-circle bg-primary d-block text-center text-decoration-none text-white fs-12 fw-medium border border-1 border-color-white">+10</a>
                                            </li>
                                        </ul>
                                        <span class="d-block text-primary"><span class="text-body fw-medium">By:</span> Olivia Rodriguez</span>
                                    </div>
                                    <div class="icon four">
                                        <div></div>
                                    </div>
                                    <div class="time">
                                        <time>12:00 PM, 22 Mar, 2024</time>
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
