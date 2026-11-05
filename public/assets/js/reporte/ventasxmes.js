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

        // Seleccionar solo TERCERO por defecto
        $('#filter-tipo_cliente .btn-filter').each(function () {
            const val = $(this).data('value').toString().trim().toUpperCase();
            if (val === 'TERCERO') {
                filters.tipo_cliente.push($(this).data('value').toString());
                $(this).addClass('active');
            }
        });
    }

    initDefaults();
    loadReport();

    // Export functionality
    setupExportButton('btn-export-ventas', 'tbl-ventas-mes', 'reporte_ventas_por_mes');

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
        const url = window.baseUrl + '/ajax-listado-ventas-por-mes';
        const data = {
            anio: filters.anio.join(','),
            tipo_cliente: filters.tipo_cliente.join(','),
            empresa: filters.empresa.join(','),
            _token: $('#token').val()
        };

        const loading = '<tr><td colspan="100" class="text-center py-5"><span class="spinner-border spinner-border-sm"></span> Cargando datos de ventas...</td></tr>';
        $('#tbl-ventas-mes tbody').html(loading);

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
        const $tbody = $('#tbl-ventas-mes tbody');
        const $tfoot = $('#footer-totals');

        // Limpiar headers dinámicos
        $headerMonths.find('th:gt(1)').remove();
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
            $headerMonths.append(`<th colspan="2" class="text-center border-start">${monthNamesShort[m]}</th>`);
            $headerMetrics.append(`<th class="text-end bg-light-blue fs-10">T Cant.</th><th class="text-end bg-light-green fs-10 border-end">T Venta S/.</th>`);
        });

        // Totales de la derecha
        $headerMonths.append(`<th colspan="2" class="text-center border-start bg-light">TOTAL</th>`);
        $headerMetrics.append(`<th class="text-end fw-bold bg-light fs-10">T. Gral Cant.</th><th class="text-end fw-bold bg-light fs-10 border-end">T. Gral Venta S/.</th>`);

        // Estructura de datos
        const organized = {};
        const grandTotalsByMonth = {};
        let grandTotalCant = 0;
        let grandTotalVenta = 0;

        data.forEach(item => {
            const peso = item.peso_kilogramos || 'S/P';
            const product = item.producto_nombre || 'S/N';
            const mes = parseInt(item.mes);
            const cant = parseFloat(item.total_cantidad) || 0;
            const venta = parseFloat(item.total_venta) || 0;

            if (!organized[peso]) organized[peso] = { totalCant: 0, totalVenta: 0, months: {}, products: {} };
            if (!organized[peso].months[mes]) organized[peso].months[mes] = { cant: 0, venta: 0 };
            organized[peso].totalCant += cant;
            organized[peso].totalVenta += venta;
            organized[peso].months[mes].cant += cant;
            organized[peso].months[mes].venta += venta;

            if (!organized[peso].products[product]) organized[peso].products[product] = { totalCant: 0, totalVenta: 0, months: {} };
            if (!organized[peso].products[product].months[mes]) organized[peso].products[product].months[mes] = { cant: 0, venta: 0 };
            organized[peso].products[product].totalCant += cant;
            organized[peso].products[product].totalVenta += venta;
            organized[peso].products[product].months[mes].cant += cant;
            organized[peso].products[product].months[mes].venta += venta;

            if (!grandTotalsByMonth[mes]) grandTotalsByMonth[mes] = { cant: 0, venta: 0 };
            grandTotalsByMonth[mes].cant += cant;
            grandTotalsByMonth[mes].venta += venta;
            grandTotalCant += cant;
            grandTotalVenta += venta;
        });

        // Renderizar filas
        Object.keys(organized).sort((a, b) => parseFloat(a) - parseFloat(b)).forEach((peso, pIdx) => {
            const pesoData = organized[peso];
            const pId = `peso-${pIdx}`;

            // Fila de Peso (Padre)
            let pRow = `<tr class="peso-group toggle-row" data-target=".${pId}" style="cursor: pointer; background-color: #f8f9fa;">
                <td class="sticky-col-1 border-end-dark fw-bold"><i class="material-symbols-outlined fs-6 align-middle exp-icon">chevron_right</i> ${peso}</td>
                <td class="sticky-col-2 border-end-dark"></td>`;

            monthsPresent.forEach(m => {
                const mData = pesoData.months[m] || { cant: 0, venta: 0 };
                pRow += `<td class="text-end fw-bold dbl-click-export" data-peso_clic="${peso}" data-mes_clic="${m}" title="Doble clic para ver detalle">${formatNumber(mData.cant)}</td>`;
                pRow += `<td class="text-end fw-bold border-end dbl-click-export" data-peso_clic="${peso}" data-mes_clic="${m}" title="Doble clic para ver detalle">${formatNumber(mData.venta)}</td>`;
            });

            pRow += `<td class="text-end fw-bold bg-light dbl-click-export" data-peso_clic="${peso}" title="Doble clic para ver detalle">${formatNumber(pesoData.totalCant)}</td>`;
            pRow += `<td class="text-end fw-bold bg-light border-end dbl-click-export" data-peso_clic="${peso}" title="Doble clic para ver detalle">${formatNumber(pesoData.totalVenta)}</td>`;
            pRow += `</tr>`;
            $tbody.append(pRow);

            // Filas de Productos (Hijos)
            Object.keys(pesoData.products).sort().forEach(product => {
                const prodData = pesoData.products[product];
                let prodRow = `<tr class="child-row ${pId}" style="display: none;">
                    <td class="sticky-col-1 border-end-dark"></td>
                    <td class="sticky-col-2 border-end-dark fs-12">${product}</td>`;

                monthsPresent.forEach(m => {
                    const mData = prodData.months[m] || { cant: 0, venta: 0 };
                    prodRow += `<td class="text-end text-muted-value fs-11 dbl-click-export" data-peso_clic="${peso}" data-producto_clic="${product}" data-mes_clic="${m}" title="Doble clic para ver detalle">${mData.cant > 0 ? formatNumber(mData.cant) : '-'}</td>`;
                    prodRow += `<td class="text-end text-muted-value fs-11 border-end dbl-click-export" data-peso_clic="${peso}" data-producto_clic="${product}" data-mes_clic="${m}" title="Doble clic para ver detalle">${mData.venta > 0 ? formatNumber(mData.venta) : '-'}</td>`;
                });

                prodRow += `<td class="text-end text-muted-value fs-11 bg-light dbl-click-export" data-peso_clic="${peso}" data-producto_clic="${product}" title="Doble clic para ver detalle">${formatNumber(prodData.totalCant)}</td>`;
                prodRow += `<td class="text-end text-muted-value fs-11 bg-light border-end dbl-click-export" data-peso_clic="${peso}" data-producto_clic="${product}" title="Doble clic para ver detalle">${formatNumber(prodData.totalVenta)}</td>`;
                prodRow += `</tr>`;
                $tbody.append(prodRow);
            });
        });

        // Footer Totals
        let fRow = `<tr class="fw-bold bg-dark text-white">
            <td colspan="2" class="sticky-col-1 border-end-dark">Total general</td>`;

        monthsPresent.forEach(m => {
            const gtM = grandTotalsByMonth[m] || { cant: 0, venta: 0 };
            fRow += `<td class="text-end dbl-click-export" data-mes_clic="${m}" title="Doble clic para ver detalle">${formatNumber(gtM.cant)}</td>`;
            fRow += `<td class="text-end border-end dbl-click-export" data-mes_clic="${m}" title="Doble clic para ver detalle">${formatNumber(gtM.venta)}</td>`;
        });

        fRow += `<td class="text-end dbl-click-export" title="Doble clic para ver detalle">${formatNumber(grandTotalCant)}</td>`;
        fRow += `<td class="text-end border-end dbl-click-export" title="Doble clic para ver detalle">${formatNumber(grandTotalVenta)}</td>`;
        fRow += `</tr>`;
        $tfoot.append(fRow);

        attachTableEvents();
    }

    function attachTableEvents() {
        $('.toggle-row').off('click').on('click', function () {
            const $row = $(this);
            const target = $row.data('target');
            const $icon = $row.find('.exp-icon');
            const isCollapsing = $icon.text() === 'expand_more';

            if (isCollapsing) {
                $icon.text('chevron_right');
                $(target).fadeOut('fast');
            } else {
                $icon.text('expand_more');
                $(target).fadeIn('fast');
            }
        });

        // Evento Doble Clic para Exportar Detalle
        $('.dbl-click-export').off('dblclick').on('dblclick', function () {
            const d = $(this).data();
            const url = window.baseUrl + '/ajax-exportar-detalle-ventas-por-mes';
            const params = $.param({
                anio: filters.anio.join(','),
                tipo_cliente: filters.tipo_cliente.join(','),
                empresa: filters.empresa.join(','),
                peso_clic: d.peso_clic,
                producto_clic: d.producto_clic,
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
