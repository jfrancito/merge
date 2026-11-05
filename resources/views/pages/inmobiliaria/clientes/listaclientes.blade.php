@extends('layouts.app')

@section('title', 'Directorio de Clientes')

@section('page-title', 'Gestión Comercial')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Clientes / Compradores</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Gestión Comercial
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Clientes
			</li>
		</ol>
	</div>
@endsection

@push('styles')
	<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
@endpush

@section('content')
	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
				<div>
					<h3 class="mb-1">Directorio de Clientes y Compradores</h3>
					<p class="text-muted fs-14 mb-0">Gestión de prospectos, clientes titulares y datos de cónyuges para contratos</p>
				</div>
				<div class="d-flex flex-wrap gap-3 align-items-center">
					<a href="{{ url('/agregar-cliente/' . $idopcion) }}" target="_self">
						<button class="btn btn-primary py-2 px-3 px-sm-4 fs-14 fw-medium rounded-3 d-flex align-items-center gap-2 shadow-sm">
							<i class="ri-user-add-line fs-18"></i>
							<span>Nuevo Cliente</span>
						</button>
					</a>
				</div>
			</div>

			@if(session('bienhecho'))
				<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
					<i class="ri-checkbox-circle-line me-2 fs-16"></i> {{ session('bienhecho') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			@if(session('errorbd'))
				<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
					<i class="ri-error-warning-line me-2 fs-16"></i> {{ session('errorbd') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<div class="default-table-area all-products">
				<div class="table-responsive"
					style="border-radius: 12px; overflow-x: auto; box-shadow: 0 0 20px rgba(0,0,0,0.02); padding-bottom: 20px;">
					<table class="table table-hover align-middle mb-0" id="clientesTable"
						style="border-collapse: collapse; min-width: 1000px;">
						<thead>
							<tr style="background-color: #f7f9fc;">
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Cliente / Razón Social</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Documento</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Contacto (Tel / Email)</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Cónyuge / Co-propietario</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Estado</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($clientes as $item)
								<tr class="transition-all" style="transition: all 0.2s ease;">
									<td class="py-3 px-3 border-bottom" style="border-color: #f0f4fa;">
										<div class="d-flex align-items-center gap-3">
											<div class="bg-primary bg-opacity-10 text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 14px;">
												{{ strtoupper(substr($item->nombre_razon_social, 0, 2)) }}
											</div>
											<div>
												<h6 class="mb-0 fw-bold text-dark fs-14">{{ $item->nombre_completo }}</h6>
												@if($item->ocupacion)
													<span class="text-secondary fs-12">{{ $item->ocupacion }}</span>
												@endif
											</div>
										</div>
									</td>
									<td class="py-3 px-3 border-bottom font-monospace" style="border-color: #f0f4fa;">
										<span class="badge bg-light text-dark border px-2 py-1 fs-13">
											{{ $item->tipo_documento }}: {{ $item->numero_documento }}
										</span>
									</td>
									<td class="py-3 px-3 border-bottom fs-13" style="border-color: #f0f4fa;">
										@if($item->telefono)
											<div>
												<a href="https://wa.me/51{{ preg_replace('/[^0-9]/', '', $item->telefono) }}" target="_blank" class="text-success text-decoration-none fw-medium">
													<i class="ri-whatsapp-line align-middle"></i> {{ $item->telefono }}
												</a>
											</div>
										@endif
										@if($item->email)
											<div class="text-muted"><i class="ri-mail-line align-middle me-1"></i> {{ $item->email }}</div>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom fs-13" style="border-color: #f0f4fa;">
										@if($item->conyuge_nombre)
											<div class="fw-medium text-dark">{{ $item->conyuge_nombre }}</div>
											@if($item->conyuge_dni)
												<span class="text-muted fs-12">DNI: {{ $item->conyuge_dni }}</span>
											@endif
										@else
											<span class="text-muted fst-italic fs-12">No especificado</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										@if($item->activo == 1)
											<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Activo</span>
										@else
											<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Inactivo</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										<div class="d-flex justify-content-center gap-2">
											<a href="{{ url('/modificar-cliente/' . $idopcion . '/' . \App\Facades\Hashids::encode(intval(substr($item->id, 4)))) }}"
												class="btn bg-primary bg-opacity-10 p-2 rounded-3 border-0 shadow-sm d-inline-flex align-items-center justify-content-center text-primary hover-bg-primary hover-text-white transition-all"
												style="width: 34px; height: 34px;" title="Editar Cliente">
												<i class="ri-edit-line fs-16"></i>
											</a>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
	<script>
		$(document).ready(function() {
			if ($('#clientesTable').length) {
				$('#clientesTable').DataTable({
					responsive: true,
					autoWidth: false,
					order: [[0, 'asc']],
					language: window.dtSpanish
				});
			}
		});
	</script>
@endpush
