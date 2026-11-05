$(document).ready(function () {
    "use strict";

    const filters = {
        anio: [],
        mes: [],
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

        // Seleccionar el mes actual por defecto
        const currentMonth = new Date().getMonth() + 1;
        filters.mes = [currentMonth.toString()];
        $(`#filter-mes .btn-filter-mes[data-value="${currentMonth}"]`).addClass('active');

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
    setupExportButton('btn-export-precio-diario', 'tbl-precio-promedio-diario', 'reporte_precio_promedio_diario');

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

    // Filtro de Mes - Selección única
    $('.btn-filter-mes').on('click', function () {
        const $btn = $(this);
        const value = $btn.data('value').toString();

        if ($btn.hasClass('active')) {
            // No permitir deseleccionar si es selección única, o al menos no hacer nada
            return;
        }

        // Limpiar otros meses
        $('#filter-mes .btn-filter-mes').removeClass('active');
        $btn.addClass('active');
        filters.mes = [value];

        loadReport();
    });

    $('.clear-filter').on('click', function () {
        const filterType = $(this).data('filter');
        if (filterType === 'mes') return; // El mes no se limpia por ser selección única

        filters[filterType] = [];
        $(`#filter-${filterType} .btn-filter`).removeClass('active');
        loadReport();
    });

    function loadReport() {
        const url = window.baseUrl + '/ajax-listado-precio-promedio-diario';
        const data = {
            anio: filters.anio.join(','),
            mes: filters.mes.join(','),
            tipo_cliente: filters.tipo_cliente.join(','),
            empresa: filters.empresa.join(','),
            _token: $('#token').val()
        };

        const loading = '<tr><td colspan="100" class="text-center py-5"><span class="spinner-border spinner-border-sm"></span> Cargando datos de precios diarios...</td></tr>';
        $('#tbl-precio-promedio-diario tbody').html(loading);

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (response) {
                renderReport(response);
            },
            error: function (err) {
                $('#tbl-precio-promedio-diario tbody').html('<tr><td colspan="100" class="text-center text-danger py-4">Error al cargar datos</td></tr>');
            }
        });
    }

    function renderReport(data) {
        const $headerDays = $('#header-days');
        const $headerMetrics = $('#header-metrics-diario');
        const $tbody = $('#tbl-precio-promedio-diario tbody');
        const $tfoot = $('#footer-totals-diario');

        // Limpiar headers dinámicos
        $headerDays.find('th:gt(2)').remove();
        $headerMetrics.empty();
        $tbody.empty();
        $tfoot.empty();

        if (data.length === 0) {
            $tbody.append('<tr><td colspan="100" class="text-center py-4">No hay datos para los filtros seleccionados</td></tr>');
            return;
        }

        // Obtener días presentes en los datos
        const daysPresent = [...new Set(data.map(item => parseInt(item.dia)))].sort((a, b) => a - b);

        daysPresent.forEach(d => {
            $headerDays.append(`<th class="text-center border-start">${d}</th>`);
            $headerMetrics.append(`<th class="text-end bg-light-green fs-10 border-end">S/.</th>`);
        });

        // Totales de la derecha
        $headerDays.append(`<th class="text-center border-start bg-light">PROMEDIO</th>`);
        $headerMetrics.append(`<th class="text-end fw-bold bg-light fs-10 border-end">S/.</th>`);

        // Estructura de datos jerárquica: Peso -> Producto -> Cliente
        const organized = {};
        const grandTotalsByDay = { importe: {}, cantidad: {} };
        const grandTotalCounts = { importe: 0, cantidad: 0 };

        data.forEach(item => {
            const peso = item.peso_kilogramos || 'S/P';
            const product = item.producto_nombre || 'S/N';
            const cliente = item.cliente_nombre || 'S/N';
            const dia = parseInt(item.dia);

            const importe = parseFloat(item.total_importe) || 0;
            const cantidad = parseFloat(item.total_cantidad) || 0;

            if (!organized[peso]) {
                organized[peso] = { days: {}, products: {} };
            }
            if (!organized[peso].days[dia]) organized[peso].days[dia] = { importe: 0, cantidad: 0 };
            organized[peso].days[dia].importe += importe;
            organized[peso].days[dia].cantidad += cantidad;

            if (!organized[peso].products[product]) {
                organized[peso].products[product] = { days: {}, clientes: {} };
            }
            if (!organized[peso].products[product].days[dia]) organized[peso].products[product].days[dia] = { importe: 0, cantidad: 0 };
            organized[peso].products[product].days[dia].importe += importe;
            organized[peso].products[product].days[dia].cantidad += cantidad;

            if (!organized[peso].products[product].clientes[cliente]) {
                organized[peso].products[product].clientes[cliente] = { days: {} };
            }
            if (!organized[peso].products[product].clientes[cliente].days[dia]) organized[peso].products[product].clientes[cliente].days[dia] = { importe: 0, cantidad: 0 };
            organized[peso].products[product].clientes[cliente].days[dia].importe += importe;
            organized[peso].products[product].clientes[cliente].days[dia].cantidad += cantidad;

            if (!grandTotalsByDay.importe[dia]) grandTotalsByDay.importe[dia] = 0;
            if (!grandTotalsByDay.cantidad[dia]) grandTotalsByDay.cantidad[dia] = 0;
            grandTotalsByDay.importe[dia] += importe;
            grandTotalsByDay.cantidad[dia] += cantidad;

            grandTotalCounts.importe += importe;
            grandTotalCounts.cantidad += cantidad;
        });

        const calcPromedio = (importe, cantidad) => (cantidad > 0) ? (importe / cantidad) : 0;

        // Calcular promedios generales
        Object.keys(organized).forEach(peso => {
            const pesoData = organized[peso];
            let pImp = 0, pCant = 0;
            Object.values(pesoData.days).forEach(d => { pImp += d.importe; pCant += d.cantidad; });
            pesoData.promGeneral = calcPromedio(pImp, pCant);

            Object.keys(pesoData.products).forEach(product => {
                const prodData = pesoData.products[product];
                let prImp = 0, prCant = 0;
                Object.values(prodData.days).forEach(d => { prImp += d.importe; prCant += d.cantidad; });
                prodData.promGeneral = calcPromedio(prImp, prCant);

                Object.keys(prodData.clientes).forEach(cliente => {
                    const cliData = prodData.clientes[cliente];
                    let cImp = 0, cCant = 0;
                    Object.values(cliData.days).forEach(d => { cImp += d.importe; cCant += d.cantidad; });
                    cliData.promGeneral = calcPromedio(cImp, cCant);
                });
            });
        });

        // Renderizar filas
        Object.keys(organized).sort((a, b) => parseFloat(a) - parseFloat(b)).forEach((peso, pIdx) => {
            const pesoData = organized[peso];
            const pId = `peso-d-${pIdx}`;

            let pRow = `<tr class="peso-group toggle-row" data-target=".${pId}" style="cursor: pointer; background-color: #f8f9fa;">
                <td class="sticky-col-1 border-end-dark fw-bold"><i class="material-symbols-outlined fs-6 align-middle exp-icon">chevron_right</i> ${peso}</td>
                <td class="sticky-col-2 border-end-dark"></td>
                <td class="sticky-col-3 border-end-dark"></td>`;

            daysPresent.forEach(d => {
                const dData = pesoData.days[d];
                const precio = dData ? calcPromedio(dData.importe, dData.cantidad) : 0;
                pRow += `<td class="text-end fw-bold dbl-click-export" data-peso_clic="${peso}" data-dia_clic="${d}" title="Doble clic para ver detalle">${precio > 0 ? formatNumber(precio) : '-'}</td>`;
            });
            pRow += `<td class="text-end fw-bold bg-light dbl-click-export" data-peso_clic="${peso}" title="Doble clic para ver detalle">${formatNumber(pesoData.promGeneral)}</td>`;
            pRow += `</tr>`;
            $tbody.append(pRow);

            Object.keys(pesoData.products).sort().forEach((product, prodIdx) => {
                const prodData = pesoData.products[product];
                const prodId = `${pId}-prod-${prodIdx}`;

                let prodRow = `<tr class="child-row ${pId} toggle-row" data-target=".${prodId}" style="display: none; cursor: pointer; background-color: #f0f4f7;">
                    <td class="sticky-col-1 border-end-dark"></td>
                    <td class="sticky-col-2 border-end-dark fs-12"><i class="material-symbols-outlined fs-6 align-middle exp-icon">chevron_right</i> ${product}</td>
                    <td class="sticky-col-3 border-end-dark"></td>`;

                daysPresent.forEach(d => {
                    const dData = prodData.days[d];
                    const precio = dData ? calcPromedio(dData.importe, dData.cantidad) : 0;
                    prodRow += `<td class="text-end text-muted-value fs-11 dbl-click-export" data-peso_clic="${peso}" data-producto_clic="${product}" data-dia_clic="${d}" title="Doble clic para ver detalle">${precio > 0 ? formatNumber(precio) : '-'}</td>`;
                });
                prodRow += `<td class="text-end text-muted-value fs-11 bg-light dbl-click-export" data-peso_clic="${peso}" data-producto_clic="${product}" title="Doble clic para ver detalle">${formatNumber(prodData.promGeneral)}</td>`;
                prodRow += `</tr>`;
                $tbody.append(prodRow);

                Object.keys(prodData.clientes).sort().forEach(cliente => {
                    const cliData = prodData.clientes[cliente];
                    let cliRow = `<tr class="grandchild-row ${prodId}" style="display: none;">
                        <td class="sticky-col-1 border-end-dark"></td>
                        <td class="sticky-col-2 border-end-dark"></td>
                        <td class="sticky-col-3 border-end-dark fs-11 text-muted">${cliente}</td>`;

                    daysPresent.forEach(d => {
                        const dData = cliData.days[d];
                        const precio = dData ? calcPromedio(dData.importe, dData.cantidad) : 0;
                        cliRow += `<td class="text-end text-muted fs-10 dbl-click-export" data-peso_clic="${peso}" data-producto_clic="${product}" data-cliente_clic="${cliente}" data-dia_clic="${d}" title="Doble clic para ver detalle">${precio > 0 ? formatNumber(precio) : '-'}</td>`;
                    });
                    cliRow += `<td class="text-end text-muted fs-10 bg-light dbl-click-export" data-peso_clic="${peso}" data-producto_clic="${product}" data-cliente_clic="${cliente}" title="Doble clic para ver detalle">${formatNumber(cliData.promGeneral)}</td>`;
                    cliRow += `</tr>`;
                    $tbody.append(cliRow);
                });
            });
        });

        // Footer Totals
        let fRow = `<tr class="fw-bold bg-dark text-white">
            <td colspan="3" class="sticky-col-1 border-end-dark">Promedio General</td>`;
        daysPresent.forEach(d => {
            const prom = calcPromedio(grandTotalsByDay.importe[d], grandTotalsByDay.cantidad[d]);
            fRow += `<td class="text-end dbl-click-export" data-dia_clic="${d}" title="Doble clic para ver detalle">${formatNumber(prom)}</td>`;
        });
        fRow += `<td class="text-end dbl-click-export" title="Doble clic para ver detalle">${formatNumber(calcPromedio(grandTotalCounts.importe, grandTotalCounts.cantidad))}</td>`;
        fRow += `</tr>`;
        $tfoot.append(fRow);

        attachTableEvents();
    }

    function attachTableEvents() {
        $('.toggle-row').off('click').on('click', function (e) {
            if ($(e.target).hasClass('dbl-click-export') || $(e.target).closest('.dbl-click-export').length) return;
            const $row = $(this), target = $row.data('target'), $icon = $row.find('.exp-icon').first();
            if ($icon.text() === 'expand_more') {
                $icon.text('chevron_right');
                $(target).fadeOut('fast');
                $(target).find('.exp-icon').text('chevron_right');
                $(target).each(function () { const sub = $(this).data('target'); if (sub) $(sub).hide(); });
            } else {
                $icon.text('expand_more');
                $(target).fadeIn('fast');
            }
        });

        $('.dbl-click-export').off('dblclick').on('dblclick', function () {
            const d = $(this).data();
            const url = window.baseUrl + '/ajax-exportar-detalle-precio-promedio-diario';
            const params = $.param({
                anio: filters.anio.join(','),
                mes: filters.mes.join(','),
                tipo_cliente: filters.tipo_cliente.join(','),
                empresa: filters.empresa.join(','),
                peso_clic: d.peso_clic,
                producto_clic: d.producto_clic,
                cliente_clic: d.cliente_clic,
                dia_clic: d.dia_clic,
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
        if (num === null || num === undefined || isNaN(num) || num === 0) return '0.00';
        return parseFloat(num).toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
    }
});
