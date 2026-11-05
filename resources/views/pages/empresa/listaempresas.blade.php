@extends('layouts.app')

@section('title', 'Lista de Empresas / Inmobiliarias')

@section('page-title', 'Gestión de Empresas')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Empresas e Inmobiliarias</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>

			<li class="breadcrumb-item d-inline-block position-relative">
				Configuración
			</li>

			<li class="breadcrumb-item d-inline-block position-relative">
				Empresas
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
				<div>
					<h3 class="mb-1">Empresas / Desarrolladoras Inmobiliarias</h3>
					<p class="text-muted fs-14 mb-0">Gestione las inmobiliarias y empresas del sistema Loteame</p>
				</div>
				<div class="d-flex flex-wrap gap-3 align-items-center">
					<a href="{{ url('/agregar-empresa/' . $idopcion) }}" target="_self">
						<button class="btn btn-primary py-2 px-3 px-sm-4 fs-14 fw-medium rounded-3 d-flex align-items-center gap-2">
							<i class="ri-add-line fs-18"></i>
							<span>Registrar Inmobiliaria</span>
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
					<table class="table table-hover align-middle mb-0" id="empresasTable"
						style="border-collapse: collapse; min-width: 1050px;">
						<thead>
							<tr style="background-color: #f7f9fc;">
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Inmobiliaria / Razón Social</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									RUC</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Contacto</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Representante Legal</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Estado</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($listaempresas as $index => $item)
								@php
									$config = is_array($item->configuracion_simple) ? $item->configuracion_simple : json_decode($item->configuracion_simple ?? '{}', true);
									$telefono = $config['telefono'] ?? null;
									$email = $config['email'] ?? null;
									$repLegal = $config['representante_legal'] ?? null;
									$repDni = $config['representante_dni'] ?? null;
								@endphp
								<tr class="transition-all" style="transition: all 0.2s ease;">
									<td class="py-3 px-3 border-bottom" style="border-color: #f0f4fa;">
										<div class="d-flex align-items-center gap-3">
											@if($item->logo)
												<img src="{{ asset('storage/' . $item->logo) }}" alt="{{ $item->nombre }}" class="rounded-3 border p-1" style="width: 44px; height: 44px; object-fit: contain; background: #fff;">
											@else
												<div class="bg-primary bg-opacity-10 text-primary fw-bold rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 16px;">
													<i class="ri-building-line"></i>
												</div>
											@endif
											<div>
												<h6 class="mb-0 fw-bold text-dark fs-14">{{ $item->nombre }}</h6>
												<span class="text-secondary fs-12">
													<i class="ri-map-pin-line fs-12 align-middle"></i> {{ $item->direccion_fiscal ?: 'Sin dirección registrada' }}
												</span>
											</div>
										</div>
									</td>
									<td class="py-3 px-3 border-bottom fw-semibold text-dark fs-14" style="border-color: #f0f4fa;">
										<span class="badge bg-light text-dark border px-2 py-1 fs-13 font-monospace">{{ $item->ruc }}</span>
									</td>
									<td class="py-3 px-3 border-bottom fs-13" style="border-color: #f0f4fa;">
										@if($telefono)
											<div><i class="ri-phone-line text-muted align-middle me-1"></i> {{ $telefono }}</div>
										@endif
										@if($email)
											<div class="text-muted"><i class="ri-mail-line align-middle me-1"></i> {{ $email }}</div>
										@endif
										@if(!$telefono && !$email)
											<span class="text-muted fst-italic fs-12">No especificado</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom fs-13" style="border-color: #f0f4fa;">
										@if($repLegal)
											<div class="fw-medium text-dark">{{ $repLegal }}</div>
											@if($repDni)
												<span class="text-muted fs-12">DNI: {{ $repDni }}</span>
											@endif
										@else
											<span class="text-muted fst-italic fs-12">No especificado</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										@if($item->activo == 1)
											<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill fs-12 fw-medium">Activa</span>
										@else
											<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1 rounded-pill fs-12 fw-medium">Inactiva</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										<div class="d-flex justify-content-center gap-2">
											<a href="{{ url('/modificar-empresa/' . $idopcion . '/' . \App\Facades\Hashids::encode(intval(substr($item->id, 4)))) }}"
												class="btn bg-primary bg-opacity-10 p-2 rounded-3 border-0 shadow-sm d-inline-flex align-items-center justify-content-center text-primary hover-bg-primary hover-text-white transition-all"
												style="width: 34px; height: 34px;" title="Editar Inmobiliaria">
												<i class="ri-edit-line fs-16"></i>
											</a>
											@if(session('usuario')->rol_id === '1CIX00000001' && $item->id !== session('empresa_id'))
												<a href="{{ url('/superadmin/cambiar-empresa/' . $item->id) }}"
													class="btn bg-success bg-opacity-10 p-2 rounded-3 border-0 shadow-sm d-inline-flex align-items-center justify-content-center text-success hover-bg-success hover-text-white transition-all"
													style="width: 34px; height: 34px;" title="Cambiar a esta Inmobiliaria">
													<i class="ri-login-box-line fs-16"></i>
												</a>
											@endif
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
	<script src="{{ asset('js/app/empresas.js?v='.$version) }}"></script>
@endpush