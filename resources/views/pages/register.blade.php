<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Trezo - Register</title>

    @include('partials.styles')
</head>

<body class="boxed-size bg-white">
    @include('partials.preloader')

    <!-- FORMULARIO REAL -->
    <form action="{{ route('register.post') }}" method="POST">
        @csrf

        <div class="container">
            <div class="main-content d-flex flex-column p-0">
                <div class="m-auto m-1230">
                    <div class="row align-items-center">
                        
                        <!-- Imagen izquierda -->
                        <div class="col-lg-6 d-none d-lg-block">
                            <img src="{{ asset('assets/images/register.jpg') }}" class="rounded-3" alt="register">
                        </div>

                        <!-- Formulario -->
                        <div class="col-lg-6">
                            <div class="mw-480 ms-lg-auto">

                                <a href="#" class="d-inline-block mb-4">
                                    <img src="{{ asset('assets/images/logo.svg') }}" class="rounded-3 for-light-logo" alt="logo">
                                    <img src="{{ asset('assets/images/white-logo.svg') }}" class="rounded-3 for-dark-logo" alt="logo">
                                </a>

                                <!-- Social buttons -->
                                <h3 class="fs-28 mb-2">Registro to App Movil</h3>
{{--                                 <p class="fw-medium fs-16 mb-4">Register with social account or enter your details</p>

                                <div class="row justify-content-center mb-4">
                                    <div class="col-lg-4 col-sm-4 mb-2">
                                        <a href="#" class="btn btn-outline-secondary bg-transparent w-100 py-2">
                                            <img src="{{ asset('assets/images/google.svg') }}" alt="google">
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 mb-2">
                                        <a href="#" class="btn btn-outline-secondary bg-transparent w-100 py-2">
                                            <img src="{{ asset('assets/images/facebook2.svg') }}" alt="facebook">
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 mb-2">
                                        <a href="#" class="btn btn-outline-secondary bg-transparent w-100 py-2">
                                            <img src="{{ asset('assets/images/apple.svg') }}" alt="apple">
                                        </a>
                                    </div>
                                </div>
 --}}
                                <!-- CAMPOS DEL FORMULARIO -->
                                <div class="form-group mb-3">
                                    <label class="label text-secondary">Nombre Completo</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="label text-secondary">Email @</label>
                                    <input type="email" name="email" class="form-control" placeholder="example@appmovil.com" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="label text-secondary">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Type password" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="label text-secondary">Confirmar Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                                </div>

                                <!-- Botón -->
                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-primary fw-medium py-2 px-3 w-100">
                                        <div class="d-flex align-items-center justify-content-center py-1">
                                            <i class="material-symbols-outlined text-white fs-20 me-2">person_4</i>
                                            <span>Registrar</span>
                                        </div>
                                    </button>
                                </div>

                                <div class="form-group">
                                    <p>Al confirmar tu correo electrónico, aceptas nuestros
                                        <a href="#" class="fw-medium text-decoration-none">Terminos del Servicio</a> 
                                        y
                                        <a href="#" class="fw-medium text-decoration-none">Politica de Privacidad</a>.
                                    </p>
                                    <p>Ya tienes una cuenta? 
                                        <a href="{{ route('login') }}" class="fw-medium text-primary text-decoration-none">Incia Session</a>
                                    </p>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Theme Settings -->
    @include('partials.theme_settings')
    @include('partials.scripts')

</body>
</html>
