@extends('layouts.app')

@section('title', 'Registrar  Opcion')

@section('page-title', 'Registrar Opcion')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
	<li class="breadcrumb-item active">Opcion</li>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">


@endpush

@section('content')


<div class="card bg-white border-0 rounded-3 mb-4">
	<div class="card-body p-4">
		<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
			<h3 class="mb-0">Agregar {{ $titulomodal }}</h3>
		</div>
		
		<form action='{{ route('agregar.opciones.mto',[$idopcion]) }}' 
			  name={{ 'frmregistrar'.$titulomodal}} 
			  id='frmregistrar' 
			  method="POST">
			@csrf
			<div class="row">

				<x-form.hidden 
					name="idopcion"
					:value="$idopcion"
				/>
			

				<x-form.input 
					type="text"
					label="Nombre"
					name="nombre"
					:value="''"
					placeholder="Escriba el Nombre Opcion"
					required="required"
					col='6'
				/>


				<x-form.input 
					type="text"
					label="Descripcion"
					name="descripcion"
					:value="''"
					placeholder="Escriba la Descripcion"
					required="required"
					col='6'
				/>


				<x-form.input 
					type="text"
					label="Pagina"
					name="pagina"
					:value="''"
					placeholder="Escriba el Url de la Pagina"
					required="required"
					col='6'
				/>


				<x-form.select 
					label="Grupo Opcion"
					name="grupoopcion_id"
					:options="$combogrupoopcion"	
					:value="1"
					icon="ri-user-settings-line"
					col="6"
					required="required"
					class="select2-icono"
				/>

				

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
		$('#frmregistrar').on('submit', function(e) {
			// Si llega aquí, es que pasó el 'required'
			abrircargando('Registrando ... ');
		});

		


	});

})(jQuery);
</script>
@endpush

