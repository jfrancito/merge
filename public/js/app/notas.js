/**
 * notas.js - Módulo compartido para Notas de Crédito (07) y Notas de Débito (08)
 * La variable global `tipoNota` (definida en la vista) determina el tipo de documento.
 * La variable global `appBaseUrl` (definida en la vista) es la URL base del sistema.
 */

let itemsNota = [];

$(document).ready(function () {

    let esNC = (tipoNota === '07');
    let nombreDoc = esNC ? 'Nota de Crédito' : 'Nota de Débito';
    let emitirUrl = esNC ? '/nota-credito/emitir' : '/nota-debito/emitir';

    // ------------- 1. AUTOCOMPLETE COMPROBANTE DE REFERENCIA -------------
    let refTimer;
    $('#buscar_comprobante_ref').on('keyup', function () {
        let q = $(this).val();
        let $resList = $('#ref_results');

        clearTimeout(refTimer);
        if (q.length < 3) {
            $resList.addClass('d-none');
            return;
        }

        refTimer = setTimeout(function () {
            let apiUrl = esNC ? "/api/nota-credito/buscar-comprobante" : "/api/nota-debito/buscar-comprobante";
            $.get(appBaseUrl + apiUrl, { q: q }, function (data) {
                $resList.empty();
                if (data.length > 0) {
                    data.forEach(item => {
                        let textTipo = (item.tipo_comprobante == '01') ? 'FACTURA' : 'BOLETA';
                        let nroDoc = item.serie + '-' + String(item.correlativo).padStart(8, '0');
                        $resList.append(`
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action item-ref"
                                data-id="${item.id}" 
                                data-tipo="${item.tipo_comprobante}" 
                                data-tipotexto="${textTipo}"
                                data-serie="${item.serie}" 
                                data-correlativo="${item.correlativo}"
                                data-total="${item.total}"
                                data-cliente="${item.cliente ? item.cliente.razon_social : 'N/A'}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-primary">${nroDoc}</span>
                                    <span class="badge bg-light text-dark border">${item.fecha_emision}</span>
                                </div>
                                <div class="small text-muted">${item.cliente ? item.cliente.razon_social : 'CLIENTE VARIOS'}</div>
                                <div class="small fw-bold">${item.simbolo_moneda || 'S/'} ${parseFloat(item.total_moneda_original || item.total).toFixed(2)}</div>
                            </a>
                        `);
                    });
                    $resList.removeClass('d-none');
                } else {
                    $resList.html('<div class="list-group-item text-muted small py-2">No se encontraron comprobantes aceptados</div>').removeClass('d-none');
                }
            });
        }, 350);
    });

    let currentSeriesData = []; // Store correlativos

    // Función para abstraer la carga de series
    function cargarSeriesDisponibles(tipoComprobante) {
        let prefijo = (tipoComprobante == '01') ? 'F' : 'B';
        let apiUrl = esNC ? "/api/nota-credito/obtener-serie" : "/api/nota-debito/obtener-serie";
        let $serieSelect = $('#serie_nota');
        let $correlativoInput = $('#correlativo_nota');

        $serieSelect.empty().append('<option value="" disabled selected>Cargando series...</option>').prop('disabled', true);
        $correlativoInput.val('Cargando...');
        currentSeriesData = [];

        $.get(appBaseUrl + apiUrl, { prefijo: prefijo }, function (res) {
            $serieSelect.empty();
            if (res.success && res.series && res.series.length > 0) {
                currentSeriesData = res.series;
                res.series.forEach((s, idx) => {
                    let selected = idx === 0 ? 'selected' : '';
                    $serieSelect.append(`<option value="${s.serie}" ${selected}>${s.serie}</option>`);
                });
                $serieSelect.prop('disabled', false);
                $serieSelect.trigger('change');
            } else {
                $serieSelect.append('<option value="" disabled selected>SIN SERIE DISPONIBLE</option>');
                $correlativoInput.val('-');
                Swal.fire('Atención', `No tiene una serie activa para Notas de ${esNC ? 'Crédito' : 'Débito'} que empiece con la letra '${prefijo}'. Modifique sus series.`, 'warning');
            }
        });
    }

    // Selección de comprobante
    $(document).on('click', '.item-ref', function () {
        let id = $(this).data('id');
        let tipoComprobante = $(this).data('tipo');
        let nro = $(this).data('serie') + '-' + String($(this).data('correlativo')).padStart(8, '0');

        $('#comprobante_ref_id').val(id);
        $('#buscar_comprobante_ref').val(nro);
        $('#ref_tipo').val($(this).data('tipotexto') + ' ' + nro);
        $('#ref_cliente').val($(this).data('cliente'));
        $('#ref_results').addClass('d-none');

        // Limpiar items previos si cambia la referencia
        itemsNota = [];
        renderTableNC();

        cargarSeriesDisponibles(tipoComprobante);
    });

    // Cargar la serie automáticamente si el formulario ya viene pre-cargado (viene desde Venta -> Nueva Nota)
    let refTipoCarga = $('#ref_tipo').val();
    if (refTipoCarga && refTipoCarga.trim() !== '') {
        let tipoOnLoad = refTipoCarga.includes('FACTURA') ? '01' : (refTipoCarga.includes('BOLETA') ? '03' : null);
        if (tipoOnLoad) {
            cargarSeriesDisponibles(tipoOnLoad);
        }
    }

    $('#serie_nota').on('change', function () {
        let val = $(this).val();
        let serieObj = currentSeriesData.find(s => s.serie === val);
        if (serieObj) {
            $('#correlativo_nota').val(serieObj.correlativo);
        }
    });

    // Cerrar resultados al hacer clic fuera
    $(document).on('click', function (e) {
        if (!$(e.target).closest("#buscar_comprobante_ref, #ref_results").length) {
            $("#ref_results").addClass('d-none');
        }
    });

    // 2. Cargar ítems desde el comprobante original
    $('#btnCargarItems').on('click', function () {
        let refId = $('#comprobante_ref_id').val();
        if (!refId) {
            Swal.fire('Atención', 'Primero seleccione un comprobante de referencia.', 'warning');
            return;
        }

        // Determinar la URL según tipo
        let urlDetalles = esNC ? '/api/nota-credito/detalles' : '/api/nota-debito/detalles';

        $.get(appBaseUrl + urlDetalles, { venta_id: refId }, function (res) {
            if (res.success && res.detalles && res.detalles.length > 0) {
                // ... (items loading code)
                itemsNota = [];
                res.detalles.forEach(det => {
                    let isUSD = (res.venta && res.venta.moneda === 'USD');
                    let precioUnit = parseFloat(isUSD ? det.precio_unitario_original : det.precio_unitario);
                    let valorUnit = isUSD ? (precioUnit / 1.18) : parseFloat(det.valor_unitario);
                    let cant = parseFloat(det.cantidad);
                    let igv = isUSD ? (cant * valorUnit * 0.18) : parseFloat(det.igv);
                    let importe = isUSD ? (cant * precioUnit) : parseFloat(det.total);
                    let tipoAfecta = det.tipo_afectacion || '10';
                    let esItemGratuito = ['11','12','13','14','15','16','17','21','31','32','33','34','35','36'].includes(tipoAfecta);

                    itemsNota.push({
                        producto_id: det.producto_id,
                        descripcion: det.descripcion || ('Producto ' + det.producto_id),
                        cantidad: cant,
                        precio_unitario: esItemGratuito ? 0 : precioUnit,
                        precio_referencial: esItemGratuito ? precioUnit : 0,
                        valor_unitario: esItemGratuito ? 0 : valorUnit,
                        igv: esItemGratuito ? 0 : igv,
                        importe: esItemGratuito ? 0 : importe,
                        tipo_afectacion: tipoAfecta,
                        simbolo: res.simbolo_moneda || 'S/'
                    });
                });
                renderTableNC();
                if (res.venta && res.venta.cuotas && res.venta.cuotas.length > 0) {
                    cargarCuotasOriginales(res.venta.cuotas);
                }
                Swal.fire({
                    toast: true, position: 'top-end', icon: 'success',
                    title: res.detalles.length + ' ítems cargados del comprobante original.',
                    showConfirmButton: false, timer: 2000
                });
            } else {
                let msg = res.message || 'No se encontraron items en el comprobante seleccionado.';
                let icono = res.message ? 'error' : 'info';
                Swal.fire(res.success ? 'Sin datos' : 'Atención', msg, icono);
            }
        });
    });

    // 3. Render table de items
    function renderTableNC() {
        let html = '';
        let totalGravadas = 0, totalExoneradas = 0, totalInafectas = 0, totalGratuitas = 0, totalIGV = 0, totalGeneral = 0;
        let motivo = $('#motivo_codigo').val();
        let esAjusteCuotas = ['11', '12', '13'].includes(motivo);

        if (itemsNota.length === 0) {
            let icon = esNC ? 'assignment_return' : 'trending_up';
            $('#tablaDetallesNC tbody').html('<tr id="rowEmptyNC"><td colspan="6" class="text-center text-muted py-4"><i class="material-symbols-outlined fs-40 d-block mb-2 text-secondary">' + icon + '</i>Sin items cargados</td></tr>');
        } else {
            // Deshabilitar campos si es anulación total (01), devolución total (06) o ajuste de cuotas (11, 12, 13)
            let readonly = (esNC && (motivo === '01' || motivo === '06' || esAjusteCuotas)) ? 'readonly' : '';

            itemsNota.forEach((item, index) => {
                let simbolo = item.simbolo || 'S/';
                let esItemGratuito = ['11', '12', '13', '14', '15', '16', '17', '21', '31', '32', '33', '34', '35', '36'].includes(item.tipo_afectacion);
                let badgeGratuito = esItemGratuito ? '<span class="badge bg-success small d-block" style="font-size:10px;">GRATUITO</span>' : '';
                
                let precioMostrar = esAjusteCuotas ? 0 : (esItemGratuito ? (item.precio_referencial || 0) : item.precio_unitario);
                let igvMostrar = esAjusteCuotas ? 0 : item.igv;
                let importeMostrar = esAjusteCuotas ? 0 : (esItemGratuito ? 0 : item.importe);

                html += `<tr>
                    <td class="text-center">
                        <input type="number" class="form-control form-control-sm text-center fw-bold nc-cant" data-index="${index}" value="${item.cantidad}" min="0.01" step="0.01" style="width:70px;" ${readonly}>
                    </td>
                    <td>
                        <div class="fw-bold">${item.descripcion}</div>
                        ${badgeGratuito}
                        ${esAjusteCuotas ? '<span class="badge bg-warning text-dark style="font-size:10px;">VALOR S/ 0.00 (AJUSTE CUOTAS)</span>' : ''}
                        <input type="hidden" class="nc-desc" data-index="${index}" value="${item.descripcion}">
                    </td>
                    <td class="text-end">
                        <div class="${(esItemGratuito || esAjusteCuotas) ? 'text-decoration-line-through text-muted small' : ''}">
                            <input type="number" class="form-control form-control-sm text-end nc-precio" data-index="${index}" value="${precioMostrar.toFixed(2)}" min="0.00" step="0.01" style="width:100px; display:inline-block;" ${readonly}>
                        </div>
                    </td>
                    <td class="text-end text-muted small">${simbolo} ${igvMostrar.toFixed(2)}</td>
                    <td>
                        <select class="form-select form-select-sm nc-impuesto" data-index="${index}" ${readonly} style="font-size: 10px; padding: 2px 4px;">
                            <option value="10" ${item.tipo_afectacion == '10' ? 'selected' : ''}>GRAVADO</option>
                            <option value="20" ${item.tipo_afectacion == '20' ? 'selected' : ''}>EXONERADO</option>
                            <option value="30" ${item.tipo_afectacion == '30' ? 'selected' : ''}>INAFECTO</option>
                            <option value="11" ${esItemGratuito ? 'selected' : ''}>GRATUITO</option>
                        </select>
                    </td>
                    <td class="text-end fw-bold text-dark">${simbolo} ${importeMostrar.toFixed(2)}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-sm btn-outline-primary p-1 me-1 edit-nc-item" data-index="${index}" title="Editar" ${esAjusteCuotas ? 'disabled' : ''}>
                                <i class="material-symbols-outlined fs-16">edit</i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger p-1 rmv-nc-item" data-index="${index}" title="Eliminar" ${esAjusteCuotas ? 'disabled' : ''}>
                                <i class="material-symbols-outlined fs-16">delete</i>
                            </button>
                        </div>
                    </td>
                </tr>`;

                if (!esAjusteCuotas) {
                    if (esItemGratuito) {
                        totalGratuitas += (precioMostrar * item.cantidad);
                    } else if (item.tipo_afectacion === '10') {
                        totalGravadas += (item.valor_unitario * item.cantidad);
                        totalIGV += item.igv;
                    } else if (item.tipo_afectacion === '30' || item.tipo_afectacion === '21') {
                        totalInafectas += item.importe;
                    } else {
                        totalExoneradas += item.importe;
                    }
                    totalGeneral += esItemGratuito ? 0 : item.importe;
                }
            });
            $('#tablaDetallesNC tbody').html(html);
        }

        let mainSimbolo = itemsNota.length > 0 ? (itemsNota[0].simbolo || 'S/') : 'S/';
        $('.nc_simbolo').text(mainSimbolo);

        $('#nc_gravadas').text(totalGravadas.toFixed(2));
        $('#nc_exoneradas').text(totalExoneradas.toFixed(2));
        $('#nc_inafectas').text(totalInafectas.toFixed(2));
        $('#nc_igv').text(totalIGV.toFixed(2));
        $('#nc_total').text(totalGeneral.toFixed(2));
        
        if (totalGratuitas > 0) {
            $('#nc_gratuitas').text(totalGratuitas.toFixed(2));
            $('#row_nc_gratuitas').removeClass('d-none');
        } else {
            $('#row_nc_gratuitas').addClass('d-none');
        }
    }

    // 4. Eliminar item de la nota
    $(document).on('click', '.rmv-nc-item', function () {
        itemsNota.splice($(this).data('index'), 1);
        renderTableNC();
    });

    // 5. Actualizar cantidad, precio, impuesto o descripción
    $(document).on('change', '.nc-cant, .nc-precio, .nc-desc, .nc-impuesto', function () {
        let idx = $(this).data('index');
        let item = itemsNota[idx];

        if ($(this).hasClass('nc-desc')) {
            item.descripcion = $(this).val();
        } else if ($(this).hasClass('nc-cant')) {
            let nuevaCant = parseFloat($(this).val());
            if (nuevaCant <= 0 || isNaN(nuevaCant)) { nuevaCant = 1; $(this).val(1); }
            item.cantidad = nuevaCant;
        } else if ($(this).hasClass('nc-impuesto')) {
            item.tipo_afectacion = $(this).val();
            // Recalcular base unitaria según nuevo impuesto
            item.valor_unitario = item.tipo_afectacion === '10' ? item.precio_unitario / 1.18 : item.precio_unitario;
        } else {
            let nuevoPrecio = parseFloat($(this).val());
            if (nuevoPrecio <= 0 || isNaN(nuevoPrecio)) { nuevoPrecio = item.precio_unitario; $(this).val(nuevoPrecio.toFixed(2)); }
            item.precio_unitario = nuevoPrecio;
            // Calcular valor unitario (sin IGV)
            item.valor_unitario = item.tipo_afectacion === '10' ? nuevoPrecio / 1.18 : nuevoPrecio;
        }

        // Recalcular item
        let esItemGratuito = ['11', '12', '13', '14', '15', '16', '17', '21', '31', '32', '33', '34', '35', '36'].includes(item.tipo_afectacion);

        if (esItemGratuito) {
            // Si es gratuito, el precio que el usuario puso se vuelve referencial
            item.precio_referencial = item.precio_unitario || item.precio_referencial || 0;
            item.precio_unitario = 0;
            item.valor_unitario = 0;
            item.igv = 0;
            item.importe = 0;
        } else if (item.tipo_afectacion === '10') {
            item.igv = item.cantidad * item.valor_unitario * 0.18;
            item.importe = item.cantidad * item.precio_unitario;
        } else {
            item.igv = 0;
            item.importe = item.cantidad * item.valor_unitario;
        }
        renderTableNC();
    });

    $(document).on('click', '.edit-nc-item', function () {
        let row = $(this).closest('tr');
        row.find('.nc-cant').focus().select();
        
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
        Toast.fire({
            icon: 'info',
            title: 'Listo para modificar'
        });
    });

    // 5.1 Al cambiar el motivo, refrescar la tabla y mostrar/ocultar panel de cuotas
    $('#motivo_codigo').on('change', function () {
        let motivo = $(this).val();
        renderTableNC();
        
        if (['11', '12', '13'].includes(motivo)) {
            $('#container_cuotas_credito').removeClass('d-none');
            $('#card_info_ajuste_cuotas').removeClass('d-none');
            $('#card_items_nc').addClass('d-none');
            if ($('#tbody_cuotas_credito tr').length === 0) {
                let defaultMonto = 0;
                let hoy = new Date();
                hoy.setDate(hoy.getDate() + 30);
                let fechaDefault = hoy.toISOString().split('T')[0];
                agregarFilaCuota(fechaDefault, defaultMonto);
            }
        } else {
            $('#container_cuotas_credito').addClass('d-none');
            $('#card_info_ajuste_cuotas').addClass('d-none');
            $('#card_items_nc').removeClass('d-none');
        }
    });

    // --- LÓGICA DE GESTIÓN DE CUOTAS PARA MOTIVOS 11, 12, 13 ---
    function agregarFilaCuota(fecha = '', monto = 0) {
        let nro = $('#tbody_cuotas_credito tr').length + 1;
        let simbolo = $('.nc_simbolo').first().text() || 'S/';
        let html = `
            <tr>
                <td class="text-center fw-bold td-num-cuota">${nro}</td>
                <td>
                    <input type="date" class="form-control form-control-sm input-cuota-fecha" value="${fecha}" required>
                </td>
                <td>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">${simbolo}</span>
                        <input type="number" class="form-control form-control-sm text-end input-cuota-monto" value="${parseFloat(monto).toFixed(2)}" min="0.01" step="0.01" required>
                    </div>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger p-1 rmv-cuota-item" title="Eliminar Cuota">
                        <i class="material-symbols-outlined fs-16">delete</i>
                    </button>
                </td>
            </tr>
        `;
        $('#tbody_cuotas_credito').append(html);
        recalcularCuotasTotales();
    }

    function recalcularCuotasTotales() {
        let totalSum = 0;
        let simbolo = $('.nc_simbolo').first().text() || 'S/';
        
        $('#tbody_cuotas_credito tr').each(function(idx) {
            $(this).find('.td-num-cuota').text(idx + 1);
            let monto = parseFloat($(this).find('.input-cuota-monto').val()) || 0;
            totalSum += monto;
        });
        
        $('#td_total_cuotas_credito').text(simbolo + ' ' + totalSum.toFixed(2));
    }

    $('#btn_agregar_cuota').on('click', function() {
        let hoy = new Date();
        let cantActual = $('#tbody_cuotas_credito tr').length;
        hoy.setDate(hoy.getDate() + (30 * (cantActual + 1)));
        let fechaNext = hoy.toISOString().split('T')[0];
        agregarFilaCuota(fechaNext, 0);
    });

    $(document).on('click', '.rmv-cuota-item', function() {
        $(this).closest('tr').remove();
        recalcularCuotasTotales();
    });

    $(document).on('change keyup', '.input-cuota-monto, .input-cuota-fecha', function() {
        recalcularCuotasTotales();
    });

    // Cargar cuotas de la venta original si están disponibles
    function cargarCuotasOriginales(cuotas) {
        $('#tbody_cuotas_credito').empty();
        if (cuotas && cuotas.length > 0) {
            cuotas.forEach(c => {
                let fecha = c.fecha_pago || c.fecha_vencimiento || '';
                let monto = c.monto || 0;
                agregarFilaCuota(fecha, monto);
            });
        }
    }

    // 6. Emitir NC/ND
    $('#btnEmitirNC').on('click', function () {
        let isExterno = $('#ref_externa').is(':checked');
        let refId = $('#comprobante_ref_id').val();
        let motivoCodigo = $('#motivo_codigo').val();
        let motivoDesc = $('#motivo_descripcion').val();
        let serieAsignada = $('#serie_nota').val();

        if (isExterno) {
            let refExtTipo = $('#ref_ext_tipo_comprobante').val();
            let refExtSerie = $('#ref_ext_serie').val().trim().toUpperCase();
            let refExtCorrelativo = $('#ref_ext_correlativo').val().trim();
            let refExtClienteId = $('#ref_ext_cliente_id').val();

            if (!refExtTipo) { Swal.fire('Atención', 'Seleccione el tipo de comprobante de referencia externo.', 'warning'); return; }
            if (refExtSerie.length !== 4) { Swal.fire('Atención', 'La serie de referencia debe tener 4 caracteres (Ej: F001).', 'warning'); return; }
            if (!refExtCorrelativo) { Swal.fire('Atención', 'Ingrese el correlativo de referencia externo.', 'warning'); return; }
            if (!refExtClienteId) { Swal.fire('Atención', 'Debe buscar y seleccionar un cliente destinatario.', 'warning'); return; }
        } else {
            if (!refId) { Swal.fire('Atención', 'Seleccione un comprobante de referencia.', 'warning'); return; }
        }

        if (!serieAsignada) { Swal.fire('Atención', 'Seleccione la serie para esta Nota.', 'warning'); return; }

        // Validaciones de Fecha de Emisión
        let fechaEmision = $('#fecha_emision_nota').val();
        if (!fechaEmision) { Swal.fire('Atención', 'Seleccione la fecha de emisión para esta Nota.', 'warning'); return; }
        
        let selectedDate = new Date(fechaEmision + 'T00:00:00');
        let todayDate = new Date();
        todayDate.setHours(0,0,0,0);
        
        if (selectedDate > todayDate) {
            Swal.fire('Atención', 'La fecha de emisión no puede ser futura.', 'warning');
            return;
        }
        
        let minDate = new Date(todayDate);
        minDate.setDate(todayDate.getDate() - 3);
        if (selectedDate < minDate) {
            Swal.fire('Atención', 'La fecha de emisión no puede ser menor a 3 días anteriores a hoy.', 'warning');
            return;
        }

        if (!motivoCodigo) { Swal.fire('Atención', 'Seleccione el motivo de la ' + nombreDoc + '.', 'warning'); return; }
        if (!motivoDesc || motivoDesc.trim().length < 3) { Swal.fire('Atención', 'Describa el motivo de la ' + nombreDoc + '.', 'warning'); return; }
        if (!['11', '12', '13'].includes(motivoCodigo) && itemsNota.length === 0) { Swal.fire('Atención', 'Debe tener al menos un ítem en la nota.', 'warning'); return; }

        // Validación especial de cuotas para motivos 11, 12, 13
        let cuotasCreditoPayload = [];
        if (['11', '12', '13'].includes(motivoCodigo)) {
            $('#tbody_cuotas_credito tr').each(function() {
                let fecha = $(this).find('.input-cuota-fecha').val();
                let monto = parseFloat($(this).find('.input-cuota-monto').val()) || 0;
                if (fecha && monto > 0) {
                    cuotasCreditoPayload.push({
                        fecha_vencimiento: fecha,
                        monto: monto
                    });
                }
            });

            if (cuotasCreditoPayload.length === 0) {
                Swal.fire('Atención', 'Para los motivos de Ajuste de Cuotas (11, 12, 13) debe ingresar al menos una cuota reprogramada válida con fecha de vencimiento y monto.', 'warning');
                return;
            }
        }

        let totalStr = $('#nc_total').text();
        let simboloStr = itemsNota.length > 0 ? (itemsNota[0].simbolo || 'S/') : 'S/';
        Swal.fire({
            title: '¿Confirmar Emisión?',
            html: `Se emitirá una <strong>${nombreDoc}</strong> por <strong>${simboloStr} ${totalStr}</strong> a SUNAT.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, Emitir',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: esNC ? '#ffc107' : '#dc3545'
        }).then((result) => {
            if (!result.isConfirmed) return;

            // Mostrar loader global e inmediato
            Swal.showLoading();
            if (typeof window.abrircargando === 'function') {
                window.abrircargando('Firmando XML y enviando a SUNAT...');
            }

            let payload = {
                es_externo: isExterno,
                fecha_emision: fechaEmision,
                comprobante_ref_id: isExterno ? null : refId,
                ref_tipo_comprobante: isExterno ? $('#ref_ext_tipo_comprobante').val() : null,
                ref_serie: isExterno ? $('#ref_ext_serie').val().trim().toUpperCase() : null,
                ref_correlativo: isExterno ? $('#ref_ext_correlativo').val().trim() : null,
                ref_fecha_emision: isExterno ? $('#ref_ext_fecha_emision').val() : null,
                ref_moneda: isExterno ? $('#ref_ext_moneda').val() : null,
                ref_tipo_cambio: isExterno ? $('#ref_ext_tipo_cambio').val() : null,
                cliente_id: isExterno ? $('#ref_ext_cliente_id').val() : null,
                serie_nota: serieAsignada,
                motivo_codigo: motivoCodigo,
                motivo_descripcion: motivoDesc,
                items: itemsNota,
                cuotas: cuotasCreditoPayload
            };

            $.ajax({
                url: appBaseUrl + emitirUrl,
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: JSON.stringify(payload),
                contentType: "application/json",
                success: function (res) {
                    if (typeof window.cerrarcargando === 'function') window.cerrarcargando();
                    if (res.success) {
                        let downloadButtons = `
                            <div class="mt-3 p-3 rounded-3" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                <p class="mb-2 text-secondary small fw-bold text-uppercase">Accesos Rápidos:</p>
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <a href="${appBaseUrl}/venta/imprimir/${res.id_cifrado}/a4" target="_blank" class="btn btn-warning d-flex align-items-center gap-2 shadow-sm">
                                        <i class="material-symbols-outlined fs-20">description</i> A4
                                    </a>
                                    <a href="${appBaseUrl}/venta/imprimir/${res.id_cifrado}/ticket" target="_blank" class="btn btn-dark d-flex align-items-center gap-2 shadow-sm">
                                        <i class="material-symbols-outlined fs-20">receipt</i> TICKET
                                    </a>
                                    ${res.wa_url ? `
                                    <a href="${res.wa_url}" target="_blank" class="btn btn-success d-flex align-items-center gap-2 shadow-sm border-0" style="background-color: #25D366;">
                                        <i class="material-symbols-outlined fs-20">chat</i> WHATSAPP
                                    </a>` : ''}
                                    ${res.xml_url ? `
                                    <a href="${res.xml_url}" target="_blank" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
                                        <i class="material-symbols-outlined fs-20">code</i> XML
                                    </a>` : ''}
                                    ${res.cdr_url ? `
                                    <a href="${res.cdr_url}" target="_blank" class="btn btn-success d-flex align-items-center gap-2 shadow-sm">
                                        <i class="material-symbols-outlined fs-20">task_alt</i> CDR
                                    </a>` : ''}
                                </div>
                            </div>
                        `;

                        Swal.fire({
                            title: '¡' + nombreDoc + ' Emitida!',
                            html: `<div class="text-start">${res.message}</div> ${downloadButtons}`,
                            icon: 'success',
                            confirmButtonText: 'Emitir Otra',
                            showCancelButton: true,
                            cancelButtonText: 'Cerrar',
                            width: '500px'
                        }).then((r) => {
                            if (r.isConfirmed) {
                                window.location.reload();
                            } else {
                                window.location.href = appBaseUrl + (esNC ? '/notas-de-credito/' : '/notas-de-debito/') + idOpcion;
                            }
                        });

                        // Limpiar formulario de inmediato
                        $('#comprobante_ref_id').val('');
                        $('#buscar_comprobante_ref').val('');
                        $('#ref_tipo').val('');
                        $('#ref_cliente').val('');
                        $('#motivo_codigo').val('');
                        $('#motivo_descripcion').val('');

                        // Limpiar campos de referencia externa
                        $('#ref_externa').prop('checked', false).trigger('change');
                        $('#ref_ext_serie').val('');
                        $('#ref_ext_correlativo').val('');
                        $('#ref_ext_razon_social_cliente').val('');
                        $('#ref_ext_nro_doc_cliente').val('');
                        $('#ref_ext_cliente_id').val('');

                        itemsNota = [];
                        renderTableNC();
                    } else {
                        Swal.fire('Rechazado / Error', res.message, 'error');
                    }
                },
                error: function (err) {
                    if (typeof window.cerrarcargando === 'function') window.cerrarcargando();
                    let msg = 'Error de comunicación con el servidor.';
                    if (err.responseJSON && err.responseJSON.message) msg = err.responseJSON.message;
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    });

    // --- LÓGICA DE REFERENCIA EXTERNA MANUAL ---
    $('#ref_externa').on('change', function() {
        let isChecked = $(this).is(':checked');
        if (isChecked) {
            $('#row_referencia_interna').addClass('d-none');
            $('#row_referencia_externa').removeClass('d-none');
            $('#btnAgregarItemManual').removeClass('d-none');
            
            // Forzar carga de series con valor default de factura
            let defaultTipo = $('#ref_ext_tipo_comprobante').val();
            cargarSeriesDisponibles(defaultTipo);
        } else {
            $('#row_referencia_interna').removeClass('d-none');
            $('#row_referencia_externa').addClass('d-none');
            $('#btnAgregarItemManual').addClass('d-none');
            
            // Restablecer campos internos
            $('#comprobante_ref_id').val('');
            $('#buscar_comprobante_ref').val('');
            $('#ref_tipo').val('');
            $('#ref_cliente').val('');
            $('#serie_nota').empty().append('<option value="" disabled selected>Esperando documento original...</option>').prop('disabled', true);
            $('#correlativo_nota').val('-');
        }
        // Limpiar items al cambiar la modalidad
        itemsNota = [];
        renderTableNC();
    });

    // Al cambiar tipo de comprobante externo, recargar series habilitadas
    $('#ref_ext_tipo_comprobante').on('change', function() {
        if ($('#ref_externa').is(':checked')) {
            cargarSeriesDisponibles($(this).val());
        }
    });

    // Formatear correlativo de referencia externo a 8 dígitos con ceros
    $('#ref_ext_correlativo').on('blur', function() {
        let val = $(this).val().trim();
        val = val.replace(/\D/g, '');
        if (val !== '') {
            $(this).val(val.padStart(8, '0'));
        }
    });

    // Permitir solo números en el correlativo
    $('#ref_ext_correlativo').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });

    // --- AUTOCOMPLETE CLIENTE EXTERNO ---
    let cliTimer;
    $('#ref_ext_nro_doc_cliente').on('keyup', function() {
        let q = $(this).val().trim();
        let $resList = $('#cliente_ext_results');
        
        clearTimeout(cliTimer);
        if (q.length < 2) {
            $resList.addClass('d-none');
            return;
        }

        cliTimer = setTimeout(function() {
            $.get(appBaseUrl + '/api/ventas/buscar-cliente', { q: q }, function(data) {
                $resList.empty();
                if (data && data.length > 0) {
                    data.forEach(c => {
                        $resList.append(`
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action item-cli-ext"
                                data-id="${c.id}"
                                data-doc="${c.numero_documento}"
                                data-tipo="${c.tipo_documento}"
                                data-nombre="${c.razon_social}">
                                <span class="fw-bold">${c.numero_documento}</span> - ${c.razon_social}
                            </a>
                        `);
                    });
                    $resList.removeClass('d-none');
                } else {
                    $resList.html('<div class="list-group-item text-muted small py-2">No se encontraron clientes localmente</div>').removeClass('d-none');
                }
            });
        }, 300);
    });

    // Selección de cliente autocompletado
    $(document).on('click', '.item-cli-ext', function() {
        let id = $(this).data('id');
        let doc = $(this).data('doc');
        let tipo = $(this).data('tipo');
        let nombre = $(this).data('nombre');

        $('#ref_ext_cliente_id').val(id);
        $('#ref_ext_nro_doc_cliente').val(doc);
        $('#ref_ext_tipo_doc_cliente').val(tipo);
        $('#ref_ext_razon_social_cliente').val(nombre);
        $('#cliente_ext_results').addClass('d-none');
    });

    // Cerrar sugerencias al hacer clic fuera
    $(document).on('click', function(e) {
        if (!$(e.target).closest("#ref_ext_nro_doc_cliente, #cliente_ext_results").length) {
            $("#cliente_ext_results").addClass('d-none');
        }
    });

    // --- CONSULTA API DE SUNAT CLIENTE EXTERNO ---
    $('#btn_consultar_api_cliente_ext').on('click', function() {
        let doc = $('#ref_ext_nro_doc_cliente').val().trim();
        if (doc.length !== 8 && doc.length !== 11) {
            Swal.fire('Atención', 'El número de documento debe tener 8 (DNI) u 11 (RUC) caracteres.', 'warning');
            return;
        }

        let tipo = (doc.length === 11) ? '6' : '1';
        let $btn = $(this);
        let oldHtml = $btn.html();
        
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
        
        $.get(appBaseUrl + '/api/consultar-doc', { tipo: tipo, num: doc, save: 1 }, function(res) {
            $btn.prop('disabled', false).html(oldHtml);
            
            if (res.success) {
                $('#ref_ext_cliente_id').val(res.id);
                $('#ref_ext_tipo_doc_cliente').val(tipo);
                $('#ref_ext_razon_social_cliente').val(res.nombre);
                Swal.fire({
                    toast: true, position: 'top-end', icon: 'success',
                    title: 'Cliente encontrado y registrado localmente.',
                    showConfirmButton: false, timer: 2000
                });
            } else {
                Swal.fire('Atención', res.message, 'info');
            }
        }).fail(function() {
            $btn.prop('disabled', false).html(oldHtml);
            Swal.fire('Error', 'No se pudo conectar con el servicio de consulta.', 'error');
        });
    });

    // --- MODAL DE BÚSQUEDA Y ADICIÓN DE PRODUCTOS ---
    $('#inputSearchProdNC').on('keyup', function() {
        let val = $(this).val().toLowerCase();
        $('#resProdNC a').each(function() {
            let txt = $(this).text().toLowerCase();
            if (txt.indexOf(val) > -1) {
                $(this).removeClass('d-none');
            } else {
                $(this).addClass('d-none');
            }
        });
    });

    // Agregar producto al hacer clic en el listado del modal
    $(document).on('click', '.item-prod-select-nc', function() {
        let id = $(this).data('id');
        let codigo = $(this).data('codigo');
        let descripcion = $(this).data('descripcion');
        let precio = parseFloat($(this).data('precio')) || 0;
        let mainSimbolo = $('#ref_ext_moneda').val() === 'USD' ? '$' : 'S/';

        // Calcular IGV y Base (Asumiendo Afectación 10 Gravado por defecto)
        let valorUnit = precio / 1.18;
        let igv = valorUnit * 0.18;

        itemsNota.push({
            producto_id: id,
            descripcion: codigo + ' - ' + descripcion,
            quantity: 1, // Let's check: does table expect quantity or cantidad?
            // Ah! Line 208 expects item.cantidad and Line 217 expects item.precio_unitario, Line 294 expects item.precio_unitario!
            // Wait, let's verify line 208 and 243: yes! they use cantidad and precio_unitario!
            cantidad: 1,
            precio_unitario: precio,
            precio_referencial: 0,
            valor_unitario: valorUnit,
            igv: igv,
            importe: precio,
            tipo_afectacion: '10',
            simbolo: mainSimbolo
        });

        renderTableNC();
        
        // Cerrar modal
        let modalEl = document.getElementById('modalBuscarProductosNC');
        let modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
        if (modalInstance) {
            modalInstance.hide();
        }

        Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Producto agregado a la nota.',
            showConfirmButton: false, timer: 1500
        });
    });

    // ------------- 1b. MODAL BUSCAR COMPROBANTE ORIGINAL -------------
    let modalRefInstance = null;
    $('#btn_listar_comprobantes').on('click', function () {
        let modalEl = document.getElementById('modalBuscarComprobanteOriginal');
        modalRefInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
        modalRefInstance.show();
        
        // Ejecutar búsqueda por defecto al abrir
        ejecutarBusquedaModal();
    });

    $('#btn_modal_ejecutar_busqueda').on('click', function () {
        ejecutarBusquedaModal();
    });

    $('#modal_buscar_q').on('keypress', function (e) {
        if (e.which === 13) {
            ejecutarBusquedaModal();
        }
    });

    function ejecutarBusquedaModal() {
        let q = $('#modal_buscar_q').val();
        let tipo = $('#modal_buscar_tipo').val();
        let desde = $('#modal_buscar_desde').val();
        let hasta = $('#modal_buscar_hasta').val();
        let $body = $('#modalComprobantesBody');

        $body.html('<tr><td colspan="6" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 mb-0">Buscando documentos...</p></td></tr>');

        let apiUrl = esNC ? "/api/nota-credito/buscar-comprobante" : "/api/nota-debito/buscar-comprobante";
        $.get(appBaseUrl + apiUrl, { q: q, desde: desde, hasta: hasta }, function (data) {
            $body.empty();

            let filteredData = data;
            if (tipo) {
                filteredData = data.filter(item => item.tipo_comprobante === tipo);
            }

            if (filteredData.length > 0) {
                filteredData.forEach(item => {
                    let textTipo = (item.tipo_comprobante == '01') ? 'FACTURA' : 'BOLETA';
                    let nroDoc = item.serie + '-' + String(item.correlativo).padStart(8, '0');
                    let rucCliente = item.cliente ? (item.cliente.numero_documento || '-') : '-';
                    let razonSocial = item.cliente ? (item.cliente.razon_social || 'CLIENTE VARIOS') : 'CLIENTE VARIOS';
                    let totalOriginal = parseFloat(item.total_moneda_original || item.total).toFixed(2);
                    let simboloMoneda = item.simbolo_moneda || 'S/';

                    let badgeNc = '';
                    if (item.notas_credito && item.notas_credito.length > 0) {
                        let ncs = item.notas_credito.map(nc => nc.serie + '-' + String(nc.correlativo).padStart(8, '0')).join(', ');
                        badgeNc = `<span class="badge bg-warning text-dark border" style="font-size: 10px;" title="Notas asociadas: ${ncs}"><i class="material-symbols-outlined fs-12 align-middle">warning</i> Tiene NC (${ncs})</span>`;
                    }

                    $body.append(`
                        <tr>
                            <td>${item.fecha_emision}</td>
                            <td><span class="badge bg-light text-dark border">${textTipo}</span></td>
                            <td>
                                <span class="fw-bold text-primary">${nroDoc}</span>
                                ${badgeNc ? '<div class="mt-1">' + badgeNc + '</div>' : ''}
                            </td>
                            <td>
                                <div class="fw-bold">${razonSocial}</div>
                                <small class="text-muted">Doc: ${rucCliente}</small>
                            </td>
                            <td class="text-end fw-bold">${simboloMoneda} ${totalOriginal}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-success btn-select-ref-modal"
                                    data-id="${item.id}"
                                    data-tipo="${item.tipo_comprobante}"
                                    data-tipotexto="${textTipo}"
                                    data-serie="${item.serie}"
                                    data-correlativo="${item.correlativo}"
                                    data-total="${item.total}"
                                    data-cliente="${razonSocial}">
                                    <i class="material-symbols-outlined fs-16 align-middle">check_circle</i> Seleccionar
                                </button>
                           </td>
                        </tr>
                    `);
                });
            } else {
                $body.html('<tr><td colspan="6" class="text-center text-muted py-4">No se encontraron comprobantes que coincidan con la búsqueda.</td></tr>');
            }
        });
    }

    $(document).on('click', '.btn-select-ref-modal', function () {
        let id = $(this).data('id');
        let tipoComprobante = $(this).data('tipo');
        let nro = $(this).data('serie') + '-' + String($(this).data('correlativo')).padStart(8, '0');
        let tipoTexto = $(this).data('tipotexto');
        let razonSocial = $(this).data('cliente');

        $('#comprobante_ref_id').val(id);
        $('#buscar_comprobante_ref').val(nro);
        $('#ref_tipo').val(tipoTexto + ' ' + nro);
        $('#ref_cliente').val(razonSocial);

        // Limpiar items previos si cambia la referencia
        itemsNota = [];
        renderTableNC();

        cargarSeriesDisponibles(tipoComprobante);

        // Cerrar modal
        if (modalRefInstance) {
            modalRefInstance.hide();
        } else {
            let modalEl = document.getElementById('modalBuscarComprobanteOriginal');
            let inst = bootstrap.Modal.getInstance(modalEl);
            if (inst) inst.hide();
        }

        Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Comprobante seleccionado como referencia.',
            showConfirmButton: false, timer: 1500
        });

        // Cargar ítems automáticamente al seleccionar
        setTimeout(() => {
            $('#btnCargarItems').trigger('click');
        }, 300);
    });

    // Si ya viene un comprobante referenciado (desde la lista de ventas)
    if ($('#comprobante_ref_id').val()) {
        setTimeout(() => {
            $('#btnCargarItems').click();
        }, 500);
    }
});
