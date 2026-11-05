@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    .report-card { border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; border: none; overflow: hidden; }
    .filter-section { background: #f8f9fa; border-radius: 12px; border: 1px solid #e9ecef; transition: all 0.3s ease; }
    .filter-section:hover { border-color: #1a73e8; box-shadow: 0 5px 15px rgba(26,115,232,0.05); }
    .form-control-custom {
        border: 2px solid #e9ecef !important;
        border-radius: 8px !important;
        padding: 10px 15px !important;
        background-color: #ffffff !important;
        transition: all 0.3s ease !important;
    }
    .form-control-custom:focus {
        border-color: #1a73e8 !important;
        box-shadow: 0 0 0 3px rgba(26,115,232,0.1) !important;
    }
    .btn-premium {
        border-radius: 10px !important;
        padding: 12px 25px !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.3s ease;
    }
    .btn-search { background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%) !important; color: white !important; }
    .btn-search:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(26,115,232,0.4); }
    .btn-download { background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%) !important; color: white !important; }
    .btn-download:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(45,206,137,0.4); }
    .report-title { color: #0d47a1; font-weight: 800; font-size: 1.4rem; letter-spacing: -0.5px; }
    .report-subtitle { color: #525f7f; font-weight: 400; font-size: 0.9rem; }
    .card-header-gradient { background: linear-gradient(87deg, #ffffff 0, #f8f9fa 100%) !important; border-bottom: 1px solid #e9ecef !important; }

    /* Cards de resumen */
    .stat-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    .stat-card .stat-value { font-size: 1.8rem; font-weight: 800; }
    .stat-card .stat-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; color: #6c757d; }

    /* Asientos */
    .asiento-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }
    .asiento-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .asiento-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2b5797 100%);
        color: #fff;
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .asiento-header .comprobante-nombre { font-weight: 700; font-size: 14px; }
    .asiento-header .comprobante-info { font-size: 12px; opacity: 0.85; }
    .asiento-table { font-size: 12px; margin-bottom: 0; }
    .asiento-table thead th {
        background: #f1f5f9;
        border: none;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #475569;
        padding: 8px 12px;
    }
    .asiento-table td { padding: 8px 12px; vertical-align: middle; }
    .asiento-table .cuenta-code { font-family: 'Courier New', monospace; font-weight: 700; color: #1e3a5f; font-size: 13px; }
    .asiento-table .monto-debe { color: #1565c0; font-weight: 700; }
    .asiento-table .monto-haber { color: #2e7d32; font-weight: 700; }
    .asiento-table .row-gratuita { background: #fff8e1 !important; }
    .asiento-table .row-separador {
        background: #fff3e0 !important;
        font-weight: 700;
        font-style: italic;
        color: #bf360c;
        font-size: 11px;
    }
    .asiento-footer {
        background: #e8f5e9;
        padding: 8px 12px;
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        font-size: 12px;
    }
    .badge-gratuita {
        background: linear-gradient(135deg, #ff9800, #f57c00);
        color: #fff;
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 20px;
        font-weight: 700;
    }
    .badge-normal {
        background: rgba(255,255,255,0.2);
        color: #fff;
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 20px;
        font-weight: 600;
    }
</style>

<div class="card bg-white border-0 rounded-3 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <h3 class="mb-0">Asientos Contables</h3>
        </div>

        <div class="row g-3 mb-4 p-4 rounded-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafd 100%); border: 1px solid #e5eaf0; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">

                        <form id="formAsientos" class="w-100">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold text-secondary fs-11 text-uppercase letter-spacing-1 mb-2">Fecha de Inicio</label>
                                    <input type="date" name="fecha_desde" class="form-control border-0 shadow-sm fs-13 rounded-3" style="background-color: #f0f4fa; padding: 10px 15px; color: #1a1a2e; font-weight: 500;" value="{{ date('Y-m-01') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold text-secondary fs-11 text-uppercase letter-spacing-1 mb-2">Fecha Final</label>
                                    <input type="date" name="fecha_hasta" class="form-control border-0 shadow-sm fs-13 rounded-3" style="background-color: #f0f4fa; padding: 10px 15px; color: #1a1a2e; font-weight: 500;" value="{{ date('Y-m-t') }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" id="btnGenerar" class="btn btn-outline-primary w-100 fs-13 rounded-3" style="padding: 10px; font-weight: 600; border-width: 1.5px; transition: all 0.2s;">
                                        <i class="ri-search-line me-1"></i> Generar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Pestañas de Navegación -->
                    <ul class="nav nav-tabs border-0 mb-4 bg-light p-1 rounded-3" id="asientosTabs" role="tablist" style="gap: 5px;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active border-0 rounded-3 px-4 py-2 fw-bold text-secondary" id="tabEstandar" data-bs-toggle="tab" data-bs-target="#panelEstandar" type="button" role="tab" aria-controls="panelEstandar" aria-selected="true" style="transition: all 0.2s;">
                                Formato Estándar
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link border-0 rounded-3 px-4 py-2 fw-bold text-secondary" id="tabConcar" data-bs-toggle="tab" data-bs-target="#panelConcar" type="button" role="tab" aria-controls="panelConcar" aria-selected="false" style="transition: all 0.2s;">
                                Formato CONCAR (Carga Plana)
                            </button>
                        </li>
                    </ul>

                    <!-- Estilos para pestañas activas -->
                    <style>
                        #asientosTabs .nav-link.active {
                            background-color: #1a73e8 !important;
                            color: #ffffff !important;
                            box-shadow: 0 4px 10px rgba(26,115,232,0.15);
                        }
                        #asientosTabs .nav-link:not(.active):hover {
                            background-color: #e9ecef !important;
                            color: #1a73e8 !important;
                        }
                    </style>

                    <div class="tab-content" id="asientosTabContent">
                        <!-- Panel 1: Formato Estándar -->
                        <div class="tab-pane fade show active" id="panelEstandar" role="tabpanel" aria-labelledby="tabEstandar">
                            {{-- Resumen Estándar --}}
                            <div id="seccionResumen" class="d-none">
                                <div class="row g-3 mb-4">
                                    <div class="col-md-3">
                                        <div class="stat-card bg-white">
                                            <div class="stat-value text-primary" id="statComprobantes">0</div>
                                            <div class="stat-label">Comprobantes</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="stat-card bg-white">
                                            <div class="stat-value text-warning" id="statGratuitas">0</div>
                                            <div class="stat-label">Con Gratuitas</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="stat-card bg-white">
                                            <div class="stat-value text-info" id="statDebe">0.00</div>
                                            <div class="stat-label">Total Debe</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="stat-card bg-white">
                                            <div class="stat-value text-success" id="statHaber">0.00</div>
                                            <div class="stat-label">Total Haber</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mb-3">
                                    <button type="button" id="btnExportarExcel" class="btn btn-premium btn-download">
                                        <i class="material-icons me-1">download</i> Exportar Excel
                                    </button>
                                </div>
                            </div>

                            {{-- Contenedor de asientos estándar --}}
                            <div id="contenedorAsientos" class="mt-3"></div>
                        </div>

                        <!-- Panel 2: Formato CONCAR -->
                        <div class="tab-pane fade" id="panelConcar" role="tabpanel" aria-labelledby="tabConcar">
                            <div id="seccionResumenConcar" class="d-none">
                                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center gap-2 mb-4" style="background-color: #f0f4fa; color: #0d47a1; border-radius: 12px;">
                                    <i class="material-icons">info</i>
                                    <div>
                                        <strong>Formato de Carga Masiva CONCAR:</strong> Esta vista muestra la estructura plana de importación de 35 columnas tal como se generará en el archivo de Excel.
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mb-3">
                                    <button type="button" id="btnExportarExcelConcar" class="btn btn-premium btn-download">
                                        <i class="material-icons me-1">download</i> Exportar Excel (CONCAR)
                                    </button>
                                </div>

                                <div class="table-responsive rounded-3 border" style="max-height: 500px; overflow-y: auto; background-color: #ffffff; border-color: #e2e8f0 !important;">
                                    <table class="table table-hover table-striped mb-0 text-nowrap" style="font-size: 11px;">
                                        <thead class="sticky-top bg-light" style="z-index: 1;">
                                            <tr style="background-color: #f1f5f9; color: #475569; border-bottom: 2px solid #cbd5e1;">
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Campo</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Sub Diario</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Comprobante</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Fecha Comp.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Moneda</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Glosa Gral.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">T. Cambio</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Tipo Conversión</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Flag Conv.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Fecha TC</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Cuenta</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Anexo</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">C. Costo</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">D/H</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Imp. Original</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Imp. Dólares</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Imp. Soles</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Tipo Doc.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Nº Doc.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Fec. Emisión</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Fec. Vence</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Cód. Trib.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Glosa Det.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Anexo Aux.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Med. Pago</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Doc. Ref. Tipo</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Doc. Ref. Nro.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Doc. Ref. Fecha</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Nro. Reg. Inm.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Área Geog.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Detrac. Tipo</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Detrac. Nro.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Detrac. Fecha</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Clasif. Op.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">TC Esp.</th>
                                                <th class="px-3 py-2 fw-bold text-uppercase" style="font-size: 9px;">Tasa IGV</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contenedorAsientosConcar">
                                            <!-- Se llena dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="sinDatosConcar" class="text-center py-5 text-secondary fs-14">
                                <i class="ri-information-line fs-24 mb-2 d-block"></i>
                                Seleccione el rango de fechas y haga clic en <strong>Generar</strong>.
                            </div>
                        </div>
                    </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var baseUrl = "{{ url('/') }}";
</script>
<script src="{{ asset('js/app/asientos_contables.js?v='.$version) }}"></script>
@endpush
