async function captureDeviceInfo() {
    // --- IP Pública ---
    let publicIp = 'No disponible';
    try {
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 2000);
        const response = await fetch('https://api.ipify.org?format=json', { signal: controller.signal });
        const data = await response.json();
        publicIp = data.ip;
        clearTimeout(timeoutId);
    } catch (e) { console.warn("IP no disponible"); }

    // --- Identificador de GPU ---
    const getGPU = () => {
        const canvas = document.createElement('canvas');
        const gl = canvas.getContext('webgl');
        if (!gl) return 'N/A';
        const debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
        return debugInfo ? gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL) : 'N/A';
    };

    const getDeviceType = () => {
        const ua = navigator.userAgent;
        if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
            return "Tablet";
        }
        if (/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(ua)) {
            return "Movil";
        }
        return "Desktop/Laptop";
    };

    const getOperatingSystem = () => {
        const ua = navigator.userAgent;
        if (ua.indexOf("Win") != -1) return "Windows";
        if (ua.indexOf("Mac") != -1) return "MacOS";
        if (ua.indexOf("Linux") != -1) return "Linux";
        if (ua.indexOf("Android") != -1) return "Android";
        if (ua.indexOf("like Mac") != -1) return "iOS";
        return "Desconocido";
    };

    // --- Canvas Fingerprint (NUEVO) ---
    // Crea una firma única basada en cómo la PC dibuja gráficos
    const getCanvasFingerprint = () => {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        ctx.textBaseline = "top";
        ctx.font = "14px 'Arial'";
        ctx.fillStyle = "#f60";
        ctx.fillRect(125,1,62,20);
        ctx.fillStyle = "#069";
        ctx.fillText("Empresa_Log_ID_123", 2, 15);
        ctx.fillStyle = "rgba(102, 204, 0, 0.7)";
        ctx.fillText("Empresa_Log_ID_123", 4, 17);
        return canvas.toDataURL();
    };

    const info = {
        ip: publicIp,
        navegador: navigator.userAgent,
        resolucion: `${screen.width}x${screen.height}x${screen.colorDepth}`,
        memoria: navigator.deviceMemory || 'N/A',
        nucleos: navigator.hardwareConcurrency || 'N/A',
        gpu: getGPU(),
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        idioma: navigator.language,
        plataforma: navigator.platform,
        tipo_dispositivo: getDeviceType(),
        sistema_operativo: getOperatingSystem(),
        es_tactil: navigator.maxTouchPoints > 0
    };

    // Generamos el Fingerprint con los nuevos datos
    info.fingerprint = btoa([
        info.navegador,
        info.resolucion,
        info.nucleos,
        info.gpu,
        info.memoria,
        info.tipo_dispositivo,
        info.sistema_operativo,
        info.es_tactil,
        getCanvasFingerprint().slice(-50) // Usamos solo el final de la imagen canvas para brevedad
    ].join('|'));

    return info;
}


// Cuando la página termine de cargar
$(document).ready(function() {
    // Llamar a la función async y cargar el input
    captureDeviceInfo().then(info => {
        // Convertir a JSON y asignar al input
        $('#device_info').val(JSON.stringify(info));
        console.log('Device info cargado:', info.deviceFingerprint);
    }).catch(error => {
        console.error('Error capturando device info:', error);
        // Cargar info mínima si falla
        $('#device_info').val(JSON.stringify({
            error: 'No se pudo capturar información completa',
            userAgent: navigator.userAgent,
            timestamp: new Date().toISOString()
        }));
    });
});
