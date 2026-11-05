<header class="header-area bg-white mb-4 rounded-bottom-15" id="header-area">
    <div class="row align-items-center">
        <div class="col-lg-4 col-sm-6">
            <div class="left-header-content">
                <ul class="d-flex align-items-center ps-0 mb-0 list-unstyled justify-content-center justify-content-sm-start">
                    <li>
                        <button class="header-burger-menu bg-transparent p-0 border-0" id="header-burger-menu">
                            <span class="material-symbols-outlined">menu</span>
                        </button>
                    </li>
                    @if(isset($todas_empresas))
                    <li class="ms-3">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                <i class="material-symbols-outlined fs-18">domain</i>
                                <span class="d-none d-md-inline">Empresa: {{ Session::get('empresa')->nombre ?? 'Seleccionar' }}</span>
                            </button>
                            <ul class="dropdown-menu shadow-lg border-0" style="max-height: 300px; overflow-y: auto;">
                                <li class="dropdown-header">Cambiar de Entorno</li>
                                @foreach($todas_empresas as $emp)
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ Session::get('empresa_id') == $emp->id ? 'active' : '' }}" 
                                       href="{{ url('/cambiar-empresa/'. \Hashids::encode(substr($emp->id, -8))) }}">
                                        {{ $emp->nombre }}
                                        @if(Session::get('empresa_id') == $emp->id)
                                            <i class="material-symbols-outlined fs-16">check_circle</i>
                                        @endif
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="col-lg-8 col-sm-6">
            <div class="right-header-content mt-2 mt-sm-0">
                <ul
                    class="d-flex align-items-center justify-content-center justify-content-sm-end ps-0 mb-0 list-unstyled">
                    <li class="header-right-item">
                        <div class="light-dark">
                            <button class="switch-toggle settings-btn dark-btn p-0 bg-transparent" id="switch-toggle"
                                style="border: none !important" ;>
                                <span class="dark"><i class="material-symbols-outlined">light_mode</i></span>
                                <span class="light"><i class="material-symbols-outlined">dark_mode</i></span>
                            </button>
                        </div>
                    </li>


                    <li class="header-right-item">
                        <button class="fullscreen-btn bg-transparent p-0 border-0" id="fullscreen-button">
                            <i class="material-symbols-outlined text-body">fullscreen</i>
                        </button>
                    </li>


                    <li class="header-right-item">
                        <div class="dropdown admin-profile">
                            <div class="d-xxl-flex align-items-center bg-transparent border-0 text-start p-0 cursor dropdown-toggle"
                                data-bs-toggle="dropdown">
                                <div class="flex-shrink-0">
                                    <img class="rounded-circle wh-40 administrator"
                                        src="{{ asset('assets/images/APP/avatar.png') }}" alt="admin" />
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-none d-xxl-block">
                                            <div class="d-flex align-content-center">
                                                <h3>{{Session::get('usuario')->NombrePersona}} </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-menu border-0 bg-white dropdown-menu-end">
                                <div class="d-flex align-items-center info">
                                    <div class="flex-shrink-0">
                                        <img class="rounded-circle wh-30 administrator"
                                            src="{{ asset('assets/images/APP/avatar.png') }}" alt="admin" />
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h3 class="fw-medium">
                                            {{Session::get('usuario')->NombrePersona}}
                                            {{Session::get('usuario')->ApellidoPaterno}}
                                            {{Session::get('usuario')->ApellidoMaterno}}
                                        </h3>
                                        <span class="fs-12"> {{Session::get('usuario')->nombre}} </span>
                                    </div>
                                </div>
                                <ul class="admin-link ps-0 mb-0 list-unstyled">
                                    <!-- <li>
                                        <a class="dropdown-item d-flex align-items-center text-body" href="/my-profile">
                                            <i class="material-symbols-outlined">account_circle</i>
                                            <span class="ms-2"> Mi Perfil</span>
                                        </a>
                                    </li> -->

                                    {{-- <li>
                                        <a class="dropdown-item d-flex align-items-center text-body" href="/settings">
                                            <i class="material-symbols-outlined">settings</i>
                                            <span class="ms-2">Settings</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center text-body" href="{{ url('/cambiar-mi-clave') }}">
                                            <i class="material-symbols-outlined">lock_reset</i>
                                            <span class="ms-2">Cambiar Contraseña</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center text-body"
                                            href="{{ url('cerrarsession') }}">
                                            <i class="material-symbols-outlined">logout</i>
                                            <span class="ms-2">Salir</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <!-- <li class="header-right-item">
                        <button class="theme-settings-btn p-0 border-0 bg-transparent" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                            aria-controls="offcanvasScrolling">
                            <i class="material-symbols-outlined" data-bs-toggle="tooltip" data-bs-placement="left"
                                data-bs-title="Click On Theme Settings">settings</i>
                        </button>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
</header>