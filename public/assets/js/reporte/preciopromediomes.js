$(document).ready(function () {
    "use strict";

    const filters = {
        anio: [],
        tipo_cliente: [],
        empresa: []
    };

    function initDefaults() {
        // Seleccionar el año más reciente por defecto
        const lastYear = $('#filter-anio .btn-filter').first().data('value');
        if (lastYear) {
            filters.anio = [lastYear.toString()];
            $(`#filter-anio .btn-filter[data-value="${lastYear}"]`).addClass('active');
        }

        // Seleccionar todas las empresas por defecto
        $('#filter-empresa .btn-filter').each(function () {
            const val = $(this).data('value').toString();
            filters.empresa.push(val);
            $(this).addClass('active');
        });

        // Seleccionar todas los tipos de cliente por defecto
        $('#filter-tipo_cliente .btn-filter').each(function () {
            const val = $(this).data('value').toString();
            filters.tipo_cliente.push(val);
            $(this).addClass('active');
        });
    }

    initDefaults();
    loadReport();

    // Export functionality
    setupExportButton('btn-export-precio', 'tbl-precio-promedio-mes', 'reporte_precio_promedio_mes');

    $('.btn-filter').on('click', function () {
        const $btn = $(this);
        const filterType = $btn.parent().attr('id').replace('filter-', '');
        const value = $btn.data('value').toString();

        if ($btn.hasClass('active')) {
            $btn.removeClass('active');
            filters[filterType] = filters[filterType].filter(item => item !== value);
        } else {
            $btn.addClass('active');
            filters[filterType].push(value);
        }
        loadReport();
    });

    $('.clear-filter').on('click', function () {
        const filterType = $(this).data('filter');
        filters[filterType] = [];
        $(`#filter-${filterType} .btn-filter`).removeClass('active');
        loadReport();
    });

    function loadReport() {
        const url = window.baseUrl + '/ajax-listado-precio-promedio-mes';
        const data = {
            anio: filters.anio.join(','),
            tipo_cliente: filters.tipo_cliente.join(','),
            empresa: filters.empresa.join(','),
            _token: $('#token').val()
        };

        const loading = '<tr><td colspan="100" class="text-center py-5"><span class="spinner-border spinner-border-sm"></span> Cargando datos de precios...</td></tr>';
        $('#tbl-precio-promedio-mes tbody').html(loading);

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (response) {
                renderReport(response);
            }
        });
    }

    const monthNamesShort = ["", "ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SET", "OCT", "NOV", "DIC"];

    function renderReport(data) {
        const $headerMonths = $('#header-months');
        const $headerMetrics = $('#header-metrics');
        const $tbody = $('#tbl-precio-promedio-mes tbody');
        const $tfoot = $('#footer-totals');

        // Limpiar headers dinámicos
        $headerMonths.find('th:gt(2)').remove();
        $headerMetrics.empty();
        $tbody.empty();
        $tfoot.empty();

        if (data.length === 0) {
            $tbody.append('<tr><td colspan="100" class="text-center py-4">No hay datos para los filtros seleccionados</td></tr>');
            return;
        }

        // Obtener meses presentes en los datos
        const monthsPresent = [...new Set(data.map(item => parseInt(item.mes)))].sort((a, b) => a - b);

        monthsPresent.forEach(m => {
            $headerMonths.append(`<th class="text-center border-start">${monthNamesShort[m]}</th>`);
            $headerMetrics.append(`<th class="text-end bg-light-green fs-10 border-end">Precio Prom. S/.</th>`);
        });

        // Totales de la derecha
        $headerMonths.append(`<th class="text-center border-start bg-light">PROMEDIO GRAL</th>`);
        $headerMetrics.append(`<th class="text-end fw-bold bg-light fs-10 border-end">Precio Prom. S/.</th>`);

        // Estructura de datos jerárquica: Peso -> Producto -> Cliente
        const organized = {};
        const grandTotalsByMonth = { importe: {}, cantidad: {} };
        const grandTotalCounts = { importe: 0, cantidad: 0 }; // Para el promedio global total

        data.forEach(item => {
            const peso = item.peso_kilogramos || 'S/P';
            const product = item.producto_nombre || 'S/N';
            const cliente = item.cliente_nombre || 'S/N';
            const mes = parseInt(item.mes);

            // Convertir a float con seguridad
            const importe = parseFloat(item.total_importe) || 0;
            const cantidad = parseFloat(item.total_cantidad) || 0;

            // Nivel 1: Peso
            if (!organized[peso]) {
                organized[peso] = {
                    months: {}, // Almacenará { importe: X, cantidad: Y } por mes
                    products: {}
                };
            }
            if (!organized[peso].months[mes]) {
                organized[peso].months[mes] = { importe: 0, cantidad: 0 };
            }
            organized[peso].months[mes].importe += importe;
            organized[peso].months[mes].cantidad += cantidad;

            // Nivel 2: Producto
            if (!organized[peso].products[product]) {
                organized[peso].products[product] = {
                    months: {},
                    clientes: {}
                };
            }
            if (!organized[peso].products[product].months[mes]) {
                organized[peso].products[product].months[mes] = { importe: 0, cantidad: 0 };
            }
            organized[peso].products[product].months[mes].importe += importe;
            organized[peso].products[product].months[mes].cantidad += cantidad;

            // Nivel 3: Cliente
            if (!organized[peso].products[product].clientes[cliente]) {
                organized[peso].products[product].clientes[cliente] = {
                    months: {}
                };
            }
            // En el nivel más bajo (cliente), guardamos los totales directos
            // Nota: Podría haber múltiples filas para el mismo cliente/mes si el backend no agrupa todo (aunque el backend ya agrupa por cliente/mes)
            // Para asegurar, sumamos si ya existiera (aunque con la query actual será único)
            if (!organized[peso].products[product].clientes[cliente].months[mes]) {
                organized[peso].products[product].clientes[cliente].months[mes] = { importe: 0, cantidad: 0 };
            }
            organized[peso].products[product].clientes[cliente].months[mes].importe += importe;
            organized[peso].products[product].clientes[cliente].months[mes].cantidad += cantidad;

            // Grand totals
            if (!grandTotalsByMonth.importe[mes]) grandTotalsByMonth.importe[mes] = 0;
            if (!grandTotalsByMonth.cantidad[mes]) grandTotalsByMonth.cantidad[mes] = 0;

            grandTotalsByMonth.importe[mes] += importe;
            grandTotalsByMonth.cantidad[mes] += cantidad;

            grandTotalCounts.importe += importe;
            grandTotalCounts.cantidad += cantidad;
        });

        // Función auxiliar para calcular precio promedio
        const calcPromedio = (importe, cantidad) => {
            return (cantidad > 0) ? (importe / cantidad) : 0;
        };

        // Calcular promedios generales por fila (Peso y Producto)
        Object.keys(organized).forEach(peso => {
            const pesoData = organized[peso];
            let pesoTotalImporte = 0;
            let pesoTotalCantidad = 0;

            // Calcular total general de la fila Peso (sumando todos los meses disponibles)
            // Nota: Ya tenemos acumulados por mes, podemos usarlos
            Object.values(pesoData.months).forEach(m => {
                pesoTotalImporte += m.importe;
                pesoTotalCantidad += m.cantidad;
            });
            pesoData.promGeneral = calcPromedio(pesoTotalImporte, pesoTotalCantidad);

            // Calcular para Productos
            Object.keys(pesoData.products).forEach(product => {
                const prodData = pesoData.products[product];
                let prodTotalImporte = 0;
                let prodTotalCantidad = 0;

                Object.values(prodData.months).forEach(m => {
                    prodTotalImporte += m.importe;
                    prodTotalCantidad += m.cantidad;
                });
                prodData.promGeneral = calcPromedio(prodTotalImporte, prodTotalCantidad);

                // Calcular para Clientes (Nivel 3)
                Object.keys(prodData.clientes).forEach(cliente => {
                    const clienteData = prodData.clientes[cliente];
                    let cliTotalImporte = 0;
                    let cliTotalCantidad = 0;
                    Object.values(clienteData.months).forEach(m => {
                        cliTotalImporte += m.importe;
                        cliTotalCantidad += m.cantidad;
                    });
                    clienteData.promGeneral = calcPromedio(cliTotalImporte, cliTotalCantidad);
                });
            });
        });

        // Renderizar filas
        Object.keys(organized).sort((a, b) => parseFloat(a) - parseFloat(b)).forEach((peso, pIdx) => {
            const pesoData = organized[peso];
            const pId = `peso-${pIdx}`;

            // Fila de Peso (Nivel 1)
            let pRow = `<tr class="peso-group toggle-row" data-target=".${pId}" style="cursor: pointer; background-color: #f8f9fa;">
                <td class="sticky-col-1 border-end-dark fw-bold"><i class="material-symbols-outlined fs-6 align-middle exp-icon">chevron_right</i> ${peso}</td>
                <td class="sticky-col-2 border-end-dark"></td>
                <td class="sticky-col-3 border-end-dark"></td>`;

            monthsPresent.forEach(m => {
                const mData = pesoData.months[m];
                const precio = mData ? calcPromedio(mData.importe, mData.cantidad) : 0;
                pRow += `<td class="text-end fw-bold dbl-click-export" data-peso_clic="${peso}" data-mes_clic="${m}" title="Doble clic para ver detalle">${precio > 0 ? formatNumber(precio) : '-'}</td>`;
            });

            pRow += `<td class="text-end fw-bold bg-light dbl-click-export" data-peso_clic="${peso}" title="Doble clic para ver detalle">${formatNumber(pesoData.promGeneral)}</td>`;
            pRow += `</tr>`;
            $tbody.append(pRow);

            // Filas de Productos (Nivel 2)
            Object.keys(pesoData.products).sort().forEach((product, prodIdx) => {
                const prodData = pesoData.products[product];
                const prodId = `${pId}-prod-${prodIdx}`;

                let prodRow = `<tr class="child-row ${pId} toggle-row" data-target=".${prodId}" style="display: none; cursor: pointer; background-color: #f0f4f7;">
                    <td class="sticky-col-1 border-end-dark"></td>
                    <td class="sticky-col-2 border-end-dark fs-12"><i class="material-symbols-outlined fs-6 align-middle exp-icon">chevron_right</i> ${product}</td>
                    <td class="sticky-col-3 border-end-dark"></td>`;

                monthsPresent.forEach(m => {
                    const mData = prodData.months[m];
                    const precio = mData ? calcPromedio(mData.importe, mData.cantidad) : 0;
                    prodRow += `<td class="text-end text-muted-value fs-11 dbl-click-export" data-peso_clic="${peso}" data-producto_clic="${product}" data-mes_clic="${m}" title="Doble clic para ver detalle">${precio > 0 ? formatNumber(precio) : '-'}</td>`;
                });

                prodRow += `<td class="text-end text-muted-value fs-11 bg-light dbl-click-export" data-peso_clic="${peso}" data-producto_clic="${product}" title="Doble clic para ver detalle">${formatNumber(prodData.promGeneral)}</td>`;
                prodRow += `</tr>`;
                $tbody.append(prodRow);

                // Filas de Clientes (Nivel 3)
                Object.keys(prodData.clientes).sort().forEach(cliente => {
                    const clienteData = prodData.clientes[cliente];

                    let clienteRow = `<tr class="grandchild-row ${prodId}" style="display: none;">
                        <td class="sticky-col-1 border-end-dark"></td>
                        <td class="sticky-col-2 border-end-dark"></td>
                        <td class="sticky-col-3 border-end-dark fs-11 text-muted">${cliente}</td>`;

                    monthsPresent.forEach(m => {
                        const mData = clienteData.months[m];
                        const precio = mData ? calcPromedio(mData.importe, mData.cantidad) : 0;
                        clienteRow += `<td class="text-end text-muted fs-10 dbl-click-export" data-peso_clic="${peso}" data-producto_clic="${product}" data-cliente_clic="${cliente}" data-mes_clic="${m}" title="Doble clic para ver detalle">${precio > 0 ? formatNumber(precio) : '-'}</td>`;
                    });

                    clienteRow += `<td class="text-end text-muted fs-10 bg-light dbl-click-export" data-peso_clic="${peso}" data-producto_clic="${product}" data-cliente_clic="${cliente}" title="Doble clic para ver detalle">${formatNumber(clienteData.promGeneral)}</td>`;
                    clienteRow += `</tr>`;
                    $tbody.append(clienteRow);
                });
            });
        });

        // Footer Totals
        let fRow = `<tr class="fw-bold bg-dark text-white">
            <td colspan="3" class="sticky-col-1 border-end-dark">Promedio General</td>`;

        monthsPresent.forEach(m => {
            const importe = grandTotalsByMonth.importe[m] || 0;
            const cantidad = grandTotalsByMonth.cantidad[m] || 0;
            const promedio = calcPromedio(importe, cantidad);
            fRow += `<td class="text-end dbl-click-export" data-mes_clic="${m}" title="Doble clic para ver detalle">${formatNumber(promedio)}</td>`;
        });

        // Promedio Global Total
        const promedioGlobal = calcPromedio(grandTotalCounts.importe, grandTotalCounts.cantidad);

        fRow += `<td class="text-end dbl-click-export" title="Doble clic para ver detalle">${formatNumber(promedioGlobal)}</td>`;
        fRow += `</tr>`;
        $tfoot.append(fRow);

        attachTableEvents();
    }

    function attachTableEvents() {
        $('.toggle-row').off('click').on('click', function (e) {
            // Evitar que se dispare si se hace clic en una celda con export
            if ($(e.target).hasClass('dbl-click-export') || $(e.target).closest('.dbl-click-export').length) {
                return;
            }

            const $row = $(this);
            const target = $row.data('target');
            const $icon = $row.find('.exp-icon').first();
            const isCollapsing = $icon.text() === 'expand_more';

            if (isCollapsing) {
                $icon.text('chevron_right');
                $(target).fadeOut('fast');
                // También colapsar los nietos si están expandidos
                $(target).find('.exp-icon').text('chevron_right');
                $(target).each(function () {
                    const subTarget = $(this).data('target');
                    if (subTarget) {
                        $(subTarget).hide();
                    }
                });
            } else {
                $icon.text('expand_more');
                $(target).fadeIn('fast');
            }
        });

        // Evento Doble Clic para Exportar Detalle
        $('.dbl-click-export').off('dblclick').on('dblclick', function () {
            const d = $(this).data();
            const url = window.baseUrl + '/ajax-exportar-detalle-precio-promedio-mes';
            const params = $.param({
                anio: filters.anio.join(','),
                tipo_cliente: filters.tipo_cliente.join(','),
                empresa: filters.empresa.join(','),
                peso_clic: d.peso_clic,
                producto_clic: d.producto_clic,
                cliente_clic: d.cliente_clic,
                mes_clic: d.mes_clic,
                _token: $('#token').val()
            });
            window.location.href = url + '?' + params;
        });
    }

    function setupExportButton(btnId, tableId, filename) {
        $(`#${btnId}`).off('click').on('click', function () {
            let csv = ['\uFEFF'];
            $(`#${tableId} thead tr`).each(function () { let r = []; $(this).find('th').each(function () { r.push('"' + $(this).text().trim() + '"'); }); csv.push(r.join(';')); });
            $(`#${tableId} tbody tr:visible`).each(function () { let r = []; $(this).find('td').each(function () { let t = $(this).text().trim().replace(/expand_more|chevron_right/g, ''); r.push('"' + t + '"'); }); csv.push(r.join(';')); });
            $(`#${tableId} tfoot tr`).each(function () { let r = []; $(this).find('td').each(function () { r.push('"' + $(this).text().trim() + '"'); }); csv.push(r.join(';')); });
            const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a"); link.setAttribute("href", URL.createObjectURL(blob)); link.setAttribute("download", `${filename}.csv`); link.click();
        });
    }

    function formatNumber(num, decimals = 2) {
        if (num === null || num === undefined || isNaN(num)) return '0.00';
        if (num === 0) return '0.00';
        return parseFloat(num).toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
    }
});
