@extends('layouts.app')

@section('title', 'LOTEAME - Dashboard Inmobiliario')

@section('page-title', 'Panel de Control Inmobiliario')

@section('breadcrumb')
    <div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
        <div>
            <h5 class="mb-1 fw-bold text-dark">Panel de Control & Ventas de Lotes</h5>
            <p class="text-muted small mb-0">Resumen comercial, inventario de lotes y recaudación</p>
        </div>
        <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
            <form action="{{ url('/bienvenido') }}" method="GET" class="d-flex align-items-center gap-2 flex-wrap flex-md-nowrap">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="material-symbols-outlined fs-18 text-muted">calendar_month</i></span>
                    <input type="date" name="fecha_inicio" class="form-control border-start-0" value="{{ $filtros['fecha_inicio'] }}">
                </div>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="material-symbols-outlined fs-18 text-muted">event</i></span>
                    <input type="date" name="fecha_fin" class="form-control border-start-0" value="{{ $filtros['fecha_fin'] }}">
                </div>
                <select name="proyecto" class="form-select form-select-sm" style="min-width: 170px;">
                    <option value="">Todos los Proyectos</option>
                    @foreach($proyectos as $p)
                        <option value="{{ $p['id'] }}" {{ $filtros['proyecto'] == $p['id'] ? 'selected' : '' }}>{{ $p['nombre'] }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-emerald-primary btn-sm d-flex align-items-center gap-1 text-white">
                    <i class="material-symbols-outlined fs-18">filter_alt</i> Filtrar
                </button>
                <a href="{{ url('/bienvenido') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1" title="Restablecer">
                    <i class="material-symbols-outlined fs-18">restart_alt</i>
                </a>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --lote-emerald: #059669;
            --lote-emerald-dark: #047857;
            --lote-amber: #f59e0b;
            --lote-blue: #0284c7;
            --lote-slate: #0f172a;
        }

        .btn-emerald-primary {
            background-color: var(--lote-emerald) !important;
            border-color: var(--lote-emerald) !important;
            color: #ffffff !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-emerald-primary:hover {
            background-color: var(--lote-emerald-dark) !important;
            border-color: var(--lote-emerald-dark) !important;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        .widget-card {
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: none;
            overflow: hidden;
            position: relative;
        }
        .widget-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2.5rem rgba(15, 23, 42, 0.08) !important;
        }
        .icon-box {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            flex-shrink: 0;
        }
        .card-consolidado-lote {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #064e3b 100%);
            color: white !important;
        }
        .card-consolidado-lote .text-secondary {
            color: rgba(255,255,255,0.75) !important;
        }
        .bg-glass {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .progress-lote {
            height: 8px;
            border-radius: 50px;
            background-color: #f1f5f9;
            overflow: hidden;
        }
        .badge-status-lote {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
@endpush

@section('content')
    <!-- Fila 1: Inventario de Lotes -->
    <div class="row g-3 mb-4">
        <!-- Total Lotes -->
        <div class="col-xl-3 col-sm-6">
            <div class="card bg-white widget-card rounded-4 shadow-sm h-100 border-start border-dark border-4">
                <div class="card-body p-3 p-xl-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box bg-dark bg-opacity-10 text-dark">
                            <span class="material-symbols-outlined fs-28">holiday_village</span>
                        </div>
                        <span class="badge bg-light text-dark fw-bold border px-2 py-1">Inventario Total</span>
                    </div>
                    <h3 class="mb-1 fw-bold fs-28 text-dark">{{ $totalLotes }} <small class="fs-14 fw-normal text-muted">Lotes</small></h3>
                    <p class="text-muted mb-0 fw-semibold text-uppercase fs-11 ls-1">{{ _count($proyectos) }} {{ _count($proyectos) == 1 ? 'Proyecto' : 'Proyectos' }} en Gestión</p>
                    <div class="progress-lote mt-3">
                        <div class="progress-bar bg-dark" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lotes Vendidos -->
        <div class="col-xl-3 col-sm-6">
            <div class="card bg-white widget-card rounded-4 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body p-3 p-xl-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <span class="material-symbols-outlined fs-28">verified</span>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1">{{ $porcentajeVendido }}% Vendido</span>
                    </div>
                    <h3 class="mb-1 fw-bold fs-28 text-success">{{ $lotesVendidos }} <small class="fs-14 fw-normal text-muted">Lotes</small></h3>
                    <p class="text-muted mb-0 fw-semibold text-uppercase fs-11 ls-1">Contratos Cerrados</p>
                    <div class="progress-lote mt-3">
                        <div class="progress-bar bg-success" style="width: {{ $porcentajeVendido }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lotes Reservados -->
        <div class="col-xl-3 col-sm-6">
            <div class="card bg-white widget-card rounded-4 shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body p-3 p-xl-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning">
                            <span class="material-symbols-outlined fs-28">schedule</span>
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-2 py-1">En Separación</span>
                    </div>
                    <h3 class="mb-1 fw-bold fs-28 text-warning">{{ $lotesReservados }} <small class="fs-14 fw-normal text-muted">Lotes</small></h3>
                    <p class="text-muted mb-0 fw-semibold text-uppercase fs-11 ls-1">Separaciones Activas</p>
                    <div class="progress-lote mt-3">
                        <div class="progress-bar bg-warning" style="width: {{ $totalLotes > 0 ? round(($lotesReservados / $totalLotes) * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lotes Disponibles -->
        <div class="col-xl-3 col-sm-6">
            <div class="card bg-white widget-card rounded-4 shadow-sm h-100 border-start border-info border-4">
                <div class="card-body p-3 p-xl-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box bg-info bg-opacity-10 text-info">
                            <span class="material-symbols-outlined fs-28">domain</span>
                        </div>
                        <span class="badge bg-info bg-opacity-10 text-info fw-bold px-2 py-1">Para Venta</span>
                    </div>
                    <h3 class="mb-1 fw-bold fs-28 text-info">{{ $lotesDisponibles }} <small class="fs-14 fw-normal text-muted">Lotes</small></h3>
                    <p class="text-muted mb-0 fw-semibold text-uppercase fs-11 ls-1">Disponibilidad Inmediata</p>
                    <div class="progress-lote mt-3">
                        <div class="progress-bar bg-info" style="width: {{ $totalLotes > 0 ? round(($lotesDisponibles / $totalLotes) * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fila 2: Métricas Financieras & Recaudación -->
    <div class="row g-4 mb-4">
        <!-- Recaudación Total Soles -->
        <div class="col-xl-4 col-md-12">
            <div class="card widget-card card-consolidado-lote rounded-4 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="icon-box bg-glass text-white">
                                <span class="material-symbols-outlined fs-30">payments</span>
                            </div>
                            <span class="badge bg-glass text-white border border-light border-opacity-25 px-3 py-2">Recaudación PEN</span>
                        </div>
                        <h2 class="mb-1 fw-bold text-white ls-1">S/ {{ number_format($totalRecaudadoSoles, 2) }}</h2>
                        <p class="text-secondary mb-0 fw-medium text-uppercase fs-11 ls-2">Total Recaudado en Soles</p>
                    </div>
                    <div class="mt-4 pt-3 border-top border-light border-opacity-10 d-flex justify-content-between align-items-center">
                        <small class="text-white text-opacity-75 d-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-16">receipt_long</span>
                            {{ $contratosEmitidos }} Contratos de Lote Emitidos
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recaudación Dólares -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-white widget-card rounded-4 shadow-sm h-100 border-start border-success border-5">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <span class="material-symbols-outlined fs-30">currency_exchange</span>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1">USD Cartera</span>
                    </div>
                    <h3 class="mb-1 fw-bold fs-28 text-dark">$ {{ number_format($totalRecaudadoDolares, 2) }}</h3>
                    <p class="text-muted mb-0 fw-semibold text-uppercase fs-10 ls-2">Recaudación en Dólares</p>
                    <div class="progress mt-4" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cobranzas del Mes / Clientes -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-white widget-card rounded-4 shadow-sm h-100 border-start border-primary border-5">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary">
                            <span class="material-symbols-outlined fs-30">account_balance</span>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1">Cobranza del Mes</span>
                    </div>
                    <h3 class="mb-1 fw-bold fs-28 text-dark">S/ {{ number_format($cuotasPorCobrarMes, 2) }}</h3>
                    <p class="text-muted mb-0 fw-semibold text-uppercase fs-10 ls-2">Cuotas Programadas este Mes</p>
                    <div class="progress mt-4" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fila 3: Gráficos de Ventas y Acciones Rápidas -->
    <div class="row g-4 mb-4">
        <!-- Gráfico Evolución de Ventas -->
        <div class="col-lg-8">
            <div class="card bg-white border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <div>
                            <h5 class="mb-1 fw-bold text-dark">Colocación Mensual de Lotes</h5>
                            <p class="text-muted small mb-0">Evolución de lotes vendidos y separados en el año</p>
                        </div>
                        <span class="badge bg-emerald-subtle text-success border border-success border-opacity-25 px-3 py-2 fw-semibold">
                            <span class="material-symbols-outlined fs-16 align-middle me-1">trending_up</span> Metas Cumplidas
                        </span>
                    </div>
                    <div style="position: relative; height: 320px;">
                        <canvas id="lotesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas Inmobiliarias -->
        <div class="col-lg-4">
            <div class="card bg-white border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="mb-3 fw-bold text-dark">Acciones Comerciales</h5>
                        <div class="d-grid gap-2">
                            <a href="{{ url('/agregar-reserva/1CIX00000012') }}" class="btn btn-emerald-primary py-3 d-flex align-items-center justify-content-center gap-2 shadow-sm rounded-3">
                                <span class="material-symbols-outlined">add_home_work</span> Nueva Separación / Reserva
                            </a>

                            <a href="{{ url('/plano-interactivo/1CIX00000008') }}" class="btn btn-outline-dark py-3 fw-bold d-flex align-items-center justify-content-center gap-2 rounded-3">
                                <span class="material-symbols-outlined">map</span> Plano Interactivo & Disponibilidad
                            </a>

                            <a href="{{ url('/agregar-cliente/1CIX00000009') }}" class="btn btn-outline-secondary py-3 fw-bold d-flex align-items-center justify-content-center gap-2 rounded-3">
                                <span class="material-symbols-outlined">person_add</span> Registrar Comprador
                            </a>

                            <a href="{{ url('/gestion-de-ventas/1CIX00000013') }}" class="btn btn-outline-info py-3 fw-bold d-flex align-items-center justify-content-center gap-2 rounded-3">
                                <span class="material-symbols-outlined">history_edu</span> Contratos de Compraventa
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded-3 border border-light">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-warning fs-20">lightbulb</span>
                            <span class="fw-bold text-dark small">Tip Inmobiliario</span>
                        </div>
                        <p class="text-muted small mb-0">
                            Mantén actualizado el estado de las separaciones para liberar los lotes que superen las 48 horas sin pago de inicial.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fila 4: Resumen de Proyectos y Urbanizaciones -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card bg-white border-0 rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-success fs-24">location_city</span>
                            <h5 class="mb-0 fw-bold text-dark">Proyectos y Urbanizaciones en Cartera</h5>
                        </div>
                        <span class="text-muted small">Total: {{ _count($proyectos) }} Proyectos Activos</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 text-secondary fw-bold py-3 px-3">Proyecto / Urbanización</th>
                                    <th class="border-0 text-secondary fw-bold py-3 px-3">Ubicación</th>
                                    <th class="border-0 text-secondary fw-bold py-3 px-3 text-center">Total Lotes</th>
                                    <th class="border-0 text-secondary fw-bold py-3 px-3 text-center">Vendidos</th>
                                    <th class="border-0 text-secondary fw-bold py-3 px-3 text-center">Separados</th>
                                    <th class="border-0 text-secondary fw-bold py-3 px-3 text-center">Disponibles</th>
                                    <th class="border-0 text-secondary fw-bold py-3 px-3 text-center">Precio m²</th>
                                    <th class="border-0 text-secondary fw-bold py-3 px-3 text-center">Avance</th>
                                    <th class="border-0 text-secondary fw-bold py-3 px-3 text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($proyectos as $p)
                                    <tr>
                                        <td class="py-3 px-3 border-bottom">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="icon-box bg-success bg-opacity-10 text-success" style="width: 36px; height: 36px;">
                                                    <span class="material-symbols-outlined fs-20">domain</span>
                                                </div>
                                                <span class="fw-bold text-dark">{{ $p['nombre'] }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 border-bottom text-muted">
                                            <span class="material-symbols-outlined fs-16 align-middle text-secondary">pin_drop</span>
                                            {{ $p['ubicacion'] }}
                                        </td>
                                        <td class="py-3 px-3 border-bottom text-center fw-bold">{{ $p['total_lotes'] }}</td>
                                        <td class="py-3 px-3 border-bottom text-center text-success fw-bold">{{ $p['vendidos'] }}</td>
                                        <td class="py-3 px-3 border-bottom text-center text-warning fw-bold">{{ $p['reservados'] }}</td>
                                        <td class="py-3 px-3 border-bottom text-center text-info fw-bold">{{ $p['disponibles'] }}</td>
                                        <td class="py-3 px-3 border-bottom text-center fw-bold text-dark">{{ $p['precio_m2'] }}</td>
                                        <td class="py-3 px-3 border-bottom text-center" style="min-width: 140px;">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress-lote flex-grow-1" style="height: 6px;">
                                                    <div class="progress-bar bg-success" style="width: {{ $p['progreso'] }}%"></div>
                                                </div>
                                                <span class="small fw-bold text-muted">{{ $p['progreso'] }}%</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 border-bottom text-center">
                                            @if($p['estado'] == 'Liquidado')
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1 rounded-pill">
                                                    Liquidado
                                                </span>
                                            @elseif($p['estado'] == 'En Venta')
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill">
                                                    En Venta
                                                </span>
                                            @else
                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 rounded-pill">
                                                    Configuración
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">
                                            <i class="material-symbols-outlined fs-36 d-block mb-1 text-secondary">domain_disabled</i>
                                            No hay proyectos registrados para esta empresa todavía.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('lotesChart');
            if (ctx) {
                var labels = {!! json_encode($ventasMesesLabels) !!};
                var lotesData = {!! json_encode($ventasMesesData) !!};

                new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Lotes Vendidos / Separados',
                                data: lotesData,
                                backgroundColor: 'rgba(5, 150, 105, 0.85)',
                                borderColor: '#059669',
                                borderWidth: 1,
                                borderRadius: 6,
                                barThickness: 24
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { size: 13, weight: 'bold' },
                                bodyFont: { size: 12 },
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return ' ' + context.raw + ' lotes colocados';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f1f5f9'
                                },
                                ticks: {
                                    stepSize: 5
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush