@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    .report-card { border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; border: none; }
    .filter-section { background: #f8f9fa; border-radius: 12px; border: 1px solid #e9ecef; }
    .form-control-custom { border: 2px solid #e9ecef !important; border-radius: 8px !important; padding: 10px 15px !important; }
    .form-control-custom:focus { border-color: #1a73e8 !important; box-shadow: 0 0 0 3px rgba(26,115,232,0.1) !important; }
    .btn-premium { border-radius: 10px !important; font-weight: 600 !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; }
    .btn-search { background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%) !important; color: white !important; }
    .btn-excel { background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%) !important; color: white !important; }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card report-card">
                <div class="card-header p-4 bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center border-radius-md me-3">
                            <i class="material-icons opacity-10">local_shipping</i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-dark font-weight-bolder">Control de Guías de Remisión</h4>
                            <p class="mb-0 text-sm text-secondary">Monitoreo logístico y estados de validación GRE 2.1</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="filter-section p-3 mb-4">
                        <form id="formGuias">
                            @csrf
                            <div class="row align-items-end g-3">
                                <div class="col-md-3">
                                    <label class="text-xs font-weight-bold text-uppercase ps-1">Fecha Emisión Desde</label>
                                    <input type="date" name="fecha_desde" class="form-control form-control-custom" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="text-xs font-weight-bold text-uppercase ps-1">Fecha Emisión Hasta</label>
                                    <input type="date" name="fecha_hasta" class="form-control form-control-custom" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-6 d-flex flex-wrap gap-2">
                                    <button type="button" id="btnConsultar" class="btn btn-premium btn-search mb-0 flex-grow-1" style="min-width: 120px;">
                                        <i class="material-icons me-1">search</i> Consultar
                                    </button>
                                    <button type="button" id="btnExportar" class="btn btn-premium btn-excel mb-0" title="Descargar Resumen por Guía">
                                        <i class="material-icons me-1">download</i> Por Guía
                                    </button>
                                    <button type="button" id="btnExportarDetallado" class="btn btn-premium mb-0 text-white" style="background: linear-gradient(135deg, #1A3A5C 0%, #2A5298 100%) !important;" title="Descargar Reporte Detallado por Producto / Ítem">
                                        <i class="material-icons me-1">table_view</i> Detallado (Por Ítem)
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Guía</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Receptor / Destinatario</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha Traslado</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado SUNAT</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Placa</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyGuias">
                                <tr><td colspan="5" class="text-center py-5 text-secondary text-sm">Use los filtros para buscar guías</td></tr>
                            </tbody>
                        </table>
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

    function downloadFile(response) {
        const byteCharacters = atob(response.file);
        const byteNumbers = new Array(byteCharacters.length);
        for (let i = 0; i < byteCharacters.length; i++) byteNumbers[i] = byteCharacters.charCodeAt(i);
        const byteArray = new Uint8Array(byteNumbers);
        const blob = new Blob([byteArray], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = response.filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    $('#btnConsultar').on('click', function() {
        Swal.fire({ title: 'Buscando Guías...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        $.ajax({
            url: baseUrl + '/reporte-guias/data',
            method: 'POST',
            data: $('#formGuias').serialize(),
            success: function(res) {
                Swal.close();
                if (res.success) {
                    let html = '';
                    res.data.forEach(g => {
                        let badge = `<span class="badge" style="background-color: #2dce89; color: white;">ACEPTADO</span>`;
                        if(g.estado_sunat != 'ACEPTADO') {
                            let color = g.estado_sunat == 'PENDIENTE' ? '#fb6340' : '#f5365c';
                            badge = `<span class="badge" style="background-color: ${color}; color: white;">${g.estado_sunat || 'SIN ESTADO'}</span>`;
                        }

                        html += `
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">${g.serie}-${g.correlativo}</h6>
                                            <p class="text-xs text-secondary mb-0">Emisión: ${g.fecha_emision}</p>
                                        </div>
                                    </div>
                                </td>
                                <td><p class="text-xs font-weight-bold mb-0">${g.razon_social_receptor}</p></td>
                                <td class="text-center"><span class="text-secondary text-xs font-weight-bold">${g.fecha_traslado}</span></td>
                                <td class="text-center">${badge}</td>
                                <td class="text-center"><span class="badge" style="background-color: #e9ecef; color: #344767; border: 1px solid #dee2e6; font-weight: bold;">${g.placa_vehiculo || '-'}</span></td>
                            </tr>`;
                    });
                    $('#tbodyGuias').html(html || '<tr><td colspan="5" class="text-center">No se encontraron guías</td></tr>');
                }
            }
        });
    });

    $('#btnExportar').on('click', function() {
        Swal.fire({ title: 'Generando Reporte...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        $.ajax({
            url: baseUrl + '/reporte-guias/excel',
            method: 'POST',
            data: $('#formGuias').serialize(),
            success: function(res) {
                Swal.close();
                if (res.success) downloadFile(res);
                else Swal.fire('Error', res.message, 'error');
            },
            error: function() {
                Swal.close();
                Swal.fire('Error', 'Ocurrió un error al generar el reporte.', 'error');
            }
        });
    });

    $('#btnExportarDetallado').on('click', function() {
        Swal.fire({ title: 'Generando Reporte Detallado...', text: 'Procesando ítems y logística...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        $.ajax({
            url: baseUrl + '/reporte-guias/excel-detallado',
            method: 'POST',
            data: $('#formGuias').serialize(),
            success: function(res) {
                Swal.close();
                if (res.success) downloadFile(res);
                else Swal.fire('Error', res.message, 'error');
            },
            error: function() {
                Swal.close();
                Swal.fire('Error', 'Ocurrió un error al generar el reporte detallado.', 'error');
            }
        });
    });
});
</script>
@endpush
