@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    .report-card { border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; border: none; overflow: hidden; }
    .filter-section { background: #f8f9fa; border-radius: 12px; border: 1px solid #e9ecef; }
    .form-control-custom { border: 2px solid #e9ecef !important; border-radius: 8px !important; padding: 10px 15px !important; background-color: #ffffff !important; }
    .form-control-custom:focus { border-color: #2dce89 !important; box-shadow: 0 0 0 3px rgba(45,206,137,0.1) !important; }
    .btn-premium { border-radius: 10px !important; font-weight: 600 !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; }
    .btn-search { background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%) !important; color: white !important; }
    .btn-excel { background: linear-gradient(135deg, #11cdef 0%, #1171ef 100%) !important; color: white !important; }
    .customer-avatar { width: 40px; height: 40px; background: #e9ecef; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-11 mx-auto">
            <div class="card report-card">
                <div class="card-header p-4 bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-success shadow-success text-center border-radius-md me-3">
                            <i class="material-icons opacity-10">group</i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-dark font-weight-bolder">Análisis de Mejores Clientes</h4>
                            <p class="mb-0 text-sm text-secondary">Identifica a tus compradores más valiosos por monto acumulado</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="filter-section p-3 mb-4">
                        <form id="formClientes">
                            @csrf
                            <div class="row align-items-end g-3">
                                <div class="col-md-4">
                                    <label class="text-xs font-weight-bold text-uppercase ps-1">Desde</label>
                                    <input type="date" name="fecha_desde" class="form-control form-control-custom" value="{{ date('Y-m-01') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="text-xs font-weight-bold text-uppercase ps-1">Hasta</label>
                                    <input type="date" name="fecha_hasta" class="form-control form-control-custom" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <button type="button" id="btnConsultar" class="btn btn-premium btn-search w-100 mb-0">
                                        <i class="material-icons me-2">analytics</i> Analizar
                                    </button>
                                    <button type="button" id="btnExportar" class="btn btn-premium btn-excel mb-0">
                                        <i class="material-icons">download</i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cliente</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nro Ventas</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Monto Invertido</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progreso</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyClientes">
                                <tr><td colspan="4" class="text-center py-5 text-secondary text-sm">Realice un análisis para ver resultados</td></tr>
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
        Swal.fire({ title: 'Procesando datos...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        $.ajax({
            url: baseUrl + '/reporte-clientes/data',
            method: 'POST',
            data: $('#formClientes').serialize(),
            success: function(res) {
                Swal.close();
                if (res.success) {
                    let html = '';
                    const maxMonto = res.data.length > 0 ? res.data[0].total_monto : 1;
                    res.data.forEach((item) => {
                        const percent = (item.total_monto / maxMonto) * 100;
                        html += `
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="customer-avatar me-3"><i class="material-icons text-success">person</i></div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">${item.nombre}</h6>
                                            <p class="text-xs text-secondary mb-0">${item.numero_documento}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center text-sm font-weight-bold">${item.total_ventas}</td>
                                <td class="text-center text-sm font-weight-bold text-success">S/ ${parseFloat(item.total_monto).toLocaleString('es-PE', {minimumFractionDigits:2})}</td>
                                <td class="align-middle text-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="progress w-75" style="height: 6px;">
                                            <div class="progress-bar bg-gradient-success" role="progressbar" style="width: ${percent}%"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>`;
                    });
                    $('#tbodyClientes').html(html || '<tr><td colspan="4" class="text-center">Sin resultados</td></tr>');
                }
            }
        });
    });

    $('#btnExportar').on('click', function() {
        Swal.fire({ title: 'Generando Excel...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        $.ajax({
            url: baseUrl + '/reporte-clientes/excel',
            method: 'POST',
            data: $('#formClientes').serialize(),
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
