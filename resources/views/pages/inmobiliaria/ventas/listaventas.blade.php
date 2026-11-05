@extends('layouts.app')

@section('title', 'Contratos de Venta')

@section('page-title', 'Ventas y Cobranzas')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Contratos de Venta</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Ventas y Cobranzas
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Contratos de Venta
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
					<h3 class="mb-1">Contratos de Compraventa de Lotes</h3>
					<p class="text-muted fs-14 mb-0">Gestione las ventas cerradas, cronogramas de financiamiento directo y contratos</p>
				</div>
				<div class="d-flex flex-wrap gap-3 align-items-center">
					<a href="{{ url('/agregar-venta/' . $idopcion) }}" target="_self">
						<button class="btn btn-primary py-2 px-3 px-sm-4 fs-14 fw-medium rounded-3 d-flex align-items-center gap-2 shadow-sm">
							<i class="ri-file-add-line fs-18"></i>
							<span>Formalizar Nueva Venta</span>
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
					<table class="table table-hover align-middle mb-0" id="ventasTable"
						style="border-collapse: collapse; min-width: 1100px;">
						<thead>
							<tr style="background-color: #f7f9fc;">
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									N° Contrato</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Comprador</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3">
									Proyecto & Lote</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Modalidad</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-end">
									Precio Total</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-end">
									Pagado / Saldo</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Estado</th>
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-3 text-center">
									Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($ventas as $item)
								@php
									$simbolo = ($item->proyecto && $item->proyecto->moneda === 'USD') ? '$' : 'S/';
									$pagado = $item->monto_total_pagado;
									$saldo = $item->saldo_pendiente_total;
								@endphp
								<tr class="transition-all" style="transition: all 0.2s ease;">
									<td class="py-3 px-3 border-bottom font-monospace fw-bold text-primary fs-13" style="border-color: #f0f4fa;">
										{{ $item->codigo_contrato }}
										<span class="d-block text-muted fs-11 fw-normal">{{ date('d/m/Y', strtotime($item->fecha_venta)) }}</span>
									</td>
									<td class="py-3 px-3 border-bottom fs-14 text-dark fw-medium" style="border-color: #f0f4fa;">
										{{ $item->cliente ? $item->cliente->nombre_completo : '' }}
										@if($item->cliente)
											<div class="fs-12 text-muted">DNI: {{ $item->cliente->numero_documento }}</div>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom fs-13" style="border-color: #f0f4fa;">
										<div class="fw-semibold text-dark">{{ $item->proyecto ? $item->proyecto->nombre : '' }}</div>
										<span class="text-muted fs-12">
											{{ $item->lote && $item->lote->manzana ? $item->lote->manzana->nombre : 'Mz' }} - Lote {{ $item->lote ? $item->lote->numero_lote : '' }}
										</span>
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										@if($item->tipo_venta === 'contado')
											<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Contado</span>
										@else
											<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">
												Crédito ({{ $item->numero_cuotas }}m)
											</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-end fw-bold text-dark fs-14" style="border-color: #f0f4fa;">
										{{ $simbolo }} {{ number_format($item->precio_final, 2) }}
									</td>
									<td class="py-3 px-3 border-bottom text-end fs-13" style="border-color: #f0f4fa;">
										<div class="text-success fw-bold">{{ $simbolo }} {{ number_format($pagado, 2) }}</div>
										@if($saldo > 0)
											<div class="text-danger fs-12">Saldo: {{ $simbolo }} {{ number_format($saldo, 2) }}</div>
										@else
											<span class="badge bg-success bg-opacity-10 text-success fs-10 px-2 py-0">Cancelado</span>
										@endif
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										{!! $item->estado_badge !!}
									</td>
									<td class="py-3 px-3 border-bottom text-center" style="border-color: #f0f4fa;">
										<div class="d-flex justify-content-center gap-2">
											<a href="{{ url('/ver-venta/' . $idopcion . '/' . \App\Facades\Hashids::encode(intval(substr($item->id, 4)))) }}"
												class="btn bg-primary bg-opacity-10 p-2 rounded-3 border-0 shadow-sm d-inline-flex align-items-center justify-content-center text-primary hover-bg-primary hover-text-white transition-all"
												style="width: 34px; height: 34px;" title="Ver Cronograma y Estado de Cuenta">
												<i class="ri-calendar-check-line fs-16"></i>
											</a>
											<a href="{{ url('/imprimir-contrato/' . $idopcion . '/' . \App\Facades\Hashids::encode(intval(substr($item->id, 4)))) }}"
												target="_blank"
												class="btn bg-secondary bg-opacity-10 p-2 rounded-3 border-0 shadow-sm d-inline-flex align-items-center justify-content-center text-secondary hover-bg-secondary hover-text-white transition-all"
												style="width: 34px; height: 34px;" title="Imprimir Contrato Compraventa">
												<i class="ri-file-paper-2-line fs-16"></i>
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
			if ($('#ventasTable').length) {
				$('#ventasTable').DataTable({
					responsive: true,
					autoWidth: false,
					order: [[0, 'desc']],
					language: window.dtSpanish
				});
			}
		});
	</script>
@endpush
