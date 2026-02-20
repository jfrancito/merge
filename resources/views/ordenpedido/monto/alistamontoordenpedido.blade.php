<div class="card shadow-sm pedido-card mb-4">

    <div class="pedido-header">
        <i class="fa fa-clipboard-list me-2"></i> LISTA MONTOS ORDEN PEDIDO
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>COD MONTO</th>
                        <th>AREA</th>
                        <th>MONTO</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($listamontopedido as $item)
                        <tr class="fila-monto" 
                            data-codmonto="{{ $item['COD_MONTO'] }}"
                            data-codarea="{{ $item['COD_AREA'] }}"
                            data-area="{{ $item['TXT_AREA'] }}"
                            data-monto="{{ (int)$item['MONTO'] }}">
                            <td>{{ $item['COD_MONTO'] }}</td>
                            <td>{{ $item['TXT_AREA'] }}</td>
                            <td>{{ $item['MONTO'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    .pedido-card {
        border-radius: 6px;
        border: none;
    }

    .pedido-header {
        background: linear-gradient(90deg, #1d3a6d, #2c4f91);
        color: #fff;
        font-weight: 600;
        padding: 14px 18px;
        font-size: 15px;
        border-radius: 6px 6px 0 0;
    }

    .table thead th {
        background: #f3f5f9;
        font-size: 13px;
        font-weight: 600;
        color: #333;
        text-transform: uppercase;
        border-bottom: 2px solid #dee2e6;
        white-space: nowrap;
    }

    /* GENERAL */
    .table tbody td {
        font-size: 13px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fc;
    }

    .fila-monto-activa {
        background-color: #e3f2fd !important;
        font-weight: 600;
    }

</style>
