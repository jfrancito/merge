@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('page-title', 'Gestión de Usuarios')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
	<li class="breadcrumb-item active">Usuarios</li>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">


@endpush

@section('content')


<div class="card bg-white border-0 rounded-3 mb-4">
	<div class="card-body p-4">
		<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
			<h3 class="mb-0">{{ $oeRegistro->NombrePersona .' '. $oeRegistro->ApellidoPaterno.' '.$oeRegistro->ApellidoMaterno}}</h3>
		</div>
		
		<form action='{{ route('modificar.usuarios.mto.post',[$idopcion,$idusuario]) }}' 
			  name='frmmodificarusuario' 
			  id='frmmodificarusuario' 
			  method="POST">
			@csrf
			<div class="row">

				<x-form.hidden 
					name="nombrecompleto"
					:value="$oeRegistro->NombrePersona.' '. $oeRegistro->ApellidoPaterno. ' '. $oeRegistro->ApellidoMaterno"
				/>
				
				<x-form.input 
					type="text"
					label="Nombre"
					name="nombre"
					:value="$oeRegistro->NombrePersona ?? '' "
					placeholder="Escriba su Nombre..."
					col='6'
					disabled='disabled'
				/>
				
				<x-form.input 
					label="Apellido Paterno"
					name="apellidopaterno"
					:value="$oeRegistro->ApellidoPaterno ?? ''"
					placeholder="Escriba su Ap Paterno..."
					col='3'
					disabled='disabled'
				/>
				
				<x-form.input 
					label="Apellido Materno"
					name="apellidomaterno"
					:value="$oeRegistro->ApellidoMaterno ?? ''"
					placeholder="Escriba su Ap Materno..."
					col='3'
					disabled='disabled'
				/>

				<x-form.input 
					label="Usuario"
					name="usuario"
					:value="$oeRegistro->Nombre ?? ''"
					placeholder="Escriba su Usuario"
					col='3'
					disabled='disabled'
				/>

				<x-form.input 
					type='password'
					label="Password ({{ $oeRegistro->passwordmobil }})"
					name="password"
					:value="$oeRegistro->passwordmobil ?? ''"
					placeholder="Escriba su Pass"
					col='3'
				/>
				
				<x-form.select 
					label="Rol"
					name="rol_id"
					:options="$comborol"
					:value="$oeRegistro->rol_id"
					icon="ri-user-settings-line"
					col="3"
					class="select2-rol"
				/>

				<x-form.select 
					label="Auditado"
					name="indauditado"
					:options="$combo_auditado"
					:value="$oeRegistro->IndAuditado"
					icon="ri-user-settings-line"
					col="3"
					class="select2-auditado"
				/>

				<div class="form-group mb-4"></div>

				<div class="d-flex gap-2">
					<button type="submit" 
							id="btnGuardar"
							class="btn btn-primary bg-primary bg-opacity-10 text-primary border-0 fw-semibold py-2 px-4">
						<i class="ri-save-3-line me-2"></i>
						Guardar
					</button>

					<a href="{{ route('gestion.usuarios.mto', $idopcion) }}" 
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

        // Destruir instancias previas
        $('select[name="rol_id"], select[name="indauditado"]').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
        });

        // Inicializar Select2
        $('select[name="rol_id"], select[name="indauditado"]').select2({
            width: '100%',
            dropdownParent: $('body'),
            placeholder: 'Seleccione una opción',
            allowClear: true,
            minimumResultsForSearch: 5
        });

        // ✅ EVENTO CLICK DEL BOTÓN GUARDAR
        $('#btnGuardar').on('click', function(e) {
            {{-- e.preventDefault(); // 👈 detiene el submit --}}
            {{-- debugger; --}}
            abrircargando('Registrando ... ');
            {{-- return false; --}}
        });

    });

})(jQuery);
</script>
@endpush

