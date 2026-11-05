@extends('layouts.app')

@section('title', 'Formalizar Venta')

@section('page-title', 'Ventas y Cobranzas')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Formalizar Venta</h5>

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
				Nueva Venta
			</li>
		</ol>
	</div>
@endsection

@section('content')
	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
				<div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
					<i class="ri-file-add-line fs-22"></i>
				</div>
				<div>
					<h4 class="mb-1">Cierre de Venta y Contrato de Compraventa</h4>
					<p class="text-muted fs-14 mb-0">Genere el contrato de compraventa y el cronograma de cuotas mensuales de financiamiento directo.</p>
				</div>
			</div>

			@if(session('errorbd'))
				<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
					<i class="ri-error-warning-line me-2 fs-16"></i> {{ session('errorbd') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<form method="POST" action="{{ url('/agregar-venta/'.$idopcion) }}" class="needs-validation" novalidate data-loading-msg="Generando contrato y cuotas...">
				@csrf
				<input type="hidden" name="reserva_id" value="{{ $reserva_id_selected }}">

				<div class="row">
					<!-- PROYECTO Y LOTE -->
					<div class="col-12 mb-2">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-map-pin-line text-primary"></i> 1. Identificación del Lote y Partes
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
							<div class="invalid-feedback">Seleccione proyecto.</div>
						</div>
					</div>

					<div class="col-lg-4 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="manzana_id">Manzana <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-community-line input-icon"></i>
							<select name="manzana_id" id="manzana_id" class="form-select ps-5" required>
								<option value="">-- Elija proyecto primero --</option>
							</select>
							<div class="invalid-feedback">Seleccione manzana.</div>
						</div>
					</div>

					<div class="col-lg-4 col-md-12 mb-4">
						<label class="form-label fw-semibold" for="lote_id">Lote a Adquirir <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-map-pin-range-line input-icon"></i>
							<select name="lote_id" id="lote_id" class="form-select ps-5" required>
								<option value="">-- Elija manzana primero --</option>
							</select>
							<div class="invalid-feedback">Seleccione lote.</div>
						</div>
					</div>

					<div class="col-lg-6 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="cliente_id">Comprador Titular <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-user-line input-icon"></i>
							<select name="cliente_id" id="cliente_id" class="form-select ps-5" required>
								<option value="">-- Seleccione Cliente --</option>
								@foreach($clientes as $c)
									<option value="{{ $c->id }}">{{ $c->numero_documento }} - {{ $c->nombre_completo }}</option>
								@endforeach
							</select>
							<div class="invalid-feedback">Seleccione el cliente comprador.</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
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

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="fecha_venta">Fecha de Venta / Firma <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-calendar-line input-icon"></i>
							<input type="date" class="form-control ps-5" name="fecha_venta" id="fecha_venta" value="{{ date('Y-m-d') }}" required>
						</div>
					</div>

					<!-- CONDICIONES ECONÓMICAS -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-money-dollar-circle-line text-primary"></i> 2. Precio y Modalidad de Financiamiento
						</h5>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="tipo_venta">Modalidad de Venta <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-bank-card-line input-icon"></i>
							<select name="tipo_venta" id="tipo_venta" class="form-select ps-5" required>
								<option value="credito">Crédito Directo Inmobiliario</option>
								<option value="contado">Venta al Contado</option>
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
						<label class="form-label fw-semibold" for="descuento">Descuento Aplicado (S/)</label>
						<div class="input-icon-wrapper">
							<i class="ri-percent-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5 text-danger" name="descuento" id="descuento" value="0.00">
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="precio_final">Precio Total de Venta <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-money-dollar-circle-line input-icon"></i>
							<input type="number" step="0.01" class="form-control ps-5 fw-bold text-dark fs-15" name="precio_final" id="precio_final" value="0.00" required>
						</div>
					</div>

					<!-- PLAN DE CUOTAS PARA CRÉDITO -->
					<div class="col-lg-3 col-md-6 mb-4 seccion-credito">
						<label class="form-label fw-semibold" for="monto_inicial">Cuota Inicial Cobrada (S/)</label>
						<div class="input-icon-wrapper">
							<i class="ri-hand-coin-line input-icon"></i>
							<input type="number" step="0.01" min="0" class="form-control ps-5 fw-bold text-success" name="monto_inicial" id="monto_inicial" value="5000.00">
						</div>
						<div class="small text-muted mt-1">Se registrará como Cuota 0 pagada</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4 seccion-credito">
						<label class="form-label fw-semibold" for="numero_cuotas">N° de Cuotas Mensuales</label>
						<div class="input-icon-wrapper">
							<i class="ri-calendar-todo-line input-icon"></i>
							<select name="numero_cuotas" id="numero_cuotas" class="form-select ps-5">
								<option value="12">12 Meses</option>
								<option value="24">24 Meses</option>
								<option value="36" selected>36 Meses</option>
								<option value="48">48 Meses</option>
								<option value="60">60 Meses</option>
								<option value="72">72 Meses</option>
							</select>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4 seccion-credito">
						<label class="form-label fw-semibold" for="dia_pago_mensual">Día de Pago de cada Mes</label>
						<div class="input-icon-wrapper">
							<i class="ri-calendar-check-line input-icon"></i>
							<select name="dia_pago_mensual" id="dia_pago_mensual" class="form-select ps-5">
								<option value="5">Cada día 05 de mes</option>
								<option value="10">Cada día 10 de mes</option>
								<option value="15" selected>Cada día 15 de mes</option>
								<option value="20">Cada día 20 de mes</option>
								<option value="30">Fin de mes (30)</option>
							</select>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4 seccion-credito">
						<label class="form-label fw-semibold text-success" for="monto_cuota_mensual">Monto de Cuota Fija Mensual</label>
						<div class="input-icon-wrapper">
							<i class="ri-coins-line input-icon text-success"></i>
							<input type="number" step="0.01" class="form-control ps-5 fw-bold fs-16 text-success" name="monto_cuota_mensual" id="monto_cuota_mensual" value="0.00" readonly>
						</div>
					</div>

					<div class="col-lg-4 col-md-6 mb-4 seccion-credito">
						<label class="form-label fw-semibold" for="fecha_primer_vencimiento">Fecha de Vencimiento 1era Cuota</label>
						<div class="input-icon-wrapper">
							<i class="ri-time-line input-icon"></i>
							<input type="date" class="form-control ps-5" name="fecha_primer_vencimiento" id="fecha_primer_vencimiento" value="{{ date('Y-m-d', strtotime('+1 month')) }}">
						</div>
					</div>

					<div class="col-lg-8 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="clausulas_adicionales">Cláusulas / Acuerdos Especiales en el Contrato</label>
						<div class="input-icon-wrapper">
							<i class="ri-file-text-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="clausulas_adicionales" id="clausulas_adicionales" placeholder="Ej: Se entregará nivelado con punto de agua...">
						</div>
					</div>

					<div class="col-12 d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
						<a href="{{ url('/gestion-de-ventas/'.$idopcion) }}" class="btn btn-outline-secondary py-2 px-4 fw-medium rounded-3">
							Cancelar
						</a>
						<button type="submit" class="btn btn-primary py-2 px-4 fw-medium rounded-3 d-flex align-items-center gap-2">
							<i class="ri-check-double-line fs-18"></i>
							<span>Formalizar Venta y Generar Cronograma</span>
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

	$('#manzana_id').on('change', function() {
		var mzid = $(this).val();
		$('#lote_id').empty().append('<option value="">Cargando...</option>');
		if(!mzid) return;

		$.getJSON('/loteame/ajax-lotes-disponibles-por-manzana', { manzana_id: mzid }, function(res) {
			$('#lote_id').empty().append('<option value="">-- Seleccione Lote --</option>');
			if(res.success && res.lotes.length) {
				$.each(res.lotes, function(i, lt) {
					$('#lote_id').append('<option value="' + lt.id + '" data-precio="' + lt.precio_total + '">Lote ' + lt.numero_lote + ' (' + lt.area_m2 + 'm² - S/ ' + lt.precio_total + ')</option>');
				});
			} else {
				$('#lote_id').append('<option value="" disabled>No hay lotes disponibles en esta manzana</option>');
			}
		});
	});

	$('#lote_id').on('change', function() {
		var selected = $(this).find('option:selected');
		var precio = parseFloat(selected.data('precio')) || 0;
		$('#precio_lote').val(precio.toFixed(2));
		recalcularVenta();
	});

	function recalcularVenta() {
		var precioLista = parseFloat($('#precio_lote').val()) || 0;
		var desc = parseFloat($('#descuento').val()) || 0;
		var precioFinal = Math.max(0, precioLista - desc);
		$('#precio_final').val(precioFinal.toFixed(2));

		var tipo = $('#tipo_venta').val();
		if (tipo === 'contado') {
			$('.seccion-credito').hide();
			$('#monto_cuota_mensual').val('0.00');
		} else {
			$('.seccion-credito').show();
			var inicial = parseFloat($('#monto_inicial').val()) || 0;
			var saldo = Math.max(0, precioFinal - inicial);
			var meses = parseInt($('#numero_cuotas').val()) || 1;
			var cuota = meses > 0 ? (saldo / meses).toFixed(2) : 0;
			$('#monto_cuota_mensual').val(cuota);
		}
	}

	$('#descuento, #monto_inicial, #numero_cuotas, #tipo_venta').on('input change', recalcularVenta);
});
</script>
@endpush
