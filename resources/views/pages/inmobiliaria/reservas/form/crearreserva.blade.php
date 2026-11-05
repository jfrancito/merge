@extends('layouts.app')

@section('title', 'Registrar Separación')

@section('page-title', 'Gestión Comercial')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Registrar Separación</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/gestion-de-reservas/'.$idopcion) }}">Reservas</a>
			</li>
			<li class="breadcrumb-item d-inline-block position-relative">
				Nueva
			</li>
		</ol>
	</div>
@endsection

@section('content')
	<div class="card bg-white border-0 rounded-3 mb-4 shadow-sm">
		<div class="card-body p-4">
			<div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
				<div class="bg-warning bg-opacity-10 text-warning rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
					<i class="ri-bookmark-line fs-22"></i>
				</div>
				<div>
					<h4 class="mb-1">Separación y Reserva de Lote</h4>
					<p class="text-muted fs-14 mb-0">Bloquea temporalmente el lote seleccionado tras el pago de la señal o reserva.</p>
				</div>
			</div>

			@if(session('errorbd'))
				<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
					<i class="ri-error-warning-line me-2 fs-16"></i> {{ session('errorbd') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<form method="POST" action="{{ url('/agregar-reserva/'.$idopcion) }}" class="needs-validation" novalidate data-loading-msg="Guardando reserva..." enctype="multipart/form-data">
				@csrf
				<div class="row">
					<!-- PROYECTO Y LOTE -->
					<div class="col-12 mb-2">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-map-pin-line text-primary"></i> 1. Lote a Reservar
						</h5>
					</div>

					<div class="col-lg-4 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="proyecto_id">Proyecto Inmobiliario <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-building-line input-icon"></i>
							<select name="proyecto_id" id="proyecto_id" class="form-select ps-5" required>
								<option value="">-- Seleccione Proyecto --</option>
								@foreach($proyectos as $p)
									<option value="{{ $p->id }}">{{ $p->nombre }}</option>
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

					<!-- DATOS DE LA SEPARACIÓN -->
					<div class="col-12"><hr class="my-2"></div>
					<div class="col-12 mb-2 mt-3">
						<h5 class="text-dark fw-bold fs-15 mb-3 d-flex align-items-center gap-2">
							<i class="ri-money-dollar-box-line text-primary"></i> 2. Datos del Depósito y Vigencia
						</h5>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="monto_reserva">Monto de Separación (S/) <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-money-dollar-circle-line input-icon text-success"></i>
							<input type="number" step="0.01" min="1" class="form-control ps-5 fw-bold text-success fs-15" name="monto_reserva" id="monto_reserva" value="{{ old('monto_reserva', 500.00) }}" required>
							<div class="invalid-feedback">Ingrese el monto de reserva.</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="metodo_pago">Medio de Pago <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-bank-card-line input-icon"></i>
							<select name="metodo_pago" id="metodo_pago" class="form-select ps-5" required>
								<option value="transferencia">Transferencia Bancaria</option>
								<option value="deposito">Depósito en Ventanilla</option>
								<option value="efectivo">Efectivo en Caja</option>
								<option value="yape">Yape / Plin</option>
							</select>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="banco_origen">Banco Destino / Cuenta</label>
						<div class="input-icon-wrapper">
							<i class="ri-bank-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="banco_origen" id="banco_origen" placeholder="Ej: BCP Cta Cte">
						</div>
					</div>

					<div class="col-lg-3 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="numero_operacion">N° de Operación</label>
						<div class="input-icon-wrapper">
							<i class="ri-hashtag input-icon"></i>
							<input type="text" class="form-control ps-5" name="numero_operacion" id="numero_operacion" placeholder="Ej: 0048593">
						</div>
					</div>

					<div class="col-lg-4 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="fecha_reserva">Fecha de Separación <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-calendar-line input-icon"></i>
							<input type="date" class="form-control ps-5" name="fecha_reserva" id="fecha_reserva" value="{{ date('Y-m-d') }}" required>
						</div>
					</div>

					<div class="col-lg-4 col-md-6 mb-4">
						<label class="form-label fw-semibold" for="fecha_limite">Fecha Límite para Formalizar <span class="text-danger">*</span></label>
						<div class="input-icon-wrapper">
							<i class="ri-calendar-check-line input-icon"></i>
							<input type="date" class="form-control ps-5" name="fecha_limite" id="fecha_limite" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
						</div>
						<div class="small text-muted mt-1">Por defecto: 7 días de vigencia</div>
					</div>

					<div class="col-lg-4 col-md-12 mb-4">
						<label class="form-label fw-semibold" for="voucher_foto">Voucher / Comprobante (Opcional)</label>
						<div class="input-icon-wrapper">
							<i class="ri-attachment-line input-icon"></i>
							<input type="file" class="form-control ps-5" name="voucher_foto" id="voucher_foto" accept="image/*,.pdf">
						</div>
						<div class="small text-secondary mt-1">Formatos: JPG, PNG, PDF (Máx. 3MB)</div>
					</div>

					<div class="col-12 mb-4">
						<label class="form-label fw-semibold" for="observaciones">Observaciones</label>
						<div class="input-icon-wrapper">
							<i class="ri-file-text-line input-icon"></i>
							<input type="text" class="form-control ps-5" name="observaciones" id="observaciones" placeholder="Ej: Cliente formalizará la compra con 30% de inicial...">
						</div>
					</div>

					<div class="col-12 d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
						<a href="{{ url('/gestion-de-reservas/'.$idopcion) }}" class="btn btn-outline-secondary py-2 px-4 fw-medium rounded-3">
							Cancelar
						</a>
						<button type="submit" class="btn btn-warning py-2 px-4 fw-medium rounded-3 d-flex align-items-center gap-2 text-dark shadow-sm">
							<i class="ri-check-line fs-18"></i>
							<span>Registrar Separación y Bloquear Lote</span>
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
					$('#lote_id').append('<option value="' + lt.id + '">Lote ' + lt.numero_lote + ' (' + lt.area_m2 + 'm² - S/ ' + lt.precio_total + ')</option>');
				});
			} else {
				$('#lote_id').append('<option value="" disabled>No hay lotes disponibles en esta manzana</option>');
			}
		});
	});
});
</script>
@endpush
