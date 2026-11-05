@extends('layouts.app')

@section('title', 'Asignar Series')

@section('page-title', 'Asignar Series a ' . $usuario->name)

@section('breadcrumb')
<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
    <h5 class="mb-0">Series por Usuario</h5>

    <ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
        <li class="breadcrumb-item d-inline-block position-relative">
            <a href="{{ url('/') }}" class="d-inline-block position-relative">
                <i class="material-symbols-outlined">home</i>
                Inicio
            </a>
        </li>
        <li class="breadcrumb-item d-inline-block position-relative">
            <a href="{{ url('/gestion-de-usuarios/' . $idopcion) }}" class="d-inline-block position-relative">
                Usuarios
            </a>
        </li>
        <li class="breadcrumb-item d-inline-block position-relative">
            Asignar Series
        </li>
    </ol>
</div>
@endsection

@section('content')
<div class="card bg-white border-0 rounded-3 mb-4">
    <div class="card-body p-4">
        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h3 class="mb-1">Series Autorizadas</h3>
                <p class="text-secondary mb-0">Marque las series que el usuario <strong>{{ $usuario->name }}</strong> podrá utilizar para emitir documentos.</p>
            </div>
            <a href="{{ url('/gestion-de-usuarios/' . $idopcion) }}" class="btn btn-outline-secondary py-1 px-4 fs-14 fw-medium rounded-3 mt-md-0">
                <i class="ri-arrow-left-line"></i> Volver
            </a>
        </div>

        <div class="default-table-area">
            <div class="table-responsive" style="border-radius: 12px; overflow: hidden; box-shadow: 0 0 20px rgba(0,0,0,0.02);">
                <table class="table table-hover align-middle mb-0" style="border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f7f9fc;">
                            <th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-4">Tipo Documento</th>
                            <th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-4">Serie</th>
                            <th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-4">Sede</th>
                            <th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-4 text-center">Asignado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($series as $serie)
                            <tr class="transition-all" style="transition: all 0.2s ease;">
                                <td class="py-3 px-4 border-bottom text-secondary fs-14" style="border-color: #f0f4fa;">
                                    @switch($serie->tipo_comprobante)
                                        @case('01') <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 rounded-pill fs-11 fw-medium">FACTURA</span> @break
                                        @case('03') <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fs-11 fw-medium">BOLETA</span> @break
                                        @case('07') <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1 rounded-pill fs-11 fw-medium">NOTA CRÉDITO</span> @break
                                        @case('08') <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 rounded-pill fs-11 fw-medium">NOTA DÉBITO</span> @break
                                        @case('09') <span class="badge bg-dark bg-opacity-10 text-dark border border-dark border-opacity-25 px-2 py-1 rounded-pill fs-11 fw-medium">GUÍA REMISIÓN</span> @break
                                        @default <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 rounded-pill fs-11 fw-medium">{{ $serie->tipo_comprobante }}</span>
                                    @endswitch
                                </td>
                                <td class="py-3 px-4 border-bottom fw-bold text-secondary fs-14" style="border-color: #f0f4fa;">
                                    {{ $serie->serie }}
                                </td>
                                <td class="py-3 px-4 border-bottom text-secondary fs-13" style="border-color: #f0f4fa;">
                                    {{ $serie->sede->nombre ?? 'N/A' }}
                                </td>
                                <td class="py-3 px-4 border-bottom text-center" style="border-color: #f0f4fa;">
                                    <div class="form-check form-switch d-inline-block">
                                        <input class="form-check-input chk-serie" type="checkbox" 
                                               id="serie_{{ $serie->id }}"
                                               data-usuario="{{ $usuario->id }}"
                                               data-serie="{{ $serie->id }}"
                                               autocomplete="off"
                                               {{ in_array($serie->id, $seriesAsignadas) ? 'checked' : '' }}>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if($series->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center py-4 text-secondary">
                                    No hay series configuradas para esta empresa.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<input type="hidden" id="js_version" value="{{ $version }}">
@endsection

@push('scripts')
<script src="{{ asset('js/app/usuario_series.js?v='.$version) }}"></script>
@endpush
