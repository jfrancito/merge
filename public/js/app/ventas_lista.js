$(document).ready(function () {
    if ($("#ventasTable").length) {
        let table = $('#ventasTable').DataTable({
            responsive: true,
            autoWidth: false,
            lengthMenu: [ [10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"] ],
            pageLength: 500,
            order: [[2, 'desc']],
            language: window.dtSpanish
        });

        $('#filterCorrelativo').on('keypress', function (e) {
            if (e.which === 13) {
                aplicarFiltros();
            }
        });

        // Checkbox general
        $('#selectAllVentas').on('change', function () {
            let checked = this.checked;
            table.$('.select-venta').each(function () {
                if (!$(this).prop('disabled')) {
                    $(this).prop('checked', checked);
                }
            });
            updateBulkActionsBar();
        });

        // Checkboxes individuales
        $(document).on('change', '.select-venta', function () {
            updateBulkActionsBar();
        });

        function updateBulkActionsBar() {
            let selectedCount = 0;
            table.$('.select-venta:checked').each(function () {
                selectedCount++;
            });

            if (selectedCount > 0) {
                $('#selectedCount').text(selectedCount);
                $('#bulkActionsBar').removeClass('d-none');
            } else {
                $('#bulkActionsBar').addClass('d-none');
                $('#selectAllVentas').prop('checked', false);
            }
        }

        // Botón para anulación masiva
        $('#btnBulkAnular').on('click', function () {
            let selectedIds = [];
            let numbers = [];
            table.$('.select-venta:checked').each(function () {
                selectedIds.push($(this).data('id'));
                numbers.push($(this).data('numero'));
            });

            if (selectedIds.length === 0) {
                Swal.fire('Atención', 'Debe seleccionar al menos un comprobante.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Baja Masiva de Comprobantes',
                html: `
                    <p class="text-start mb-3">Se enviará una comunicación de baja a SUNAT para los <strong>${selectedIds.length}</strong> comprobantes seleccionados:</p>
                    <div class="mb-3 text-start bg-light p-2 rounded" style="max-height: 120px; overflow-y: auto; font-family: monospace; font-size: 11px;">
                        ${numbers.join(', ')}
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">Motivo de anulación masiva <span class="text-danger">*</span></label>
                        <input type="text" id="swal-bulk-motivo" class="form-control" placeholder="Ej: Error en el lote, Duplicidad de documentos..." value="ANULACION DE COMPROBANTES MASIVO">
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: '<i class="ri-delete-bin-line"></i> Sí, dar de baja en SUNAT',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const motivo = document.getElementById('swal-bulk-motivo').value;
                    if (!motivo || motivo.trim() === '') {
                        Swal.showValidationMessage('Debes ingresar un motivo de anulación');
                        return false;
                    }
                    return $.ajax({
                        url: window.urlVentaAnularSeleccionados,
                        type: 'POST',
                        data: {
                            _token: window.csrfToken,
                            venta_ids: selectedIds,
                            motivo: motivo
                        },
                        dataType: 'json'
                    }).then(res => {
                        return res;
                    }).catch(err => {
                        let errMsg = 'Error de conexión con el servidor.';
                        if (err.responseJSON && err.responseJSON.message) {
                            errMsg = err.responseJSON.message;
                        }
                        Swal.showValidationMessage(errMsg);
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const res = result.value;
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Procesado!',
                            html: res.message,
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: res.message,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                }
            });
        });
    }

    // Modal para ver notas asociadas
    $(document).on('click', '.btn-ver-notas', function () {
        let id = $(this).data('id');
        let nro = $(this).data('numero');

        $('#modalNotasAsociadas').modal('show');
        $('#modalNotasLabel').text('Notas asociadas a ' + nro);
        $('#bodyNotasAsociadas').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>');

        $.get(window.urlNotasAsociadas, { venta_id: id }, function (res) {
            if (res.success && res.notas.length > 0) {
                let html = '<div class="table-responsive"><table class="table table-sm align-middle">';
                html += '<thead class="bg-light"><tr><th>Documento</th><th>Tipo</th><th>Fecha</th><th>Monto</th><th>Estado</th><th class="text-center">Docs</th></tr></thead>';
                html += '<tbody>';
                res.notas.forEach(n => {
                    let badgeClass = n.estado === 'ACEPTADO' ? 'bg-success' : (n.estado === 'RECHAZADO' ? 'bg-danger' : 'bg-warning text-dark');
                    html += `<tr>
                        <td class="fw-bold">${n.numero}</td>
                        <td><small>${n.tipo}</small></td>
                        <td>${n.fecha}</td>
                        <td class="fw-bold text-dark text-nowrap">${n.simbolo_moneda || 'S/'} ${n.monto_original || n.monto}</td>
                        <td><span class="badge ${badgeClass} fs-10">${n.estado}</span></td>
                        <td class="text-center">
                            ${n.xml ? `<a href="${n.xml}" target="_blank" class="text-primary me-2" title="Descargar XML"><i class="ri-file-code-line fs-18"></i></a>` : ''}
                            ${n.cdr ? `<a href="${n.cdr}" target="_blank" class="text-success" title="Descargar CDR"><i class="ri-checkbox-circle-line fs-18"></i></a>` : ''}
                        </td>
                    </tr>`;
                });
                html += '</tbody></table></div>';
                $('#bodyNotasAsociadas').html(html);
            } else {
                $('#bodyNotasAsociadas').html('<div class="alert alert-info border-0 mb-0">No se encontraron notas asociadas.</div>');
            }
        });
    });
});

function aplicarFiltros() {
    let desde = $('#filterDesde').val();
    let hasta = $('#filterHasta').val();
    let tipo = $('#filterTipo').val();
    let estado = $('#filterEstado').val();
    let serie = $('#filterSerie').val();
    let correlativo = $('#filterCorrelativo').val();
    let cliente = $('#filterCliente').val();

    let url = new URL(window.location.href);
    if (desde) url.searchParams.set('fecha_desde', desde); else url.searchParams.delete('fecha_desde');
    if (hasta) url.searchParams.set('fecha_hasta', hasta); else url.searchParams.delete('fecha_hasta');
    if (tipo) url.searchParams.set('tipo', tipo); else url.searchParams.delete('tipo');
    if (estado) url.searchParams.set('estado', estado); else url.searchParams.delete('estado');
    if (serie) url.searchParams.set('serie', serie); else url.searchParams.delete('serie');
    if (correlativo) url.searchParams.set('correlativo', correlativo); else url.searchParams.delete('correlativo');
    if (cliente) url.searchParams.set('cliente', cliente); else url.searchParams.delete('cliente');

    window.location.href = url.toString();
}

function resetFilters() {
    let url = window.location.protocol + "//" + window.location.host + window.location.pathname;
    window.location.href = url;
}

function verDetalle(id) {
    $('#modalDetalleVenta').modal('show');
    $('#modalBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-secondary">Cargando...</p></div>');

    $.get(window.urlVentaDetalles, { id: id }, function (res) {
        if (res.success) {
            const v = res.venta;
            const nroDoc = v.serie + '-' + String(v.correlativo).padStart(8, '0');
            const tipoDoc = v.tipo_comprobante == '01' ? 'FACTURA' : v.tipo_comprobante == '03' ? 'BOLETA' : v.tipo_comprobante == '07' ? 'NOTA DE CRÉDITO' : 'NOTA DE DÉBITO';

            let estadoBadge = '';
            if (v.estado_sunat === 'ACEPTADO') {
                estadoBadge = '<span class="badge bg-success px-3 py-2" style="font-size:13px;"><i class="ri-check-line me-1"></i>ACEPTADO</span>';
            } else if (v.estado_sunat === 'ANULADO') {
                estadoBadge = '<span class="badge bg-dark px-3 py-2" style="font-size:13px;"><i class="ri-forbid-line me-1"></i>ANULADO</span>';
            } else if (v.estado_sunat === 'RECHAZADO') {
                estadoBadge = '<span class="badge bg-danger px-3 py-2" style="font-size:13px;"><i class="ri-close-line me-1"></i>RECHAZADO</span>';
            } else if (v.estado_sunat === 'BAJA_EN_PROCESO') {
                estadoBadge = '<span class="badge bg-info px-3 py-2" style="font-size:13px;"><i class="ri-history-line me-1"></i>EN PROCESO</span>';
            } else {
                estadoBadge = '<span class="badge bg-warning text-dark px-3 py-2" style="font-size:13px;">' + v.estado_sunat + '</span>';
            }

            let colorTitulo = v.tipo_comprobante == '01' ? '#4de1ff' : v.tipo_comprobante == '03' ? '#ffca28' : '#fff';

            $('#modalTitle').html('<span style="color: ' + colorTitulo + '">' + tipoDoc + '</span> ELECTRÓNICA');
            $('#modalSubtitle').html('<span style="font-size:15px; font-weight:600; opacity: 0.9;">' + nroDoc + '</span>');

            let html = `
                <div style="padding: 24px 28px 0;">
                    <div class="row g-3 mb-4">
                        <div class="col-md-7">
                            <div style="background: #f0f4fa; border-radius: 10px; padding: 18px 20px; height: 100%; border: 1px solid #dce3ed;">
                                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #4a6fa5; font-weight: 700; margin-bottom: 10px;">
                                    <i class="ri-user-3-line me-1"></i> Datos del Cliente
                                </div>
                                <div style="font-size: 17px; font-weight: 700; color: #1a1a2e; margin-bottom: 6px;">
                                    ${v.cliente ? v.cliente.razon_social : 'CLIENTE VARIOS'}
                                </div>
                                <div style="font-size: 14px; color: #3d5a80; font-weight: 500;">
                                    ${v.cliente ? (v.cliente.tipo_documento == '6' ? 'RUC' : 'DNI') + ': <strong>' + v.cliente.numero_documento + '</strong>' : '-'}
                                </div>
                                ${v.cliente && v.cliente.direccion ? '<div style="font-size: 13px; color: #6b7b8d; margin-top: 6px;">📍 ' + v.cliente.direccion + '</div>' : ''}
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div style="background: #f0f4fa; border-radius: 10px; padding: 18px 20px; height: 100%; border: 1px solid #dce3ed;">
                                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #4a6fa5; font-weight: 700; margin-bottom: 10px;">
                                    <i class="ri-file-text-line me-1"></i> Información
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span style="font-size: 13px; color: #3d5a80; font-weight: 500;">Estado</span>
                                    ${estadoBadge}
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="font-size: 13px; color: #3d5a80;">Fecha</span>
                                    <span style="font-size: 14px; font-weight: 600; color: #1a1a2e;">${v.fecha_emision.split('-').reverse().join('-')}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span style="font-size: 13px; color: #3d5a80;">Moneda</span>
                                    <span style="font-size: 14px; font-weight: 600; color: #1a1a2e;">${v.moneda === 'PEN' ? 'Soles (PEN)' : 'Dólares (USD)'}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="padding: 0 28px;">
                    <table class="table mb-0" style="font-size: 14px;">
                        <thead>
                            <tr style="background: #1a3b6e; color: #fff;">
                                <th style="padding: 12px 14px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; border: 0;" class="text-center" width="8%">Cant.</th>
                                <th style="padding: 12px 14px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; border: 0;">Descripción</th>
                                <th style="padding: 12px 14px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; border: 0;" class="text-center" width="10%">Afect.</th>
                                <th style="padding: 12px 14px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; border: 0;" class="text-end" width="18%">P. Unit</th>
                                <th style="padding: 12px 14px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; border: 0;" class="text-end" width="18%">Importe</th>
                            </tr>
                        </thead>
                        <tbody>`;

            const simbolo = v.simbolo_moneda || 'S/';
            res.detalles.forEach((d, i) => {
                const bg = i % 2 === 0 ? '#fff' : '#f5f7fb';
                // Convertir tipo afectación a etiqueta legible
                let afectacionLabel = d.tipo_afectacion == '10' ? '<span class="badge bg-success bg-opacity-10 text-success border-0">Gravada</span>' : 
                                      (d.tipo_afectacion == '20' ? '<span class="badge bg-warning bg-opacity-10 text-warning border-0">Exonerada</span>' : 
                                      '<span class="badge bg-info bg-opacity-10 text-info border-0">Inafecta</span>');
                html += `
                    <tr style="background: ${bg};">
                        <td style="padding: 11px 14px; border-bottom: 1px solid #e5eaf0; font-size: 14px;" class="text-center">${parseFloat(d.cantidad).toFixed(2)}</td>
                        <td style="padding: 11px 14px; border-bottom: 1px solid #e5eaf0; font-weight: 600; font-size: 14px; color: #1a1a2e;"><span class="text-secondary" style="font-size:11px;">[${d.unidad_medida || 'NIU'}]</span> ${d.producto ? d.producto.descripcion : d.producto_id}</td>
                        <td style="padding: 11px 14px; border-bottom: 1px solid #e5eaf0; font-size: 13px;" class="text-center">${afectacionLabel}</td>
                        <td style="padding: 11px 14px; border-bottom: 1px solid #e5eaf0; font-size: 14px;" class="text-end">${simbolo} ${parseFloat(d.precio_unitario_original || d.precio_unitario).toFixed(2)}</td>
                        <td style="padding: 11px 14px; border-bottom: 1px solid #e5eaf0; font-weight: 700; font-size: 14px; color: #1a1a2e;" class="text-end">${simbolo} ${parseFloat(d.total_original || d.total).toFixed(2)}</td>
                    </tr>`;

            });

            html += `
                        </tbody>
                    </table>
                </div>

                <div style="background: linear-gradient(135deg, #e8eef6 0%, #dce5f1 100%); padding: 22px 28px; margin-top: 0;">
                    <div class="d-flex justify-content-end">
                        <div style="width: 300px;">
                            <div class="d-flex justify-content-between mb-2" style="font-size: 14px; color: #3d5a80;">
                                <span>Op. Gravadas</span>
                                <span style="font-weight: 600;">${simbolo} ${parseFloat(v.ope_gravadas_original || v.ope_gravadas).toFixed(2)}</span>
                            </div>
                            ${parseFloat(v.ope_exoneradas_original || v.ope_exoneradas) > 0 ? `<div class="d-flex justify-content-between mb-2" style="font-size: 14px; color: #3d5a80;"><span>Op. Exoneradas</span><span style="font-weight: 600;">${simbolo} ${parseFloat(v.ope_exoneradas_original || v.ope_exoneradas).toFixed(2)}</span></div>` : ''}
                            ${parseFloat(v.ope_inafectas_original || v.ope_inafectas) > 0 ? `<div class="d-flex justify-content-between mb-2" style="font-size: 14px; color: #3d5a80;"><span>Op. Inafectas</span><span style="font-weight: 600;">${simbolo} ${parseFloat(v.ope_inafectas_original || v.ope_inafectas).toFixed(2)}</span></div>` : ''}
                            <div class="d-flex justify-content-between mb-3" style="font-size: 14px; color: #3d5a80;">
                                <span>I.G.V. (18%)</span>
                                <span style="font-weight: 600;">${simbolo} ${parseFloat(v.igv_original || v.igv).toFixed(2)}</span>
                            </div>
                            <div class="d-flex justify-content-between pt-3" style="border-top: 3px solid #1a3b6e; font-size: 20px; font-weight: 800; color: #1a3b6e;">
                                <span>TOTAL</span>
                                <span>${simbolo} ${parseFloat(v.moneda == 'USD' ? v.total_moneda_original : v.total).toFixed(2)}</span>
                            </div>
                        </div>

                    </div>
                </div>
                ${v.mensaje_sunat ? '<div style="padding: 16px 28px 18px; border-top: 1px solid #dce3ed; background: #fafbfc;"><div style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #4a6fa5; font-weight: 700; margin-bottom: 6px;"><i class="ri-government-line me-1"></i> Respuesta SUNAT</div><div style="font-size: 13px; color: #6b7b8d; line-height: 1.5;">' + v.mensaje_sunat + '</div></div>' : ''}
            `;

            $('#modalBody').html(html);
        } else {
            $('#modalBody').html('<div class="alert alert-danger m-4">Error al cargar el detalle.</div>');
        }
    });
}

function anularComprobante(id) {
    Swal.fire({
        title: 'Comunicación de Baja',
        html: `
            <p class="text-start mb-3">Se enviará una <strong>Comunicación de Baja</strong> a SUNAT para anular este comprobante.</p>
            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Motivo de anulación <span class="text-danger">*</span></label>
                <input type="text" id="swal-motivo" class="form-control" placeholder="Ej: Error en el monto, Documento duplicado..." value="ANULACION DE COMPROBANTE">
            </div>
            <div class="alert alert-warning text-start mb-0" style="font-size: 13px;">
                <i class="ri-error-warning-line"></i> Esta acción es <strong>irreversible</strong>. El comprobante quedará como ANULADO ante SUNAT.
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: '<i class="ri-delete-bin-line"></i> Sí, Anular en SUNAT',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const motivo = document.getElementById('swal-motivo').value;
            if (!motivo || motivo.trim() === '') {
                Swal.showValidationMessage('Debes ingresar un motivo de anulación');
                return false;
            }
            return $.ajax({
                url: window.urlVentaAnular,
                type: 'POST',
                data: {
                    _token: window.csrfToken,
                    venta_id: id,
                    motivo: motivo
                },
                dataType: 'json'
            }).then(res => {
                return res;
            }).catch(err => {
                Swal.showValidationMessage('Error de conexión con el servidor.');
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            const res = result.value;
            if (res.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Comprobante Anulado!',
                    text: res.message,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Rechazado / Error',
                    text: res.message,
                    confirmButtonText: 'Aceptar'
                });
            }
        }
    });
}

function consultarTicket(id) {
    Swal.fire({
        title: 'Consultando SUNAT',
        text: 'Estamos verificando el estado del ticket de baja...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
            $.ajax({
                url: window.urlConsultarTicket,
                type: 'POST',
                data: {
                    _token: window.csrfToken,
                    venta_id: id
                },
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        Swal.fire('¡Éxito!', res.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Aún en Proceso', res.message, 'info');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
                }
            });
        }
    });
}

// Eventos para el modal de búsqueda de clientes
$(document).ready(function () {
    $(document).on('click', '#btnBuscarClienteModal', function () {
        $('#modalBuscarCliente').modal('show');
        $('#modal_cliente_buscar_q').val('');
        cargarClientesModal('');
    });

    $(document).on('click', '#btnEjecutarBuscarCliente', function () {
        let q = $('#modal_cliente_buscar_q').val();
        cargarClientesModal(q);
    });

    $(document).on('keyup', '#modal_cliente_buscar_q', function (e) {
        if (e.key === 'Enter') {
            let q = $(this).val();
            cargarClientesModal(q);
        }
    });

    $(document).on('click', '.btn-select-cliente-modal', function () {
        let doc = $(this).data('doc');
        let nombre = $(this).data('nombre');
        $('#filterCliente').val(nombre);
        $('#modalBuscarCliente').modal('hide');
    });
});

function cargarClientesModal(q) {
    $('#tbodyModalClientes').html(`
        <tr>
            <td colspan="4" class="text-center py-4 text-secondary">
                <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                Buscando clientes...
            </td>
        </tr>
    `);

    $.ajax({
        url: window.urlClientesModal,
        type: 'GET',
        data: { q: q },
        success: function (res) {
            if (res.success && res.clientes.length > 0) {
                let html = '';
                res.clientes.forEach(function (c) {
                    let tipoDocLabel = c.tipo_documento == '6' ? 'RUC' : (c.tipo_documento == '1' ? 'DNI' : 'OTROS');
                    html += `
                        <tr class="hover-bg">
                            <td><span class="badge bg-light text-dark border px-2 py-1">${tipoDocLabel}</span></td>
                            <td class="fw-bold">${c.numero_documento}</td>
                            <td>${c.razon_social}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-primary btn-select-cliente-modal px-3" 
                                    data-doc="${c.numero_documento}" data-nombre="${c.razon_social}" style="border-radius: 6px;">
                                    Seleccionar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $('#tbodyModalClientes').html(html);
            } else {
                $('#tbodyModalClientes').html(`
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            No se encontraron clientes activos.
                        </td>
                    </tr>
                `);
            }
        },
        error: function () {
            $('#tbodyModalClientes').html(`
                <tr>
                    <td colspan="4" class="text-center py-4 text-danger">
                        Error al cargar los clientes.
                    </td>
                </tr>
            `);
        }
    });
}
