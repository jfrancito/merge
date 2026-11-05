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
                        <h3 class="mb-0">Sweet Alarts</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Extra Pages</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Sweet Alarts</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Sweet Alarts</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview-tab" data-bs-toggle="tab" data-bs-target="#preview-tab-pane" type="button" role="tab" aria-controls="preview-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code-tab" data-bs-toggle="tab" data-bs-target="#code-tab-pane" type="button" role="tab" aria-controls="code-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="preview-tab-pane" role="tabpanel" aria-labelledby="preview-tab" tabindex="0">
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_1">Try Me</button>
                                                <button type="button" class="btn btn-success text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_2">Try Me</button>
                                                <button type="button" class="btn btn-danger text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_3">Try Me</button>
                                                <button type="button" class="btn btn-info text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_4">Try Me</button>
                                                <button type="button" class="btn btn-dark text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_5">Try Me</button>
                                                <button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_6">Try Me</button>
                                                <button type="button" class="btn btn-success text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_7">Try Me</button>
                                                <button type="button" class="btn btn-danger text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_8">Try Me</button>
                                                <button type="button" class="btn btn-info text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_9">Try Me</button>
                                                <button type="button" class="btn btn-dark text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_10">Try Me</button>
                                                <button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_11">Try Me</button>
                                                <button type="button" class="btn btn-success text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_12">Try Me</button>
                                                <button type="button" class="btn btn-danger text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_13">Try Me</button>
                                                <button type="button" class="btn btn-info text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_14">Try Me</button>
                                                <button type="button" class="btn btn-dark text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_15">Try Me</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
    <pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
    <code class="language-markup" id="basicAlertsCode">
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_1"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_2"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_3"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_4"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_5"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_6"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_7"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_8"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_9"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_10"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_11"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_12"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_13"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_14"&gt;Try Me&lt;/button&gt;
    &lt;button type="button" class="btn btn-primary text-white fs-16 fw-semibol py-2 px-3" id="sweetalert_15"&gt;Try Me&lt;/button&gt;
    &lt;script&gt;
    document.getElementById("sweetalert_1").addEventListener("click", function(e) {
        Swal.fire("Good job!");
    });
    
    document.getElementById('sweetalert_2').addEventListener('click', function(e) {
        Swal.fire("Here's the title!", "...and here's the text!");
    });
    
    document.getElementById('sweetalert_3').addEventListener('click', function(e) {
        Swal.fire("Good job!", "You clicked the button!", "warning");
    });
    
    document.getElementById('sweetalert_4').addEventListener('click', function(e) {
        Swal.fire("Good job!", "You clicked the button!", "error");
    });
    
    document.getElementById('sweetalert_5').addEventListener('click', function(e) {
        Swal.fire("Good job!", "You clicked the button!", "success");
    });
    
    document.getElementById('sweetalert_6').addEventListener('click', function(e) {
        Swal.fire("Good job!", "You clicked the button!", "info");
    });
    
    document.getElementById('sweetalert_7').addEventListener('click', function(e) {
        Swal.fire("Good job!", "You clicked the button!", "question");
    });
    
    document.getElementById('sweetalert_8').addEventListener('click', function(e) {
        Swal.fire({
            title: "Good job!",
            text: "You clicked the button!",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Confirm me!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    });
    
    document.getElementById('sweetalert_9').addEventListener('click', function(e) {
        Swal.fire({
            title: "Good job!",
            text: "You clicked the button!",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "<i class='la la-headphones'></i> I am game!",
            showCancelButton: true,
            cancelButtonText: "<i class='la la-thumbs-down'></i> No, thanks",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-default"
            }
        });
    });
    
    document.getElementById('sweetalert_10').addEventListener('click', function(e) {
        Swal.fire({
            position: "top-right",
            icon: "success",
            title: "Your work has been saved",
            showConfirmButton: false,
            timer: 1500
        });
    });
    
    document.getElementById('sweetalert_11').addEventListener('click', function(e) {
        Swal.fire({
            title: 'jQuery HTML example',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    });
    
    document.getElementById('sweetalert_12').addEventListener('click', function(e) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won to be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
                Swal.fire(
                    "Deleted!",
                    "Your file has been deleted.",
                    "success"
                );
            }
        });
    });
    
    document.getElementById('sweetalert_13').addEventListener('click', function(e) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won to be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                Swal.fire(
                    "Deleted!",
                    "Your file has been deleted.",
                    "success"
                );
            } else if (result.dismiss === "cancel") {
                Swal.fire(
                    "Cancelled",
                    "Your imaginary file is safe :)",
                    "error"
                );
            }
        });
    });
    
    document.getElementById('sweetalert_14').addEventListener('click', function(e) {
        Swal.fire({
            title: "Sweet!",
            text: "Modal with a custom image.",
            imageUrl: "https://camo.envatousercontent.com/5b57b814db32f74f4ce750680390a407898cc665/68747470733a2f2f696d616765732e656e76797468656d652e636f6d2f72656163742d76657273696f6e2d617661696c61626c652e6a7067",
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: "Custom image",
            animation: false
        });
    });
    
    document.getElementById('sweetalert_15').addEventListener('click', function(e) {
        Swal.fire({
            title: "Auto close alert!",
            text: "I will close in 5 seconds.",
            timer: 5000,
            onOpen: function() {
                Swal.showLoading();
            }
        }).then(function(result) {
            if (result.dismiss === "timer") {
                console.log("I was closed by the timer");
            }
        });
    });
    &lt;/script&gt;
    </code>
    </pre>
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
