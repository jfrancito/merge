$(document).ready(function () {
    // ==================== EVENTOS DE ELIMINACIÓN (AL INICIO) ====================
    // Usamos delegación en $(document) para asegurar que funcione incluso si la tabla se redibuja
    $(document).on('click', '.btn-eliminar-boleta', function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        
        if (!id) {
            console.error("No se encontró ID en el botón de eliminación");
            return;
        }

        Swal.fire({
            title: '¿Eliminar boleta?',
            text: "Esta boleta se quitará de la lista de pendientes y no será enviada a SUNAT.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: window.urlEliminarBoleta,
                    type: 'POST',
                    data: {
                        _token: window.csrfToken,
                        id: id
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire('¡Eliminado!', res.message, 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function (xhr) {
                        console.error("Error en AJAX:", xhr);
                        Swal.fire('Error', 'Error de conexión con el servidor.', 'error');
                    }
                });
            }
        });
    });

    // ==================== EVENTOS DE ANULACIÓN DE RESUMEN COMPLETO ====================
    $(document).on('click', '.btn-anular-resumen', function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        const identificador = $(this).data('identificador');
        
        if (!id) return;

        Swal.fire({
            title: 'Anular Boletas del Resumen',
            html: `
                <p class="text-start mb-3">Se enviará un Resumen Diario de bajas a la SUNAT para anular todas las boletas vinculadas al lote <strong>${identificador}</strong>.</p>
                <div class="mb-3 text-start">
                    <label class="form-label fw-bold">Motivo de anulación <span class="text-danger">*</span></label>
                    <input type="text" id="swal-resumen-motivo" class="form-control" placeholder="Ej: Error en importación, lote rechazado..." value="ANULACION POR ERROR EN LOTE MASIVO">
                </div>
                <div class="alert alert-warning text-start mb-0" style="font-size: 13px;">
                    <i class="ri-error-warning-line"></i> Esta acción es <strong>irreversible</strong>. Las boletas del lote quedarán anuladas ante SUNAT.
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, anular todo el lote',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const motivo = document.getElementById('swal-resumen-motivo').value;
                if (!motivo || motivo.trim() === '') {
                    Swal.showValidationMessage('Debes ingresar un motivo de anulación');
                    return false;
                }
                return $.ajax({
                    url: window.urlAnularResumen,
                    type: 'POST',
                    data: {
                        _token: window.csrfToken,
                        resumen_id: id,
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
                        title: '¡Resumen de baja enviado!',
                        html: res.message,
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.reload();
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

    // ==================== LIMPIAR TODAS LAS BOLETAS PENDIENTES ====================
    $('#btnLimpiarPendientes').on('click', function () {
        Swal.fire({
            title: '¿Limpiar toda la lista?',
            text: "Se eliminarán todas las boletas pendientes de envío. Esto te permitirá volver a subir el Excel sin dejar huecos en los correlativos.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, limpiar todo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Limpiando...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: window.urlLimpiarPendientes,
                    type: 'POST',
                    data: { _token: window.csrfToken },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire('¡Listo!', res.message, 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Error de conexión con el servidor.', 'error');
                    }
                });
            }
        });
    });

    // ==================== UPLOAD ZONE (Drag & Drop) ====================
    const uploadZone = $('#uploadZone');
    const fileInput = $('#archivoExcel');
    const btnProcesar = $('#btnProcesar');

    // Drag & Drop
    uploadZone.on('dragover', function (e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });

    uploadZone.on('dragleave drop', function (e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });

    uploadZone.on('drop', function (e) {
        e.preventDefault();
        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            fileInput[0].files = files;
            actualizarZonaCarga(files[0]);
        }
    });

    // Al seleccionar archivo
    fileInput.on('change', function () {
        if (this.files.length > 0) {
            actualizarZonaCarga(this.files[0]);
        }
    });

    function actualizarZonaCarga(file) {
        const validExtensions = ['xlsx', 'xls'];
        const ext = file.name.split('.').pop().toLowerCase();

        if (!validExtensions.includes(ext)) {
            Swal.fire('Archivo no válido', 'Solo se permiten archivos .xlsx o .xls', 'error');
            fileInput.val('');
            return;
        }

        uploadZone.addClass('file-selected');
        $('#uploadIcon').text('check_circle');
        $('#uploadText').text(file.name);
        $('#uploadHint').text((file.size / 1024).toFixed(1) + ' KB — Clic para cambiar archivo');
        btnProcesar.prop('disabled', false);
    }

    // ==================== PROCESAR EXCEL ====================
    btnProcesar.on('click', function () {
        const file = fileInput[0].files[0];
        const serieSeleccionada = $('#serieAsignada').val();

        if (!serieSeleccionada) {
            Swal.fire('Atención', 'Seleccione la Serie a Asignar.', 'warning');
            return;
        }

        if (!file) {
            Swal.fire('Atención', 'Seleccione un archivo Excel primero.', 'warning');
            return;
        }

        Swal.fire({
            title: '¿Procesar Excel?',
            html: `Se leerá el archivo <strong>${file.name}</strong> y se crearán las boletas en el sistema.<br><small class="text-muted">Las boletas quedarán pendientes para enviar por Resumen Diario.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="ri-upload-2-line me-1"></i> Procesar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#1a73e8',
        }).then((result) => {
            if (result.isConfirmed) {
                subirExcel(file);
            }
        });
    });

    function subirExcel(file) {
        const formData = new FormData();
        formData.append('archivo_excel', file);
        formData.append('serie_asignada', $('#serieAsignada').val());
        formData.append('_token', window.csrfToken);

        // Deshabilitar botón y mostrar loading
        btnProcesar.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Procesando...');

        $.ajax({
            url: window.urlProcesarExcel,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success) {
                    if (res.preview) {
                        // Renderizar vista previa
                        const tbody = $('#bodyPreviewBoletas');
                        tbody.empty();

                        let totalGeneral = 0;
                        res.boletas.forEach(function (boleta) {
                            const itemsCount = boleta.items.length;
                            const total = parseFloat(boleta.total_validar);
                            totalGeneral += total;

                            const row = `<tr>
                                <td class="py-2 px-3">${formatDate(boleta.fecha_emision)}</td>
                                <td class="py-2 px-3 fw-semibold">${escapeHtml(boleta.nombre_cliente)}</td>
                                <td class="py-2 px-3">${escapeHtml(boleta.nro_doc_cliente)}</td>
                                <td class="py-2 px-3 text-center">${itemsCount}</td>
                                <td class="py-2 px-3 text-end fw-bold text-success">S/ ${total.toFixed(2)}</td>
                            </tr>`;
                            tbody.append(row);
                        });

                        // Renderizar productos agrupados
                        const tbodyAgrup = $('#bodyPreviewAgrupados');
                        tbodyAgrup.empty();
                        if (res.agrupados && res.agrupados.length > 0) {
                            res.agrupados.forEach(function (g) {
                                const row = `<tr>
                                    <td class="py-2 px-3 fw-bold text-dark"><span class="text-secondary" style="font-size: 11px;">[${escapeHtml(g.codigo)}]</span> ${escapeHtml(g.descripcion)}</td>
                                    <td class="py-2 px-3 fw-semibold text-secondary">${escapeHtml(g.tipo_afectacion_nombre)}</td>
                                    <td class="py-2 px-3">${escapeHtml(g.unidad_medida_nombre)}</td>
                                    <td class="py-2 px-3 text-center fw-bold">${g.cantidad_total.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                    <td class="py-2 px-3 text-end fw-bold text-success">S/ ${g.monto_total.toFixed(2)}</td>
                                </tr>`;
                                tbodyAgrup.append(row);
                            });
                        } else {
                            tbodyAgrup.append(`<tr><td colspan="5" class="text-center text-muted py-3">No hay productos agrupados.</td></tr>`);
                        }

                        $('#previewTotalBoletas').text(res.boletas.length);
                        $('#previewMontoTotal').text('S/ ' + totalGeneral.toFixed(2));

                        // Ocultar mensaje previo de carga
                        $('#resultadoProceso').addClass('d-none');

                        // Resetear tab activa a "Boletas a Importar"
                        let triggerEl = document.querySelector('#previewTabs button[data-bs-target="#tab-boletas"]');
                        if (triggerEl) {
                            let tab = bootstrap.Tab.getInstance(triggerEl) || new bootstrap.Tab(triggerEl);
                            tab.show();
                        }

                        // Mostrar modal
                        $('#modalPreviewCarga').modal('show');

                        // Restaurar botón procesar
                        btnProcesar.prop('disabled', false).html('<i class="material-symbols-outlined">upload_file</i> Procesar Excel');
                    } else {
                        // Fallback tradicional
                        let html = `<div class="alert alert-success border-0 mb-0">
                            <i class="ri-check-double-line me-1"></i> ${res.message}
                        </div>`;

                        if (res.errores && res.errores.length > 0) {
                            html += `<div class="alert alert-warning border-0 mt-2 mb-0" style="max-height: 150px; overflow-y: auto; font-size: 12px;">
                                <strong>Advertencias:</strong><br>`;
                            res.errores.forEach(function (err) {
                                html += `• ${err}<br>`;
                            });
                            html += '</div>';
                        }

                        $('#resultadoProceso').html(html).removeClass('d-none');
                        setTimeout(function () {
                            window.location.reload();
                        }, 2500);
                    }
                } else {
                    let html = '';
                    if (res.bloqueo_pendientes) {
                        html = `
                            <div class="alert alert-danger border-0 p-3 rounded-3 mb-0 shadow-sm" style="background-color: #fff2f2; border-left: 4px solid #dc3545 !important;">
                                <div class="d-flex align-items-start gap-2">
                                    <i class="ri-error-warning-fill fs-22 text-danger mt-1"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-1 text-danger">Boletas Pendientes en Serie ${escapeHtml(res.serie)}</h6>
                                        <p class="mb-2 text-dark fs-13" style="line-height: 1.5;">${escapeHtml(res.message)}</p>
                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                            <button type="button" class="btn btn-sm btn-danger fw-bold d-inline-flex align-items-center gap-1 shadow-sm" id="btnVerPendientesSerie">
                                                <i class="material-symbols-outlined fs-16">visibility</i> Ver Boletas Pendientes (${res.total_pendientes})
                                            </button>
                                            <a href="${window.urlDescargarPendientesSerie}?serie=${encodeURIComponent(res.serie)}" target="_blank" class="btn btn-sm btn-outline-danger fw-bold d-inline-flex align-items-center gap-1 bg-white shadow-sm">
                                                <i class="material-symbols-outlined fs-16">download</i> Descargar Lista en Excel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        window.boletasPendientesBloqueo = res.boletas || [];
                        window.seriePendientesBloqueo = res.serie;
                        window.totalPendientesBloqueo = res.total_pendientes;

                        Swal.fire({
                            title: 'Boletas Pendientes Detectadas',
                            html: `Existen <b>${res.total_pendientes} boleta(s)</b> pendientes de envío a SUNAT para la serie <b>${res.serie}</b>.<br><small class="text-secondary mt-1 d-block">Para mantener la correlatividad, SUNAT exige enviar o regularizar las boletas pendientes antes de realizar una nueva carga.</small>`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: '<i class="material-symbols-outlined fs-16 align-middle">visibility</i> Ver Lista de Boletas',
                            cancelButtonText: 'Cerrar',
                            footer: `<a href="${window.urlDescargarPendientesSerie}?serie=${encodeURIComponent(res.serie)}" target="_blank" class="text-danger fw-bold text-decoration-none"><i class="material-symbols-outlined fs-15 align-middle">download</i> Descargar lista en Excel (.xlsx)</a>`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                mostrarModalPendientesSerie();
                            }
                        });

                    } else {
                        html = `<div class="alert alert-danger border-0 mb-0">
                            <i class="ri-error-warning-line me-1"></i> ${res.message}
                        </div>`;

                        if (res.errores && res.errores.length > 0) {
                            html += `<div class="alert alert-warning border-0 mt-2 mb-0" style="max-height: 150px; overflow-y: auto; font-size: 12px;">
                                <strong>Detalle de errores:</strong><br>`;
                            res.errores.forEach(function (err) {
                                html += `• ${err}<br>`;
                            });
                            html += '</div>';
                        }
                    }

                    $('#resultadoProceso').html(html).removeClass('d-none');
                    btnProcesar.prop('disabled', false).html('<i class="material-symbols-outlined">upload_file</i> Procesar Excel');

                    $('#btnVerPendientesSerie').on('click', function() {
                        mostrarModalPendientesSerie();
                    });
                }
            },
            error: function (xhr) {
                let msg = 'Error desconocido al procesar el archivo.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire('Error', msg, 'error');
                btnProcesar.prop('disabled', false).html('<i class="material-symbols-outlined">upload_file</i> Procesar Excel');
            }
        });
    }

    function mostrarModalPendientesSerie() {
        const boletas = window.boletasPendientesBloqueo || [];
        const serie = window.seriePendientesBloqueo || '';
        const total = window.totalPendientesBloqueo || boletas.length;

        $('#lblModalSerie').text(serie);
        $('#lblModalTotalPendientes').text(total);
        $('#btnDescargarExcelModal').attr('href', `${window.urlDescargarPendientesSerie}?serie=${encodeURIComponent(serie)}`);

        const tbody = $('#tbodyPendientesSerie');
        tbody.empty();

        if (boletas.length === 0) {
            tbody.append('<tr><td colspan="5" class="text-center py-4 text-muted">No se pudieron cargar los detalles de las boletas.</td></tr>');
        } else {
            boletas.forEach(function(b) {
                let badgeClass = 'bg-warning text-dark';
                if (b.estado_sunat === 'RECHAZADO') badgeClass = 'bg-danger text-white';
                else if (b.estado_sunat === 'ACEPTADO') badgeClass = 'bg-success text-white';

                const row = `
                    <tr>
                        <td class="fw-bold text-dark">${escapeHtml(b.comprobante)}</td>
                        <td>${escapeHtml(b.fecha_emision)}</td>
                        <td>
                            <div class="text-truncate fw-semibold text-dark" style="max-width: 250px;">${escapeHtml(b.cliente_nombre)}</div>
                            <small class="text-muted">${escapeHtml(b.cliente_doc)}</small>
                        </td>
                        <td class="text-end fw-bold text-success">S/ ${escapeHtml(b.total)}</td>
                        <td class="text-center">
                            <span class="badge ${badgeClass} px-2 py-1 fs-11">${escapeHtml(b.estado_sunat)}</span>
                            ${b.mensaje_sunat ? `<div class="text-muted text-truncate" style="font-size: 10px; max-width: 150px;" title="${escapeHtml(b.mensaje_sunat)}">${escapeHtml(b.mensaje_sunat)}</div>` : ''}
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        $('#modalPendientesSerie').modal('show');
    }

    // Funciones auxiliares para sanitizar y formatear
    function formatDate(dateStr) {
        if (!dateStr) return '';
        const parts = dateStr.split('-');
        if (parts.length === 3) {
            return parts[2] + '/' + parts[1] + '/' + parts[0];
        }
        return dateStr;
    }

    function escapeHtml(text) {
        if (!text) return '';
        return text
            .toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // ==================== VISTA PREVIA ACCIONES ====================
    $('#btnConfirmarPreview').on('click', function () {
        Swal.fire({
            title: '¿Confirmar y Registrar?',
            text: "Se registrarán todas las boletas cargadas en el sistema. Esta acción asignará los correlativos correspondientes.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, registrar boletas',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#1a73e8',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Registrando boletas...',
                    html: 'Por favor espere mientras se guardan los datos...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: window.urlConfirmarImportacion,
                    type: 'POST',
                    data: { _token: window.csrfToken },
                    success: function (res) {
                        if (res.success) {
                            $('#modalPreviewCarga').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: '¡Importación Completa!',
                                text: res.message,
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function (xhr) {
                        let msg = 'Error de conexión con el servidor al confirmar.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', msg, 'error');
                    }
                });
            }
        });
    });

    $('#btnCancelarPreview, #btnCerrarPreviewCross').on('click', function () {
        Swal.fire({
            title: '¿Cancelar importación?',
            text: "Se borrarán los datos cargados y tendrá que volver a subir el archivo Excel.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No, mantener',
            confirmButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: window.urlCancelarImportacion,
                    type: 'POST',
                    data: { _token: window.csrfToken },
                    success: function () {
                        // Limpiar formulario
                        $('#archivoExcel').val('');
                        $('#uploadIcon').text('cloud_upload');
                        $('#uploadText').text('Arrastre su archivo aquí o haga clic para seleccionar');
                        $('#uploadHint').text('Solo archivos .xlsx o .xls (máx. 5MB). Boletas ≥ S/ 700 requieren DNI/RUC real.');
                        $('#uploadZone').removeClass('file-selected');
                        $('#btnProcesar').prop('disabled', true);
                        
                        $('#modalPreviewCarga').modal('hide');
                    },
                    error: function () {
                        // Cerrar modal de todos modos
                        $('#modalPreviewCarga').modal('hide');
                    }
                });
            }
        });
    });

    // ==================== ENVIAR RESUMEN DIARIO ====================
    $('#btnEnviarResumen').on('click', function () {
        const fechas = window.fechasPendientes || [];
        
        if (fechas.length === 0) {
            Swal.fire('Atención', 'No se encontraron fechas válidas en las boletas pendientes.', 'warning');
            return;
        }

        let htmlContent = '';
        let confirmText = '';
        let defaultDate = fechas[0];

        if (fechas.length === 1) {
            // Solo hay una fecha, la mostramos simple
            const fechaFormateada = new Date(fechas[0] + 'T00:00:00').toLocaleDateString('es-PE');
            htmlContent = `Se enviarán todas las boletas con fecha de emisión: <strong>${fechaFormateada}</strong> a SUNAT.<br>
                           <input type="hidden" id="swalFechaRef" value="${fechas[0]}">`;
            confirmText = '<i class="ri-send-plane-line me-1"></i> Confirmar y Enviar';
        } else {
            // Hay varias fechas, dejamos elegir cuál enviar hoy
            let options = '';
            fechas.forEach(f => {
                const fLabel = new Date(f + 'T00:00:00').toLocaleDateString('es-PE');
                options += `<option value="${f}">${fLabel}</option>`;
            });

            htmlContent = `Se encontraron boletas de múltiples días. <strong>Seleccione cuál desea enviar en este resumen:</strong><br>
                <div class="mt-3">
                    <select id="swalFechaRef" class="form-select">
                        ${options}
                    </select>
                </div>`;
            confirmText = '<i class="ri-send-plane-line me-1"></i> Enviar a SUNAT';
        }

        const entornoBadge = `<div class="mt-3 mb-2 p-2 rounded" style="background-color: #f8f9fa; border: 1px dashed #ccc;"><span class="fw-bold text-secondary fs-14">Destino de envío:</span> <span class="badge ${window.entornoColor || 'bg-primary'}" style="font-size: 13px;">${window.entornoLabel || 'SUNAT'}</span></div>`;

        Swal.fire({
            title: '¿Enviar Resumen Diario?',
            html: htmlContent + entornoBadge + `<br><small class="text-muted">Este proceso puede tardar unos segundos.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#43a047',
            preConfirm: () => {
                return document.getElementById('swalFechaRef').value;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                enviarResumenDiario(result.value);
            }
        });
    });

    function enviarResumenDiario(fechaRef) {
        Swal.fire({
            title: 'Enviando a SUNAT...',
            html: 'Por favor espere mientras se procesa el Resumen Diario...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: window.urlEnviarResumen,
            type: 'POST',
            data: {
                _token: window.csrfToken,
                fecha_referencia: fechaRef
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({
                        icon: res.estado === 'ACEPTADO' ? 'success' : 'info',
                        title: res.estado === 'ACEPTADO' ? '¡Resumen Aceptado!' : 'Resumen Enviado',
                        html: res.message,
                        confirmButtonColor: '#1a73e8'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error', res.message, 'error').then(() => {
                        window.location.reload();
                    });
                }
            },
            error: function (xhr) {
                let msg = 'Error de conexión con el servidor.';
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                Swal.fire('Error', msg, 'error').then(() => {
                    window.location.reload();
                });
            }
        });
    }

    // ==================== CONSULTAR TICKET DE RESUMEN ====================
    $(document).on('click', '.btn-consultar-ticket', function () {
        const resumenId = $(this).data('id');
        const btn = $(this);

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.ajax({
            url: window.urlConsultarTicketResumen,
            type: 'POST',
            data: {
                _token: window.csrfToken,
                resumen_id: resumenId
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire('¡Actualizado!', res.message, 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Resultado', res.message, 'info');
                    btn.prop('disabled', false).html('<i class="ri-search-line me-1"></i> Consultar');
                }
            },
            error: function () {
                Swal.fire('Error', 'Error de conexión con el servidor.', 'error');
                btn.prop('disabled', false).html('<i class="ri-search-line me-1"></i> Consultar');
            }
        });
    });

    // ==================== RESETEAR RESUMEN RECHAZADO ====================
    $(document).on('click', '.btn-resetear-resumen', function () {
        const resumenId = $(this).data('id');
        
        Swal.fire({
            title: '¿Resetear resumen?',
            text: "Las boletas de este resumen volverán a estar 'Pendientes' para que puedas corregirlas o volver a enviarlas.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, liberar boletas',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Reseteando...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: window.urlResetearResumen,
                    type: 'POST',
                    data: {
                        _token: window.csrfToken,
                        resumen_id: resumenId
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire('¡Listo!', res.message, 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Error de conexión con el servidor.', 'error');
                    }
                });
            }
        });
    });

    // ==================== DATATABLES ====================
    if ($('#resumenesTable').length) {
        $('#resumenesTable').DataTable({
            responsive: true,
            autoWidth: false,
            order: [[0, 'desc']],
            columnDefs: [
                { orderable: false, targets: [6, 7] }
            ],
            language: window.dtSpanish,
            pageLength: 10,
        });
    }

    if ($('#tablaPendientes').length) {
        $('#tablaPendientes').DataTable({
            responsive: true,
            autoWidth: false,
            order: [[1, 'asc']], // Ordenar por fecha
            language: window.dtSpanish,
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50]
        });
    }

    // ==================== DOBLE CLIC EN FILA DE RESUMEN ====================
    $(document).on('dblclick', '.row-resumen', function () {
        const resumenId = $(this).data('id');
        const identificador = $(this).data('identificador');
        
        $('#resumenModalTitle').text('Detalle de Resumen Diario');
        $('#resumenModalSubtitle').text(identificador);
        $('#modalDetalleResumen').modal('show');
        $('#resumenModalBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-secondary">Cargando boletas...</p></div>');

        $.ajax({
            url: window.urlResumenBoletas,
            type: 'GET',
            data: { resumen_id: resumenId },
            success: function (res) {
                if (res.success) {
                    if (res.boletas.length === 0) {
                        $('#resumenModalBody').html('<div class="text-center py-5 text-secondary"><i class="material-symbols-outlined" style="font-size: 48px;">inbox</i><p class="mt-2">No se encontraron boletas en este resumen.</p></div>');
                        return;
                    }

                    let tableHtml = `
                        <div class="table-responsive" style="max-height: 450px;">
                            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                                <thead style="background: #f7f9fc; position: sticky; top: 0; z-index: 1;">
                                    <tr>
                                        <th class="border-0 text-secondary py-2 px-3">BOLETA</th>
                                        <th class="border-0 text-secondary py-2 px-3">FECHA</th>
                                        <th class="border-0 text-secondary py-2 px-3">CLIENTE</th>
                                        <th class="border-0 text-secondary py-2 px-3 text-end">TOTAL</th>
                                        <th class="border-0 text-secondary py-2 px-3 text-center">ESTADO SUNAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                    res.boletas.forEach(function (b) {
                        const clienteNombre = b.cliente ? b.cliente.razon_social : 'CLIENTE VARIOS';
                        const clienteDoc = b.cliente ? b.cliente.numero_documento : '-';
                        const nroDoc = b.serie + '-' + String(b.correlativo).padStart(8, '0');
                        const total = parseFloat(b.total).toFixed(2);
                        
                        let badgeClass = 'bg-secondary';
                        let badgeText = b.estado_sunat;
                        if (b.estado_sunat === 'ACEPTADO') {
                            badgeClass = 'badge bg-success';
                        } else if (b.estado_sunat === 'RECHAZADO') {
                            badgeClass = 'badge bg-danger';
                        } else if (b.estado_sunat === 'PENDIENTE_RESUMEN') {
                            badgeClass = 'badge bg-warning text-dark';
                            badgeText = 'PENDIENTE';
                        } else if (b.estado_sunat === 'RESUMEN_ENVIADO') {
                            badgeClass = 'badge bg-info text-white';
                            badgeText = 'ENVIADO';
                        }

                        tableHtml += `
                            <tr class="row-boleta-resumen" style="cursor: pointer;" title="Doble clic para ver detalle del comprobante" data-id="${b.id}">
                                <td class="fw-bold py-2 px-3">${nroDoc}</td>
                                <td class="py-2 px-3">${b.fecha_emision.split('-').reverse().join('/')}</td>
                                <td class="py-2 px-3">
                                    <div class="text-truncate" style="max-width: 250px;">${escapeHtml(clienteNombre)}</div>
                                    <small class="text-secondary">${clienteDoc}</small>
                                </td>
                                <td class="text-end fw-bold text-success py-2 px-3">S/ ${total}</td>
                                <td class="text-center py-2 px-3">
                                    <span class="${badgeClass} px-2 py-1 rounded-pill fw-bold" style="font-size: 10px;">
                                        ${badgeText}
                                    </span>
                                </td>
                            </tr>
                        `;
                    });

                    tableHtml += `
                                </tbody>
                            </table>
                        </div>
                    `;

                    $('#resumenModalBody').html(tableHtml);
                } else {
                    $('#resumenModalBody').html('<div class="alert alert-danger m-4">Error al cargar las boletas del resumen: ' + res.message + '</div>');
                }
            },
            error: function () {
                $('#resumenModalBody').html('<div class="alert alert-danger m-4">Error de conexión al cargar las boletas.</div>');
            }
        });
    });

    // Doble clic en una boleta de la lista del resumen para abrir su detalle individual
    $(document).on('dblclick', '.row-boleta-resumen', function () {
        const id = $(this).data('id');
        // Ocultar modal del resumen
        $('#modalDetalleResumen').modal('hide');
        
        // Esperar un momento a que termine la transición de cierre para evitar conflictos de Bootstrap
        setTimeout(function () {
            verDetalle(id);
        }, 150);
    });
});

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
            } else if (v.estado_sunat === 'PENDIENTE_RESUMEN') {
                estadoBadge = '<span class="badge bg-warning text-dark px-3 py-2" style="font-size:13px;"><i class="ri-time-line me-1"></i>PENDIENTE</span>';
            } else {
                estadoBadge = '<span class="badge bg-secondary px-3 py-2" style="font-size:13px;">' + v.estado_sunat + '</span>';
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
            `;

            $('#modalBody').html(html);
        } else {
            $('#modalBody').html('<div class="alert alert-danger m-4">Error al cargar el detalle.</div>');
        }
    });
}
