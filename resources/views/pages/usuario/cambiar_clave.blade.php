@extends('layouts.app')
@section('title', 'Cambiar Contraseña')
@section('page-title', 'Cambiar Contraseña')
@section('breadcrumb')
    <div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
        <h5 class="mb-0">Mi Cuenta</h5>
        <ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
            <li class="breadcrumb-item d-inline-block position-relative">
                <a href="{{ url('/') }}" class="d-inline-block position-relative">
                    <i class="material-symbols-outlined">home</i>
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item d-inline-block position-relative">
                Usuario
            </li>
            <li class="breadcrumb-item d-inline-block position-relative">
                Cambiar Contraseña
            </li>
        </ol>
    </div>
@endsection

@section('content')

    <div class="card bg-white border-0 rounded-3 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <h3 class="mb-0">Cambiar Contraseña</h3>
            </div>

            <form action="{{ url('/cambiar-mi-clave') }}" id='frmcambiarclave' method="POST"
                class="needs-validation frmcargando" novalidate>
                @csrf
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="label text-secondary">Contraseña Actual <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input name="clave_actual" type="password" id='clave_actual' class="form-control h-55 pe-5" placeholder="Contraseña Actual"
                                required>
                            <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-secondary text-decoration-none py-0 pe-3" 
                                onclick="togglePasswordVisibility('clave_actual', this)" style="border: none; background: none; z-index: 10;">
                                <i class="ri-eye-line fs-18"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">
                            Por favor ingrese su contraseña actual.
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="label text-secondary">Nueva Contraseña <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input name="password" type="password" id='password' class="form-control h-55 pe-5" placeholder="Nueva Contraseña"
                                required>
                            <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-secondary text-decoration-none py-0 pe-3" 
                                onclick="togglePasswordVisibility('password', this)" style="border: none; background: none; z-index: 10;">
                                <i class="ri-eye-line fs-18"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">
                            Por favor ingrese su nueva contraseña (mínimo 6 caracteres).
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="label text-secondary">Confirmar Nueva Contraseña <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input name="password_confirmation" type="password" id='password_confirmation' class="form-control h-55 pe-5"
                                placeholder="Confirmar Nueva Contraseña" required>
                            <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-secondary text-decoration-none py-0 pe-3" 
                                onclick="togglePasswordVisibility('password_confirmation', this)" style="border: none; background: none; z-index: 10;">
                                <i class="ri-eye-line fs-18"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">
                            Por favor confirme su nueva contraseña.
                        </div>
                    </div>

                    <div class="form-group mb-4"></div>
                    <div class="d-flex gap-2">
                        <button type="submit" id="btnGuardar"
                            class="btn btn-primary bg-primary bg-opacity-10 text-primary border-0 fw-semibold py-2 px-4">
                            <i class="ri-save-3-line me-2"></i>
                            Actualizar Contraseña
                        </button>

                        <a href="{{ url('/') }}"
                            class="btn btn-danger bg-danger bg-opacity-10 text-danger border-0 fw-semibold py-2 px-4">
                            <i class="ri-close-line me-2"></i>
                            Cancelar
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ri-eye-line');
                icon.classList.add('ri-eye-off-line');
            } else {
                input.type = 'password';
                icon.classList.remove('ri-eye-off-line');
                icon.classList.add('ri-eye-line');
            }
        }
    </script>
@endpush
