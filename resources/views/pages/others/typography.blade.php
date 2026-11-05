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
                        <h3 class="mb-0">Typography</h3>

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
                                    <span class="fw-medium">Typography</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Highlights</h4>
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
                                            <h1 class="fs-1">Hello Trezo</h1>
                                            <h2 class="fs-2">Hello Trezo</h2>
                                            <h3 class="fs-3">Hello Trezo</h3>
                                            <h4 class="fs-4">Hello Trezo</h4>
                                            <h5 class="fs-5">Hello Trezo</h5>
                                            <h6 class="fs-6">Hello Trezo</h6>
                                            <p class="text-gray-light">Lorem ipsum <span class="text-success">dolor</span>, sit amet consectetur adipisicing elit. Aliquam aliquid vel porro natus? Est culpa aliquid, cumque <span class="text-dark">eligendi</span> inventore laborum, sit <span class="text-danger">incidunt</span> accusamus nesciunt vitae recusandae quos eaque saepe? Laudantium.</p>
                                            <p class="text-gray-light">Lorem ipsum <span class="mark">dolor</span>, sit amet consectetur adipisicing elit. Aliquam aliquid vel porro natus? Est culpa aliquid, cumque <span class="mark">eligendi</span> inventore laborum, sit <span class="mark">incidunt</span> accusamus nesciunt vitae <em class="text-dark">recusandae</em> quos eaque saepe? Laudantium.</p>
                                            <p class="text-gray-light">Lorem <span class="d-inline-block text-primary bg-primary px-2 rounded-2 bg-opacity-10">Laudantium</span> ipsum <span class="text-success">dolor</span>, sit amet consectetur adipisicing elit. <span class="d-inline-block text-white bg-danger px-2 rounded-2">Laudantium</span> Aliquam aliquid vel porro natus? Est culpa aliquid, cumque <span class="text-dark">eligendi</span> inventore laborum, sit <span class="text-danger">incidunt</span> accusamus nesciunt vitae recusandae quos eaque saepe? <span class="d-inline-block text-white bg-primary px-2 rounded-2">Laudantium</span>.</p>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;h1&gt;Hello Trezo&lt;/h1&gt;
&lt;h2&gt;Hello Trezo&lt;/h2&gt;
&lt;h3&gt;Hello Trezo&lt;/h3&gt;
&lt;h4&gt;Hello Trezo&lt;/h4&gt;
&lt;h5&gt;Hello Trezo&lt;/h5&gt;
&lt;h6&gt;Hello Trezo&lt;/h6&gt;
&lt;p class="text-gray-light"&gt;Lorem ipsum &lt;span class="text-success"&gt;dolor&lt;/span&gt;, sit amet consectetur adipisicing elit. Aliquam aliquid vel porro natus? Est culpa aliquid, cumque &lt;span class="text-dark"&gt;eligendi&lt;/span&gt; inventore laborum, sit &lt;span class="text-danger"&gt;incidunt&lt;/span&gt; accusamus nesciunt vitae recusandae quos eaque saepe? Laudantium.&lt;/p&gt;
&lt;p class="text-gray-light"&gt;Lorem ipsum &lt;span class="mark"&gt;dolor&lt;/span&gt;, sit amet consectetur adipisicing elit. Aliquam aliquid vel porro natus? Est culpa aliquid, cumque &lt;span class="mark"&gt;eligendi&lt;/span&gt; inventore laborum, sit &lt;span class="mark"&gt;incidunt&lt;/span&gt; accusamus nesciunt vitae &lt;em class="text-dark"&gt;recusandae&lt;/em&gt; quos eaque saepe? Laudantium.&lt;/p&gt;
&lt;p class="text-gray-light"&gt;Lorem &lt;span class="d-inline-block text-primary bg-primary px-2 rounded-2 bg-opacity-10"&gt;Laudantium&lt;/span&gt; ipsum &lt;span class="text-success"&gt;dolor&lt;/span&gt;, sit amet consectetur adipisicing elit. &lt;span class="d-inline-block text-white bg-danger px-2 rounded-2"&gt;Laudantium&lt;/span&gt; Aliquam aliquid vel porro natus? Est culpa aliquid, cumque &lt;span class="text-dark"&gt;eligendi&lt;/span&gt; inventore laborum, sit &lt;span class="text-danger"&gt;incidunt&lt;/span&gt; accusamus nesciunt vitae recusandae quos eaque saepe? &lt;span class="d-inline-block text-white bg-primary px-2 rounded-2"&gt;Laudantium&lt;/span&gt;.&lt;/p&gt;
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
