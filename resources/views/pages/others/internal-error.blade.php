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
        <div class="container-fluid">
            <div class="card-body p-4">
                <div class="text-center">
                    <img src="/assets/images/internal-error.png" class="mw-430 mb-5 w-100" alt="error">
                    <h3 class="fs-24 mb-3">Looks like we did not find this page, please try again later.</h3>
                    <p class="mb-4">But no worries! Our team is looking ever where while you wait safely.</p>
                    <a href="/" class="btn btn-primary py-2 px-4 fs-16 fw-medium">
                        <span class="d-inline-block py-1">Back To Dashboard</span>
                    </a>
                </div>
            </div>
        </div>

        @include('partials.scripts')
    </body>
</html>
