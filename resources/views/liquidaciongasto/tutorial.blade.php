<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tutorial - Liquidación de Gastos</title>
    
    <!-- Bootstrap 3 y FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 25px 0;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        
        .header h1 {
            margin: 0;
            font-weight: 300;
            font-size: 32px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .header p {
            margin: 8px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        
        .debug-info {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            margin: 20px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            font-size: 13px;
            color: #495057;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .debug-info strong {
            color: #dc3545;
            font-weight: 700;
        }
        
        .debug-info a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }
        
        .debug-info a:hover {
            text-decoration: underline;
        }
        
        .main-container {
            padding: 40px 20px;
        }
        
        .video-wrapper {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
            overflow: hidden;
            max-width: 1400px;
            margin: 0 auto;
            border: 3px solid rgba(255,255,255,0.2);
        }
        
        .video-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px 35px;
            text-align: center;
        }
        
        .video-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 400;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .video-header p {
            margin: 10px 0 0 0;
            opacity: 0.95;
            font-size: 16px;
        }
        
        .video-container {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            background: #000;
            border-bottom: 3px solid #667eea;
        }
        
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #000;
        }
        
        .video-info {
            padding: 30px 35px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .video-info h4 {
            color: #495057;
            font-size: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .info-item {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .info-item:hover {
            border-color: #667eea;
            transform: translateY(-5px);
        }
        
        .info-item i {
            font-size: 28px;
            color: #667eea;
            margin-bottom: 12px;
        }
        
        .info-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .info-value {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
        }
        
        .video-controls {
            padding: 25px 35px;
            background: white;
            text-align: center;
            border-top: 3px solid #f8f9fa;
        }
        
        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 30px;
            margin: 8px 12px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
            color: white;
            text-decoration: none;
        }
        
        .btn-custom:active {
            transform: translateY(-1px);
        }
        
        .btn-custom i {
            margin-right: 8px;
        }
        
        .video-error {
            padding: 100px 40px;
            text-align: center;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }
        
        .video-error i {
            font-size: 100px;
            color: #dc3545;
            margin-bottom: 30px;
            text-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }
        
        .video-error h3 {
            color: #495057;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: 600;
        }
        
        .video-error p {
            color: #6c757d;
            margin-bottom: 30px;
            font-size: 18px;
            line-height: 1.6;
        }
        
        .btn-retry {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: none;
            padding: 18px 35px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
            transition: all 0.3s ease;
        }
        
        .btn-retry:hover {
            background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.6);
        }
        
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.8) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            backdrop-filter: blur(5px);
        }
        
        .loading-content {
            text-align: center;
            color: white;
        }
        
        .loading-spinner {
            width: 80px;
            height: 80px;
            border: 6px solid rgba(255,255,255,0.2);
            border-top: 6px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 25px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .loading-text {
            font-size: 20px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .loading-progress {
            font-size: 16px;
            color: #ccc;
            opacity: 0.9;
        }
        
        .error-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.95) 0%, rgba(200, 35, 51, 0.95) 100%);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 15;
            text-align: center;
            color: white;
            backdrop-filter: blur(5px);
        }
        
        .error-content i {
            font-size: 80px;
            margin-bottom: 25px;
            text-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }
        
        .error-content h3 {
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .error-content p {
            font-size: 16px;
            margin-bottom: 25px;
            opacity: 0.9;
            line-height: 1.5;
        }
        
        .error-button {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .error-button:hover {
            background: white;
            color: #dc3545;
        }
        
        .console-log {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0,0,0,0.9);
            color: #00ff00;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-width: 400px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        
        .console-toggle {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            z-index: 1001;
        }
        
        .autoplay-notice {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 15px 25px;
            text-align: center;
            font-weight: 600;
            border-radius: 10px;
            margin: 20px;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .autoplay-notice i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 24px;
            }
            
            .video-wrapper {
                margin: 0 15px;
                border-radius: 15px;
            }
            
            .video-header {
                padding: 20px 25px;
            }
            
            .video-header h2 {
                font-size: 22px;
            }
            
            .video-info {
                padding: 25px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .video-controls {
                padding: 20px 25px;
            }
            
            .btn-custom {
                display: block;
                width: calc(100% - 24px);
                margin: 10px 12px;
                text-align: center;
            }
            
            .debug-info {
                margin: 15px;
                padding: 15px;
                font-size: 12px;
            }
            
            .console-log {
                bottom: 10px;
                right: 10px;
                max-width: calc(100vw - 20px);
            }
            
            .console-toggle {
                bottom: 10px;
                left: 10px;
            }
            
            .autoplay-notice {
                margin: 15px;
                padding: 12px 20px;
            }
        }
        
        @media (max-width: 480px) {
            .main-container {
                padding: 20px 10px;
            }
            
            .header {
                padding: 20px 15px;
            }
            
            .header h1 {
                font-size: 20px;
            }
            
            .video-error {
                padding: 60px 25px;
            }
            
            .video-error i {
                font-size: 80px;
            }
            
            .video-error h3 {
                font-size: 24px;
            }
        }
        
        /* Video fullscreen */
        .video-container:-webkit-full-screen video {
            object-fit: contain;
        }
        
        .video-container:-moz-full-screen video {
            object-fit: contain;
        }
        
        .video-container:fullscreen video {
            object-fit: contain;
        }
    </style>
</head>
<body>
    <!-- Console Toggle -->
    <button class="console-toggle" onclick="toggleConsole()" style="display:none">
        <i class="fa fa-terminal"></i> Console
    </button>
    
    <!-- Console Log -->
    <div class="console-log" id="consoleLog"></div>

    <!-- Header -->
    <div class="header">
        <div class="container">
            <h1><i class="fa fa-graduation-cap"></i> Tutorial de Capacitación</h1>
            <p>Sistema de Liquidación de Gastos - Video Interactivo con Autoplay</p>
        </div>
    </div>

    <!-- Autoplay Notice -->
    <div class="autoplay-notice">
        <i class="fa fa-play-circle"></i>
        El video se reproducirá automáticamente con sonido activado
    </div>

    <!-- Debug Info -->
    @if(isset($debug) && config('app.debug'))
    <div class="debug-info" style="display:none;">
        <strong>🔍 INFORMACIÓN DE DEBUG DETALLADA:</strong><br><br>
        
        <strong>📁 Estado del Archivo:</strong><br>
        &nbsp;&nbsp;• Existe: {{ $debug['archivo_existe'] ? '✅ SÍ' : '❌ NO' }}<br>
        &nbsp;&nbsp;• Legible: {{ $debug['es_legible'] ? '✅ SÍ' : '❌ NO' }}<br>
        &nbsp;&nbsp;• Tamaño: <span style="color: #28a745;">{{ number_format($debug['tamaño']) }} bytes ({{ number_format($debug['tamaño'] / 1024 / 1024, 2) }} MB)</span><br><br>
        
        <strong>🌐 URLs y Rutas:</strong><br>
        &nbsp;&nbsp;• URL pública: <a href="{{ $debug['ruta_publica'] }}" target="_blank">{{ $debug['ruta_publica'] }}</a><br>
        &nbsp;&nbsp;• Ruta física: <code>{{ $debug['ruta_fisica'] }}</code><br>
        &nbsp;&nbsp;• Permisos: <code>{{ $debug['permisos'] }}</code><br><br>
        
        <strong>🔧 Diagnóstico:</strong><br>
        &nbsp;&nbsp;• Servidor: Laravel {{ app()->version() }} en {{ PHP_OS }}<br>
        &nbsp;&nbsp;• PHP: {{ PHP_VERSION }}<br>
        &nbsp;&nbsp;• User Agent: <span id="userAgent">Detectando...</span><br><br>
        
        <strong>💡 Acciones de prueba:</strong><br>
        &nbsp;&nbsp;1. <a href="{{ $debug['ruta_publica'] }}" target="_blank" style="color: #007bff; font-weight: bold;">🎬 Abrir video directamente</a><br>
        &nbsp;&nbsp;2. <button onclick="testVideoUrl()" style="background: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">🔍 Probar carga con fetch()</button><br>
        &nbsp;&nbsp;3. <button onclick="downloadVideo()" style="background: #17a2b8; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">⬇️ Forzar descarga</button>
    </div>
    @endif

    <!-- Main Content -->
    <div class="main-container">
        <div class="video-wrapper">
            <!-- Video Header -->
            <div class="video-header">
                <h2><i class="fa fa-play-circle"></i> Video Tutorial con Autoplay</h2>
                <p>El video se iniciará automáticamente con sonido activado</p>
            </div>

            <!-- Video o Error -->
            @if(isset($infoVideo) && $infoVideo['existe'])
                <!-- Video Container -->
                <div class="video-container" id="videoContainer">
                    <video 
                        id="tutorialVideo"
                        width="100%" 
                        height="100%" 
                        controls 
                        preload="auto"
                        autoplay
                        playsinline
                        crossorigin="anonymous"
                        data-src="{{ $rutaVideo }}"
                    >
                        <source src="{{ $rutaVideo }}#t=0.1" type="video/mp4">
                        <source src="{{ $rutaVideo }}" type="video/mp4">
                        <source src="{{ $rutaVideo }}" type="video/webm">
                        <p>
                            Tu navegador no soporta el elemento video HTML5.<br>
                            <a href="{{ $rutaVideo }}" target="_blank" style="color: #007bff;">👉 Descargar y ver video externamente</a>
                        </p>
                    </video>
                    
                    <!-- Loading Overlay -->

                    
                    <!-- Error Overlay -->
                    <div class="error-overlay" id="errorOverlay">
                        <div class="error-content">
                            <i class="fa fa-exclamation-triangle"></i>
                            <h3>Error al cargar el video</h3>
                            <p id="errorMessage">Ha ocurrido un problema al cargar el video</p>
                            <button class="error-button" onclick="forceReloadVideo()">
                                <i class="fa fa-refresh"></i> Reintentar Carga
                            </button>
                            <br><br>
                            <button class="error-button" onclick="openVideoDirectly()">
                                <i class="fa fa-external-link"></i> Abrir en Nueva Pestaña
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Video Info -->
                <div class="video-info" style="display: none;">
                    <h4><i class="fa fa-info-circle"></i> Información Detallada del Video</h4>
                    <div class="info-grid">
                        <div class="info-item">
                            <i class="fa fa-file-video-o"></i>
                            <div class="info-label">Archivo</div>
                            <div class="info-value">{{ $infoVideo['nombre'] }}</div>
                        </div>
                        <div class="info-item">
                            <i class="fa fa-hdd-o"></i>
                            <div class="info-label">Tamaño</div>
                            <div class="info-value">{{ number_format($infoVideo['tamaño'] / 1024 / 1024, 2) }} MB</div>
                        </div>
                        <div class="info-item">
                            <i class="fa fa-clock-o"></i>
                            <div class="info-label">Duración</div>
                            <div class="info-value" id="videoDuration">--:--</div>
                        </div>
                        <div class="info-item">
                            <i class="fa fa-desktop"></i>
                            <div class="info-label">Resolución</div>
                            <div class="info-value" id="videoResolution">Detectando...</div>
                        </div>
                        <div class="info-item">
                            <i class="fa fa-signal"></i>
                            <div class="info-label">Estado</div>
                            <div class="info-value" id="videoStatus">Autoplay activado</div>
                        </div>
                        <div class="info-item">
                            <i class="fa fa-volume-up"></i>
                            <div class="info-label">Audio</div>
                            <div class="info-value" id="audioStatus">Activado</div>
                        </div>
                    </div>
                </div>

                <!-- Video Controls -->
                <div class="video-controls" style="display: none;">
                    <button class="btn-custom" onclick="togglePlayPause()">
                        <i class="fa fa-pause" id="playIcon"></i> <span id="playText">Pausar</span>
                    </button>
                    <button class="btn-custom" onclick="toggleMute()">
                        <i class="fa fa-volume-up" id="muteIcon"></i> <span id="muteText">Silenciar</span>
                    </button>
                    <button class="btn-custom" onclick="toggleFullscreen()">
                        <i class="fa fa-expand"></i> Pantalla Completa
                    </button>
                    <a href="{{ $rutaVideo }}" download="{{ $infoVideo['nombre'] }}" class="btn-custom">
                        <i class="fa fa-download"></i> Descargar
                    </a>
                    <button class="btn-custom" onclick="forceReloadVideo()">
                        <i class="fa fa-refresh"></i> Recargar Video
                    </button>
                    <button class="btn-custom" onclick="openVideoDirectly()">
                        <i class="fa fa-external-link"></i> Abrir Directamente
                    </button>
                    <button class="btn-custom" onclick="restartVideo()">
                        <i class="fa fa-fast-backward"></i> Reiniciar
                    </button>
                </div>
            @else
                <!-- Error State -->
                <div class="video-error">
                    <i class="fa fa-exclamation-triangle"></i>
                    <h3>Video no disponible</h3>
                    <p>El archivo de video no se pudo encontrar en el servidor.</p>
                    <p><strong>Archivo esperado:</strong> <code>{{ public_path('firmas/liquidaciongastos.mp4') }}</code></p>
                    <p><strong>Tamaño esperado:</strong> Mayor a 0 bytes</p>
                    <a href="{{ url()->current() }}" class="btn-retry">
                        <i class="fa fa-refresh"></i> Reintentar Carga
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script>
        // Variables globales
        let video = null;
        let loadingOverlay = null;
        let errorOverlay = null;
        let consoleLog = null;
        let videoInitialized = false;
        let autoplayAttempted = false;
        let debugMode = {{ config('app.debug') ? 'true' : 'false' }};
        
        // Función de logging personalizada
        function logToConsole(message, type = 'info') {
            const timestamp = new Date().toLocaleTimeString();
            const logElement = document.getElementById('consoleLog');
            const colors = {
                'info': '#00ff00',
                'warn': '#ffff00',
                'error': '#ff0000',
                'success': '#00ffff'
            };
            
            if (logElement) {
                logElement.innerHTML += `<div style="color: ${colors[type]};">[${timestamp}] ${message}</div>`;
                logElement.scrollTop = logElement.scrollHeight;
            }
            
            console.log(`[VIDEO AUTOPLAY] ${message}`);
        }
        
        function toggleConsole() {
            const console = document.getElementById('consoleLog');
            if (console.style.display === 'none' || !console.style.display) {
                console.style.display = 'block';
            } else {
                console.style.display = 'none';
            }
        }
        
        function updateVideoStatus(status) {
            const statusElement = document.getElementById('videoStatus');
            if (statusElement) {
                statusElement.textContent = status;
            }
            logToConsole(`Estado: ${status}`, 'info');
        }
        
        function updateAudioStatus(status) {
            const audioElement = document.getElementById('audioStatus');
            if (audioElement) {
                audioElement.textContent = status;
            }
        }
        
        async function testVideoUrl() {
            const videoUrl = '{{ $rutaVideo }}';
            logToConsole('🔍 Probando acceso directo al video...', 'info');
            
            try {
                const response = await fetch(videoUrl, { method: 'HEAD' });
                logToConsole(`✅ Respuesta del servidor: ${response.status} ${response.statusText}`, 'success');
                logToConsole(`📊 Content-Type: ${response.headers.get('content-type')}`, 'info');
                logToConsole(`📏 Content-Length: ${response.headers.get('content-length')} bytes`, 'info');
                
                if (response.ok) {
                    logToConsole('🎉 El video es accesible via HTTP!', 'success');
                } else {
                    logToConsole('❌ Error HTTP al acceder al video', 'error');
                }
            } catch (error) {
                logToConsole(`❌ Error de red: ${error.message}`, 'error');
            }
        }
        
        function attemptAutoplayWithSound() {
            if (!video || autoplayAttempted) return;
            
            logToConsole('🎬 Intentando autoplay con sonido...', 'info');
            autoplayAttempted = true;
            
            // Asegurar que el video no esté silenciado
            video.muted = false;
            updateAudioStatus('Activado');
            updateMuteButton(false);
            
            // Intentar reproducir
            video.play().then(() => {
                logToConsole('🎉 ¡AUTOPLAY CON SONIDO EXITOSO!', 'success');
                updateVideoStatus('Reproduciendo con audio');
                updatePlayButton(true);
                
                // Ocultar loading después de un segundo
                setTimeout(() => {
                    if (loadingOverlay) loadingOverlay.style.display = 'none';
                }, 1000);
                
            }).catch(error => {
                logToConsole(`⚠️ Autoplay bloqueado: ${error.message}`, 'warn');
                logToConsole('💡 Intentando autoplay silenciado primero...', 'info');
                
                // Intentar con muted y luego activar sonido
                video.muted = true;
                updateAudioStatus('Silenciado temporalmente');
                updateMuteButton(true);
                
                video.play().then(() => {
                    logToConsole('✅ Autoplay silenciado exitoso', 'success');
                    updateVideoStatus('Reproduciendo (silenciado)');
                    updatePlayButton(true);
                    
                    // Intentar activar sonido después de 2 segundos
                    setTimeout(() => {
                        if (video && !video.paused) {
                            video.muted = false;
                            updateAudioStatus('Activado automáticamente');
                            updateMuteButton(false);
                            logToConsole('🔊 Sonido activado automáticamente', 'success');
                            updateVideoStatus('Reproduciendo con audio');
                        }
                    }, 2000);
                    
                    if (loadingOverlay) loadingOverlay.style.display = 'none';
                    
                }).catch(secondError => {
                    logToConsole(`❌ Autoplay completamente bloqueado: ${secondError.message}`, 'error');
                    updateVideoStatus('Autoplay bloqueado - Interacción requerida');
                    updateAudioStatus('Requiere interacción');
                    
                    // Mostrar mensaje al usuario
                    if (loadingOverlay) {
                        const loadingProgress = document.getElementById('loadingProgress');
                        if (loadingProgress) {
                            loadingProgress.innerHTML = '👆 Haz clic en "Reproducir" para iniciar con sonido';
                        }
                        
                        setTimeout(() => {
                            loadingOverlay.style.display = 'none';
                        }, 3000);
                    }
                });
            });
        }
        
        function initializeVideo() {
            video = document.getElementById('tutorialVideo');
            loadingOverlay = document.getElementById('loadingOverlay');
            errorOverlay = document.getElementById('errorOverlay');
            
            if (!video) {
                logToConsole('❌ Elemento video no encontrado', 'error');
                return;
            }
            
            if (videoInitialized) {
                logToConsole('⚠️ Video ya inicializado', 'warn');
                return;
            }
            
            logToConsole('🚀 Inicializando video con autoplay y sonido...', 'info');
            updateVideoStatus('Inicializando autoplay...');
            
            // Detectar user agent
            if (document.getElementById('userAgent')) {
                document.getElementById('userAgent').textContent = navigator.userAgent;
            }
            
            // Mostrar loading
            if (loadingOverlay) loadingOverlay.style.display = 'flex';
            if (errorOverlay) errorOverlay.style.display = 'none';
            
            // Event listeners
            setupVideoEventListeners();
            
            // Configurar video para autoplay
            video.preload = 'auto';
            video.autoplay = true;
            video.muted = false; // Intentar sin silencio desde el inicio
            
            videoInitialized = true;
            logToConsole('✅ Video configurado para autoplay con sonido', 'success');
        }
        
        function setupVideoEventListeners() {
            if (!video) return;
            
            video.addEventListener('loadstart', function() {
                logToConsole('🎬 Video: Iniciando carga para autoplay...', 'info');
                updateVideoStatus('Cargando para autoplay...');
                if (loadingOverlay) loadingOverlay.style.display = 'flex';
                document.getElementById('loadingProgress').textContent = 'Preparando autoplay...';
            });
            
            video.addEventListener('durationchange', function() {
                logToConsole(`⏱️ Video: Duración detectada: ${video.duration} segundos`, 'success');
                updateVideoStatus('Duración detectada');
            });
            
            video.addEventListener('loadedmetadata', function() {
                logToConsole('📊 Video: Metadatos cargados', 'success');
                logToConsole(`Duración: ${video.duration}s`, 'info');
                logToConsole(`Dimensiones: ${video.videoWidth}x${video.videoHeight}`, 'info');
                updateVideoStatus('Metadatos listos');
                
                // Actualizar información en la UI
                const duration = Math.floor(video.duration);
                const minutes = Math.floor(duration / 60);
                const seconds = duration % 60;
                const durationElement = document.getElementById('videoDuration');
                if (durationElement && !isNaN(duration)) {
                    durationElement.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
                }
                
                const resolutionElement = document.getElementById('videoResolution');
                if (resolutionElement && video.videoWidth && video.videoHeight) {
                    resolutionElement.textContent = video.videoWidth + 'x' + video.videoHeight;
                }
            });
            
            video.addEventListener('loadeddata', function() {
                logToConsole('🎞️ Video: Primer frame cargado', 'success');
                updateVideoStatus('Primer frame listo');
                document.getElementById('loadingProgress').textContent = 'Primer frame cargado...';
            });
            
            video.addEventListener('canplay', function() {
                logToConsole('▶️ Video: Puede reproducirse - INICIANDO AUTOPLAY', 'success');
                updateVideoStatus('Iniciando autoplay...');
                
                // Intentar autoplay inmediatamente cuando esté listo
                setTimeout(() => {
                    attemptAutoplayWithSound();
                }, 500);
            });
            
            video.addEventListener('canplaythrough', function() {
                logToConsole('🎯 Video: Completamente cargado', 'success');
                updateVideoStatus('Completamente cargado');
                
                // Segundo intento de autoplay si el primero falló
                if (!autoplayAttempted) {
                    setTimeout(() => {
                        attemptAutoplayWithSound();
                    }, 1000);
                }
            });
            
            video.addEventListener('play', function() {
                logToConsole('▶️ Video: REPRODUCIENDO', 'success');
                updateVideoStatus(video.muted ? 'Reproduciendo (silenciado)' : 'Reproduciendo con audio');
                updatePlayButton(true);
                if (loadingOverlay) loadingOverlay.style.display = 'none';
            });
            
            video.addEventListener('pause', function() {
                logToConsole('⏸️ Video: Pausado', 'info');
                updateVideoStatus('Pausado');
                updatePlayButton(false);
            });
            
            video.addEventListener('waiting', function() {
                logToConsole('⏳ Video: Esperando buffer...', 'warn');
                updateVideoStatus('Buffering...');
                if (loadingOverlay) {
                    loadingOverlay.style.display = 'flex';
                    document.getElementById('loadingProgress').textContent = 'Buffering...';
                }
            });
            
            video.addEventListener('playing', function() {
                logToConsole('🎵 Video: Reproduciendo activamente', 'success');
                updateVideoStatus(video.muted ? 'En reproducción (silenciado)' : 'En reproducción con audio');
                if (loadingOverlay) loadingOverlay.style.display = 'none';
            });
            
            video.addEventListener('stalled', function() {
                logToConsole('⚠️ Video: Descarga detenida', 'warn');
                updateVideoStatus('Descarga detenida');
                document.getElementById('loadingProgress').textContent = 'Descarga detenida...';
            });
            
            video.addEventListener('suspend', function() {
                logToConsole('⏹️ Video: Descarga suspendida', 'warn');
                updateVideoStatus('Descarga suspendida');
            });
            
            video.addEventListener('ended', function() {
                logToConsole('🏁 Video: Reproducción terminada', 'info');
                updateVideoStatus('Terminado');
                updatePlayButton(false);
            });
            
            video.addEventListener('volumechange', function() {
                const muteStatus = video.muted ? 'Silenciado' : 'Con sonido';
                logToConsole(`🔊 Cambio de volumen: ${muteStatus}`, 'info');
                updateAudioStatus(video.muted ? 'Silenciado' : 'Activado');
                updateMuteButton(video.muted);
            });
            
            video.addEventListener('error', function(e) {
                logToConsole('❌ ERROR DEL VIDEO:', 'error');
                logToConsole(`Código: ${video.error ? video.error.code : 'Desconocido'}`, 'error');
                logToConsole(`Mensaje: ${video.error ? video.error.message : 'Sin mensaje'}`, 'error');
                
                if (loadingOverlay) loadingOverlay.style.display = 'none';
                
                let errorText = 'Error desconocido';
                let errorDetails = '';
                
                if (video.error) {
                    switch(video.error.code) {
                        case 1:
                            errorText = 'Descarga abortada';
                            errorDetails = 'La descarga fue cancelada por el usuario o el navegador';
                            break;
                        case 2:
                            errorText = 'Error de red';
                            errorDetails = 'No se puede acceder al archivo de video en el servidor';
                            break;
                        case 3:
                            errorText = 'Error de decodificación';
                            errorDetails = 'El archivo está corrupto o el navegador no puede decodificarlo';
                            break;
                        case 4:
                            errorText = 'Formato no soportado';
                            errorDetails = 'El navegador no soporta el formato MP4 o los codecs utilizados';
                            break;
                    }
                }
                
                updateVideoStatus(`Error: ${errorText}`);
                updateAudioStatus('Error');
                
                if (errorOverlay) {
                    document.getElementById('errorMessage').innerHTML = `
                        <strong>${errorText}</strong><br>
                        ${errorDetails}<br><br>
                        <small>Código de error: ${video.error ? video.error.code : 'N/A'}</small>
                    `;
                    errorOverlay.style.display = 'flex';
                }
            });
            
            video.addEventListener('timeupdate', function() {
                if (video.currentTime > 0 && video.duration > 0) {
                    const percent = Math.round((video.currentTime / video.duration) * 100);
                    updateVideoStatus(`Reproduciendo ${percent}% ${video.muted ? '(silenciado)' : '(con audio)'}`);
                }
            });
        }
        
        function togglePlayPause() {
            if (!video) {
                logToConsole('⚠️ Video no inicializado', 'warn');
                initializeVideo();
                return;
            }
            
            if (video.paused) {
                video.muted = false; // Asegurar sonido al reproducir manualmente
                updateAudioStatus('Activado');
                video.play().then(() => {
                    logToConsole('✅ Play manual exitoso con sonido', 'success');
                }).catch(error => {
                    logToConsole(`❌ Error al reproducir: ${error.message}`, 'error');
                });
            } else {
                video.pause();
                logToConsole('⏸️ Video pausado manualmente', 'info');
            }
        }
        
        function updatePlayButton(isPlaying) {
            const icon = document.getElementById('playIcon');
            const text = document.getElementById('playText');
            if (icon && text) {
                if (isPlaying) {
                    icon.className = 'fa fa-pause';
                    text.textContent = 'Pausar';
                } else {
                    icon.className = 'fa fa-play';
                    text.textContent = 'Reproducir';
                }
            }
        }
        
        function updateMuteButton(isMuted) {
            const icon = document.getElementById('muteIcon');
            const text = document.getElementById('muteText');
            if (icon && text) {
                if (isMuted) {
                    icon.className = 'fa fa-volume-off';
                    text.textContent = 'Activar Sonido';
                } else {
                    icon.className = 'fa fa-volume-up';
                    text.textContent = 'Silenciar';
                }
            }
        }
        
        function toggleMute() {
            if (!video) {
                logToConsole('⚠️ Video no inicializado para mute', 'warn');
                return;
            }
            
            video.muted = !video.muted;
            logToConsole(`🔊 Mute: ${video.muted ? 'ON' : 'OFF'}`, 'info');
            updateAudioStatus(video.muted ? 'Silenciado' : 'Activado');
            updateMuteButton(video.muted);
        }
        
        function toggleFullscreen() {
            const videoContainer = document.getElementById('videoContainer');
            
            if (document.fullscreenElement) {
                document.exitFullscreen();
                logToConsole('📺 Saliendo de pantalla completa', 'info');
            } else if (videoContainer && videoContainer.requestFullscreen) {
                videoContainer.requestFullscreen().then(() => {
                    logToConsole('📺 Pantalla completa activada', 'success');
                }).catch(err => {
                    logToConsole(`❌ Error pantalla completa: ${err.message}`, 'error');
                });
            }
        }
        
        function forceReloadVideo() {
            logToConsole('🔄 Recargando video con autoplay...', 'info');
            
            if (video) {
                video.pause();
                video.currentTime = 0;
                video.muted = false;
                video.autoplay = true;
            }
            
            if (loadingOverlay) loadingOverlay.style.display = 'flex';
            if (errorOverlay) errorOverlay.style.display = 'none';
            
            updateVideoStatus('Recargando para autoplay...');
            updateAudioStatus('Preparando sonido...');
            autoplayAttempted = false;
            
            // Reinicializar después de un breve delay
            setTimeout(() => {
                if (video) {
                    video.load();
                }
            }, 1000);
        }
        
        function restartVideo() {
            if (!video) return;
            
            logToConsole('⏮️ Reiniciando video desde el inicio', 'info');
            video.currentTime = 0;
            video.muted = false;
            updateAudioStatus('Activado');
            updateMuteButton(false);
            
            if (video.paused) {
                video.play().then(() => {
                    logToConsole('✅ Video reiniciado y reproduciendo', 'success');
                }).catch(error => {
                    logToConsole(`❌ Error al reiniciar: ${error.message}`, 'error');
                });
            }
        }
        
        function openVideoDirectly() {
            const videoUrl = '{{ $rutaVideo }}';
            logToConsole('🌐 Abriendo video en nueva pestaña...', 'info');
            window.open(videoUrl, '_blank');
        }
        
        function downloadVideo() {
            const videoUrl = '{{ $rutaVideo }}';
            const link = document.createElement('a');
            link.href = videoUrl;
            link.download = '{{ $infoVideo["nombre"] ?? "liquidaciongastos.mp4" }}';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            logToConsole('⬇️ Iniciando descarga directa...', 'info');
        }
        
        // Inicialización automática cuando se carga el DOM
        document.addEventListener('DOMContentLoaded', function() {
            logToConsole('🚀 DOM cargado, inicializando autoplay...', 'success');
            
            // Inicializar inmediatamente
            setTimeout(() => {
                initializeVideo();
            }, 1000);
            
            // Test automático de conectividad
            if (debugMode) {
                setTimeout(() => {
                    testVideoUrl();
                }, 2000);
            }
        });
        
        // Atajos de teclado mejorados
        document.addEventListener('keydown', function(e) {
            // Solo si no estamos en un input
            if (e.target.tagName.toLowerCase() === 'input' || e.target.tagName.toLowerCase() === 'textarea') return;
            
            switch(e.code) {
                case 'Space':
                    e.preventDefault();
                    togglePlayPause();
                    break;
                case 'KeyM':
                    toggleMute();
                    break;
                case 'KeyF':
                    toggleFullscreen();
                    break;
                case 'KeyR':
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        forceReloadVideo();
                    } else {
                        restartVideo();
                    }
                    break;
                case 'KeyI':
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        initializeVideo();
                    }
                    break;
                case 'KeyC':
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        toggleConsole();
                    }
                    break;
                case 'ArrowLeft':
                    if (video && video.duration) {
                        video.currentTime = Math.max(0, video.currentTime - 10);
                        logToConsole('⏪ Retroceso 10s', 'info');
                    }
                    break;
                case 'ArrowRight':
                    if (video && video.duration) {
                        video.currentTime = Math.min(video.duration, video.currentTime + 10);
                        logToConsole('⏩ Avance 10s', 'info');
                    }
                    break;
                case 'Digit0':
                    if (video) {
                        restartVideo();
                    }
                    break;
            }
        });
        
        // Manejo de eventos de interacción del usuario para activar autoplay
        document.addEventListener('click', function(e) {
            if (!autoplayAttempted && video && video.paused) {
                logToConsole('👆 Interacción detectada - intentando autoplay', 'info');
                attemptAutoplayWithSound();
            }
        });
        
        // Manejo de errores globales
        window.addEventListener('error', function(e) {
            logToConsole(`❌ Error global: ${e.message}`, 'error');
        });
        
        // Log inicial
        logToConsole('🎬 Sistema de video tutorial con AUTOPLAY inicializado', 'success');
        logToConsole('🔊 El video se reproducirá automáticamente CON SONIDO', 'success');
        logToConsole('💡 Atajos: Espacio (play/pause), M (mute), F (fullscreen), R (restart), 0 (inicio)', 'info');
    </script>
</body>
</html>