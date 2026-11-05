@extends('layouts.app')

@section('title', 'Cotizaciones y Proformas')

@section('page-title', 'Gestión Comercial')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Cotizaciones / Proformas</h5>

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
				Cotizaciones
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
					<h3 class="mb-1">Simulador y Proformas de Lotes</h3>
					<p class="text-muted fs-14 mb-0">Cotizaciones generadas con planes de financiamiento y exportación de proforma</p>
				</div>
				<div class="d-flex flex-wrap gap-3 align-items-center">
					<a href="{{ url('/agregar-cotizacion/' . $idopcion) }}" target="_self">
						<button class="btn btn-primary py-2 px-3 px-sm-4 fs-14 fw-medium rounded-3 d-flex align-items-center gap-2 shadow-sm">
							<i class="ri-calculator-line fs-18"></i>
							<span>Nueva Cotización</span>
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
					<table class="table table-hover align-middle mb-0" id="cotizacionesTable"
						style="border-collapse: collapse; min-width: 1050px;">
						<thead>
							<tr style="background-color: #f7f9fc;">
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Código</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Cliente</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Proyecto & Lote</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Modalidad</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-end">
									Precio Final</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Plan Cuotas</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Emisión</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($cotizaciones as $item)
								@php
									$simbolo = ($item->proyecto && $item->proyecto->moneda === 'USD') ? '$' : 'S/';
								@endphp
								<tr class="transition-all" style="transition: all 0.2s ease;">
									<td class="py-3 px-3 border-bottom font-monospace fw-bold text-primary fs-13" style="border-color: #f0f4fa;">
										{{ $item->codigo_cotizacion }}
									</td>
									<td class="py-3 px-3 border-bottom fs-14 text-dark fw-medium" style="border-color: #f0f4fa;">
										{{ $item->cliente ? $item->cliente->nombre_completo : 'Cliente no asignado' }}
										@if($item->cliente && $item->cliente->telefono)
											<div class="fs-12 text-muted">{{ $item->cliente->telefono }}</div>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom fs-13" style="border-color: #f0f4fa;">
										<div class="fw-semibold text-dark">{{ $item->proyecto ? $item->proyecto->nombre : '' }}</div>
										<span class="text-muted fs-12">
											{{ $item->lote && $item->lote->manzana ? $item->lote->manzana->nombre : 'Mz' }} - Lote {{ $item->lote ? $item->lote->numero_lote : '' }}
											({{ $item->lote ? number_format($item->lote->area_m2, 2) : 0 }} m²)
										</span>
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										@if($item->tipo_pago === 'contado')
											<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Contado</span>
										@else
											<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Crédito Directo</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-end fw-bold text-dark fs-14" style="border-color: #f0f4fa;">
										{{ $simbolo }} {{ number_format($item->precio_final, 2) }}
									</td>
									<td class="py-3 px-3 border-bottom text-center fs-13" style="border-color: #f0f4fa;">
										@if($item->tipo_pago === 'credito')
											<div class="fw-bold text-dark">{{ $item->numero_cuotas }} meses</div>
											<span class="text-muted fs-12">{{ $simbolo }} {{ number_format($item->monto_cuota_mensual, 2) }} /mes</span>
										@else
											<span class="text-muted fst-italic fs-12">Pago Único</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-center text-muted fs-12" style="border-color: #f0f4fa;">
										{{ $item->fecha_emision ? date('d/m/Y', strtotime($item->fecha_emision)) : '' }}
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										<div class="d-flex justify-content-center gap-2">
											<a href="{{ url('/ver-cotizacion/' . $idopcion . '/' . \App\Facades\Hashids::encode(intval(substr($item->id, 4)))) }}"
												target="_blank"
												class="btn bg-primary bg-opacity-10 p-2 rounded-3 border-0 shadow-sm d-inline-flex align-items-center justify-content-center text-primary hover-bg-primary hover-text-white transition-all"
												style="width: 34px; height: 34px;" title="Ver / Imprimir Proforma">
												<i class="ri-printer-line fs-16"></i>
											</a>
											<a href="{{ url('/agregar-reserva/1CIX00000012?lote_id=' . $item->lote_id) }}"
												class="btn bg-warning bg-opacity-10 p-2 rounded-3 border-0 shadow-sm d-inline-flex align-items-center justify-content-center text-warning hover-bg-warning hover-text-white transition-all"
												style="width: 34px; height: 34px;" title="Convertir a Separación">
												<i class="ri-bookmark-line fs-16"></i>
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
			if ($('#cotizacionesTable').length) {
				$('#cotizacionesTable').DataTable({
					responsive: true,
					autoWidth: false,
					order: [[0, 'desc']],
					language: window.dtSpanish
				});
			}
		});
	</script>
@endpush
