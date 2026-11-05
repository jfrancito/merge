@extends('layouts.app')

@section('title', 'Modificar Grupo Opcion')

@section('page-title', 'Modificar de Grupo Opcion')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
	<li class="breadcrumb-item active">Grupo Opcion</li>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">


@endpush

@section('content')


<div class="card bg-white border-0 rounded-3 mb-4">
	<div class="card-body p-4">
		<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
			<h3 class="mb-0">Modificar {{ $titulomodal }}</h3>
		</div>
		
		<form action='{{ route('modificar.grupoopciones.mto',[$idopcion,$idregistro]) }}' 
			  name={{ 'frmmodificar'.$titulomodal}} 
			  id='frmmodificar' 
			  method="POST">
			@csrf
			<div class="row">

				<x-form.hidden 
					name="idopcion"
					:value="$idopcion"
				/>
				<x-form.hidden 
					name="nameform"
					:value="'frmregisrtar'.$titulomodal"
				/>

				<x-form.input 
					type="text"
					label="Nombre"
					name="nombre"
					:value="$oeRegistro->nombre??''"
					placeholder="Escriba el Nombre Grupo Opcion"
					required="required"
					col='6'
				/>

				<x-form.select 
					label="Icono"
					name="icono"
					:options="$combo_icono"	
					:value="$oeRegistro->icono??''"
					icon="ri-user-settings-line"
					col="3"
					required="required"
					class="select2-icono"
				/>

				<x-form.icono
					label="Icono Preview"
					name="iconoprev"
					:value="$oeRegistro->icono??''"
					col='2'
				/>

				<x-form.select 
					label="Activo"
					name="activo"
					:options="$combo_activo"	
					:value="1"
					icon="ri-user-settings-line"
					col="3"
					class="select2-auditado"
				/>


				{{-- <x-form.bandera 
					name="anadir"
					value="1"
					label="Activo"
				/> --}}


				<div class="form-group mb-4"></div>

				<div class="d-flex gap-2">
					<button type="submit" 
							id="btnGuardar"
							class="btn btn-primary bg-primary bg-opacity-10 text-primary border-0 fw-semibold py-2 px-4">
						<i class="ri-save-3-line me-2"></i>
						Guardar
					</button>

					<a href="{{ route('gestion.grupoopciones.mto', $idopcion) }}" 
					   class="btn btn-danger bg-danger bg-opacity-10 text-danger border-0 fw-semibold py-2 px-4">
						<i class="ri-close-line me-2"></i>
						Cancelar
					</a>
				</div>

			</div>
		</form>

	</div>
</div>

@endsection

@push('scripts')
<script>
(function($) {
	'use strict';
	
	$(document).ready(function() {


		let formname = $('#nameform').val();
		// Inicializar Select2
		$('select[name="icono"], select[name="indauditado"]').select2({
			width: '100%',
			dropdownParent: $('body'),
			placeholder: 'Seleccione una opción',
			allowClear: true,
			minimumResultsForSearch: 5
		});

		// ✅ EVENTO SUBMIT DEL FORMULARIO
		// Este evento solo se dispara si el formulario es válido
		$('#frmmodificar').on('submit', function(e) {
			// Si llega aquí, es que pasó el 'required'
			abrircargando('Registrando ... ');
		});

		$('#icono').on('change', function () {
			let icono = $(this).val();
			let $prev = $('#iconoprev');
			// Animación: se desvanece → cambia → aparece suave
			$prev.fadeOut(120, function () {
				$prev.text(icono); // Cambia el contenido
				$prev.fadeIn(120);
			});
		});

	});

})(jQuery);
</script>
@endpush

