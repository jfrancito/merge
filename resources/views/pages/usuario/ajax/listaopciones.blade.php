<div class="table-responsive">
  <table class="table table-hover align-middle">
    <thead class="table-light">
      <tr>
        <th class="text-secondary fw-semibold" style="width: 50%;">
          <i class="ri-list-check me-2"></i>
          Opciones
        </th>
        <th class="text-center text-secondary fw-semibold" style="width: 12.5%;">
          <span data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">
            <i class="ri-eye-line"></i>
            <span class="d-none d-md-inline ms-1">Ver</span>
          </span>
        </th>
        <th class="text-center text-secondary fw-semibold" style="width: 12.5%;">
          <span data-bs-toggle="tooltip" data-bs-placement="top" title="Agregar">
            <i class="ri-add-circle-line"></i>
            <span class="d-none d-md-inline ms-1">Agregar</span>
          </span>
        </th>
        <th class="text-center text-secondary fw-semibold" style="width: 12.5%;">
          <span data-bs-toggle="tooltip" data-bs-placement="top" title="Modificar">
            <i class="ri-edit-line"></i>
            <span class="d-none d-md-inline ms-1">Modificar</span>
          </span>
        </th>
        <th class="text-center text-secondary fw-semibold" style="width: 12.5%;">
          <span data-bs-toggle="tooltip" data-bs-placement="top" title="Todas">
            <i class="ri-checkbox-multiple-line"></i>
            <span class="d-none d-md-inline ms-1">Todas</span>
          </span>
        </th>
      </tr>
    </thead>
    <tbody>

      @foreach($listaopciones as $item)
        <tr class="permiso-row">
          <td class="text-secondary">
            <div class="d-flex flex-column">
              <span class="fw-medium text-dark mb-1">
                <i class="ri-folder-2-line me-2 text-primary"></i>
                {{ $item->opcion->nombre }}
              </span>
              <small class="text-muted">
                <i class="ri-price-tag-3-line me-1"></i>
                {{ $item->opcion->grupoopcion->nombre }}
              </small>
            </div>
          </td>

          <!-- Ver -->
          <td class="text-center">
            <div class="form-check form-switch d-flex justify-content-center">
              <input 
                class="form-check-input cursor-pointer {{$item->hash}}"
                type="checkbox"
                role="switch"
                id="1{{$item->hash}}"
                @if ($item->ver == 1) checked @endif
                style="width: 2.5rem; height: 1.25rem;"
              >
              <label 
                class="form-check-label cursor-pointer ms-2 visually-hidden"
                for="1{{$item->hash}}"
                data-atr="ver"
                name="{{$item->hash}}">
                Ver
              </label>
            </div>
          </td>

          <!-- Agregar -->
          <td class="text-center">
            <div class="form-check form-switch d-flex justify-content-center">
              <input 
                class="form-check-input cursor-pointer {{$item->hash}}"
                type="checkbox"
                role="switch"
                id="2{{$item->hash}}"
                @if ($item->anadir == 1) checked @endif
                style="width: 2.5rem; height: 1.25rem;"
              >
              <label 
                class="form-check-label cursor-pointer ms-2 visually-hidden"
                for="2{{$item->hash}}"
                data-atr="anadir"
                name="{{$item->hash}}">
                Agregar
              </label>
            </div>
          </td>

          <!-- Modificar -->
          <td class="text-center">
            <div class="form-check form-switch d-flex justify-content-center">
              <input 
                class="form-check-input cursor-pointer {{$item->hash}}"
                type="checkbox"
                role="switch"
                id="3{{$item->hash}}"
                @if ($item->modificar == 1) checked @endif
                style="width: 2.5rem; height: 1.25rem;"
              >
              <label 
                class="form-check-label cursor-pointer ms-2 visually-hidden"
                for="3{{$item->hash}}"
                data-atr="modificar"
                name="{{$item->hash}}">
                Modificar
              </label>
            </div>
          </td>

          <!-- Todas -->
          <td class="text-center">
            <div class="form-check form-switch d-flex justify-content-center">
              <input 
                class="form-check-input cursor-pointer {{$item->hash}}"
                type="checkbox"
                role="switch"
                id="4{{$item->hash}}"
                @if ($item->todas == 1) checked @endif
                style="width: 2.5rem; height: 1.25rem;"
              >
              <label 
                class="form-check-label cursor-pointer ms-2 visually-hidden"
                for="4{{$item->hash}}"
                data-atr="todas"
                name="{{$item->hash}}">
                Todas
              </label>
            </div>
          </td>
        </tr>
      @endforeach

    </tbody>
  </table>
</div>

@if(_count($listaopciones) == 0)
  <div class="alert alert-info border-0 d-flex align-items-center" role="alert">
    <i class="ri-information-line fs-4 me-3"></i>
    <div>
      <strong>Sin permisos asignados</strong>
      <p class="mb-0">No hay opciones disponibles para este rol.</p>
    </div>
  </div>
@endif

<style>
.permiso-row {
  transition: all 0.2s ease;
}

.permiso-row:hover {
  background-color: #f8f9fa;
}

.form-check-input:checked {
  background-color: #605dff;
  border-color: #605dff;
}

.form-check-input:focus {
  border-color: #605dff;
  box-shadow: 0 0 0 0.25rem rgba(96, 93, 255, 0.25);
}

.cursor-pointer {
  cursor: pointer;
}

.form-check-input {
  transition: all 0.3s ease;
}

.table-light {
  background-color: #f8f9fa;
  border-bottom: 2px solid #e9ecef;
}
</style>

<script>
// Re-inicializar tooltips después de cargar el contenido AJAX
document.addEventListener('DOMContentLoaded', function() {
  initializeTooltips();
});

// Función para inicializar tooltips (también se llama después de AJAX)
function initializeTooltips() {
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    // Destruir tooltip existente si hay
    const existingTooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
    if (existingTooltip) {
      existingTooltip.dispose();
    }
    // Crear nuevo tooltip
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
}

// Llamar a la función después de que se cargue el contenido AJAX
setTimeout(initializeTooltips, 100);
</script>