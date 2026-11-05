@extends('layouts.app')

@section('title', 'Manzanas y Secciones')

@section('page-title', 'Catálogo de Lotes')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Manzanas / Secciones</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>

			<li class="breadcrumb-item d-inline-block position-relative">
				Catálogo de Lotes
			</li>

			<li class="breadcrumb-item d-inline-block position-relative">
				Manzanas
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
					<h3 class="mb-1">Manzanas y Bloques de Lotes</h3>
					<p class="text-muted fs-14 mb-0">Gestione las manzanas (`Mz. A`, `Mz. B`, etc.) por cada proyecto inmobiliario</p>
				</div>
				<div class="d-flex flex-wrap gap-3 align-items-center">
					<a href="{{ url('/agregar-manzana/' . $idopcion . ($proyecto_id ? '?proyecto_id='.$proyecto_id : '')) }}" target="_self">
						<button class="btn btn-primary py-2 px-3 px-sm-4 fs-14 fw-medium rounded-3 d-flex align-items-center gap-2 shadow-sm">
							<i class="ri-add-line fs-18"></i>
							<span>Nueva Manzana</span>
						</button>
					</a>
				</div>
			</div>

			<!-- FILTRO POR PROYECTO -->
			<div class="row mb-4">
				<div class="col-lg-4 col-md-6">
					<label class="form-label fw-semibold fs-13 text-muted">Filtrar por Proyecto:</label>
					<div class="input-group">
						<span class="input-group-text bg-light text-muted"><i class="ri-filter-3-line"></i></span>
						<select class="form-select" id="filtro_proyecto_id" data-idopcion="{{ $idopcion }}">
							<option value="">-- Todos los Proyectos --</option>
							@foreach($proyectos as $p)
								<option value="{{ $p->id }}" {{ $proyecto_id == $p->id ? 'selected' : '' }}>
									{{ $p->nombre }} ({{ $p->distrito }})
								</option>
							@endforeach
						</select>
					</div>
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
					<table class="table table-hover align-middle mb-0" id="manzanasTable"
						style="border-collapse: collapse; min-width: 900px;">
						<thead>
							<tr style="background-color: #f7f9fc;">
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Proyecto</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Manzana / Sección</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Orden</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Lotes en Manzana</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Estado</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($manzanas as $item)
								@php
									$totales = $item->lotes_totales;
									$disp = $item->lotes_disponibles;
									$res = $item->lotes_reservados;
									$vend = $item->lotes_vendidos;
								@endphp
								<tr class="transition-all" style="transition: all 0.2s ease;">
									<td class="py-3 px-3 border-bottom fw-semibold text-dark fs-14" style="border-color: #f0f4fa;">
										<i class="ri-building-line text-primary me-1"></i> {{ $item->proyecto ? $item->proyecto->nombre : 'Sin Proyecto' }}
									</td>
									<td class="py-3 px-3 border-bottom" style="border-color: #f0f4fa;">
										<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-3 fs-14 fw-bold">
											{{ $item->nombre }}
										</span>
										@if($item->descripcion)
											<span class="d-block text-muted fs-12 mt-1">{{ $item->descripcion }}</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-center text-muted fs-13" style="border-color: #f0f4fa;">
										#{{ $item->orden }}
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										<div class="d-flex justify-content-center gap-1 flex-wrap">
											<span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill fs-11" title="Disponibles">
												🟢 {{ $disp }} Disp.
											</span>
											<span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1 rounded-pill fs-11" title="Reservados">
												🟡 {{ $res }} Res.
											</span>
											<span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 rounded-pill fs-11" title="Vendidos">
												🔴 {{ $vend }} Vend.
											</span>
										</div>
										<div class="small text-muted mt-1 fs-11">Total: <strong>{{ $totales }} lotes</strong></div>
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										@if($item->activo == 1)
											<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Activa</span>
										@else
											<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Inactiva</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										<div class="d-flex justify-content-center gap-2">
											<a href="{{ url('/gestion-de-lotes/1CIX00000007?proyecto_id=' . $item->proyecto_id . '&manzana_id=' . $item->id) }}"
												class="btn bg-success bg-opacity-10 p-2 rounded-3 border-0 shadow-sm d-inline-flex align-items-center justify-content-center text-success hover-bg-success hover-text-white transition-all"
												style="width: 34px; height: 34px;" title="Ver Lotes de esta Manzana">
												<i class="ri-crop-line fs-16"></i>
											</a>
											<a href="{{ url('/modificar-manzana/' . $idopcion . '/' . \App\Facades\Hashids::encode(intval(substr($item->id, 4)))) }}"
												class="btn bg-primary bg-opacity-10 p-2 rounded-3 border-0 shadow-sm d-inline-flex align-items-center justify-content-center text-primary hover-bg-primary hover-text-white transition-all"
												style="width: 34px; height: 34px;" title="Editar Manzana">
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
	<script src="{{ asset('js/app/manzanas.js?v='.$version) }}"></script>
@endpush
