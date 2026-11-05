@extends('layouts.app')

@section('title', 'Modificar Inmobiliaria / Empresa')

@section('page-title', 'Gestión de Empresas')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Modificar Inmobiliaria</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/gestion-de-empresas/'.$idopcion) }}">Empresas</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Modificar
			</li>
		</ol>
	</div>
@endsection

@section('content')
	@php
		$config = is_array($empresa->configuracion_simple) ? $empresa->configuracion_simple : json_decode($empresa->configuracion_simple ?? '{}', true);
		$telefono = $config['telefono'] ?? null;
		$email = $config['email'] ?? null;
		$repLegal = $config['representante_legal'] ?? null;
		$repDni = $config['representante_dni'] ?? null;
		$ctaSoles = $config['cuenta_bancaria_soles'] ?? null;
		$ctaDolares = $config['cuenta_bancaria_dolares'] ?? null;
	@endphp

	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
				<div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
					<i class="ri-edit-2-line fs-22"></i>
				</div>
				<div>
					<h4 class="mb-1">Modificar Inmobiliaria: <span class="text-primary">{{ $empresa->nombre }}</span></h4>
					<p class="text-muted fs-14 mb-0">Actualice los datos comerciales, de contacto, cuentas bancarias y estado.</p>
				</div>
			</div>

			@if(session('errorbd'))
				<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
					<i class="ri-error-warning-line me-2 fs-16"></i> {{ session('errorbd') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<form method="POST" action="{{ url('/modificar-empresa/'.$idopcion.'/'.$idempresa) }}" class="needs-validation" novalidate data-loading-msg="Guardando cambios..." enctype="multipart/form-data">
				@csrf
				<div class="row">
					<!-- DATOS PRINCIPALES -->
					<div class="col-12 mb-2">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-information-line text-primary"></i> 1. Datos Principales
						</h5>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="ruc">RUC <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-article-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="ruc" id="ruc" value="{{ old('ruc', $empresa->ruc) }}" 
								   placeholder="Ej: 20601234567" maxlength="11" required>
							<div class="invalid-feedback">Por favor ingrese el RUC.</div>
						</div>
						@error('ruc')
							<span class="text-danger d-block mt-1 fs-12">{{ $message }}</span>
						@enderror
					</div>

					<div class="col-lg-5 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="nombre">Razón Social / Nombre Comercial <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-building-line input-icon"></i>
							<input type="text" class="form-control ps-5 text-uppercase" name="nombre" id="nombre" value="{{ old('nombre', $empresa->nombre) }}" 
								   placeholder="Ej: INMOBILIARIA & CONSTRUCTORA LOTEAME S.A.C." required>
							<div class="invalid-feedback">Por favor ingrese la Razón Social.</div>
						</div>
						@error('nombre')
							<span class="text-danger d-block mt-1 fs-12">{{ $message }}</span>
						@enderror
					</div>

					<div class="col-lg-4 col-md-12 mb-4">
						<label class="form-label fw-semibold" for="logo">Logo de la Empresa</label>
						<div class="input-icon-wrapper">
							<i class="ri-image-line input-icon"></i>
							<input type="file" class="form-control ps-5" name="logo" id="logo" accept="image/*">
						</div>
						<div class="small text-secondary mt-1">
							@if($empresa->logo)
								<a href="{{ asset('storage/' . $empresa->logo) }}" target="_blank" class="text-primary fw-medium text-decoration-none">
									<i class="ri-image-line align-middle"></i> Ver logo actual
								</a>. 
							@endif
							Formatos: PNG, JPG, WEBP (Máx. 2MB)
						</div>
						<div id="logoPreview" class="mt-2" style="display: none;">
							<img id="logoPreviewImg" src="#" alt="Vista previa logo" class="img-thumbnail rounded-3 p-1" style="max-height: 50px; background: #f8fafc;">
						</div>
						@error('logo')
							<span class="text-danger d-block mt-1 fs-12">{{ $message }}</span>
						@enderror
					</div>

					<div class="col-lg-12 mb-4">
						<label class="form-label fw-semibold" for="direccion_fiscal">Dirección Fiscal / Oficina Principal</label>
						<div class="input-icon-wrapper">
							<i class="ri-map-pin-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="direccion_fiscal" id="direccion_fiscal" value="{{ old('direccion_fiscal', $empresa->direccion_fiscal) }}" 
								   placeholder="Ej: Av. Balta 1234 - Of. 501, Chiclayo, Lambayeque">
						</div>
						@error('direccion_fiscal')
							<span class="text-danger d-block mt-1 fs-12">{{ $message }}</span>
						@enderror
					</div>

					<!-- DATOS DE CONTACTO Y REPRESENTANTE -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-contacts-line text-primary"></i> 2. Contacto y Representación Legal
						</h5>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="telefono">Teléfono / Celular de Contacto</label>
						<div class="input-icon-wrapper">
							<i class="ri-phone-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="telefono" id="telefono" value="{{ old('telefono', $telefono) }}" 
								   placeholder="Ej: 974123456">
						</div>
						@error('telefono')
							<span class="text-danger d-block mt-1 fs-12">{{ $message }}</span>
						@enderror
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="email">Correo Electrónico de Contacto</label>
						<div class="input-icon-wrapper">
							<i class="ri-mail-line input-icon"></i>
							<input type="email" class="form-control ps-5" name="email" id="email" value="{{ old('email', $email) }}" 
								   placeholder="Ej: contacto@loteame.pe">
						</div>
						@error('email')
							<span class="text-danger d-block mt-1 fs-12">{{ $message }}</span>
						@enderror
					</div>

					<div class="col-lg-4 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="representante_legal">Representante Legal</label>
						<div class="input-icon-wrapper">
							<i class="ri-user-star-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="representante_legal" id="representante_legal" value="{{ old('representante_legal', $repLegal) }}" 
								   placeholder="Ej: Juan Pérez Morales">
						</div>
						@error('representante_legal')
							<span class="text-danger d-block mt-1 fs-12">{{ $message }}</span>
						@enderror
					</div>

					<div class="col-lg-2 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="representante_dni">DNI Representante</label>
						<div class="input-icon-wrapper">
							<i class="ri-id-card-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="representante_dni" id="representante_dni" value="{{ old('representante_dni', $repDni) }}" 
								   placeholder="Ej: 45678912" maxlength="8">
						</div>
						@error('representante_dni')
							<span class="text-danger d-block mt-1 fs-12">{{ $message }}</span>
						@enderror
					</div>

					<!-- CUENTAS BANCARIAS RECAUDADORAS -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-bank-card-line text-primary"></i> 3. Cuentas Bancarias de Recaudación (Lotes y Reservas)
						</h5>
					</div>

					<div class="col-lg-6 mb-4">
						<label class="form-label fw-semibold" for="cuenta_bancaria_soles">Cuenta Bancaria en Soles (S/)</label>
						<div class="input-icon-wrapper">
							<i class="ri-bank-card-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="cuenta_bancaria_soles" id="cuenta_bancaria_soles" value="{{ old('cuenta_bancaria_soles', $ctaSoles) }}" 
								   placeholder="Ej: BCP Cta Cte: 305-1234567-0-12 / CCI: 002-305...">
						</div>
					</div>

					<div class="col-lg-6 mb-4">
						<label class="form-label fw-semibold" for="cuenta_bancaria_dolares">Cuenta Bancaria en Dólares ($)</label>
						<div class="input-icon-wrapper">
							<i class="ri-bank-card-2-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="cuenta_bancaria_dolares" id="cuenta_bancaria_dolares" value="{{ old('cuenta_bancaria_dolares', $ctaDolares) }}" 
								   placeholder="Ej: BBVA Cta: 0011-0234-0100012345 / CCI: 011-234...">
						</div>
					</div>

					<!-- ESTADO DE LA EMPRESA -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-settings-4-line text-primary"></i> 4. Estado de la Cuenta
						</h5>
					</div>

					<div class="col-lg-4 mb-4">
						<label class="form-label fw-semibold" for="activo">Estado</label>
						<div class="input-icon-wrapper">
							<i class="ri-checkbox-circle-line input-icon"></i>
							<select name="activo" id="activo" class="form-select ps-5" required>
								<option value="1" {{ old('activo', $empresa->activo) == 1 ? 'selected' : '' }}>Activa</option>
								<option value="0" {{ old('activo', $empresa->activo) == 0 ? 'selected' : '' }}>Inactiva (Bloqueada)</option>
							</select>
						</div>
					</div>

					<div class="col-12 d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
						<a href="{{ url('/gestion-de-empresas/'.$idopcion) }}" class="btn btn-outline-secondary py-2 px-4 fw-medium rounded-3">
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

@push('scripts')
	<script src="{{ asset('js/app/empresas.js?v='.$version) }}"></script>
@endpush

