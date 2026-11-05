@extends('layouts.app')

@section('content')
<style>
/* Corrección de z-index para Select2 y Modales Bootstrap */
.select2-container {
    z-index: 1000 !important;
}
.select2-container--open {
    z-index: 1060 !important;
}
.modal {
    z-index: 1055 !important;
}
.modal-backdrop {
    z-index: 1050 !important;
}
</style>
<div class="container-fluid">
    <!-- Encabezado de Página -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 text-white fw-bold">
                            <i class="ri-file-transfer-line me-2"></i> Facturación de Servicios Interempresa
                        </h3>
                        <p class="mb-0 text-white-50">
                            Consolide automáticamente las ventas por unidad de medida (sacos, bolsas, kilos, etc.) de sus empresas hermanas y emita la Factura Electrónica de Servicios.
                        </p>
                    </div>
                    @if($esSuperAdmin)
                    <div>
                        <button type="button" class="btn btn-light text-primary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalConfigEmpresas">
                            <i class="ri-settings-3-line me-1"></i> Configurar Empresas Autorizadas
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- NAVEGACIÓN PESTAÑAS: EMISIÓN VS HISTÓRICO -->
    <ul class="nav nav-pills nav-justified mb-4 bg-white p-2 rounded shadow-sm border" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold py-2 fs-15" id="tab-emision-tab" data-bs-toggle="pill" data-bs-target="#tab-emision" type="button" role="tab">
                <i class="ri-add-circle-line me-1 fs-18 align-middle"></i> 1. Emitir Factura de Servicio Interempresa
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2 fs-15" id="tab-historico-tab" data-bs-toggle="pill" data-bs-target="#tab-historico" type="button" role="tab" onclick="cargarHistoricoLiquidaciones()">
                <i class="ri-history-line me-1 fs-18 align-middle"></i> 2. Histórico de Liquidaciones Interempresa
            </button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <!-- PESTAÑA 1: EMISIÓN DE FACTURAS INTEREMPRESA -->
        <div class="tab-pane fade show active" id="tab-emision" role="tabpanel">

            <!-- PASO 1: Selección de Empresa y Periodo -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 text-dark fw-semibold">
                                <span class="badge bg-primary rounded-circle me-2">1</span> Seleccionar Empresa Origen y Rango de Fechas
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="formFiltroUnidades">
                                @csrf
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-5">
                                        <label for="empresa_origen_id" class="form-label fw-bold">Empresa Hermana a Facturar *</label>
                                        <select class="form-select select2" id="empresa_origen_id" name="empresa_origen_id" required>
                                            <option value="">-- Seleccione Empresa --</option>
                                            @foreach($empresasHermanas as $emp)
                                                <option value="{{ $emp->id }}" data-ruc="{{ $emp->ruc }}">
                                                    {{ $emp->nombre }} (RUC: {{ $emp->ruc }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="fecha_inicio" class="form-label fw-bold">Fecha Inicio *</label>
                                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                                               value="{{ date('Y-m-01') }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="fecha_fin" class="form-label fw-bold">Fecha Fin *</label>
                                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                                               value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary w-100 fw-bold" id="btnConsultar">
                                            <i class="ri-search-line me-1"></i> Consultar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenedor de Carga -->
            <div id="loadingResumen" class="text-center py-5 d-none">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <h5 class="mt-3 text-muted">Consolidando ventas por unidad de medida...</h5>
            </div>

            <!-- PASO 2: Tabla de Unidades y Asignación de Tarifas -->
            <div id="seccionResultado" class="row d-none">
                <div class="col-12">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 text-dark fw-semibold">
                                <span class="badge bg-primary rounded-circle me-2">2</span> Definir Tarifas por Unidad de Medida
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                <div id="badgeEmpresaTarget" class="badge bg-info text-dark fs-6 px-3 py-2"></div>
                                <button type="button" class="btn btn-outline-secondary btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalResumenVentas">
                                    <i class="ri-bar-chart-2-line me-1"></i> Resumen de Ventas Origen
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="tablaUnidades">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;" class="text-center">#</th>
                                            <th style="width: 140px;">Unidad Medida</th>
                                            <th>Producto / Servicio de Catálogo *</th>
                                            <th class="text-end" style="width: 180px;">Cantidad Vendida Total</th>
                                            <th class="text-end" style="width: 220px;">Tarifa Servicio S/ (con IGV)</th>
                                            <th class="text-end" style="width: 160px;">Subtotal S/</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyUnidades">
                                        <!-- Se llena dinámicamente con AJAX -->
                                    </tbody>
                                    <tfoot class="table-light fw-bold fs-6">
                                        <tr id="rowSubtotalGravado">
                                            <td colspan="4" class="text-end">SUBTOTAL OP. GRAVADAS (S/):</td>
                                            <td colspan="2" class="text-end text-primary" id="lblSubtotalGravado">S/ 0.00</td>
                                        </tr>
                                        <tr id="rowSubtotalExonerado" class="d-none">
                                            <td colspan="4" class="text-end">SUBTOTAL OP. EXONERADAS (S/):</td>
                                            <td colspan="2" class="text-end text-primary" id="lblSubtotalExonerado">S/ 0.00</td>
                                        </tr>
                                        <tr id="rowSubtotalInafecto" class="d-none">
                                            <td colspan="4" class="text-end">SUBTOTAL OP. INAFECTAS (S/):</td>
                                            <td colspan="2" class="text-end text-primary" id="lblSubtotalInafecto">S/ 0.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">IGV 18% (S/):</td>
                                            <td colspan="2" class="text-end text-primary" id="lblTotalIgv">S/ 0.00</td>
                                        </tr>
                                        <tr class="table-primary text-dark fs-5">
                                            <td colspan="4" class="text-end fw-bold">TOTAL FACTURA (S/):</td>
                                            <td colspan="2" class="text-end fw-bold text-success" id="lblTotalFactura">S/ 0.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- PASO 3: Selección de Serie y Emisión -->
                        <div class="card-footer bg-white p-4">
                            <!-- Banner Dinámico de Configuración de Envío SUNAT / OSE -->
                            <div class="alert {{ $configuracionFE['es_produccion'] ? 'alert-success border-success' : 'alert-warning border-warning' }} shadow-sm mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="mb-0 fw-bold">
                                        <i class="ri-shield-check-line me-1"></i> Entorno de Envío: 
                                        <span class="badge {{ $configuracionFE['badge_color'] }} fs-6 ms-1">{{ $configuracionFE['entorno_nombre'] }}</span>
                                    </h6>
                                    <span class="badge bg-dark fs-6">{{ $configuracionFE['proveedor_nombre'] }}</span>
                                </div>
                                <div class="small">
                                    <p class="mb-1 text-dark">
                                        Las facturas electrónicas se enviarán a: <strong>Servidor {{ $configuracionFE['proveedor_nombre'] }}</strong>.
                                    </p>
                                    <p class="mb-0 font-monospace text-muted text-break">
                                        <strong>RUTA DE ENVÍO DE COMPROBANTES:</strong> {{ $configuracionFE['url_envio'] }}
                                    </p>
                                </div>
                            </div>

                            <form id="formGenerarFactura">
                                @csrf
                                <div class="row align-items-center g-3">
                                    <div class="col-md-6">
                                        <label for="serie_id" class="form-label fw-bold">Serie de Factura Electrónica (F001) *</label>
                                        <select class="form-select" id="serie_id" name="serie_id" required>
                                            @foreach($series as $ser)
                                                <option value="{{ $ser->id }}">
                                                    {{ $ser->serie }} (Siguiente N°: {{ str_pad($ser->correlativo, 8, '0', STR_PAD_LEFT) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <button type="button" class="btn btn-success btn-lg px-4 fw-bold shadow-sm" id="btnEmitirFactura">
                                            <i class="ri-send-plane-fill me-2"></i> Generar y Emitir Factura a SUNAT
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PASO 4: Resultado Éxito -->
            <div id="seccionExito" class="row d-none">
                <div class="col-12">
                    <div class="card border-0 shadow-sm bg-light text-center p-5">
                        <div class="mb-3">
                            <i class="ri-checkbox-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-2" id="msgExitoTitulo">¡Factura Emitida Exitosamente!</h3>
                        <p class="text-muted fs-5 mb-4" id="msgExitoDetalle"></p>
                        <div class="d-flex justify-content-center gap-3">
                            <a id="btnImprimirPdf" href="#" target="_blank" class="btn btn-success fw-bold d-none">
                                <i class="ri-printer-line me-1"></i> Imprimir PDF (A4)
                            </a>
                            <button class="btn btn-outline-primary fw-bold" onclick="location.reload();">
                                <i class="ri-refresh-line me-1"></i> Facturar Otra Empresa
                            </button>
                            <a href="{{ url('/gestion-de-ventas/' . $idopcion) }}" class="btn btn-primary fw-bold">
                                <i class="ri-list-check me-1"></i> Ir a Lista de Ventas
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- CIERRE TAB-EMISION -->

        <!-- PESTAÑA 2: HISTÓRICO DE LIQUIDACIONES -->
        <div class="tab-pane fade" id="tab-historico" role="tabpanel">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="ri-history-line text-primary me-2"></i> Histórico de Facturas de Servicio Interempresa Emitidas
                    </h5>
                    <button type="button" class="btn btn-outline-primary btn-sm fw-bold" onclick="cargarHistoricoLiquidaciones()">
                        <i class="ri-refresh-line me-1"></i> Actualizar Listado
                    </button>
                </div>
                <div class="card-body p-0">
                    <div id="loadingHistorico" class="text-center py-5 d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="text-muted mt-2">Cargando histórico de liquidaciones...</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>N° Factura Servicio</th>
                                    <th>Empresa Destino (Cliente)</th>
                                    <th>Fecha Emisión</th>
                                    <th class="text-center">Docs Origen Cubiertos</th>
                                    <th class="text-end">Monto Total S/</th>
                                    <th>Estado SUNAT</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyHistoricoLiquidaciones">
                                <!-- Dinámico -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- CIERRE TAB-HISTORICO -->
    </div> <!-- CIERRE TAB-CONTENT -->
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const formFiltro = document.getElementById('formFiltroUnidades');
    const loadingResumen = document.getElementById('loadingResumen');
    const seccionResultado = document.getElementById('seccionResultado');
    const tbodyUnidades = document.getElementById('tbodyUnidades');
    const badgeEmpresaTarget = document.getElementById('badgeEmpresaTarget');
    const btnEmitirFactura = document.getElementById('btnEmitirFactura');
    const seccionExito = document.getElementById('seccionExito');

    let datosResumen = null;

    // STEP 1: Consultar resumen por AJAX
    formFiltro.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const empId = document.getElementById('empresa_origen_id').value;
        if (!empId) {
            Swal.fire('Atención', 'Por favor seleccione una empresa origen.', 'warning');
            return;
        }

        seccionResultado.classList.add('d-none');
        seccionExito.classList.add('d-none');
        loadingResumen.classList.remove('d-none');

        const formData = new FormData(formFiltro);

        fetch('{{ route("facturacion_interempresa.resumen") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            loadingResumen.classList.add('d-none');
            if (data.success) {
                datosResumen = data;
                renderizarTabla(data);
                seccionResultado.classList.remove('d-none');
            } else {
                Swal.fire('Información', data.message || 'No se encontraron datos.', 'info');
            }
        })
        .catch(err => {
            loadingResumen.classList.add('d-none');
            console.error(err);
            Swal.fire('Error', 'Ocurrió un problema al consultar las ventas.', 'error');
        });
    });

    // Renderizar la tabla de resultados
    function renderizarTabla(data) {
        badgeEmpresaTarget.innerHTML = `<i class="ri-building-line me-1"></i> Facturando a: <strong>${data.empresa_origen.nombre}</strong> (RUC: ${data.empresa_origen.ruc})`;
        tbodyUnidades.innerHTML = '';

        if (data.audit) {
            document.getElementById('kpiTotalDocs').textContent = data.audit.total_documentos;
            document.getElementById('kpiTotalMonto').textContent = `S/ ${data.audit.total_monto.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            document.getElementById('kpiTotalFacturas').textContent = data.audit.total_facturas;
            document.getElementById('kpiTotalBoletas').textContent = data.audit.total_boletas;

            // Renderizar desglose por Unidad de Medida en el modal de auditoría
            const tbodyAuditUnidades = document.getElementById('tbodyAuditUnidades');
            if (tbodyAuditUnidades) {
                tbodyAuditUnidades.innerHTML = '';
                if (data.items && data.items.length > 0) {
                    let sumCantidad = 0;
                    let sumMonto = 0;
                    data.items.forEach(it => {
                        const cant = parseFloat(it.cantidad_total || 0);
                        const mto = parseFloat(it.monto_total || 0);
                        sumCantidad += cant;
                        sumMonto += mto;

                        const trU = document.createElement('tr');
                        trU.innerHTML = `
                            <td class="fw-bold"><span class="badge bg-primary me-2">${it.unidad_medida}</span> ${it.unidad_label}</td>
                            <td class="text-center fw-bold fs-6">${cant.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                            <td class="text-end fw-bold text-success fs-6">S/ ${mto.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        `;
                        tbodyAuditUnidades.appendChild(trU);
                    });

                    // Fila Total Consolidado
                    const trTot = document.createElement('tr');
                    trTot.className = 'table-light fw-bold';
                    trTot.innerHTML = `
                        <td class="text-end fw-bold">TOTAL CONSOLIDADO:</td>
                        <td class="text-center text-primary fs-6 fw-bold">${sumCantidad.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        <td class="text-end text-success fs-6 fw-bold">S/ ${sumMonto.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                    `;
                    tbodyAuditUnidades.appendChild(trTot);
                } else {
                    tbodyAuditUnidades.innerHTML = `<tr><td colspan="3" class="text-center text-muted">Sin datos de unidades de medida disponibles</td></tr>`;
                }
            }

            const tbodyAudit = document.getElementById('tbodyAuditDesglose');
            tbodyAudit.innerHTML = '';

            const unidadesNombresMap = {
                'NIU': 'UNIDAD',
                'ZZ':  'SERVICIO',
                'KGM': 'KILOGRAMO',
                'BX':  'BOLSA',
                'SA':  'SACO',
                'SAC': 'SACO',
                'BOL': 'BOLSA',
                'DZN': 'DOCENA',
                'MTR': 'METRO',
                'LTR': 'LITRO',
                'CJ':  'CAJA',
                'PK':  'PAQUETE'
            };

            if (data.audit.desglose && data.audit.desglose.length > 0) {
                let sumDocs = 0;
                let sumCant = 0;
                let sumMto = 0;

                data.audit.desglose.forEach(row => {
                    const tipoNombre = row.tipo_comprobante === '01' ? 'Factura Electrónica (01)' : (row.tipo_comprobante === '03' ? 'Boleta de Venta (03)' : `Tipo ${row.tipo_comprobante}`);
                    let badgeEstado = '<span class="badge bg-secondary">PENDIENTE</span>';
                    const est = (row.estado_sunat || '').toUpperCase();
                    if (est === 'ACEPTADO' || est === '0') {
                        badgeEstado = '<span class="badge bg-success">ACEPTADO</span>';
                    } else if (est === 'RECHAZADO') {
                        badgeEstado = '<span class="badge bg-danger">RECHAZADO</span>';
                    } else if (est === 'ANULADO') {
                        badgeEstado = '<span class="badge bg-dark">ANULADO</span>';
                    }

                    const uCode = (row.unidad_medida || 'NIU').toUpperCase().trim();
                    const uNombre = unidadesNombresMap[uCode] ?? uCode;
                    const uLabel = `<span class="badge bg-primary me-1">${uCode}</span> ${uNombre}`;

                    const docs = parseInt(row.cantidad_docs || 0);
                    const cUnits = parseFloat(row.cantidad_unidades || 0);
                    const mto = parseFloat(row.monto_total || 0);

                    sumDocs += docs;
                    sumCant += cUnits;
                    sumMto += mto;

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="fw-bold">${tipoNombre}</td>
                        <td>${badgeEstado}</td>
                        <td>${uLabel}</td>
                        <td class="text-center fw-bold fs-6">${docs}</td>
                        <td class="text-center fw-bold text-primary fs-6">${cUnits.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        <td class="text-end fw-bold text-success fs-6">S/ ${mto.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                    `;
                    tbodyAudit.appendChild(tr);
                });

                // Fila Total General
                const trTot = document.createElement('tr');
                trTot.className = 'table-dark fw-bold';
                trTot.innerHTML = `
                    <td colspan="3" class="text-end fw-bold text-white">TOTAL GENERAL:</td>
                    <td class="text-center text-white fs-6 fw-bold">${sumDocs}</td>
                    <td class="text-center text-info fs-6 fw-bold">${sumCant.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                    <td class="text-end text-warning fs-6 fw-bold">S/ ${sumMto.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                `;
                tbodyAudit.appendChild(trTot);
            } else {
                tbodyAudit.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-3">Sin detalles de auditoría disponibles</td></tr>`;
            }
        }

        let opcionesProdHtml = `<option value="">-- Seleccionar Servicio del Catálogo --</option>`;
        if (data.productos && data.productos.length > 0) {
            data.productos.forEach(p => {
                const prc = parseFloat(p.precio_unitario) || 0;
                const txtPrc = prc > 0 ? ` (S/ ${prc.toFixed(2)})` : '';
                const tipoAfe = p.tipo_afectacion || '10';
                let tagAfe = '';
                if (tipoAfe === '20') tagAfe = ' [EXONERADO]';
                else if (tipoAfe === '30') tagAfe = ' [INAFECTO]';
                opcionesProdHtml += `<option value="${p.id}" data-precio="${prc}" data-desc="${p.descripcion}" data-tipo-afectacion="${tipoAfe}">${p.descripcion}${tagAfe}${txtPrc}</option>`;
            });
        }

        data.items.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="text-center fw-bold">${index + 1}</td>
                <td>
                    <span class="badge bg-primary fs-6">${item.unidad_label}</span>
                </td>
                <td>
                    <select class="form-select form-select-sm select-producto fw-semibold" id="producto_id_${index}" data-index="${index}">
                        ${opcionesProdHtml}
                    </select>
                </td>
                <td class="text-end fw-bold fs-6 text-dark">${item.cantidad_total.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                <td class="text-end">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text fw-bold bg-light">S/</span>
                        <input type="number" step="0.01" min="0" class="form-control text-end fw-bold fs-6 input-tarifa" 
                               id="tarifa_${index}" data-index="${index}" data-cantidad="${item.cantidad_total}" placeholder="0.00" value="0.00">
                    </div>
                </td>
                <td class="text-end fw-bold text-primary fs-6 lbl-subtotal" id="subtotal_${index}">S/ 0.00</td>
            `;
            tbodyUnidades.appendChild(tr);

        });

        // Inicializar Select2 en los combos de producto para permitir búsqueda y filtrado rápido
        if (window.jQuery && $.fn.select2) {
            $('.select-producto').select2({
                placeholder: "-- Buscar y Seleccionar Servicio --",
                allowClear: true,
                width: '100%'
            }).on('change', function() {
                const idx = this.getAttribute('data-index');
                const selectedOpt = this.options[this.selectedIndex];
                if (selectedOpt) {
                    const prc = parseFloat(selectedOpt.getAttribute('data-precio')) || 0;
                    if (prc > 0) {
                        const inputT = document.getElementById(`tarifa_${idx}`);
                        if (inputT) {
                            inputT.value = prc.toFixed(2);
                            calcularTotales();
                        }
                    }
                }
            });
        } else {
            document.querySelectorAll('.select-producto').forEach(sel => {
                sel.addEventListener('change', function() {
                    const idx = this.getAttribute('data-index');
                    const opt = this.options[this.selectedIndex];
                    const prc = parseFloat(opt.getAttribute('data-precio')) || 0;
                    if (prc > 0) {
                        const inputT = document.getElementById(`tarifa_${idx}`);
                        if (inputT) {
                            inputT.value = prc.toFixed(2);
                            calcularTotales();
                        }
                    }
                });
            });
        }

        // Event listener para recálculo de subtotales al modificar la tarifa
        document.querySelectorAll('.input-tarifa').forEach(input => {
            input.addEventListener('input', calcularTotales);
        });

        calcularTotales();
    }

    // Calcular Subtotales e IGV en tiempo real considerando la afectación fiscal
    function calcularTotales() {
        let totalGeneral = 0;
        let subtotalGravado = 0;
        let subtotalExonerado = 0;
        let subtotalInafecto = 0;
        let totalIgv = 0;

        document.querySelectorAll('.input-tarifa').forEach(input => {
            const index = input.getAttribute('data-index');
            const cantidad = parseFloat(input.getAttribute('data-cantidad')) || 0;
            const tarifa = parseFloat(input.value) || 0;

            const selectProd = document.getElementById(`producto_id_${index}`);
            let tipoAfe = '10';
            if (selectProd && selectProd.selectedIndex >= 0) {
                const selectedOpt = selectProd.options[selectProd.selectedIndex];
                if (selectedOpt) {
                    tipoAfe = selectedOpt.getAttribute('data-tipo-afectacion') || '10';
                }
            }

            const totalItem = cantidad * tarifa;
            totalGeneral += totalItem;

            if (tipoAfe === '10') {
                const valVenta = totalItem / 1.18;
                subtotalGravado += valVenta;
                totalIgv += (totalItem - valVenta);
            } else if (tipoAfe === '20') {
                subtotalExonerado += totalItem;
            } else {
                subtotalInafecto += totalItem;
            }

            const lblSubtotal = document.getElementById(`subtotal_${index}`);
            if (lblSubtotal) {
                lblSubtotal.textContent = `S/ ${totalItem.toFixed(2)}`;
            }
        });

        document.getElementById('lblSubtotalGravado').textContent = `S/ ${subtotalGravado.toFixed(2)}`;
        
        const elExo = document.getElementById('lblSubtotalExonerado');
        const rowExo = document.getElementById('rowSubtotalExonerado');
        if (elExo && rowExo) {
            elExo.textContent = `S/ ${subtotalExonerado.toFixed(2)}`;
            if (subtotalExonerado > 0) rowExo.classList.remove('d-none');
            else rowExo.classList.add('d-none');
        }

        const elIna = document.getElementById('lblSubtotalInafecto');
        const rowIna = document.getElementById('rowSubtotalInafecto');
        if (elIna && rowIna) {
            elIna.textContent = `S/ ${subtotalInafecto.toFixed(2)}`;
            if (subtotalInafecto > 0) rowIna.classList.remove('d-none');
            else rowIna.classList.add('d-none');
        }

        document.getElementById('lblTotalIgv').textContent = `S/ ${totalIgv.toFixed(2)}`;
        document.getElementById('lblTotalFactura').textContent = `S/ ${totalGeneral.toFixed(2)}`;
    }

    // STEP 3: Emitir Factura a SUNAT
    btnEmitirFactura.addEventListener('click', function() {
        if (!datosResumen) return;

        const serieId = document.getElementById('serie_id').value;
        if (!serieId) {
            Swal.fire('Atención', 'Por favor seleccione una serie de factura.', 'warning');
            return;
        }

        const itemsPayload = [];
        let tieneTarifaValida = false;
        let cancelado = false;

        document.querySelectorAll('.input-tarifa').forEach(input => {
            if (cancelado) return;
            const idx = input.getAttribute('data-index');
            const tarifa = parseFloat(input.value) || 0;
            const itemOriginal = datosResumen.items[idx];
            const selectProd = document.getElementById(`producto_id_${idx}`);
            const productoId = selectProd ? selectProd.value : '';

            if (tarifa > 0) {
                if (!productoId) {
                    Swal.fire('Atención', `Por favor seleccione un Producto/Servicio del catálogo para la fila #${parseInt(idx) + 1} (${itemOriginal.unidad_label}).`, 'warning');
                    tieneTarifaValida = false;
                    cancelado = true;
                    return;
                }
                tieneTarifaValida = true;
                itemsPayload.push({
                    producto_id: productoId,
                    unidad_medida: itemOriginal.unidad_medida,
                    descripcion: itemOriginal.descripcion,
                    cantidad: itemOriginal.cantidad_total,
                    tarifa_unitario: tarifa
                });
            }
        });

        if (!tieneTarifaValida) {
            Swal.fire('Atención', 'Debe ingresar al menos una tarifa mayor a S/ 0.00 para generar la factura.', 'warning');
            return;
        }

        Swal.fire({
            title: '¿Confirmar Emisión de Factura?',
            text: `Se emitirá una Factura Electrónica a ${datosResumen.empresa_origen.nombre} por el monto total de ${document.getElementById('lblTotalFactura').textContent}.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="ri-send-plane-fill me-1"></i> Sí, Emitir Factura',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                btnEmitirFactura.disabled = true;
                btnEmitirFactura.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Transmitiendo a SUNAT...';

                // Pantalla de Carga Activa mientras se conecta con SUNAT / OSE
                Swal.fire({
                    title: 'Transmitiendo Factura Electrónica',
                    html: `
                        <div class="text-center py-3">
                            <div class="spinner-border text-success mb-3" style="width: 3.5rem; height: 3.5rem;" role="status">
                                <span class="visually-hidden">Procesando...</span>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Conectando con Servidor SUNAT / OSE...</h5>
                            <p class="text-muted small mb-0">Generando el comprobante UBL 2.1, firmando digitalmente y procesando la respuesta (CDR)...</p>
                        </div>
                    `,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false
                });

                fetch('{{ route("facturacion_interempresa.generar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        empresa_origen_id: datosResumen.empresa_origen.id,
                        fecha_inicio: document.getElementById('fecha_inicio').value,
                        fecha_fin: document.getElementById('fecha_fin').value,
                        serie_id: serieId,
                        items: itemsPayload
                    })
                })
                .then(response => response.json())
                .then(data => {
                    btnEmitirFactura.disabled = false;
                    btnEmitirFactura.innerHTML = '<i class="ri-send-plane-fill me-2"></i> Generar y Emitir Factura a SUNAT';

                    if (data.success) {
                        seccionResultado.classList.add('d-none');
                        document.getElementById('msgExitoTitulo').textContent = `¡Factura ${data.comprobante} Emitida!`;
                        document.getElementById('msgExitoDetalle').textContent = `Estado SUNAT: ${data.estado_sunat} - ${data.mensaje_sunat || ''}`;
                        
                        const encId = data.venta_id_encrypted ? encodeURIComponent(data.venta_id_encrypted) : data.venta_id;
                        if (encId) {
                            const btnPdf = document.getElementById('btnImprimirPdf');
                            if (btnPdf) {
                                btnPdf.href = `{{ url('/venta/imprimir') }}/${encId}/a4`;
                                btnPdf.classList.remove('d-none');
                            }
                        }

                        seccionExito.classList.remove('d-none');

                        Swal.fire({
                            title: '¡Factura Emitida y Transmitida!',
                            html: `<strong>Comprobante:</strong> ${data.comprobante}<br><strong>Estado SUNAT:</strong> <span class="badge bg-success">${data.estado_sunat}</span><br><small class="text-muted">${data.mensaje_sunat || ''}</small>`,
                            icon: 'success',
                            confirmButtonText: '<i class="ri-printer-line me-1"></i> Ver PDF A4',
                            showCancelButton: true,
                            cancelButtonText: 'Cerrar'
                        }).then((res) => {
                            if (res.isConfirmed && encId) {
                                window.open(`{{ url('/venta/imprimir') }}/${encId}/a4`, '_blank');
                            }
                        });
                    } else {
                        Swal.fire('Error', data.message || 'No se pudo emitir la factura.', 'error');
                    }
                })
                .catch(err => {
                    btnEmitirFactura.disabled = false;
                    btnEmitirFactura.innerHTML = '<i class="ri-send-plane-fill me-2"></i> Generar y Emitir Factura a SUNAT';
                    console.error(err);
                    Swal.fire('Error', 'Ocurrió un error inesperado al procesar la solicitud.', 'error');
                });
            }
        });
    });

    @if($esSuperAdmin)
    const formGuardarConfig = document.getElementById('formGuardarConfigEmpresas');
    if (formGuardarConfig) {
        formGuardarConfig.addEventListener('submit', function(e) {
            e.preventDefault();
            const btnGuardarConfig = document.getElementById('btnGuardarConfig');
            btnGuardarConfig.disabled = true;
            btnGuardarConfig.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Guardando...';

            const formData = new FormData(formGuardarConfig);

            fetch('{{ route("facturacion_interempresa.guardar_config") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async res => {
                const isJson = res.headers.get('content-type')?.includes('application/json');
                const data = isJson ? await res.json() : null;
                if (!res.ok) {
                    const msg = data && data.message ? data.message : `Error ${res.status}: ${res.statusText}`;
                    throw new Error(msg);
                }
                return data;
            })
            .then(data => {
                btnGuardarConfig.disabled = false;
                btnGuardarConfig.innerHTML = '<i class="ri-save-line me-1"></i> Guardar Cambios';

                if (data && data.success) {
                    Swal.fire('Éxito', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error al Guardar', (data && data.message) ? data.message : 'No se pudo guardar.', 'error');
                }
            })
            .catch(err => {
                btnGuardarConfig.disabled = false;
                btnGuardarConfig.innerHTML = '<i class="ri-save-line me-1"></i> Guardar Cambios';
                console.error('Error guardando configuración:', err);
                Swal.fire('Error', err.message || 'Ocurrió un error al guardar.', 'error');
            });
        });
    }
    @endif

    // ==========================================
    // HISTÓRICO DE LIQUIDACIONES INTEREMPRESA
    // ==========================================
    window.cargarHistoricoLiquidaciones = function() {
        const loadingHist = document.getElementById('loadingHistorico');
        const tbodyHist = document.getElementById('tbodyHistoricoLiquidaciones');
        if (!tbodyHist) return;

        if (loadingHist) loadingHist.classList.remove('d-none');
        tbodyHist.innerHTML = '';

        fetch('{{ route("facturacion_interempresa.historico") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (loadingHist) loadingHist.classList.add('d-none');
            if (data.success && data.liquidaciones && data.liquidaciones.length > 0) {
                data.liquidaciones.forEach(item => {
                    let badgeEstado = '<span class="badge bg-secondary">PENDIENTE</span>';
                    const est = (item.estado_sunat || '').toUpperCase();
                    if (est === 'ACEPTADO' || est === '0') badgeEstado = '<span class="badge bg-success">ACEPTADO</span>';
                    else if (est === 'RECHAZADO') badgeEstado = '<span class="badge bg-danger">RECHAZADO</span>';
                    else if (est === 'ANULADO') badgeEstado = '<span class="badge bg-dark">ANULADO</span>';

                    const encId = item.id_encrypted ? encodeURIComponent(item.id_encrypted) : item.id;

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="fw-bold text-primary fs-6">${item.comprobante}</td>
                        <td>
                            <div class="fw-bold text-dark">${item.cliente_nombre}</div>
                            <small class="text-muted">RUC: ${item.cliente_ruc}</small>
                        </td>
                        <td>${item.fecha_emision}</td>
                        <td class="text-center fw-bold fs-6">
                            <span class="badge bg-info text-dark fs-13 px-2 py-1">${item.total_docs_origen} comprobantes</span>
                        </td>
                        <td class="text-end fw-bold text-success fs-6">S/ ${parseFloat(item.total).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        <td>${badgeEstado}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-primary fw-bold d-inline-flex align-items-center gap-1" onclick="verDetalleLiquidacion('${item.id}')" title="Ver comprobantes origen cubiertos">
                                    <i class="ri-eye-line fs-14"></i> Comprobantes Cubiertos
                                </button>
                                <a href="{{ url('/venta/imprimir') }}/${encId}/a4" target="_blank" class="btn btn-outline-danger d-inline-flex align-items-center gap-1" title="Ver PDF A4">
                                    <i class="ri-file-pdf-line fs-14"></i> PDF
                                </a>
                            </div>
                        </td>
                    `;
                    tbodyHist.appendChild(tr);
                });
            } else {
                tbodyHist.innerHTML = `<tr><td colspan="7" class="text-center text-muted py-4">No se han registrado liquidaciones interempresa previamente.</td></tr>`;
            }
        })
        .catch(err => {
            if (loadingHist) loadingHist.classList.add('d-none');
            console.error(err);
            tbodyHist.innerHTML = `<tr><td colspan="7" class="text-center text-danger py-4">Error al cargar el histórico de liquidaciones.</td></tr>`;
        });
    };

    window.verDetalleLiquidacion = function(facturaId) {
        Swal.fire({
            title: 'Cargando detalle...',
            text: 'Consultando comprobantes origen cubiertos',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => { Swal.showLoading(); }
        });

        fetch('{{ route("facturacion_interempresa.detalle_historico") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ factura_id: facturaId })
        })
        .then(res => res.json())
        .then(data => {
            Swal.close();
            if (data.success) {
                document.getElementById('lblHistComprobante').textContent = data.factura_servicio.comprobante;
                document.getElementById('lblHistCliente').textContent = `${data.factura_servicio.cliente_nombre} (RUC: ${data.factura_servicio.cliente_ruc})`;
                document.getElementById('lblHistFecha').textContent = data.factura_servicio.fecha_emision;
                document.getElementById('lblHistTotal').textContent = `S/ ${parseFloat(data.factura_servicio.total).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

                const tbodyDet = document.getElementById('tbodyDetalleHistorico');
                tbodyDet.innerHTML = '';

                if (data.comprobantes_origen && data.comprobantes_origen.length > 0) {
                    let totalMonto = 0;
                    data.comprobantes_origen.forEach(co => {
                        totalMonto += parseFloat(co.total || 0);
                        let badgeEst = '<span class="badge bg-secondary">PENDIENTE</span>';
                        const est = (co.estado_sunat || '').toUpperCase();
                        if (est === 'ACEPTADO' || est === '0') badgeEst = '<span class="badge bg-success">ACEPTADO</span>';
                        else if (est === 'ANULADO') badgeEst = '<span class="badge bg-dark">ANULADO</span>';

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="fw-bold">${co.empresa_origen}</td>
                            <td class="fw-bold text-primary">${co.comprobante}</td>
                            <td>${co.fecha_emision}</td>
                            <td>${co.cliente_original}</td>
                            <td class="text-end fw-bold text-success">S/ ${parseFloat(co.total).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                            <td>${badgeEst}</td>
                        `;
                        tbodyDet.appendChild(tr);
                    });

                    // Fila total
                    const trTot = document.createElement('tr');
                    trTot.className = 'table-light fw-bold';
                    trTot.innerHTML = `
                        <td colspan="4" class="text-end fw-bold">TOTAL VENTA ORIGEN:</td>
                        <td class="text-end text-success fs-6">S/ ${totalMonto.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        <td></td>
                    `;
                    tbodyDet.appendChild(trTot);
                } else {
                    tbodyDet.innerHTML = `<tr><td colspan="6" class="text-center text-muted">No se encontraron detalles de comprobantes origen.</td></tr>`;
                }

                const modalDet = new bootstrap.Modal(document.getElementById('modalDetalleLiquidacion'));
                modalDet.show();
            } else {
                Swal.fire('Información', data.message || 'No se pudo obtener el detalle.', 'warning');
            }
        })
        .catch(err => {
            Swal.close();
            console.error(err);
            Swal.fire('Error', 'Ocurrió un problema al cargar el detalle.', 'error');
        });
    };
});
</script>

@if($esSuperAdmin)
<!-- Modal Exclusivo SuperAdmin: Configurar Empresas Autorizadas -->
<div class="modal fade" id="modalConfigEmpresas" tabindex="-1" aria-labelledby="modalConfigEmpresasLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold text-white" id="modalConfigEmpresasLabel">
                    <i class="ri-settings-3-line me-2"></i> Configurar Empresas Autorizadas (Exclusivo SuperAdmin)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formGuardarConfigEmpresas">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted mb-3 fs-6">
                        Seleccione las empresas que la empresa actual tiene autorizadas para consultar y facturar servicios interempresa:
                    </p>
                    <div class="list-group shadow-sm">
                        @foreach($todasEmpresas as $emp)
                            @php
                                $isCheck = in_array($emp->id, $idsPermitidos ?? []);
                            @endphp
                            <label class="list-group-item d-flex align-items-center justify-content-between p-3">
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $emp->nombre }}</h6>
                                    <small class="text-muted">RUC: {{ $emp->ruc }}</small>
                                </div>
                                <div class="form-check form-switch fs-4">
                                    <input class="form-check-input" type="checkbox" name="empresas_permitidas[]" value="{{ $emp->id }}" {{ $isCheck ? 'checked' : '' }}>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer bg-light py-3">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4" id="btnGuardarConfig">
                        <i class="ri-save-line me-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Modal Auditoría / Resumen de Ventas Origen -->
<div class="modal fade" id="modalResumenVentas" tabindex="-1" aria-labelledby="modalResumenVentasLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white py-3">
                <h5 class="modal-title fw-bold text-white" id="modalResumenVentasLabel">
                    <i class="ri-bar-chart-box-line me-2"></i> Resumen de Ventas de Empresa Origen
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Tarjetas KPI -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white p-3 shadow-sm border-0 text-center">
                            <small class="text-white-50 text-uppercase fw-bold">Total Comprobantes</small>
                            <h4 class="mb-0 fw-bold mt-1 text-white" id="kpiTotalDocs">0</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white p-3 shadow-sm border-0 text-center">
                            <small class="text-white-50 text-uppercase fw-bold">Monto Total Vendido</small>
                            <h4 class="mb-0 fw-bold mt-1 text-white" id="kpiTotalMonto">S/ 0.00</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-dark p-3 shadow-sm border-0 text-center">
                            <small class="text-dark-50 text-uppercase fw-bold">Facturas (01)</small>
                            <h4 class="mb-0 fw-bold mt-1 text-dark" id="kpiTotalFacturas">0</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark p-3 shadow-sm border-0 text-center">
                            <small class="text-dark-50 text-uppercase fw-bold">Boletas (03)</small>
                            <h4 class="mb-0 fw-bold mt-1 text-dark" id="kpiTotalBoletas">0</h4>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold text-dark mb-3"><i class="ri-list-settings-line me-1"></i> Desglose por Tipo de Comprobante, Estado SUNAT y Unidad de Medida:</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Tipo Comprobante</th>
                                <th>Estado SUNAT</th>
                                <th>Unidad de Medida</th>
                                <th class="text-center">Cant. Docs</th>
                                <th class="text-center">Cant. Vendida</th>
                                <th class="text-end">Monto Total S/</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyAuditDesglose">
                            <!-- Se llena dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detalle Liquidación Interempresa -->
<div class="modal fade" id="modalDetalleLiquidacion" tabindex="-1" aria-labelledby="modalDetalleLiquidacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold text-white" id="modalDetalleLiquidacionLabel">
                    <i class="ri-file-list-3-line me-2"></i> Detalle de Liquidación Interempresa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Info Header Card -->
                <div class="alert alert-light border border-primary border-opacity-25 rounded-3 p-3 mb-4">
                    <div class="row g-2 fs-14">
                        <div class="col-md-6">
                            <strong>Factura de Servicio:</strong> <span id="lblHistComprobante" class="text-primary fw-bold">-</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Cliente:</strong> <span id="lblHistCliente">-</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha Emisión:</strong> <span id="lblHistFecha">-</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Monto Facturado:</strong> <span id="lblHistTotal" class="text-success fw-bold">S/ 0.00</span>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold text-dark mb-3"><i class="ri-checkbox-multiple-line text-primary me-1"></i> Comprobantes Origen Cubiertos en esta Liquidación:</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Empresa Origen</th>
                                <th>Comprobante</th>
                                <th>Fecha Emisión</th>
                                <th>Cliente Original</th>
                                <th class="text-end">Monto Total S/</th>
                                <th>Estado SUNAT</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyDetalleHistorico">
                            <!-- Se llena dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection
