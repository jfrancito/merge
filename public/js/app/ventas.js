/**
 * ventas.js - Módulo de Emisión de Comprobantes Electrónicos (INVOXA)
 * Maneja la lógica del POS: autocomplete de clientes/productos,
 * cálculos de IGV, Transferencia Gratuita y envío AJAX a SUNAT via Greenter.
 */

let itemsVenta = [];

$(document).ready(function () {

    // ------------- 1. CARGAR SERIE (Factura / Boleta) -------------
    let currentSeriesData = []; // Store correlativos mapping

    $('#tipo_comprobante').on('change', function () {
        let tipo = $(this).val();
        let $serieSelect = $('#serie');
        let $correlativoInput = $('#correlativo');

        $serieSelect.empty().append('<option value="" disabled selected>Cargando...</option>').prop('disabled', true);
        $correlativoInput.val('Cargando...');
        currentSeriesData = [];

        console.log("Cargando series para tipo:", tipo);
        $.get(appBaseUrl + "/api/ventas/obtener-serie", { tipo_comprobante: tipo }, function (res) {
            console.log("Respuesta series:", res);
            $serieSelect.empty();
            if (res.success && res.series && res.series.length > 0) {
                currentSeriesData = res.series;
                res.series.forEach((s, idx) => {
                    let selected = idx === 0 ? 'selected' : '';
                    $serieSelect.append(`<option value="${s.serie}" ${selected}>${s.serie}</option>`);
                });
                $serieSelect.prop('disabled', false);
                console.log("Select habilitado");
                // Trigger change to set correlativo
                $serieSelect.trigger('change');
            } else {
                console.error("No se encontraron series o falló la respuesta");
                $serieSelect.append('<option value="" disabled selected>NO CONFIGURADO</option>');
                $correlativoInput.val('-');
                Swal.fire('Atención', 'No hay una serie Activa configurada para este tipo de comprobante en su Empresa.', 'warning');
            }
        }).fail(function(err) {
            console.error("Error en la petición AJAX:", err);
            Swal.fire('Error', 'No se pudo conectar con el servidor para obtener las series.', 'error');
        });
    });

    $('#serie').on('change', function () {
        let val = $(this).val();
        let serieObj = currentSeriesData.find(s => s.serie === val);
        if (serieObj) {
            $('#correlativo').val(serieObj.correlativo);
        }
    });

    // ------------- 1.5. CAMBIO TIPO OPERACIÓN (Venta Interna / Transferencia Gratuita) -------------
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
            // Limpiar items existentes si los hay, ya que cambian las reglas de cálculo
            if (itemsVenta.length > 0) {
                Swal.fire({
                    title: 'Cambio de Tipo de Operación',
                    text: 'Al cambiar a Transferencia Gratuita, se recalcularán todos los items. Los productos tendrán valor de venta S/ 0.00.',
                    icon: 'info',
                    confirmButtonText: 'Entendido'
                });
                // Recalcular todos los items como gratuitos
                itemsVenta.forEach(item => {
                    item.tipo_afectacion = '21'; // Exonerado - Transferencia Gratuita
                    item.precio_referencial = item.precio_unitario; // Guardar el precio como referencial
                    item.igv = 0;
                    item.importe = 0;
                    item.valor_unitario = 0;
                });
                renderTable();
            }
            // Mostrar indicador visual
            $('#badge_gratuito_container').removeClass('d-none');
        } else {
            // Volver a Venta Interna
            if (itemsVenta.length > 0) {
                Swal.fire({
                    title: 'Cambio de Tipo de Operación',
                    text: 'Al cambiar a Venta Interna, se recalcularán todos los items con IGV 18% (Gravado).',
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
            // Ocultar indicador visual
            $('#badge_gratuito_container').addClass('d-none');
        }
    });

    // ------------- 1.6. MANEJO DE FORMA DE PAGO (CUOTAS) -------------
    $('#forma_pago').on('change', function () {
        let val = $(this).val();
        if (val === 'Credito') {
            $('#seccion_cuotas').removeClass('d-none').addClass('animate__fadeInDown');
            $('.total_venta_cuota').text($('#lbl_total').text());
            // Si no hay cuotas, agregar la primera automáticamente
            if ($('#tablaCuotas tbody tr').length === 0) {
                agregarFilaCuota();
            }
        } else {
            $('#seccion_cuotas').addClass('d-none');
        }
    });

    $('#btnAgregarCuota').on('click', function() {
        agregarFilaCuota();
    });

    function agregarFilaCuota() {
        let n = $('#tablaCuotas tbody tr').length + 1;
        let today = new Date();
        today.setDate(today.getDate() + (30 * n)); // Sugerir a 30 días
        let dateStr = today.toISOString().split('T')[0];
        
        let html = `
            <tr class="animate__animated animate__fadeIn">
                <td class="fw-bold text-primary">${n}</td>
                <td><input type="date" class="form-control form-control-sm cuota-fecha" value="${dateStr}"></td>
                <td><input type="number" step="0.01" class="form-control form-control-sm cuota-monto text-end fw-bold" value="0.00"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-link text-danger p-0 rmv-cuota"><i class="material-symbols-outlined fs-18">delete</i></button>
                </td>
            </tr>
        `;
        $('#tablaCuotas tbody').append(html);
        recalcularCuotas();
    }

    $(document).on('click', '.rmv-cuota', function() {
        $(this).closest('tr').remove();
        // Re-enumerar
        $('#tablaCuotas tbody tr').each(function(i) {
            $(this).find('td:first').text(i + 1);
        });
        recalcularCuotas();
    });

    $(document).on('keyup change', '.cuota-monto', recalcularCuotas);

    function recalcularCuotas() {
        let total = 0;
        $('.cuota-monto').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('#totalCuotas').text(total.toFixed(2));
        
        let totalVenta = parseFloat($('#lbl_total').text());
        if (Math.abs(total - totalVenta) > 0.01) {
            $('#alertCuotas').removeClass('d-none');
            $('#totalCuotas').addClass('text-danger').removeClass('text-primary');
        } else {
            $('#alertCuotas').addClass('d-none');
            $('#totalCuotas').removeClass('text-danger').addClass('text-primary');
        }
    }

    // ------------- 2.1. CONSULTA API RUC/DNI (NUEVO) -------------
    $('#btn_consultar_api').on('click', function() {
        let doc = $('#buscar_cliente').val().trim();
        if (doc.length !== 8 && doc.length !== 11) {
            Swal.fire('Atención', 'El número de documento debe tener 8 (DNI) u 11 (RUC) caracteres.', 'warning');
            return;
        }

        let tipo = (doc.length === 11) ? '6' : '1';
        let $btn = $(this);
        let oldHtml = $btn.html();
        
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
        
        console.log("Consultando doc:", doc, "en:", window.baseUrl + '/api/consultar-doc');

        $.get(window.baseUrl + '/api/consultar-doc', { tipo: tipo, num: doc, save: 1 }, function(res) {
            $btn.prop('disabled', false).html(oldHtml);
            
            if (res.success) {
                $('#cliente_nombre').val(res.nombre);
                $('#cliente_num_doc').val(doc);
                $('#cliente_tipo_doc').val(tipo);
                $('#cliente_id').val(res.id); // VINCULAR ID REAL/NUEVO

                console.log("ID de cliente vinculado:", res.id);

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
                Toast.fire({ icon: 'success', title: 'Datos obtenidos correctamente' });
            } else {
                Swal.fire('Atención', res.message, 'info');
            }
        }).fail(function() {
            $btn.prop('disabled', false).html(oldHtml);
            Swal.fire('Error', 'No se pudo conectar con el servicio de consulta.', 'error');
        });
    });

    // ------------- 2. AUTOCOMPLETE CLIENTE -------------
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
        }, 350); // Debounce 350ms
    });

    // Elegir cliente
    $(document).on('click', '.item-cliente', function () {
        $('#cliente_id').val($(this).data('id'));
        $('#cliente_num_doc').val($(this).data('num'));
        $('#cliente_tipo_doc').val($(this).data('tipo'));
        $('#cliente_nombre').val($(this).data('nom'));
        $('#buscar_cliente').val($(this).data('num'));
        $('#cliente_results').addClass('d-none');

        // Auto select tipo comprobante: si es RUC -> Factura, DNI -> Boleta
        let targetTipo = $(this).data('tipo') == '6' ? '01' : '03';
        let currentTipo = $('#tipo_comprobante').val();

        if (currentTipo !== targetTipo) {
            $('#tipo_comprobante').val(targetTipo).trigger('change');
        }
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
    // También al presionar Enter en el campo cantidad
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
        let precioUnit = parseFloat($('#prod_precio').val()); // Precio CON IGV
        let afecta = $('#prod_afectacion').val() || '10';
        let unidad = $('#prod_unidad').val() || 'NIU';
        let esGratuitaGlobal = $('#tipo_operacion').val() === '0201';
        let esGratuitaItem = $('#item_gratuito').is(':checked');

        if (!id || cant <= 0 || precioUnit < 0 || isNaN(cant) || isNaN(precioUnit)) {
            Swal.fire('Error', 'Seleccione un producto válido y defina cantidad/precio.', 'error');
            return;
        }

        // Calculos base
        let valorUnitario = precioUnit;
        let igvItem = 0;
        let importe = cant * precioUnit;
        let precioReferencial = null;

        if (esGratuitaGlobal || esGratuitaItem) {
            // Transferencia Gratuita: valor_unitario = 0, importe = 0, igv = 0
            // El precio ingresado se guarda como precio referencial para SUNAT
            precioReferencial = precioUnit;
            valorUnitario = 0;
            igvItem = 0;
            importe = 0;
            // Si el producto era Gravado (10), su versión gratuita es 11. 
            // Si era Exonerado (20), su versión gratuita es 21.
            if (afecta === '10') afecta = '11'; 
            else if (afecta === '20') afecta = '21';
            else afecta = '31'; // Inafecta
        } else if (afecta === '10') { // Gravado
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

        // Check if product already exists in details and is not a bonificación
        let newFree = esGratuitaGlobal || esGratuitaItem;
        let merged = false;

        if (!newFree) {
            let existingIndex = itemsVenta.findIndex(it => {
                let isItemGratuito = esGratuitaGlobal || ['11','12','13','14','15','16','17','21','31','32','33','34','35','36'].includes(it.tipo_afectacion);
                return it.producto_id === id && !isItemGratuito;
            });

            if (existingIndex !== -1) {
                let existingItem = itemsVenta[existingIndex];
                let totalCant = existingItem.cantidad + cant;
                let newImporte = totalCant * precioUnit;
                let newValorUnitario = precioUnit;
                let newIgvItem = 0;

                if (afecta === '10') { // Gravado
                    newValorUnitario = precioUnit / 1.18;
                    let subtotal = totalCant * newValorUnitario;
                    newIgvItem = newImporte - subtotal;
                }

                existingItem.cantidad = totalCant;
                existingItem.precio_unitario = precioUnit;
                existingItem.valor_unitario = newValorUnitario;
                existingItem.igv = newIgvItem;
                existingItem.importe = newImporte;
                existingItem.tipo_afectacion = afecta;
                existingItem.unidad_medida = unidad;

                merged = true;
            }
        }

        if (!merged) {
            itemsVenta.push(item);
        }

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
                let importeMostrar = esItemGratuito ? (item.precio_referencial || item.precio_unitario) * item.cantidad : item.importe;
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

        // Actualizar Labels del Resumen
        $('#lbl_gravadas').text(totalGravadas.toFixed(2));
        $('#lbl_exoneradas').text(totalExoneradas.toFixed(2));
        $('#lbl_inafectas').text(totalInafectas.toFixed(2));
        $('#lbl_gratuitas').text(totalGratuitas.toFixed(2));
        $('#lbl_igv').text(totalIGV.toFixed(2));
        $('#lbl_total').text(totalGeneral.toFixed(2));

        // Animar el total
        $('#lbl_total').closest('li').addClass('animate__animated animate__pulse');
        setTimeout(() => {
            $('#lbl_total').closest('li').removeClass('animate__animated animate__pulse');
        }, 600);
    }

    $(document).on('click', '.rmv-item', function () {
        let i = $(this).data('index');
        itemsVenta.splice(i, 1);
        renderTable();
    });

    $(document).on('click', '.edit-item', function () {
        let i = $(this).data('index');
        let item = itemsVenta[i];

        // Cargar datos en los inputs superiores
        $('#prod_id').val(item.producto_id);
        $('#prod_desc').val(item.descripcion);
        $('#buscar_producto').val(item.descripcion);
        $('#prod_cant').val(item.cantidad);
        // Para items gratuitos, mostrar el precio referencial en el input
        let precioEditar = item.precio_referencial || item.precio_unitario;
        $('#prod_precio').val(precioEditar.toFixed(2));
        $('#prod_afectacion').val(item.tipo_afectacion);
        $('#prod_unidad').val(item.unidad_medida || 'NIU');

        let esItemGratuito = ['11','12','13','14','15','16','17','21','31','32','33','34','35','36'].includes(item.tipo_afectacion);
        $('#item_gratuito').prop('checked', esItemGratuito);

        // Remover del listado (se volverá a agregar editado)
        itemsVenta.splice(i, 1);
        renderTable();

        // Posicionar el foco para edición rápida
        $('#prod_cant').focus().select();

        // Notificación opcional
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'info',
            title: 'Producto listo para editar'
        });
    });

    // Ocultar dropdowns al hacer click afuera
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
        $('#tablaCuotas tbody tr').each(function() {
            c.push({
                fecha: $(this).find('.cuota-fecha').val(),
                monto: $(this).find('.cuota-monto').val()
            });
        });
        return c;
    }

    // ------------- 5. EMITIR A SUNAT (AJAX) -------------
    $('#btnEmitirSUNAT').on('click', function () {
        let tipo = $('#tipo_comprobante').val();
        let serie = $('#serie').val();
        let clienteId = $('#cliente_id').val();
        let tipoOperacion = $('#tipo_operacion').val();
        let esGratuita = (tipoOperacion === '0201');

        if (!tipo || !serie || serie.includes('NO CONF') || serie === '-') {
            Swal.fire('Atención', 'Debe seleccionar un tipo de comprobante y tener una serie válida configurada.', 'warning');
            return;
        }

        if (typeof validarFechaEmision === 'function' && !validarFechaEmision()) {
            Swal.fire('Atención', 'La fecha de emisión no es válida para la serie seleccionada. Debe tener máximo 3 días de antigüedad y no ser anterior al último comprobante emitido en esta serie.', 'warning');
            return;
        }
        if (!clienteId) {
            Swal.fire('Atención', 'Debe seleccionar un cliente para el comprobante.', 'warning');
            return;
        }
        if (itemsVenta.length === 0) {
            Swal.fire('Atención', 'Agregue al menos un producto o servicio a la venta.', 'warning');
            return;
        }

        // Validación de Cuotas (Crédito)
        if ($('#forma_pago').val() === 'Credito') {
            let totalCuotasVal = 0;
            let countCuotas = 0;
            $('.cuota-monto').each(function() {
                totalCuotasVal += parseFloat($(this).val()) || 0;
                countCuotas++;
            });
            
            let totalVentaVal = parseFloat($('#lbl_total').text());

            if (countCuotas === 0) {
                Swal.fire('Atención', 'Debe agregar al menos una cuota para ventas al crédito.', 'warning');
                return;
            }

            if (Math.abs(totalCuotasVal - totalVentaVal) > 0.01) {
                Swal.fire('Atención', 'El total de las cuotas (' + totalCuotasVal.toFixed(2) + ') no coincide con el total del comprobante (' + totalVentaVal.toFixed(2) + '). Por favor, ajuste los montos.', 'warning');
                return;
            }
        }

        let sim = currentMoneda === 'USD' ? '$' : 'S/';
        let totalDisplay = esGratuita ? '0.00' : $('#lbl_total').text();
        let msgExtra = esGratuita ? '<br><span class="badge bg-success">TRANSFERENCIA GRATUITA</span>' : '';
        
        // Confirmación previa
        Swal.fire({
            title: '¿Confirmar Emisión?',
            html: `Se emitirá el comprobante <strong>${serie}-${$('#correlativo').val()}</strong> por <strong>${sim} ${totalDisplay}</strong> a SUNAT.${msgExtra}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, Emitir',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#0d6efd'
        }).then((result) => {
            if (!result.isConfirmed) return;

            // Mostrar loader global e inmediato
            Swal.showLoading();
            if (typeof window.abrircargando === 'function') {
                window.abrircargando('Firmando XML y enviando a SUNAT...');
            }

            let payload = {
                tipo_comprobante: $('#tipo_comprobante').val(),
                tipo_operacion: tipoOperacion,
                serie: $('#serie').val(),
                correlativo: $('#correlativo').val(),
                fecha_emision: $('#fecha_emision').val(),
                cliente_id: clienteId,
                moneda: currentMoneda,
                tipo_cambio: valTC,
                forma_pago: $('#forma_pago').val(),
                cuotas: obtenerCuotas(),
                items: itemsVenta,
                total_gravadas: $('#lbl_gravadas').text(),
                total_exoneradas: $('#lbl_exoneradas').text(),
                total_inafectas: $('#lbl_inafectas').text(),
                total_gratuitas: $('#lbl_gratuitas').text(),
                total_igv: $('#lbl_igv').text(),
                total_general: $('#lbl_total').text(),
                total_moneda_original: $('#lbl_total').text(),
                observaciones: $('#observaciones').val()
            };

            $.ajax({
                url: appBaseUrl + '/nueva-venta/emitir',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(payload),
                contentType: "application/json",
                success: function (res) {
                    if (typeof window.cerrarcargando === 'function') {
                        window.cerrarcargando();
                    }
                    if (res.success) {
                        let downloadButtons = `
                            <div class="mt-3 p-3 rounded-3" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                <p class="mb-2 text-secondary small fw-bold text-uppercase text-center">Gestionar Comprobante:</p>
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <a href="${appBaseUrl}/venta/imprimir/${res.id_cifrado}/a4" target="_blank" class="btn btn-warning d-flex align-items-center gap-2 shadow-sm">
                                        <i class="material-symbols-outlined fs-20">description</i> A4
                                    </a>
                                    <a href="${appBaseUrl}/venta/imprimir/${res.id_cifrado}/ticket" target="_blank" class="btn btn-dark d-flex align-items-center gap-2 shadow-sm">
                                        <i class="material-symbols-outlined fs-20">receipt</i> TICKET
                                    </a>
                                    ${res.xml_url ? `
                                    <a href="${res.xml_url}" target="_blank" class="btn btn-outline-primary d-flex align-items-center gap-2 shadow-sm">
                                        <i class="material-symbols-outlined fs-20">code</i> XML
                                    </a>` : ''}
                                    ${res.cdr_url ? `
                                    <a href="${res.cdr_url}" target="_blank" class="btn btn-success d-flex align-items-center gap-2 shadow-sm">
                                        <i class="material-symbols-outlined fs-20">task_alt</i> CDR
                                    </a>` : ''}
                                    ${res.wa_url ? `
                                    <a href="${res.wa_url}" target="_blank" class="btn btn-success d-flex align-items-center gap-2 shadow-sm border-0" style="background-color: #25D366;">
                                        <i class="material-symbols-outlined fs-20">chat</i> WHATSAPP
                                    </a>` : ''}
                                </div>
                            </div>
                        `;

                        Swal.fire({
                            title: '¡Emitido Exitosamente!',
                            html: `<div class="text-start">${res.message}</div> ${downloadButtons}`,
                            icon: 'success',
                            confirmButtonText: 'Nueva Venta',
                            showCancelButton: true,
                            cancelButtonText: 'Cerrar',
                            width: '500px'
                        }).then((r) => {
                            if (r.isConfirmed) {
                                window.location.reload();
                            }
                        });
                        // Limpiar formulario
                        itemsVenta = [];
                        renderTable();
                        $('#formNuevaVenta')[0].reset();
                        $('#cliente_nombre, #buscar_cliente, #serie, #correlativo').val('');
                    } else {
                        Swal.fire('Rechazado / Error', res.message, 'error');
                    }
                },
                error: function (err) {
                    if (typeof window.cerrarcargando === 'function') {
                        window.cerrarcargando();
                    }
                    let msg = 'Ocurrió un error al comunicar con el servidor.';
                    if (err.responseJSON && err.responseJSON.message) {
                        msg = err.responseJSON.message;
                    }
                    Swal.fire('Error del Servidor', msg, 'error');
                }
            });
        });
    });

    // 9.5 VISTA PREVIA (BORRADOR)
    $('#btnVistaPrevia').on('click', function () {
        let clienteId = $('#cliente_id').val();
        if (!clienteId && itemsVenta.length === 0) {
            Swal.fire('Atención', 'Debe seleccionar un cliente y agregar al menos un producto para la vista previa.', 'warning');
            return;
        }

        // Validar cuotas si es crédito
        if ($('#forma_pago').val() === 'Credito') {
            let totalCuotasVal = 0;
            let countCuotas = 0;
            $('.cuota-monto').each(function () {
                totalCuotasVal += parseFloat($(this).val()) || 0;
                countCuotas++;
            });
            let totalVentaVal = parseFloat($('#lbl_total').text());
            if (countCuotas === 0) {
                Swal.fire('Atención', 'Debe agregar al menos una cuota para ventas al crédito.', 'warning');
                return;
            }
            if (Math.abs(totalCuotasVal - totalVentaVal) > 0.01) {
                Swal.fire('Atención', 'El total de las cuotas (' + totalCuotasVal.toFixed(2) + ') no coincide con el total del comprobante (' + totalVentaVal.toFixed(2) + ').', 'warning');
                return;
            }
        }

        let tipoOperacion = $('#tipo_operacion').val();
        let esGratuita = tipoOperacion === '0201';

        let payload = {
            tipo_comprobante: $('#tipo_comprobante').val(),
            tipo_operacion: tipoOperacion,
            serie: $('#serie').val() || 'F001',
            correlativo: $('#correlativo').val() || '00000001',
            fecha_emision: $('#fecha_emision').val(),
            cliente_id: clienteId,
            moneda: currentMoneda,
            tipo_cambio: valTC,
            forma_pago: $('#forma_pago').val(),
            cuotas: obtenerCuotas(),
            items: itemsVenta,
            total_gravadas: $('#lbl_gravadas').text(),
            total_exoneradas: $('#lbl_exoneradas').text(),
            total_inafectas: $('#lbl_inafectas').text(),
            total_gratuitas: $('#lbl_gratuitas').text(),
            total_igv: $('#lbl_igv').text(),
            total_general: $('#lbl_total').text(),
            observaciones: $('#observaciones').val()
        };

        // Crear formulario temporal para hacer POST en una pestaña nueva
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

    // 10. PRECARGA DESDE GUIA (Si fue redigirido desde Guia de Remisión)
    if (typeof guiaPreload !== 'undefined' && guiaPreload) {
        // Cargar Cliente
        if (guiaPreload.cliente) {
            $('#cliente_id').val(guiaPreload.cliente.id);
            $('#cliente_tipo_doc').val(guiaPreload.cliente.tipo_documento);
            $('#cliente_num_doc').val(guiaPreload.cliente.nro_documento);
            $('#cliente_nombre').val(guiaPreload.cliente.nro_documento + ' - ' + guiaPreload.cliente.razon_social);
        }

        // Cargar Detalles
        if (guiaPreload.detalles && guiaPreload.detalles.length > 0) {
            guiaPreload.detalles.forEach(function(d) {
                // Agregar producto al array temporal
                let cant = parseFloat(d.cantidad);
                let precio = d.producto ? parseFloat(d.producto.precio_1 || 0) : 0;
                
                let p = {
                    producto_id: d.producto_id || d.codigo,
                    descripcion: d.descripcion,
                    tipo_afectacion: d.producto ? (d.producto.tipo_afectacion || '10') : '10',
                    cantidad: cant,
                    precio_unitario: precio
                };

                // Calcular IGV y subtotal provisorio
                if (p.tipo_afectacion === '10') {
                    p.valor_unitario = p.precio_unitario / 1.18;
                    p.igv = (p.precio_unitario - p.valor_unitario) * p.cantidad;
                    p.importe = p.precio_unitario * p.cantidad;
                } else {
                    p.valor_unitario = p.precio_unitario;
                    p.igv = 0;
                    p.importe = p.precio_unitario * p.cantidad;
                }

                itemsVenta.push(p);
            });
            renderTable();
        }
    }

    function validarFechaEmision() {
        let fechaEmisionVal = $('#fecha_emision').val();
        let $error = $('#error_fecha_emision');
        if (!fechaEmisionVal) {
            $error.text('Debe seleccionar una fecha').removeClass('d-none');
            return false;
        }

        let dateEmision = new Date(fechaEmisionVal + 'T00:00:00');
        let dateHoy = new Date();
        dateHoy.setHours(0,0,0,0);

        // 1. Validar 3 días antes de hoy
        let diffTime = dateHoy.getTime() - dateEmision.getTime();
        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays > 3) {
            $error.text('⚠️ No puede superar los 3 días de antigüedad').removeClass('d-none');
            return false;
        }

        if (dateEmision > new Date()) {
            $error.text('⚠️ La fecha no puede ser futura').removeClass('d-none');
            return false;
        }

        let serieVal = $('#serie').val();
        if (typeof currentSeriesData !== 'undefined' && currentSeriesData) {
            let serieObj = currentSeriesData.find(s => s.serie === serieVal);
            if (serieObj && serieObj.ultima_fecha) {
                let dateUltimo = new Date(serieObj.ultima_fecha + 'T00:00:00');
                if (dateEmision < dateUltimo) {
                    let parts = serieObj.ultima_fecha.split('-');
                    let fechaFormateada = parts[2] + '/' + parts[1] + '/' + parts[0];
                    $error.text('⚠️ Menor al último emitido (' + fechaFormateada + ')').removeClass('d-none');
                    return false;
                }
            }
        }

        $error.addClass('d-none').text('');
        return true;
    }

    $(document).on('change', '#fecha_emision, #serie, #tipo_comprobante', function() {
        setTimeout(validarFechaEmision, 200);
    });

});
