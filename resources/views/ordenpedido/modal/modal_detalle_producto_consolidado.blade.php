<div id="modal-detalle-producto-consolidado"
     class="modal-container colored-header colored-header-primary modal-effect-8">

    <div class="modal-content">

        <div class="modal-header text-white border-0"
             style="background: linear-gradient(135deg, #0b1a3d, #1f2a50);">
            <h5 class="modal-title fw-semibold text-center w-100">
                 <div class="d-flex justify-content-center align-items-center mb-1">
                    <i class="bi bi-receipt me-2 opacity-75"></i>
                    <span>DETALLE DEL CONSOLIDADO</span>
                </div>
                <span id="modal-producto-nombre"></span>
            </h5>
        </div>

        <div class="modal-body">
            <div class="table-responsive detalle-scroll">
                <table class="table table-hover table-bordered detalle-table"
                       id="tablaDetalleProducto">
                    <thead class="detalle-thead">
                        <tr>
                            <th class="text-center" style="width:10%">FECHA</th>
                            <th class="text-center">NRO PEDIDO</th>
                            <th class="text-center">AREA</th>
                            <th class="text-center">GLOSA</th>
                            <th class="text-center">CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Se llena dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-footer justify-content-center bg-light" 
               style="margin-top:-10px; border-top:1px solid #dee2e6;">
            <button type="button" data-dismiss="modal" 
                    class="btn btn-primary btn-space modal-close">
              Cerrar
            </button>
        </div>

    </div>
</div>

<style>
    
    /* ===== MODAL ===== */
.modal-header {
    backdrop-filter: blur(6px);
    box-shadow: 0 8px 24px rgba(0,0,0,.25);
}

.modal-footer {
    backdrop-filter: blur(4px);
    box-shadow: 0 -4px 14px rgba(0,0,0,.08);
}

/* ===== SCROLL TABLA ===== */
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
/* ===== CELLS ===== */
.detalle-table td {
    padding: 14px;
    border: none;
    vertical-align: middle;
}

/* ===== GLOSA MÁS GRANDE ===== */
#tablaDetalleProducto tbody td:nth-child(4) {
    font-size: 1.05rem;
    color: #495057;
    font-weight: 500;
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
    padding: 14px;
    border: none;
    vertical-align: middle;
}

.detalle-table td:first-child {
    border-radius: 14px 0 0 14px;
}

.detalle-table td:last-child {
    border-radius: 0 14px 14px 0;
}

/* ===== BADGE CANTIDAD ===== */
.badge-cantidad {
    background: linear-gradient(135deg, #e7efff, #d6e2ff);
    color: #1f4ed8;
    font-size: 1.15rem;
    font-weight: 900;
    padding: 10px 22px;
    border-radius: 999px;
}

</style>