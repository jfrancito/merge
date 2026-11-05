$(document).ready(function () {
    const filters = {
        anio: [],
        calidad: []
    };

    function init() {
        const $lastYearBtn = $('#filter-anio .btn-filter').first();
        if ($lastYearBtn.length) {
            $lastYearBtn.addClass('active');
            filters.anio.push($lastYearBtn.data('value').toString());
        }

        $('#filter-calidad .btn-filter').each(function () {
            const val = $(this).data('value').toString();
            filters.calidad.push(val);
            $(this).addClass('active');
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

        loadReport();
    }

    init();

    function loadReport() {
        if (filters.anio.length === 0) return;
        const data = { anio: filters.anio.join(','), calidades: filters.calidad.join(','), _token: $('#token').val() };

        const loading = '<tr><td colspan="4" class="text-center py-5">Cargando...</td></tr>';
        $('#tbl-analisis-pesos tbody, #tbl-analisis-precios tbody').html(loading);

        $.ajax({
            url: window.baseUrl + '/ajax-listado-analisis-precio-calidad',
            type: 'POST',
            data: data,
            success: function (response) {
                renderTable('tbl-analisis-pesos', response, 'peso');
                renderTable('tbl-analisis-precios', response, 'precio');
            }
        });
    }

    function renderTable(tableId, data, metricType) {
        const $table = $(`#${tableId}`);
        const $headerQuals = $table.find('.header-calidades');
        const $headerMetrics = $table.find('.header-metrics');
        const $tbody = $table.find('tbody');
        const $tfoot = $table.find('.footer-analisis');

        $headerQuals.find('th:gt(1)').remove();
        $headerMetrics.empty();
        $tbody.empty();
        $tfoot.empty();

        if (data.length === 0) {
            $tbody.append('<tr><td colspan="10" class="text-center">No hay datos</td></tr>');
            return;
        }

        const selectedQualities = filters.calidad.sort();
        selectedQualities.forEach(q => {
            $headerQuals.append(`<th colspan="2" class="text-center border-start border-white-50">${q}</th>`);
            if (metricType === 'peso') {
                $headerMetrics.append(`<th class="fs-10 text-center" style="width:70px;">Húmedo</th><th class="fs-10 text-center border-end" style="width:70px;">Seco</th>`);
            } else {
                $headerMetrics.append(`<th class="fs-10 text-center" style="width:60px;">P. Unit. H</th><th class="fs-10 text-center border-end" style="width:60px;">P. Unit. S</th>`);
            }
        });

        // Totals Column
        $headerQuals.append(`<th colspan="2" class="text-center opacity-75">T. GRAL</th>`);
        $headerMetrics.append(`<th class="fs-10 text-center" style="width:80px;">Húmedo</th><th class="fs-10 text-center" style="width:80px;">Seco</th>`);

        const organized = {}; // { year: { month: { quality: { h, s, imp } } } }
        data.forEach(item => {
            const y = item.anio_compra, m = item.mes_numero_compra, q = item.calidad;
            if (!organized[y]) organized[y] = {};
            if (!organized[y][m]) organized[y][m] = {};
            organized[y][m][q] = { h: parseFloat(item.total_peso_humedo) || 0, s: parseFloat(item.total_peso_seco) || 0, imp: parseFloat(item.total_importe) || 0 };
        });

        const monthNames = ["", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

        Object.keys(organized).sort().reverse().forEach((year, yIdx) => {
            const yearId = `year-${tableId}-${yIdx}`;

            // Year Summary Row
            let yearRow = `<tr class="centro-group toggle-row" data-target=".${yearId}" style="cursor: pointer;">`;
            yearRow += `<td class="sticky-col-1 border-end-dark"><i class="material-symbols-outlined fs-6 align-middle exp-icon">chevron_right</i> ${year}</td>`;
            yearRow += `<td class="sticky-col-2 border-end-dark text-center"><span class="badge bg-light text-dark border">AÑO</span></td>`;

            let yH_total = 0, yS_total = 0, yImp_total = 0;

            selectedQualities.forEach(q => {
                let qH = 0, qS = 0, qImp = 0;
                for (let m = 1; m <= 12; m++) {
                    const d = (organized[year][m] && organized[year][m][q]) || { h: 0, s: 0, imp: 0 };
                    qH += d.h; qS += d.s; qImp += d.imp;
                }
                yH_total += qH; yS_total += qS; yImp_total += qImp;

                if (metricType === 'peso') {
                    yearRow += `<td class="text-end fw-bold bg-metric-h dbl-click-export" data-anio="${year}" data-calidad="${q}" title="Doble clic para ver detalle">${formatNumber(qH)}</td><td class="text-end fw-bold border-end bg-metric-s dbl-click-export" data-anio="${year}" data-calidad="${q}" title="Doble clic para ver detalle">${formatNumber(qS)}</td>`;
                } else {
                    const puH = qH > 0 ? qImp / qH : 0, puS = qS > 0 ? qImp / qS : 0;
                    yearRow += `<td class="text-end text-primary-value bg-metric-h dbl-click-export" data-anio="${year}" data-calidad="${q}" title="Doble clic para ver detalle">${formatNumber(puH, 2)}</td><td class="text-end text-primary-value border-end bg-metric-s dbl-click-export" data-anio="${year}" data-calidad="${q}" title="Doble clic para ver detalle">${formatNumber(puS, 2)}</td>`;
                }
            });

            if (metricType === 'peso') {
                yearRow += `<td class="text-end fw-bold dbl-click-export" data-anio="${year}" title="Doble clic para ver detalle">${formatNumber(yH_total)}</td><td class="text-end fw-bold dbl-click-export" data-anio="${year}" title="Doble clic para ver detalle">${formatNumber(yS_total)}</td>`;
            } else {
                const yPuH = yH_total > 0 ? yImp_total / yH_total : 0, yPuS = yS_total > 0 ? yImp_total / yS_total : 0;
                yearRow += `<td class="text-end text-primary-value dbl-click-export" data-anio="${year}" title="Doble clic para ver detalle">${formatNumber(yPuH, 2)}</td><td class="text-end text-primary-value dbl-click-export" data-anio="${year}" title="Doble clic para ver detalle">${formatNumber(yPuS, 2)}</td>`;
            }
            yearRow += `</tr>`;
            $tbody.append(yearRow);

            // Months Rows
            for (let m = 1; m <= 12; m++) {
                let mH_total = 0, mS_total = 0, mImp_total = 0;
                let hasData = false;
                selectedQualities.forEach(q => { if (organized[year][m] && organized[year][m][q]) hasData = true; });
                if (!hasData) continue;

                let monthRow = `<tr class="child-row ${yearId}" style="display: none;">`;
                monthRow += `<td class="sticky-col-1 border-end-dark"></td>`;
                monthRow += `<td class="sticky-col-2 border-end-dark ps-3 text-muted-value">${monthNames[m]}</td>`;

                selectedQualities.forEach(q => {
                    const d = (organized[year][m] && organized[year][m][q]) || { h: 0, s: 0, imp: 0 };
                    mH_total += d.h; mS_total += d.s; mImp_total += d.imp;
                    if (metricType === 'peso') {
                        monthRow += `<td class="text-end text-muted-value dbl-click-export" data-anio="${year}" data-mes="${m}" data-calidad="${q}" title="Doble clic para ver detalle">${formatNumber(d.h)}</td><td class="text-end text-muted-value border-end dbl-click-export" data-anio="${year}" data-mes="${m}" data-calidad="${q}" title="Doble clic para ver detalle">${formatNumber(d.s)}</td>`;
                    } else {
                        const puH = d.h > 0 ? d.imp / d.h : 0, puS = d.s > 0 ? d.imp / d.s : 0;
                        monthRow += `<td class="text-end text-primary-value dbl-click-export" data-anio="${year}" data-mes="${m}" data-calidad="${q}" title="Doble clic para ver detalle">${formatNumber(puH, 2)}</td><td class="text-end text-primary-value border-end dbl-click-export" data-anio="${year}" data-mes="${m}" data-calidad="${q}" title="Doble clic para ver detalle">${formatNumber(puS, 2)}</td>`;
                    }
                });

                if (metricType === 'peso') {
                    monthRow += `<td class="text-end opacity-75 dbl-click-export" data-anio="${year}" data-mes="${m}" title="Doble clic para ver detalle">${formatNumber(mH_total)}</td><td class="text-end opacity-75 dbl-click-export" data-anio="${year}" data-mes="${m}" title="Doble clic para ver detalle">${formatNumber(mS_total)}</td>`;
                } else {
                    const mPuH = mH_total > 0 ? mImp_total / mH_total : 0, mPuS = mS_total > 0 ? mImp_total / mS_total : 0;
                    monthRow += `<td class="text-end text-primary-value opacity-75 dbl-click-export" data-anio="${year}" data-mes="${m}" title="Doble clic para ver detalle">${formatNumber(mPuH, 2)}</td><td class="text-end text-primary-value opacity-75 dbl-click-export" data-anio="${year}" data-mes="${m}" title="Doble clic para ver detalle">${formatNumber(mPuS, 2)}</td>`;
                }
                monthRow += `</tr>`;
                $tbody.append(monthRow);
            }
        });

        // Global Footer
        let footH_total = 0, footS_total = 0, footImp_total = 0;
        let footRow = `<td class="sticky-col-1 border-end-dark" colspan="2">TOTAL ACUMULADO</td>`;

        selectedQualities.forEach(q => {
            let qH = 0, qS = 0, qImp = 0;
            data.forEach(item => { if (item.calidad === q) { qH += parseFloat(item.total_peso_humedo) || 0; qS += parseFloat(item.total_peso_seco) || 0; qImp += parseFloat(item.total_importe) || 0; } });
            footH_total += qH; footS_total += qS; footImp_total += qImp;

            if (metricType === 'peso') {
                footRow += `<td class="text-end">${formatNumber(qH)}</td><td class="text-end opacity-75 border-end">${formatNumber(qS)}</td>`;
            } else {
                const puH = qH > 0 ? qImp / qH : 0, puS = qS > 0 ? qImp / qS : 0;
                footRow += `<td class="text-end">${formatNumber(puH, 2)}</td><td class="text-end opacity-75 border-end">${formatNumber(puS, 2)}</td>`;
            }
        });

        if (metricType === 'peso') {
            footRow += `<td class="text-end fw-bold">${formatNumber(footH_total)}</td><td class="text-end fw-bold">${formatNumber(footS_total)}</td>`;
        } else {
            const gPuH = footH_total > 0 ? footImp_total / footH_total : 0, gPuS = footS_total > 0 ? footImp_total / footS_total : 0;
            footRow += `<td class="text-end fw-bold">${formatNumber(gPuH, 2)}</td><td class="text-end fw-bold">${formatNumber(gPuS, 2)}</td>`;
        }
        $tfoot.append(footRow);

        attachTableEvents(tableId);
    }

    function attachTableEvents(tableId) {
        $(`#${tableId} .toggle-row`).off('click').on('click', function () {
            const target = $(this).data('target');
            const $icon = $(this).find('.exp-icon');
            const isCollapsing = !$(this).hasClass('collapsed');

            $(this).toggleClass('collapsed');

            if (isCollapsing) {
                $icon.text('chevron_right');
                $(target).fadeOut('fast');
            } else {
                $icon.text('expand_more');
                $(target).fadeIn('fast');
            }
        });

        // Initialize: everything collapsed
        $(`#${tableId} .toggle-row`).addClass('collapsed').find('.exp-icon').text('chevron_right');
        $(`#${tableId} .child-row`).hide();

        $(`#${tableId} .dbl-click-export`).off('dblclick').on('dblclick', function (e) {
            e.stopPropagation();
            const d = $(this).data();
            const url = window.baseUrl + '/ajax-exportar-detalle-analisis';
            const params = {
                anio: d.anio,
                mes: d.mes,
                calidad: d.calidad,
                _token: $('#token').val()
            };
            window.location.href = url + '?' + $.param(params);
        });
    }

    function formatNumber(num, decimals = 2) {
        if (num === 0) return '-';
        return num.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
    }

    setupExportButton('btn-export-pesos', 'tbl-analisis-pesos', 'analisis_pesos_calidad');
    setupExportButton('btn-export-precios', 'tbl-analisis-precios', 'analisis_precios_calidad');

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
