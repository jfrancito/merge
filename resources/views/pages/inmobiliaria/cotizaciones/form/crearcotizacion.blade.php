@extends('layouts.app')

@section('title', 'Generar Cotización')

@section('page-title', 'Gestión Comercial')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Generar Cotización</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/gestion-de-cotizaciones/'.$idopcion) }}">Cotizaciones</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Cotizador
			</li>
		</ol>
	</div>
@endsection

@section('content')
	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
				<div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
					<i class="ri-calculator-line fs-22"></i>
				</div>
				<div>
					<h4 class="mb-1">Simulador de Financiamiento y Cotización</h4>
					<p class="text-muted fs-14 mb-0">Seleccione el lote y configure las opciones de pago al contado o crédito directo.</p>
				</div>
			</div>

			@if(session('errorbd'))
				<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
					<i class="ri-error-warning-line me-2 fs-16"></i> {{ session('errorbd') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<form method="POST" action="{{ url('/agregar-cotizacion/'.$idopcion) }}" class="needs-validation" novalidate data-loading-msg="Generando cotización...">
				@csrf
				<div class="row">
					<!-- PROYECTO Y LOTE -->
					<div class="col-12 mb-2">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-map-pin-line text-primary"></i> 1. Selección de Lote y Cliente
						</h5>
					</div>

					<div class="col-lg-4 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="proyecto_id">Proyecto Inmobiliario <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-building-line input-icon"></i>
							<select name="proyecto_id" id="proyecto_id" class="form-select ps-5" required>
								<option value="">-- Seleccione Proyecto --</option>
								@foreach($proyectos as $p)
									<option value="{{ $p->id }}">{{ $p->nombre }} ({{ $p->distrito }})</option>
								@endforeach
							</select>
							<div class="invalid-feedback">Seleccione un proyecto.</div>
						</div>
					</div>

					<div class="col-lg-4 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="manzana_id">Manzana <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-community-line input-icon"></i>
							<select name="manzana_id" id="manzana_id" class="form-select ps-5" required>
								<option value="">-- Primero elija proyecto --</option>
							</select>
							<div class="invalid-feedback">Seleccione manzana.</div>
						</div>
					</div>

					<div class="col-lg-4 col-md-12 mb-4">
						<label class="form-label fw-semibold" for="lote_id">Lote Disponible <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-map-pin-range-line input-icon"></i>
							<select name="lote_id" id="lote_id" class="form-select ps-5" required>
								<option value="">-- Primero elija manzana --</option>
							</select>
							<div class="invalid-feedback">Seleccione un lote.</div>
						</div>
					</div>

					<!-- DETALLE DEL LOTE CARGADO DINÁMICAMENTE -->
					<div class="col-12 mb-4" id="box-info-lote" style="display: none;">
						<div class="alert alert-primary bg-primary bg-opacity-10 border-primary border-opacity-25 rounded-3 p-3">
							<div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
								<div>
									<h6 class="mb-1 text-primary fw-bold" id="info-lote-titulo">Mz. A - Lote 01</h6>
									<span class="text-muted fs-13" id="info-lote-medidas">Área: 120.00 m² | Frente: 6m x Fondo: 20m</span>
								</div>
								<div class="text-end">
									<span class="text-muted fs-12 d-block">Precio de Lista:</span>
									<h4 class="mb-0 fw-bold text-dark" id="info-lote-precio">S/ 42,000.00</h4>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-6 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="cliente_id">Cliente / Comprador <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-user-line input-icon"></i>
							<select name="cliente_id" id="cliente_id" class="form-select ps-5" required>
								<option value="">-- Seleccione Cliente --</option>
								@foreach($clientes as $c)
									<option value="{{ $c->id }}">{{ $c->numero_documento }} - {{ $c->nombre_completo }}</option>
								@endforeach
							</select>
							<div class="invalid-feedback">Seleccione un cliente.</div>
						</div>
					</div>

					<div class="col-lg-6 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="vendedor_id">Asesor Comercial</label>
						<div class="input-icon-wrapper">
							<i class="ri-user-star-line input-icon"></i>
							<select name="vendedor_id" id="vendedor_id" class="form-select ps-5">
								<option value="">-- Sin Asesor Asignado --</option>
								@foreach($vendedores as $v)
									<option value="{{ $v->id }}">{{ $v->nombre_completo }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<!-- CONDICIONES DE PAGO -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-coins-line text-primary"></i> 2. Plan de Pago y Simulación
						</h5>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="tipo_pago">Modalidad de Pago <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-bank-card-line input-icon"></i>
							<select name="tipo_pago" id="tipo_pago" class="form-select ps-5" required>
								<option value="credito">Crédito Directo (Financiado)</option>
								<option value="contado">Al Contado</option>
							</select>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="precio_lote">Precio de Lista (S/)</label>
						<div class="input-icon-wrapper">
							<i class="ri-price-tag-3-line input-icon"></i>
							<input type="number" step="0.01" class="form-control ps-5" name="precio_lote" id="precio_lote" value="0.00" readonly>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="descuento">Descuento Especial (S/)</label>
						<div class="input-icon-wrapper">
							<i class="ri-percent-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5 text-danger" name="descuento" id="descuento" value="0.00">
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="precio_final">Precio Final con Descuento (S/)</label>
						<div class="input-icon-wrapper">
							<i class="ri-money-dollar-circle-line input-icon"></i>
							<input type="number" step="0.01" class="form-control ps-5 fw-bold text-dark fs-15" name="precio_final" id="precio_final" value="0.00" readonly>
						</div>
					</div>

					<!-- CAMPOS PARA CRÉDITO DIRECTO -->
					<div class="col-lg-4 col-md-4 mb-4 campo-credito">
						<label class="form-label fw-semibold" for="monto_inicial">Cuota Inicial Sugerida (S/)</label>
						<div class="input-icon-wrapper">
							<i class="ri-hand-coin-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5" name="monto_inicial" id="monto_inicial" value="5000.00">
						</div>
					</div>

					<div class="col-lg-4 col-md-4 mb-4 campo-credito">
						<label class="form-label fw-semibold" for="numero_cuotas">N° de Cuotas Mensuales</label>
						<div class="input-icon-wrapper">
							<i class="ri-calendar-event-line input-icon"></i>
							<select name="numero_cuotas" id="numero_cuotas" class="form-select ps-5">
								<option value="12">12 Meses (1 año)</option>
								<option value="24">24 Meses (2 años)</option>
								<option value="36" selected>36 Meses (3 años)</option>
								<option value="48">48 Meses (4 años)</option>
								<option value="60">60 Meses (5 años)</option>
								<option value="72">72 Meses (6 años)</option>
							</select>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 mb-4 campo-credito">
						<label class="form-label fw-semibold text-success" for="monto_cuota_mensual">Cuota Mensual Estimada</label>
						<div class="input-icon-wrapper">
							<i class="ri-coins-line input-icon text-success"></i>
							<input type="number" step="0.01" class="form-control ps-5 fw-bold fs-16 text-success" name="monto_cuota_mensual" id="monto_cuota_mensual" value="0.00" readonly>
						</div>
					</div>

					<div class="col-12 mb-4">
						<label class="form-label fw-semibold" for="observaciones">Observaciones / Notas para la Proforma</label>
						<div class="input-icon-wrapper">
							<i class="ri-file-text-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="observaciones" id="observaciones" placeholder="Ej: Válido por 15 días calendario...">
						</div>
					</div>

					<div class="col-12 d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
						<a href="{{ url('/gestion-de-cotizaciones/'.$idopcion) }}" class="btn btn-outline-secondary py-2 px-4 fw-medium rounded-3">
							Cancelar
						</a>
						<button type="submit" class="btn btn-primary py-2 px-4 fw-medium rounded-3 d-flex align-items-center gap-2">
							<i class="ri-file-text-line fs-18"></i>
							<span>Generar Cotización y Proforma</span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
	// Cargar Manzanas
	$('#proyecto_id').on('change', function() {
		var pid = $(this).val();
		$('#manzana_id').empty().append('<option value="">Cargando...</option>');
		$('#lote_id').empty().append('<option value="">-- Elija manzana primero --</option>');
		if(!pid) return;

		$.getJSON('/loteame/ajax-manzanas-por-proyecto', { proyecto_id: pid }, function(res) {
			$('#manzana_id').empty().append('<option value="">-- Seleccione Manzana --</option>');
			if(res.success && res.manzanas.length) {
				$.each(res.manzanas, function(i, mz) {
					$('#manzana_id').append('<option value="' + mz.id + '">' + mz.nombre + '</option>');
				});
			}
		});
	});

	// Cargar Lotes disponibles de la manzana
	$('#manzana_id').on('change', function() {
		var mzid = $(this).val();
		var pid = $('#proyecto_id').val();
		$('#lote_id').empty().append('<option value="">Cargando...</option>');
		if(!mzid) return;

		// Reutilizamos filtro de lotes
		$.getJSON('/loteame/ajax-detalle-lote', { manzana_id: mzid }, function(res) {
			// Alternativa: consultar lotes disponibles
		}).fail(function() {
			// Cargar lotes via llamada manual rápida
		});
	});

	// Función para calcular cuotas en vivo
	function recalcular() {
		var precioLista = parseFloat($('#precio_lote').val()) || 0;
		var desc = parseFloat($('#descuento').val()) || 0;
		var precioFinal = Math.max(0, precioLista - desc);
		$('#precio_final').val(precioFinal.toFixed(2));

		var tipo = $('#tipo_pago').val();
		if (tipo === 'contado') {
			$('.campo-credito').hide();
			$('#monto_cuota_mensual').val('0.00');
		} else {
			$('.campo-credito').show();
			var inicial = parseFloat($('#monto_inicial').val()) || 0;
			var saldo = Math.max(0, precioFinal - inicial);
			var meses = parseInt($('#numero_cuotas').val()) || 1;
			var cuota = meses > 0 ? (saldo / meses).toFixed(2) : 0;
			$('#monto_cuota_mensual').val(cuota);
		}
	}

	$('#descuento, #monto_inicial, #numero_cuotas, #tipo_pago').on('input change', recalcular);
});
</script>
@endpush
