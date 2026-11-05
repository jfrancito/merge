@extends('layouts.app')

@section('title', 'Modificar Asesor')

@section('page-title', 'Gestión Comercial')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Modificar Asesor</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/gestion-de-vendedores/'.$idopcion) }}">Asesores</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Modificar
			</li>
		</ol>
	</div>
@endsection

@section('content')
	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
				<div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
					<i class="ri-edit-2-line fs-22"></i>
				</div>
				<div>
					<h4 class="mb-1">Modificar Asesor: <span class="text-primary">{{ $vendedor->nombre_completo }}</span></h4>
					<p class="text-muted fs-14 mb-0">Actualice los datos y esquemas de comisiones del asesor comercial.</p>
				</div>
			</div>

			@if(session('errorbd'))
				<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
					<i class="ri-error-warning-line me-2 fs-16"></i> {{ session('errorbd') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<form method="POST" action="{{ url('/modificar-vendedor/'.$idopcion.'/'.$idvendedor) }}" class="needs-validation" novalidate data-loading-msg="Guardando cambios...">
				@csrf
				<div class="row">
					<div class="col-lg-3 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="tipo_documento">Tipo Documento <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-id-card-line input-icon"></i>
							<select name="tipo_documento" id="tipo_documento" class="form-select ps-5" required>
								<option value="DNI" {{ old('tipo_documento', $vendedor->tipo_documento) == 'DNI' ? 'selected' : '' }}>DNI</option>
								<option value="CE" {{ old('tipo_documento', $vendedor->tipo_documento) == 'CE' ? 'selected' : '' }}>Carnet Extranjería</option>
								<option value="PASAPORTE" {{ old('tipo_documento', $vendedor->tipo_documento) == 'PASAPORTE' ? 'selected' : '' }}>Pasaporte</option>
							</select>
						</div>
					</div>

					<div class="col-lg-3 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="numero_documento">N° Documento <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-article-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="numero_documento" id="numero_documento" value="{{ old('numero_documento', $vendedor->numero_documento) }}" required>
						</div>
					</div>

					<div class="col-lg-3 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="nombre">Nombres <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-user-star-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="nombre" id="nombre" value="{{ old('nombre', $vendedor->nombre) }}" required>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="apellidos">Apellidos Completos</label>
						<div class="input-icon-wrapper">
							<i class="ri-user-shared-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="apellidos" id="apellidos" value="{{ old('apellidos', $vendedor->apellidos) }}">
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="telefono">Teléfono / WhatsApp</label>
						<div class="input-icon-wrapper">
							<i class="ri-phone-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="telefono" id="telefono" value="{{ old('telefono', $vendedor->telefono) }}">
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="email">Correo Electrónico</label>
						<div class="input-icon-wrapper">
							<i class="ri-mail-line input-icon"></i>
							<input type="email" class="form-control ps-5" name="email" id="email" value="{{ old('email', $vendedor->email) }}">
						</div>
					</div>

					<div class="col-lg-2 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="porcentaje_comision">Comisión (%)</label>
						<div class="input-icon-wrapper">
							<i class="ri-percent-line input-icon"></i>
							<input type="number" step="0.01" min="0" max="100" class="form-control ps-5" name="porcentaje_comision" id="porcentaje_comision" value="{{ old('porcentaje_comision', $vendedor->porcentaje_comision) }}">
						</div>
					</div>

					<div class="col-lg-2 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="comision_fija">Comisión Fija (S/)</label>
						<div class="input-icon-wrapper">
							<i class="ri-money-dollar-circle-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5" name="comision_fija" id="comision_fija" value="{{ old('comision_fija', $vendedor->comision_fija) }}">
						</div>
					</div>

					<div class="col-lg-2 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="activo">Estado</label>
						<div class="input-icon-wrapper">
							<i class="ri-checkbox-circle-line input-icon"></i>
							<select name="activo" id="activo" class="form-select ps-5" required>
								<option value="1" {{ old('activo', $vendedor->activo) == 1 ? 'selected' : '' }}>Activo</option>
								<option value="0" {{ old('activo', $vendedor->activo) == 0 ? 'selected' : '' }}>Inactivo</option>
							</select>
						</div>
					</div>

					<div class="col-12 d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
						<a href="{{ url('/gestion-de-vendedores/'.$idopcion) }}" class="btn btn-outline-secondary py-2 px-4 fw-medium rounded-3">
							Cancelar
						</a>
						<button type="submit" class="btn btn-primary py-2 px-4 fw-medium rounded-3 d-flex align-items-center gap-2">
							<i class="ri-save-line fs-18"></i>
							<span>Guardar Cambios</span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
