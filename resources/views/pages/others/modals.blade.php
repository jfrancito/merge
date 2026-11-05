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
                        <h3 class="mb-0">Modals</h3>

                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb align-items-center mb-0 lh-1">
                                <li class="breadcrumb-item">
                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                        <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                                        <span class="text-secondary fw-medium hover">Dashboard</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">UI Elements</span>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span class="fw-medium">Modals</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Live Demo Modal</h4>
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
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn btn-primary py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                Launch demo modal
                                            </button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Hello Modal
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary text-white">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;!-- Button trigger modal --&gt;
&lt;button type="button" class="btn btn btn-primary py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModal"&gt;
    Launch demo modal
&lt;/button&gt;
    
&lt;!-- Modal --&gt;
&lt;div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"&gt;
    &lt;div class="modal-dialog"&gt;
        &lt;div class="modal-content"&gt;
            &lt;div class="modal-header"&gt;
                &lt;h1 class="modal-title fs-5" id="exampleModalLabel"&gt;Modal title&lt;/h1&gt;
                &lt;button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"&gt;&lt;/button&gt;
            &lt;/div&gt;
            &lt;div class="modal-body"&gt;
                Hello Modal
            &lt;/div&gt;
            &lt;div class="modal-footer"&gt;
                &lt;button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal"&gt;Close&lt;/button&gt;
                &lt;button type="button" class="btn btn-primary text-white"&gt;Save changes&lt;/button&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Static Backdrop Modal</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab2" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview2-tab" data-bs-toggle="tab" data-bs-target="#preview2-tab-pane" type="button" role="tab" aria-controls="preview2-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code2-tab" data-bs-toggle="tab" data-bs-target="#code2-tab-pane" type="button" role="tab" aria-controls="code2-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent2">
                                        <div class="tab-pane fade show active" id="preview2-tab-pane" role="tabpanel" aria-labelledby="preview2-tab" tabindex="0">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary text-white py-2 px-4 fw-semibold" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                Launch static backdrop modal
                                            </button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Hello Modal
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary text-white">Understood</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode2">
&lt;!-- Button trigger modal --&gt;
&lt;button type="button" class="btn btn-primary text-white py-2 px-4 fw-semibold" data-bs-toggle="modal" data-bs-target="#staticBackdrop"&gt;
    Launch static backdrop modal
&lt;/button&gt;

&lt;!-- Modal --&gt;
&lt;div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"&gt;
    &lt;div class="modal-dialog"&gt;
        &lt;div class="modal-content"&gt;
            &lt;div class="modal-header"&gt;
                &lt;h1 class="modal-title fs-5" id="staticBackdropLabel"&gt;Modal title&lt;/h1&gt;
                &lt;button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"&gt;&lt;/button&gt;
            &lt;/div&gt;
            &lt;div class="modal-body"&gt;
                Hello Modal
            &lt;/div&gt;
            &lt;div class="modal-footer"&gt;
                &lt;button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal"&gt;Close&lt;/button&gt;
                &lt;button type="button" class="btn btn-primary text-white"&gt;Understood&lt;/button&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Scrolling long content modal</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab3" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview3-tab" data-bs-toggle="tab" data-bs-target="#preview3-tab-pane" type="button" role="tab" aria-controls="preview3-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code3-tab" data-bs-toggle="tab" data-bs-target="#code3-tab-pane" type="button" role="tab" aria-controls="code3-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent3">
                                        <div class="tab-pane fade show active" id="preview3-tab-pane" role="tabpanel" aria-labelledby="preview3-tab" tabindex="0">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary text-white py-2 px-4 fw-semibold" data-bs-toggle="modal" data-bs-target="#staticBackdrop3">
                                                Scrolling modal
                                            </button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdrop3Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticBackdrop3Label">Modal Scrolling</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Hello Modal Scrolling 
                                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
                                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
                                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
                                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
                                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
                                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
                                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
                                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
                                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
                                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut consequatur sit sed cumque iusto reiciendis expedita magni, ullam deleniti earum soluta maiores id obcaecati deserunt quas minus illo necessitatibus. Dicta! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, praesentium perspiciatis sapiente blanditiis itaque incidunt explicabo, quo modi veniam esse ratione, magnam maiores id facilis architecto cum iusto corporis eaque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum autem delectus quo omnis, beatae quas nostrum perferendis illo! Sunt fugit rem doloremque eum amet velit porro, dolore et laudantium debitis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem autem asperiores voluptates praesentium reiciendis. Ea nemo fuga nihil consectetur ipsum facere optio quibusdam, officia blanditiis? Delectus laudantium reiciendis fuga corporis?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary text-white">Understood</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode3">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode3">
&lt;!-- Button trigger modal --&gt;
&lt;button type="button" class="btn btn-primary text-white py-2 px-4 fw-semibold" data-bs-toggle="modal" data-bs-target="#staticBackdrop3"&gt;
        Launch static backdrop modal
    &lt;/button&gt;
    
&lt;!-- Modal --&gt;
&lt;div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdrop3Label" aria-hidden="true"&gt;
    &lt;div class="modal-dialog modal-dialog-scrollable"&gt;
        &lt;div class="modal-content"&gt;
            &lt;div class="modal-header"&gt;
                &lt;h1 class="modal-title fs-5" id="staticBackdrop3Label"&gt;Modal title&lt;/h1&gt;
                &lt;button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"&gt;&lt;/button&gt;
            &lt;/div&gt;
            &lt;div class="modal-body"&gt;
                Hello Modal
            &lt;/div&gt;
            &lt;div class="modal-footer"&gt;
                &lt;button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal"&gt;Close&lt;/button&gt;
                &lt;button type="button" class="btn btn-primary text-white"&gt;Understood&lt;/button&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Vertically centered Modal</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab4" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview4-tab" data-bs-toggle="tab" data-bs-target="#preview4-tab-pane" type="button" role="tab" aria-controls="preview4-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code4-tab" data-bs-toggle="tab" data-bs-target="#code4-tab-pane" type="button" role="tab" aria-controls="code4-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent4">
                                        <div class="tab-pane fade show active" id="preview4-tab-pane" role="tabpanel" aria-labelledby="preview4-tab" tabindex="0">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn btn-primary py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModal4">
                                                Center demo modal
                                            </button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Hello Modal Center
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary text-white">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode4">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode4">
&lt;button type="button" class="btn btn btn-primary py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModal4"&gt;
    Center demo modal
&lt;/button&gt;

&lt;!-- Modal --&gt;
&lt;div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"&gt;
    &lt;div class="modal-dialog modal-dialog-centered"&gt;
        &lt;div class="modal-content"&gt;
            &lt;div class="modal-header"&gt;
                &lt;h1 class="modal-title fs-5" id="exampleModalLabel"&gt;Modal title&lt;/h1&gt;
                &lt;button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"&gt;&lt;/button&gt;
            &lt;/div&gt;
            &lt;div class="modal-body"&gt;
                Hello Modal Center
            &lt;/div&gt;
            &lt;div class="modal-footer"&gt;
                &lt;button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal"&gt;Close&lt;/button&gt;
                &lt;button type="button" class="btn btn-primary text-white"&gt;Save changes&lt;/button&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Extra large modal</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab5" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview5-tab" data-bs-toggle="tab" data-bs-target="#preview5-tab-pane" type="button" role="tab" aria-controls="preview5-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code5-tab" data-bs-toggle="tab" data-bs-target="#code5-tab-pane" type="button" role="tab" aria-controls="code5-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent5">
                                        <div class="tab-pane fade show active" id="preview5-tab-pane" role="tabpanel" aria-labelledby="preview5-tab" tabindex="0">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn btn-primary py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModalxl">
                                                Extra large modal
                                            </button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalxl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Extra large modal</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Hello Modal Center
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary text-white">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code5-tab-pane" role="tabpanel" aria-labelledby="code5-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode5">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode5">
&lt;!-- Button trigger modal --&gt;
&lt;button type="button" class="btn btn btn-primary py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModalxl"&gt;
    Center demo modal
&lt;/button&gt;

&lt;!-- Modal --&gt;
&lt;div class="modal fade" id="exampleModalxl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"&gt;
    &lt;div class="modal-dialog modal-xl"&gt;
        &lt;div class="modal-content"&gt;
            &lt;div class="modal-header"&gt;
                &lt;h1 class="modal-title fs-5" id="exampleModalLabel"&gt;Modal title&lt;/h1&gt;
                &lt;button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"&gt;&lt;/button&gt;
            &lt;/div&gt;
            &lt;div class="modal-body"&gt;
                Hello Modal Center
            &lt;/div&gt;
            &lt;div class="modal-footer"&gt;
                &lt;button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal"&gt;Close&lt;/button&gt;
                &lt;button type="button" class="btn btn-primary text-white"&gt;Save changes&lt;/button&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Large modal</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab6" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview6-tab" data-bs-toggle="tab" data-bs-target="#preview6-tab-pane" type="button" role="tab" aria-controls="preview6-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code6-tab" data-bs-toggle="tab" data-bs-target="#code6-tab-pane" type="button" role="tab" aria-controls="code6-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent6">
                                        <div class="tab-pane fade show active" id="preview6-tab-pane" role="tabpanel" aria-labelledby="preview6-tab" tabindex="0">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn btn-primary py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModallg">
                                                Large modal
                                            </button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModallg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Large modal</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Hello Modal Center
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary text-white">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code6-tab-pane" role="tabpanel" aria-labelledby="code6-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode6">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode6">
&lt;!-- Button trigger modal --&gt;
&lt;button type="button" class="btn btn btn-primary py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModallg"&gt;
    Large modal
&lt;/button&gt;
    
&lt;!-- Modal --&gt;
&lt;div class="modal fade" id="exampleModallg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"&gt;
    &lt;div class="modal-dialog modal-lg"&gt;
        &lt;div class="modal-content"&gt;
            &lt;div class="modal-header"&gt;
                &lt;h1 class="modal-title fs-5" id="exampleModalLabel"&gt;Large modal&lt;/h1&gt;
                &lt;button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"&gt;&lt;/button&gt;
            &lt;/div&gt;
            &lt;div class="modal-body"&gt;
                Hello Modal Center
            &lt;/div&gt;
            &lt;div class="modal-footer"&gt;
                &lt;button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal"&gt;Close&lt;/button&gt;
                &lt;button type="button" class="btn btn-primary text-white"&gt;Save changes&lt;/button&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
</code>
</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Checkboxes and radios List</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab7" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview7-tab" data-bs-toggle="tab" data-bs-target="#preview7-tab-pane" type="button" role="tab" aria-controls="preview8-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code8-tab" data-bs-toggle="tab" data-bs-target="#code8-tab-pane" type="button" role="tab" aria-controls="code8-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent8">
                                        <div class="tab-pane fade show active" id="preview8-tab-pane" role="tabpanel" aria-labelledby="preview8-tab" tabindex="0">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn btn-primary py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModalsm">
                                                Small modal
                                            </button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalsm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Small modal</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Hello Modal Center
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary text-white">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code8-tab-pane" role="tabpanel" aria-labelledby="code6-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode8">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode8">
&lt;!-- Button trigger modal --&gt;
&lt;button type="button" class="btn btn btn-primary py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModalsm"&gt;
    Small modal
&lt;/button&gt;

&lt;!-- Modal --&gt;
&lt;div class="modal fade" id="exampleModalsm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"&gt;
    &lt;div class="modal-dialog modal-sm"&gt;
        &lt;div class="modal-content"&gt;
            &lt;div class="modal-header"&gt;
                &lt;h1 class="modal-title fs-5" id="exampleModalLabel"&gt;Small modal&lt;/h1&gt;
                &lt;button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"&gt;&lt;/button&gt;
            &lt;/div&gt;
            &lt;div class="modal-body"&gt;
                Hello Modal Center
            &lt;/div&gt;
            &lt;div class="modal-footer"&gt;
                &lt;button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal"&gt;Close&lt;/button&gt;
                &lt;button type="button" class="btn btn-primary text-white"&gt;Save changes&lt;/button&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
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
