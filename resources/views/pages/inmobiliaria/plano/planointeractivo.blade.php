@extends('layouts.app')

@section('title', 'Plano Interactivo')

@section('page-title', 'Catálogo de Lotes')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Plano Interactivo de Lotes</h5>

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
				Plano Interactivo
			</li>
		</ol>
	</div>
@endsection

@push('styles')
<style>
	.lote-tile {
		border-radius: 10px;
		padding: 12px 8px;
		text-align: center;
		cursor: pointer;
		transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
		position: relative;
		border: 2px solid transparent;
		user-select: none;
	}
	.lote-tile:hover {
		transform: translateY(-4px) scale(1.03);
		box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
		z-index: 5;
	}
	/* Estados */
	.lote-disponible {
		background-color: #ecfdf5;
		border-color: #10b981;
		color: #065f46;
	}
	.lote-disponible:hover {
		background-color: #d1fae5;
		box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25);
	}
	.lote-separado, .lote-reservado {
		background-color: #fffbeb;
		border-color: #f59e0b;
		color: #92400e;
	}
	.lote-separado:hover, .lote-reservado:hover {
		background-color: #fef3c7;
		box-shadow: 0 8px 20px rgba(245, 158, 11, 0.25);
	}
	.lote-vendido {
		background-color: #fef2f2;
		border-color: #ef4444;
		color: #991b1b;
	}
	.lote-vendido:hover {
		background-color: #fee2e2;
		box-shadow: 0 8px 20px rgba(239, 68, 68, 0.25);
	}
	.lote-bloqueado {
		background-color: #f1f5f9;
		border-color: #94a3b8;
		color: #475569;
	}
	.status-dot {
		width: 10px;
		height: 10px;
		border-radius: 50%;
		display: inline-block;
	}
</style>
@endpush

@section('content')
	@php
		$totalLotes = 0;
		$totalDisp = 0;
		$totalRes = 0;
		$totalVend = 0;
		$totalBloq = 0;

		foreach($manzanas as $mz) {
			foreach($mz->lotes as $lt) {
				$totalLotes++;
				if($lt->estado == 'disponible') $totalDisp++;
				elseif($lt->estado == 'separado' || $lt->estado == 'reservado') $totalRes++;
				elseif($lt->estado == 'vendido') $totalVend++;
				else $totalBloq++;
			}
		}

		$porcVendido = $totalLotes > 0 ? round((($totalVend + $totalRes) / $totalLotes) * 100, 1) : 0;
	@endphp

	<!-- Top Control Bar -->
	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="row align-items-center g-3">
				<div class="col-12 col-md-5">
					<h3 class="mb-1">Plano y Mapa de Disponibilidad</h3>
					<p class="text-muted fs-14 mb-0">Vista gráfica en tiempo real por manzanas y parcelas</p>
				</div>
				<div class="col-12 col-md-7">
					<form method="GET" action="{{ url('/plano-interactivo/' . $idopcion) }}" class="d-flex gap-2 justify-content-md-end align-items-center flex-wrap">
						<label class="fs-13 fw-semibold text-secondary mb-0">Seleccionar Proyecto:</label>
						<select name="proyecto_id" class="form-select w-auto fw-bold text-primary" onchange="this.form.submit()">
							@foreach($proyectos as $p)
								<option value="{{ $p->id }}" {{ $proyecto_id == $p->id ? 'selected' : '' }}>
									{{ $p->nombre }} ({{ $p->ubicacion }})
								</option>
							@endforeach
						</select>
					</form>
				</div>
			</div>

			<hr class="my-3 text-muted opacity-25">

			<!-- KPI Cards -->
			<div class="row g-3 align-items-center">
				<div class="col-6 col-sm-4 col-md-2">
					<div class="p-2 border rounded-3 text-center bg-light">
						<span class="fs-11 text-muted text-uppercase fw-semibold d-block">Total Lotes</span>
						<span class="fs-18 fw-bold text-dark">{{ $totalLotes }}</span>
					</div>
				</div>
				<div class="col-6 col-sm-4 col-md-2">
					<div class="p-2 border rounded-3 text-center" style="background-color: #ecfdf5; border-color: #10b981 !important;">
						<span class="fs-11 text-success text-uppercase fw-semibold d-block">
							<span class="status-dot bg-success me-1"></span> Disponibles
						</span>
						<span class="fs-18 fw-bold text-success">{{ $totalDisp }}</span>
					</div>
				</div>
				<div class="col-6 col-sm-4 col-md-2">
					<div class="p-2 border rounded-3 text-center" style="background-color: #fffbeb; border-color: #f59e0b !important;">
						<span class="fs-11 text-warning text-uppercase fw-semibold d-block">
							<span class="status-dot bg-warning me-1"></span> Reservados
						</span>
						<span class="fs-18 fw-bold text-warning">{{ $totalRes }}</span>
					</div>
				</div>
				<div class="col-6 col-sm-4 col-md-2">
					<div class="p-2 border rounded-3 text-center" style="background-color: #fef2f2; border-color: #ef4444 !important;">
						<span class="fs-11 text-danger text-uppercase fw-semibold d-block">
							<span class="status-dot bg-danger me-1"></span> Vendidos
						</span>
						<span class="fs-18 fw-bold text-danger">{{ $totalVend }}</span>
					</div>
				</div>
				<div class="col-6 col-sm-4 col-md-2">
					<div class="p-2 border rounded-3 text-center bg-light">
						<span class="fs-11 text-secondary text-uppercase fw-semibold d-block">
							<span class="status-dot bg-secondary me-1"></span> Bloqueados
						</span>
						<span class="fs-18 fw-bold text-secondary">{{ $totalBloq }}</span>
					</div>
				</div>
				<div class="col-6 col-sm-4 col-md-2">
					<div class="p-2 border rounded-3 text-center bg-primary bg-opacity-10 border-primary border-opacity-25">
						<span class="fs-11 text-primary text-uppercase fw-semibold d-block">Colocación</span>
						<span class="fs-18 fw-bold text-primary">{{ $porcVendido }}%</span>
					</div>
				</div>
			</div>

			<!-- Filter buttons -->
			<div class="d-flex flex-wrap gap-2 mt-3 pt-2">
				<span class="fs-13 fw-semibold text-secondary align-self-center me-2">Filtrar vista:</span>
				<button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 filter-btn active" data-filter="all">Todos ({{ $totalLotes }})</button>
				<button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 filter-btn" data-filter="disponible">🟢 Disponibles ({{ $totalDisp }})</button>
				<button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 filter-btn" data-filter="separado">🟡 Reservados ({{ $totalRes }})</button>
				<button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 filter-btn" data-filter="vendido">🔴 Vendidos ({{ $totalVend }})</button>
			</div>
		</div>
	</div>

	<!-- Manzanas Grid -->
	@if(_count($manzanas) > 0)
		@foreach($manzanas as $mz)
			<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm manzana-card">
				<div class="card-header bg-light border-0 py-3 px-4 rounded-top-3 d-flex justify-content-between align-items-center">
					<div class="d-flex align-items-center gap-2">
						<i class="ri-community-line text-primary fs-20"></i>
						<h5 class="mb-0 fw-bold text-dark">{{ $mz->nombre }}</h5>
						<span class="badge bg-secondary bg-opacity-10 text-secondary fs-12 ms-2">{{ _count($mz->lotes) }} lotes</span>
					</div>
					<div class="text-muted fs-12">
						@if($mz->descripcion)
							<span>{{ $mz->descripcion }}</span>
						@endif
					</div>
				</div>

				<div class="card-body p-4">
					@if(_count($mz->lotes) > 0)
						<div class="row g-3">
							@foreach($mz->lotes as $lt)
								@php
									$simbolo = ($proyectoSeleccionado && $proyectoSeleccionado->moneda === 'USD') ? '$' : 'S/';
									$estadoClase = 'lote-' . $lt->estado;
								@endphp
								<div class="col-6 col-sm-4 col-md-3 col-lg-2 lote-item" data-estado="{{ $lt->estado }}">
									<div class="lote-tile {{ $estadoClase }}"
										onclick="abrirModalLote({{ json_encode($lt) }}, '{{ $mz->nombre }}', '{{ $proyectoSeleccionado ? $proyectoSeleccionado->nombre : '' }}', '{{ $simbolo }}')">
										<div class="fs-15 fw-bold font-monospace">LOTE {{ $lt->numero_lote }}</div>
										<div class="fs-12 fw-medium mt-1">{{ number_format($lt->area_m2, 2) }} m²</div>
										<div class="fs-11 fw-bold mt-1">
											{{ $simbolo }} {{ number_format($lt->precio_venta, 0) }}
										</div>
										<span class="badge rounded-pill mt-2 px-2 py-0 fs-10 text-uppercase"
											style="background: rgba(0,0,0,0.08); color: inherit;">
											{{ $lt->estado }}
										</span>
									</div>
								</div>
							@endforeach
						</div>
					@else
						<div class="text-center py-3 text-muted fs-13">
							Esta manzana aún no tiene lotes registrados.
						</div>
					@endif
				</div>
			</div>
		@endforeach
	@else
		<div class="card bg-white border-0 rounded-3 p-5 text-center shadow-sm">
			<i class="ri-map-pin-line text-secondary fs-48 mb-3"></i>
			<h4 class="text-dark fw-bold">No hay manzanas configuradas para este proyecto</h4>
			<p class="text-muted fs-14">Cree manzanas y cargue lotes desde el módulo de Manzanas o Lotes para visualizarlos aquí.</p>
		</div>
	@endif

	<!-- Modal Ficha Rápida de Lote -->
	<div class="modal fade" id="modalLoteInfo" tabindex="-1" aria-labelledby="modalLoteInfoLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
				<div class="modal-header bg-dark text-white border-0 py-3 px-4" id="modalHeaderBg">
					<div>
						<span class="fs-12 text-uppercase text-white-50 d-block" id="modalLoteSubtitulo">Proyecto - Manzana</span>
						<h4 class="modal-title fw-bold text-white mb-0" id="modalLoteTitulo">Lote 00</h4>
					</div>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body p-4">
					<!-- Estado y Precio -->
					<div class="d-flex justify-content-between align-items-center p-3 rounded-3 mb-3 bg-light border">
						<div>
							<span class="text-muted fs-12 text-uppercase fw-semibold d-block">Estado Actual</span>
							<span class="badge px-3 py-1 fs-13 rounded-pill text-uppercase fw-bold" id="modalLoteBadge">Disponible</span>
						</div>
						<div class="text-end">
							<span class="text-muted fs-12 text-uppercase fw-semibold d-block">Precio de Lista</span>
							<h3 class="mb-0 fw-bold text-primary" id="modalLotePrecio">S/ 0.00</h3>
						</div>
					</div>

					<!-- Medidas y Linderos -->
					<h6 class="text-uppercase fs-12 fw-bold text-secondary mb-2">Dimensiones y Linderos</h6>
					<div class="row g-2 mb-3">
						<div class="col-6">
							<div class="border rounded-2 p-2 text-center bg-white">
								<span class="text-muted fs-11 d-block">Área Total</span>
								<strong class="fs-14 text-dark" id="modalLoteArea">0.00 m²</strong>
							</div>
						</div>
						<div class="col-6">
							<div class="border rounded-2 p-2 text-center bg-white">
								<span class="text-muted fs-11 d-block">Precio por m²</span>
								<strong class="fs-14 text-dark" id="modalLotePrecioM2">S/ 0.00</strong>
							</div>
						</div>
						<div class="col-3">
							<div class="border rounded-2 p-1 text-center bg-light">
								<span class="text-muted fs-10 d-block">Frente</span>
								<span class="fs-12 fw-semibold text-dark" id="modalLoteFrente">-</span>
							</div>
						</div>
						<div class="col-3">
							<div class="border rounded-2 p-1 text-center bg-light">
								<span class="text-muted fs-10 d-block">Fondo</span>
								<span class="fs-12 fw-semibold text-dark" id="modalLoteFondo">-</span>
							</div>
						</div>
						<div class="col-3">
							<div class="border rounded-2 p-1 text-center bg-light">
								<span class="text-muted fs-10 d-block">Izquierda</span>
								<span class="fs-12 fw-semibold text-dark" id="modalLoteIzq">-</span>
							</div>
						</div>
						<div class="col-3">
							<div class="border rounded-2 p-1 text-center bg-light">
								<span class="text-muted fs-10 d-block">Derecha</span>
								<span class="fs-12 fw-semibold text-dark" id="modalLoteDer">-</span>
							</div>
						</div>
					</div>

					<div id="modalLoteObservacionesWrap" class="mb-3 d-none">
						<span class="text-muted fs-11 d-block">Observaciones:</span>
						<p class="fs-12 text-dark bg-light p-2 rounded-2 mb-0" id="modalLoteObservaciones"></p>
					</div>

					<!-- Acciones Dinámicas -->
					<div class="d-grid gap-2 mt-4" id="modalAcciones">
						<!-- Botones inyectados dinámicamente -->
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
<script>
	// Filtros
	document.querySelectorAll('.filter-btn').forEach(btn => {
		btn.addEventListener('click', function() {
			document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active', 'btn-secondary', 'btn-success', 'btn-warning', 'btn-danger'));
			this.classList.add('active');

			const filtro = this.dataset.filter;
			document.querySelectorAll('.lote-item').forEach(item => {
				if(filtro === 'all') {
					item.style.display = 'block';
				} else if(filtro === 'separado') {
					item.style.display = (item.dataset.estado === 'separado' || item.dataset.estado === 'reservado') ? 'block' : 'none';
				} else {
					item.style.display = item.dataset.estado === filtro ? 'block' : 'none';
				}
			});
		});
	});

	// Modal Info Lote
	function abrirModalLote(lote, manzanaNombre, proyectoNombre, simbolo) {
		document.getElementById('modalLoteSubtitulo').textContent = `${proyectoNombre} - ${manzanaNombre}`;
		document.getElementById('modalLoteTitulo').textContent = `LOTE ${lote.numero_lote}`;

		const badge = document.getElementById('modalLoteBadge');
		badge.textContent = lote.estado.toUpperCase();
		badge.className = 'badge px-3 py-1 fs-13 rounded-pill text-uppercase fw-bold ';

		if(lote.estado === 'disponible') {
			badge.classList.add('bg-success');
		} else if(lote.estado === 'separado' || lote.estado === 'reservado') {
			badge.classList.add('bg-warning', 'text-dark');
		} else if(lote.estado === 'vendido') {
			badge.classList.add('bg-danger');
		} else {
			badge.classList.add('bg-secondary');
		}

		document.getElementById('modalLotePrecio').textContent = `${simbolo} ${parseFloat(lote.precio_venta).toLocaleString('es-PE', {minimumFractionDigits: 2})}`;
		document.getElementById('modalLoteArea').textContent = `${parseFloat(lote.area_m2).toFixed(2)} m²`;

		const precioM2 = lote.area_m2 > 0 ? (lote.precio_venta / lote.area_m2) : 0;
		document.getElementById('modalLotePrecioM2').textContent = `${simbolo} ${precioM2.toLocaleString('es-PE', {minimumFractionDigits: 2})}`;

		document.getElementById('modalLoteFrente').textContent = lote.medida_frente ? `${lote.medida_frente} m` : '-';
		document.getElementById('modalLoteFondo').textContent = lote.medida_fondo ? `${lote.medida_fondo} m` : '-';
		document.getElementById('modalLoteIzq').textContent = lote.medida_izquierda ? `${lote.medida_izquierda} m` : '-';
		document.getElementById('modalLoteDer').textContent = lote.medida_derecha ? `${lote.medida_derecha} m` : '-';

		if(lote.observaciones) {
			document.getElementById('modalLoteObservacionesWrap').classList.remove('d-none');
			document.getElementById('modalLoteObservaciones').textContent = lote.observaciones;
		} else {
			document.getElementById('modalLoteObservacionesWrap').classList.add('d-none');
		}

		// Botones de acción
		const accionesDiv = document.getElementById('modalAcciones');
		accionesDiv.innerHTML = '';

		if(lote.estado === 'disponible') {
			accionesDiv.innerHTML = `
				<a href="{{ url('/crear-cotizacion/1CIX00000011') }}?lote_id=${lote.id}" class="btn btn-primary py-2 rounded-3 fw-medium">
					<i class="ri-calculator-line me-1"></i> Simular Cotización / Proforma
				</a>
				<div class="row g-2">
					<div class="col-6">
						<a href="{{ url('/crear-reserva/1CIX00000012') }}?lote_id=${lote.id}" class="btn btn-warning w-100 py-2 rounded-3 fw-medium text-dark">
							<i class="ri-bookmark-line me-1"></i> Separar Lote
						</a>
					</div>
					<div class="col-6">
						<a href="{{ url('/agregar-venta/1CIX00000013') }}?lote_id=${lote.id}" class="btn btn-success w-100 py-2 rounded-3 fw-medium">
							<i class="ri-file-add-line me-1"></i> Formalizar Venta
						</a>
					</div>
				</div>
			`;
		} else if(lote.estado === 'separado' || lote.estado === 'reservado') {
			accionesDiv.innerHTML = `
				<div class="alert alert-warning py-2 px-3 fs-13 mb-2 rounded-3 text-center">
					<i class="ri-alarm-warning-line me-1"></i> Este lote se encuentra en proceso de separación.
				</div>
				<a href="{{ url('/agregar-venta/1CIX00000013') }}?lote_id=${lote.id}" class="btn btn-primary py-2 rounded-3 fw-medium">
					<i class="ri-file-check-line me-1"></i> Proceder a Contrato de Venta Definitivo
				</a>
			`;
		} else if(lote.estado === 'vendido') {
			accionesDiv.innerHTML = `
				<div class="alert alert-danger py-2 px-3 fs-13 mb-0 rounded-3 text-center">
					<i class="ri-lock-line me-1"></i> Lote adjudicado y vendido con contrato cerrado.
				</div>
			`;
		} else {
			accionesDiv.innerHTML = `
				<div class="alert alert-secondary py-2 px-3 fs-13 mb-0 rounded-3 text-center">
					<i class="ri-forbid-line me-1"></i> Lote bloqueado o no disponible para venta.
				</div>
			`;
		}

		const modal = new bootstrap.Modal(document.getElementById('modalLoteInfo'));
		modal.show();
	}
</script>
@endpush
