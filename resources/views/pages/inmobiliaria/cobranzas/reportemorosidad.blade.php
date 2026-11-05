@extends('layouts.app')

@section('title', 'Reporte de Morosidad')

@section('page-title', 'Ventas y Cobranzas')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Reporte de Morosidad (Cartera Vencida)</h5>

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
				Reporte Morosidad
			</li>
		</ol>
	</div>
@endsection

@push('styles')
	<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
@endpush

@section('content')
	<!-- Metric Summary Cards -->
	<div class="row mb-4 g-3">
		<div class="col-12 col-sm-6 col-xl-3">
			<div class="card border-0 rounded-3 shadow-sm p-3 bg-white border-start border-4 border-danger">
				<div class="d-flex align-items-center justify-content-between">
					<div>
						<span class="text-muted fs-12 fw-bold text-uppercase">Deuda Vencida Total</span>
						<h3 class="mb-0 fw-bold text-danger mt-1">S/ {{ number_format($resumenMora['total_deuda'], 2) }}</h3>
						<span class="fs-12 text-muted">{{ $resumenMora['total_cuotas_vencidas'] }} cuotas impagas</span>
					</div>
					<div class="rounded-circle bg-danger bg-opacity-10 p-3 text-danger">
						<i class="ri-money-dollar-circle-line fs-28"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 col-sm-6 col-xl-3">
			<div class="card border-0 rounded-3 shadow-sm p-3 bg-white border-start border-4 border-warning">
				<div class="d-flex align-items-center justify-content-between">
					<div>
						<span class="text-muted fs-12 fw-bold text-uppercase">Tramo 1 a 30 Días</span>
						<h3 class="mb-0 fw-bold text-warning mt-1">S/ {{ number_format($resumenMora['mora_1_30'], 2) }}</h3>
						<span class="fs-12 text-muted">Mora temprana</span>
					</div>
					<div class="rounded-circle bg-warning bg-opacity-10 p-3 text-warning">
						<i class="ri-time-line fs-28"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 col-sm-6 col-xl-3">
			<div class="card border-0 rounded-3 shadow-sm p-3 bg-white border-start border-4 border-orange" style="border-left-color: #fd7e14 !important;">
				<div class="d-flex align-items-center justify-content-between">
					<div>
						<span class="text-muted fs-12 fw-bold text-uppercase">Tramo 31 a 60 Días</span>
						<h3 class="mb-0 fw-bold mt-1" style="color: #fd7e14;">S/ {{ number_format($resumenMora['mora_31_60'], 2) }}</h3>
						<span class="fs-12 text-muted">Mora media</span>
					</div>
					<div class="rounded-circle p-3" style="background: rgba(253, 126, 20, 0.1); color: #fd7e14;">
						<i class="ri-alarm-warning-line fs-28"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 col-sm-6 col-xl-3">
			<div class="card border-0 rounded-3 shadow-sm p-3 bg-white border-start border-4 border-dark">
				<div class="d-flex align-items-center justify-content-between">
					<div>
						<span class="text-muted fs-12 fw-bold text-uppercase">Más de 60 Días</span>
						<h3 class="mb-0 fw-bold text-dark mt-1">S/ {{ number_format($resumenMora['mora_mas_60'], 2) }}</h3>
						<span class="fs-12 text-danger fw-semibold">Riesgo de resolución</span>
					</div>
					<div class="rounded-circle bg-dark bg-opacity-10 p-3 text-dark">
						<i class="ri-error-warning-fill fs-28"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Main Table -->
	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
				<div>
					<h3 class="mb-1">Detalle de Cartera Pesada y Clientes Morosos</h3>
					<p class="text-muted fs-14 mb-0">Total: {{ $resumenMora['clientes_unicos'] }} clientes con pagos pendientes fuera de fecha</p>
				</div>
				<div class="d-flex gap-2">
					<button onclick="window.print()" class="btn btn-outline-secondary py-2 px-3 fs-14 rounded-3 d-flex align-items-center gap-2">
						<i class="ri-printer-line"></i>
						<span>Imprimir Reporte</span>
					</button>
				</div>
			</div>

			<div class="table-responsive" style="border-radius: 12px; overflow-x: auto; padding-bottom: 20px;">
				<table class="table table-hover align-middle mb-0" id="morosidadTable" style="border-collapse: collapse; min-width: 1100px;">
					<thead>
						<tr style="background-color: #f7f9fc;">
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3">Cliente / DNI</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3">Contacto Directo</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3">Contrato & Lote</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-center">N° Cuota</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-center">F. Vencimiento</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-center">Días de Atraso</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-end">Deuda Pendiente</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-center">Gestión Cobro</th>
						</tr>
					</thead>
					<tbody>
						@forelse($cuotasVencidas as $item)
							@php
								$simbolo = ($item->proyecto_moneda === 'USD') ? '$' : 'S/';
								$cleanPhone = preg_replace('/[^0-9]/', '', $item->cliente_telefono ?? '');
								$mensajeWhatsapp = rawurlencode("Estimado(a) " . $item->nombre_razon_social . ", le saludamos de Loteame Inmobiliaria. Le recordamos amablemente que registra la Cuota #" . $item->numero_cuota . " del Contrato " . $item->codigo_contrato . " con un saldo pendiente de " . $simbolo . " " . number_format($item->saldo_pendiente, 2) . " vencida el " . date('d/m/Y', strtotime($item->fecha_vencimiento)) . ". Por favor comuníquese con nosotros para facilitarle los medios de pago. Saludos cordiales.");
							@endphp
							<tr>
								<td class="py-3 px-3 border-bottom fs-13">
									<div class="fw-bold text-dark">{{ $item->nombre_razon_social }} {{ $item->cliente_apellidos }}</div>
									<div class="text-muted fs-12">Doc: <span class="font-monospace">{{ $item->cliente_dni }}</span></div>
								</td>
								<td class="py-3 px-3 border-bottom fs-13">
									@if($cleanPhone)
										<a href="https://wa.me/51{{ $cleanPhone }}?text={{ $mensajeWhatsapp }}" target="_blank"
											class="btn btn-sm btn-success rounded-pill px-3 py-1 fs-12 d-inline-flex align-items-center gap-1 shadow-sm">
											<i class="ri-whatsapp-line fs-14"></i>
											<span>Recordar por WhatsApp</span>
										</a>
										<div class="text-muted fs-11 mt-1">{{ $item->cliente_telefono }}</div>
									@else
										<span class="text-muted fs-12">Sin teléfono</span>
									@endif
								</td>
								<td class="py-3 px-3 border-bottom fs-13">
									<div class="font-monospace fw-bold text-primary">{{ $item->codigo_contrato }}</div>
									<div class="text-dark">{{ $item->proyecto_nombre }}</div>
									<span class="text-muted fs-12">{{ $item->manzana_nombre }} - Lote {{ $item->numero_lote }}</span>
								</td>
								<td class="py-3 px-3 border-bottom text-center fs-14">
									@if($item->numero_cuota == 0)
										<span class="badge bg-info bg-opacity-10 text-info fw-bold">Inicial</span>
									@else
										<span class="fw-bold text-dark"># {{ $item->numero_cuota }}</span>
									@endif
								</td>
								<td class="py-3 px-3 border-bottom text-center fs-13 text-danger fw-semibold">
									{{ date('d/m/Y', strtotime($item->fecha_vencimiento)) }}
								</td>
								<td class="py-3 px-3 border-bottom text-center">
									@if($item->dias_mora <= 30)
										<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-bold">
											{{ $item->dias_mora }} días
										</span>
									@elseif($item->dias_mora <= 60)
										<span class="badge bg-orange text-white px-2 py-1 rounded-pill fs-12 fw-bold" style="background-color: #fd7e14;">
											{{ $item->dias_mora }} días
										</span>
									@else
										<span class="badge bg-danger text-white px-2 py-1 rounded-pill fs-12 fw-bold">
											{{ $item->dias_mora }} días (Crítico)
										</span>
									@endif
								</td>
								<td class="py-3 px-3 border-bottom text-end fs-14 fw-bold text-danger">
									{{ $simbolo }} {{ number_format($item->saldo_pendiente, 2) }}
								</td>
								<td class="py-3 px-3 border-bottom text-center">
									<a href="{{ url('/gestion-de-cobranzas/' . $idopcion . '?buscar=' . $item->cliente_dni) }}"
										class="btn btn-outline-primary btn-sm rounded-pill px-3 fs-12">
										<i class="ri-hand-coin-line me-1"></i> Ir a Cobrar
									</a>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center py-5 text-muted">
									<i class="ri-checkbox-circle-fill text-success fs-36 d-block mb-2"></i>
									<h5 class="text-success fw-bold">¡Excelente!</h5>
									<p class="mb-0 text-muted">No existen clientes con cuotas en estado de morosidad actualmente.</p>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
