@extends('layouts.app')

@section('title', 'Lista de Grupo Opciones')

@section('page-title', 'Gestión de Grupo Opciones')

@section('breadcrumb')
<div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
    <h5 class="mb-0">Grupo Opciones</h5>

    <ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
        <li class="breadcrumb-item d-inline-block position-relative">
            <a href="{{ url('/') }}" class="d-inline-block position-relative">
                <i class="material-symbols-outlined">home</i>
                Inicio
            </a>
        </li>

        <li class="breadcrumb-item d-inline-block position-relative">
            Grupo Opciones
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
        <h3 class="mb-0">Lista de Grupo Opciones</h3>
        <div class="d-flex flex-wrap gap-3 align-items-center">
              
              <a href="{{ route('agregar.opciones.mto',[$idopcion]) }}" target="_self">
                <button class="btn btn-outline-primary py-1 px-2 px-sm-4 fs-14 fw-medium rounded-3 hover-bg" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    
                  <span class="py-sm-1 d-block">
                    <i class="ri-add-line d-none d-sm-inline-block"></i>
                    <span>Agregar</span>
                  </span>

                </button>
              </a>
          </div>

      </div>

      <div class="default-table-area all-products">
        <div class="table-responsive">
          <table class="table align-middle" id="opcionesTable">
            <thead>
              <tr>
                {{-- <th scope="col">#</th> --}}
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Pagina</th>
                <th scope="col">Grupo Opcion</th>
                <th scope="col">Activo</th>
                <th scope="col">Opción</th>

              </tr>
            </thead>
            <tbody>
              @foreach($listadatos as $index => $item)
                <tr>
                  {{-- <td class="text-body">{{ $index+1 }}</td> --}}
                  
                  <td class="text-secondary">{{ $item->nombre }}</td>
                  <td class="text-secondary">{{ $item->descripcion }}</td>
                  <td class="text-secondary">{{ $item->pagina }}</td>
                  <td class="text-secondary">{{ $item->grupoopcion->nombre }}</td>

                  <td class="text-secondary text-center">
                    @if($item->activo==1)
                      <span class="badge bg-success">Sí</span>
                    @else
                      <span class="badge bg-danger">No</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <a href="{{ route('modificar.opciones.mto', [$idopcion,$item->hash])}}" class="btn btn-sm btn-outline-primary">
                      <i class="material-symbols-outlined fs-18">edit</i>
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
{{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

  console.log("Página de bienvenida cargada correctamente");

  // 1) Verificar que jQuery exista
  if (typeof $ === 'undefined') {
    console.warn("jQuery no está disponible todavía.");
    return;
  }

  // 2) Verificar que DataTables esté cargado
  if (typeof $.fn.DataTable === 'undefined') {
    console.warn("DataTables no está cargado, no se inicializará.");
    return;
  }

  // 3) Verificar si la tabla existe en la página actual
  if ($("#opcionesTable").length) {
    $('#opcionesTable').DataTable({
      responsive: true,
      autoWidth: false,
      language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
    });
  } else {
    console.log("opcionesTable no está presente.");
  }

});
</script>

@endpush





