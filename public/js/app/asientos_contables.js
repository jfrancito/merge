$(document).ready(function() {
    // baseUrl es definida como variable global en la vista Blade

    // Generar asientos
    $('#btnGenerar').on('click', function() {
        const $btn = $(this);
        const $form = $('#formAsientos');
        const fechaDesde = $form.find('input[name="fecha_desde"]').val();
        const fechaHasta = $form.find('input[name="fecha_hasta"]').val();

        if (!fechaDesde || !fechaHasta) {
            Swal.fire({ icon: 'warning', title: 'Faltan fechas', text: 'Por favor seleccione el período a consultar.' });
            return;
        }

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Generando...');

        Swal.fire({
            title: 'Generando asientos...',
            text: 'Procesando comprobantes del período seleccionado.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        const isConcar = $('#tabConcar').hasClass('active');
        const url = isConcar ? baseUrl + '/asientos-contables/concar-data' : baseUrl + '/asientos-contables/data';

        $.ajax({
            url: url,
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                Swal.close();
                if (response.success) {
                    if (isConcar) {
                        renderAsientosConcar(response.rows);
                        $('#seccionResumenConcar').removeClass('d-none');
                        $('#sinDatosConcar').addClass('d-none');
                    } else {
                        renderResumen(response.resumen);
                        renderAsientos(response.asientos);
                        $('#seccionResumen').removeClass('d-none');
                    }
                } else {
                    if (isConcar) {
                        $('#seccionResumenConcar').addClass('d-none');
                        $('#sinDatosConcar').removeClass('d-none').html(`<i class="ri-information-line fs-24 mb-2 d-block"></i> ${response.message}`);
                        $('#contenedorAsientosConcar').html('');
                    } else {
                        $('#seccionResumen').addClass('d-none');
                        $('#contenedorAsientos').html('');
                        Swal.fire({ icon: 'info', title: 'Sin datos', text: response.message });
                    }
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo generar el reporte.' });
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="ri-search-line me-1"></i> Generar');
            }
        });
    });

    // Exportar a Excel (Formato Estándar)
    $('#btnExportarExcel').on('click', function() {
        const $btn = $(this);
        const $form = $('#formAsientos');

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Exportando...');

        Swal.fire({
            title: 'Generando Excel...',
            text: 'Preparando el archivo con los asientos contables.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: baseUrl + '/asientos-contables/excel',
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                Swal.close();
                if (response.success) {
                    const byteCharacters = atob(response.file);
                    const byteNumbers = new Array(byteCharacters.length);
                    for (let i = 0; i < byteCharacters.length; i++) {
                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                    }
                    const byteArray = new Uint8Array(byteNumbers);
                    const blob = new Blob([byteArray], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});

                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = response.filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    Swal.fire({ icon: 'success', title: '¡Listo!', text: 'El archivo se ha descargado.', timer: 2000, showConfirmButton: false });
                } else {
                    Swal.fire({ icon: 'info', title: 'Sin datos', text: response.message });
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo generar el Excel.' });
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="material-icons me-1">download</i> Exportar Excel');
            }
        });
    });

    // Exportar a Excel (Formato CONCAR)
    $(document).on('click', '#btnExportarExcelConcar', function() {
        const $btn = $(this);
        const $form = $('#formAsientos');

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Exportando...');

        Swal.fire({
            title: 'Generando Excel CONCAR...',
            text: 'Preparando el archivo de importación contable.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: baseUrl + '/asientos-contables/concar-excel',
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                Swal.close();
                if (response.success) {
                    const byteCharacters = atob(response.file);
                    const byteNumbers = new Array(byteCharacters.length);
                    for (let i = 0; i < byteCharacters.length; i++) {
                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                    }
                    const byteArray = new Uint8Array(byteNumbers);
                    const blob = new Blob([byteArray], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});

                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = response.filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    Swal.fire({ icon: 'success', title: '¡Listo!', text: 'El archivo CONCAR se ha descargado.', timer: 2000, showConfirmButton: false });
                } else {
                    Swal.fire({ icon: 'info', title: 'Sin datos', text: response.message });
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo generar el Excel de CONCAR.' });
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="material-icons me-1">download</i> Exportar Excel (CONCAR)');
            }
        });
    });

    // Renderizar cards de resumen
    function renderResumen(resumen) {
        $('#statComprobantes').text(resumen.total_comprobantes);
        $('#statGratuitas').text(resumen.total_con_gratuitas);
        $('#statDebe').text(formatMonto(resumen.total_debe));
        $('#statHaber').text(formatMonto(resumen.total_haber));
    }

    // Renderizar los asientos en cards
    function renderAsientos(asientos) {
        let html = '';

        asientos.forEach((asiento, index) => {
            let badgeHtml = asiento.tiene_gratuitas
                ? '<span class="badge-gratuita">CON GRATUITAS</span>'
                : '<span class="badge-normal">NORMAL</span>';

            let lineasHtml = '';
            let bloqueGratuitaIniciado = false;

            asiento.lineas.forEach(linea => {
                // Separador para el bloque de gratuitas
                if (linea.tipo === 'gratuita' && !bloqueGratuitaIniciado) {
                    bloqueGratuitaIniciado = true;
                    lineasHtml += `
                        <tr class="row-separador">
                            <td colspan="4">▸ TRANSFERENCIA GRATUITA</td>
                        </tr>
                    `;
                }

                let rowClass = linea.tipo === 'gratuita' ? 'row-gratuita' : '';
                let debeHtml = linea.debe > 0 ? `<span class="monto-debe">${formatMonto(linea.debe)}</span>` : '';
                let haberHtml = linea.haber > 0 ? `<span class="monto-haber">${formatMonto(linea.haber)}</span>` : '';

                lineasHtml += `
                    <tr class="${rowClass}">
                        <td class="cuenta-code">${linea.cuenta}</td>
                        <td>${linea.descripcion}</td>
                        <td class="text-end">${debeHtml}</td>
                        <td class="text-end">${haberHtml}</td>
                    </tr>
                `;
            });

            html += `
                <div class="asiento-card">
                    <div class="asiento-header">
                        <div>
                            <span class="comprobante-nombre">${asiento.comprobante}</span>
                            <span class="comprobante-info ms-2">${asiento.tipo} | ${asiento.fecha}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="comprobante-info">${asiento.cliente} (${asiento.ruc_dni})</span>
                            ${badgeHtml}
                        </div>
                    </div>
                    <table class="table asiento-table">
                        <thead>
                            <tr>
                                <th style="width: 120px;">CUENTA</th>
                                <th>DESCRIPCIÓN</th>
                                <th class="text-end" style="width: 130px;">DEBE</th>
                                <th class="text-end" style="width: 130px;">HABER</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${lineasHtml}
                        </tbody>
                    </table>
                    <div class="asiento-footer">
                        <span>TOTALES</span>
                        <div>
                            <span class="text-primary me-4">Debe: S/ ${formatMonto(asiento.total_debe)}</span>
                            <span class="text-success">Haber: S/ ${formatMonto(asiento.total_haber)}</span>
                        </div>
                    </div>
                </div>
            `;
        });

        $('#contenedorAsientos').html(html);
    }

    // Renderizar la tabla plana de CONCAR
    function renderAsientosConcar(rows) {
        let html = '';
        rows.forEach(row => {
            html += `
                <tr>
                    <td class="px-3 py-2 text-center" style="font-family: monospace;">${row.campo}</td>
                    <td class="px-3 py-2 text-center" style="font-family: monospace;">${row.subdiario}</td>
                    <td class="px-3 py-2 text-center" style="font-family: monospace;">${row.comprobante_nro}</td>
                    <td class="px-3 py-2 text-center">${row.fecha_comprobante}</td>
                    <td class="px-3 py-2 text-center">${row.moneda}</td>
                    <td class="px-3 py-2" title="${row.glosa}">${row.glosa}</td>
                    <td class="px-3 py-2 text-end" style="font-family: monospace;">${row.tc}</td>
                    <td class="px-3 py-2 text-center">${row.tipo_conversion}</td>
                    <td class="px-3 py-2 text-center">${row.flag_conversion}</td>
                    <td class="px-3 py-2 text-center">${row.fecha_tc}</td>
                    <td class="px-3 py-2 text-center fw-bold" style="font-family: monospace; color: #1e3a5f;">${row.cuenta}</td>
                    <td class="px-3 py-2 text-center" style="font-family: monospace;">${row.anexo || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.centro_costo || '-'}</td>
                    <td class="px-3 py-2 text-center fw-bold ${row.debe_haber === 'D' ? 'text-primary' : 'text-success'}">${row.debe_haber}</td>
                    <td class="px-3 py-2 text-end fw-bold" style="font-family: monospace;">${formatMonto(row.imp_original)}</td>
                    <td class="px-3 py-2 text-end" style="font-family: monospace; color: #555;">${formatMonto(row.imp_dolares)}</td>
                    <td class="px-3 py-2 text-end" style="font-family: monospace; color: #555;">${formatMonto(row.imp_soles)}</td>
                    <td class="px-3 py-2 text-center fw-bold">${row.tipo_doc}</td>
                    <td class="px-3 py-2" style="font-family: monospace;">${row.num_doc}</td>
                    <td class="px-3 py-2 text-center">${row.fecha_emision}</td>
                    <td class="px-3 py-2 text-center">${row.fecha_vence}</td>
                    <td class="px-3 py-2 text-center">${row.codigo_tributo || '-'}</td>
                    <td class="px-3 py-2" title="${row.glosa_detalle}">${row.glosa_detalle}</td>
                    <td class="px-3 py-2 text-center">${row.anexo_auxiliar || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.medio_pago || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.tipo_doc_ref || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.num_doc_ref || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.fecha_doc_ref || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.nro_reg_inmueble || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.area_geografica || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.detraccion_tipo || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.detraccion_nro || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.detraccion_fecha || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.clasificacion_operacion || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.tc_especial || '-'}</td>
                    <td class="px-3 py-2 text-center">${row.tasa_igv || '-'}</td>
                </tr>
            `;
        });
        $('#contenedorAsientosConcar').html(html);
    }

    // Formatear montos
    function formatMonto(valor) {
        return parseFloat(valor).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
});
