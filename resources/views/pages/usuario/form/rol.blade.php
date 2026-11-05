@extends('layouts.app')
@section('title', 'Registrar Rol')
@section('page-title', 'Registrar de Rol')
@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Roles</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Roles
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Agregar Rol
			</li>

		</ol>
	</div>
@endsection
@push('styles')
	<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
@endpush

@section('content')

	<div class="card bg-white border-0 rounded-3 mb-4">
		<div class="card-body p-4">
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
				<h3 class="mb-0">Agregar </h3>
			</div>

			<form action="{{ url('/agregar-rol/' . $idopcion) }}" id='frmregistrarroles' method="POST"
				class="needs-validation frmcargando" novalidate>
				@csrf
				<div class="row">

					<div class="col-md-4">
						<label class="label text-secondary">Rol <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-shield-keyhole-line input-icon"></i>
							<input name="nombre" type="text" id='nombre' value="" class="form-control ps-5 h-55" placeholder="Rol" required>
							<div class="invalid-feedback">
								Por favor ingrese Rol.
							</div>
						</div>
					</div>
					<div class="form-group mb-4"></div>
					<div class="d-flex gap-2">
						<button type="submit" id="btnGuardar"
							class="btn btn-primary bg-primary bg-opacity-10 text-primary border-0 fw-semibold py-2 px-4">
							<i class="ri-save-3-line me-2"></i>
							Guardar
						</button>

						<a href="{{url('/gestion-de-roles/' . $idopcion) }}"
							class="btn btn-danger bg-danger bg-opacity-10 text-danger border-0 fw-semibold py-2 px-4">
							<i class="ri-close-line me-2"></i>
							Cancelar
						</a>
					</div>

				</div>
			</form>

		</div>
	</div>

@endsection

@push('scripts')
	<script>

	</script>
@endpush