<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Recibo de Cobranza {{ $pago->codigo_recibo }} - Loteame</title>
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
	<style>
		body {
			background-color: #f4f7f6;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			color: #333;
		}
		.recibo-card {
			max-width: 800px;
			margin: 30px auto;
			background: #fff;
			border-radius: 12px;
			box-shadow: 0 10px 30px rgba(0,0,0,0.08);
			padding: 40px;
		}
		.recibo-header {
			border-bottom: 2px dashed #e2e8f0;
			padding-bottom: 20px;
			margin-bottom: 25px;
		}
		.recibo-numero-badge {
			background-color: #eef2ff;
			border: 1px solid #c7d2fe;
			color: #3730a3;
			padding: 10px 18px;
			border-radius: 8px;
			text-align: right;
		}
		.firmas-section {
			margin-top: 50px;
			padding-top: 20px;
		}
		.linea-firma {
			border-top: 1px solid #718096;
			width: 220px;
			margin: 0 auto;
			padding-top: 8px;
		}
		@media print {
			body {
				background: #fff;
				margin: 0;
				padding: 0;
			}
			.recibo-card {
				box-shadow: none;
				border: 1px solid #ccc;
				margin: 0;
				padding: 20px;
				max-width: 100%;
			}
			.no-print {
				display: none !important;
			}
		}
	</style>
</head>
<body>

	<div class="no-print container text-center my-3">
		<button onclick="window.print()" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm me-2">
			<i class="ri-printer-line me-1"></i> Imprimir Recibo
		</button>
		<button onclick="window.close()" class="btn btn-secondary px-4 py-2 rounded-pill shadow-sm">
			<i class="ri-close-line me-1"></i> Cerrar Ventana
		</button>
	</div>

	<div class="recibo-card">
		<!-- Header -->
		<div class="recibo-header row align-items-center">
			<div class="col-7">
				<div class="d-flex align-items-center gap-3">
					<img src="{{ asset('assets/images/loteame/logo.png') }}" alt="Logo" style="height: 50px; object-fit: contain;" onerror="this.style.display='none'">
					<div>
						<h4 class="mb-0 fw-bold text-primary">LOTEAME INMOBILIARIA</h4>
						<p class="text-muted fs-12 mb-0">Gestión de Proyectos y Desarrollo Urbano</p>
						<p class="text-muted fs-11 mb-0">RUC: {{ session('empresa')->ruc ?? '20608945123' }}</p>
					</div>
				</div>
			</div>
			<div class="col-5">
				<div class="recibo-numero-badge">
					<span class="fs-12 text-uppercase fw-semibold d-block text-secondary">Recibo de Caja</span>
					<span class="fs-18 fw-bold font-monospace">{{ $pago->codigo_recibo }}</span>
					<span class="d-block fs-11 text-muted">Fecha: {{ date('d/m/Y', strtotime($pago->fecha_pago)) }}</span>
				</div>
			</div>
		</div>

		<!-- Cliente & Lote Info -->
		<div class="row g-3 mb-4">
			<div class="col-6">
				<div class="p-3 bg-light rounded-3 h-100">
					<h6 class="text-uppercase fs-12 fw-bold text-secondary mb-2">Datos del Pagador / Cliente</h6>
					<div class="fw-bold text-dark fs-15">{{ $pago->venta && $pago->venta->cliente ? $pago->venta->cliente->nombre_completo : 'N/A' }}</div>
					<div class="text-muted fs-13">Doc. Identidad: <strong>{{ $pago->venta && $pago->venta->cliente ? $pago->venta->cliente->numero_documento : 'N/A' }}</strong></div>
					<div class="text-muted fs-13">Teléfono: {{ $pago->venta && $pago->venta->cliente ? $pago->venta->cliente->telefono : '-' }}</div>
					<div class="text-muted fs-13">Dirección: {{ $pago->venta && $pago->venta->cliente ? $pago->venta->cliente->direccion : '-' }}</div>
				</div>
			</div>

			<div class="col-6">
				<div class="p-3 bg-light rounded-3 h-100">
					<h6 class="text-uppercase fs-12 fw-bold text-secondary mb-2">Datos del Inmueble & Venta</h6>
					<div class="fw-bold text-dark fs-15">{{ $pago->venta && $pago->venta->proyecto ? $pago->venta->proyecto->nombre : 'Proyecto' }}</div>
					<div class="text-primary fw-semibold fs-13">
						{{ $pago->venta && $pago->venta->lote && $pago->venta->lote->manzana ? $pago->venta->lote->manzana->nombre : 'Manzana' }}
						- LOTE {{ $pago->venta && $pago->venta->lote ? $pago->venta->lote->numero_lote : '' }}
					</div>
					<div class="text-muted fs-13">Contrato N°: <strong class="font-monospace text-dark">{{ $pago->venta ? $pago->venta->codigo_contrato : '-' }}</strong></div>
					<div class="text-muted fs-13">Moneda: {{ $pago->venta && $pago->venta->proyecto ? $pago->venta->proyecto->moneda : 'PEN' }}</div>
				</div>
			</div>
		</div>

		<!-- Detalle del Pago Table -->
		<div class="table-responsive mb-4">
			<table class="table table-bordered align-middle">
				<thead class="table-light">
					<tr>
						<th class="fs-12 text-uppercase text-secondary">Concepto</th>
						<th class="fs-12 text-uppercase text-secondary text-center">F. Vencimiento</th>
						<th class="fs-12 text-uppercase text-secondary text-center">Forma de Pago</th>
						<th class="fs-12 text-uppercase text-secondary text-end">Mora</th>
						<th class="fs-12 text-uppercase text-secondary text-end">Monto Cancelado</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<div class="fw-bold text-dark">
								@if($pago->cuota)
									{{ $pago->cuota->numero_cuota == 0 ? 'Pago de Cuota Inicial' : 'Pago de Cuota Ordinaria #' . $pago->cuota->numero_cuota }}
								@else
									Amortización a Cuenta de Lote
								@endif
							</div>
							@if($pago->observaciones)
								<small class="text-muted d-block">{{ $pago->observaciones }}</small>
							@endif
						</td>
						<td class="text-center text-muted fs-13">
							{{ $pago->cuota ? date('d/m/Y', strtotime($pago->cuota->fecha_vencimiento)) : '-' }}
						</td>
						<td class="text-center fs-13">
							<span class="text-uppercase fw-semibold">{{ $pago->metodo_pago }}</span>
							@if($pago->numero_operacion)
								<span class="d-block text-muted fs-11 font-monospace">Op: {{ $pago->numero_operacion }}</span>
							@endif
							@if($pago->banco_destino)
								<span class="d-block text-secondary fs-11">{{ $pago->banco_destino }}</span>
							@endif
						</td>
						<td class="text-end text-danger fs-13">
							S/ {{ number_format($pago->mora_pagada, 2) }}
						</td>
						<td class="text-end fw-bold text-success fs-15">
							S/ {{ number_format($pago->monto_pagado, 2) }}
						</td>
					</tr>
				</tbody>
				<tfoot class="table-light">
					<tr>
						<th colspan="4" class="text-end fs-13 text-uppercase">Total Recibido:</th>
						<th class="text-end fs-16 fw-bold text-primary">
							S/ {{ number_format($pago->monto_pagado + $pago->mora_pagada, 2) }}
						</th>
					</tr>
				</tfoot>
			</table>
		</div>

		<!-- Saldo Restante -->
		@if($pago->cuota)
			<div class="p-3 bg-light rounded-3 mb-4 border d-flex justify-content-between align-items-center">
				<span class="fs-13 text-muted">Saldo restante de esta cuota:</span>
				<span class="fs-14 fw-bold {{ $pago->cuota->saldo_pendiente > 0 ? 'text-danger' : 'text-success' }}">
					{{ $pago->cuota->saldo_pendiente > 0 ? 'S/ ' . number_format($pago->cuota->saldo_pendiente, 2) : 'CUOTA TOTALMENTE CANCELADA' }}
				</span>
			</div>
		@endif

		<!-- Firmas -->
		<div class="row firmas-section text-center">
			<div class="col-6">
				<div class="linea-firma">
					<div class="fw-semibold fs-13 text-dark">LOTEAME INMOBILIARIA</div>
					<div class="text-muted fs-11">Caja y Recaudaciones</div>
				</div>
			</div>
			<div class="col-6">
				<div class="linea-firma">
					<div class="fw-semibold fs-13 text-dark">FIRMA DEL CLIENTE</div>
					<div class="text-muted fs-11">DNI: {{ $pago->venta && $pago->venta->cliente ? $pago->venta->cliente->numero_documento : '' }}</div>
				</div>
			</div>
		</div>

		<div class="mt-4 pt-3 border-top text-center text-muted fs-11">
			Este documento certifica la recepción dineraria por el concepto indicado. Conserve este comprobante para cualquier trámite o liquidación futura.
		</div>
	</div>

</body>
</html>
