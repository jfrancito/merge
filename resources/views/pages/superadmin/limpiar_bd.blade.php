@extends('layouts.app')

@section('title', '⚠️ Limpieza de Base de Datos')

@section('page-title', 'Panel Super Admin')

@section('breadcrumb')
    <div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
        <h5 class="mb-0">Limpieza de Base de Datos</h5>
        <ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
            <li class="breadcrumb-item d-inline-block position-relative">
                <a href="{{ url('/') }}" class="d-inline-block position-relative">
                    <i class="material-symbols-outlined">home</i>
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item d-inline-block position-relative">
                Super Admin
            </li>
            <li class="breadcrumb-item d-inline-block position-relative">
                Limpieza BD
            </li>
        </ol>
    </div>
@endsection

@push('styles')
<style>
    /* ============================
       ESTILOS PARA PANTALLA DE LIMPIEZA
       ============================ */
    .danger-zone-header {
        background: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%);
        border-radius: 16px 16px 0 0;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .danger-zone-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .danger-zone-header .warning-icon {
        font-size: 3.5rem;
        animation: pulse-warning 2s infinite;
    }
    @keyframes pulse-warning {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.85; }
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
    .stat-card {
        background: #fff;
        border: 1.5px solid #f0f4fa;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.85rem;
        transition: all 0.2s ease;
    }
    .stat-card:hover {
        border-color: #dc3545;
        box-shadow: 0 4px 15px rgba(220,53,69,0.08);
        transform: translateY(-2px);
    }
    .stat-card .stat-icon {
        width: 42px;
        height: 42px;
        background: #fff5f5;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .stat-card .stat-num {
        font-size: 1.5rem;
        font-weight: 700;
        color: #dc3545;
        line-height: 1;
    }
    .stat-card .stat-label {
        font-size: 0.78rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }
    .stat-card.stat-zero {
        opacity: 0.5;
    }
    .stat-card.stat-zero .stat-num {
        color: #28a745;
    }
    .stat-card.stat-zero .stat-icon {
        background: #f0fff4;
    }
    .confirm-box {
        border: 2px dashed #dc3545;
        border-radius: 12px;
        padding: 1.5rem;
        background: #fff8f8;
    }
    .confirm-box .form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220,53,69,0.25);
    }
    #btn-ejecutar {
        transition: all 0.3s ease;
    }
    #btn-ejecutar:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        filter: grayscale(0.4);
    }
    #btn-ejecutar:not(:disabled) {
        animation: btn-pulse 1.5s infinite;
    }
    @keyframes btn-pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
    }
    .safe-badge {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 8px;
        padding: 0.5rem 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.82rem;
        font-weight: 600;
    }
    .total-banner {
        background: linear-gradient(135deg, #212529, #343a40);
        border-radius: 12px;
        color: white;
        padding: 1rem 1.5rem;
    }
</style>
@endpush

@section('content')

{{-- Alerta de éxito --}}
@if(session('bienhecho'))
    <div class="alert alert-success border-0 rounded-3 mb-4 d-flex align-items-center gap-2 shadow-sm" role="alert">
        <i class="ri-checkbox-circle-fill fs-20"></i>
        <span>{{ session('bienhecho') }}</span>
    </div>
@endif

{{-- Alerta de error --}}
@if(session('errorbd'))
    <div class="alert alert-danger border-0 rounded-3 mb-4 d-flex align-items-center gap-2 shadow-sm" role="alert">
        <i class="ri-error-warning-fill fs-20"></i>
        <span>{{ session('errorbd') }}</span>
    </div>
@endif

<div class="card border-0 rounded-4 overflow-hidden shadow-sm mb-4">

    {{-- HEADER DE ZONA PELIGROSA --}}
    <div class="danger-zone-header">
        <div class="d-flex align-items-center gap-3">
            <div class="warning-icon">⚠️</div>
            <div>
                <h2 class="mb-1 fw-bold">Zona de Peligro — Limpieza Total</h2>
                <p class="mb-0 opacity-75 fs-14">
                    Esta acción eliminará <strong>todos los datos de prueba</strong> de la base de datos.
                    Solo se conservará la empresa y el usuario Super Administrador.
                    <strong>Esta operación es IRREVERSIBLE.</strong>
                </p>
            </div>
        </div>
    </div>

    <div class="card-body p-4">

        {{-- SECCIÓN: LO QUE SE CONSERVA --}}
        <div class="mb-4">
            <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                <i class="ri-shield-check-fill text-success fs-20"></i>
                Lo que se conservará
            </h5>
            <div class="d-flex flex-wrap gap-2">
                <span class="safe-badge"><i class="ri-building-line"></i> Empresa INVOXA (1CIX00000001)</span>
                <span class="safe-badge"><i class="ri-user-star-line"></i> Usuario Super Admin</span>
                <span class="safe-badge"><i class="ri-shield-star-line"></i> Rol Super Admin</span>
                <span class="safe-badge"><i class="ri-menu-line"></i> Menú del sistema completo</span>
                <span class="safe-badge"><i class="ri-map-pin-line"></i> Tabla Ubigeos (catálogo Perú)</span>
            </div>
        </div>

        <hr class="my-4">

        {{-- SECCIÓN: ESTADÍSTICAS DE LO QUE SE ELIMINARÁ --}}
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                    <i class="ri-delete-bin-6-fill text-danger fs-20"></i>
                    Registros que serán eliminados
                </h5>
                @php $totalRegistros = array_sum($stats); @endphp
                <div class="total-banner">
                    <span class="fs-12 opacity-75 text-uppercase letter-spacing-1">Total a eliminar</span>
                    <div class="fs-22 fw-bold">{{ number_format($totalRegistros) }} registros</div>
                </div>
            </div>

            <div class="stats-grid">

                <div class="stat-card {{ $stats['empresas'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">🏢</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['empresas']) }}</div>
                        <div class="stat-label">Empresas</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['users'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">👤</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['users']) }}</div>
                        <div class="stat-label">Usuarios</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['rols'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">🛡️</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['rols']) }}</div>
                        <div class="stat-label">Roles</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['rolopciones_no_sa'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">🔑</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['rolopciones_no_sa']) }}</div>
                        <div class="stat-label">Permisos</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['ventas'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">🧾</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['ventas']) }}</div>
                        <div class="stat-label">Ventas (CPE)</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['venta_detalles'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">📋</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['venta_detalles']) }}</div>
                        <div class="stat-label">Det. Ventas</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['venta_sunat_logs'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">📡</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['venta_sunat_logs']) }}</div>
                        <div class="stat-label">Logs SUNAT</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['venta_cuotas'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">💳</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['venta_cuotas']) }}</div>
                        <div class="stat-label">Cuotas</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['resumenes_diarios'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">📅</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['resumenes_diarios']) }}</div>
                        <div class="stat-label">Resúmenes</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['guias'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">🚛</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['guias']) }}</div>
                        <div class="stat-label">Guías</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['guia_detalles'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">📦</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['guia_detalles']) }}</div>
                        <div class="stat-label">Det. Guías</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['ordenes_pedido'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">📝</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['ordenes_pedido']) }}</div>
                        <div class="stat-label">Órdenes Pedido</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['ordenes_pedido_det'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">🗒️</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['ordenes_pedido_det']) }}</div>
                        <div class="stat-label">Det. Órdenes</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['clientes'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">👥</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['clientes']) }}</div>
                        <div class="stat-label">Clientes</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['productos'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">📦</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['productos']) }}</div>
                        <div class="stat-label">Productos</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['sedes'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">🏬</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['sedes']) }}</div>
                        <div class="stat-label">Sedes</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['series'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">🔢</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['series']) }}</div>
                        <div class="stat-label">Series</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['usuario_series'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">🔗</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['usuario_series']) }}</div>
                        <div class="stat-label">Asig. Series</div>
                    </div>
                </div>

                <div class="stat-card {{ $stats['tipo_cambios'] == 0 ? 'stat-zero' : '' }}">
                    <div class="stat-icon">💱</div>
                    <div>
                        <div class="stat-num">{{ number_format($stats['tipo_cambios']) }}</div>
                        <div class="stat-label">Tipos Cambio</div>
                    </div>
                </div>

            </div>

            {{-- Nota si ya está limpia --}}
            @if($totalRegistros == 0)
                <div class="alert alert-success border-0 rounded-3 mt-3 d-flex align-items-center gap-2">
                    <i class="ri-checkbox-circle-fill fs-20"></i>
                    <strong>¡La base de datos ya está limpia!</strong> No hay registros de prueba para eliminar. Puedes proceder a producción.
                </div>
            @endif
        </div>

        <hr class="my-4">

        {{-- SECCIÓN: FORMULARIO DE CONFIRMACIÓN --}}
        @if($totalRegistros > 0)
        <div class="mb-2">
            <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                <i class="ri-lock-password-fill text-danger fs-20"></i>
                Confirmación de seguridad
            </h5>

            <div class="alert alert-warning border-0 rounded-3 d-flex gap-2 mb-4">
                <i class="ri-information-fill fs-18 flex-shrink-0 mt-1"></i>
                <div>
                    <strong>¿Tiene un backup?</strong> Antes de continuar, asegúrese de haber realizado un
                    <strong>backup completo de la base de datos</strong>. Esta operación no puede deshacerse.
                </div>
            </div>

            <form id="form-limpieza" method="POST" action="{{ url('/superadmin/limpiar-bd/ejecutar') }}" autocomplete="off">
                @csrf

                <div class="confirm-box">
                    <div class="row g-3">

                        {{-- Campo de confirmación de texto --}}
                        <div class="col-md-6">
                            <label for="confirmacion" class="form-label fw-semibold text-danger">
                                Paso 1: Escribe <code class="bg-danger text-white px-2 py-1 rounded">CONFIRMAR</code> para activar el botón
                            </label>
                            <input
                                type="text"
                                id="confirmacion"
                                name="confirmacion"
                                class="form-control form-control-lg @error('confirmacion') is-invalid @enderror"
                                placeholder="Escribe: CONFIRMAR"
                                autocomplete="off"
                                spellcheck="false"
                                maxlength="10"
                            >
                            @error('confirmacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Debe escribir exactamente: CONFIRMAR (en mayúsculas)</div>
                        </div>

                        {{-- Campo de contraseña --}}
                        <div class="col-md-6">
                            <label for="password_admin" class="form-label fw-semibold text-danger">
                                Paso 2: Ingresa tu contraseña de Super Admin
                            </label>
                            <input
                                type="password"
                                id="password_admin"
                                name="password_admin"
                                class="form-control form-control-lg @error('password_admin') is-invalid @enderror"
                                placeholder="Tu contraseña actual"
                                autocomplete="new-password"
                            >
                            @error('password_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Se verificará contra la contraseña almacenada en el sistema</div>
                        </div>

                    </div>

                    <div class="mt-4 d-flex align-items-center gap-3 flex-wrap">
                        <button
                            type="submit"
                            id="btn-ejecutar"
                            class="btn btn-danger btn-lg px-5 fw-bold d-flex align-items-center gap-2"
                            disabled
                        >
                            <i class="ri-delete-bin-6-fill"></i>
                            Ejecutar Limpieza ({{ number_format($totalRegistros) }} registros)
                        </button>

                        <a href="{{ url('/bienvenido') }}" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="ri-arrow-left-line me-1"></i>
                            Cancelar
                        </a>

                        <div id="estado-confirmacion" class="ms-auto">
                            <span class="badge bg-secondary px-3 py-2 fs-12" id="badge-estado">
                                <i class="ri-lock-line me-1"></i> Pendiente de confirmación
                            </span>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        @else
        <div class="text-center py-3">
            <a href="{{ url('/bienvenido') }}" class="btn btn-primary btn-lg px-5">
                <i class="ri-home-line me-2"></i> Ir al Inicio
            </a>
        </div>
        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const inputConfirmacion = document.getElementById('confirmacion');
    const inputPassword     = document.getElementById('password_admin');
    const btnEjecutar       = document.getElementById('btn-ejecutar');
    const badgeEstado       = document.getElementById('badge-estado');

    if (!inputConfirmacion || !btnEjecutar) return;

    function verificarCondiciones() {
        const textoOk    = inputConfirmacion.value.trim() === 'CONFIRMAR';
        const passOk     = inputPassword.value.trim().length >= 4;
        const todoOk     = textoOk && passOk;

        btnEjecutar.disabled = !todoOk;

        if (todoOk) {
            badgeEstado.className = 'badge bg-danger px-3 py-2 fs-12';
            badgeEstado.innerHTML = '<i class="ri-alarm-warning-line me-1"></i> ¡Listo para ejecutar!';
        } else if (textoOk && !passOk) {
            badgeEstado.className = 'badge bg-warning text-dark px-3 py-2 fs-12';
            badgeEstado.innerHTML = '<i class="ri-key-line me-1"></i> Ingresa tu contraseña';
        } else {
            badgeEstado.className = 'badge bg-secondary px-3 py-2 fs-12';
            badgeEstado.innerHTML = '<i class="ri-lock-line me-1"></i> Pendiente de confirmación';
        }
    }

    inputConfirmacion.addEventListener('input', verificarCondiciones);
    inputPassword.addEventListener('input', verificarCondiciones);

    // Confirmación final antes de enviar
    document.getElementById('form-limpieza').addEventListener('submit', function(e) {
        e.preventDefault();

        const totalRegistros = {{ $totalRegistros }};

        if (!confirm(
            '🚨 ÚLTIMA ADVERTENCIA 🚨\n\n' +
            'Estás a punto de eliminar ' + totalRegistros.toLocaleString() + ' registros de la base de datos.\n\n' +
            '¿Tienes backup?\n¿Estás ABSOLUTAMENTE seguro?\n\n' +
            'Esta acción NO se puede deshacer.'
        )) {
            return;
        }

        // Cambiar botón a estado cargando
        btnEjecutar.disabled  = true;
        btnEjecutar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Ejecutando limpieza...';

        this.submit();
    });

});
</script>
@endpush
