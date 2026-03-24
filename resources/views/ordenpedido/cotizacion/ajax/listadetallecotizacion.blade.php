<div id="modal-detalle-cotizacion" class="modal-container colored-header colored-header-primary modal-effect-8" style="width: 80%; max-width: 1000px;">
    <div class="modal-content">
        <!-- HEADER -->
        <div class="modal-header" style="background: #1d3a6d; color: #fff;">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close">
                <span class="mdi mdi-close"></span>
            </button>
            <h3 class="modal-title text-center" style="font-weight: 800; color: #fff;">
                DETALLE DE COTIZACIÓN: {{ $lista_detalle->first()->ID_COTIZACION ?? 'N/A' }}
            </h3>
        </div>

        <!-- BODY -->
        <div class="modal-body p-0 bg-light">
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0 8px;">
                    <thead style="background: #eef1f7; color: #1d3a6d;">
                        <tr class="text-uppercase small">
                            <th style="width:5%" class="text-center">#</th>
                            <th style="width:30%">Producto</th>
                            <th style="width:15%">Familia</th>
                            <th style="width:15%">Medida</th>
                            <th style="width:10%" class="text-center">Cant.</th>
                            <th style="width:10%" class="text-right">Precio</th>
                            <th style="width:15%" class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lista_detalle as $index => $detalle)
                        <tr style="background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                            <td class="text-center fw-semibold text-muted">{{ $index + 1 }}</td>
                            <td class="fw-bold" style="color: #1d3a6d;">{{ $detalle->NOM_PRODUCTO }}</td>
                            <td><span class="label label-info">{{ $detalle->NOM_CATEGORIA_FAMILIA }}</span></td>
                            <td>{{ $detalle->NOM_CATEGORIA_MEDIDA }}</td>
                            <td class="text-center">
                                <span class="badge" style="background: #eef1f7; color: #1d3a6d; font-weight: 800; padding: 5px 10px; font-size: 14px;">
                                    {{ number_format($detalle->CANTIDAD, 2) }}
                                </span>
                            </td>
                            <td class="text-right">{{ number_format($detalle->CAN_PRECIO, 2) }}</td>
                            <td class="text-right fw-bold" style="color: #1d3a6d;">
                                {{ number_format($detalle->CANTIDAD * $detalle->CAN_PRECIO, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No hay productos registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary modal-close">
                <i class="fa fa-times"></i> Cerrar
            </button>
        </div>
    </div>
</div>

<style>
.detalle-table thead th {
    padding: 12px;
    border: none;
}
.detalle-table tbody td {
    padding: 12px;
    vertical-align: middle;
    border: none;
}
</style>
