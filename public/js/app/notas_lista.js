$(document).ready(function () {
    const tableId = $("#notasCreditoTable").length ? "#notasCreditoTable" : "#notasDebitoTable";
    if ($(tableId).length) {
        let table = $(tableId).DataTable({
            responsive: true,
            autoWidth: false,
            order: [[0, 'desc']],
            pageLength: 500,
            lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
            language: window.dtSpanish
        });

        $('#filterEstado').on('change', function () {
            table.column(5).search(this.value).draw();
        });

        $('#filterDesde, #filterHasta').on('change', function () {
            table.draw();
        });

        // Aplicar filtros al cargar si ya tienen valor (por defecto hoy)
        if ($('#filterDesde').val() || $('#filterHasta').val()) {
            table.draw();
        }
    }
});

function resetFilters() {
    $('#filterEstado').val('').trigger('change');

    let hoy = new Date();
    let yyyy = hoy.getFullYear();
    let mm = String(hoy.getMonth() + 1).padStart(2, '0');
    let dd = String(hoy.getDate()).padStart(2, '0');
    let fechaHoy = `${yyyy}-${mm}-${dd}`;

    $('#filterDesde').val(fechaHoy);
    $('#filterHasta').val(fechaHoy);
    const tableId = $("#notasCreditoTable").length ? "#notasCreditoTable" : "#notasDebitoTable";
    if (typeof $.fn.DataTable !== 'undefined' && $(tableId).length) {
        let table = $(tableId).DataTable();
        table.search('');
        table.columns().search('');
        table.draw();
    }
}

function verDetalle(id) {
    $('#modalDetalleNC').modal('show');
    $('#modalBodyNC').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-secondary">Cargando...</p></div>');

    $.get(window.urlVentaDetalles, { id: id }, function (res) {
        if (res.success) {
            const v = res.venta;
            const nroDoc = v.serie + '-' + String(v.correlativo).padStart(8, '0');
            const tipoDoc = 'NOTA DE CRÉDITO';

            let estadoBadge = '';
            if (v.estado_sunat === 'ACEPTADO') {
                estadoBadge = '<span class="badge bg-success px-3 py-2" style="font-size:13px;"><i class="ri-check-line me-1"></i>ACEPTADO</span>';
            } else if (v.estado_sunat === 'RECHAZADO') {
                estadoBadge = '<span class="badge bg-danger px-3 py-2" style="font-size:13px;"><i class="ri-close-line me-1"></i>RECHAZADO</span>';
            } else {
                estadoBadge = '<span class="badge bg-warning text-dark px-3 py-2" style="font-size:13px;">' + v.estado_sunat + '</span>';
            }

            $('#modalTitleNC').html('<span>' + tipoDoc + '</span> ELECTRÓNICA');
            $('#modalSubtitleNC').html('<span style="font-size:15px; font-weight:600; opacity: 0.9;">' + nroDoc + '</span>');

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
                                ${v.moneda === 'USD' ? '<div class="d-flex justify-content-between mt-2"><span style="font-size: 13px; color: #3d5a80;">T. Cambio</span><span style="font-size: 14px; font-weight: 600; color: #0088cc;">' + parseFloat(v.tipo_cambio).toFixed(3) + '</span></div>' : ''}
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
                                <th style="padding: 12px 14px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; border: 0;" class="text-end" width="18%">P. Unit</th>
                                <th style="padding: 12px 14px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; border: 0;" class="text-end" width="15%">IGV</th>
                                <th style="padding: 12px 14px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; border: 0;" class="text-end" width="18%">Importe</th>
                            </tr>
                        </thead>
                        <tbody>`;

            const esAjuste = ['11', '12', '13'].includes(String(v.tipo_nota_concepto));

            res.detalles.forEach((d, i) => {
                const bg = i % 2 === 0 ? '#fff' : '#f5f7fb';
                const simbolo = v.simbolo_moneda || 'S/';
                const precio = esAjuste ? 0 : (v.moneda === 'USD' ? d.precio_unit_original || (d.precio_unitario/v.tipo_cambio) : d.precio_unitario);
                const totalDet = esAjuste ? 0 : (v.moneda === 'USD' ? d.total_original || (d.total/v.tipo_cambio) : d.total);
                const igvDet = esAjuste ? 0 : (v.moneda === 'USD' ? d.igv_original || (d.igv/v.tipo_cambio) : d.igv);

                html += `
                    <tr style="background: ${bg};">
                        <td style="padding: 11px 14px; border-bottom: 1px solid #e5eaf0; font-size: 14px;" class="text-center">${parseFloat(d.cantidad).toFixed(0)}</td>
                        <td style="padding: 11px 14px; border-bottom: 1px solid #e5eaf0; font-weight: 600; font-size: 14px; color: #1a1a2e;">${d.producto ? d.producto.descripcion : d.producto_id}</td>
                        <td style="padding: 11px 14px; border-bottom: 1px solid #e5eaf0; font-size: 14px;" class="text-end">${simbolo} ${parseFloat(precio).toFixed(2)}</td>
                        <td style="padding: 11px 14px; border-bottom: 1px solid #e5eaf0; font-size: 14px;" class="text-end">${parseFloat(igvDet).toFixed(2)}</td>
                        <td style="padding: 11px 14px; border-bottom: 1px solid #e5eaf0; font-weight: 700; font-size: 14px; color: #1a1a2e;" class="text-end">${simbolo} ${parseFloat(totalDet).toFixed(2)}</td>
                    </tr>`;
            });

            const gravadasModal = esAjuste ? '0.00' : parseFloat(v.moneda === 'USD' ? v.ope_gravadas_original : v.ope_gravadas).toFixed(2);
            const exoneradasModal = esAjuste ? '0.00' : parseFloat(v.moneda === 'USD' ? v.ope_exoneradas_original : v.ope_exoneradas).toFixed(2);
            const igvModal = esAjuste ? '0.00' : parseFloat(v.moneda === 'USD' ? v.igv_original : v.igv).toFixed(2);
            const totalModal = esAjuste ? '0.00' : parseFloat(v.moneda === 'USD' ? v.total_moneda_original : v.total).toFixed(2);

            html += `
                        </tbody>
                    </table>
                </div>

                <div style="background: linear-gradient(135deg, #e8eef6 0%, #dce5f1 100%); padding: 22px 28px; margin-top: 0;">
                    <div class="d-flex justify-content-end">
                        <div style="width: 300px;">
                            <div class="d-flex justify-content-between mb-2" style="font-size: 14px; color: #3d5a80;">
                                <span>Op. Gravadas</span>
                                <span style="font-weight: 600;">${v.simbolo_moneda} ${gravadasModal}</span>
                            </div>
                            ${parseFloat(exoneradasModal) > 0 ? '<div class="d-flex justify-content-between mb-2" style="font-size: 14px; color: #3d5a80;"><span>Op. Exoneradas</span><span style="font-weight: 600;">' + v.simbolo_moneda + ' ' + exoneradasModal + '</span></div>' : ''}
                            <div class="d-flex justify-content-between mb-3" style="font-size: 14px; color: #3d5a80;">
                                <span>I.G.V. (18%)</span>
                                <span style="font-weight: 600;">${v.simbolo_moneda} ${igvModal}</span>
                            </div>
                            <div class="d-flex justify-content-between pt-3" style="border-top: 3px solid #1a3b6e; font-size: 20px; font-weight: 800; color: #1a3b6e;">
                                <span>TOTAL</span>
                                <span>${v.simbolo_moneda} ${totalModal}</span>
                            </div>
                        </div>
                    </div>
                </div>
                ${v.mensaje_sunat ? '<div style="padding: 16px 28px 18px; border-top: 1px solid #dce3ed; background: #fafbfc;"><div style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #4a6fa5; font-weight: 700; margin-bottom: 6px;"><i class="ri-government-line me-1"></i> Respuesta SUNAT</div><div style="font-size: 13px; color: #6b7b8d; line-height: 1.5;">' + v.mensaje_sunat + '</div></div>' : ''}
            `;

            $('#modalBodyNC').html(html);
        } else {
            $('#modalBodyNC').html('<div class="alert alert-danger m-4">Error al cargar el detalle.</div>');
        }
    });
}

function anularComprobante(id) {
    Swal.fire({
        title: 'Comunicación de Baja',
        html: `
            <p class="text-start mb-3">Se enviará una <strong>Comunicación de Baja</strong> a SUNAT para anular este comprobante (Nota de Crédito).</p>
            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Motivo de anulación <span class="text-danger">*</span></label>
                <input type="text" id="swal-motivo" class="form-control" placeholder="Ej: Error en el monto, Documento duplicado..." value="ANULACION DE NOTA DE CREDITO">
            </div>
            <div class="alert alert-warning text-start mb-0" style="font-size: 13px;">
                <i class="ri-error-warning-line"></i> Esta acción es <strong>irreversible</strong> ante SUNAT.
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
                    title: '¡Anulación Enviada!',
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

function consultarEstadoSunat(id) {
    Swal.fire({
        title: 'Consultando SUNAT',
        text: 'Obteniendo el estado del CDR...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
            $.ajax({
                url: window.urlConsultarEstadoSunat,
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
                        Swal.fire('Atención', res.message, 'warning').then(() => {
                            location.reload();
                        });
                    }
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
                }
            });
        }
    });
}

function reenviarComprobante(id) {
    Swal.fire({
        title: '¿Reenviar a SUNAT?',
        text: 'Se firmará e intentará transmitir de nuevo esta Nota a SUNAT/EFACT.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, enviar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Transmitiendo...',
                text: 'Por favor espere mientras nos comunicamos con SUNAT/EFACT.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: window.urlVentaReenviar,
                type: 'POST',
                data: {
                    _token: window.csrfToken,
                    venta_id: id
                },
                success: function (res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Retransmisión Exitosa!',
                            text: res.message
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo conectar con el servidor o error de red.', 'error');
                }
            });
        }
    });
}
