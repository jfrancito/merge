@extends('layouts.app')

@section('title', 'Caja y Cobranzas')

@section('page-title', 'Ventas y Cobranzas')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Caja y Cobranzas de Cuotas</h5>

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
				Cobranzas
			</li>
		</ol>
	</div>
@endsection

@push('styles')
	<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
@endpush

@section('content')
	<div class="row mb-4">
		<div class="col-12 col-md-4 mb-3 mb-md-0">
			<div class="card border-0 rounded-3 shadow-sm p-3 bg-white border-start border-4 border-warning">
				<div class="d-flex align-items-center gap-3">
					<div class="rounded-circle bg-warning bg-opacity-10 p-3 text-warning">
						<i class="ri-time-line fs-24"></i>
					</div>
					<div>
						<div class="text-muted fs-12 fw-medium text-uppercase">Cuotas Pendientes</div>
						<h4 class="mb-0 fw-bold text-dark">{{ $cuotas->where('estado', '!=', 'pagado')->count() }} cuotas</h4>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4 mb-3 mb-md-0">
			<div class="card border-0 rounded-3 shadow-sm p-3 bg-white border-start border-4 border-danger">
				<div class="d-flex align-items-center gap-3">
					<div class="rounded-circle bg-danger bg-opacity-10 p-3 text-danger">
						<i class="ri-alarm-warning-line fs-24"></i>
					</div>
					<div>
						<div class="text-muted fs-12 fw-medium text-uppercase">Cuotas Vencidas</div>
						<h4 class="mb-0 fw-bold text-danger">
							{{ $cuotas->where('estado', '!=', 'pagado')->where('fecha_vencimiento', '<', date('Y-m-d'))->count() }} cuotas
						</h4>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="card border-0 rounded-3 shadow-sm p-3 bg-white border-start border-4 border-success">
				<div class="d-flex align-items-center gap-3">
					<div class="rounded-circle bg-success bg-opacity-10 p-3 text-success">
						<i class="ri-checkbox-circle-line fs-24"></i>
					</div>
					<div>
						<div class="text-muted fs-12 fw-medium text-uppercase">Pagos Recientes</div>
						<h4 class="mb-0 fw-bold text-success">{{ $pagosRecientes->count() }} operaciones</h4>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
				<div>
					<h3 class="mb-1">Gestión de Cobranzas e Ingresos</h3>
					<p class="text-muted fs-14 mb-0">Registre pagos de cuotas ordinarias, cuotas iniciales y emita recibos de cobro</p>
				</div>
				<div class="d-flex flex-wrap gap-2">
					<div class="btn-group" role="group">
						<a href="{{ url('/gestion-de-cobranzas/' . $idopcion . '?estado=pendiente') }}" class="btn btn-outline-secondary fs-13 py-2 px-3 {{ $estado == 'pendiente' ? 'active fw-bold' : '' }}">
							Pendientes
						</a>
						<a href="{{ url('/gestion-de-cobranzas/' . $idopcion . '?estado=vencido') }}" class="btn btn-outline-danger fs-13 py-2 px-3 {{ $estado == 'vencido' ? 'active fw-bold' : '' }}">
							Vencidas
						</a>
						<a href="{{ url('/gestion-de-cobranzas/' . $idopcion . '?estado=pagado') }}" class="btn btn-outline-success fs-13 py-2 px-3 {{ $estado == 'pagado' ? 'active fw-bold' : '' }}">
							Pagadas
						</a>
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

			<!-- Nav tabs -->
			<ul class="nav nav-tabs mb-4 border-bottom" id="cobranzasTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active fw-medium fs-14 py-2 px-3" id="cuotas-tab" data-bs-toggle="tab" data-bs-target="#cuotas-pane" type="button" role="tab">
						<i class="ri-file-list-3-line me-1"></i> Cronograma de Cuotas ({{ $cuotas->count() }})
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link fw-medium fs-14 py-2 px-3" id="historial-tab" data-bs-toggle="tab" data-bs-target="#historial-pane" type="button" role="tab">
						<i class="ri-history-line me-1"></i> Historial de Recibos Emitidos ({{ $pagosRecientes->count() }})
					</button>
				</li>
			</ul>

			<div class="tab-content" id="cobranzasTabContent">
				<!-- Tab 1: Cuotas -->
				<div class="tab-pane fade show active" id="cuotas-pane" role="tabpanel">
					<div class="table-responsive" style="border-radius: 12px; overflow-x: auto; padding-bottom: 20px;">
						<table class="table table-hover align-middle mb-0" id="cuotasTable" style="border-collapse: collapse; min-width: 1000px;">
							<thead>
								<tr style="background-color: #f7f9fc;">
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3">Contrato & Lote</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3">Cliente</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-center">N° Cuota</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-center">Vencimiento</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-end">Monto Cuota</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-end">Saldo Pendiente</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-center">Estado</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-center">Acción</th>
								</tr>
							</thead>
							<tbody>
								@forelse($cuotas as $item)
									@php
										$simbolo = ($item->proyecto_moneda === 'USD') ? '$' : 'S/';
										$isVencida = ($item->estado != 'pagado' && $item->fecha_vencimiento < date('Y-m-d'));
									@endphp
									<tr class="{{ $isVencida ? 'table-danger bg-opacity-25' : '' }}">
										<td class="py-3 px-3 border-bottom fs-13">
											<div class="font-monospace fw-bold text-primary">{{ $item->codigo_contrato }}</div>
											<div class="text-dark fw-medium">{{ $item->proyecto_nombre }}</div>
											<span class="text-muted fs-12">{{ $item->manzana_nombre }} - Lote {{ $item->numero_lote }}</span>
										</td>
										<td class="py-3 px-3 border-bottom fs-13">
											<div class="fw-semibold text-dark">{{ $item->nombre_razon_social }} {{ $item->cliente_apellidos }}</div>
											<div class="text-muted fs-12">DNI: {{ $item->cliente_dni }}</div>
											@if($item->cliente_telefono)
												<div class="text-muted fs-11">
													<a href="https://wa.me/51{{ preg_replace('/[^0-9]/', '', $item->cliente_telefono) }}" target="_blank" class="text-success text-decoration-none">
														<i class="ri-whatsapp-line"></i> {{ $item->cliente_telefono }}
													</a>
												</div>
											@endif
										</td>
										<td class="py-3 px-3 border-bottom text-center fs-14">
											@if($item->numero_cuota == 0)
												<span class="badge bg-info bg-opacity-10 text-info fw-bold">Inicial</span>
											@else
												<span class="fw-bold text-dark"># {{ $item->numero_cuota }}</span>
											@endif
										</td>
										<td class="py-3 px-3 border-bottom text-center fs-13">
											<div class="{{ $isVencida ? 'text-danger fw-bold' : 'text-muted' }}">
												{{ date('d/m/Y', strtotime($item->fecha_vencimiento)) }}
											</div>
											@if($isVencida)
												@php
													$diasMora = (strtotime(date('Y-m-d')) - strtotime($item->fecha_vencimiento)) / 86400;
												@endphp
												<span class="badge bg-danger text-white fs-10 px-2 py-0">+{{ intval($diasMora) }} días</span>
											@endif
										</td>
										<td class="py-3 px-3 border-bottom text-end fs-13 text-dark fw-medium">
											{{ $simbolo }} {{ number_format($item->monto_cuota, 2) }}
										</td>
										<td class="py-3 px-3 border-bottom text-end fs-14 fw-bold {{ $item->saldo_pendiente > 0 ? 'text-danger' : 'text-success' }}">
											{{ $simbolo }} {{ number_format($item->saldo_pendiente, 2) }}
										</td>
										<td class="py-3 px-3 border-bottom text-center">
											@if($item->estado == 'pagado')
												<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fs-12">Pagado</span>
											@elseif($item->estado == 'parcial')
												<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 rounded-pill fs-12">Parcial</span>
											@elseif($isVencida)
												<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill fs-12">Vencido</span>
											@else
												<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 rounded-pill fs-12">Pendiente</span>
											@endif
										</td>
										<td class="py-3 px-3 border-bottom text-center">
											@if($item->estado != 'pagado')
												<button type="button" class="btn btn-sm btn-primary rounded-3 px-3 py-1 fs-12 fw-medium btn-cobrar"
													data-bs-toggle="modal"
													data-bs-target="#modalCobro"
													data-cuota-id="{{ $item->id }}"
													data-contrato="{{ $item->codigo_contrato }}"
													data-cliente="{{ $item->nombre_razon_social }} {{ $item->cliente_apellidos }}"
													data-lote="{{ $item->proyecto_nombre }} - {{ $item->manzana_nombre }} Lote {{ $item->numero_lote }}"
													data-num-cuota="{{ $item->numero_cuota == 0 ? 'Inicial' : 'Cuota #' . $item->numero_cuota }}"
													data-saldo="{{ $item->saldo_pendiente }}"
													data-simbolo="{{ $simbolo }}">
													<i class="ri-hand-coin-line me-1"></i> Cobrar
												</button>
											@else
												<span class="text-success fs-13"><i class="ri-check-double-line"></i> Cancelado</span>
											@endif
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="8" class="text-center py-5 text-muted">
											<i class="ri-inbox-line fs-32 d-block mb-2 text-secondary"></i>
											No se encontraron cuotas para los filtros seleccionados
										</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>

				<!-- Tab 2: Historial Pagos -->
				<div class="tab-pane fade" id="historial-pane" role="tabpanel">
					<div class="table-responsive" style="border-radius: 12px; overflow-x: auto; padding-bottom: 20px;">
						<table class="table table-hover align-middle mb-0" id="pagosTable" style="border-collapse: collapse; min-width: 900px;">
							<thead>
								<tr style="background-color: #f7f9fc;">
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3">Recibo N°</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3">Fecha Pago</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3">Cliente</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3">Detalle Cuota</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3">Método / Op.</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-end">Monto Pagado</th>
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold py-3 px-3 text-center">Acciones</th>
								</tr>
							</thead>
							<tbody>
								@forelse($pagosRecientes as $pago)
									<tr>
										<td class="py-3 px-3 border-bottom font-monospace fw-bold text-primary fs-13">
											{{ $pago->codigo_recibo }}
										</td>
										<td class="py-3 px-3 border-bottom fs-13 text-dark">
											{{ date('d/m/Y', strtotime($pago->fecha_pago)) }}
										</td>
										<td class="py-3 px-3 border-bottom fs-13 text-dark fw-medium">
											{{ $pago->venta && $pago->venta->cliente ? $pago->venta->cliente->nombre_completo : 'Cliente' }}
										</td>
										<td class="py-3 px-3 border-bottom fs-12 text-muted">
											@if($pago->cuota)
												{{ $pago->cuota->numero_cuota == 0 ? 'Cuota Inicial' : 'Cuota #' . $pago->cuota->numero_cuota }}
											@endif
											<span class="d-block text-dark fw-semibold">
												{{ $pago->venta && $pago->venta->lote && $pago->venta->lote->manzana ? $pago->venta->lote->manzana->nombre : '' }}
												Lote {{ $pago->venta && $pago->venta->lote ? $pago->venta->lote->numero_lote : '' }}
											</span>
										</td>
										<td class="py-3 px-3 border-bottom fs-12">
											<span class="badge bg-light text-dark border px-2 py-1 text-uppercase">{{ $pago->metodo_pago }}</span>
											@if($pago->numero_operacion)
												<div class="text-muted fs-11 mt-1">Op: {{ $pago->numero_operacion }}</div>
											@endif
										</td>
										<td class="py-3 px-3 border-bottom text-end fs-14 fw-bold text-success">
											S/ {{ number_format($pago->monto_pagado, 2) }}
											@if($pago->mora_pagada > 0)
												<div class="text-danger fs-11 fw-normal">+ Mora: S/ {{ number_format($pago->mora_pagada, 2) }}</div>
											@endif
										</td>
										<td class="py-3 px-3 border-bottom text-center">
											<a href="{{ url('/recibo-pago/' . $idopcion . '/' . \App\Facades\Hashids::encode(intval(substr($pago->id, 4)))) }}"
												target="_blank"
												class="btn btn-outline-primary btn-sm rounded-pill px-3 fs-12">
												<i class="ri-printer-line me-1"></i> Imprimir Recibo
											</a>
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="7" class="text-center py-4 text-muted">No se registran pagos recientes</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Registrar Pago de Cuota -->
	<div class="modal fade" id="modalCobro" tabindex="-1" aria-labelledby="modalCobroLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content border-0 shadow-lg rounded-4">
				<form action="{{ url('/registrar-pago-cuota/' . $idopcion) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="cuota_id" id="modal_cuota_id">

					<div class="modal-header bg-light border-0 py-3 px-4 rounded-top-4">
						<h5 class="modal-title fw-bold text-dark" id="modalCobroLabel">
							<i class="ri-secure-payment-line text-primary me-2"></i> Registrar Pago de Cuota
						</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>

					<div class="modal-body p-4">
						<!-- Info Card -->
						<div class="bg-light rounded-3 p-3 mb-3 border">
							<div class="d-flex justify-content-between mb-1">
								<span class="text-muted fs-12">Contrato:</span>
								<span class="fw-bold font-monospace text-primary" id="lbl_contrato"></span>
							</div>
							<div class="d-flex justify-content-between mb-1">
								<span class="text-muted fs-12">Cliente:</span>
								<span class="fw-semibold text-dark" id="lbl_cliente"></span>
							</div>
							<div class="d-flex justify-content-between mb-1">
								<span class="text-muted fs-12">Lote:</span>
								<span class="text-dark" id="lbl_lote"></span>
							</div>
							<div class="d-flex justify-content-between">
								<span class="text-muted fs-12">Concepto:</span>
								<span class="badge bg-primary text-white" id="lbl_num_cuota"></span>
							</div>
						</div>

						<div class="row g-3">
							<div class="col-6">
								<label class="form-label fs-13 fw-semibold">Monto a Pagar <span class="text-danger">*</span></label>
								<div class="input-icon-wrapper">
									<i class="ri-money-dollar-circle-line input-icon text-success"></i>
									<input type="number" step="0.01" min="0.01" class="form-control ps-5 fw-bold fs-16 text-success" name="monto_pagar" id="txt_monto_pagar" required>
								</div>
							</div>

							<div class="col-6">
								<label class="form-label fs-13 fw-semibold">Interés Moratorio (Mora)</label>
								<div class="input-icon-wrapper">
									<i class="ri-alarm-warning-line input-icon text-danger"></i>
									<input type="number" step="0.01" min="0" class="form-control ps-5 text-danger" name="mora" value="0.00">
								</div>
							</div>

							<div class="col-6">
								<label class="form-label fs-13 fw-semibold">Fecha de Pago <span class="text-danger">*</span></label>
								<div class="input-icon-wrapper">
									<i class="ri-calendar-line input-icon"></i>
									<input type="date" class="form-control ps-5" name="fecha_pago" value="{{ date('Y-m-d') }}" required>
								</div>
							</div>

							<div class="col-6">
								<label class="form-label fs-13 fw-semibold">Método de Pago <span class="text-danger">*</span></label>
								<div class="input-icon-wrapper">
									<i class="ri-bank-card-line input-icon"></i>
									<select class="form-select ps-5" name="metodo_pago" required>
										<option value="transferencia">Transferencia Bancaria</option>
										<option value="deposito">Depósito en Ventanilla</option>
										<option value="efectivo">Efectivo en Oficina</option>
										<option value="yape">Yape / Plin</option>
										<option value="tarjeta">Tarjeta Débito/Crédito</option>
									</select>
								</div>
							</div>

							<div class="col-6">
								<label class="form-label fs-13 fw-semibold">Banco Destino</label>
								<div class="input-icon-wrapper">
									<i class="ri-bank-line input-icon"></i>
									<select class="form-select ps-5" name="banco_destino">
										<option value="">-- No Aplica / Directo --</option>
										<option value="BCP">BCP - Banco de Crédito</option>
										<option value="BBVA">BBVA Continental</option>
										<option value="Interbank">Interbank</option>
										<option value="Scotiabank">Scotiabank</option>
										<option value="Banco de la Nacion">Banco de la Nación</option>
									</select>
								</div>
							</div>

							<div class="col-6">
								<label class="form-label fs-13 fw-semibold">N° Operación / Transacción</label>
								<div class="input-icon-wrapper">
									<i class="ri-hashtag input-icon"></i>
									<input type="text" class="form-control ps-5 font-monospace" name="numero_operacion" placeholder="Ej: 00482910">
								</div>
							</div>

							<div class="col-12">
								<label class="form-label fs-13 fw-semibold">Voucher / Comprobante (Opcional)</label>
								<div class="input-icon-wrapper">
									<i class="ri-attachment-line input-icon"></i>
									<input type="file" class="form-control ps-5" name="voucher_foto" accept="image/*,.pdf">
								</div>
							</div>

							<div class="col-12">
								<label class="form-label fs-13 fw-semibold">Observaciones</label>
								<div class="input-icon-wrapper">
									<i class="ri-file-text-line input-icon" style="top: 20px;"></i>
									<textarea class="form-control ps-5" name="observaciones" rows="2" placeholder="Nota adicional..."></textarea>
								</div>
							</div>
						</div>
					</div>

					<div class="modal-footer border-0 p-4 pt-0">
						<button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary rounded-3 px-4 fw-medium">
							<i class="ri-check-line me-1"></i> Confirmar y Emitir Recibo
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const btnsCobrar = document.querySelectorAll('.btn-cobrar');
		btnsCobrar.forEach(btn => {
			btn.addEventListener('click', function() {
				document.getElementById('modal_cuota_id').value = this.dataset.cuotaId;
				document.getElementById('lbl_contrato').textContent = this.dataset.contrato;
				document.getElementById('lbl_cliente').textContent = this.dataset.cliente;
				document.getElementById('lbl_lote').textContent = this.dataset.lote;
				document.getElementById('lbl_num_cuota').textContent = this.dataset.numCuota;
				document.getElementById('lbl_simbolo').textContent = this.dataset.simbolo;
				document.getElementById('txt_monto_pagar').value = parseFloat(this.dataset.saldo).toFixed(2);
			});
		});
	});
</script>
@endpush
