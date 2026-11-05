@extends('layouts.app')

@section('title', 'Registrar Manzana')

@section('page-title', 'Catálogo de Lotes')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Registrar Manzana</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/gestion-de-manzanas/'.$idopcion) }}">Manzanas</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Registrar
			</li>
		</ol>
	</div>
@endsection

@section('content')
	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
				<div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
					<i class="ri-grid-line fs-22"></i>
				</div>
				<div>
					<h4 class="mb-1">Nueva Manzana / Bloque</h4>
					<p class="text-muted fs-14 mb-0">Asigne la manzana al proyecto inmobiliario correspondiente.</p>
				</div>
			</div>

			@if(session('errorbd'))
				<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
					<i class="ri-error-warning-line me-2 fs-16"></i> {{ session('errorbd') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<form method="POST" action="{{ url('/agregar-manzana/'.$idopcion) }}" class="needs-validation" novalidate data-loading-msg="Guardando manzana...">
				@csrf
				<div class="row">
					<div class="col-lg-6 col-md-12 mb-4">
						<label class="form-label fw-semibold" for="proyecto_id">Proyecto Inmobiliario <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-building-line input-icon"></i>
							<select name="proyecto_id" id="proyecto_id" class="form-select ps-5" required>
								<option value="">-- Seleccione un Proyecto --</option>
								@foreach($proyectos as $p)
									<option value="{{ $p->id }}" {{ old('proyecto_id', $proyecto_id_selected) == $p->id ? 'selected' : '' }}>
										{{ $p->nombre }} ({{ $p->distrito }})
									</option>
								@endforeach
							</select>
							<div class="invalid-feedback">Seleccione el proyecto.</div>
						</div>
						@error('proyecto_id')
							<span class="text-danger d-block mt-1 fs-12">{{ $message }}</span>
						@enderror
					</div>

					<div class="col-lg-4 col-md-8 mb-4">
						<label class="form-label fw-semibold" for="nombre">Nombre de Manzana <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-community-line input-icon"></i>
							<input type="text" class="form-control ps-5 text-uppercase" name="nombre" id="nombre" value="{{ old('nombre') }}" 
								   placeholder="Ej: Mz. A" required>
							<div class="invalid-feedback">Ingrese el nombre de la manzana.</div>
						</div>
						@error('nombre')
							<span class="text-danger d-block mt-1 fs-12">{{ $message }}</span>
						@enderror
					</div>

					<div class="col-lg-2 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="orden">N° Orden</label>
						<div class="input-icon-wrapper">
							<i class="ri-sort-asc input-icon"></i>
							<input type="number" min="1" class="form-control ps-5" name="orden" id="orden" value="{{ old('orden', 1) }}">
						</div>
					</div>

					<div class="col-12 mb-4">
						<label class="form-label fw-semibold" for="descripcion">Descripción / Referencia</label>
						<div class="input-icon-wrapper">
							<i class="ri-information-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" 
								   placeholder="Ej: Frente a parque principal, primera etapa">
						</div>
					</div>

					<div class="col-12 d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
						<a href="{{ url('/gestion-de-manzanas/'.$idopcion) }}" class="btn btn-outline-secondary py-2 px-4 fw-medium rounded-3">
							Cancelar
						</a>
						<button type="submit" class="btn btn-primary py-2 px-4 fw-medium rounded-3 d-flex align-items-center gap-2">
							<i class="ri-check-line fs-18"></i>
							<span>Registrar Manzana</span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('js/app/manzanas.js?v='.$version) }}"></script>
@endpush
