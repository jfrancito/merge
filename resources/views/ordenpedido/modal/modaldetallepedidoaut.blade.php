@php
    $cod_usuario_session = Session::get('usuario')->usuarioosiris_id ?? null;
@endphp

<!-- HEADER -->
<div class="modal-header text-white border-0"
     style="background: linear-gradient(135deg, #0b1a3d, #1f2a50);">
<h5 class="modal-title fw-semibold text-center w-100">
    <div class="d-flex justify-content-center align-items-center mb-1">
        <i class="bi bi-receipt me-2 opacity-75"></i>
        <span>DETALLE DEL PEDIDO (AUTORIZACIÓN)</span>
    </div>

    <span class="d-block fw-medium pedido-numero">
        N° {{ $pedido->ID_PEDIDO ?? '' }}
    </span>
</h5>
</div>


<!-- BODY -->
<div class="modal-body p-0 bg-light">

  <div class="table-responsive detalle-scroll">

    <table class="table table-hover align-middle mb-0 detalle-table">

      <thead class="text-white sticky-top detalle-thead">
        <tr class="text-uppercase small">
          <th style="width:5%" class="text-center">#</th>
          <th style="width:25%">Producto</th>
          <th style="width:15%">Categoría</th>
          <th style="width:10%" class="text-center">Cant.</th>
          <th style="width:15%" class="text-right">Precio</th>
          <th style="width:15%" class="text-right">Total</th>
          <th style="width:15%">Observación</th>
        </tr>
      </thead>

      <tbody>
        @php $suma_total_general = 0; @endphp
        @forelse($pedillodetalle as $index => $detalle)
        @php
        // Determinar la cantidad que se va a mostrar
        $cantidad_mostrar = $detalle->CAN_MODIF_ADM 
                             ?? $detalle->CAN_MODIF_GER 
                             ?? $detalle->CAN_MODIF_JEF_AUT 
                             ?? $detalle->CANTIDAD;
        
        $precio = $detalle->CAN_PRECIO ?? 0;
        $subtotal = $cantidad_mostrar * $precio;
        $suma_total_general += $subtotal;
        @endphp
        <tr>
          <td class="text-center fw-semibold text-muted">
            {{ $index + 1 }}
          </td>

          <td class="fw-semibold text-truncate"
              title="{{ $detalle->NOM_PRODUCTO }}">
            {{ $detalle->NOM_PRODUCTO }}
          </td>

          <td class="text-truncate text-secondary"
              title="{{ $detalle->NOM_CATEGORIA }}">
            {{ $detalle->NOM_CATEGORIA }}
          </td>

          <td class="text-center">
            @if (
            $pedido->COD_TRABAJADOR_AUTORIZA == $cod_usuario_session &&
            $pedido->COD_ESTADO == 'ETM0000000000010'
            )

            <input type="number" 
                       class="form-control text-center input-cantidad-editar" 
                       value="{{ (int)$cantidad_mostrar  }}"
                       min="1"
                       data-id="{{ $detalle->ID_PEDIDO }}"
                       data-prod="{{ $detalle->COD_PRODUCTO }}"
                       style="width: 70px; margin: 0 auto; font-weight: bold;">
            @else
                <span class="badge badge-cantidad">
                  {{ $cantidad_mostrar  }}
                </span>
            @endif
          </td>

          <td class="text-right fw-bold text-success">
            S/ {{ number_format($precio, 2, '.', ',') }}
          </td>
          
          <td class="text-right fw-bold" style="color:#1f2a50;">
            S/ {{ number_format($subtotal, 2, '.', ',') }}
          </td>

          <td class="text-truncate observacion"
              title="{{ $detalle->TXT_OBSERVACION }}">
            {{ $detalle->TXT_OBSERVACION ?: '—' }}
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center text-muted fst-italic py-4">
            No hay productos en este pedido.
          </td>
        </tr>
        @endforelse
      </tbody>
      <tfoot>
        <tr style="background-color: #f8f9fa;">
            <td colspan="5" class="text-right fw-bold" style="font-size: 1.1rem; color: #1f2a50;">TOTAL GENERAL:</td>
            <td class="text-right fw-bold" style="font-size: 1.2rem; color: #d9534f;">
                S/ {{ number_format($suma_total_general, 2, '.', ',') }}
            </td>
            <td></td>
        </tr>
      </tfoot>

    </table>
  </div>
    @if(isset($pedido->TXT_GLOSA_RECHAZO) && !empty($pedido->TXT_GLOSA_RECHAZO))
      <div class="alert alert-danger mx-3 my-3" style="border-left: 5px solid #d9534f; background-color: #fdf2f2; border-radius: 8px; box-shadow: 0 2px 8px rgba(217, 83, 79, 0.1);">
          <h5 class="fw-bold mb-1" style="color: #d9534f; font-size: 1.1rem;"><i class="fa fa-times-circle"></i> MOTIVO DEL RECHAZO:</h5>
          <p class="mb-0" style="font-size: 1rem; font-weight: 500; color: #000 !important;">{{ $pedido->TXT_GLOSA_RECHAZO }}</p>
      </div>
    @endif
</div>

 <div class="modal-footer d-flex justify-content-center align-items-center bg-light" 
       style="margin-top:-10px; border-top:1px solid #dee2e6;">
    @if (
    $pedido->COD_TRABAJADOR_AUTORIZA == $cod_usuario_session &&
    $pedido->COD_ESTADO == 'ETM0000000000010'
    )

    <button type="button" 
            class="btn btn-success btn-space btn-editar-cantidades-aut"
            data-id="{{ $pedido->ID_PEDIDO ?? '' }}"
            style="margin: 5px;">
      <i class="fa fa-edit"></i> Editar
    </button>
    @endif
    <button type="button" data-dismiss="modal" 
            class="btn btn-primary btn-space modal-close"
            style="margin: 5px;">
      Cerrar
    </button>
  </div>


<style>/* ===== HEADER ===== */
.modal-header {
    backdrop-filter: blur(6px);
    box-shadow: 0 8px 24px rgba(0,0,0,.25);
}

.modal-title small {
    font-size: .8rem;
    letter-spacing: .12em;
}
.pedido-numero {
    font-size: 1.6rem;
    font-weight: 900;
    letter-spacing: .22em;
}



/* ===== SCROLL ===== */
.detalle-scroll {
    max-height: 45vh;     /* altura controlada: deja espacio al header y footer */
    overflow-y: auto;
    background: linear-gradient(180deg, #f9fafc, #eef1f7);
}

.detalle-scroll::-webkit-scrollbar {
    width: 5px;
}

.detalle-scroll::-webkit-scrollbar-thumb {
    background: rgba(31,42,80,.35);
    border-radius: 10px;
}

/* ===== TABLE ===== */
.detalle-table {
    border-collapse: separate;
    border-spacing: 0 8px; /* separación tipo cards */
    font-size: .94rem;
}

/* ===== THEAD ===== */
.detalle-thead th {
    background: #1f2a50;
    font-weight: 600;
    letter-spacing: .08em;
    padding: 16px 14px;
    border: none;
}

/* ===== ROWS (CARD STYLE) ===== */
.detalle-table tbody tr {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,.06);
    transition: transform .25s ease, box-shadow .25s ease;
}

.detalle-table tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(0,0,0,.12);
}

/* ===== CELLS ===== */
.detalle-table td {
    padding: 14px 14px;
    border: none;
    vertical-align: middle;
}

.detalle-table td:first-child {
    border-radius: 14px 0 0 14px;
}

.detalle-table td:last-child {
    border-radius: 0 14px 14px 0;
}

/* ===== PRODUCTO ===== */
.detalle-table td:nth-child(2) {
    font-weight: 900;
    color: #1f2a50;
}

/* ===== CATEGORIA ===== */
.detalle-table td:nth-child(3) {
    font-size: 1.25rem;
    color: #6c757d;
}

/* ===== BADGE CANTIDAD ===== */
.badge-cantidad {
    background: linear-gradient(135deg, #e7efff, #d6e2ff);
    color: #1f4ed8;
      font-size: 1.45rem;   /* ⬅ aquí lo agrandas */
    font-weight: 900;
    padding: 10px 22px;
    border-radius: 999px;
    box-shadow: inset 0 0 0 1px rgba(31,78,216,.15);
}


/* ===== OBSERVACION ===== */
.observacion {
    font-size: .9rem;
    color: #495057;
}

/* ===== EMPTY ===== */
tbody tr td[colspan] {
    background: transparent !important;
    box-shadow: none !important;
}

/* ===== FOOTER ===== */
.modal-footer {
    backdrop-filter: blur(4px);
    box-shadow: 0 -4px 14px rgba(0,0,0,.08);
}
</style>