$(document).ready(function () {
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
        const url = window.baseUrl + '/ajax-listado-resumen-calidad';
        const data = {
            anio: filters.anio.join(','),
            mes: filters.mes.join(','),
            centro: filters.centro.join(','),
            _token: $('#token').val()
        };

        const loading = '<tr><td colspan="10" class="text-center py-5"><span class="spinner-border spinner-border-sm"></span> Cargando datos...</td></tr>';
        $('#tbl-resumen-calidad tbody, #tbl-resumen-solo-calidad tbody').html(loading);

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (response) {
                renderReport(response);
                renderQualitySummary(response);
            },
            error: function (xhr) {
                const msg = '<tr><td colspan="10" class="text-center text-danger">Error al cargar datos</td></tr>';
                $('#tbl-resumen-calidad tbody, #tbl-resumen-solo-calidad tbody').html(msg);
            }
        });

        loadMonthlyReport();
        loadPriceQualityReport();
    }

    function renderReport(data) {
        const $tbody = $('#tbl-resumen-calidad tbody');
        $tbody.empty();

        if (data.length === 0) {
            $tbody.append('<tr><td colspan="8" class="text-center">No hay registros</td></tr>');
            resetTotals();
            return;
        }

        const groupedData = {};
        let grandTotalH = 0, grandTotalS = 0, grandTotalImporte = 0;

        data.forEach(item => {
            const h = parseFloat(item.total_peso_humedo) || 0;
            const s = parseFloat(item.total_peso_seco) || 0;
            const imp = parseFloat(item.total_importe) || 0;
            grandTotalH += h; grandTotalS += s; grandTotalImporte += imp;

            if (!groupedData[item.centro_acopio_nombre]) {
                groupedData[item.centro_acopio_nombre] = { totalH: 0, totalS: 0, totalImporte: 0, variedades: {} };
            }
            const c = groupedData[item.centro_acopio_nombre];
            c.totalH += h; c.totalS += s; c.totalImporte += imp;

            if (!c.variedades[item.variedad_arroz]) {
                c.variedades[item.variedad_arroz] = { totalH: 0, totalS: 0, totalImporte: 0, items: [] };
            }
            const v = c.variedades[item.variedad_arroz];
            v.totalH += h; v.totalS += s; v.totalImporte += imp;
            v.items.push(item);
        });

        Object.keys(groupedData).sort().forEach((centroName, cIdx) => {
            const centro = groupedData[centroName];
            const pUnitH = centro.totalH > 0 ? centro.totalImporte / centro.totalH : 0;
            const pUnitS = centro.totalS > 0 ? centro.totalImporte / centro.totalS : 0;
            const varHS = pUnitH > 0 ? ((pUnitS - pUnitH) / pUnitH) * 100 : 0;
            const centroId = `centro-${cIdx}`;

            $tbody.append(`
                <tr class="centro-group toggle-row" data-target=".${centroId}" style="cursor: pointer;">
                    <td class="sticky-col-1 border-end-dark"><i class="material-symbols-outlined fs-6 align-middle exp-icon">chevron_right</i> ${centroName}</td>
                    <td class="sticky-col-2 border-end-dark text-center"><span class="badge bg-light text-dark border">RESUMEN</span></td>
                    <td></td>
                    <td class="text-end fw-bold">${formatNumber(centro.totalH)}</td>
                    <td class="text-end text-primary-value bg-metric-h">${formatNumber(pUnitH, 2)}</td>
                    <td class="text-end fw-bold">${formatNumber(centro.totalS)}</td>
                    <td class="text-end text-primary-value bg-metric-s">${formatNumber(pUnitS, 2)}</td>
                    <td class="text-end fw-bold">${formatNumber(varHS, 2)}%</td>
                </tr>
            `);

            Object.keys(centro.variedades).sort().forEach((variedadName, vIdx) => {
                const variedad = centro.variedades[variedadName];
                const vpUnitH = variedad.totalH > 0 ? variedad.totalImporte / variedad.totalH : 0;
                const vpUnitS = variedad.totalS > 0 ? variedad.totalImporte / variedad.totalS : 0;
                const vVarHS = vpUnitH > 0 ? ((vpUnitS - vpUnitH) / vpUnitH) * 100 : 0;
                const varietyId = `${centroId}-v-${vIdx}`;

                $tbody.append(`
                    <tr class="variedad-group toggle-row ${centroId}" data-target=".${varietyId}" style="cursor: pointer; display: none;">
                        <td class="sticky-col-1 border-end-dark"></td>
                        <td class="sticky-col-2 border-end-dark fw-semibold ps-4"><i class="material-symbols-outlined fs-6 align-middle exp-icon">chevron_right</i> ${variedadName}</td>
                        <td class="text-center"><small class="opacity-50 text-dark">VARIEDAD</small></td>
                        <td class="text-end">${formatNumber(variedad.totalH)}</td>
                        <td class="text-end text-primary-value">${formatNumber(vpUnitH, 2)}</td>
                        <td class="text-end">${formatNumber(variedad.totalS)}</td>
                        <td class="text-end text-primary-value">${formatNumber(vpUnitS, 2)}</td>
                        <td class="text-end fw-bold">${formatNumber(vVarHS, 2)}%</td>
                    </tr>
                `);

                variedad.items.forEach(item => {
                    const iH = parseFloat(item.total_peso_humedo) || 0;
                    const iS = parseFloat(item.total_peso_seco) || 0;
                    const iImp = parseFloat(item.total_importe) || 0;
                    const iPUnitH = iH > 0 ? iImp / iH : 0;
                    const iPUnitS = iS > 0 ? iImp / iS : 0;
                    const iVarHS = iPUnitH > 0 ? ((iPUnitS - iPUnitH) / iPUnitH) * 100 : 0;

                    $tbody.append(`
                        <tr class="child-row ${varietyId} dbl-click-export" data-centro="${centroName}" data-variedad="${variedadName}" data-calidad="${item.calidad}" title="Doble clic para ver detalle" style="display: none;">
                            <td class="sticky-col-1 border-end-dark"></td>
                            <td class="sticky-col-2 border-end-dark"></td>
                            <td class="text-muted ps-4">${item.calidad}</td>
                            <td class="text-end text-muted-value">${formatNumber(iH)}</td>
                            <td class="text-end text-primary-value">${formatNumber(iPUnitH, 2)}</td>
                            <td class="text-end text-muted-value">${formatNumber(iS)}</td>
                            <td class="text-end text-primary-value">${formatNumber(iPUnitS, 2)}</td>
                            <td class="text-end text-muted-value">${formatNumber(iVarHS, 2)}%</td>
                        </tr>
                    `);
                });
            });
        });

        const grandPUnitH = grandTotalH > 0 ? grandTotalImporte / grandTotalH : 0;
        const grandPUnitS = grandTotalS > 0 ? grandTotalImporte / grandTotalS : 0;
        const grandVarHS = grandPUnitH > 0 ? ((grandPUnitS - grandPUnitH) / grandPUnitH) * 100 : 0;

        $('#total-peso-h').text(formatNumber(grandTotalH));
        $('#total-p-unt-h').text(formatNumber(grandPUnitH, 2));
        $('#total-peso-s').text(formatNumber(grandTotalS));
        $('#total-p-unt-s').text(formatNumber(grandPUnitS, 2));
        $('#total-var-hs').text(formatNumber(grandVarHS, 2) + '%');

        attachTableEvents('tbl-resumen-calidad');
    }

    function renderQualitySummary(data) {
        const $tbody = $('#tbl-resumen-solo-calidad tbody');
        $tbody.empty();
        if (data.length === 0) return;

        const qualityData = {};
        let qTotalH = 0, qTotalS = 0, qTotalImporte = 0;

        data.forEach(item => {
            const h = parseFloat(item.total_peso_humedo) || 0, s = parseFloat(item.total_peso_seco) || 0, imp = parseFloat(item.total_importe) || 0;
            qTotalH += h; qTotalS += s; qTotalImporte += imp;
            if (!qualityData[item.calidad]) qualityData[item.calidad] = { totalH: 0, totalS: 0, totalImporte: 0 };
            qualityData[item.calidad].totalH += h; qualityData[item.calidad].totalS += s; qualityData[item.calidad].totalImporte += imp;
        });

        Object.keys(qualityData).sort().forEach(calName => {
            const q = qualityData[calName];
            const pUnitH = q.totalH > 0 ? q.totalImporte / q.totalH : 0;
            const pUnitS = q.totalS > 0 ? q.totalImporte / q.totalS : 0;
            const varHS = pUnitH > 0 ? ((pUnitS - pUnitH) / pUnitH) * 100 : 0;

            $tbody.append(`
                <tr data-calidad="${calName}" class="dbl-click-export" title="Doble clic para ver detalle">
                    <td colspan="3" class="fw-bold text-dark">${calName}</td>
                    <td class="text-end fw-bold">${formatNumber(q.totalH)}</td>
                    <td class="text-end text-primary-value bg-metric-h">${formatNumber(pUnitH, 2)}</td>
                    <td class="text-end fw-bold">${formatNumber(q.totalS)}</td>
                    <td class="text-end text-primary-value bg-metric-s">${formatNumber(pUnitS, 2)}</td>
                    <td class="text-end fw-bold">${formatNumber(varHS, 2)}%</td>
                </tr>
            `);
        });

        const qGrandPUnitH = qTotalH > 0 ? qTotalImporte / qTotalH : 0;
        const qGrandPUnitS = qTotalS > 0 ? qTotalImporte / qTotalS : 0;
        const qGrandVarHS = qGrandPUnitH > 0 ? ((qGrandPUnitS - qGrandPUnitH) / qGrandPUnitH) * 100 : 0;

        $('#total-q-peso-h').text(formatNumber(qTotalH));
        $('#total-q-p-unt-h').text(formatNumber(qGrandPUnitH, 2));
        $('#total-q-peso-s').text(formatNumber(qTotalS));
        $('#total-q-p-unt-s').text(formatNumber(qGrandPUnitS, 2));
        $('#total-q-var-hs').text(formatNumber(qGrandVarHS, 2) + '%');

        $('#tbl-resumen-solo-calidad tbody tr').on('dblclick', function () {
            exportToExcel(null, null, $(this).data('calidad'));
        });
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

        // Initialize state: all collapsed
        $(`#${tableId} .toggle-row`).addClass('collapsed').find('.exp-icon').text('chevron_right');
        $(`#${tableId} .variedad-group, #${tableId} .child-row`).hide();

        $(`#${tableId} tbody tr`).off('dblclick').on('dblclick', function () {
            const d = $(this).data();
            exportToExcel(d.centro, d.variedad, d.calidad);
        });

        $(`#${tableId} tfoot tr`).off('dblclick').on('dblclick', function () {
            exportToExcel();
        });
    }

    // Tab 2 & 3 loading remains similar but with formatted render
    function loadMonthlyReport() {
        if (filters.anio.length === 0) return;
        $.ajax({
            url: window.baseUrl + '/ajax-resumen-mensual',
            type: 'POST',
            data: { anio: filters.anio.join(','), _token: $('#token').val() },
            success: function (response) { renderMonthlyReport(response); }
        });
    }

    function renderMonthlyReport(data) {
        const $tbody = $('#tbl-resumen-mensual tbody');
        $tbody.empty();
        if (data.length === 0) return;

        const organized = {};
        const centers = new Set();
        data.forEach(item => {
            centers.add(item.centro_acopio_nombre);
            if (!organized[item.centro_acopio_nombre]) organized[item.centro_acopio_nombre] = {};
            organized[item.centro_acopio_nombre][item.mes_numero_compra] = { h: parseFloat(item.total_peso_humedo) || 0, imp: parseFloat(item.total_importe) || 0 };
        });

        Array.from(centers).sort().forEach(cName => {
            let rowHtml = `<tr data-centro="${cName}" class="dbl-click-export" title="Doble clic para ver detalle">`;
            rowHtml += `<td class="fw-bold sticky-col-1 border-end-dark">${cName}</td>`;
            let yH = 0, yImp = 0;
            for (let m = 1; m <= 12; m++) {
                const info = organized[cName][m] || { h: 0, imp: 0 };
                const pu = info.h > 0 ? info.imp / info.h : 0;
                yH += info.h; yImp += info.imp;
                rowHtml += `<td class="text-end col-month-${m} text-muted-value" data-month="${m}">${formatNumber(info.h)}</td><td class="text-end text-primary-value col-month-${m} bg-metric-h" data-month="${m}">${formatNumber(pu, 2)}</td>`;
            }
            rowHtml += `<td class="text-end fw-bold">${formatNumber(yH)}</td><td class="text-end fw-bold text-primary-value">${formatNumber(yH > 0 ? yImp / yH : 0, 2)}</td></tr>`;
            $tbody.append(rowHtml);
        });

        renderMonthlyFooter(organized, Array.from(centers));
        applyMonthlyVisibility();
    }

    function renderMonthlyFooter(organized, centers) {
        const $tfootRow = $('#monthly-footer');
        $tfootRow.empty();
        $tfootRow.append('<td class="sticky-col-1 border-end-dark">TOTALES</td>');
        let mTotals = {};
        centers.forEach(c => {
            for (let m = 1; m <= 12; m++) {
                if (!mTotals[m]) mTotals[m] = { h: 0, imp: 0 };
                const d = organized[c][m] || { h: 0, imp: 0 };
                mTotals[m].h += d.h; mTotals[m].imp += d.imp;
            }
        });
        let gH = 0, gImp = 0;
        for (let m = 1; m <= 12; m++) {
            const h = mTotals[m].h;
            gH += h; gImp += mTotals[m].imp;
            $tfootRow.append(`<td class="col-month-${m} text-end">${formatNumber(h)}</td><td class="col-month-${m} text-end opacity-75">${formatNumber(h > 0 ? mTotals[m].imp / h : 0, 2)}</td>`);
        }
        $tfootRow.append(`<td class="text-end">${formatNumber(gH)}</td><td class="fw-bold text-end">${formatNumber(gH > 0 ? gImp / gH : 0, 2)}</td>`);
    }

    // Tendencia Precios
    function loadPriceQualityReport() {
        if (filters.anio.length === 0) return;
        $.ajax({
            url: window.baseUrl + '/ajax-resumen-calidad-mensual',
            type: 'POST',
            data: { anio: filters.anio.join(','), _token: $('#token').val() },
            success: function (response) { renderPriceQualityReport(response); }
        });
    }

    function renderPriceQualityReport(data) {
        const $tbody = $('#tbl-resumen-precios-calidad tbody');
        $tbody.empty();
        if (data.length === 0) return;
        const organized = {};
        const quals = new Set();
        data.forEach(item => {
            quals.add(item.calidad);
            if (!organized[item.calidad]) organized[item.calidad] = {};
            organized[item.calidad][item.mes_numero_compra] = { h: parseFloat(item.total_peso_humedo) || 0, imp: parseFloat(item.total_importe) || 0 };
        });

        Array.from(quals).sort().forEach(qName => {
            let rowHtml = `<tr data-calidad="${qName}" class="dbl-click-export" title="Doble clic para ver detalle">`;
            rowHtml += `<td class="fw-bold text-dark sticky-col-1 border-end-dark">${qName}</td>`;
            let yH = 0, yImp = 0;
            for (let m = 1; m <= 12; m++) {
                const info = organized[qName][m] || { h: 0, imp: 0 };
                const pu = info.h > 0 ? info.imp / info.h : 0;
                yH += info.h; yImp += info.imp;
                rowHtml += `<td class="text-end col-pq-month-${m} text-primary-value" data-month="${m}">${formatNumber(pu, 2)}</td>`;
            }
            rowHtml += `<td class="text-end fw-bold text-primary-value">${formatNumber(yH > 0 ? yImp / yH : 0, 2)}</td></tr>`;
            $tbody.append(rowHtml);
        });
        renderPriceQualityFooter(organized, Array.from(quals));
        applyPQMonthlyVisibility();
    }

    function renderPriceQualityFooter(organized, qualities) {
        const $tfootRow = $('#price-quality-footer');
        $tfootRow.empty();
        $tfootRow.append('<td class="sticky-col-1 border-end-dark">PROM. GRAL</td>');
        let mTotals = {};
        qualities.forEach(q => {
            for (let m = 1; m <= 12; m++) {
                if (!mTotals[m]) mTotals[m] = { h: 0, imp: 0 };
                const d = organized[q][m] || { h: 0, imp: 0 };
                mTotals[m].h += d.h; mTotals[m].imp += d.imp;
            }
        });
        let gH = 0, gImp = 0;
        for (let m = 1; m <= 12; m++) {
            const h = mTotals[m].h;
            gH += h; gImp += mTotals[m].imp;
            $tfootRow.append(`<td class="col-pq-month-${m} text-end">${formatNumber(h > 0 ? mTotals[m].imp / h : 0, 2)}</td>`);
        }
        $tfootRow.append(`<td class="fw-bold text-end">${formatNumber(gH > 0 ? gImp / gH : 0, 2)}</td>`);
    }

    // Helper functions
    function exportToExcel(centro = null, variedad = null, calidad = null) {
        const url = window.baseUrl + '/ajax-exportar-detalle-resumen-calidad';
        const params = $.param({ anio: filters.anio.join(','), mes: filters.mes.join(','), centro_filtro: filters.centro.join(','), centro: centro, variedad: variedad, calidad: calidad, _token: $('#token').val() });
        window.location.href = url + '?' + params;
    }

    function formatNumber(num, decimals = 2) { return num.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }); }
    function resetTotals() { $('#total-peso-h, #total-p-unt-h, #total-peso-s, #total-p-unt-s').text('0.00'); $('#total-var-hs').text('0.00%'); }

    // Visibility togglers
    $('.chk-month-toggle').on('change', applyMonthlyVisibility);
    $('#btn-month-all').on('click', () => { $('.chk-month-toggle').prop('checked', true).trigger('change'); });
    $('#btn-month-none').on('click', () => { $('.chk-month-toggle').prop('checked', false).trigger('change'); });
    function applyMonthlyVisibility() { $('.chk-month-toggle').each(function () { const m = $(this).val(); if ($(this).is(':checked')) $(`.col-month-${m}`).show(); else $(`.col-month-${m}`).hide(); }); }

    $('.chk-pq-month-toggle').on('change', applyPQMonthlyVisibility);
    $('#btn-pq-month-all').on('click', () => { $('.chk-pq-month-toggle').prop('checked', true).trigger('change'); });
    $('#btn-pq-month-none').on('click', () => { $('.chk-pq-month-toggle').prop('checked', false).trigger('change'); });
    function applyPQMonthlyVisibility() { $('.chk-pq-month-toggle').each(function () { const m = $(this).val(); if ($(this).is(':checked')) $(`.col-pq-month-${m}`).show(); else $(`.col-pq-month-${m}`).hide(); }); }

    // Export Buttons logic
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
    setupExportButton('btn-export-summary', 'tbl-resumen-calidad', 'resumen_acopio');
    setupExportButton('btn-export-summary-calidad', 'tbl-resumen-solo-calidad', 'resumen_calidad');
    setupExportButton('btn-export-monthly', 'tbl-resumen-mensual', 'comparativo_mensual');
    setupExportButton('btn-export-price-quality', 'tbl-resumen-precios-calidad', 'precios_calidad');
});
