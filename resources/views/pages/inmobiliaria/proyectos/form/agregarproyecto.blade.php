@extends('layouts.app')

@section('title', 'Registrar Proyecto Inmobiliario')

@section('page-title', 'Catálogo de Lotes')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Registrar Proyecto</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/gestion-de-proyectos/'.$idopcion) }}">Proyectos</a>
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
					<i class="ri-building-2-line fs-22"></i>
				</div>
				<div>
					<h4 class="mb-1">Nuevo Proyecto / Urbanización / Sector</h4>
					<p class="text-muted fs-14 mb-0">Ingrese los datos generales, ubicación, moneda y planos del desarrollo inmobiliario.</p>
				</div>
			</div>

			@if(session('errorbd'))
				<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
					<i class="ri-error-warning-line me-2 fs-16"></i> {{ session('errorbd') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<form method="POST" action="{{ url('/agregar-proyecto/'.$idopcion) }}" class="needs-validation" novalidate data-loading-msg="Registrando proyecto..." enctype="multipart/form-data">
				@csrf
				<div class="row">
					<!-- DATOS PRINCIPALES -->
					<div class="col-12 mb-2">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-information-line text-primary"></i> 1. Información General
						</h5>
					</div>

					<div class="col-lg-6 col-md-12 mb-4">
						<label class="form-label fw-semibold" for="nombre">Nombre del Proyecto <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-building-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="nombre" id="nombre" value="{{ old('nombre') }}" 
								   placeholder="Ej: Residencial Los Álamos - Etapa 1" required>
							<div class="invalid-feedback">Por favor ingrese el nombre del proyecto.</div>
						</div>
						@error('nombre')
							<span class="text-danger d-block mt-1 fs-12">{{ $message }}</span>
						@enderror
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="moneda">Moneda Principal <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-money-dollar-circle-line input-icon"></i>
							<select name="moneda" id="moneda" class="form-select ps-5" required>
								<option value="PEN" {{ old('moneda') == 'PEN' ? 'selected' : '' }}>Soles (S/)</option>
								<option value="USD" {{ old('moneda') == 'USD' ? 'selected' : '' }}>Dólares ($)</option>
							</select>
							<div class="invalid-feedback">Seleccione la moneda.</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="precio_m2_referencial">Precio Base Sugerido x m²</label>
						<div class="input-icon-wrapper">
							<i class="ri-price-tag-3-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5" name="precio_m2_referencial" id="precio_m2_referencial" value="{{ old('precio_m2_referencial') }}" 
								   placeholder="Ej: 350.00">
						</div>
					</div>

					<div class="col-12 mb-4">
						<label class="form-label fw-semibold" for="descripcion">Descripción / Beneficios del Proyecto</label>
						<div class="input-icon-wrapper">
							<i class="ri-file-text-line input-icon" style="top: 20px;"></i>
							<textarea class="form-control ps-5" name="descripcion" id="descripcion" rows="2" 
									  placeholder="Ej: Proyecto campestre con pórtico de ingreso, áreas verdes, parques infantiles, servicios básicos habilitados...">{{ old('descripcion') }}</textarea>
						</div>
					</div>

					<!-- UBICACIÓN GEOGRÁFICA -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-map-pin-line text-primary"></i> 2. Ubicación Geográfica
						</h5>
					</div>

					<div class="col-lg-4 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="departamento">Departamento</label>
						<div class="input-icon-wrapper">
							<i class="ri-map-pin-2-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="departamento" id="departamento" value="{{ old('departamento', 'Lambayeque') }}" 
								   placeholder="Ej: Lambayeque">
						</div>
					</div>

					<div class="col-lg-4 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="provincia">Provincia</label>
						<div class="input-icon-wrapper">
							<i class="ri-map-pin-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="provincia" id="provincia" value="{{ old('provincia', 'Chiclayo') }}" 
								   placeholder="Ej: Chiclayo">
						</div>
					</div>

					<div class="col-lg-4 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="distrito">Distrito</label>
						<div class="input-icon-wrapper">
							<i class="ri-compass-3-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="distrito" id="distrito" value="{{ old('distrito', 'Pimentel') }}" 
								   placeholder="Ej: Pimentel">
						</div>
					</div>

					<div class="col-12 mb-4">
						<label class="form-label fw-semibold" for="direccion">Dirección / Referencia de Llegada</label>
						<div class="input-icon-wrapper">
							<i class="ri-road-map-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="direccion" id="direccion" value="{{ old('direccion') }}" 
								   placeholder="Ej: Km 8.5 Carretera Chiclayo - Pimentel, frente al Colegio Militar">
						</div>
					</div>

					<!-- MULTIMEDIA Y PLANOS -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-image-line text-primary"></i> 3. Foto de Portada y Plano General
						</h5>
					</div>

					<div class="col-lg-6 mb-4">
						<label class="form-label fw-semibold" for="foto">Foto de Portada / Render</label>
						<div class="input-icon-wrapper">
							<i class="ri-image-line input-icon"></i>
							<input type="file" class="form-control ps-5" name="foto" id="foto" accept="image/*">
						</div>
						<div class="small text-secondary mt-1">Formatos: JPG, PNG, WEBP (Máx. 3MB)</div>
						<div id="fotoPreview" class="mt-2" style="display: none;">
							<img id="fotoPreviewImg" src="#" alt="Vista previa foto" class="img-thumbnail rounded-3 p-1" style="max-height: 120px; object-fit: cover;">
						</div>
					</div>

					<div class="col-lg-6 mb-4">
						<label class="form-label fw-semibold" for="plano">Archivo de Plano General (Master Plan)</label>
						<div class="input-icon-wrapper">
							<i class="ri-file-pdf-line input-icon"></i>
							<input type="file" class="form-control ps-5" name="plano" id="plano" accept=".pdf,image/*">
						</div>
						<div class="small text-secondary mt-1">Formatos: PDF o Imagen de alta resolución (Máx. 10MB)</div>
					</div>

					<div class="col-12 d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
						<a href="{{ url('/gestion-de-proyectos/'.$idopcion) }}" class="btn btn-outline-secondary py-2 px-4 fw-medium rounded-3">
							Cancelar
						</a>
						<button type="submit" class="btn btn-primary py-2 px-4 fw-medium rounded-3 d-flex align-items-center gap-2">
							<i class="ri-check-line fs-18"></i>
							<span>Guardar Proyecto</span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('js/app/proyectos.js?v='.$version) }}"></script>
	<script>
		$('#moneda').on('change', function() {
			$('#moneda-symbol').text($(this).val() === 'USD' ? '$' : 'S/');
		});
	</script>
@endpush
