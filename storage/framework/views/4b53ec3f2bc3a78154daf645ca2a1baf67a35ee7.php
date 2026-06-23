<div class="table-responsive shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid #cbd5e1; background: #ffffff;">
    <table id="tabla_vale_rendir_detalle"
           class="table table-hover align-middle mb-0"
           style="background-color: #ffffff;">
        <thead>
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

                <?php if(isset($areacomercial) && strtoupper($areacomercial) == 'VENTAS'): ?>
                    <th>Monto Aprox. Venta</th>
                    <th>Monto Aprox. Cobranza</th>
                <?php endif; ?>

                <th>Anular</th>
            </tr>
        </thead>

        <tbody class="text-center">
            
        </tbody>
        <tfoot>
            <?php 
                $colspan = isset($areacomercial) && strtoupper($areacomercial) == 'VENTAS' ? 10 : 8;
             ?>
            <tr id="fila_total">
                <!-- Celda TOTAL alineada a la derecha mediante div -->
                <td colspan="<?php echo e($colspan); ?>">
                    <div style="text-align: right; font-weight: bold; letter-spacing: 0.05em; font-size: 0.95rem;">TOTAL:</div>
                </td>
                <!-- Celda del importe -->
                <td id="suma_total_importe">0.00</td>
            </tr>
        </tfoot>
    </table>
</div>

<style>
/* Forzar contenedor responsivo con scroll horizontal suave en móviles */
.table-responsive {
    display: block !important;
    width: 100% !important;
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
}

/* Estilo general de la tabla premium corporativa */
#tabla_vale_rendir_detalle {
    border-collapse: collapse;
    width: 100%;
    background-color: #ffffff;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: #0f172a;
    border: 1.5px solid #cbd5e1 !important;
}

/* Encabezado elegante con el color azul corporativo #1d3a6d, más grande y legible */
#tabla_vale_rendir_detalle thead th {
    background-color: #1d3a6d !important;
    color: #ffffff;
    font-weight: 700;
    font-size: 1.1rem;
    letter-spacing: 0.02em;
    padding: 18px 20px;
    border: 1.5px solid #cbd5e1 !important; /* Renglones entre columnas en el encabezado */
    vertical-align: middle;
    text-align: center;
    white-space: normal !important; /* Permitir que el texto largo se envuelva de forma elegante */
    word-break: break-word;
}

/* Celdas con alto nivel de contraste, más amplias y legibles, con borde de fila y columna bien definido */
#tabla_vale_rendir_detalle td {
    padding: 16px 20px;
    font-size: 1.1rem;
    color: #0f172a;
    font-weight: 500;
    vertical-align: middle;
    border: 1.5px solid #cbd5e1 !important; /* Renglones completos entre columnas y filas */
    white-space: normal;
    word-wrap: break-word;
}

/* Diferenciación de filas mediante cebra (Zebra striping) */
#tabla_vale_rendir_detalle tbody tr:nth-child(odd) td {
    background-color: #f8fafc !important; /* Renglón impar ligeramente grisáceo */
}

#tabla_vale_rendir_detalle tbody tr:nth-child(even) td {
    background-color: #ffffff !important; /* Renglón par blanco */
}

/* Animación y efecto Hover refinado */
#tabla_vale_rendir_detalle tbody tr {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

#tabla_vale_rendir_detalle tbody tr:hover td {
    background-color: #e2e8f0 !important; /* Renglón en hover más destacado */
    color: #000000;
}

#tabla_vale_rendir_detalle tbody tr:hover {
    box-shadow: inset 4px 0 0 #1d3a6d, 0 4px 12px rgba(0, 0, 0, 0.03);
}

/* Footer modernizado y de mayor tamaño */
#tabla_vale_rendir_detalle tfoot td {
    background-color: #f8fafc !important;
    border-top: 3px double #1d3a6d !important;
    border: 1.5px solid #cbd5e1 !important;
    font-weight: 700;
    color: #1d3a6d;
    padding: 18px 20px;
    font-size: 1.15rem;
}

#tabla_vale_rendir_detalle #suma_total_importe {
    color: #1d3a6d;
    font-size: 1.4rem;
    font-weight: 800;
    text-align: center;
    background-color: #f8fafc !important;
}

/* Botón de eliminación Premium, más visible y amigable al clic */
.btn.eliminarFila {
    background-color: #fee2e2;
    color: #ef4444;
    border: 1px solid #fca5a5;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    cursor: pointer;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.btn.eliminarFila:hover {
    background-color: #ef4444 !important;
    color: #ffffff !important;
    border-color: #dc2626;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
    transform: translateY(-1px);
}

.btn.eliminarFila:active {
    transform: translateY(0);
}

/* Responsividad adaptativa premium y ultra-fluida */
@media (max-width: 992px) {
    #tabla_vale_rendir_detalle {
        min-width: 950px !important; /* Asegurar que la tabla no se colapse ilegiblemente y active scroll lateral */
    }
    #tabla_vale_rendir_detalle th {
        font-size: 0.95rem;
        padding: 12px 14px;
    }
    #tabla_vale_rendir_detalle td {
        font-size: 0.95rem;
        padding: 12px 14px;
    }
}

@media (max-width: 768px) {
    #tabla_vale_rendir_detalle th {
        font-size: 0.9rem;
        padding: 10px 12px;
    }
    #tabla_vale_rendir_detalle td {
        font-size: 0.9rem;
        padding: 10px 12px;
    }
    .btn.eliminarFila {
        padding: 6px 12px;
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    #tabla_vale_rendir_detalle th {
        font-size: 0.85rem;
        padding: 8px 10px;
    }
    #tabla_vale_rendir_detalle td {
        font-size: 0.85rem;
        padding: 8px 10px;
    }
    #tabla_vale_rendir_detalle #suma_total_importe {
        font-size: 1.15rem;
    }
    .btn.eliminarFila {
        padding: 4px 8px;
        font-size: 0.775rem;
    }
}
</style>
