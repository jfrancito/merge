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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


@section('content')


	<div class="card bg-white border-0 rounded-3 mb-4">
		<div class="card-body p-4">
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
				<h3 class="mb-0">{{ $oeRegistro->NombrePersona .' '. $oeRegistro->ApellidoPaterno.' '.$oeRegistro->ApellidoMaterno}}</h3>
				{{-- <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
					<option selected="">This Week</option>
					<option value="1">This Month</option>
					<option value="2">This Year</option>
				</select> --}}
			</div>
			{{-- <form action="{{ route('register.post') }}" method="POST"> --}}
			<form action='{{ route('modificar.usuarios.mto.post',[$idopcion,$idusuario]) }}' name='frmmodificarusuario' id='frmmodificarusuario' method="POST">
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
						placeholder="Escriba su Usario"
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
						:options="$comborol"   {{-- array: id => nombre --}}
						:value="$oeRegistro->rol_id"
						icon="ri-user-settings-line"
						col="3"
					/>

					<x-form.select 
						label="Auditado"
						name="indauditado"
						:options="$combo_auditado"   {{-- array: id => nombre --}}
						:value="$oeRegistro->IndAuditado"
						icon="ri-user-settings-line"
						col="3"
					/>

					{{-- <x-form.modal /> --}}


					<div class="form-group mb-4">
						{{-- <div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
							<label class="form-check-label" for="flexCheckDefault">
								Remember me
							</label>
						</div> --}}
					</div>

					<div class="d-flex gap-2">
						<button type="submit" class="btn btn-primary bg-primary bg-opacity-10 text-primary border-0 fw-semibold py-2 px-4">
							<i class="ri-save-3-line me-2"></i>
							Guardar
						</button>

						<button type="button" class="btn btn-danger bg-danger bg-opacity-10 text-danger border-0 fw-semibold py-2 px-4">
							<i class="ri-close-line me-2"></i>
							Cancelar
						</button>
					</div>

				</div>
			</form>

		</div>
	</div>



@endsection

{{-- @push('scripts')

<script>
	document.addEventListener('DOMContentLoaded', function () {
		console.log("Página de bienvenida cargada correctamente");
		$('.select2-input').select2();
	});
</script>

@endpush --}}

@push('scripts')
<script>
$(document).ready(function() {
	{{-- console.log("Iniciando select2..."); --}}
	{{-- alert('holaaa'); --}}
	{{-- var rol = $('#') --}}
	{{-- $('.select2-input').select2(); --}}

});
</script>
@endpush

{{-- <script src="/js/jquery.dataTables.min.js"></script> --}}
