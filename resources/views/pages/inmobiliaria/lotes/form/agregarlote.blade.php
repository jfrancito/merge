@extends('layouts.app')

@section('title', 'Registrar Lote')

@section('page-title', 'Catálogo de Lotes')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Registrar Lote</h5>

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
					<i class="ri-crop-line fs-22"></i>
				</div>
				<div>
					<h4 class="mb-1">Registrar Nuevo Lote</h4>
					<p class="text-muted fs-14 mb-0">Complete la información física, medidas perimétricas y precio del lote.</p>
				</div>
			</div>

			@if(session('errorbd'))
				<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
					<i class="ri-error-warning-line me-2 fs-16"></i> {{ session('errorbd') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<form method="POST" action="{{ url('/agregar-lote/'.$idopcion) }}" class="needs-validation" novalidate data-loading-msg="Guardando lote...">
				@csrf
				<div class="row">
					<!-- UBICACIÓN FÍSICA -->
					<div class="col-12 mb-2">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-map-pin-line text-primary"></i> 1. Ubicación y N° de Lote
						</h5>
					</div>

					<div class="col-lg-4 col-md-6 mb-4">
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

					<div class="col-lg-4 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="manzana_id">Manzana / Sector <span class="text-danger">*</span></label>
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

					<div class="col-lg-4 col-md-12 mb-4">
						<label class="form-label fw-semibold" for="numero_lote">Número / Código de Lote <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-hashtag input-icon"></i>
							<input type="text" class="form-control ps-5 fw-bold" name="numero_lote" id="numero_lote" value="{{ old('numero_lote') }}" 
								   placeholder="Ej: 01 o Lote 12" required>
							<div class="invalid-feedback">Ingrese el número de lote.</div>
						</div>
					</div>

					<!-- MEDIDAS Y LINDEROS -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-ruler-line text-primary"></i> 2. Área y Medidas Perimétricas (Metros Lineales)
						</h5>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="area_m2">Área Total (m²) <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-ruler-2-line input-icon"></i>
							<input type="number" step="0.01" min="1" class="form-control ps-5 fw-bold fs-15 text-primary" name="area_m2" id="area_m2" value="{{ old('area_m2', 120.00) }}" required>
							<div class="invalid-feedback">Ingrese el área en m².</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="medida_frente">Frente (ml)</label>
						<div class="input-icon-wrapper">
							<i class="ri-arrow-left-right-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5" name="medida_frente" id="medida_frente" value="{{ old('medida_frente', 6.00) }}" placeholder="Ej: 6.00">
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="medida_fondo">Fondo (ml)</label>
						<div class="input-icon-wrapper">
							<i class="ri-arrow-up-down-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5" name="medida_fondo" id="medida_fondo" value="{{ old('medida_fondo', 6.00) }}" placeholder="Ej: 6.00">
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="medida_derecha">Laterales (Der / Izq ml)</label>
						<div class="row g-2">
							<div class="col-6">
								<div class="input-icon-wrapper">
									<i class="ri-arrow-right-s-line input-icon"></i>
									<input type="number" step="0.01" min="0" class="form-control ps-5" name="medida_derecha" id="medida_derecha" value="{{ old('medida_derecha', 20.00) }}" placeholder="Der">
								</div>
							</div>
							<div class="col-6">
								<div class="input-icon-wrapper">
									<i class="ri-arrow-left-s-line input-icon"></i>
									<input type="number" step="0.01" min="0" class="form-control ps-5" name="medida_izquierda" id="medida_izquierda" value="{{ old('medida_izquierda', 20.00) }}" placeholder="Izq">
								</div>
							</div>
						</div>
					</div>

					<!-- PRECIOS Y ESTADO COMERCIAL -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-money-dollar-circle-line text-primary"></i> 3. Precios y Estado Comercial
						</h5>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="precio_m2">Precio x m²</label>
						<div class="input-icon-wrapper">
							<i class="ri-price-tag-3-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5" name="precio_m2" id="precio_m2" value="{{ old('precio_m2', 350.00) }}" placeholder="Ej: 350.00">
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="precio_total">Precio Total de Venta <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-money-dollar-circle-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5 fw-bold fs-15 text-success" name="precio_total" id="precio_total" value="{{ old('precio_total', 42000.00) }}" required>
							<div class="invalid-feedback">Ingrese el precio total.</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="tipo_lote">Tipo / Ubicación Especial</label>
						<div class="input-icon-wrapper">
							<i class="ri-map-2-line input-icon"></i>
							<select name="tipo_lote" id="tipo_lote" class="form-select ps-5">
								<option value="estandar" {{ old('tipo_lote') == 'estandar' ? 'selected' : '' }}>Estándar (Calle Interna)</option>
								<option value="esquina" {{ old('tipo_lote') == 'esquina' ? 'selected' : '' }}>Esquina</option>
								<option value="parque" {{ old('tipo_lote') == 'parque' ? 'selected' : '' }}>Frente a Parque</option>
								<option value="avenida" {{ old('tipo_lote') == 'avenida' ? 'selected' : '' }}>Avenida Principal</option>
							</select>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="estado">Estado Inicial</label>
						<div class="input-icon-wrapper">
							<i class="ri-checkbox-circle-line input-icon"></i>
							<select name="estado" id="estado" class="form-select ps-5" required>
								<option value="disponible" {{ old('estado') == 'disponible' ? 'selected' : '' }}>🟢 Disponible</option>
								<option value="reservado" {{ old('estado') == 'reservado' ? 'selected' : '' }}>🟡 Reservado</option>
								<option value="vendido" {{ old('estado') == 'vendido' ? 'selected' : '' }}>🔴 Vendido</option>
								<option value="bloqueado" {{ old('estado') == 'bloqueado' ? 'selected' : '' }}>⚫ Bloqueado</option>
							</select>
						</div>
					</div>

					<div class="col-12 mb-4">
						<label class="form-label fw-semibold" for="observaciones">Observaciones / Detalles Adicionales</label>
						<div class="input-icon-wrapper">
							<i class="ri-file-text-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="observaciones" id="observaciones" value="{{ old('observaciones') }}" 
								   placeholder="Ej: Lote plano con punto de agua y luz al frente">
						</div>
					</div>

					<div class="col-12 d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
						<a href="{{ url('/gestion-de-lotes/'.$idopcion) }}" class="btn btn-outline-secondary py-2 px-4 fw-medium rounded-3">
							Cancelar
						</a>
						<button type="submit" class="btn btn-primary py-2 px-4 fw-medium rounded-3 d-flex align-items-center gap-2">
							<i class="ri-check-line fs-18"></i>
							<span>Guardar Lote</span>
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
