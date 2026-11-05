<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LOTEAME - Sistema de Gestión Inmobiliaria y Venta de Lotes</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/loteame/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/loteame/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/loteame/favicon.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/loteame/favicon.png') }}">
    
    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    @include('partials.styles')
    
    <style>
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --primary-light: #10b981;
            --primary-subtle: rgba(5, 150, 105, 0.1);
            --secondary: #64748b;
            --dark: #0f172a;
            --accent: #d97706;
            --accent-gold: #f59e0b;
            --glass: rgba(15, 23, 42, 0.7);
            --glass-border: rgba(255, 255, 255, 0.15);
            --font-main: 'Plus Jakarta Sans', sans-serif;
            --font-head: 'Outfit', sans-serif;
        }

        body {
            font-family: var(--font-main);
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #0f172a;
            color: #f8fafc;
        }

        .login-container {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* Hero Section */
        .hero-section {
            flex: 1.4;
            position: relative;
            background: url('{{ asset('assets/images/loteame/login_bg.jpg') }}') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at top right, rgba(5, 150, 105, 0.35), transparent 60%);
            z-index: 1;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.4) 0%, rgba(15, 23, 42, 0.88) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 4rem;
            max-width: 820px;
            animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #6ee7b7;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(8px);
        }

        .hero-content h1 {
            font-family: var(--font-head);
            font-size: 4.2rem;
            font-weight: 800;
            line-height: 1.08;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 60%, #a7f3d0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1.5px;
        }

        .hero-content p {
            font-size: 1.25rem;
            line-height: 1.65;
            color: #cbd5e1;
            margin-bottom: 2.5rem;
            max-width: 580px;
        }

        .doc-badges {
            display: flex;
            gap: 0.85rem;
            flex-wrap: wrap;
        }

        .badge-lote {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 0.6rem 1.1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            color: #f1f5f9;
            display: flex;
            align-items: center;
            gap: 0.55rem;
            transition: all 0.3s ease;
        }

        .badge-lote:hover {
            background: rgba(5, 150, 105, 0.3);
            border-color: rgba(52, 211, 153, 0.5);
            transform: translateY(-2px);
            color: #ffffff;
        }

        .badge-lote span.material-symbols-outlined {
            font-size: 1.15rem;
            color: #34d399;
        }

        /* Form Section */
        .form-section {
            flex: 1;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            z-index: 10;
            padding: 2rem 2.5rem 1.2rem 2.5rem;
            position: relative;
            height: 100vh;
            overflow-y: auto;
        }

        .form-wrapper {
            width: 100%;
            max-width: 440px;
            margin-top: auto;
            margin-bottom: auto;
            animation: fadeInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            padding: 0.5rem 0;
        }

        .logo-box {
            margin-bottom: 1.5rem;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-box img {
            height: 105px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(5, 150, 105, 0.12));
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .logo-box img:hover {
            transform: scale(1.03);
            filter: drop-shadow(0 6px 16px rgba(5, 150, 105, 0.22));
        }

        .welcome-head h2 {
            font-family: var(--font-head);
            font-size: 2.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.3rem;
            letter-spacing: -0.5px;
        }

        .welcome-head p {
            color: var(--secondary);
            font-size: 0.98rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
            position: relative;
            z-index: 20;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #334155;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
            z-index: 25;
        }

        .input-wrapper span.material-symbols-outlined {
            position: absolute;
            left: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary) !important;
            font-size: 22px;
            z-index: 50 !important;
            pointer-events: none;
            display: flex !important;
            align-items: center;
            justify-content: center;
        }

        .form-control {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.875rem 1rem 0.875rem 3.2rem;
            font-size: 1rem;
            font-family: var(--font-main);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #f8fafc;
            color: var(--dark);
            position: relative;
            z-index: 10;
        }

        .form-control:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.15);
            outline: none;
        }

        .btn-submit {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.05rem;
            width: 100%;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            box-shadow: 0 10px 25px rgba(5, 150, 105, 0.25);
            position: relative;
            z-index: 20;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(5, 150, 105, 0.35);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .footer-text {
            text-align: center;
            font-size: 0.85rem;
            color: #94a3b8;
            margin-top: 1.5rem;
            width: 100%;
        }

        /* Info and Primary Action Boxes */
        .info-card-box {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
        }
        
        .info-card-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
            border-color: #cbd5e1;
        }

        .info-card-box.highlight {
            background-color: rgba(5, 150, 105, 0.06) !important;
            border: 1.5px solid rgba(5, 150, 105, 0.2) !important;
        }

        .info-card-box .icon-circle {
            background-color: var(--primary) !important;
        }

        .btn-emerald-custom {
            background-color: var(--primary) !important;
            color: #ffffff !important;
            border: none;
            font-weight: 700;
            padding: 0.45rem 1rem;
            font-size: 0.825rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
        }

        .btn-emerald-custom:hover {
            background-color: var(--primary-dark) !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(5, 150, 105, 0.3);
            color: #ffffff !important;
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Floating Shapes for polish */
        .shape {
            position: absolute;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.12;
            z-index: 1;
            pointer-events: none;
        }

        .shape-1 { width: 320px; height: 320px; top: -100px; right: -100px; }
        .shape-2 { width: 420px; height: 420px; bottom: -150px; left: -150px; }

        /* Responsive */
        @media (max-width: 1200px) {
            .hero-content h1 { font-size: 3.4rem; }
        }

        @media (max-width: 992px) {
            .hero-section { display: none; }
            .form-section { flex: 1; }
            body { overflow-y: auto; }
        }
    </style>
</head>

<body>
    @include('partials.preloader')
    @include('partials.error')

    <div class="login-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-tag">
                    <span class="material-symbols-outlined" style="font-size: 18px;">landscape</span>
                    Gestión Inmobiliaria & Lotizaciones
                </div>
                <h1>Venta de Lotes <br>& Urbanizaciones.</h1>
                <p>Plataforma integral para el control de proyectos, manzanas, lotes, cronogramas de pago, contratos y comisiones de ventas.</p>
                
                <div class="doc-badges">
                    <div class="badge-lote"><span class="material-symbols-outlined">map</span> Plano & Lotes</div>
                    <div class="badge-lote"><span class="material-symbols-outlined">holiday_village</span> Proyectos</div>
                    <div class="badge-lote"><span class="material-symbols-outlined">payments</span> Planes de Pago</div>
                    <div class="badge-lote"><span class="material-symbols-outlined">history_edu</span> Contratos</div>
                    <div class="badge-lote"><span class="material-symbols-outlined">badge</span> Asesores</div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            
            <div class="form-wrapper">
                <div class="logo-box">
                    <img src="{{ asset('assets/images/loteame/logo.png') }}" alt="LOTEAME Logo">
                </div>

                <div class="welcome-head">
                    <h2>Bienvenido</h2>
                    <p>Inicie sesión para acceder al sistema de gestión de lotes</p>
                </div>

                <form method="POST" action="{{ url('login') }}" id="frmLoginMain" class="needs-validation" novalidate>
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="form-label" for="usuario">Usuario / Asesor</label>
                        <div class="input-wrapper">
                            <input type="text" name="name" id="usuario" class="form-control" placeholder="Nombre de usuario" required autofocus>
                            <span class="material-symbols-outlined">person</span>
                            <div class="invalid-feedback">Ingrese su usuario.</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Contraseña</label>
                        <div class="input-wrapper" style="position: relative;">
                            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required minlength="4" style="padding-right: 3.5rem;">
                            <span class="material-symbols-outlined">lock</span>
                            <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-secondary text-decoration-none py-0 pe-3" 
                                onclick="togglePasswordVisibility('password', this)" style="border: none; background: none; z-index: 50; right: 0.5rem; position: absolute; top: 50%; transform: translateY(-50%); cursor: pointer; display: flex; align-items: center; justify-content: center; height: 100%;">
                                <i class="ri-eye-line" style="font-size: 20px; color: var(--secondary);"></i>
                            </button>
                            <div class="invalid-feedback">Ingrese su contraseña.</div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        Ingresar a LOTEAME
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </form>

                <div class="info-card-box highlight mt-4 p-3 rounded-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-circle text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <span class="material-symbols-outlined" style="font-size: 20px;">domain</span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark fw-bold">Proyectos y Lotes</h6>
                            <p class="mb-0 text-muted small">Disponibilidad en tiempo real</p>
                        </div>
                        <span class="badge bg-success bg-opacity-25 text-success fw-bold px-3 py-2 rounded-pill">Activo</span>
                    </div>
                </div>

                <div class="info-card-box mt-3 p-3 rounded-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-circle bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <span class="material-symbols-outlined" style="font-size: 20px;">support_agent</span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark fw-bold">¿Necesitas soporte?</h6>
                            <p class="mb-0 text-muted small">Contacta a administración</p>
                        </div>
                        <a href="mailto:soporte@loteame.com" class="btn-emerald-custom px-3">Contactar</a>
                    </div>
                </div>
            </div>

            <div class="footer-text">
                &copy; {{ date('Y') }} LOTEAME. Todos los derechos reservados.
            </div>
        </div>
    </div>

    @include('partials.scripts')
    <script src="{{ url('/assets/js/custom/custom.js') }}"></script>

    <script>
        // Form Validation UI
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()

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
</body>

</html>


