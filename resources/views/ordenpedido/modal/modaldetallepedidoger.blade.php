@php
    $cod_usuario_session = Session::get('usuario')->usuarioosiris_id ?? null;
@endphp

<!-- HEADER -->
<div class="modal-header text-white border-0"
     style="background: linear-gradient(135deg, #0b1a3d, #1f2a50);">
<h5 class="modal-title fw-semibold text-center w-100">
    <div class="d-flex justify-content-center align-items-center mb-1">
        <i class="bi bi-receipt me-2 opacity-75"></i>
        <span>DETALLE DEL PEDIDO (GERENCIA)</span>
    </div>

    <span class="d-block fw-medium pedido-numero">
        N° {{ $pedido->ID_PEDIDO ?? '' }}
    </span>
</h5>
</div>

<!-- BODY -->
<div class="modal-body p-0 bg-light">

@php
    $mostrarJefe = false;
    $total_general = 0;

    foreach($pedillodetalle as $item){
        if(!is_null($item->CAN_MODIF_JEF_AUT)){
            $mostrarJefe = true;
            break;
        }
    }
@endphp

<div class="table-responsive detalle-scroll">
<table class="table table-hover align-middle mb-0 detalle-table">

<thead class="text-white sticky-top detalle-thead">
<tr class="text-uppercase small">
    <th style="width:5%" class="text-center">#</th>
    <th style="width:30%">Producto</th>
    <th style="width:20%">Categoría</th>
    <th style="width:5%" class="text-center">Cant.</th>
    <th style="width:5%" class="text-center">Precio.</th>

    @if($mostrarJefe)
        <th style="width:10%" class="text-center">Cant. Jefe</th>
    @endif

    <th style="width:35%">Observación</th>
</tr>
</thead>

<tbody>
@forelse($pedillodetalle as $index => $detalle)

@php
    $cantidad_original = $detalle->CANTIDAD;
    $cantidad_jefe     = $detalle->CAN_MODIF_JEF_AUT;
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

    {{-- CANTIDAD ORIGINAL --}}
    <td class="text-center">

        @if (
            !$mostrarJefe &&
            $pedido->COD_TRABAJADOR_APRUEBA_GER == $cod_usuario_session &&
            $pedido->COD_ESTADO == 'ETM0000000000013'
        )

            <input type="number"
                   class="form-control text-center input-cantidad-editar"
                   value="{{ (int)$cantidad_original }}"
                   min="1"
                   data-id="{{ $detalle->ID_PEDIDO }}"
                   data-prod="{{ $detalle->COD_PRODUCTO }}"
                   style="width: 70px; margin: 0 auto; font-weight: bold;">

        @else

            <span class="badge badge-cantidad">
                {{ $cantidad_original }}
            </span>

        @endif

    </td>

    {{-- COLUMNA JEFE SOLO SI EXISTE MODIFICACIÓN --}}
    @if($mostrarJefe)
    <td class="text-center">

        @if (
            $pedido->COD_TRABAJADOR_APRUEBA_GER == $cod_usuario_session &&
            $pedido->COD_ESTADO == 'ETM0000000000013' &&
            !is_null($cantidad_jefe)
        )

            <input type="number"
                   class="form-control text-center input-cantidad-editar"
                   value="{{ (int)$cantidad_jefe }}"
                   min="1"
                   data-id="{{ $detalle->ID_PEDIDO }}"
                   data-prod="{{ $detalle->COD_PRODUCTO }}"
                   style="width: 70px; margin: 0 auto; font-weight: bold;">

        @else

            <span class="badge badge-cantidad">
                {{ $cantidad_jefe ?? '—' }}
            </span>

        @endif

    </td>
    @endif
    
    <td class="fw-semibold text-truncate text-center"
        title="{{ $detalle->CAN_PRECIO }}">
        {{ number_format($detalle->CAN_PRECIO, 2) }}
    </td>

    @php
        $total_general += ($detalle->CANTIDAD * $detalle->CAN_PRECIO);
    @endphp

    <td class="text-truncate observacion"
        title="{{ $detalle->TXT_OBSERVACION }}">
        {{ $detalle->TXT_OBSERVACION ?: '—' }}
    </td>
</tr>

@empty
<tr>
    <td colspan="{{ $mostrarJefe ? 6 : 5 }}" class="text-center text-muted fst-italic py-4">
        No hay productos en este pedido.
    </td>
</tr>
@endforelse
</tbody>

<tfoot style="background: #f8f9fa; color: #1f2a50; border-top: 2px solid #dee2e6;">
    <tr>
        <td colspan="{{ 6 + ($mostrarJefe ? 1 : 0) }}" class="text-right py-3 px-4" style="border:none;">
            <span class="fw-bold" style="font-size: 1.4rem; font-weight: 900;">
                TOTAL: S/ {{ number_format($total_general, 2) }}
            </span>
        </td>
    </tr>
</tfoot>

</table>
</div>
</div>

<!-- FOOTER -->
<div class="modal-footer d-flex justify-content-center align-items-center bg-light" 
     style="margin-top:-10px; border-top:1px solid #dee2e6;">

@if (
    $pedido->COD_TRABAJADOR_APRUEBA_GER == $cod_usuario_session &&
    $pedido->COD_ESTADO == 'ETM0000000000013'
)
<button type="button" 
        class="btn btn-success btn-space btn-editar-cantidades-ger"
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
    max-height: 60vh;
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

.badge-total {
    background: linear-gradient(135deg, #e6fffa, #b2f5ea);
    color: #2c7a7b;
    font-size: 1.1rem;
    font-weight: 900;
    padding: 8px 18px;
    border-radius: 10px;
    box-shadow: inset 0 0 0 1px rgba(44,122,123,.15);
    display: inline-block;
}


/* ===== OBSERVACION ===== */
.observacion {
    font-size: .9rem;
    color: #495057;
}

/* ===== FOOTER ===== */
.modal-footer {
    backdrop-filter: blur(4px);
    box-shadow: 0 -4px 14px rgba(0,0,0,.08);
}
</style>