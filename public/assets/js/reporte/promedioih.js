$(document).ready(function () {
    const filters = {
        anio: [],
        centro: []
    };

    const MESES = JSON.parse($('#json-meses').val());

    function init() {
        const $lastYearBtn = $('#filter-anio .btn-filter').first();
        if ($lastYearBtn.length) {
            $lastYearBtn.addClass('active');
            filters.anio.push($lastYearBtn.data('value').toString());
        }

        $('#filter-centro .btn-filter').addClass('active');
        $('#filter-centro .btn-filter').each(function () {
            filters.centro.push($(this).data('value').toString());
        });

        $('.btn-filter').on('click', function () {
            const $btn = $(this);
            const type = $btn.parent().attr('id').replace('filter-', '');
            const val = $btn.data('value').toString();
            if ($btn.hasClass('active')) {
                $btn.removeClass('active');
                filters[type] = filters[type].filter(v => v !== val);
            } else {
                $btn.addClass('active');
                filters[type].push(val);
            }
            loadReport();
        });

        $('.clear-filter').on('click', function () {
            const type = $(this).data('filter');
            $(`#filter-${type} .btn-filter`).removeClass('active');
            filters[type] = [];
            loadReport();
        });

        loadReport();
    }

    init();

    function loadReport() {
        if (filters.anio.length === 0) {
            const emptyMsg = '<tr><td colspan="30" class="text-center py-5">Seleccione al menos un año</td></tr>';
            $('#tbl-promedio-ih tbody, #tbl-promedio-ih-anual tbody, #tbl-promedio-is tbody, #tbl-promedio-is-anual tbody, #tbl-promedio-iv tbody, #tbl-promedio-iv-anual tbody, #tbl-promedio-af tbody').html(emptyMsg);
            return;
        }

        const data = {
            anio: filters.anio.join(','),
            centro: filters.centro.join(','),
            _token: $('#token').val()
        };

        const loading = '<tr><td colspan="30" class="text-center py-5">Cargando reporte...</td></tr>';
        $('#tbl-promedio-ih tbody, #tbl-promedio-ih-anual tbody, #tbl-promedio-is tbody, #tbl-promedio-is-anual tbody, #tbl-promedio-iv tbody, #tbl-promedio-iv-anual tbody, #tbl-promedio-af tbody').html(loading);

        $.ajax({
            url: window.baseUrl + '/ajax-listado-promedio-i-h',
            type: 'POST',
            data: data,
            success: function (response) {
                renderPriceReport(response, 'H'); // Humid
                renderPriceReport(response, 'S'); // Seco
                renderPriceReport(response, 'V'); // Variation
                renderAnnualConsolidated(response, 'H');
                renderAnnualConsolidated(response, 'S');
                renderAnnualConsolidated(response, 'V');
                renderPhysicalAnalysis(response);
            }
        });
    }

    function renderPriceReport(data, type) {
        let tableId = 'tbl-promedio-ih';
        if (type === 'S') tableId = 'tbl-promedio-is';
        if (type === 'V') tableId = 'tbl-promedio-iv';

        const $tbody = $(`#${tableId} tbody`);
        $tbody.empty();

        if (data.length === 0) {
            $tbody.html('<tr><td colspan="15" class="text-center py-4">No se encontraron resultados</td></tr>');
            return;
        }

        const organized = organizeData(data);
        const monthTotals = calculateMonthPriceTotals(organized, type);

        const metricClass = type === 'H' ? 'bg-metric-h' : (type === 'S' ? 'bg-metric-s' : '');
        const valueClass = type === 'H' ? 'text-primary-value' : (type === 'S' ? 'text-success' : 'text-warning');

        Object.keys(organized).sort().forEach((centro, cIdx) => {
            const centroId = `${tableId}-centro-${cIdx}`;
            const cSums = calculateCentroSums(organized[centro]);
            const cVal = calculateFinalMetric(cSums, type);

            let centroRow = `<tr class="centro-group toggle-row collapsed" data-target=".${centroId}" style="cursor: pointer;">`;
            centroRow += `<td class="sticky-col-1 border-end-dark fw-bold"><i class="material-symbols-outlined fs-6 align-middle exp-icon">chevron_right</i> ${centro}</td>`;
            centroRow += `<td class="sticky-col-2 border-end-dark text-center"><span class="badge bg-light text-dark border">CENTRO</span></td>`;

            for (let m = 1; m <= 12; m++) {
                const sums = calculateMonthSumsAcrossYears(organized[centro], m);
                const cellVal = calculateFinalMetric(sums, type);
                centroRow += `<td class="text-end fw-semibold ${metricClass} dbl-click-export" data-centro="${centro}" data-mes="${m}">${formatNumber(cellVal, 2, type === 'V')}</td>`;
            }
            centroRow += `<td class="text-end fw-bold ${valueClass} dbl-click-export" data-centro="${centro}" style="background-color: rgba(59, 130, 246, 0.05);">${formatNumber(cVal, 2, type === 'V')}</td>`;
            centroRow += `</tr>`;
            $tbody.append(centroRow);

            Object.keys(organized[centro]).sort((a, b) => b - a).forEach(year => {
                let yearRow = `<tr class="child-row ${centroId}" style="display: none;">`;
                yearRow += `<td class="sticky-col-1 border-end-dark"></td>`;
                yearRow += `<td class="sticky-col-2 border-end-dark text-muted-value ps-3">${year}</td>`;
                const ySums = calculateYearSums(organized[centro][year]);
                const yVal = calculateFinalMetric(ySums, type);

                for (let m = 1; m <= 12; m++) {
                    const d = organized[centro][year][m] || { h: 0, s: 0, imp: 0 };
                    const cellVal = calculateFinalMetric(d, type);
                    yearRow += `<td class="text-end text-muted-value dbl-click-export" data-centro="${centro}" data-anio="${year}" data-mes="${m}">${formatNumber(cellVal, 2, type === 'V')}</td>`;
                }
                yearRow += `<td class="text-end ${valueClass} opacity-75 dbl-click-export" data-centro="${centro}" data-anio="${year}">${formatNumber(yVal, 2, type === 'V')}</td>`;
                yearRow += `</tr>`;
                $tbody.append(yearRow);
            });
        });

        // Footers
        const fPx = type === 'H' ? 'total-m-' : (type === 'S' ? 'total-is-m-' : 'total-iv-m-');
        const gFid = type === 'H' ? 'total-g-total' : (type === 'S' ? 'total-is-g-total' : 'total-iv-g-total');

        for (let m = 1; m <= 12; m++) {
            $(`#${fPx}${m}`).text(formatNumber(monthTotals[m], 2, type === 'V')).addClass('dbl-click-export').attr('data-mes', m);
        }
        $(`#${gFid}`).text(formatNumber(monthTotals.total, 2, type === 'V')).addClass('dbl-click-export');

        attachTableEvents(tableId);
    }

    function renderPhysicalAnalysis(data) {
        const $theadMeses = $('#header-fisico-meses').empty();
        const $tbody = $('#tbl-promedio-af tbody').empty();
        const $tfoot = $('#tbl-promedio-af tfoot tr').empty();

        // Header meshes (12 months + PROM for each block)
        let mHeaders = '';
        ['imp', 'hum'].forEach(metric => {
            MESES.forEach(m => {
                mHeaders += `<th class="text-center font-monospace" style="min-width: 65px; font-size: 10px;">${m.mes_compra.substr(0, 3)}</th>`;
            });
            mHeaders += `<th class="text-center fw-bold border-start-dark bg-light" style="min-width: 70px;">PROM</th>`;
        });
        $theadMeses.html(mHeaders);

        if (data.length === 0) return;

        const organized = organizeData(data);
        const globalSums = { impW: 0, humW: 0, pesoH: 0 };
        const gMonthSums = {};
        for (let m = 1; m <= 12; m++) gMonthSums[m] = { impW: 0, humW: 0, pesoH: 0 };

        Object.keys(organized).sort().forEach((centro, cIdx) => {
            const centroId = `tbl-af-centro-${cIdx}`;
            const cSums = calculateCentroPhysicalSums(organized[centro]);

            let cRow = `<tr class="centro-group toggle-row collapsed" data-target=".${centroId}" style="cursor: pointer;">`;
            cRow += `<td class="sticky-col-1 border-end-dark fw-bold"><i class="material-symbols-outlined fs-6 align-middle exp-icon">chevron_right</i> ${centro}</td>`;
            cRow += `<td class="sticky-col-2 border-end-dark text-center"><span class="badge bg-light text-dark border">CENTRO</span></td>`;

            // Impurezas months
            for (let m = 1; m <= 12; m++) {
                const s = calculateMonthPhysicalSums(organized[centro], m);
                const val = s.pesoH > 0 ? (s.impW / s.pesoH) / 100 : 0;
                cRow += `<td class="text-end fw-semibold cell-imp dbl-click-export" data-centro="${centro}" data-mes="${m}">${formatNumber(val, 2, true)}</td>`;
            }
            const cImpAll = cSums.pesoH > 0 ? (cSums.impW / cSums.pesoH) / 100 : 0;
            cRow += `<td class="text-end fw-bold border-start-dark cell-imp dbl-click-export" data-centro="${centro}">${formatNumber(cImpAll, 2, true)}</td>`;

            // Humedad months
            for (let m = 1; m <= 12; m++) {
                const s = calculateMonthPhysicalSums(organized[centro], m);
                const val = s.pesoH > 0 ? (s.humW / s.pesoH) / 100 : 0;
                cRow += `<td class="text-end fw-semibold cell-hum dbl-click-export border-left-dark" data-centro="${centro}" data-mes="${m}" style="${m == 1 ? '' : 'border-left:none !important;'}">${formatNumber(val, 2, true)}</td>`;
            }
            const cHumAll = cSums.pesoH > 0 ? (cSums.humW / cSums.pesoH) / 100 : 0;
            cRow += `<td class="text-end fw-bold border-start-dark cell-hum dbl-click-export" data-centro="${centro}">${formatNumber(cHumAll, 2, true)}</td>`;
            cRow += `</tr>`;
            $tbody.append(cRow);

            Object.keys(organized[centro]).sort((a, b) => b - a).forEach(year => {
                let yRow = `<tr class="child-row ${centroId}" style="display: none;">`;
                yRow += `<td class="sticky-col-1 border-end-dark"></td>`;
                yRow += `<td class="sticky-col-2 border-end-dark text-muted-value ps-3">${year}</td>`;
                const ySums = { impW: 0, humW: 0, pesoH: 0 };

                for (let m = 1; m <= 12; m++) {
                    const d = organized[centro][year][m] || { impW: 0, humW: 0, pesoH: 0 };
                    ySums.impW += d.impW; ySums.humW += d.humW; ySums.pesoH += d.pesoH;
                    globalSums.impW += d.impW; globalSums.humW += d.humW; globalSums.pesoH += d.pesoH;
                    gMonthSums[m].impW += d.impW; gMonthSums[m].humW += d.humW; gMonthSums[m].pesoH += d.pesoH;
                }

                // Imp Row
                for (let m = 1; m <= 12; m++) {
                    const d = organized[centro][year][m] || { impW: 0, pesoH: 0 };
                    const val = d.pesoH > 0 ? (d.impW / d.pesoH) / 100 : 0;
                    yRow += `<td class="text-end text-muted-value dbl-click-export" data-centro="${centro}" data-anio="${year}" data-mes="${m}">${formatNumber(val, 2, true)}</td>`;
                }
                const yImpAvg = ySums.pesoH > 0 ? (ySums.impW / ySums.pesoH) / 100 : 0;
                yRow += `<td class="text-end fw-bold border-start-dark dbl-click-export" data-centro="${centro}" data-anio="${year}">${formatNumber(yImpAvg, 2, true)}</td>`;

                // Hum Row
                for (let m = 1; m <= 12; m++) {
                    const d = organized[centro][year][m] || { humW: 0, pesoH: 0 };
                    const val = d.pesoH > 0 ? (d.humW / d.pesoH) / 100 : 0;
                    yRow += `<td class="text-end text-muted-value border-left-dark dbl-click-export" data-centro="${centro}" data-anio="${year}" data-mes="${m}" style="${m == 1 ? '' : 'border-left:none !important;'}">${formatNumber(val, 2, true)}</td>`;
                }
                const yHumAvg = ySums.pesoH > 0 ? (ySums.humW / ySums.pesoH) / 100 : 0;
                yRow += `<td class="text-end fw-bold border-start-dark dbl-click-export" data-centro="${centro}" data-anio="${year}">${formatNumber(yHumAvg, 2, true)}</td>`;

                yRow += `</tr>`;
                $tbody.append(yRow);
            });
        });

        // Global Footer
        let fRow = `<td class="sticky-col-1 border-end-dark" colspan="2">PROMEDIO GENERAL</td>`;
        for (let m = 1; m <= 12; m++) {
            const s = gMonthSums[m];
            const val = s.pesoH > 0 ? (s.impW / s.pesoH) / 100 : 0;
            fRow += `<td class="text-end fw-bold dbl-click-export" data-mes="${m}">${formatNumber(val, 2, true)}</td>`;
        }
        const gImpAll = globalSums.pesoH > 0 ? (globalSums.impW / globalSums.pesoH) / 100 : 0;
        fRow += `<td class="text-end fw-extrabold border-start-dark">${formatNumber(gImpAll, 2, true)}</td>`;

        for (let m = 1; m <= 12; m++) {
            const s = gMonthSums[m];
            const val = s.pesoH > 0 ? (s.humW / s.pesoH) / 100 : 0;
            fRow += `<td class="text-end fw-bold border-left-dark dbl-click-export" data-mes="${m}" style="${m == 1 ? '' : 'border-left:none !important;'}">${formatNumber(val, 2, true)}</td>`;
        }
        const gHumAll = globalSums.pesoH > 0 ? (globalSums.humW / globalSums.pesoH) / 100 : 0;
        fRow += `<td class="text-end fw-extrabold border-start-dark">${formatNumber(gHumAll, 2, true)}</td>`;
        $tfoot.html(fRow);

        attachTableEvents('tbl-promedio-af');
    }

    // Helper functions for common logic
    function organizeData(data) {
        const organized = {};
        data.forEach(item => {
            const c = item.centro_acopio_nombre, y = item.anio_compra, m = item.mes_numero_compra;
            if (!organized[c]) organized[c] = {};
            if (!organized[c][y]) organized[c][y] = {};
            organized[c][y][m] = {
                h: parseFloat(item.total_peso_humedo) || 0,
                s: parseFloat(item.total_peso_seco) || 0,
                imp: parseFloat(item.total_importe) || 0,
                impW: parseFloat(item.total_impurezas_w) || 0,
                humW: parseFloat(item.total_humedad_w) || 0,
                pesoH: parseFloat(item.total_peso_humedo) || 0
            };
        });
        return organized;
    }

    function calculateMonthPriceTotals(organized, type) {
        const totals = {};
        for (let m = 1; m <= 12; m++) totals[m] = { h: 0, s: 0, imp: 0 };
        let gH = 0, gS = 0, gImp = 0;

        Object.values(organized).forEach(centroYrs => {
            Object.values(centroYrs).forEach(months => {
                for (let m = 1; m <= 12; m++) {
                    const d = months[m] || { h: 0, s: 0, imp: 0 };
                    totals[m].h += d.h; totals[m].s += d.s; totals[m].imp += d.imp;
                    gH += d.h; gS += d.s; gImp += d.imp;
                }
            });
        });

        const final = { total: calculateFinalMetric({ h: gH, s: gS, imp: gImp }, type) };
        for (let m = 1; m <= 12; m++) final[m] = calculateFinalMetric(totals[m], type);
        return final;
    }

    function calculateFinalMetric(sums, type) {
        if (type === 'H') return sums.h > 0 ? sums.imp / sums.h : 0;
        if (type === 'S') return sums.s > 0 ? sums.imp / sums.s : 0;
        const puh = sums.h > 0 ? sums.imp / sums.h : 0, pus = sums.s > 0 ? sums.imp / sums.s : 0;
        return puh > 0 ? ((pus - puh) / puh) * 100 : 0;
    }

    function calculateCentroSums(centroYears) {
        let h = 0, s = 0, imp = 0;
        Object.values(centroYears).forEach(yearMonths => {
            Object.values(yearMonths).forEach(d => {
                h += d.h; s += d.s; imp += d.imp;
            });
        });
        return { h, s, imp };
    }

    function calculateMonthSumsAcrossYears(centroYears, m) {
        let h = 0, s = 0, imp = 0;
        Object.values(centroYears).forEach(yearMonths => {
            const d = yearMonths[m] || { h: 0, s: 0, imp: 0 };
            h += d.h; s += d.s; imp += d.imp;
        });
        return { h, s, imp };
    }

    function calculateYearSums(yearMonths) {
        let h = 0, s = 0, imp = 0;
        Object.values(yearMonths).forEach(d => {
            h += d.h; s += d.s; imp += d.imp;
        });
        return { h, s, imp };
    }

    function calculateCentroPhysicalSums(centroYears) {
        let impW = 0, humW = 0, pesoH = 0;
        Object.values(centroYears).forEach(yrs => {
            Object.values(yrs).forEach(d => {
                impW += d.impW; humW += d.humW; pesoH += d.pesoH;
            });
        });
        return { impW, humW, pesoH };
    }

    function calculateMonthPhysicalSums(centroYears, m) {
        let impW = 0, humW = 0, pesoH = 0;
        Object.values(centroYears).forEach(yrs => {
            const d = yrs[m] || { impW: 0, humW: 0, pesoH: 0 };
            impW += d.impW; humW += d.humW; pesoH += d.pesoH;
        });
        return { impW, humW, pesoH };
    }

    function renderAnnualConsolidated(data, type) {
        let tableId = 'tbl-promedio-ih-anual';
        if (type === 'S') tableId = 'tbl-promedio-is-anual';
        if (type === 'V') tableId = 'tbl-promedio-iv-anual';
        const $tbody = $(`#${tableId} tbody`).empty();

        const organized = {};
        data.forEach(it => {
            const y = it.anio_compra, m = it.mes_numero_compra;
            if (!organized[y]) organized[y] = {};
            if (!organized[y][m]) organized[y][m] = { h: 0, s: 0, imp: 0 };
            organized[y][m].h += parseFloat(it.total_peso_humedo) || 0;
            organized[y][m].s += parseFloat(it.total_peso_seco) || 0;
            organized[y][m].imp += parseFloat(it.total_importe) || 0;
        });

        const gTotals = {}; for (let m = 1; m <= 12; m++) gTotals[m] = { h: 0, s: 0, imp: 0 };
        const vCls = type === 'H' ? 'text-primary-value' : (type === 'S' ? 'text-success' : 'text-warning');

        Object.keys(organized).sort((a, b) => b - a).forEach(y => {
            const ySums = calculateYearSums(organized[y]);
            const yVal = calculateFinalMetric(ySums, type);
            let row = `<tr><td class="sticky-col-1 border-end-dark fw-bold text-primary">${y}</td>`;
            for (let m = 1; m <= 12; m++) {
                const d = organized[y][m] || { h: 0, s: 0, imp: 0 };
                gTotals[m].h += d.h; gTotals[m].s += d.s; gTotals[m].imp += d.imp;
                row += `<td class="text-end dbl-click-export" data-anio="${y}" data-mes="${m}">${formatNumber(calculateFinalMetric(d, type), 2, type === 'V')}</td>`;
            }
            row += `<td class="text-end fw-bold ${vCls} dbl-click-export" data-anio="${y}" style="background-color: rgba(59, 130, 246, 0.05);">${formatNumber(yVal, 2, type === 'V')}</td></tr>`;
            $tbody.append(row);
        });

        const fPx = type === 'H' ? 'total-anual-m-' : (type === 'S' ? 'total-is-anual-m-' : 'total-iv-anual-m-');
        const gFid = type === 'H' ? 'total-anual-g-total' : (type === 'S' ? 'total-is-anual-g-total' : 'total-iv-anual-g-total');
        let fH = 0, fS = 0, fImp = 0;
        for (let m = 1; m <= 12; m++) {
            fH += gTotals[m].h; fS += gTotals[m].s; fImp += gTotals[m].imp;
            $(`#${fPx}${m}`).text(formatNumber(calculateFinalMetric(gTotals[m], type), 2, type === 'V'));
        }
        $(`#${gFid}`).text(formatNumber(calculateFinalMetric({ h: fH, s: fS, imp: fImp }, type), 2, type === 'V'));
        attachTableEvents(tableId);
    }

    function attachTableEvents(tableId) {
        $(`#${tableId} .toggle-row`).off('click').on('click', function () {
            const $row = $(this), target = $row.data('target'), $icon = $row.find('.exp-icon'), isCollapsing = !$row.hasClass('collapsed');
            $row.toggleClass('collapsed');
            if (isCollapsing) { $icon.text('chevron_right'); $(target).fadeOut('fast').addClass('collapsed'); }
            else { $icon.text('expand_more'); $(target).fadeIn('fast').removeClass('collapsed'); }
        });
        $(`#${tableId} .dbl-click-export`).off('dblclick').on('dblclick', function (e) {
            e.stopPropagation(); const d = $(this).data(); exportDetail(d.centro, d.anio, d.mes);
        });
    }

    function exportDetail(centro = null, anio = null, mes = null) {
        const url = window.baseUrl + '/ajax-exportar-detalle-promedio-ih';
        const params = { centro_filtro: filters.centro.join(','), anio_filtro: filters.anio.join(','), centro_clic: centro, anio_clic: anio, mes_clic: mes, _token: $('#token').val() };
        window.location.href = url + '?' + $.param(params);
    }

    function formatNumber(num, decimals = 2, isPercent = false) {
        if (num === 0) return isPercent ? '0.00%' : '-';
        if (isPercent) return (num * 100).toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }) + '%';
        return num.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
    }

    $('#btn-export-promedio-ih, #btn-export-promedio-ih-anual, #btn-export-promedio-is, #btn-export-promedio-is-anual, #btn-export-promedio-iv, #btn-export-promedio-iv-anual, #btn-export-promedio-af').on('click', function () {
        const tableId = $(this).attr('id').replace('btn-export-', ''), csv = ['\uFEFF'];
        $(`#${tableId} thead tr`).each(function () {
            let hs = []; $(this).find('th').each(function () { let text = $(this).text().trim().replace(/\n/g, ' '), cs = $(this).attr('colspan') || 1; hs.push('"' + text + '"'); for (let i = 1; i < cs; i++) hs.push('""'); });
            csv.push(hs.join(';'));
        });
        $(`#${tableId} tbody tr:visible`).each(function () {
            let rs = []; $(this).find('td').each(function () { let text = $(this).text().trim().replace(/expand_more|chevron_right/g, ''); rs.push('"' + text + '"'); });
            csv.push(rs.join(';'));
        });
        $(`#${tableId} tfoot tr`).each(function () {
            let fs = []; $(this).find('td').each(function () { fs.push('"' + $(this).text().trim() + '"'); });
            csv.push(fs.join(';'));
        });
        const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' }), link = document.createElement("a");
        link.setAttribute("href", URL.createObjectURL(blob)); link.setAttribute("download", `${tableId}.csv`); link.click();
    });
});
