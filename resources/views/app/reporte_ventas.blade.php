@extends('layouts.app')

@section('content')
<!-- Material Icons & Google Fonts -->
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
        outline: none !important;
    }
    .btn-premium {
        border-radius: 10px !important;
        padding: 12px 25px !important;
        font-weight: 600 !important;
        text-transform: none !important;
        letter-spacing: 0.5px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .btn-download { background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%) !important; color: white !important; }
    .btn-search { background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%) !important; color: white !important; }
    .report-title { color: #0d47a1; font-weight: 800; font-size: 1.4rem; letter-spacing: -0.5px; }
    .report-subtitle { color: #525f7f; font-weight: 400; font-size: 0.9rem; }
    .card-header-gradient { background: linear-gradient(87deg, #ffffff 0, #f8f9fa 100%) !important; border-bottom: 1px solid #e9ecef !important; }
    .legend-box { border-radius: 10px; padding: 14px 18px; background: #fff; border: 1px solid #e9ecef; }
    .legend-item { display: inline-flex; align-items: center; gap: 7px; margin: 4px 8px 4px 0; font-size: 0.82rem; }
    .legend-dot { width: 14px; height: 14px; border-radius: 3px; display: inline-block; flex-shrink: 0; }
    .col-badge { display: inline-block; background: #1A3A5C; color: #fff; border-radius: 4px; font-size: 0.75rem; padding: 1px 7px; font-family: monospace; font-weight: 600; }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card report-card">
                <div class="card-header card-header-gradient p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center border-radius-md me-3">
                            <i class="material-icons opacity-10">assessment</i>
                        </div>
                        <div>
                            <h4 class="mb-0 report-title">Registro de Ventas e Ingresos</h4>
                            <p class="mb-0 report-subtitle">Formato SUNAT — Libros Electrónicos</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="filter-section p-4">
                        <h6 class="text-dark font-weight-bold mb-4"><i class="material-icons align-middle me-2 text-primary">tune</i> Configuración de Reporte</h6>

                        <form id="formReporteVentas">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold text-xs text-uppercase">Fecha de Inicio</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i class="material-icons text-sm">calendar_today</i></span>
                                        <input type="date" name="fecha_desde" class="form-control form-control-custom" value="{{ date('Y-m-01') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold text-xs text-uppercase">Fecha Final</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i class="material-icons text-sm">event</i></span>
                                        <input type="date" name="fecha_hasta" class="form-control form-control-custom" value="{{ date('Y-m-t') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-12 text-center d-flex flex-column flex-md-row justify-content-center gap-3">
                                    <button type="button" id="btnGenerarExcel" class="btn btn-premium btn-download shadow-lg">
                                        <i class="material-icons me-2">download</i> Registro SUNAT 14.1 (Por Comprobante)
                                    </button>
                                    <button type="button" id="btnGenerarExcelDetallado" class="btn btn-premium btn-search shadow-lg">
                                        <i class="material-icons me-2">table_view</i> Reporte Detallado (Por Producto / Ítem)
                                    </button>
                                </div>
                                <div class="col-12 text-center">
                                    <p class="text-xs text-secondary mt-3 mb-0">
                                        <i class="material-icons text-xs me-1">verified_user</i>
                                        Elija <b>Por Comprobante</b> para formato SUNAT 14.1 o <b>Por Producto / Ítem</b> para ver el desglose por línea de detalle.
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Leyenda de columnas --}}
                    <div class="legend-box mt-4">
                        <h6 class="fw-bold text-dark mb-3"><i class="material-icons align-middle me-1 text-primary" style="font-size:18px">info</i> Columnas del Reporte</h6>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <ul class="list-unstyled mb-0 small">
                                    <li class="mb-1"><span class="col-badge">A</span> USUARIO — quien creó el CP</li>
                                    <li class="mb-1"><span class="col-badge">B</span> ESTADO CP — estado SUNAT del CP</li>
                                    <li class="mb-1"><span class="col-badge">C</span> FECHA DE EMISIÓN</li>
                                    <li class="mb-1"><span class="col-badge">D</span> FECHA DE VENCIMIENTO — (última cuota al crédito)</li>
                                    <li class="mb-1"><span class="col-badge">E</span> TIPO — Factura / Boleta / NC / ND</li>
                                    <li class="mb-1"><span class="col-badge">F</span> SERIE</li>
                                    <li class="mb-1"><span class="col-badge">G</span> CORRELATIVO</li>
                                    <li class="mb-1"><span class="col-badge">H</span> DOC CU — Comprobante Afectado (NC/ND) con tipo doc</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="list-unstyled mb-0 small">
                                    <li class="mb-1"><span class="col-badge">I</span> GUIA RELACIONADA — solo guía de remisión vinculada</li>
                                    <li class="mb-1"><span class="col-badge">J</span> ESTADO DEL CP — estado SUNAT</li>
                                    <li class="mb-1"><span class="col-badge">K</span> MONEDA — PEN / USD</li>
                                    <li class="mb-1"><span class="col-badge">L</span> TIPO DE CAMBIO</li>
                                    <li class="mb-1"><span class="col-badge">M</span> FORMA DE PAGO — Contado / Crédito</li>
                                    <li class="mb-1"><span class="col-badge">N</span> OBSERVACIÓN — notas internas del formulario</li>
                                    <li class="mb-1"><span class="col-badge">O</span> TIPO DOC CLI — RUC / DNI / CE</li>
                                    <li class="mb-1"><span class="col-badge">P</span> NRO CLI — número de documento cliente</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="list-unstyled mb-0 small">
                                    <li class="mb-1"><span class="col-badge">Q</span> CLIENTE — razón social</li>
                                    <li class="mb-1"><span class="col-badge">R</span> GRAVADO</li>
                                    <li class="mb-1"><span class="col-badge">S</span> INAFECTO</li>
                                    <li class="mb-1"><span class="col-badge">T</span> EXONERADO</li>
                                    <li class="mb-1"><span class="col-badge">U</span> IGV</li>
                                    <li class="mb-1"><span class="col-badge">V</span> TOTAL</li>
                                    <li class="mb-1"><span class="col-badge">W</span> TG — Transferencia Gratuita (SI (100%) / PARCIAL / NO)</li>
                                    <li class="mb-1"><span class="col-badge">X</span> IMPORTE REFERENCIAL TG — monto gratuito valorizado</li>
                                </ul>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="fw-semibold small text-muted me-2">Color en Excel:</span>
                            <span class="legend-item"><span class="legend-dot" style="background:#FCE4EC;border:1px solid #ccc;"></span> Anulado</span>
                            <span class="legend-item"><span class="legend-dot" style="background:#FFF3E0;border:1px solid #ccc;"></span> Rechazado</span>
                            <span class="legend-item"><span class="legend-dot" style="background:#E8F5E9;border:1px solid #ccc;"></span> TG 100% Gratuita</span>
                            <span class="legend-item"><span class="legend-dot" style="background:#E0F7FA;border:1px solid #ccc;"></span> TG Parcial / Bonificación</span>
                            <span class="legend-item"><span class="legend-dot" style="background:#FFFDE7;border:1px solid #ccc;"></span> Fila de Totales</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
$(document).ready(function() {
    const baseUrl = "{{ url('/') }}";

    $('#btnGenerarExcel').on('click', function() {
        const $btn = $(this);
        const $form = $('#formReporteVentas');

        const fechaDesde = $form.find('input[name="fecha_desde"]').val();
        const fechaHasta = $form.find('input[name="fecha_hasta"]').val();

        if (!fechaDesde || !fechaHasta) {
            Swal.fire({ icon: 'warning', title: 'Faltan fechas', text: 'Por favor seleccione el periodo.' });
            return;
        }

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Procesando...');
        
        Swal.fire({
            title: 'Preparando Excel',
            text: 'Estamos consolidando los datos contables...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: baseUrl + '/reporte-ventas/generar',
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                Swal.close();
                if (response.success) {
                    // Método de descarga robusto
                    const byteCharacters = atob(response.file);
                    const byteNumbers = new Array(byteCharacters.length);
                    for (let i = 0; i < byteCharacters.length; i++) {
                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                    }
                    const byteArray = new Uint8Array(byteNumbers);
                    const blob = new Blob([byteArray], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
                    
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = response.filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    Swal.fire({ icon: 'success', title: '¡Listo!', text: 'El reporte se ha descargado.', timer: 2000, showConfirmButton: false });
                } else {
                    Swal.fire({ icon: 'info', title: 'Aviso', text: response.message });
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo generar el reporte.' });
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="material-icons me-2">download</i> Registro SUNAT 14.1 (Por Comprobante)');
            }
        });
    });

    $('#btnGenerarExcelDetallado').on('click', function() {
        const $btn = $(this);
        const $form = $('#formReporteVentas');

        const fechaDesde = $form.find('input[name="fecha_desde"]').val();
        const fechaHasta = $form.find('input[name="fecha_hasta"]').val();

        if (!fechaDesde || !fechaHasta) {
            Swal.fire({ icon: 'warning', title: 'Faltan fechas', text: 'Por favor seleccione el periodo.' });
            return;
        }

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Procesando...');
        
        Swal.fire({
            title: 'Preparando Excel Detallado',
            text: 'Consolidando detalles de productos e ítems...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: baseUrl + '/reporte-ventas-detallado/generar',
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                Swal.close();
                if (response.success) {
                    const byteCharacters = atob(response.file);
                    const byteNumbers = new Array(byteCharacters.length);
                    for (let i = 0; i < byteCharacters.length; i++) {
                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                    }
                    const byteArray = new Uint8Array(byteNumbers);
                    const blob = new Blob([byteArray], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
                    
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = response.filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    Swal.fire({ icon: 'success', title: '¡Listo!', text: 'El reporte detallado se ha descargado.', timer: 2000, showConfirmButton: false });
                } else {
                    Swal.fire({ icon: 'info', title: 'Aviso', text: response.message });
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo generar el reporte detallado.' });
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="material-icons me-2">table_view</i> Reporte Detallado (Por Producto / Ítem)');
            }
        });
    });
});
</script>
@endpush
