@extends('layouts.app')

@section('title', 'Super Admin - Grupo Opciones')

@section('page-title', 'Gestión de Grupo Opciones')

@section('breadcrumb')
<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
    <h5 class="mb-0">Grupo Opciones</h5>

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
            Grupo Opciones
        </li>
    </ol>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
@endpush

@section('content')

@if(session('success'))
    <div class="alert alert-success border-0 mb-4">{{ session('success') }}</div>
@endif

<div class="card bg-white border-0 rounded-3 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <h3 class="mb-0">Lista de Grupo Opciones</h3>
            <div class="d-flex flex-wrap gap-3 align-items-center">
                <a href="{{ route('superadmin.grupo_opciones.agregar') }}" class="btn btn-outline-primary py-1 px-3 fs-14 fw-medium rounded-3 hover-bg">
                    <i class="ri-add-line align-middle me-1"></i> Agregar Grupo
                </a>
            </div>
        </div>

        <div class="default-table-area all-products">
            <div class="table-responsive">
                <table class="table align-middle" id="grupoTables">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Ícono</th>
                            <th scope="col">Orden</th>
                            <th scope="col">Activo</th>
                            <th scope="col" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listadatos as $item)
                            <tr>
                                <td class="text-secondary fw-semibold">{{ $item->id }}</td>
                                <td class="text-secondary">{{ $item->nombre }}</td>
                                <td class="text-secondary">
                                    <span class="material-symbols-outlined align-middle me-1">{{ $item->icono }}</span>
                                    <code>{{ $item->icono }}</code>
                                </td>
                                <td class="text-secondary">{{ $item->orden }}</td>
                                <td class="text-secondary">
                                    @if($item->activo == 1)
                                        <span class="badge bg-success">Sí</span>
                                    @else
                                        <span class="badge bg-danger">No</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('superadmin.grupo_opciones.editar', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="material-symbols-outlined fs-18">edit</i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof $ !== 'undefined' && typeof $.fn.DataTable !== 'undefined') {
        if ($("#grupoTables").length) {
            $('#grupoTables').DataTable({
                responsive: true,
                autoWidth: false,
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
            });
        }
    }
});
</script>
@endpush
