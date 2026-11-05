@extends('layouts.app')

@section('title', 'Detalle de Contrato - ' . $venta->codigo_contrato)

@section('page-title', 'Ventas y Cobranzas')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Contrato: {{ $venta->codigo_contrato }}</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/gestion-de-ventas/'.$idopcion) }}">Ventas</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Cronograma y Estado de Cuenta
			</li>
		</ol>
	</div>
@endsection

@section('content')
	@php
		$simbolo = ($venta->proyecto && $venta->proyecto->moneda === 'USD') ? '$' : 'S/';
		$pagado = $venta->monto_total_pagado;
		$saldo = $venta->saldo_pendiente_total;
		$pct = $venta->precio_final > 0 ? round(($pagado / $venta->precio_final) * 100, 1) : 0;
	@endphp

	<!-- CABECERA RESUMEN -->
	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-3 border-bottom">
				<div>
					<span class="badge bg-primary bg-opacity-10 text-primary fs-14 px-3 py-1 rounded-pill font-monospace fw-bold mb-1">
						CONTRATO {{ $venta->codigo_contrato }}
					</span>
					<h4 class="mb-0 fw-bold text-dark mt-1">{{ $venta->cliente->nombre_completo ?? '' }}</h4>
					<span class="text-muted fs-13">
						{{ $venta->proyecto->nombre ?? '' }} - {{ $venta->lote->manzana->nombre ?? 'Mz' }} Lote {{ $venta->lote->numero_lote ?? '' }}
					</span>
				</div>
				<div class="d-flex gap-2">
					<a href="{{ url('/imprimir-contrato/' . $idopcion . '/' . \App\Facades\Hashids::encode(intval(substr($venta->id, 4)))) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
						<i class="ri-printer-line me-1"></i> Imprimir Contrato
					</a>
				</div>
			</div>

			<!-- BARRA DE PROGRESO DE PAGO -->
			<div class="mb-4">
				<div class="d-flex justify-content-between align-items-center mb-1">
					<span class="fs-13 fw-semibold text-muted">Progreso de Amortización del Lote:</span>
					<span class="fs-13 fw-bold text-primary">{{ $pct }}% Pagado</span>
				</div>
				<div class="progress" style="height: 12px; border-radius: 6px;">
					<div class="progress-bar bg-success" role="progressbar" style="width: {{ $pct }}%;" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>

			<div class="row g-3">
				<div class="col-lg-3 col-sm-6">
					<div class="p-3 bg-light rounded-3">
						<span class="text-muted fs-12 text-uppercase d-block">Precio Final</span>
						<h5 class="mb-0 fw-bold text-dark mt-1">{{ $simbolo }} {{ number_format($venta->precio_final, 2) }}</h5>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="p-3 bg-light rounded-3">
						<span class="text-muted fs-12 text-uppercase d-block text-success">Total Cobrado</span>
						<h5 class="mb-0 fw-bold text-success mt-1">{{ $simbolo }} {{ number_format($pagado, 2) }}</h5>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="p-3 bg-light rounded-3">
						<span class="text-muted fs-12 text-uppercase d-block text-danger">Saldo Restante</span>
						<h5 class="mb-0 fw-bold text-danger mt-1">{{ $simbolo }} {{ number_format($saldo, 2) }}</h5>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="p-3 bg-light rounded-3">
						<span class="text-muted fs-12 text-uppercase d-block">Cuotas Pagadas</span>
						<h5 class="mb-0 fw-bold text-primary mt-1">{{ $venta->cuotas_pagadas_count }} / {{ $venta->cuotas->count() }} cuotas</h5>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- TABLA CRONOGRAMA DE PAGOS -->
	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
				<div>
					<h5 class="mb-1 fw-bold">Cronograma de Financiamiento Directo</h5>
					<p class="text-muted fs-13 mb-0">Detalle de vencimiento y amortizaciones cuota a cuota</p>
				</div>
			</div>

			<div class="table-responsive" style="border-radius: 12px; overflow-x: auto;">
				<table class="table table-hover align-middle mb-0" style="border-collapse: collapse; min-width: 950px;">
					<thead>
						<tr style="background-color: #f7f9fc;">
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3">Cuota</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3">Descripción</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-center">Vencimiento</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-end">Monto Cuota</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-end">Pagado</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-end">Saldo</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-center">Estado</th>
							<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-center">Cobranza</th>
						</tr>
					</thead>
					<tbody>
						@foreach($venta->cuotas as $c)
							<tr class="transition-all" style="border-bottom: 1px solid #f0f4fa;">
								<td class="py-3 px-3 font-monospace fw-bold fs-13 text-primary">
									{{ $c->numero_cuota == 0 ? 'Inicial' : 'Cuota #' . $c->numero_cuota }}
								</td>
								<td class="py-3 px-3 fs-13 text-dark fw-medium">{{ $c->descripcion }}</td>
								<td class="py-3 px-3 text-center fs-13 text-muted">
									{{ date('d/m/Y', strtotime($c->fecha_vencimiento)) }}
								</td>
								<td class="py-3 px-3 text-end fw-semibold fs-14 text-dark">
									{{ $simbolo }} {{ number_format($c->monto_cuota, 2) }}
								</td>
								<td class="py-3 px-3 text-end text-success fw-bold fs-14">
									{{ $simbolo }} {{ number_format($c->monto_pagado, 2) }}
								</td>
								<td class="py-3 px-3 text-end {{ $c->saldo_pendiente > 0 ? 'text-danger fw-bold' : 'text-muted' }} fs-14">
									{{ $simbolo }} {{ number_format($c->saldo_pendiente, 2) }}
								</td>
								<td class="py-3 px-3 text-center">
									{!! $c->estado_badge !!}
								</td>
								<td class="py-3 px-3 text-center">
									@if($c->estado !== 'pagado')
										<button type="button" class="btn btn-sm btn-success rounded-pill px-3 py-1 fs-12 btn-pagar-cuota" 
												data-cuota-id="{{ $c->id }}"
												data-cuota-num="{{ $c->numero_cuota }}"
												data-saldo="{{ $c->saldo_pendiente }}"
												data-bs-toggle="modal" data-bs-target="#modalPagarCuota">
											<i class="ri-money-dollar-circle-line me-1"></i> Cobrar
										</button>
									@else
										<div class="d-flex justify-content-center align-items-center gap-2">
											<span class="text-success fs-12 fw-medium"><i class="ri-check-line align-middle"></i> Pagado</span>
											@if($c->pagos && $c->pagos->first())
												<a href="{{ url('/recibo-pago/1CIX00000014/' . \App\Facades\Hashids::encode(intval(substr($c->pagos->first()->id, 4)))) }}"
													target="_blank"
													class="btn btn-sm btn-outline-primary rounded-pill px-2 py-0 fs-11" title="Ver Recibo">
													<i class="ri-printer-line"></i> Recibo
												</a>
											@endif
										</div>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- MODAL COBRAR CUOTA -->
	<div class="modal fade" id="modalPagarCuota" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content border-0 rounded-4 shadow">
				<div class="modal-header border-bottom p-4">
					<h5 class="modal-title fw-bold" id="modalCobroTitulo">Registrar Pago de Cuota</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="{{ url('/registrar-pago-cuota/1CIX00000014') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="cuota_id" id="modal_cuota_id">
					<div class="modal-body p-4">
						<div class="mb-3">
							<label class="form-label fw-semibold">Monto a Pagar (S/) <span class="text-danger">*</span></label>
							<div class="input-icon-wrapper">
								<i class="ri-money-dollar-circle-line input-icon text-success"></i>
								<input type="number" step="0.01" min="0.01" class="form-control ps-5 form-control-lg fw-bold text-success fs-18" name="monto_pagar" id="modal_monto_pagar" required>
							</div>
						</div>

						<div class="row">
							<div class="col-6 mb-3">
								<label class="form-label fw-semibold">Mora (S/)</label>
								<div class="input-icon-wrapper">
									<i class="ri-alarm-warning-line input-icon text-danger"></i>
									<input type="number" step="0.01" min="0" class="form-control ps-5" name="mora" value="0.00">
								</div>
							</div>
							<div class="col-6 mb-3">
								<label class="form-label fw-semibold">Fecha de Pago <span class="text-danger">*</span></label>
								<div class="input-icon-wrapper">
									<i class="ri-calendar-line input-icon"></i>
									<input type="date" class="form-control ps-5" name="fecha_pago" value="{{ date('Y-m-d') }}" required>
								</div>
							</div>
						</div>

						<div class="mb-3">
							<label class="form-label fw-semibold">Medio de Pago <span class="text-danger">*</span></label>
							<div class="input-icon-wrapper">
								<i class="ri-bank-card-line input-icon"></i>
								<select name="metodo_pago" class="form-select ps-5" required>
									<option value="transferencia">Transferencia Bancaria</option>
									<option value="deposito">Depósito Bancario</option>
									<option value="efectivo">Efectivo en Caja</option>
									<option value="yape">Yape / Plin</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-6 mb-3">
								<label class="form-label fw-semibold">Banco Destino</label>
								<div class="input-icon-wrapper">
									<i class="ri-bank-line input-icon"></i>
									<input type="text" class="form-control ps-5" name="banco_destino" placeholder="Ej: BCP">
								</div>
							</div>
							<div class="col-6 mb-3">
								<label class="form-label fw-semibold">N° Operación</label>
								<div class="input-icon-wrapper">
									<i class="ri-hashtag input-icon"></i>
									<input type="text" class="form-control ps-5" name="numero_operacion" placeholder="Ej: 002345">
								</div>
							</div>
						</div>

						<div class="mb-3">
							<label class="form-label fw-semibold">Voucher / Comprobante</label>
							<div class="input-icon-wrapper">
								<i class="ri-attachment-line input-icon"></i>
								<input type="file" class="form-control ps-5" name="voucher_foto" accept="image/*,.pdf">
							</div>
						</div>
					</div>
					<div class="modal-footer border-top p-3">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary px-4">Guardar Pago y Emitir Recibo</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
	$('.btn-pagar-cuota').on('click', function() {
		var id = $(this).data('cuota-id');
		var num = $(this).data('cuota-num');
		var saldo = $(this).data('saldo');

		$('#modal_cuota_id').val(id);
		$('#modal_monto_pagar').val(saldo);
		$('#modalCobroTitulo').text(num == 0 ? 'Pago de Cuota Inicial' : 'Pago de Cuota #' + num);
	});
});
</script>
@endpush
