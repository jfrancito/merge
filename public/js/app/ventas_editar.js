/**
 * ventas_editar.js - Edición y Reenvío de Comprobantes Rechazados (INVOXA)
 * Carga items y datos del comprobante existente, permite modificar productos,
 * clientes, precios, cuotas y reenviar ante SUNAT/EFACT con la misma serie y correlativo.
 */

let itemsVenta = [];

$(document).ready(function () {

    // ------------- 1. PRECARGAR ITEMS Y CUOTAS INICIALES -------------
    if (typeof initialItems !== 'undefined' && Array.isArray(initialItems) && initialItems.length > 0) {
        itemsVenta = JSON.parse(JSON.stringify(initialItems));
    }

    if (currentMoneda === 'USD') {
        $('.lbl_simbolo').text('$');
    } else {
        $('.lbl_simbolo').text('S/');
    }

    renderTable();

    // Precargar cuotas si es crédito
    if (typeof initialCuotas !== 'undefined' && Array.isArray(initialCuotas) && initialCuotas.length > 0) {
        initialCuotas.forEach(function (c) {
            agregarFilaCuota(c.fecha, c.monto);
        });
        calcularTotalCuotas();
    }

    // ------------- 1.5. CAMBIO TIPO OPERACIÓN -------------
    function toggleGratuitoSwitch() {
        let tipoOp = $('#tipo_operacion').val();
        if (tipoOp === '0201') {
            $('#switch_gratuito_container').hide();
            $('#item_gratuito').prop('checked', false);
            $('#forma_pago').val('Contado').trigger('change').prop('disabled', true);
        } else {
            $('#switch_gratuito_container').show();
            $('#forma_pago').prop('disabled', false);
        }
    }
    toggleGratuitoSwitch();

    $('#tipo_operacion').on('change', function () {
        let tipoOp = $(this).val();
        let esGratuita = (tipoOp === '0201');
        toggleGratuitoSwitch();

        if (esGratuita) {
            if (itemsVenta.length > 0) {
                Swal.fire({
                    title: 'Cambio de Tipo de Operación',
                    text: 'Al cambiar a Transferencia Gratuita, se recalcularán todos los items. Los productos tendrán valor de venta S/ 0.00.',
                    icon: 'info',
                    confirmButtonText: 'Entendido'
                });
                itemsVenta.forEach(item => {
                    item.tipo_afectacion = '21';
                    item.precio_referencial = item.precio_referencial || item.precio_unitario;
                    item.igv = 0;
                    item.importe = 0;
                    item.valor_unitario = 0;
                });
                renderTable();
            }
            $('#badge_gratuito_container').removeClass('d-none');
        } else {
            if (itemsVenta.length > 0) {
                Swal.fire({
                    title: 'Cambio de Tipo de Operación',
                    text: 'Al cambiar a Venta Interna, se recalcularán los items con IGV 18% (Gravado).',
                    icon: 'info',
                    confirmButtonText: 'Entendido'
                });
                itemsVenta.forEach(item => {
                    let precioReal = item.precio_referencial || item.precio_unitario;
                    item.tipo_afectacion = '10';
                    item.precio_unitario = precioReal;
                    item.valor_unitario = precioReal / 1.18;
                    item.igv = (precioReal - (precioReal / 1.18)) * item.cantidad;
                    item.importe = precioReal * item.cantidad;
                    delete item.precio_referencial;
                });
                renderTable();
            }
            $('#badge_gratuito_container').addClass('d-none');
        }
    });

    // ------------- 1.6. MANEJO DE FORMA DE PAGO (CUOTAS) -------------
    $('#forma_pago').on('change', function () {
        let val = $(this).val();
        if (val === 'Credito') {
            $('#seccion_cuotas').removeClass('d-none').addClass('animate__fadeInDown');
            $('.total_venta_cuota').text($('#lbl_total').text());
            if ($('#tablaCuotas tbody tr').length === 0) {
                agregarFilaCuota();
            }
        } else {
            $('#seccion_cuotas').addClass('d-none');
        }
    });

    $('#btnAgregarCuota').on('click', function () {
        agregarFilaCuota();
    });

    function agregarFilaCuota(fecha = null, monto = null) {
        let n = $('#tablaCuotas tbody tr').length + 1;
        let dateStr = fecha;
        if (!dateStr) {
            let today = new Date();
            today.setDate(today.getDate() + (30 * n));
            dateStr = today.toISOString().split('T')[0];
        }

        let montoStr = monto !== null ? parseFloat(monto).toFixed(2) : '0.00';

        let html = `
            <tr class="animate__animated animate__fadeIn">
                <td class="fw-bold text-primary">${n}</td>
                <td><input type="date" class="form-control form-control-sm cuota-fecha" value="${dateStr}"></td>
                <td><input type="number" step="0.01" class="form-control form-control-sm text-end cuota-monto" value="${montoStr}"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger p-0 border-0 btn-eliminar-cuota" style="width:24px;height:24px;">
                        <i class="material-symbols-outlined fs-16">delete</i>
                    </button>
                </td>
            </tr>
        `;
        $('#tablaCuotas tbody').append(html);
        calcularTotalCuotas();
    }

    $(document).on('click', '.btn-eliminar-cuota', function () {
        $(this).closest('tr').remove();
        $('#tablaCuotas tbody tr').each(function (index) {
            $(this).find('td:first').text(index + 1);
        });
        calcularTotalCuotas();
    });

    $(document).on('input', '.cuota-monto', function () {
        calcularTotalCuotas();
    });

    function calcularTotalCuotas() {
        let total = 0;
        $('.cuota-monto').each(function () {
            let val = parseFloat($(this).val()) || 0;
            total += val;
        });
        $('#totalCuotas').text(total.toFixed(2));

        let totalVenta = parseFloat($('#lbl_total').text()) || 0;
        $('.total_venta_cuota').text(totalVenta.toFixed(2));

        if (Math.abs(total - totalVenta) > 0.01) {
            $('#alertCuotas').removeClass('d-none');
            $('#totalCuotas').addClass('text-danger').removeClass('text-primary');
        } else {
            $('#alertCuotas').addClass('d-none');
            $('#totalCuotas').removeClass('text-danger').addClass('text-primary');
        }
    }

    // ------------- 2. CONSULTA API RUC/DNI -------------
    $('#btn_consultar_api').on('click', function () {
        let doc = $('#buscar_cliente').val().trim();
        if (doc.length !== 8 && doc.length !== 11) {
            Swal.fire('Atención', 'El número de documento debe tener 8 (DNI) u 11 (RUC) caracteres.', 'warning');
            return;
        }

        let tipo = (doc.length === 11) ? '6' : '1';
        let $btn = $(this);
        let oldHtml = $btn.html();

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.get(window.baseUrl + '/api/consultar-doc', { tipo: tipo, num: doc, save: 1 }, function (res) {
            $btn.prop('disabled', false).html(oldHtml);

            if (res.success) {
                $('#cliente_nombre').val(res.nombre);
                $('#cliente_num_doc').val(doc);
                $('#cliente_tipo_doc').val(tipo);
                $('#cliente_id').val(res.id);

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
                Toast.fire({ icon: 'success', title: 'Datos de cliente obtenidos' });
            } else {
                Swal.fire('Atención', res.message, 'info');
            }
        }).fail(function () {
            $btn.prop('disabled', false).html(oldHtml);
            Swal.fire('Error', 'No se pudo conectar con el servicio de consulta.', 'error');
        });
    });

    // ------------- 2.1 AUTOCOMPLETE CLIENTE -------------
    let clienteTimer;
    $('#buscar_cliente').on('keyup', function () {
        let q = $(this).val();
        let $resList = $('#cliente_results');

        clearTimeout(clienteTimer);

        if (q.length < 3) {
            $resList.addClass('d-none');
            return;
        }

        clienteTimer = setTimeout(function () {
            $.get(appBaseUrl + "/api/ventas/buscar-cliente", { q: q }, function (data) {
                $resList.empty();
                if (data.length > 0) {
                    data.forEach(item => {
                        $resList.append(`
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action item-cliente"
                               data-id="${item.id}" data-num="${item.numero_documento}" data-tipo="${item.tipo_documento}" data-nom="${item.razon_social}">
                               <div class="fw-bold">${item.numero_documento}</div>
                               <small class="text-muted">${item.razon_social}</small>
                            </a>
                        `);
                    });
                    $resList.removeClass('d-none');
                } else {
                    $resList.html('<div class="list-group-item text-muted small py-2">No se encontraron resultados</div>').removeClass('d-none');
                }
            });
        }, 350);
    });

    $(document).on('click', '.item-cliente', function () {
        $('#cliente_id').val($(this).data('id'));
        $('#cliente_num_doc').val($(this).data('num'));
        $('#cliente_tipo_doc').val($(this).data('tipo'));
        $('#cliente_nombre').val($(this).data('nom'));
        $('#buscar_cliente').val($(this).data('num'));
        $('#cliente_results').addClass('d-none');
    });

    // ------------- 3. AUTOCOMPLETE PRODUCTO -------------
    let productoTimer;
    $('#buscar_producto').on('keyup', function () {
        let q = $(this).val();
        let $resList = $('#producto_results');

        clearTimeout(productoTimer);

        if (q.length < 2) {
            $resList.addClass('d-none');
            return;
        }

        productoTimer = setTimeout(function () {
            $.get(appBaseUrl + "/api/ventas/buscar-producto", { q: q }, function (data) {
                $resList.empty();
                if (data.items && data.items.length > 0) {
                    let sim = currentMoneda === 'USD' ? '$' : 'S/';
                    let esGratuita = $('#tipo_operacion').val() === '0201';
                    data.items.forEach(prod => {
                        let precioConvertido = currentMoneda === 'USD' ? (parseFloat(prod.precio_unitario) / valTC) : parseFloat(prod.precio_unitario);
                        let labelPrecio = esGratuita
                            ? `<span class="badge bg-success rounded-pill">GRATUITO (Ref: ${sim} ${precioConvertido.toFixed(2)})</span>`
                            : `<span class="badge bg-primary rounded-pill">${sim} ${precioConvertido.toFixed(2)}</span>`;
                        $resList.append(`
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action item-producto"
                               data-id="${prod.id}" data-codigo="${prod.codigo || ''}" data-codsunat="${prod.cod_prod_sunat || ''}" data-desc="${prod.descripcion}" data-precio="${precioConvertido.toFixed(2)}" data-afecta="${prod.tipo_afectacion}" data-unidad="${prod.unidad_medida || 'NIU'}">
                               <div class="fw-bold">${prod.descripcion}</div>
                               <div class="d-flex justify-content-between">
                                 <small class="text-muted">Cód: ${prod.codigo || 'S/C'}</small>
                                 ${labelPrecio}
                                </div>
                            </a>
                        `);
                    });
                    $resList.removeClass('d-none');
                } else {
                    $resList.html('<div class="list-group-item text-muted small py-2">Sin resultados</div>').removeClass('d-none');
                }
            });
        }, 350);
    });

    // ------------- 3.5. CAMBIO DE MONEDA -------------
    $('#moneda').on('change', function () {
        let newMoneda = $(this).val();
        if (newMoneda === currentMoneda) return;

        if (newMoneda === 'USD') {
            itemsVenta.forEach(item => {
                item.precio_unitario = item.precio_unitario / valTC;
                item.valor_unitario = item.valor_unitario / valTC;
                item.igv = item.igv / valTC;
                item.importe = item.importe / valTC;
                if (item.precio_referencial) {
                    item.precio_referencial = item.precio_referencial / valTC;
                }
            });
            $('.lbl_simbolo').text('$');
        } else {
            itemsVenta.forEach(item => {
                item.precio_unitario = item.precio_unitario * valTC;
                item.valor_unitario = item.valor_unitario * valTC;
                item.igv = item.igv * valTC;
                item.importe = item.importe * valTC;
                if (item.precio_referencial) {
                    item.precio_referencial = item.precio_referencial * valTC;
                }
            });
            $('.lbl_simbolo').text('S/');
        }
        currentMoneda = newMoneda;
        renderTable();
        $('#buscar_producto').val('');
        $('#prod_precio').val('');
    });

    $(document).on('click', '.item-producto', function () {
        $('#prod_id').val($(this).data('id'));
        $('#prod_codigo').val($(this).data('codigo'));
        $('#prod_cod_sunat').val($(this).data('codsunat'));
        $('#buscar_producto').val($(this).data('desc'));
        $('#prod_desc').val($(this).data('desc'));
        $('#prod_precio').val($(this).data('precio'));
        $('#prod_afectacion').val($(this).data('afecta'));
        $('#prod_unidad').val($(this).data('unidad'));
        $('#prod_cant').val(1).select();
        $('#producto_results').addClass('d-none');
    });

    // ------------- 4. AGREGAR ITEM A TABLA -------------
    $('#btnAgregarProd').on('click', agregarProducto);
    $('#prod_cant, #prod_precio').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            agregarProducto();
        }
    });

    function agregarProducto() {
        let id = $('#prod_id').val();
        let desc = $('#prod_desc').val();
        let cant = parseFloat($('#prod_cant').val());
        let precioUnit = parseFloat($('#prod_precio').val());
        let afecta = $('#prod_afectacion').val() || '10';
        let unidad = $('#prod_unidad').val() || 'NIU';
        let esGratuitaGlobal = $('#tipo_operacion').val() === '0201';
        let esGratuitaItem = $('#item_gratuito').is(':checked');

        if (!id || cant <= 0 || precioUnit < 0 || isNaN(cant) || isNaN(precioUnit)) {
            Swal.fire('Error', 'Seleccione un producto válido y defina cantidad/precio.', 'error');
            return;
        }

        let valorUnitario = precioUnit;
        let igvItem = 0;
        let importe = cant * precioUnit;
        let precioReferencial = null;

        if (esGratuitaGlobal || esGratuitaItem) {
            precioReferencial = precioUnit;
            valorUnitario = 0;
            igvItem = 0;
            importe = 0;
            if (afecta === '10') afecta = '11';
            else if (afecta === '20') afecta = '21';
            else afecta = '31';
        } else if (afecta === '10') {
            valorUnitario = precioUnit / 1.18;
            let subtotal = cant * valorUnitario;
            igvItem = importe - subtotal;
        }

        let item = {
            producto_id: id,
            codigo: $('#prod_codigo').val() || '',
            cod_prod_sunat: $('#prod_cod_sunat').val() || '',
            descripcion: desc,
            cantidad: cant,
            precio_unitario: precioUnit,
            valor_unitario: valorUnitario,
            igv: igvItem,
            importe: importe,
            tipo_afectacion: afecta,
            unidad_medida: unidad
        };

        if (precioReferencial !== null) {
            item.precio_referencial = precioReferencial;
        }

        itemsVenta.push(item);
        limpiarProdInputs();
        renderTable();
        $('#buscar_producto').focus();
    }

    function limpiarProdInputs() {
        $('#prod_id, #prod_desc, #prod_afectacion, #prod_unidad, #buscar_producto, #prod_precio').val('');
        $('#prod_cant').val('1');
        $('#item_gratuito').prop('checked', false);
    }

    function renderTable() {
        let html = '';
        let totalGravadas = 0;
        let totalExoneradas = 0;
        let totalInafectas = 0;
        let totalGratuitas = 0;
        let totalIGV = 0;
        let totalGeneral = 0;
        let esGratuita = $('#tipo_operacion').val() === '0201';

        if (itemsVenta.length === 0) {
            $('#tablaDetalles tbody').html('<tr id="rowEmpty"><td colspan="6" class="text-center text-muted py-4"><i class="material-symbols-outlined fs-40 d-block mb-2 text-secondary">inventory_2</i>No hay productos agregados</td></tr>');
        } else {
            let sim = currentMoneda === 'USD' ? '$' : 'S/';
            itemsVenta.forEach((item, index) => {
                let esItemGratuito = esGratuita || ['11','12','13','14','15','16','17','21','31','32','33','34','35','36'].includes(item.tipo_afectacion);
                let valorMostrar = esItemGratuito ? (item.precio_referencial || item.precio_unitario) : item.valor_unitario;
                let badgeGratis = esItemGratuito ? '<span class="badge bg-success-subtle text-success border border-success border-opacity-25 ms-2" style="font-size: 10px;">BONIFICACIÓN</span>' : '';

                html += `<tr class="animate__animated animate__fadeIn">
                    <td class="text-center fw-bold">${item.cantidad}</td>
                    <td>${item.descripcion}${badgeGratis}</td>
                    <td class="text-end text-muted">${esItemGratuito ? '<del class="text-muted">' : ''}${sim} ${valorMostrar.toFixed(2)}${esItemGratuito ? '</del>' : ''}</td>
                    <td class="text-end text-muted">${sim} ${item.igv.toFixed(2)}</td>
                    <td class="text-end fw-bold ${esItemGratuito ? 'text-success' : 'text-dark'}">${esItemGratuito ? sim + ' 0.00' : sim + ' ' + item.importe.toFixed(2)}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-sm btn-outline-primary p-1 line-height-1 edit-item me-1" data-index="${index}" title="Editar">
                                <i class="material-symbols-outlined fs-16">edit</i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger p-1 line-height-1 rmv-item" data-index="${index}" title="Eliminar">
                                <i class="material-symbols-outlined fs-16">delete</i>
                            </button>
                        </div>
                    </td>
                </tr>`;

                if (esItemGratuito) {
                    totalGratuitas += (item.precio_referencial || item.precio_unitario) * item.cantidad;
                } else if (item.tipo_afectacion === '10') {
                    totalGravadas += (item.valor_unitario * item.cantidad);
                    totalIGV += item.igv;
                } else if (item.tipo_afectacion === '20') {
                    totalExoneradas += item.importe;
                } else if (item.tipo_afectacion === '30') {
                    totalInafectas += item.importe;
                }

                totalGeneral += item.importe;
            });
            $('#tablaDetalles tbody').html(html);
        }

        $('#lbl_gravadas').text(totalGravadas.toFixed(2));
        $('#lbl_exoneradas').text(totalExoneradas.toFixed(2));
        $('#lbl_inafectas').text(totalInafectas.toFixed(2));
        $('#lbl_gratuitas').text(totalGratuitas.toFixed(2));
        $('#lbl_igv').text(totalIGV.toFixed(2));
        $('#lbl_total').text(totalGeneral.toFixed(2));

        calcularTotalCuotas();
    }

    $(document).on('click', '.rmv-item', function () {
        let i = $(this).data('index');
        itemsVenta.splice(i, 1);
        renderTable();
    });

    $(document).on('click', '.edit-item', function () {
        let i = $(this).data('index');
        let item = itemsVenta[i];

        $('#prod_id').val(item.producto_id);
        $('#prod_desc').val(item.descripcion);
        $('#buscar_producto').val(item.descripcion);
        $('#prod_cant').val(item.cantidad);
        let precioEditar = item.precio_referencial || item.precio_unitario;
        $('#prod_precio').val(precioEditar.toFixed(2));
        $('#prod_afectacion').val(item.tipo_afectacion);
        $('#prod_unidad').val(item.unidad_medida || 'NIU');

        let esItemGratuito = ['11','12','13','14','15','16','17','21','31','32','33','34','35','36'].includes(item.tipo_afectacion);
        $('#item_gratuito').prop('checked', esItemGratuito);

        itemsVenta.splice(i, 1);
        renderTable();
        $('#prod_cant').focus().select();
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest("#buscar_cliente, #cliente_results").length) {
            $("#cliente_results").addClass('d-none');
        }
        if (!$(e.target).closest("#buscar_producto, #producto_results").length) {
            $("#producto_results").addClass('d-none');
        }
    });

    function obtenerCuotas() {
        let c = [];
        if ($('#forma_pago').val() !== 'Credito') return c;
        $('#tablaCuotas tbody tr').each(function () {
            c.push({
                fecha: $(this).find('.cuota-fecha').val(),
                monto: $(this).find('.cuota-monto').val()
            });
        });
        return c;
    }

    function validarFormulario() {
        let clienteId = $('#cliente_id').val();
        if (!clienteId) {
            Swal.fire('Atención', 'Debe seleccionar un cliente para el comprobante.', 'warning');
            return false;
        }
        if (itemsVenta.length === 0) {
            Swal.fire('Atención', 'Agregue al menos un producto o servicio al comprobante.', 'warning');
            return false;
        }
        if ($('#forma_pago').val() === 'Credito') {
            let totalCuotasVal = 0;
            let countCuotas = 0;
            $('.cuota-monto').each(function () {
                totalCuotasVal += parseFloat($(this).val()) || 0;
                countCuotas++;
            });
            let totalVentaVal = parseFloat($('#lbl_total').text()) || 0;
            if (countCuotas === 0) {
                Swal.fire('Atención', 'Debe agregar al menos una cuota para ventas al crédito.', 'warning');
                return false;
            }
            if (Math.abs(totalCuotasVal - totalVentaVal) > 0.01) {
                Swal.fire('Atención', 'El total de las cuotas (' + totalCuotasVal.toFixed(2) + ') no coincide con el total del comprobante (' + totalVentaVal.toFixed(2) + ').', 'warning');
                return false;
            }
        }
        return true;
    }

    function construirPayload(enviarSunat) {
        let tipoOperacion = $('#tipo_operacion').val();
        return {
            venta_id: $('#venta_id').val(),
            tipo_comprobante: $('#tipo_comprobante').val(),
            serie: $('#serie').val(),
            correlativo: $('#correlativo').val(),
            fecha_emision: $('#fecha_emision').val(),
            cliente_id: $('#cliente_id').val(),
            moneda: currentMoneda,
            tipo_cambio: valTC,
            tipo_operacion: tipoOperacion,
            forma_pago: $('#forma_pago').val(),
            cuotas: obtenerCuotas(),
            items: itemsVenta,
            total_gravadas: $('#lbl_gravadas').text(),
            total_exoneradas: $('#lbl_exoneradas').text(),
            total_inafectas: $('#lbl_inafectas').text(),
            total_gratuitas: $('#lbl_gratuitas').text(),
            total_igv: $('#lbl_igv').text(),
            total_general: $('#lbl_total').text(),
            observaciones: $('#observaciones').val(),
            enviar_sunat: enviarSunat
        };
    }

    // ------------- 5. GUARDAR CAMBIOS (SOLO ACTUALIZAR SIN ENVIAR) -------------
    $('#btnGuardarSinEnviar').on('click', function () {
        if (!validarFormulario()) return;

        Swal.fire({
            title: '¿Guardar Cambios?',
            text: 'Se actualizarán los datos del comprobante sin enviarlo a SUNAT todavía.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, Guardar',
            cancelButtonText: 'Cancelar'
        }).then((res) => {
            if (!res.isConfirmed) return;

            Swal.fire({
                title: 'Guardando...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            let payload = construirPayload(false);

            $.ajax({
                url: appBaseUrl + '/editar-venta/actualizar',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(payload),
                contentType: 'application/json',
                success: function (r) {
                    if (r.success) {
                        Swal.fire({
                            title: '¡Guardado!',
                            text: r.message,
                            icon: 'success',
                            confirmButtonText: 'Ir al Listado'
                        }).then(() => {
                            window.location.href = appBaseUrl + '/gestion-de-ventas/' + idopcionVolver;
                        });
                    } else {
                        Swal.fire('Error', r.message, 'error');
                    }
                },
                error: function (err) {
                    let msg = (err.responseJSON && err.responseJSON.message) ? err.responseJSON.message : 'Error al guardar el comprobante.';
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    });

    // ------------- 6. GUARDAR Y EMITIR A SUNAT / EFACT -------------
    $('#btnActualizarYEmitir').on('click', function () {
        if (!validarFormulario()) return;

        let serie = $('#serie').val();
        let correlativo = $('#correlativo').val();
        let sim = currentMoneda === 'USD' ? '$' : 'S/';
        let total = $('#lbl_total').text();

        Swal.fire({
            title: '¿Emitir a SUNAT / EFACT?',
            html: `Se actualizará y emitirá el comprobante <strong>${serie}-${correlativo}</strong> por <strong>${sim} ${total}</strong> ante SUNAT/EFACT.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, Guardar y Emitir',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#0d6efd'
        }).then((res) => {
            if (!res.isConfirmed) return;

            Swal.fire({
                title: 'Firmando y Enviando...',
                html: 'Firmando XML y enviando a SUNAT / EFACT. Por favor espere.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            let payload = construirPayload(true);

            $.ajax({
                url: appBaseUrl + '/editar-venta/actualizar',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(payload),
                contentType: 'application/json',
                success: function (r) {
                    if (r.success) {
                        let downloadButtons = `
                            <div class="mt-3 p-3 rounded-3" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                <p class="mb-2 text-secondary small fw-bold text-uppercase text-center">Gestionar Comprobante:</p>
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <a href="${appBaseUrl}/venta/imprimir/${r.id_cifrado}/a4" target="_blank" class="btn btn-warning d-flex align-items-center gap-2 shadow-sm">
                                        <i class="material-symbols-outlined fs-20">description</i> A4
                                    </a>
                                    <a href="${appBaseUrl}/venta/imprimir/${r.id_cifrado}/ticket" target="_blank" class="btn btn-dark d-flex align-items-center gap-2 shadow-sm">
                                        <i class="material-symbols-outlined fs-20">receipt</i> TICKET
                                    </a>
                                    ${r.xml_url ? `
                                    <a href="${r.xml_url}" target="_blank" class="btn btn-outline-primary d-flex align-items-center gap-2 shadow-sm">
                                        <i class="material-symbols-outlined fs-20">code</i> XML
                                    </a>` : ''}
                                    ${r.cdr_url ? `
                                    <a href="${r.cdr_url}" target="_blank" class="btn btn-success d-flex align-items-center gap-2 shadow-sm">
                                        <i class="material-symbols-outlined fs-20">task_alt</i> CDR
                                    </a>` : ''}
                                    ${r.wa_url ? `
                                    <a href="${r.wa_url}" target="_blank" class="btn btn-success d-flex align-items-center gap-2 shadow-sm border-0" style="background-color: #25D366;">
                                        <i class="material-symbols-outlined fs-20">chat</i> WHATSAPP
                                    </a>` : ''}
                                </div>
                            </div>
                        `;

                        Swal.fire({
                            title: '¡Comprobante Aceptado!',
                            html: `<div class="text-start">${r.message}</div> ${downloadButtons}`,
                            icon: 'success',
                            confirmButtonText: 'Volver a Ventas',
                            width: '500px'
                        }).then(() => {
                            window.location.href = appBaseUrl + '/gestion-de-ventas/' + idopcionVolver;
                        });
                    } else {
                        Swal.fire('Rechazado / Error', r.message, 'error');
                    }
                },
                error: function (err) {
                    let msg = (err.responseJSON && err.responseJSON.message) ? err.responseJSON.message : 'Error en la comunicación con el servidor.';
                    Swal.fire('Error del Servidor', msg, 'error');
                }
            });
        });
    });

    // ------------- 7. VISTA PREVIA -------------
    $('#btnVistaPrevia').on('click', function () {
        if (!validarFormulario()) return;

        let payload = construirPayload(false);

        let form = $('<form>', {
            action: appBaseUrl + '/venta/vista-previa',
            method: 'POST',
            target: '_blank'
        });

        form.append($('<input>', {
            type: 'hidden',
            name: '_token',
            value: $('meta[name="csrf-token"]').attr('content')
        }));

        for (let key in payload) {
            if (typeof payload[key] === 'object') {
                form.append($('<input>', {
                    type: 'hidden',
                    name: key,
                    value: JSON.stringify(payload[key])
                }));
            } else {
                form.append($('<input>', {
                    type: 'hidden',
                    name: key,
                    value: payload[key]
                }));
            }
        }

        $('body').append(form);
        form.submit();
        form.remove();
    });

});
