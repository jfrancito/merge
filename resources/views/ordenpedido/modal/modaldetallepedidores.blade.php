<!-- HEADER -->
<div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #0b1a3d, #1f2a50);">
    <h5 class="modal-title fw-semibold text-center w-100">
        <div class="d-flex justify-content-center align-items-center mb-1">
            <i class="bi bi-receipt me-2 opacity-75"></i>
            <span>DETALLE DEL PEDIDO</span>
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
            @php
                $mostrarJefe = false;
                $mostrarGer = false;
                $mostrarAdm = false;

                foreach ($pedillodetalle as $item) {
                    if (!is_null($item->CAN_MODIF_JEF_AUT)) {
                        $mostrarJefe = true;
                    }
                    if (!is_null($item->CAN_MODIF_GER)) {
                        $mostrarGer = true;
                    }
                    if (!is_null($item->CAN_MODIF_ADM)) {
                        $mostrarAdm = true;
                    }
                }
                $total_general = 0;
            @endphp

            <thead class="text-white sticky-top detalle-thead">
                <tr class="text-uppercase small">
                    <th class="text-center">#</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th class="text-center">Cant.</th>
                    @if($mostrarJefe)
                    <th class="text-center">Cant. Jefe</th> @endif
                    @if($mostrarGer)
                    <th class="text-center">Cant. Gerencia</th>@endif
                    @if($mostrarAdm)
                    <th class="text-center">Cant. Admin</th>@endif
                    <th>Observación</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pedillodetalle as $index => $detalle)
                    <tr>
                        <td class="text-center fw-semibold text-muted">
                            {{ $index + 1 }}
                        </td>

                        <td class="fw-semibold" title="{{ $detalle->NOM_PRODUCTO }}">
                            {{ $detalle->NOM_PRODUCTO }}
                        </td>

                        <td class="text-secondary" title="{{ $detalle->NOM_CATEGORIA }}">
                            {{ $detalle->NOM_CATEGORIA }}
                        </td>

                        {{-- CANTIDAD ORIGINAL (SIEMPRE SE MUESTRA) --}}
                        <td class="text-center">
                            <span class="badge badge-cantidad">
                                {{ $detalle->CANTIDAD }}
                            </span>
                        </td>
                        {{-- CANTIDAD JEFE --}}
                        @if($mostrarJefe)
                            <td class="text-center">
                                @if(!is_null($detalle->CAN_MODIF_JEF_AUT))
                                    <span class="badge badge-cantidad">
                                        {{ $detalle->CAN_MODIF_JEF_AUT }}
                                    </span>
                                @else
                                    —
                                @endif
                            </td>
                        @endif

                        {{-- CANTIDAD GERENCIA --}}
                        @if($mostrarGer)
                            <td class="text-center">
                                @if(!is_null($detalle->CAN_MODIF_GER))
                                    <span class="badge badge-cantidad">
                                        {{ $detalle->CAN_MODIF_GER }}
                                    </span>
                                @else
                                    —
                                @endif
                            </td>
                        @endif

                        {{-- CANTIDAD ADMIN --}}
                        @if($mostrarAdm)
                            <td class="text-center">
                                @if(!is_null($detalle->CAN_MODIF_ADM))
                                    <span class="badge badge-cantidad">
                                        {{ $detalle->CAN_MODIF_ADM }}
                                    </span>
                                @else
                                    —
                                @endif
                            </td>
                        @endif

                        <td class="observacion" title="{{ $detalle->TXT_OBSERVACION }}">
                            {{ $detalle->TXT_OBSERVACION ?: '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted fst-italic py-4">
                            No hay productos en este pedido.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
    @if(isset($pedido->TXT_GLOSA_RECHAZO) && !empty($pedido->TXT_GLOSA_RECHAZO))
        <div class="alert alert-danger mx-3 my-3"
            style="border-left: 5px solid #d9534f; background-color: #fdf2f2; border-radius: 8px; box-shadow: 0 2px 8px rgba(217, 83, 79, 0.1);">
            <h5 class="fw-bold mb-1" style="color: #d9534f; font-size: 1.1rem;"><i class="fa fa-times-circle"></i> MOTIVO
                DEL RECHAZO:</h5>
            <p class="mb-0" style="font-size: 1rem; font-weight: 500; color: #000 !important;">
                {{ $pedido->TXT_GLOSA_RECHAZO }}
            </p>
        </div>
    @endif
</div>

<div class="modal-footer justify-content-center bg-light" style="margin-top:-10px; border-top:1px solid #ffffffff;">
    <button type="button" data-dismiss="modal" class="btn btn-primary btn-space modal-close">
        Cerrar
    </button>
</div>


<style>
    /* ===== HEADER ===== */
    .modal-header {
        backdrop-filter: blur(6px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .25);
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
        background: rgba(31, 42, 80, .35);
        border-radius: 10px;
    }

    /* ===== TABLE ===== */
    .detalle-table {
        border-collapse: separate;
        border-spacing: 0 8px;
        /* separación tipo cards */
        font-size: .94rem;
    }

    /* ===== THEAD ===== */
    .detalle-thead th {
        background: #f1f3f5;
        /* gris claro */
        color: #212529;
        /* negro/gris oscuro */
        font-weight: 600;
        letter-spacing: .08em;
        padding: 16px 14px;
        border: none;
    }

    /* ===== ROWS (CARD STYLE) ===== */
    .detalle-table tbody tr {
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .detalle-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .12);
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
        font-size: 1.20rem;
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
        font-size: 1.45rem;
        /* ⬅ aquí lo agrandas */
        font-weight: 900;
        padding: 10px 22px;
        border-radius: 999px;
        box-shadow: inset 0 0 0 1px rgba(31, 78, 216, .15);
    }


    /* ===== OBSERVACION ===== */
    .observacion {
        font-size: 1.35rem;
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
        box-shadow: 0 -4px 14px rgba(0, 0, 0, .08);
    }

    /* Forzar ancho similar a otros modales */
    .modal-container {
        width: 80% !important;
        max-width: 1000px !important;
    }
</style>