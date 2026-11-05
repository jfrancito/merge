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
                        <h3 class="mb-0">Scrollbar</h3>

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
                                    <span class="fw-medium">Scrollbar</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="fs-18 mb-4">Scroll Bar Default</h4>
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
                                            <p class="overflow-y-scroll max-h-198">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas similique quidem adipisci quisquam nostrum quas nobis eos odio praesentium eius. Adipisci iusto aliquid, corporis aspernatur voluptate excepturi sunt obcaecati temporibus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, deserunt alias nesciunt quos mollitia iste nisi esse vitae dolorem dolor ipsa voluptate ratione laborum veniam eveniet? Expedita dolorum unde eaque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere nam placeat odio itaque non! Aliquid est quos amet perspiciatis labore, consequatur iure adipisci, maxime earum itaque blanditiis corporis at quia! Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quos harum nihil repudiandae, tempore quae nobis obcaecati sit, sapiente saepe molestias vero unde officia doloribus, debitis minus est ipsam. Fugit. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, a adipisci placeat commodi assumenda, cumque quis, repudiandae quaerat nulla tempore reprehenderit officia hic quod architecto ea voluptas beatae quasi delectus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi blanditiis, voluptatibus nisi mollitia eum dolorem illum ullam neque voluptates necessitatibus eveniet deserunt, magni a sed fuga culpa officia quam accusamus! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima, error itaque quos numquam corporis veritatis non obcaecati, nisi illo eum eius quod pariatur provident! Culpa, esse quam! Quae, unde corporis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas facilis molestiae iste. Temporibus nam ex quo quia alias, magnam totam quibusdam expedita vitae et ipsum cum tenetur dolor facere corporis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum, expedita! Fuga voluptatum aperiam saepe error labore voluptates mollitia vel deserunt magni delectus sint, quo sapiente nesciunt unde similique dolore quibusdam. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda omnis porro incidunt sit neque sint fugit nesciunt soluta, modi labore nemo, corrupti consectetur similique perspiciatis! Molestiae saepe eligendi soluta doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic perferendis quam rerum placeat? Ad saepe, deleniti incidunt dolorum et assumenda, sit inventore reprehenderit architecto quae illum repellendus dolore nobis eligendi.</p>
                                        </div>
                                        <div class="tab-pane fade" id="code-tab-pane" role="tabpanel" aria-labelledby="code-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode">
&lt;p class="overflow-y-scroll max-h-198"&gt;Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas similique quidem adipisci quisquam nostrum quas nobis eos odio praesentium eius. Adipisci iusto aliquid, corporis aspernatur voluptate excepturi sunt obcaecati temporibus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, deserunt alias nesciunt quos mollitia iste nisi esse vitae dolorem dolor ipsa voluptate ratione laborum veniam eveniet? Expedita dolorum unde eaque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere nam placeat odio itaque non! Aliquid est quos amet perspiciatis labore, consequatur iure adipisci, maxime earum itaque blanditiis corporis at quia! Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quos harum nihil repudiandae, tempore quae nobis obcaecati sit, sapiente saepe molestias vero unde officia doloribus, debitis minus est ipsam. Fugit. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, a adipisci placeat commodi assumenda, cumque quis, repudiandae quaerat nulla tempore reprehenderit officia hic quod architecto ea voluptas beatae quasi delectus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi blanditiis, voluptatibus nisi mollitia eum dolorem illum ullam neque voluptates necessitatibus eveniet deserunt, magni a sed fuga culpa officia quam accusamus! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima, error itaque quos numquam corporis veritatis non obcaecati, nisi illo eum eius quod pariatur provident! Culpa, esse quam! Quae, unde corporis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas facilis molestiae iste. Temporibus nam ex quo quia alias, magnam totam quibusdam expedita vitae et ipsum cum tenetur dolor facere corporis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum, expedita! Fuga voluptatum aperiam saepe error labore voluptates mollitia vel deserunt magni delectus sint, quo sapiente nesciunt unde similique dolore quibusdam. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda omnis porro incidunt sit neque sint fugit nesciunt soluta, modi labore nemo, corrupti consectetur similique perspiciatis! Molestiae saepe eligendi soluta doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic perferendis quam rerum placeat? Ad saepe, deleniti incidunt dolorum et assumenda, sit inventore reprehenderit architecto quae illum repellendus dolore nobis eligendi.&lt;/p&gt;
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
                                    <h4 class="fs-18 mb-4">Scroll Bar X & Y</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab2" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview2-tab" data-bs-toggle="tab" data-bs-target="#preview2-tab-pane" type="button" role="tab" aria-controls="preview2-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code2-tab" data-bs-toggle="tab" data-bs-target="#code2-tab-pane" type="button" role="tab" aria-controls="code2-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTab2Content">
                                        <div class="tab-pane fade show active" id="preview2-tab-pane" role="tabpanel" aria-labelledby="preview2-tab" tabindex="0">
                                            <div class="overflow-x-scroll max-h-198">
                                                <p class="w-1200">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas similique quidem adipisci quisquam nostrum quas nobis eos odio praesentium eius. Adipisci iusto aliquid, corporis aspernatur voluptate excepturi sunt obcaecati temporibus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, deserunt alias nesciunt quos mollitia iste nisi esse vitae dolorem dolor ipsa voluptate ratione laborum veniam eveniet? Expedita dolorum unde eaque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere nam placeat odio itaque non! Aliquid est quos amet perspiciatis labore, consequatur iure adipisci, maxime earum itaque blanditiis corporis at quia! Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quos harum nihil repudiandae, tempore quae nobis obcaecati sit, sapiente saepe molestias vero unde officia doloribus, debitis minus est ipsam. Fugit. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, a adipisci placeat commodi assumenda, cumque quis, repudiandae quaerat nulla tempore reprehenderit officia hic quod architecto ea voluptas beatae quasi delectus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi blanditiis, voluptatibus nisi mollitia eum dolorem illum ullam neque voluptates necessitatibus eveniet deserunt, magni a sed fuga culpa officia quam accusamus! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima, error itaque quos numquam corporis veritatis non obcaecati, nisi illo eum eius quod pariatur provident! Culpa, esse quam! Quae, unde corporis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas facilis molestiae iste. Temporibus nam ex quo quia alias, magnam totam quibusdam expedita vitae et ipsum cum tenetur dolor facere corporis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum, expedita! Fuga voluptatum aperiam saepe error labore voluptates mollitia vel deserunt magni delectus sint, quo sapiente nesciunt unde similique dolore quibusdam. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda omnis porro incidunt sit neque sint fugit nesciunt soluta, modi labore nemo, corrupti consectetur similique perspiciatis! Molestiae saepe eligendi soluta doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic perferendis quam rerum placeat? Ad saepe, deleniti incidunt dolorum et assumenda, sit inventore reprehenderit architecto quae illum repellendus dolore nobis eligendi.</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code2-tab-pane" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode2">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode2">
&lt;div class="overflow-x-scroll max-h-198"&gt;
    &lt;p class="w-1200"&gt;Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas similique quidem adipisci quisquam nostrum quas nobis eos odio praesentium eius. Adipisci iusto aliquid, corporis aspernatur voluptate excepturi sunt obcaecati temporibus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, deserunt alias nesciunt quos mollitia iste nisi esse vitae dolorem dolor ipsa voluptate ratione laborum veniam eveniet? Expedita dolorum unde eaque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere nam placeat odio itaque non! Aliquid est quos amet perspiciatis labore, consequatur iure adipisci, maxime earum itaque blanditiis corporis at quia! Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quos harum nihil repudiandae, tempore quae nobis obcaecati sit, sapiente saepe molestias vero unde officia doloribus, debitis minus est ipsam. Fugit. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, a adipisci placeat commodi assumenda, cumque quis, repudiandae quaerat nulla tempore reprehenderit officia hic quod architecto ea voluptas beatae quasi delectus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi blanditiis, voluptatibus nisi mollitia eum dolorem illum ullam neque voluptates necessitatibus eveniet deserunt, magni a sed fuga culpa officia quam accusamus! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima, error itaque quos numquam corporis veritatis non obcaecati, nisi illo eum eius quod pariatur provident! Culpa, esse quam! Quae, unde corporis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas facilis molestiae iste. Temporibus nam ex quo quia alias, magnam totam quibusdam expedita vitae et ipsum cum tenetur dolor facere corporis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum, expedita! Fuga voluptatum aperiam saepe error labore voluptates mollitia vel deserunt magni delectus sint, quo sapiente nesciunt unde similique dolore quibusdam. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda omnis porro incidunt sit neque sint fugit nesciunt soluta, modi labore nemo, corrupti consectetur similique perspiciatis! Molestiae saepe eligendi soluta doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic perferendis quam rerum placeat? Ad saepe, deleniti incidunt dolorum et assumenda, sit inventore reprehenderit architecto quae illum repellendus dolore nobis eligendi.&lt;/p&gt;
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
                                    <h4 class="fs-18 mb-4">Scroll Bar Simplebar</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab3" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview3-tab" data-bs-toggle="tab" data-bs-target="#preview3-tab-pane" type="button" role="tab" aria-controls="preview3-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code3-tab" data-bs-toggle="tab" data-bs-target="#code3-tab-pane" type="button" role="tab" aria-controls="code3-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTab3Content">
                                        <div class="tab-pane fade show active" id="preview3-tab-pane" role="tabpanel" aria-labelledby="preview3-tab" tabindex="0">
                                            <p class="max-h-198" data-simplebar="">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas similique quidem adipisci quisquam nostrum quas nobis eos odio praesentium eius. Adipisci iusto aliquid, corporis aspernatur voluptate excepturi sunt obcaecati temporibus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, deserunt alias nesciunt quos mollitia iste nisi esse vitae dolorem dolor ipsa voluptate ratione laborum veniam eveniet? Expedita dolorum unde eaque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere nam placeat odio itaque non! Aliquid est quos amet perspiciatis labore, consequatur iure adipisci, maxime earum itaque blanditiis corporis at quia! Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quos harum nihil repudiandae, tempore quae nobis obcaecati sit, sapiente saepe molestias vero unde officia doloribus, debitis minus est ipsam. Fugit. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, a adipisci placeat commodi assumenda, cumque quis, repudiandae quaerat nulla tempore reprehenderit officia hic quod architecto ea voluptas beatae quasi delectus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi blanditiis, voluptatibus nisi mollitia eum dolorem illum ullam neque voluptates necessitatibus eveniet deserunt, magni a sed fuga culpa officia quam accusamus! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima, error itaque quos numquam corporis veritatis non obcaecati, nisi illo eum eius quod pariatur provident! Culpa, esse quam! Quae, unde corporis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas facilis molestiae iste. Temporibus nam ex quo quia alias, magnam totam quibusdam expedita vitae et ipsum cum tenetur dolor facere corporis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum, expedita! Fuga voluptatum aperiam saepe error labore voluptates mollitia vel deserunt magni delectus sint, quo sapiente nesciunt unde similique dolore quibusdam. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda omnis porro incidunt sit neque sint fugit nesciunt soluta, modi labore nemo, corrupti consectetur similique perspiciatis! Molestiae saepe eligendi soluta doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic perferendis quam rerum placeat? Ad saepe, deleniti incidunt dolorum et assumenda, sit inventore reprehenderit architecto quae illum repellendus dolore nobis eligendi.</p>
                                        </div>
                                        <div class="tab-pane fade" id="code3-tab-pane" role="tabpanel" aria-labelledby="code3-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode3">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode3">
&lt;p class="max-h-198" data-simplebar=""&gt;Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas similique quidem adipisci quisquam nostrum quas nobis eos odio praesentium eius. Adipisci iusto aliquid, corporis aspernatur voluptate excepturi sunt obcaecati temporibus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, deserunt alias nesciunt quos mollitia iste nisi esse vitae dolorem dolor ipsa voluptate ratione laborum veniam eveniet? Expedita dolorum unde eaque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere nam placeat odio itaque non! Aliquid est quos amet perspiciatis labore, consequatur iure adipisci, maxime earum itaque blanditiis corporis at quia! Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quos harum nihil repudiandae, tempore quae nobis obcaecati sit, sapiente saepe molestias vero unde officia doloribus, debitis minus est ipsam. Fugit. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, a adipisci placeat commodi assumenda, cumque quis, repudiandae quaerat nulla tempore reprehenderit officia hic quod architecto ea voluptas beatae quasi delectus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi blanditiis, voluptatibus nisi mollitia eum dolorem illum ullam neque voluptates necessitatibus eveniet deserunt, magni a sed fuga culpa officia quam accusamus! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima, error itaque quos numquam corporis veritatis non obcaecati, nisi illo eum eius quod pariatur provident! Culpa, esse quam! Quae, unde corporis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas facilis molestiae iste. Temporibus nam ex quo quia alias, magnam totam quibusdam expedita vitae et ipsum cum tenetur dolor facere corporis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum, expedita! Fuga voluptatum aperiam saepe error labore voluptates mollitia vel deserunt magni delectus sint, quo sapiente nesciunt unde similique dolore quibusdam. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda omnis porro incidunt sit neque sint fugit nesciunt soluta, modi labore nemo, corrupti consectetur similique perspiciatis! Molestiae saepe eligendi soluta doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic perferendis quam rerum placeat? Ad saepe, deleniti incidunt dolorum et assumenda, sit inventore reprehenderit architecto quae illum repellendus dolore nobis eligendi.&lt;/p&gt;
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
                                    <h4 class="fs-18 mb-4">Scroll Bar X & Y Simplebar</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab4" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview4-tab" data-bs-toggle="tab" data-bs-target="#preview4-tab-pane" type="button" role="tab" aria-controls="preview4-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code4-tab" data-bs-toggle="tab" data-bs-target="#code4-tab-pane" type="button" role="tab" aria-controls="code4-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTab4Content">
                                        <div class="tab-pane fade show active" id="preview4-tab-pane" role="tabpanel" aria-labelledby="preview4-tab" tabindex="0">
                                            <div class="max-h-198" data-simplebar>
                                                <p class="w-1200">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas similique quidem adipisci quisquam nostrum quas nobis eos odio praesentium eius. Adipisci iusto aliquid, corporis aspernatur voluptate excepturi sunt obcaecati temporibus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, deserunt alias nesciunt quos mollitia iste nisi esse vitae dolorem dolor ipsa voluptate ratione laborum veniam eveniet? Expedita dolorum unde eaque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere nam placeat odio itaque non! Aliquid est quos amet perspiciatis labore, consequatur iure adipisci, maxime earum itaque blanditiis corporis at quia! Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quos harum nihil repudiandae, tempore quae nobis obcaecati sit, sapiente saepe molestias vero unde officia doloribus, debitis minus est ipsam. Fugit. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, a adipisci placeat commodi assumenda, cumque quis, repudiandae quaerat nulla tempore reprehenderit officia hic quod architecto ea voluptas beatae quasi delectus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi blanditiis, voluptatibus nisi mollitia eum dolorem illum ullam neque voluptates necessitatibus eveniet deserunt, magni a sed fuga culpa officia quam accusamus! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima, error itaque quos numquam corporis veritatis non obcaecati, nisi illo eum eius quod pariatur provident! Culpa, esse quam! Quae, unde corporis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas facilis molestiae iste. Temporibus nam ex quo quia alias, magnam totam quibusdam expedita vitae et ipsum cum tenetur dolor facere corporis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum, expedita! Fuga voluptatum aperiam saepe error labore voluptates mollitia vel deserunt magni delectus sint, quo sapiente nesciunt unde similique dolore quibusdam. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda omnis porro incidunt sit neque sint fugit nesciunt soluta, modi labore nemo, corrupti consectetur similique perspiciatis! Molestiae saepe eligendi soluta doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic perferendis quam rerum placeat? Ad saepe, deleniti incidunt dolorum et assumenda, sit inventore reprehenderit architecto quae illum repellendus dolore nobis eligendi.</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="code4-tab-pane" role="tabpanel" aria-labelledby="code4-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode4">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode4">
&lt;div class="overflow-x-scroll max-h-198"&gt;
    &lt;p class="w-1200"&gt;Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas similique quidem adipisci quisquam nostrum quas nobis eos odio praesentium eius. Adipisci iusto aliquid, corporis aspernatur voluptate excepturi sunt obcaecati temporibus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, deserunt alias nesciunt quos mollitia iste nisi esse vitae dolorem dolor ipsa voluptate ratione laborum veniam eveniet? Expedita dolorum unde eaque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere nam placeat odio itaque non! Aliquid est quos amet perspiciatis labore, consequatur iure adipisci, maxime earum itaque blanditiis corporis at quia! Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quos harum nihil repudiandae, tempore quae nobis obcaecati sit, sapiente saepe molestias vero unde officia doloribus, debitis minus est ipsam. Fugit. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, a adipisci placeat commodi assumenda, cumque quis, repudiandae quaerat nulla tempore reprehenderit officia hic quod architecto ea voluptas beatae quasi delectus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi blanditiis, voluptatibus nisi mollitia eum dolorem illum ullam neque voluptates necessitatibus eveniet deserunt, magni a sed fuga culpa officia quam accusamus! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima, error itaque quos numquam corporis veritatis non obcaecati, nisi illo eum eius quod pariatur provident! Culpa, esse quam! Quae, unde corporis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas facilis molestiae iste. Temporibus nam ex quo quia alias, magnam totam quibusdam expedita vitae et ipsum cum tenetur dolor facere corporis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum, expedita! Fuga voluptatum aperiam saepe error labore voluptates mollitia vel deserunt magni delectus sint, quo sapiente nesciunt unde similique dolore quibusdam. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda omnis porro incidunt sit neque sint fugit nesciunt soluta, modi labore nemo, corrupti consectetur similique perspiciatis! Molestiae saepe eligendi soluta doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic perferendis quam rerum placeat? Ad saepe, deleniti incidunt dolorum et assumenda, sit inventore reprehenderit architecto quae illum repellendus dolore nobis eligendi.&lt;/p&gt;
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
                                    <h4 class="fs-18 mb-4">Scroll Bar Y Custom</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab5" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview5-tab" data-bs-toggle="tab" data-bs-target="#preview5-tab-pane" type="button" role="tab" aria-controls="preview5-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code5-tab" data-bs-toggle="tab" data-bs-target="#code5-tab-pane" type="button" role="tab" aria-controls="code5-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTab5Content">
                                        <div class="tab-pane fade show active" id="preview5-tab-pane" role="tabpanel" aria-labelledby="preview5-tab" tabindex="0">
                                            <p class="max-h-198 scroll-bar">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas similique quidem adipisci quisquam nostrum quas nobis eos odio praesentium eius. Adipisci iusto aliquid, corporis aspernatur voluptate excepturi sunt obcaecati temporibus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, deserunt alias nesciunt quos mollitia iste nisi esse vitae dolorem dolor ipsa voluptate ratione laborum veniam eveniet? Expedita dolorum unde eaque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere nam placeat odio itaque non! Aliquid est quos amet perspiciatis labore, consequatur iure adipisci, maxime earum itaque blanditiis corporis at quia! Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quos harum nihil repudiandae, tempore quae nobis obcaecati sit, sapiente saepe molestias vero unde officia doloribus, debitis minus est ipsam. Fugit. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, a adipisci placeat commodi assumenda, cumque quis, repudiandae quaerat nulla tempore reprehenderit officia hic quod architecto ea voluptas beatae quasi delectus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi blanditiis, voluptatibus nisi mollitia eum dolorem illum ullam neque voluptates necessitatibus eveniet deserunt, magni a sed fuga culpa officia quam accusamus! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima, error itaque quos numquam corporis veritatis non obcaecati, nisi illo eum eius quod pariatur provident! Culpa, esse quam! Quae, unde corporis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas facilis molestiae iste. Temporibus nam ex quo quia alias, magnam totam quibusdam expedita vitae et ipsum cum tenetur dolor facere corporis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum, expedita! Fuga voluptatum aperiam saepe error labore voluptates mollitia vel deserunt magni delectus sint, quo sapiente nesciunt unde similique dolore quibusdam. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda omnis porro incidunt sit neque sint fugit nesciunt soluta, modi labore nemo, corrupti consectetur similique perspiciatis! Molestiae saepe eligendi soluta doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic perferendis quam rerum placeat? Ad saepe, deleniti incidunt dolorum et assumenda, sit inventore reprehenderit architecto quae illum repellendus dolore nobis eligendi.</p>
                                        </div>
                                        <div class="tab-pane fade" id="code5-tab-pane" role="tabpanel" aria-labelledby="code5-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode5">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode5">
&lt;p class="max-h-198" data-simplebar=""&gt;Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas similique quidem adipisci quisquam nostrum quas nobis eos odio praesentium eius. Adipisci iusto aliquid, corporis aspernatur voluptate excepturi sunt obcaecati temporibus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, deserunt alias nesciunt quos mollitia iste nisi esse vitae dolorem dolor ipsa voluptate ratione laborum veniam eveniet? Expedita dolorum unde eaque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere nam placeat odio itaque non! Aliquid est quos amet perspiciatis labore, consequatur iure adipisci, maxime earum itaque blanditiis corporis at quia! Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quos harum nihil repudiandae, tempore quae nobis obcaecati sit, sapiente saepe molestias vero unde officia doloribus, debitis minus est ipsam. Fugit. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, a adipisci placeat commodi assumenda, cumque quis, repudiandae quaerat nulla tempore reprehenderit officia hic quod architecto ea voluptas beatae quasi delectus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi blanditiis, voluptatibus nisi mollitia eum dolorem illum ullam neque voluptates necessitatibus eveniet deserunt, magni a sed fuga culpa officia quam accusamus! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima, error itaque quos numquam corporis veritatis non obcaecati, nisi illo eum eius quod pariatur provident! Culpa, esse quam! Quae, unde corporis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas facilis molestiae iste. Temporibus nam ex quo quia alias, magnam totam quibusdam expedita vitae et ipsum cum tenetur dolor facere corporis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum, expedita! Fuga voluptatum aperiam saepe error labore voluptates mollitia vel deserunt magni delectus sint, quo sapiente nesciunt unde similique dolore quibusdam. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda omnis porro incidunt sit neque sint fugit nesciunt soluta, modi labore nemo, corrupti consectetur similique perspiciatis! Molestiae saepe eligendi soluta doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic perferendis quam rerum placeat? Ad saepe, deleniti incidunt dolorum et assumenda, sit inventore reprehenderit architecto quae illum repellendus dolore nobis eligendi.&lt;/p&gt;
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
                                    <h4 class="fs-18 mb-4">Scroll Bar Y Custom Active</h4>
                                    <ul class="nav nav-tabs mb-4" id="myTab6" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="preview6-tab" data-bs-toggle="tab" data-bs-target="#preview6-tab-pane" type="button" role="tab" aria-controls="preview6-tab-pane" aria-selected="true">Preview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="code6-tab" data-bs-toggle="tab" data-bs-target="#code6-tab-pane" type="button" role="tab" aria-controls="code6-tab-pane" aria-selected="false">Code</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTab6Content">
                                        <div class="tab-pane fade show active" id="preview6-tab-pane" role="tabpanel" aria-labelledby="preview6-tab" tabindex="0">
                                            <p class="max-h-198 scroll-bar active">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas similique quidem adipisci quisquam nostrum quas nobis eos odio praesentium eius. Adipisci iusto aliquid, corporis aspernatur voluptate excepturi sunt obcaecati temporibus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, deserunt alias nesciunt quos mollitia iste nisi esse vitae dolorem dolor ipsa voluptate ratione laborum veniam eveniet? Expedita dolorum unde eaque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere nam placeat odio itaque non! Aliquid est quos amet perspiciatis labore, consequatur iure adipisci, maxime earum itaque blanditiis corporis at quia! Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quos harum nihil repudiandae, tempore quae nobis obcaecati sit, sapiente saepe molestias vero unde officia doloribus, debitis minus est ipsam. Fugit. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, a adipisci placeat commodi assumenda, cumque quis, repudiandae quaerat nulla tempore reprehenderit officia hic quod architecto ea voluptas beatae quasi delectus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi blanditiis, voluptatibus nisi mollitia eum dolorem illum ullam neque voluptates necessitatibus eveniet deserunt, magni a sed fuga culpa officia quam accusamus! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima, error itaque quos numquam corporis veritatis non obcaecati, nisi illo eum eius quod pariatur provident! Culpa, esse quam! Quae, unde corporis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas facilis molestiae iste. Temporibus nam ex quo quia alias, magnam totam quibusdam expedita vitae et ipsum cum tenetur dolor facere corporis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum, expedita! Fuga voluptatum aperiam saepe error labore voluptates mollitia vel deserunt magni delectus sint, quo sapiente nesciunt unde similique dolore quibusdam. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda omnis porro incidunt sit neque sint fugit nesciunt soluta, modi labore nemo, corrupti consectetur similique perspiciatis! Molestiae saepe eligendi soluta doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic perferendis quam rerum placeat? Ad saepe, deleniti incidunt dolorum et assumenda, sit inventore reprehenderit architecto quae illum repellendus dolore nobis eligendi.</p>
                                        </div>
                                        <div class="tab-pane fade" id="code6-tab-pane" role="tabpanel" aria-labelledby="code6-tab" tabindex="0">
                                            <button class="btn btn-outline-primary bg-white btn-sm copy-btn position-absolute top-0 end-0" data-clipboard-target="#basicAlertsCode6">
                                                Copy
                                            </button>
<pre class="line-numbers pt-0 pb-0 ps-25 pe-25 mb-0">
<code class="language-markup" id="basicAlertsCode6">
&lt;p class="max-h-198 croll-bar active"&gt;Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas similique quidem adipisci quisquam nostrum quas nobis eos odio praesentium eius. Adipisci iusto aliquid, corporis aspernatur voluptate excepturi sunt obcaecati temporibus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, deserunt alias nesciunt quos mollitia iste nisi esse vitae dolorem dolor ipsa voluptate ratione laborum veniam eveniet? Expedita dolorum unde eaque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere nam placeat odio itaque non! Aliquid est quos amet perspiciatis labore, consequatur iure adipisci, maxime earum itaque blanditiis corporis at quia! Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quos harum nihil repudiandae, tempore quae nobis obcaecati sit, sapiente saepe molestias vero unde officia doloribus, debitis minus est ipsam. Fugit. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio, a adipisci placeat commodi assumenda, cumque quis, repudiandae quaerat nulla tempore reprehenderit officia hic quod architecto ea voluptas beatae quasi delectus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi blanditiis, voluptatibus nisi mollitia eum dolorem illum ullam neque voluptates necessitatibus eveniet deserunt, magni a sed fuga culpa officia quam accusamus! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima, error itaque quos numquam corporis veritatis non obcaecati, nisi illo eum eius quod pariatur provident! Culpa, esse quam! Quae, unde corporis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas facilis molestiae iste. Temporibus nam ex quo quia alias, magnam totam quibusdam expedita vitae et ipsum cum tenetur dolor facere corporis. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum, expedita! Fuga voluptatum aperiam saepe error labore voluptates mollitia vel deserunt magni delectus sint, quo sapiente nesciunt unde similique dolore quibusdam. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda omnis porro incidunt sit neque sint fugit nesciunt soluta, modi labore nemo, corrupti consectetur similique perspiciatis! Molestiae saepe eligendi soluta doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic perferendis quam rerum placeat? Ad saepe, deleniti incidunt dolorum et assumenda, sit inventore reprehenderit architecto quae illum repellendus dolore nobis eligendi.&lt;/p&gt;
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
