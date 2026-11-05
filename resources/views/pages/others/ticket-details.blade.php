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
                        <h3 class="mb-0">Ticket Details</h3>

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
                                    <span class="fw-medium">Ticket Details</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card bg-white border-0 rounded-3 mb-4">
                        <div class="card-body py-4 px-0">
                            <div class="default-table-area style-two all-projects">
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
                                                    <div class="d-flex align-items-center gap-3">
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
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-8 col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-15 mb-2 pb-1">Ticket Description</h4>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of <a class="text-decoration-none" href="ticket-details">Lorem Ipsum.</a></p>

                                    <h4 class="fs-15 mb-2 pb-1 mt-4">Network Infrastructure for Trezo</h4>
                                    <ul class="mb-0">
                                        <li class="mb-2">Login Issues</li>
                                        <li class="mb-2">Cloud Migration</li>
                                        <li class="mb-2">Website Revamp</li>
                                        <li class="mb-2">Mobile Application</li>
                                        <li class="mb-2">System Deployment</li>
                                    </ul>

                                    <h4 class="fs-15 mb-2 pb-1 mt-4">Here is the Code:</h4>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;span class="material-symbols-outlined"&gt;search&lt;/span&gt;
</code>
</pre>
                                </div>
                            </div>
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="border-bottom border-primary pb-4 mb-4">
                                        <div class="d-flex flex-wrap gap-3 align-items-center mb-3">
                                            <img src="assets/images/user-6.jpg" class="wh-34 rounded-circle" alt="user">
                                            <span class="fw-medium text-primary">Ponsiano</span>
                                            <span>a day ago</span>
                                            <span class="bg-primary text-white fw-medium px-2 rounded-1 fs-12 position-relative top-2">#BD0JL0G6</span>
                                        </div>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
    
                                        <h4 class="fs-15 mb-2 pb-1">Screenshots</h4>
                                        <img src="assets/images/screenshorts.jpg" class="mw-80 rounded-3" alt="screenshorts">
                                    </div>

                                    <div class="border-bottom pb-4 mb-4 ps-4">
                                        <div class="d-flex flex-wrap gap-3 align-items-center mb-3">
                                            <img src="assets/images/user-7.jpg" class="wh-34 rounded-circle" alt="user">
                                            <span class="fw-medium text-danger">Zelxa</span>
                                            <span>18 hours ago</span>
                                            <span class="text-white fw-medium px-2 rounded-1 fs-12 position-relative top-2" style="background-color: #3584fc;">Support Staff</span>
                                        </div>
                                        <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    
                                        <h4 class="fs-15 mb-2 pb-1">Screenshots</h4>
                                        <div class="d-flex flex-wrap gap-3">
                                            <img src="assets/images/screenshorts-2.jpg" class="mw-80 rounded-3" alt="screenshorts">
                                            <img src="assets/images/screenshorts-3.jpg" class="mw-80 rounded-3" alt="screenshorts">
                                        </div>
                                    </div>

                                    <div class="border-bottom pb-4 mb-4 ps-4">
                                        <div class="d-flex flex-wrap gap-3 align-items-center mb-3">
                                            <img src="assets/images/user-6.jpg" class="wh-34 rounded-circle" alt="user">
                                            <span class="fw-medium text-primary">Ponsiano</span>
                                            <span>12 hours ago</span>
                                        </div>
                                        <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                                    </div>

                                    <div class="border-bottom pb-4 mb-4 ps-4">
                                        <div class="d-flex flex-wrap gap-3 align-items-center mb-3">
                                            <img src="assets/images/user-7.jpg" class="wh-34 rounded-circle" alt="user">
                                            <span class="fw-medium text-danger">Zelxa</span>
                                            <span>05 hours ago</span>
                                            <span class="text-white fw-medium px-2 rounded-1 fs-12 position-relative top-2" style="background-color: #3584fc;">Support Staff</span>
                                        </div>
                                        <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation.</p>
                                    </div>

                                    <form>
                                        <div class="form-group mb-4">
                                            <label class="label text-secondary fs-14">Post A Reply</label>
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
                                        <div class="form-group d-flex flex-wrap gap-3">
                                            <button type="submit" class="btn btn-danger fw-medium fs-16 py-2 px-4">
                                                <span class="py-1 d-inline-block text-white">Save As Draft</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary fw-medium fs-16 py-2 px-4">
                                                <div class="d-flex align-items-center">
                                                    <i class="material-symbols-outlined me-2 text-white">send</i>
                                                    <span class="py-1 d-inline-block text-white">Submit Now</span>
                                                </div>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-lg-5">
                            <div class="card bg-white border-0 rounded-3 mb-4 rounded-3">
                                <div class="card-body p-4">
                                    <h3 class="mb-4">Attachments</h3>

                                    <div class="d-flex justify-content-between align-items-center bg-body-bg p-3 rounded-3 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="ri-file-warning-line wh-40 lh-40 d-inline-block bg-white text-center fs-18 text-primary rounded-circle"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="mb-1 fs-14 fw-medium">Project_attachment_1.zip</h4>
                                                <span class="fs-13">3.25 MB</span>
                                            </div>
                                        </div>

                                        <button class="p-0 border-0 bg-transparent">
                                            <i class="ri-download-2-line fs-22 text-primary
                                            "></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center bg-body-bg p-3 rounded-3 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="ri-file-warning-line wh-40 lh-40 d-inline-block bg-white text-center fs-18 text-primary rounded-circle"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="mb-1 fs-14 fw-medium">Project_attachment_1.zip</h4>
                                                <span class="fs-13">3.25 MB</span>
                                            </div>
                                        </div>

                                        <button class="p-0 border-0 bg-transparent">
                                            <i class="ri-download-2-line fs-22 text-primary
                                            "></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center bg-body-bg p-3 rounded-3 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="ri-file-warning-line wh-40 lh-40 d-inline-block bg-white text-center fs-18 text-primary rounded-circle"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="mb-1 fs-14 fw-medium">Project_attachment_1.zip</h4>
                                                <span class="fs-13">3.25 MB</span>
                                            </div>
                                        </div>

                                        <button class="p-0 border-0 bg-transparent">
                                            <i class="ri-download-2-line fs-22 text-primary
                                            "></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center bg-body-bg p-3 rounded-3 mb-0">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="ri-file-warning-line wh-40 lh-40 d-inline-block bg-white text-center fs-18 text-primary rounded-circle"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="mb-1 fs-14 fw-medium">Project_attachment_1.zip</h4>
                                                <span class="fs-13">3.25 MB</span>
                                            </div>
                                        </div>

                                        <button class="p-0 border-0 bg-transparent">
                                            <i class="ri-download-2-line fs-22 text-primary
                                            "></i>
                                        </button>
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
