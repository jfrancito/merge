@extends('layouts.app')

@section('title', 'Gestión de Permisos')

@section('page-title', 'Gestión de Permisos')

@section('breadcrumb')
<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
    <h5 class="mb-0">Permisos</h5>

    <ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
        <li class="breadcrumb-item d-inline-block position-relative">
            <a href="{{ url('/') }}" class="d-inline-block position-relative">
                <i class="material-symbols-outlined">home</i>
                Inicio
            </a>
        </li>

        <li class="breadcrumb-item d-inline-block position-relative">
            Permisos
        </li>
    </ol>
</div>
@endsection

@push('styles')
<style>
	.menu-roles {
		max-height: 600px;
		overflow-y: auto;
		padding: 0;
		margin: 0;
		list-style: none;
	}
	.menu-roles li {
		border-bottom: 1px solid #e9ecef;
	}
	.menu-roles li:last-child {
		border-bottom: none;
	}
	.menu-roles li a {
		display: block;
		padding: 12px 16px;
		color: #64748b;
		text-decoration: none;
		transition: all 0.3s ease;
	}
	.menu-roles li a:hover {
		background-color: #f8f9fa;
		color: #605dff;
		padding-left: 20px;
	}
	.menu-roles li a.active {
		background-color: #605dff;
		color: #fff;
		border-left: 4px solid #4b49d8;
	}
	.listadoopciones {
		min-height: 400px;
	}
	.card-roles {
		box-shadow: 0 0 10px rgba(0,0,0,0.05);
	}
</style>
@endpush

@section('content')
	<input type="hidden" id="token" value="{{ csrf_token() }}">
	<div class="card bg-white border-0 rounded-3 mb-4">
		<div class="card-body p-4">
			
			<!-- Header -->
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
				<div>
					<h3 class="mb-1">Permisos por Rol</h3>
					<p class="text-secondary mb-0">Seleccione un rol para gestionar sus permisos</p>
				</div>
			</div>

			<!-- Contenido Principal -->
			<div class="row">
				
				<!-- Panel de Roles (Izquierda) -->
				<div class="col-12 col-lg-3 mb-4 mb-lg-0">
					<div class="card card-roles bg-white border rounded-3">
						<div class="card-header bg-light border-bottom">
							<h5 class="mb-0 fw-semibold">
								<i class="ri-shield-user-line me-2"></i>
								Roles
							</h5>
						</div>
						<div class="card-body p-0">
							<ul class="menu-roles">
								@foreach($listaroles as $item)
									<li>
										<a href="#" 
										   id="{{ Hashids::encode(substr($item->id, -8)) }}" 
										   class="selectrol"
										   data-rol-nombre="{{ $item->nombre }}">
											<i class="ri-user-settings-line me-2"></i>
											{{ $item->nombre }}
										</a>
									</li>
								@endforeach  
							</ul>
						</div>
					</div>
				</div>

				<!-- Panel de Opciones/Permisos (Derecha) -->
				<div class="col-12 col-lg-9">
					<div class="card card-roles bg-white border rounded-3">
						<div class="card-header bg-light border-bottom">
							<h5 class="mb-0 fw-semibold">
								<i class="ri-key-2-line me-2"></i>
								Permisos del Rol
							</h5>
						</div>
						<div class="card-body listadoopciones">
							<div class="text-center py-5">
								<i class="ri-arrow-left-line fs-1 text-secondary mb-3"></i>
								<p class="text-secondary mb-0">Seleccione un rol de la lista para ver y gestionar sus permisos</p>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/user/user.js?v='.$version) }}" type="text/javascript"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
	
	// Inicializar tooltips de Bootstrap 5
	const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
	tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl);
	});

});
</script>
@endpush