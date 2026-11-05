@extends('layouts.app')

@section('title', 'Generación Masiva de Lotes')

@section('page-title', 'Catálogo de Lotes')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Generación Masiva de Lotes</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/gestion-de-lotes/'.$idopcion) }}">Lotes</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Generación Masiva
			</li>
		</ol>
	</div>
@endsection

@section('content')
	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
				<div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
					<i class="ri-stack-line fs-22"></i>
				</div>
				<div>
					<h4 class="mb-1">Generador Masivo de Lotes</h4>
					<p class="text-muted fs-14 mb-0">Cree de forma automática un rango secuencial de lotes para una manzana específica.</p>
				</div>
			</div>

			@if(session('errorbd'))
				<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
					<i class="ri-error-warning-line me-2 fs-16"></i> {{ session('errorbd') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<form method="POST" action="{{ url('/creacion-masiva-lotes/'.$idopcion) }}" class="needs-validation" novalidate data-loading-msg="Generando lotes en lote...">
				@csrf
				<div class="row">
					<!-- PROYECTO Y MANZANA -->
					<div class="col-12 mb-2">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-map-pin-line text-primary"></i> 1. Selección de Proyecto y Manzana
						</h5>
					</div>

					<div class="col-lg-6 col-md-6 mb-4">
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
					</div>

					<div class="col-lg-6 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="manzana_id">Manzana / Sector Destino <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-community-line input-icon"></i>
							<select name="manzana_id" id="manzana_id" class="form-select ps-5" required>
								<option value="">-- Primero elija un Proyecto --</option>
								@if(!empty($proyecto_id_selected))
									@php
										$mzs = \App\Models\Manzana::where('proyecto_id', $proyecto_id_selected)->where('activo', 1)->orderBy('orden', 'asc')->get();
									@endphp
									@foreach($mzs as $mz)
										<option value="{{ $mz->id }}" {{ old('manzana_id', $manzana_id_selected) == $mz->id ? 'selected' : '' }}>
											{{ $mz->nombre }}
										</option>
									@endforeach
								@endif
							</select>
							<div class="invalid-feedback">Seleccione la manzana.</div>
						</div>
					</div>

					<!-- RANGO DE NÚMEROS DE LOTE -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-hashtag text-primary"></i> 2. Rango Secuencial de Lotes
						</h5>
					</div>

					<div class="col-lg-6 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="desde_numero">Desde Lote N° <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-sort-asc input-icon"></i>
							<input type="number" min="1" max="500" class="form-control ps-5 fw-bold" name="desde_numero" id="desde_numero" value="{{ old('desde_numero', 1) }}" required>
						</div>
						<div class="small text-muted mt-1">Ej: 1 (se creará como '01')</div>
					</div>

					<div class="col-lg-6 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="hasta_numero">Hasta Lote N° <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-sort-desc input-icon"></i>
							<input type="number" min="1" max="500" class="form-control ps-5 fw-bold" name="hasta_numero" id="hasta_numero" value="{{ old('hasta_numero', 20) }}" required>
						</div>
						<div class="small text-muted mt-1">Ej: 20 (se creará hasta '20')</div>
					</div>

					<!-- PARÁMETROS BASE PARA TODOS LOS LOTES DEL RANGO -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-ruler-line text-primary"></i> 3. Dimensiones y Precio Base para el Rango
						</h5>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="area_m2">Área Base (m²) <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-ruler-2-line input-icon"></i>
							<input type="number" step="0.01" min="1" class="form-control ps-5 fw-bold fs-15 text-primary" name="area_m2" id="area_m2" value="{{ old('area_m2', 120.00) }}" required>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="precio_m2">Precio x m² <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-price-tag-3-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5 fw-bold" name="precio_m2" id="precio_m2" value="{{ old('precio_m2', 350.00) }}" required>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="medida_frente">Frente (ml)</label>
						<div class="input-icon-wrapper">
							<i class="ri-arrow-left-right-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5" name="medida_frente" id="medida_frente" value="{{ old('medida_frente', 6.00) }}">
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="medida_derecha">Fondo / Laterales (ml)</label>
						<div class="input-icon-wrapper">
							<i class="ri-arrow-up-down-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5" name="medida_derecha" id="medida_derecha" value="{{ old('medida_derecha', 20.00) }}">
						</div>
					</div>

					<div class="col-12">
						<div class="alert alert-info border-0 rounded-3 p-3">
							<i class="ri-information-line me-1 fs-16 align-middle"></i>
							<strong>Nota:</strong> Los lotes generados se crearán en estado <strong>Disponible</strong> con tipo <strong>Estándar</strong>. Posteriormente podrás editar individualmente cualquier lote que sea de esquina o frente a parque.
						</div>
					</div>

					<div class="col-12 d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
						<a href="{{ url('/gestion-de-lotes/'.$idopcion) }}" class="btn btn-outline-secondary py-2 px-4 fw-medium rounded-3">
							Cancelar
						</a>
						<button type="submit" class="btn btn-primary py-2 px-4 fw-medium rounded-3 d-flex align-items-center gap-2">
							<i class="ri-magic-line fs-18"></i>
							<span>Generar Lotes en Masa</span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('js/app/lotes.js?v='.$version) }}"></script>
@endpush
