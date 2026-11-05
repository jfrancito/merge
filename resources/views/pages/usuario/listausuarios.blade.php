@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('page-title', 'Gestión de Usuarios')

@section('breadcrumb')
	<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
		<h5 class="mb-0">Usuarios</h5>

		<ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
			<li class="breadcrumb-item d-inline-block position-relative">
				<a href="{{ url('/') }}" class="d-inline-block position-relative">
					<i class="material-symbols-outlined">home</i>
					Inicio
				</a>
			</li>

			<li class="breadcrumb-item d-inline-block position-relative">
				Usuarios
			</li>
		</ol>
	</div>
@endsection
@push('styles')
	<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
@endpush
@section('content')
	<div class="card bg-white border-0 rounded-3 mb-4">
		<div class="card-body p-4">
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
				<h3 class="mb-0">Lista de Usuarios</h3>
				<div class="d-flex flex-wrap gap-3 align-items-center">
					<a href="{{ url('/agregar-usuario/' . $idopcion) }}" target="_self">
						<button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg"
							data-bs-toggle="modal" data-bs-target="#exampleModal">
							<span class="py-sm-1 d-block">
								<i class="ri-add-line d-none d-sm-inline-block"></i>
								<span>Agregar Usuario</span>
							</span>
						</button>
					</a>
				</div>
			</div>
			<div class="default-table-area all-products">
				<div class="table-responsive custom-table-scroll"
					style="border-radius: 12px; overflow-x: auto; overflow-y: auto; max-height: 500px; box-shadow: 0 0 20px rgba(0,0,0,0.02);">
					<table class="table table-hover align-middle mb-0" id="usuariosTable"
						style="border-collapse: collapse; min-width: 800px;">
						<thead>
							<tr style="background-color: #f7f9fc;">
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-4">
									Nombre</th>
								@if(session('usuario') && session('usuario')->rol_id == '1CIX00000001')
									<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-4">
										Empresa</th>
								@endif
								<th class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-4">
									Perfil</th>
								<th
									class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-4 text-center">
									Activo</th>
								<th
									class="border-0 text-secondary text-uppercase fs-12 fw-bold letter-spacing-1 py-3 px-4 text-center">
									Opción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($listausuarios as $index => $item)
								<tr class="transition-all" style="transition: all 0.2s ease;">
									<td class="py-3 px-4 border-bottom fw-bold text-secondary fs-14"
										style="border-color: #f0f4fa;">{{$item->name}}</td>
									@if(session('usuario') && session('usuario')->rol_id == '1CIX00000001')
										<td class="py-3 px-4 border-bottom text-secondary" style="border-color: #f0f4fa;">
											<span
												class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-1 rounded-pill fs-12 fw-medium">{{ $item->empresa->nombre ?? 'N/A' }}</span>
										</td>
									@endif
									<td class="py-3 px-4 border-bottom text-secondary fw-medium fs-13"
										style="border-color: #f0f4fa;">{{$item->rol->nombre ?? 'N/A'}}</td>
									<td class="py-3 px-4 border-bottom text-center" style="border-color: #f0f4fa;">
										@if($item->activo == 0)
											<span
												class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1 rounded-pill fs-12 fw-medium">Inactivo</span>
										@else
											<span
												class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill fs-12 fw-medium">Activo</span>
										@endif
									</td>
									<td class="py-3 px-4 border-bottom text-center" style="border-color: #f0f4fa;">
										<a href="{{ url('/modificar-usuario/' . $idopcion . '/' . Hashids::encode(substr($item->id, -8))) }}"
											class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1 transition-all"
											title="Editar">
											<i class="bi bi-pencil-square"></i>
											<span>Editar</span>
										</a>
									</td>
								</tr>


							@endforeach

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection

@push('scripts')
	<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function () {

			if (typeof $ === 'undefined' || typeof $.fn.DataTable === 'undefined') {
				console.warn("jQuery or DataTables not available. DataTables initialization skipped.");
				return;
			}

			let $table = $('#usuariosTable');

			if ($table.length) {
				console.log("Initializing DataTables on usuariosTable...");
				$table.DataTable({
					responsive: true,
					autoWidth: false,
					language: window.dtSpanish
				});
			} else {
				console.log("usuariosTable no está presente en esta página.");
			}

		});
	</script>

@endpush