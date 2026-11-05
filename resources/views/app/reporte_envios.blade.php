@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    .report-card { border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; border: none; }
    .filter-section { background: #f8f9fa; border-radius: 12px; border: 1px solid #e9ecef; }
    .form-control-custom { border: 2px solid #e9ecef !important; border-radius: 8px !important; padding: 10px 15px !important; }
    .form-control-custom:focus { border-color: #344767 !important; box-shadow: 0 0 0 3px rgba(52,71,103,0.1) !important; }
    .btn-premium { border-radius: 10px !important; font-weight: 600 !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; }
    .btn-search { background: linear-gradient(135deg, #344767 0%, #191919 100%) !important; color: white !important; }
    .btn-excel { background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%) !important; color: white !important; }
    .stat-card { border-radius: 12px; border: 1px solid #e9ecef; transition: all 0.3s ease; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card report-card">
                <div class="card-header p-4 bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-dark shadow-dark text-center border-radius-md me-3">
                            <i class="material-icons opacity-10">security</i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-dark font-weight-bolder">Monitor de Control SUNAT</h4>
                            <p class="mb-0 text-sm text-secondary">Verifique la integridad y el estado de sus envíos electrónicos</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="filter-section p-3 mb-4">
                        <form id="formEnvios">
                            @csrf
                            <div class="row align-items-end g-3">
                                <div class="col-md-4">
                                    <label class="text-xs font-weight-bold text-uppercase ps-1">Desde</label>
                                    <input type="date" name="fecha_desde" class="form-control form-control-custom" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="text-xs font-weight-bold text-uppercase ps-1">Hasta</label>
                                    <input type="date" name="fecha_hasta" class="form-control form-control-custom" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <button type="button" id="btnConsultar" class="btn btn-premium btn-search w-100 mb-0">
                                        <i class="material-icons me-2">sync_alt</i> Monitorear
                                    </button>
                                    <button type="button" id="btnExportar" class="btn btn-premium btn-excel mb-0">
                                        <i class="material-icons">download</i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="row mb-4" id="panelResumen" style="display:none;">
                        <div class="col-md-3">
                            <div class="stat-card p-3 text-center">
                                <span class="text-xs font-weight-bold text-success text-uppercase">Aceptados</span>
                                <h3 class="mb-0 font-weight-bolder" id="cntAceptado">0</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card p-3 text-center">
                                <span class="text-xs font-weight-bold text-warning text-uppercase">Pendientes</span>
                                <h3 class="mb-0 font-weight-bolder" id="cntPendiente">0</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card p-3 text-center">
                                <span class="text-xs font-weight-bold text-danger text-uppercase">Con Error</span>
                                <h3 class="mb-0 font-weight-bolder" id="cntError">0</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card p-3 text-center">
                                <span class="text-xs font-weight-bold text-dark text-uppercase">Rechazados</span>
                                <h3 class="mb-0 font-weight-bolder" id="cntRechazado">0</h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Documento</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cliente</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Respuesta SUNAT</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyEnvios">
                                <tr><td colspan="4" class="text-center py-5 text-secondary text-sm">Use los filtros para iniciar el monitoreo</td></tr>
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
        Swal.fire({ title: 'Sincronizando...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        $.ajax({
            url: baseUrl + '/reporte-envios/data',
            method: 'POST',
            data: $('#formEnvios').serialize(),
            success: function(res) {
                Swal.close();
                if (res.success) {
                    $('#panelResumen').fadeIn();
                    let aceptados = 0, pendientes = 0, errores = 0, rechazados = 0;
                    res.resumen.forEach(r => {
                        if (r.estado_sunat === 'ACEPTADO') aceptados = r.total;
                        else if (r.estado_sunat === 'PENDIENTE') pendientes = r.total;
                        else if (r.estado_sunat === 'RECHAZADO') rechazados = r.total;
                        else errores += parseInt(r.total);
                    });
                    $('#cntAceptado').text(aceptados); $('#cntPendiente').text(pendientes); $('#cntError').text(errores); $('#cntRechazado').text(rechazados);

                    let html = '';
                    res.listado.forEach(v => {
                        let badge = `<span class="badge" style="background-color: #2dce89; color: white;">ACEPTADO</span>`;
                        if(v.estado_sunat != 'ACEPTADO') {
                            let color = v.estado_sunat == 'PENDIENTE' ? '#fb6340' : (v.estado_sunat == 'RECHAZADO' ? '#344767' : '#f5365c');
                            badge = `<span class="badge" style="background-color: ${color}; color: white;">${v.estado_sunat || 'ERROR'}</span>`;
                        }

                        html += `
                            <tr>
                                <td><h6 class="mb-0 text-sm">${v.serie}-${v.correlativo}</h6><p class="text-xs text-secondary mb-0">S/ ${parseFloat(v.total).toFixed(2)}</p></td>
                                <td><p class="text-xs font-weight-bold mb-0">${v.cliente}</p></td>
                                <td class="text-center">${badge}</td>
                                <td><p class="text-xs text-secondary mb-0 text-truncate" style="max-width: 300px;" title="${v.mensaje_sunat}">${v.mensaje_sunat || '-'}</p></td>
                            </tr>`;
                    });
                    $('#tbodyEnvios').html(html || '<tr><td colspan="4" class="text-center">Sin datos</td></tr>');
                }
            }
        });
    });

    $('#btnExportar').on('click', function() {
        Swal.fire({ title: 'Generando Excel...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        $.ajax({
            url: baseUrl + '/reporte-envios/excel',
            method: 'POST',
            data: $('#formEnvios').serialize(),
            success: function(res) {
                Swal.close();
                if (res.success) downloadFile(res);
                else Swal.fire('Error', res.message, 'error');
            }
        });
    });
});
</script>
@endpush
