$(document).ready(function () {
    "use strict";

    const filters = {
        anio: [],
        mes: [],
        centro: []
    };

    function initDefaults() {
        const lastYear = $('#filter-anio .btn-filter').first().data('value');
        const currentMonth = new Date().getMonth() + 1;

        if (lastYear) {
            filters.anio = [lastYear.toString()];
            $(`#filter-anio .btn-filter[data-value="${lastYear}"]`).addClass('active');
        }

        if ($(`#filter-mes .btn-filter[data-value="${currentMonth}"]`).length) {
            filters.mes = [currentMonth.toString()];
            $(`#filter-mes .btn-filter[data-value="${currentMonth}"]`).addClass('active');
        } else {
            const lastAvailableMonth = $('#filter-mes .btn-filter').last().data('value');
            if (lastAvailableMonth) {
                filters.mes = [lastAvailableMonth.toString()];
                $(`#filter-mes .btn-filter[data-value="${lastAvailableMonth}"]`).addClass('active');
            }
        }

        $('#filter-centro .btn-filter').each(function () {
            const val = $(this).data('value').toString();
            filters.centro.push(val);
            $(this).addClass('active');
        });
    }

    initDefaults();
    loadReport();

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
        const url = window.baseUrl + '/ajax-listado-precio-zona';
        const data = {
            anio: filters.anio.join(','),
            mes: filters.mes.join(','),
            centro: filters.centro.join(','),
            _token: $('#token').val()
        };

        const loading = '<tr><td colspan="10" class="text-center py-5"><span class="spinner-border spinner-border-sm"></span> Cargando reporte por zonas...</td></tr>';
        $('#tbl-precio-zona tbody').html(loading);

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (response) {
                renderReport(response);
            }
        });

        loadComparisonReport();
    }

    function renderReport(data) {
        const $tbody = $('#tbl-precio-zona tbody');
        $tbody.empty();

        if (data.length === 0) {
            $tbody.append('<tr><td colspan="6" class="text-center">No hay registros</td></tr>');
            resetTotals();
            return;
        }

        const grouped = {};
        let gH = 0, gImp = 0;

        data.forEach(item => {
            const h = parseFloat(item.total_peso_humedo) || 0;
            const imp = parseFloat(item.total_importe) || 0;
            gH += h; gImp += imp;

            const y = item.anio_compra;
            const c = item.centro_acopio_nombre;

            if (!grouped[y]) grouped[y] = { totalH: 0, totalImp: 0, centros: {} };
            const yearObj = grouped[y];
            yearObj.totalH += h;
            yearObj.totalImp += imp;

            if (!yearObj.centros[c]) yearObj.centros[c] = { totalH: 0, totalImp: 0, zones: [] };
            const centerObj = yearObj.centros[c];
            centerObj.totalH += h;
            centerObj.totalImp += imp;
            centerObj.zones.push(item);
        });

        Object.keys(grouped).sort((a, b) => b - a).forEach((year, yIdx) => {
            const yearObj = grouped[year];
            const yPUnit = yearObj.totalH > 0 ? yearObj.totalImp / yearObj.totalH : 0;
            const yearId = `year-${yIdx}`;

            $tbody.append(`
                <tr class="centro-group toggle-row" data-target=".${yearId}" style="cursor: pointer;">
                    <td class="sticky-col-1 border-end-dark fw-bold"><i class="material-symbols-outlined fs-6 align-middle exp-icon">expand_more</i> ${year}</td>
                    <td class="sticky-col-2 border-end-dark"></td>
                    <td class="sticky-col-3 border-end-dark text-center"><span class="badge bg-light text-dark border">AÑO</span></td>
                    <td class="text-end fw-bold text-primary-value bg-metric-h">${formatNumber(yPUnit, 2)}</td>
                    <td class="text-end fw-bold">${formatNumber(yearObj.totalH)}</td>
                    <td class="text-end fw-bold">${formatNumber(yearObj.totalImp)}</td>
                </tr>
            `);

            Object.keys(yearObj.centros).sort().forEach((centerName, cIdx) => {
                const centerObj = yearObj.centros[centerName];
                const cPUnit = centerObj.totalH > 0 ? centerObj.totalImp / centerObj.totalH : 0;
                const centerId = `${yearId}-c-${cIdx}`;

                $tbody.append(`
                    <tr class="variedad-group toggle-row ${yearId}" data-target=".${centerId}" style="cursor: pointer; display: none;">
                        <td class="sticky-col-1 border-end-dark"></td>
                        <td class="sticky-col-2 border-end-dark fw-semibold"><i class="material-symbols-outlined fs-6 align-middle exp-icon">expand_more</i> ${centerName}</td>
                        <td class="sticky-col-3 border-end-dark text-center"><span class="badge bg-light text-dark border">CENTRO</span></td>
                        <td class="text-end text-primary-value">${formatNumber(cPUnit, 2)}</td>
                        <td class="text-end">${formatNumber(centerObj.totalH)}</td>
                        <td class="text-end">${formatNumber(centerObj.totalImp)}</td>
                    </tr>
                `);

                centerObj.zones.forEach(item => {
                    const iH = parseFloat(item.total_peso_humedo) || 0;
                    const iImp = parseFloat(item.total_importe) || 0;
                    const iPUnit = iH > 0 ? iImp / iH : 0;

                    $tbody.append(`
                        <tr class="child-row ${centerId} dbl-click-export" data-centro="${centerName}" data-zona="${item.zona_comercial}" data-anio="${year}" title="Doble clic para ver detalle" style="display: none;">
                            <td class="sticky-col-1 border-end-dark"></td>
                            <td class="sticky-col-2 border-end-dark"></td>
                            <td class="sticky-col-3 border-end-dark ps-3 text-muted-value">${item.zona_comercial || 'SIN ZONA'}</td>
                            <td class="text-end text-primary-value">${formatNumber(iPUnit, 2)}</td>
                            <td class="text-end text-muted-value">${formatNumber(iH)}</td>
                            <td class="text-end text-muted-value">${formatNumber(iImp)}</td>
                        </tr>
                    `);
                });
            });
        });

        const gPUnit = gH > 0 ? gImp / gH : 0;
        $('#total-p-unt-h').text(formatNumber(gPUnit, 2));
        $('#total-peso-h').text(formatNumber(gH));
        $('#total-compra').text(formatNumber(gImp));

        attachTableEvents('tbl-precio-zona');
    }

    function loadComparisonReport() {
        if (filters.anio.length === 0) return;
        $.ajax({
            url: window.baseUrl + '/ajax-comparativo-precios-mensual',
            type: 'POST',
            data: { anio: filters.anio.join(','), centro: filters.centro.join(','), _token: $('#token').val() },
            success: function (response) { renderComparisonReport(response); }
        });
    }

    function renderComparisonReport(data) {
        const $headerCenters = $('#comp-header-centers');
        const $headerMetrics = $('#comp-header-metrics');
        const $tbody = $('#tbl-comparativo-precios tbody');
        const $tfoot = $('#comp-footer');

        $headerCenters.find('th:gt(0)').remove();
        $headerMetrics.empty();
        $tbody.empty();
        $tfoot.empty();

        if (data.length === 0) {
            $tbody.append('<tr><td colspan="10" class="text-center">No hay datos comparativos</td></tr>');
            return;
        }

        const centers = new Set();
        const organized = {}; // { mes: { centro: { h, s, imp } } }
        data.forEach(item => {
            centers.add(item.centro_acopio_nombre);
            if (!organized[item.mes_numero_compra]) organized[item.mes_numero_compra] = {};
            organized[item.mes_numero_compra][item.centro_acopio_nombre] = {
                h: parseFloat(item.total_peso_humedo) || 0,
                s: parseFloat(item.total_peso_seco) || 0,
                imp: parseFloat(item.total_importe) || 0
            };
        });

        const sortedCenters = Array.from(centers).sort();
        sortedCenters.forEach(c => {
            $headerCenters.append(`<th colspan="2" class="text-center border-start border-white-50">${c}</th>`);
            $headerMetrics.append(`<th class="fs-9" style="width:50px;">P. Unit. H</th><th class="fs-9 border-end" style="width:50px;">P. Unit. S</th>`);
        });

        // Add TOTAL column
        $headerCenters.append(`<th colspan="2" class="text-center opacity-75">T. GRAL</th>`);
        $headerMetrics.append(`<th class="fs-9" style="width:60px;">P. Unit. H</th><th class="fs-9 border-end" style="width:60px;">P. Unit. S</th>`);

        const monthNames = ["", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

        for (let m = 1; m <= 12; m++) {
            let rowHtml = `<tr><td class="fw-bold sticky-col-1 border-end-dark">${monthNames[m]}</td>`;
            let mH = 0, mS = 0, mImp = 0;

            sortedCenters.forEach(c => {
                const info = (organized[m] && organized[m][c]) || { h: 0, s: 0, imp: 0 };
                const puH = info.h > 0 ? info.imp / info.h : 0;
                const puS = info.s > 0 ? info.imp / info.s : 0;
                mH += info.h; mS += info.s; mImp += info.imp;
                rowHtml += `<td class="text-end text-primary-value fs-10 bg-metric-h dbl-click-export" data-centro="${c}" data-month="${m}" title="Doble clic para ver detalle">${puH > 0 ? formatNumber(puH, 2) : '-'}</td>`;
                rowHtml += `<td class="text-end text-muted-value fs-10 border-end bg-metric-s">${puS > 0 ? formatNumber(puS, 2) : '-'}</td>`;
            });

            const gPuH = mH > 0 ? mImp / mH : 0;
            const gPuS = mS > 0 ? mImp / mS : 0;
            rowHtml += `<td class="text-end fw-bold">${gPuH > 0 ? formatNumber(gPuH, 2) : '-'}</td>`;
            rowHtml += `<td class="text-end fw-bold border-end">${gPuS > 0 ? formatNumber(gPuS, 2) : '-'}</td></tr>`;
            $tbody.append(rowHtml);
        }

        // Footer Totals
        let footerHtml = `<td class="sticky-col-1 border-end-dark">PROM. ANUAL</td>`;
        let totalYearH = 0, totalYearS = 0, totalYearImp = 0;
        let centersAnnual = {}; // { centro: { h, s, imp } }

        data.forEach(item => {
            if (!centersAnnual[item.centro_acopio_nombre]) centersAnnual[item.centro_acopio_nombre] = { h: 0, s: 0, imp: 0 };
            const a = centersAnnual[item.centro_acopio_nombre];
            a.h += parseFloat(item.total_peso_humedo) || 0;
            a.s += parseFloat(item.total_peso_seco) || 0;
            a.imp += parseFloat(item.total_importe) || 0;
            totalYearH += parseFloat(item.total_peso_humedo) || 0;
            totalYearS += parseFloat(item.total_peso_seco) || 0;
            totalYearImp += parseFloat(item.total_importe) || 0;
        });

        sortedCenters.forEach(c => {
            const a = centersAnnual[c] || { h: 0, s: 0, imp: 0 };
            const puH = a.h > 0 ? a.imp / a.h : 0;
            const puS = a.s > 0 ? a.imp / a.s : 0;
            footerHtml += `<td class="text-end">${puH > 0 ? formatNumber(puH, 2) : '-'}</td>`;
            footerHtml += `<td class="text-end opacity-75 border-end">${puS > 0 ? formatNumber(puS, 2) : '-'}</td>`;
        });

        footerHtml += `<td class="text-end fw-bold">${totalYearH > 0 ? formatNumber(totalYearImp / totalYearH, 2) : '-'}</td>`;
        footerHtml += `<td class="text-end fw-bold opacity-75">${totalYearS > 0 ? formatNumber(totalYearImp / totalYearS, 2) : '-'}</td>`;
        $tfoot.append(footerHtml);

        attachComparisonEvents();
    }

    function attachTableEvents(tableId) {
        $(`#${tableId} .toggle-row`).off('click').on('click', function () {
            const $row = $(this);
            const target = $row.data('target');
            const $icon = $row.find('.exp-icon');
            const isCollapsing = !$row.hasClass('collapsed');

            $row.toggleClass('collapsed');

            if (isCollapsing) {
                // Collapse this level
                $icon.text('chevron_right');
                const $targetRows = $(target);
                $targetRows.fadeOut('fast').addClass('collapsed');

                // Recursively collapse sub-toggles inside the hidden rows
                $targetRows.each(function () {
                    if ($(this).hasClass('toggle-row')) {
                        const subTarget = $(this).data('target');
                        $(this).find('.exp-icon').text('chevron_right');
                        $(subTarget).fadeOut('fast').addClass('collapsed');
                    }
                });
            } else {
                $icon.text('expand_more');
                $(target).fadeIn('fast');
            }
        });

        // Initialize: everything collapsed
        $(`#${tableId} .toggle-row`).addClass('collapsed').find('.exp-icon').text('chevron_right');
        $(`#${tableId} .variedad-group, #${tableId} .child-row`).hide();

        $(`#${tableId} tbody tr`).off('dblclick').on('dblclick', function () {
            const d = $(this).data();
            exportToExcel(d.centro, d.anio, d.zona);
        });
    }

    function attachComparisonEvents() {
        $('#tbl-comparativo-precios tbody td[data-month]').css('cursor', 'pointer').on('dblclick', function () {
            const d = $(this).data();
            const url = window.baseUrl + '/ajax-exportar-detalle-resumen-calidad';
            const params = $.param({ anio: filters.anio.join(','), mes: d.month, centro: d.centro, _token: $('#token').val() });
            window.location.href = url + '?' + params;
        });
    }

    function exportToExcel(centro = null, anio = null, zona = null) {
        const url = window.baseUrl + '/ajax-exportar-detalle-precio-zona';
        const params = $.param({
            anio: filters.anio.join(','),
            mes: filters.mes.join(','),
            centro_filtro: filters.centro.join(','),
            anio_clic: anio,
            centro: centro,
            zona: zona,
            _token: $('#token').val()
        });
        window.location.href = url + '?' + params;
    }

    function formatNumber(num, decimals = 2) { return num.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }); }
    function resetTotals() { $('#total-p-unt-h, #total-peso-h, #total-compra').text('0.00'); }

    // Export Toggles
    setupExportButton('btn-export-price-zona', 'tbl-precio-zona', 'resumen_precio_zona');
    setupExportButton('btn-export-comparison', 'tbl-comparativo-precios', 'comparativo_mensual_precios');

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
});
