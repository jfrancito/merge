@extends('layouts.app')

@section('title', $item ? 'Editar Opción' : 'Agregar Opción')

@section('page-title', $item ? 'Editar Opción' : 'Agregar Opción')

@section('breadcrumb')
<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
    <h5 class="mb-0">{{ $item ? 'Editar Opción' : 'Agregar Opción' }}</h5>

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
            <a href="{{ route('superadmin.opciones') }}">Opciones del Menú</a>
        </li>
        <li class="breadcrumb-item d-inline-block position-relative">
            {{ $item ? 'Editar' : 'Agregar' }}
        </li>
    </ol>
</div>
@endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger border-0 mb-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card bg-white border-0 rounded-3 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <h3 class="mb-0">{{ $item ? 'Modificar' : 'Agregar' }} Opción de Menú</h3>
        </div>
        
        <form action="{{ $item ? route('superadmin.opciones.actualizar', $item->id) : route('superadmin.opciones.guardar') }}" 
              method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="nombre" class="form-label fw-semibold text-secondary">Nombre de Opción</label>
                    <div class="input-icon-wrapper">
                        <i class="ri-file-list-line input-icon"></i>
                        <input type="text" 
                               class="form-control h-55 ps-5" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre', $item->nombre ?? '') }}" 
                               placeholder="Escriba el Nombre de la Opción (ej: Boletas Masivas)"
                               required>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="descripcion" class="form-label fw-semibold text-secondary">Descripción</label>
                    <div class="input-icon-wrapper">
                        <i class="ri-information-line input-icon"></i>
                        <input type="text" 
                               class="form-control h-55 ps-5" 
                               id="descripcion" 
                               name="descripcion" 
                               value="{{ old('descripcion', $item->descripcion ?? '') }}" 
                               placeholder="Escriba la descripción o tooltip de la opción"
                               required>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="pagina" class="form-label fw-semibold text-secondary">Página / URL Slug</label>
                    <div class="input-icon-wrapper">
                        <i class="ri-links-line input-icon"></i>
                        <input type="text" 
                               class="form-control h-55 ps-5" 
                               id="pagina" 
                               name="pagina" 
                               value="{{ old('pagina', $item->pagina ?? '') }}" 
                               placeholder="Escriba la url relativa de la página (ej: gestion-de-ventas)"
                               required>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="grupoopcion_id" class="form-label fw-semibold text-secondary">Grupo Opción</label>
                    <div class="input-icon-wrapper">
                        <i class="ri-folder-line input-icon"></i>
                        <select class="form-select form-control h-55 ps-5" id="grupoopcion_id" name="grupoopcion_id" required>
                            <option value="">Seleccione un grupo...</option>
                            @foreach($grupos as $g)
                                <option value="{{ $g->id }}" {{ old('grupoopcion_id', $item->grupoopcion_id ?? '') == $g->id ? 'selected' : '' }}>
                                    {{ $g->nombre }} ({{ $g->id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="orden" class="form-label fw-semibold text-secondary">Orden</label>
                    <div class="input-icon-wrapper">
                        <i class="ri-sort-asc input-icon"></i>
                        <input type="number" 
                               class="form-control h-55 ps-5" 
                               id="orden" 
                               name="orden" 
                               value="{{ old('orden', $item->orden ?? '1') }}" 
                               placeholder="Escriba el Orden de aparición"
                               required>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="activo" class="form-label fw-semibold text-secondary">Estado</label>
                    <div class="input-icon-wrapper">
                        <i class="ri-checkbox-circle-line input-icon"></i>
                        <select class="form-select form-control h-55 ps-5" id="activo" name="activo" required>
                            <option value="1" {{ old('activo', $item->activo ?? '1') == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('activo', $item->activo ?? '0') == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3 pt-3 border-top">
                <button type="submit" 
                        class="btn btn-primary fw-semibold py-2 px-4 rounded-3">
                    <i class="ri-save-3-line me-2"></i>
                    Guardar
                </button>

                <a href="{{ route('superadmin.opciones') }}" 
                   class="btn btn-outline-danger fw-semibold py-2 px-4 rounded-3">
                    <i class="ri-close-line me-2"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
