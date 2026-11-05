{{-- ALERTA DE ÉXITO --}}
@if (session('success') || session('bienhecho'))
    <div id="floating-alert-success" class="floating-alert floating-alert-success show">
        <i class="ri-checkbox-circle-line alert-icon"></i>
        <span>{{ session('success') ?? session('bienhecho') }}</span>
        <button class="close-btn" onclick="closeAlert('floating-alert-success')">&times;</button>
    </div>
@endif

{{-- ALERTA DE ERROR --}}
@if (session('error') || session('errorbd') || session('errorurl'))
    <div id="floating-alert-error" class="floating-alert floating-alert-error show">
        <i class="ri-error-warning-line alert-icon"></i>
        <span>{{ session('error') ?? session('errorbd') ?? session('errorurl') }}</span>
        <button class="close-btn" onclick="closeAlert('floating-alert-error')">&times;</button>
    </div>
@endif

{{-- ALERTA DE ADVERTENCIA --}}
@if (session('warning'))
    <div id="floating-alert-warning" class="floating-alert floating-alert-warning show">
        <i class="ri-alert-line alert-icon"></i>
        <span>{{ session('warning') }}</span>
        <button class="close-btn" onclick="closeAlert('floating-alert-warning')">&times;</button>
    </div>
@endif

{{-- ALERTA DE INFORMACIÓN --}}
@if (session('info'))
    <div id="floating-alert-info" class="floating-alert floating-alert-info show">
        <i class="ri-information-line alert-icon"></i>
        <span>{{ session('info') }}</span>
        <button class="close-btn" onclick="closeAlert('floating-alert-info')">&times;</button>
    </div>
@endif

{{-- VALIDACIONES DE FORMULARIO --}}
@if ($errors->any())
    <div id="floating-alert-validation" class="floating-alert floating-alert-error show">
        <i class="ri-error-warning-line alert-icon"></i>
        <div>
            <strong>Errores de validación:</strong>
            <ul class="mb-0 mt-1 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button class="close-btn" onclick="closeAlert('floating-alert-validation')">&times;</button>
    </div>
@endif

<div class="panel-ajax-alert" 
     style="position: fixed; top: 20px; right: 20px; z-index: 999999; width: auto; max-width: 300px;">
</div>

<div class="panel-ajax-alert-mobil" 
     style="position: fixed; top: 80px; right: 20px; z-index: 999999; width: auto; max-width: 300px;">
</div>

<div class="panel-ajax-alert-flotante" 
     style="position: fixed; bottom: 20px; right: 20px; z-index: 999999; width: auto; max-width: 300px;">
</div>


<script>
    function closeAlert(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('hide');
            setTimeout(() => alert.remove(), 500);
        }
    }

    // Auto-cerrar todas las alertas después de 5 segundos
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.floating-alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                closeAlert(alert.id);
            }, 5000);
        });
    });
</script>

<style>
    /* Estilos base para todas las alertas */
    .floating-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 16px rgba(0,0,0,0.2);
        font-size: 15px;
        font-weight: 500;
        z-index: 99999;
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0;
        transform: translateX(100px);
        transition: opacity 0.4s ease, transform 0.4s ease;
        max-width: 450px;
        min-width: 300px;
    }

    .floating-alert.show {
        opacity: 1;
        transform: translateX(0);
    }

    .floating-alert.hide {
        opacity: 0;
        transform: translateX(100px);
    }

    .floating-alert .alert-icon {
        font-size: 24px;
        flex-shrink: 0;
    }

    .floating-alert .close-btn {
        background: transparent;
        border: none;
        color: white;
        font-size: 22px;
        margin-left: auto;
        cursor: pointer;
        line-height: 1;
        flex-shrink: 0;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.3s;
    }

    .floating-alert .close-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Alerta de ÉXITO */
    .floating-alert-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        border-left: 5px solid #1e7e34;
    }

    /* Alerta de ERROR */
    .floating-alert-error {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border-left: 5px solid #a71d2a;
    }

    /* Alerta de ADVERTENCIA */
    .floating-alert-warning {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        border-left: 5px solid #e68900;
        color: #212529;
    }

    .floating-alert-warning .close-btn {
        color: #212529;
    }

    .floating-alert-warning .close-btn:hover {
        background: rgba(0, 0, 0, 0.1);
    }

    /* Alerta de INFORMACIÓN */
    .floating-alert-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        border-left: 5px solid #0c5460;
    }

    /* Estilos para listas de validación */
    .floating-alert ul {
        list-style: none;
        padding-left: 0;
    }

    .floating-alert ul li {
        padding: 2px 0;
    }

    .floating-alert ul li:before {
        content: "• ";
        font-weight: bold;
        margin-right: 5px;
    }
</style>