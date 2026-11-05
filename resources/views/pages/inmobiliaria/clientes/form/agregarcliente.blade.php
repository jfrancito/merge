@extends('layouts.app')

@section('title', 'Registrar Cliente')

@section('page-title', 'Gestión Comercial')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Registrar Cliente</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/gestion-de-clientes/'.$idopcion) }}">Clientes</a>
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
					<i class="ri-user-add-line fs-22"></i>
				</div>
				<div>
					<h4 class="mb-1">Registrar Nuevo Cliente / Comprador</h4>
					<p class="text-muted fs-14 mb-0">Ingrese los datos personales del titular y la información de su cónyuge para minutas y contratos.</p>
				</div>
			</div>

			@if(session('errorbd'))
				<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
					<i class="ri-error-warning-line me-2 fs-16"></i> {{ session('errorbd') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<form method="POST" action="{{ url('/agregar-cliente/'.$idopcion) }}" class="needs-validation" novalidate data-loading-msg="Guardando cliente...">
				@csrf
				<div class="row">
					<!-- DATOS PERSONALES -->
					<div class="col-12 mb-2">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-user-line text-primary"></i> 1. Datos del Titular
						</h5>
					</div>

					<div class="col-lg-3 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="tipo_documento">Tipo de Documento <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-id-card-line input-icon"></i>
							<select name="tipo_documento" id="tipo_documento" class="form-select ps-5" required>
								<option value="DNI" {{ old('tipo_documento') == 'DNI' ? 'selected' : '' }}>DNI</option>
								<option value="RUC" {{ old('tipo_documento') == 'RUC' ? 'selected' : '' }}>RUC</option>
								<option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Carnet Extranjería</option>
								<option value="PASAPORTE" {{ old('tipo_documento') == 'PASAPORTE' ? 'selected' : '' }}>Pasaporte</option>
							</select>
						</div>
					</div>

					<div class="col-lg-3 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="numero_documento">N° de Documento <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-article-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="numero_documento" id="numero_documento" value="{{ old('numero_documento') }}" 
								   placeholder="Ej: 47852145" required>
							<div class="invalid-feedback">Ingrese el número de documento.</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="nombre_razon_social">Nombres / Razón Social <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-user-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="nombre_razon_social" id="nombre_razon_social" value="{{ old('nombre_razon_social') }}" 
								   placeholder="Ej: Juan Carlos" required>
							<div class="invalid-feedback">Ingrese los nombres.</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="apellidos">Apellidos Completos</label>
						<div class="input-icon-wrapper">
							<i class="ri-user-shared-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" 
								   placeholder="Ej: Mendoza Quispe">
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="telefono">Teléfono / WhatsApp</label>
						<div class="input-icon-wrapper">
							<i class="ri-phone-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="telefono" id="telefono" value="{{ old('telefono') }}" 
								   placeholder="Ej: 978123456">
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="email">Correo Electrónico</label>
						<div class="input-icon-wrapper">
							<i class="ri-mail-line input-icon"></i>
							<input type="email" class="form-control ps-5" name="email" id="email" value="{{ old('email') }}" 
								   placeholder="Ej: cliente@correo.com">
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="estado_civil">Estado Civil</label>
						<div class="input-icon-wrapper">
							<i class="ri-heart-line input-icon"></i>
							<select name="estado_civil" id="estado_civil" class="form-select ps-5">
								<option value="Soltero(a)" {{ old('estado_civil') == 'Soltero(a)' ? 'selected' : '' }}>Soltero(a)</option>
								<option value="Casado(a)" {{ old('estado_civil') == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
								<option value="Conviviente" {{ old('estado_civil') == 'Conviviente' ? 'selected' : '' }}>Conviviente</option>
								<option value="Divorciado(a)" {{ old('estado_civil') == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
								<option value="Viudo(a)" {{ old('estado_civil') == 'Viudo(a)' ? 'selected' : '' }}>Viudo(a)</option>
							</select>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="ocupacion">Ocupación / Profesión</label>
						<div class="input-icon-wrapper">
							<i class="ri-briefcase-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="ocupacion" id="ocupacion" value="{{ old('ocupacion') }}" 
								   placeholder="Ej: Ingeniero Civil, Comerciante">
						</div>
					</div>

					<div class="col-12 mb-4">
						<label class="form-label fw-semibold" for="direccion">Dirección Domiciliaria Actual</label>
						<div class="input-icon-wrapper">
							<i class="ri-map-pin-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="direccion" id="direccion" value="{{ old('direccion') }}" 
								   placeholder="Ej: Urb. Santa Victoria, Ca. Los Robles 345, Chiclayo">
						</div>
					</div>

					<!-- DATOS DEL CÓNYUGE O CO-PROPIETARIO -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-team-line text-primary"></i> 2. Cónyuge / Co-propietario (Firma de Minutas / Contratos)
						</h5>
					</div>

					<div class="col-lg-8 col-md-8 mb-4">
						<label class="form-label fw-semibold" for="conyuge_nombre">Nombres y Apellidos del Cónyuge</label>
						<div class="input-icon-wrapper">
							<i class="ri-user-heart-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="conyuge_nombre" id="conyuge_nombre" value="{{ old('conyuge_nombre') }}" 
								   placeholder="Ej: María Elena Torres Ramos">
						</div>
					</div>

					<div class="col-lg-4 col-md-4 mb-4">
						<label class="form-label fw-semibold" for="conyuge_dni">DNI / Documento del Cónyuge</label>
						<div class="input-icon-wrapper">
							<i class="ri-id-card-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="conyuge_dni" id="conyuge_dni" value="{{ old('conyuge_dni') }}" 
								   placeholder="Ej: 41235678" maxlength="15">
						</div>
					</div>

					<div class="col-12 mb-4">
						<label class="form-label fw-semibold" for="observaciones">Observaciones</label>
						<div class="input-icon-wrapper">
							<i class="ri-file-text-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="observaciones" id="observaciones" value="{{ old('observaciones') }}" 
								   placeholder="Notas adicionales...">
						</div>
					</div>

					<div class="col-12 d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
						<a href="{{ url('/gestion-de-clientes/'.$idopcion) }}" class="btn btn-outline-secondary py-2 px-4 fw-medium rounded-3">
							Cancelar
						</a>
						<button type="submit" class="btn btn-primary py-2 px-4 fw-medium rounded-3 d-flex align-items-center gap-2">
							<i class="ri-check-line fs-18"></i>
							<span>Guardar Cliente</span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
