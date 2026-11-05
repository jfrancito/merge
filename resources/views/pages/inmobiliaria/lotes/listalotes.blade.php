@extends('layouts.app')

@section('title', 'Catálogo de Lotes')

@section('page-title', 'Catálogo de Lotes')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Inventario y Catálogo de Lotes</h5>

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
				Lotes
			</li>
		</ol>
	</div>
@endsection

@push('styles')
	<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
@endpush

@section('content')
	<!-- TARJETAS DE MÉTRICAS -->
	<div class="row mb-4">
		<div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
			<div class="card border-0 rounded-3 p-3 bg-white shadow-sm h-100">
				<div class="d-flex align-items-center justify-content-between">
					<div>
						<span class="text-muted fs-13 fw-semibold">TOTAL LOTES</span>
						<h3 class="mb-0 fw-bold text-dark mt-1">{{ number_format($metricas['total']) }}</h3>
						<span class="text-muted fs-12">{{ number_format($metricas['total_m2'], 2) }} m² registrados</span>
					</div>
					<div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
						<i class="ri-crop-line fs-24"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
			<div class="card border-0 rounded-3 p-3 bg-white shadow-sm h-100">
				<div class="d-flex align-items-center justify-content-between">
					<div>
						<span class="text-muted fs-13 fw-semibold">DISPONIBLES</span>
						<h3 class="mb-0 fw-bold text-success mt-1">{{ number_format($metricas['disponibles']) }}</h3>
						<span class="text-success fs-12 fw-medium">Listos para vender / cotizar</span>
					</div>
					<div class="bg-success bg-opacity-10 text-success rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
						<i class="ri-checkbox-circle-line fs-24"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
			<div class="card border-0 rounded-3 p-3 bg-white shadow-sm h-100">
				<div class="d-flex align-items-center justify-content-between">
					<div>
						<span class="text-muted fs-13 fw-semibold">RESERVADOS</span>
						<h3 class="mb-0 fw-bold text-warning mt-1">{{ number_format($metricas['reservados']) }}</h3>
						<span class="text-warning fs-12 fw-medium">Separaciones vigentes</span>
					</div>
					<div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
						<i class="ri-time-line fs-24"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
			<div class="card border-0 rounded-3 p-3 bg-white shadow-sm h-100">
				<div class="d-flex align-items-center justify-content-between">
					<div>
						<span class="text-muted fs-13 fw-semibold">VENDIDOS</span>
						<h3 class="mb-0 fw-bold text-danger mt-1">{{ number_format($metricas['vendidos']) }}</h3>
						<span class="text-muted fs-12">Valor inv.: S/ {{ number_format($metricas['total_valor'], 2) }}</span>
					</div>
					<div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
						<i class="ri-shake-hands-line fs-24"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
				<div>
					<h3 class="mb-1">Inventario de Lotes</h3>
					<p class="text-muted fs-14 mb-0">Visualice, filtre y administre los lotes por proyecto, manzana y estado comercial</p>
				</div>
				<div class="d-flex flex-wrap gap-2 align-items-center">
					<a href="{{ url('/creacion-masiva-lotes/' . $idopcion . ($proyecto_id ? '?proyecto_id='.$proyecto_id.($manzana_id ? '&manzana_id='.$manzana_id : '') : '')) }}" target="_self">
						<button class="btn btn-outline-primary py-2 px-3 fs-14 fw-medium rounded-3 d-flex align-items-center gap-2">
							<i class="ri-stack-line fs-18"></i>
							<span>Generación Masiva</span>
						</button>
					</a>
					<a href="{{ url('/agregar-lote/' . $idopcion . ($proyecto_id ? '?proyecto_id='.$proyecto_id.($manzana_id ? '&manzana_id='.$manzana_id : '') : '')) }}" target="_self">
						<button class="btn btn-primary py-2 px-3 fs-14 fw-medium rounded-3 d-flex align-items-center gap-2 shadow-sm">
							<i class="ri-add-line fs-18"></i>
							<span>Nuevo Lote</span>
						</button>
					</a>
				</div>
			</div>

			<!-- BARRA DE FILTROS -->
			<div class="row g-3 mb-4 p-3 bg-light rounded-3">
				<div class="col-lg-4 col-md-6">
					<label class="form-label fw-semibold fs-12 text-muted text-uppercase mb-1">Proyecto:</label>
					<select class="form-select fs-13" id="filtro_proyecto_id" data-idopcion="{{ $idopcion }}">
						<option value="">-- Todos los Proyectos --</option>
						@foreach($proyectos as $p)
							<option value="{{ $p->id }}" {{ $proyecto_id == $p->id ? 'selected' : '' }}>
								{{ $p->nombre }} ({{ $p->distrito }})
							</option>
						@endforeach
					</select>
				</div>

				<div class="col-lg-4 col-md-6">
					<label class="form-label fw-semibold fs-12 text-muted text-uppercase mb-1">Manzana:</label>
					<select class="form-select fs-13" id="filtro_manzana_id">
						<option value="">-- Todas las Manzanas --</option>
						@foreach($manzanas as $mz)
							<option value="{{ $mz->id }}" {{ $manzana_id == $mz->id ? 'selected' : '' }}>
								{{ $mz->nombre }}
							</option>
						@endforeach
					</select>
				</div>

				<div class="col-lg-4 col-md-12">
					<label class="form-label fw-semibold fs-12 text-muted text-uppercase mb-1">Estado Comercial:</label>
					<select class="form-select fs-13" id="filtro_estado">
						<option value="">-- Todos los Estados --</option>
						<option value="disponible" {{ $estado_filtro == 'disponible' ? 'selected' : '' }}>🟢 Disponibles</option>
						<option value="reservado" {{ $estado_filtro == 'reservado' ? 'selected' : '' }}>🟡 Reservados / Separados</option>
						<option value="vendido" {{ $estado_filtro == 'vendido' ? 'selected' : '' }}>🔴 Vendidos</option>
						<option value="bloqueado" {{ $estado_filtro == 'bloqueado' ? 'selected' : '' }}>⚫ Bloqueados</option>
					</select>
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
					<table class="table table-hover align-middle mb-0" id="lotesTable"
						style="border-collapse: collapse; min-width: 1100px;">
						<thead>
							<tr style="background-color: #f7f9fc;">
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Proyecto</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Manzana & Lote</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Área (m²)</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Medidas (F x F)</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Tipo</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-end">
									Precio Total</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Estado</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($lotes as $item)
								@php
									$simbolo = ($item->proyecto && $item->proyecto->moneda === 'USD') ? '$' : 'S/';
								@endphp
								<tr class="transition-all" style="transition: all 0.2s ease;">
									<td class="py-3 px-3 border-bottom fs-13 text-dark fw-medium" style="border-color: #f0f4fa;">
										<i class="ri-building-line text-primary me-1"></i> {{ $item->proyecto ? $item->proyecto->nombre : 'Sin Proyecto' }}
									</td>
									<td class="py-3 px-3 border-bottom" style="border-color: #f0f4fa;">
										<div class="d-flex align-items-center gap-2">
											<span class="badge bg-light text-dark border px-2 py-1 fs-13 fw-bold font-monospace">
												{{ $item->manzana ? $item->manzana->nombre : 'Mz' }}
											</span>
											<h6 class="mb-0 fw-bold text-primary fs-14">Lote {{ $item->numero_lote }}</h6>
										</div>
									</td>
									<td class="py-3 px-3 border-bottom text-center fw-bold text-dark fs-14" style="border-color: #f0f4fa;">
										{{ number_format($item->area_m2, 2) }} <span class="fs-12 text-muted fw-normal">m²</span>
									</td>
									<td class="py-3 px-3 border-bottom text-center text-muted fs-12" style="border-color: #f0f4fa;">
										@if($item->medida_frente > 0 || $item->medida_fondo > 0)
											{{ $item->medida_frente }}m x {{ $item->medida_fondo }}m
										@else
											<span class="fst-italic">-</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										@if($item->tipo_lote === 'esquina')
											<span class="badge bg-info bg-opacity-10 text-info px-2 py-1 rounded-pill fs-11">Esquina</span>
										@elseif($item->tipo_lote === 'parque')
											<span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill fs-11">Frente Parque</span>
										@elseif($item->tipo_lote === 'avenida')
											<span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill fs-11">Avenida</span>
										@else
											<span class="badge bg-light text-secondary border px-2 py-1 rounded-pill fs-11">Estándar</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-end fw-bold text-dark fs-14" style="border-color: #f0f4fa;">
										{{ $simbolo }} {{ number_format($item->precio_total, 2) }}
										@if($item->precio_m2 > 0)
											<div class="fs-11 text-muted fw-normal">{{ $simbolo }}{{ number_format($item->precio_m2, 2) }}/m²</div>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										{!! $item->estado_badge !!}
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										<div class="d-flex justify-content-center gap-2">
											<a href="{{ url('/modificar-lote/' . $idopcion . '/' . \App\Facades\Hashids::encode(intval(substr($item->id, 4)))) }}"
												class="btn bg-primary bg-opacity-10 p-2 rounded-3 border-0 shadow-sm d-inline-flex align-items-center justify-content-center text-primary hover-bg-primary hover-text-white transition-all"
												style="width: 34px; height: 34px;" title="Editar Lote">
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
	<script src="{{ asset('js/app/lotes.js?v='.$version) }}"></script>
@endpush
