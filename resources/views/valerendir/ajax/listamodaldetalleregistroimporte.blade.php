<table id="tabla_vale_rendir_detalle"
       class="table table-hover table-bordered align-middle mb-0"
       style="font-style: italic; background-color: #fff;">
    <thead class="table-primary text-center">
        <tr>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Destino</th>
            <th>Tipos</th>
            <th>Días</th>
            <th>Costo Unitario</th>
            <th>Costo Uni × (días)</th>
            <th>Importe</th>
            <th style="display:none;">Indicador</th>

            @if(isset($areacomercial) && strtoupper($areacomercial) == 'COMERCIAL')
                <th>Monto Aprox. Venta</th>
                <th>Monto Aprox. Cobranza</th>
            @endif

            <th>Anular</th>
        </tr>
    </thead>

    <tbody class="text-center small">
        {{-- Las filas dinámicas se agregan desde JS --}}
    </tbody>
    <tfoot>
        @php
            $colspan = isset($areacomercial) && strtoupper($areacomercial) == 'COMERCIAL' ? 10 : 8;
        @endphp
        <tr id="fila_total">
            <!-- Celda TOTAL alineada a la derecha mediante div -->
            <td colspan="{{ $colspan }}">
                <div style="text-align: right; font-weight: bold;">TOTAL:</div>
            </td>
            <!-- Celda del importe -->
            <td id="suma_total_importe" class="fw-bold">0.00</td>
        </tr>
    </tfoot>
</table>

<style>
/* Estilo general */
#tabla_vale_rendir_detalle {
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 10px;
    margin-top: 20px;
}

/* Encabezado */
#tabla_vale_rendir_detalle thead th {
    background-color: #1d3a6d;
    color: #fff;
    font-weight: 600;
    white-space: normal; /* permite que el texto se rompa */
    word-wrap: break-word;
    vertical-align: middle;
}

/* Celdas */
#tabla_vale_rendir_detalle td {
    vertical-align: middle;
    background-color: #fff;
    white-space: normal; /* permite que el texto se rompa */
    word-wrap: break-word;
}

/* Hover elegante */
#tabla_vale_rendir_detalle tbody tr:hover {
    background-color: #f1f5ff;
    transition: 0.2s;
}

/* Footer */
#tabla_vale_rendir_detalle tfoot td {
    background-color: #f8f9fa;
    border-top: 2px solid #dee2e6;
    font-weight: bold;
    color: #1d3a6d;
}

/* Botón eliminar */
.btn.eliminarFila {
    padding: 4px 8px;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn.eliminarFila:hover {
    background-color: #dc3545 !important;
    color: #fff;
    transform: scale(1.05);
}

/* Responsive: ajuste de font-size y padding */
@media (max-width: 768px) {
    #tabla_vale_rendir_detalle th,
    #tabla_vale_rendir_detalle td {
        font-size: 0.75rem;
        padding: 4px;
    }
}
</style>
