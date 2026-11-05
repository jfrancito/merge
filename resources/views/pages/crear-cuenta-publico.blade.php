<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INVOXA - Guía de Requisitos para Creación de Usuario</title>
    
    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/google-icon.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/remixicon.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/scss/style.css') }}" />
    
    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --secondary: #64748b;
            --dark: #0f172a;
            --font-main: 'Plus Jakarta Sans', sans-serif;
            --font-head: 'Outfit', sans-serif;
        }

        body {
            font-family: var(--font-main);
            background: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Floating background shapes */
        .shape {
            position: absolute;
            background: linear-gradient(135deg, var(--primary), #3b82f6);
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.08;
            z-index: 1;
            pointer-events: none;
        }
        .shape-1 { width: 350px; height: 350px; top: -100px; right: -100px; }
        .shape-2 { width: 450px; height: 450px; bottom: -150px; left: -150px; }

        .guide-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 780px;
            padding: 2rem 1.5rem;
        }

        .guide-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.05);
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
        }

        .guide-header {
            background: linear-gradient(135deg, var(--dark) 0%, #1e293b 100%);
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            border-bottom: 4px solid var(--primary);
        }

        .guide-header .logo-box {
            margin-bottom: 1.5rem;
        }

        .guide-header .logo-box img {
            height: 50px;
            width: auto;
        }

        .guide-header h1 {
            font-family: var(--font-head);
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.5px;
        }

        .guide-header p {
            color: #94a3b8;
            font-size: 1rem;
            margin: 0;
        }

        .guide-body {
            padding: 2.5rem;
        }

        .intro-text {
            font-size: 1.05rem;
            line-height: 1.6;
            color: #475569;
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .requirement-step {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .requirement-step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 20px;
            top: 48px;
            bottom: -28px;
            width: 2px;
            background: #e2e8f0;
        }

        .step-number {
            width: 42px;
            height: 42px;
            background: rgba(14, 165, 233, 0.1);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            flex-shrink: 0;
            z-index: 5;
        }

        .step-content {
            flex-grow: 1;
            padding-top: 0.25rem;
        }

        .step-content h3 {
            font-family: var(--font-head);
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .step-content h3 i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .step-content p {
            font-size: 0.95rem;
            line-height: 1.5;
            color: #64748b;
            margin: 0 0 1rem 0;
        }

        .details-badge-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }

        .details-badge {
            background: #f1f5f9;
            color: #475569;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid #e2e8f0;
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 0.75rem;
        }

        @media (max-width: 600px) {
            .roles-grid {
                grid-template-columns: 1fr;
            }
        }

        .role-item {
            background: #fafafa;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 0.85rem;
            transition: all 0.2s ease;
        }

        .role-item:hover {
            background: #ffffff;
            border-color: rgba(14, 165, 233, 0.2);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
        }

        .role-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark);
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .role-title i {
            color: var(--primary);
            font-size: 1rem;
        }

        .role-desc {
            font-size: 0.8rem;
            color: #64748b;
            line-height: 1.4;
            margin: 0;
        }

        /* Clipboard template box */
        .template-box {
            background: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            border-radius: 16px;
            padding: 1.5rem;
            margin-top: 3rem;
            position: relative;
        }

        .template-box h4 {
            font-family: var(--font-head);
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0 0 1rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .template-box h4 i {
            color: var(--primary);
        }

        .template-pre {
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.85rem;
            color: #334155;
            background: #ffffff;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin: 0 0 1rem 0;
            white-space: pre-wrap;
            word-break: break-all;
        }

        .btn-copy {
            background: var(--dark);
            color: #ffffff;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-copy:hover {
            background: #1e293b;
        }

        .btn-copy:active {
            transform: scale(0.98);
        }

        .guide-footer {
            margin-top: 3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .btn-back {
            background: #ffffff;
            color: var(--dark);
            border: 1.5px solid #cbd5e1;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-back:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
        }

        .copyright {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* Toast notification */
        .toast-notif {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #0f172a;
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            z-index: 999;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .toast-notif.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="guide-container">
        <div class="guide-card">
            <!-- Header -->
            <div class="guide-header">
                <div class="logo-box">
                    <img src="{{ asset('assets/images/invoxa/logo.png') }}" alt="INVOXA Logo">
                </div>
                <h1>Guía de Creación de Usuario</h1>
                <p>Requisitos necesarios para habilitar tu cuenta en el sistema</p>
            </div>

            <!-- Body -->
            <div class="guide-body">
                <p class="intro-text">
                    La creación y configuración de perfiles se realiza de manera centralizada a través del <strong>Administrador del Sistema</strong>. Para registrarte, por favor recopila los siguientes datos y envíaselos a tu administrador.
                </p>

                <!-- Step 1: Personal info -->
                <div class="requirement-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3><i class="ri-user-settings-line"></i> Datos de Acceso y Personales</h3>
                        <p>Información básica para identificar tu perfil dentro del sistema y establecer tu inicio de sesión:</p>
                        <div class="details-badge-list">
                            <span class="details-badge">Nombres y Apellidos</span>
                            <span class="details-badge">DNI / Documento de Identidad</span>
                            <span class="details-badge">Usuario sugerido (ej: jperez)</span>
                        </div>
                    </div>
                </div>

                <!-- Step 2: System Role -->
                <div class="requirement-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3><i class="ri-shield-user-line"></i> Definición de Rol</h3>
                        <p>Indica el nombre del rol o perfil que necesitas para operar en el sistema:</p>
                        <div class="details-badge-list">
                            <span class="details-badge">Nombre del Rol</span>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Branch / Establishment access -->
                <div class="requirement-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3><i class="ri-store-2-line"></i> Establecimientos Autorizados</h3>
                        <p>Especifica los datos de la sucursal, oficina o local comercial desde el cual vas a trabajar:</p>
                        <div class="details-badge-list">
                            <span class="details-badge">Cód. Establecimiento (ej: 0001)</span>
                            <span class="details-badge">Nombre del Establecimiento</span>
                            <span class="details-badge">Dirección SUNAT</span>
                            <span class="details-badge">Ubigeo (Dep/Prov/Distrito)</span>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Series and sequences -->
                <div class="requirement-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3><i class="ri-hashtag"></i> Configuración de Series</h3>
                        <p>Indica qué series necesitas usar y a qué establecimiento están amarradas:</p>
                        <div class="details-badge-list">
                            <span class="details-badge">Tipo de Comprobante</span>
                            <span class="details-badge">Serie (ej: F001)</span>
                            <span class="details-badge">Correlativo Inicial (ej: 1)</span>
                            <span class="details-badge">Establecimiento Asociado</span>
                        </div>
                    </div>
                </div>

                <!-- Template box to copy -->
                <div class="template-box">
                    <h4><i class="ri-file-copy-2-line"></i> Plantilla para enviar al Administrador</h4>
                    <p class="text-muted small">Copia esta plantilla y complétala con tus datos para enviársela a tu administrador por correo o WhatsApp:</p>
                    <pre class="template-pre" id="templateText">SOLICITUD DE NUEVO USUARIO - INVOXA
-----------------------------------------
Nombres y Apellidos: 
DNI: 
Usuario Sugerido: 

Nombre del Rol Solicitado:

--- DATOS DEL ESTABLECIMIENTO ---
Cód. Establecimiento: 
Nombre del Establecimiento: 
Dirección SUNAT: 
Ubigeo (Dep/Prov/Dist): 

--- CONFIGURACIÓN DE SERIE ---
Tipo de Comprobante (Factura/Boleta/Guía): 
Serie (ej: F001, B001): 
Correlativo Inicial (ej: 1): 
Establecimiento Asociado: </pre>
                    <button class="btn-copy" onclick="copyTemplate()">
                        <i class="ri-clipboard-line"></i> Copiar Plantilla
                    </button>
                </div>

                <!-- Footer / Return action -->
                <div class="guide-footer">
                    <span class="copyright">&copy; {{ date('Y') }} INVOXA S.A.C. Todos los derechos reservados.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notif" id="toastNotif">
        <i class="ri-checkbox-circle-line" style="color: #10b981; font-size: 1.2rem;"></i>
        ¡Plantilla copiada al portapapeles!
    </div>

    <script>
        function copyTemplate() {
            var text = document.getElementById("templateText").innerText;
            navigator.clipboard.writeText(text).then(function() {
                var toast = document.getElementById("toastNotif");
                toast.classList.add("show");
                setTimeout(function() {
                    toast.classList.remove("show");
                }, 3000);
            }, function(err) {
                console.error('Error al copiar el texto: ', err);
            });
        }
    </script>

</body>
</html>
