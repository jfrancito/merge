@extends('layouts.app')

@section('title', 'Proyectos Inmobiliarios')

@section('page-title', 'Catálogo de Lotes')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Proyectos / Urbanizaciones</h5>

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
				Proyectos
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
					<h3 class="mb-1">Proyectos y Desarrollos Inmobiliarios</h3>
					<p class="text-muted fs-14 mb-0">Administre los proyectos, sectores y condominios para la venta de lotes</p>
				</div>
				<div class="d-flex flex-wrap gap-3 align-items-center">
					<a href="{{ url('/agregar-proyecto/' . $idopcion) }}" target="_self">
						<button class="btn btn-primary py-2 px-3 px-sm-4 fs-14 fw-medium rounded-3 d-flex align-items-center gap-2 shadow-sm">
							<i class="ri-add-line fs-18"></i>
							<span>Nuevo Proyecto</span>
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
					<table class="table table-hover align-middle mb-0" id="proyectosTable"
						style="border-collapse: collapse; min-width: 1050px;">
						<thead>
							<tr style="background-color: #f7f9fc;">
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Proyecto / Ubicación</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Moneda & Precio Base</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Manzanas</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Estado de Lotes</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Plano</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($proyectos as $item)
								@php
									$totales = $item->lotes_totales;
									$disp = $item->lotes_disponibles;
									$res = $item->lotes_reservados;
									$vend = $item->lotes_vendidos;
									$simboloMoneda = $item->moneda === 'USD' ? '$' : 'S/';
								@endphp
								<tr class="transition-all" style="transition: all 0.2s ease;">
									<td class="py-3 px-3 border-bottom" style="border-color: #f0f4fa;">
										<div class="d-flex align-items-center gap-3">
											@if($item->foto)
												<img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nombre }}" class="rounded-3 border" style="width: 54px; height: 54px; object-fit: cover;">
											@else
												<div class="bg-primary bg-opacity-10 text-primary fw-bold rounded-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; font-size: 20px;">
													<i class="ri-building-2-line"></i>
												</div>
											@endif
											<div>
												<h6 class="mb-1 fw-bold text-dark fs-15">{{ $item->nombre }}</h6>
												<span class="text-secondary fs-12">
													<i class="ri-map-pin-line fs-12 align-middle text-primary"></i> 
													{{ $item->distrito ?: '' }}{{ $item->provincia ? ' - '.$item->provincia : '' }}{{ $item->departamento ? ' ('.$item->departamento.')' : '' }}
													@if($item->direccion)
														<span class="d-block text-muted">{{ $item->direccion }}</span>
													@endif
												</span>
											</div>
										</div>
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										<span class="badge bg-light text-dark border px-2 py-1 fs-13 font-monospace mb-1 d-inline-block">
											{{ $item->moneda }} ({{ $simboloMoneda }})
										</span>
										@if($item->precio_m2_referencial > 0)
											<div class="fs-12 text-muted">
												Base: <strong class="text-dark">{{ $simboloMoneda }} {{ number_format($item->precio_m2_referencial, 2) }}</strong> / m²
											</div>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										<a href="{{ url('/gestion-de-manzanas/1CIX00000006?proyecto_id=' . $item->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 fs-12 fw-medium">
											<i class="ri-grid-line me-1"></i> {{ $item->manzanas->count() }} Manzanas
										</a>
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										<div class="d-flex justify-content-center gap-1 flex-wrap">
											<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fs-11" title="Lotes Disponibles">
												🟢 {{ $disp }} Disp.
											</span>
											<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 rounded-pill fs-11" title="Lotes Reservados">
												🟡 {{ $res }} Res.
											</span>
											<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill fs-11" title="Lotes Vendidos">
												🔴 {{ $vend }} Vend.
											</span>
										</div>
										<div class="small text-muted mt-1 fs-11">Total: <strong>{{ $totales }} lotes</strong></div>
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										@if($item->plano)
											<a href="{{ asset('storage/' . $item->plano) }}" target="_blank" class="btn btn-sm btn-light border px-2 py-1 fs-12 text-primary" title="Ver Plano General">
												<i class="ri-file-chart-line fs-14 align-middle"></i> Plano
											</a>
										@else
											<span class="text-muted fs-12 fst-italic">Sin plano</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										<div class="d-flex justify-content-center gap-2">
											<a href="{{ url('/gestion-de-lotes/1CIX00000007?proyecto_id=' . $item->id) }}"
												class="btn bg-success bg-opacity-10 p-2 rounded-3 border-0 shadow-sm d-inline-flex align-items-center justify-content-center text-success hover-bg-success hover-text-white transition-all"
												style="width: 34px; height: 34px;" title="Ver Catálogo de Lotes">
												<i class="ri-crop-line fs-16"></i>
											</a>
											<a href="{{ url('/modificar-proyecto/' . $idopcion . '/' . \App\Facades\Hashids::encode(intval(substr($item->id, 4)))) }}"
												class="btn bg-primary bg-opacity-10 p-2 rounded-3 border-0 shadow-sm d-inline-flex align-items-center justify-content-center text-primary hover-bg-primary hover-text-white transition-all"
												style="width: 34px; height: 34px;" title="Editar Proyecto">
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
	<script src="{{ asset('js/app/proyectos.js?v='.$version) }}"></script>
@endpush
