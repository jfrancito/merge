@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    .report-card { border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; border: none; overflow: hidden; }
    .filter-section { background: #f8f9fa; border-radius: 12px; border: 1px solid #e9ecef; }
    .form-control-custom { 
        border: 2px solid #e9ecef !important; 
        border-radius: 8px !important; 
        padding: 10px 15px !important;
        background-color: #ffffff !important;
    }
    .form-control-custom:focus { border-color: #1a73e8 !important; box-shadow: 0 0 0 3px rgba(26,115,232,0.1) !important; }
    .btn-premium { border-radius: 10px !important; font-weight: 600 !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; }
    .btn-search { background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%) !important; color: white !important; }
    .btn-excel { background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%) !important; color: white !important; }
    .rank-badge { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-11 mx-auto">
            <div class="card report-card">
                <div class="card-header p-4 bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape bg-gradient-info shadow-info text-center border-radius-md me-3">
                            <i class="material-icons opacity-10">leaderboard</i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-dark font-weight-bolder">Ranking de Productos</h4>
                            <p class="mb-0 text-sm text-secondary">Analiza tus artículos más vendidos por volumen y monto</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="filter-section p-3 mb-4">
                        <form id="formRanking">
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
                                        <i class="material-icons me-2">search</i> Consultar
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Producto</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cantidad</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Ingresos</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyRanking">
                                <tr><td colspan="4" class="text-center py-5 text-secondary text-sm">Realice una consulta para ver resultados</td></tr>
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
        Swal.fire({ title: 'Analizando...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        $.ajax({
            url: baseUrl + '/reporte-ranking/data',
            method: 'POST',
            data: $('#formRanking').serialize(),
            success: function(res) {
                Swal.close();
                if (res.success) {
                    let html = '';
                    res.data.forEach((item, index) => {
                        let color = '#6c757d';
                        if(index==0) color='#fbcf33'; if(index==1) color='#adb5bd'; if(index==2) color='#cd7f32';
                        html += `
                            <tr>
                                <td class="ps-3"><div class="rank-badge" style="background-color:${color}">${index+1}</div></td>
                                <td><h6 class="mb-0 text-sm">${item.descripcion}</h6><p class="text-xs text-secondary mb-0">${item.codigo}</p></td>
                                <td class="text-center text-sm font-weight-bold">${parseFloat(item.total_cantidad).toFixed(2)}</td>
                                <td class="text-center text-sm font-weight-bold">S/ ${parseFloat(item.total_monto).toLocaleString('es-PE', {minimumFractionDigits:2})}</td>
                            </tr>`;
                    });
                    $('#tbodyRanking').html(html || '<tr><td colspan="4" class="text-center">Sin datos</td></tr>');
                }
            }
        });
    });

    $('#btnExportar').on('click', function() {
        Swal.fire({ title: 'Exportando...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        $.ajax({
            url: baseUrl + '/reporte-ranking/excel',
            method: 'POST',
            data: $('#formRanking').serialize(),
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
