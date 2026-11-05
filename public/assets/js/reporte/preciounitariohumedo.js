$(function () {
    "use strict";

    let filters = {
        anio: [],
        mes: []
    };

    init();

    function init() {
        const $lastYearBtn = $('#filter-anio .btn-filter').first();
        if ($lastYearBtn.length) {
            $lastYearBtn.addClass('active');
            filters.anio.push($lastYearBtn.data('value'));
        }

        const currentMonth = new Date().getMonth() + 1;
        const $currentMonthBtn = $(`#filter-mes .btn-filter[data-value="${currentMonth}"]`);

        if ($currentMonthBtn.length) {
            $currentMonthBtn.addClass('active');
            filters.mes.push($currentMonthBtn.data('value'));
        } else {
            const $lastMonthBtn = $('#filter-mes .btn-filter').last();
            if ($lastMonthBtn.length) {
                $lastMonthBtn.addClass('active');
                filters.mes.push($lastMonthBtn.data('value'));
            }
        }

        $('.btn-filter').on('click', function () {
            const $btn = $(this);
            const parentId = $btn.parent().attr('id');
            const filterKey = parentId.replace('filter-', '');
            const value = $btn.data('value');

            if ($btn.hasClass('active')) {
                $btn.removeClass('active');
                filters[filterKey] = filters[filterKey].filter(v => typeof v !== 'undefined' && v !== value);
            } else {
                $btn.addClass('active');
                filters[filterKey].push(value);
            }
            loadReport();
        });

        $('.clear-filter').on('click', function () {
            const filterKey = $(this).data('filter');
            filters[filterKey] = [];
            $(`#filter-${filterKey} .btn-filter`).removeClass('active');
            loadReport();
        });

        setupExportButton('btn-export-pu-humedo', 'tbl-pu-humedo', 'pu_humedo_diario');

        loadReport();
    }

    function loadReport() {
        if (filters.anio.length === 0 || filters.mes.length === 0) {
            $('#tbl-pu-humedo tbody').html('<tr><td colspan="150" class="text-center">Seleccione Año y Mes</td></tr>');
            return;
        }

        const url = window.baseUrl + '/ajax-listado-precio-unitario-humedo';
        const data = {
            anio: filters.anio.join(','),
            mes: filters.mes.join(','),
            _token: $('#token').val()
        };

        $('#tbl-pu-humedo tbody').html('<tr><td colspan="150" class="text-center">Cargando datos... <span class="spinner-border spinner-border-sm"></span></td></tr>');

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (response) {
                if (response.error) {
                    $('#tbl-pu-humedo tbody').html('<tr><td colspan="150" class="text-center text-danger">Error: ' + response.error + '</td></tr>');
                } else {
                    renderReport(response);
                }
            },
            error: function (xhr) {
                const msg = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Error desconocido al cargar datos';
                $('#tbl-pu-humedo tbody').html('<tr><td colspan="150" class="text-center text-danger">' + msg + '</td></tr>');
            }
        });
    }

    function renderReport(data) {
        const $headerDays = $('#header-days');
        const $headerMetrics = $('#header-metrics');
        const $tbody = $('#tbl-pu-humedo tbody');
        const $tfoot = $('#footer-pu-humedo');

        $headerDays.empty();
        $headerMetrics.empty();
        $tbody.empty();
        $tfoot.empty();

        if (data.length === 0) {
            $tbody.append('<tr><td colspan="150" class="text-center">No hay registros para la selección</td></tr>');
            return;
        }

        let maxDay = 31;
        let showWeekdays = false;
        let weekdayNames = [];

        if (filters.anio.length === 1 && filters.mes.length === 1) {
            const y = parseInt(filters.anio[0]);
            const m = parseInt(filters.mes[0]);
            maxDay = new Date(y, m, 0).getDate();
            showWeekdays = true;
            for (let d = 1; d <= maxDay; d++) {
                const date = new Date(y, m - 1, d);
                weekdayNames[d] = date.toLocaleDateString('es-ES', { weekday: 'short' }).toUpperCase();
            }
        }

        // 1. Render Headers
        let headDays = `<th rowspan="2" class="sticky-col-1 border-end-dark">CENTRO ACUMULADO</th>`;
        headDays += `<th rowspan="2" class="sticky-col-2 border-end-dark">VARIEDAD</th>`;

        let headMetrics = '';
        for (let d = 1; d <= maxDay; d++) {
            const label = showWeekdays ? `${d}<br><small class="opacity-75">${weekdayNames[d]}</small>` : d;
            headDays += `<th colspan="3" class="text-center border-start border-white-50">${label}</th>`;
            headMetrics += `
                <th class="fs-10 text-center" style="width:45px; min-width:45px;">P. Unit. H</th>
                <th class="fs-9 text-center opacity-75" style="width:40px; min-width:40px;">Min</th>
                <th class="fs-9 text-center border-end opacity-75" style="width:40px; min-width:40px;">Max</th>
            `;
        }

        // Add TOTAL header column
        headDays += `<th colspan="3" class="text-center border-start border-primary bg-primary-transparent text-primary">TOTAL PROMEDIO</th>`;
        headMetrics += `
            <th class="fs-10 text-center bg-metric-h fw-bold" style="width:45px; min-width:45px;">P. Unit. H</th>
            <th class="fs-9 text-center opacity-75" style="width:40px; min-width:40px;">Min</th>
            <th class="fs-9 text-center border-end opacity-75" style="width:40px; min-width:40px;">Max</th>
        `;

        $headerDays.append(headDays);
        $headerMetrics.append(headMetrics);

        // 2. Data Organization
        const matrix = {};
        const globalTotals = { h: 0, imp: 0, min: Infinity, max: -Infinity };
        const globalDayTotals = {};
        for (let d = 1; d <= maxDay; d++) {
            globalDayTotals[d] = { h: 0, imp: 0, min: Infinity, max: -Infinity };
        }

        data.forEach(item => {
            const center = item.centro_acopio_nombre;
            const variety = item.variedad_arroz;
            const day = parseInt(item.dia_numero_compra);
            const h = parseFloat(item.total_peso_humedo) || 0;
            const imp = parseFloat(item.total_importe) || 0;
            const min = parseFloat(item.min_ph) || 0;
            const max = parseFloat(item.max_ph) || 0;

            if (!matrix[center]) {
                matrix[center] = { totals: { h: 0, imp: 0, min: Infinity, max: -Infinity }, dayTotals: {}, varieties: {} };
                for (let d = 1; d <= maxDay; d++) {
                    matrix[center].dayTotals[d] = { h: 0, imp: 0, min: Infinity, max: -Infinity };
                }
            }

            if (!matrix[center].varieties[variety]) {
                matrix[center].varieties[variety] = { totals: { h: 0, imp: 0, min: Infinity, max: -Infinity }, days: {} };
            }

            matrix[center].varieties[variety].days[day] = { h, imp, min, max };

            // Update variety totals
            const vSum = matrix[center].varieties[variety].totals;
            vSum.h += h; vSum.imp += imp;
            if (h > 0) {
                if (min < vSum.min) vSum.min = min;
                if (max > vSum.max) vSum.max = max;
            }

            // Update center day totals
            const t = matrix[center].dayTotals[day];
            t.h += h; t.imp += imp;
            if (h > 0) {
                if (min < t.min) t.min = min;
                if (max > t.max) t.max = max;
            }

            // Update center overall totals
            const cSum = matrix[center].totals;
            cSum.h += h; cSum.imp += imp;
            if (h > 0) {
                if (min < cSum.min) cSum.min = min;
                if (max > cSum.max) cSum.max = max;
            }

            // Update global day totals
            const gdt = globalDayTotals[day];
            gdt.h += h; gdt.imp += imp;
            if (h > 0) {
                if (min < gdt.min) gdt.min = min;
                if (max > gdt.max) gdt.max = max;
            }

            // Update global overall totals
            globalTotals.h += h; globalTotals.imp += imp;
            if (h > 0) {
                if (min < globalTotals.min) globalTotals.min = min;
                if (max > globalTotals.max) globalTotals.max = max;
            }
        });

        // 3. Render Body Rows
        Object.keys(matrix).sort().forEach((center, idx) => {
            const centerData = matrix[center];
            const centerId = `center-${idx}`;

            // Center Summary Row
            let centerRow = `<tr class="toggle-row centro-group" style="cursor:pointer;" data-target=".${centerId}">`;
            centerRow += `<td class="sticky-col-1 border-end-dark"><i class="material-symbols-outlined align-middle exp-icon">chevron_right</i> ${center}</td>`;
            centerRow += `<td class="sticky-col-2 border-end-dark text-center"><span class="badge bg-light text-dark border">CENTRO</span></td>`;

            for (let d = 1; d <= maxDay; d++) {
                const t = centerData.dayTotals[d];
                const avg = t.h > 0 ? t.imp / t.h : 0;
                centerRow += `
                    <td class="text-end text-primary-value bg-metric-h">${avg > 0 ? formatNumber(avg, 2) : '-'}</td>
                    <td class="text-end text-muted-value">${t.min !== Infinity ? formatNumber(t.min, 2) : '-'}</td>
                    <td class="text-end text-muted-value border-end">${t.max !== -Infinity ? formatNumber(t.max, 2) : '-'}</td>
                `;
            }
            // Center Total Column
            const cAvg = centerData.totals.h > 0 ? centerData.totals.imp / centerData.totals.h : 0;
            centerRow += `
                <td class="text-end fw-bold text-primary-value bg-metric-h">${cAvg > 0 ? formatNumber(cAvg, 2) : '-'}</td>
                <td class="text-end text-muted-value fw-bold">${centerData.totals.min !== Infinity ? formatNumber(centerData.totals.min, 2) : '-'}</td>
                <td class="text-end text-muted-value border-end fw-bold">${centerData.totals.max !== -Infinity ? formatNumber(centerData.totals.max, 2) : '-'}</td>
            `;
            centerRow += `</tr>`;
            $tbody.append(centerRow);

            // Variety Child Rows
            Object.keys(centerData.varieties).sort().forEach(variety => {
                const vData = centerData.varieties[variety];
                let varRow = `<tr class="${centerId} child-row" style="display:none;">`;
                varRow += `<td class="sticky-col-1 border-end-dark"></td>`;
                varRow += `<td class="sticky-col-2 border-end-dark fw-medium ps-4">${variety}</td>`;

                for (let d = 1; d <= maxDay; d++) {
                    const info = vData.days[d] || { h: 0, imp: 0, min: 0, max: 0 };
                    const puH = info.h > 0 ? info.imp / info.h : 0;
                    varRow += `
                        <td class="text-end text-primary-value" data-center="${center}" data-variedad="${variety}" data-dia="${d}">${puH > 0 ? formatNumber(puH, 2) : '-'}</td>
                        <td class="text-end text-muted-value">${info.min > 0 ? formatNumber(info.min, 2) : '-'}</td>
                        <td class="text-end text-muted-value border-end">${info.max > 0 ? formatNumber(info.max, 2) : '-'}</td>
                    `;
                }
                const vAvg = vData.totals.h > 0 ? vData.totals.imp / vData.totals.h : 0;
                varRow += `
                    <td class="text-end text-primary-value fw-bold">${vAvg > 0 ? formatNumber(vAvg, 2) : '-'}</td>
                    <td class="text-end text-muted-value">${vData.totals.min !== Infinity ? formatNumber(vData.totals.min, 2) : '-'}</td>
                    <td class="text-end text-muted-value border-end">${vData.totals.max !== -Infinity ? formatNumber(vData.totals.max, 2) : '-'}</td>
                `;
                varRow += `</tr>`;
                $tbody.append(varRow);
            });
        });

        // 4. Render Footer Totals
        let footerHtml = `<td class="sticky-col-1 fw-bold">TOTAL</td>`;
        footerHtml += `<td class="sticky-col-2 fw-bold border-end-dark">GENERAL</td>`;
        for (let d = 1; d <= maxDay; d++) {
            const g = globalDayTotals[d];
            const avg = g.h > 0 ? g.imp / g.h : 0;
            footerHtml += `
                <td class="text-end fw-bold">${avg > 0 ? formatNumber(avg, 2) : '-'}</td>
                <td class="text-end opacity-75 fs-9">${g.min !== Infinity ? formatNumber(g.min, 2) : '-'}</td>
                <td class="text-end opacity-75 fs-9 border-end">${g.max !== -Infinity ? formatNumber(g.max, 2) : '-'}</td>
            `;
        }
        const gAvg = globalTotals.h > 0 ? globalTotals.imp / globalTotals.h : 0;
        footerHtml += `
            <td class="text-end fw-extrabold text-primary">${gAvg > 0 ? formatNumber(gAvg, 2) : '-'}</td>
            <td class="text-end opacity-75 fs-9 fw-bold">${globalTotals.min !== Infinity ? formatNumber(globalTotals.min, 2) : '-'}</td>
            <td class="text-end opacity-75 fs-9 border-end fw-bold">${globalTotals.max !== -Infinity ? formatNumber(globalTotals.max, 2) : '-'}</td>
        `;
        $tfoot.append(footerHtml);

        attachEvents();
    }

    function attachEvents() {
        $('.toggle-row').off('click').on('click', function () {
            const target = $(this).data('target');
            const $icon = $(this).find('.exp-icon');
            if ($icon.text().trim() === 'chevron_right') {
                $icon.text('expand_more'); $(target).show();
            } else {
                $icon.text('chevron_right'); $(target).hide();
            }
        });
        $('#tbl-pu-humedo tbody td[data-dia]').addClass('dbl-click-export');
        $('#tbl-pu-humedo tbody td[data-dia]').off('dblclick').on('dblclick', function () {
            const d = $(this).data();
            const url = window.baseUrl + '/ajax-exportar-detalle-preciounitario-humedo';
            const params = { anio: filters.anio.join(','), mes: filters.mes.join(','), centro: d.center, variedad: d.variedad, dia: d.dia, _token: $('#token').val() };
            window.location.href = url + '?' + $.param(params);
        });
    }

    function formatNumber(num, decimals = 0) {
        return new Intl.NumberFormat('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }).format(num);
    }

    function setupExportButton(btnId, tableId, filename) {
        $(`#${btnId}`).on('click', function () {
            let csv = [];
            const rows = document.getElementById(tableId).querySelectorAll("tr");
            for (let i = 0; i < rows.length; i++) {
                if (rows[i].offsetParent === null) continue;
                let row = [], cols = rows[i].querySelectorAll("td, th");
                for (let j = 0; j < cols.length; j++) {
                    let text = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
                    text = text.replace(/"/g, '""');
                    row.push('"' + text + '"');
                }
                csv.push(row.join(";"));
            }
            const blob = new Blob(["\ufeff" + csv.join("\n")], { type: "text/csv;charset=utf-8;" });
            const link = document.createElement("a");
            link.download = filename + "_" + new Date().getTime() + ".csv";
            link.href = window.URL.createObjectURL(blob);
            link.style.display = "none";
            document.body.appendChild(link);
            link.click();
        });
    }
});
