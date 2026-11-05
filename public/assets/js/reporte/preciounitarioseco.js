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

        setupExportButton('btn-export-pu-seco', 'tbl-pu-seco', 'pu_seco_diario');
        loadReport();
    }

    function loadReport() {
        if (filters.anio.length === 0 || filters.mes.length === 0) {
            $('#tbl-pu-seco tbody').html('<tr><td colspan="150" class="text-center">Seleccione Año y Mes</td></tr>');
            return;
        }

        const url = window.baseUrl + '/ajax-listado-precio-unitario-seco';
        const data = {
            anio: filters.anio.join(','),
            mes: filters.mes.join(','),
            _token: $('#token').val()
        };

        $('#tbl-pu-seco tbody').html('<tr><td colspan="150" class="text-center">Cargando datos... <span class="spinner-border spinner-border-sm"></span></td></tr>');

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (response) {
                if (response.error) {
                    $('#tbl-pu-seco tbody').html('<tr><td colspan="150" class="text-center text-danger">Error: ' + response.error + '</td></tr>');
                } else {
                    renderReport(response);
                }
            },
            error: function (xhr) {
                const msg = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Error desconocido al cargar datos';
                $('#tbl-pu-seco tbody').html('<tr><td colspan="150" class="text-center text-danger">' + msg + '</td></tr>');
            }
        });
    }

    function renderReport(data) {
        const $headerDays = $('#header-days');
        const $headerMetrics = $('#header-metrics');
        const $tbody = $('#tbl-pu-seco tbody');
        const $tfoot = $('#footer-pu-seco');

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
        let headDays = `<th rowspan="2" class="sticky-col-1 border-end-dark text-nowrap">CENTRO ACUMULADO</th>`;
        headDays += `<th rowspan="2" class="sticky-col-2 border-end-dark">VARIEDAD</th>`;

        let headMetrics = '';
        for (let d = 1; d <= maxDay; d++) {
            const label = showWeekdays ? `${d}<br><small class="opacity-75">${weekdayNames[d]}</small>` : d;
            headDays += `<th colspan="3" class="text-center border-start border-white-50">${label}</th>`;
            headMetrics += `
                <th class="fs-10 text-center bg-metric-s" style="width:45px; min-width:45px;">P. Unit. S</th>
                <th class="fs-9 text-center opacity-75" style="width:40px; min-width:40px;">Min</th>
                <th class="fs-9 text-center border-end opacity-75" style="width:40px; min-width:40px;">Max</th>
            `;
        }

        // Add TOTAL header column
        headDays += `<th colspan="3" class="text-center border-start border-success bg-success-transparent text-success">TOTAL PROMEDIO</th>`;
        headMetrics += `
            <th class="fs-10 text-center bg-metric-s fw-bold" style="width:45px; min-width:45px;">P. Unit. S</th>
            <th class="fs-9 text-center opacity-75" style="width:40px; min-width:40px;">Min</th>
            <th class="fs-9 text-center border-end opacity-75" style="width:40px; min-width:40px;">Max</th>
        `;

        $headerDays.append(headDays);
        $headerMetrics.append(headMetrics);

        // 2. Data Organization
        const matrix = {};
        const globalTotals = { s: 0, imp: 0, min: Infinity, max: -Infinity };
        const globalDayTotals = {};
        for (let d = 1; d <= maxDay; d++) {
            globalDayTotals[d] = { s: 0, imp: 0, min: Infinity, max: -Infinity };
        }

        data.forEach(item => {
            const center = item.centro_acopio_nombre;
            const variety = item.variedad_arroz;
            const day = parseInt(item.dia_numero_compra);
            const s = parseFloat(item.total_peso_seco) || 0;
            const imp = parseFloat(item.total_importe) || 0;
            const min = parseFloat(item.min_ps) || 0;
            const max = parseFloat(item.max_ps) || 0;

            if (!matrix[center]) {
                matrix[center] = { totals: { s: 0, imp: 0, min: Infinity, max: -Infinity }, dayTotals: {}, varieties: {} };
                for (let d = 1; d <= maxDay; d++) {
                    matrix[center].dayTotals[d] = { s: 0, imp: 0, min: Infinity, max: -Infinity };
                }
            }

            if (!matrix[center].varieties[variety]) {
                matrix[center].varieties[variety] = { totals: { s: 0, imp: 0, min: Infinity, max: -Infinity }, days: {} };
            }

            matrix[center].varieties[variety].days[day] = { s, imp, min, max };

            // Variety totals
            const vSum = matrix[center].varieties[variety].totals;
            vSum.s += s; vSum.imp += imp;
            if (s > 0) {
                if (min < vSum.min) vSum.min = min;
                if (max > vSum.max) vSum.max = max;
            }

            // Center day totals
            const t = matrix[center].dayTotals[day];
            t.s += s; t.imp += imp;
            if (s > 0) {
                if (min < t.min) t.min = min;
                if (max > t.max) t.max = max;
            }

            // Center overall totals
            const cSum = matrix[center].totals;
            cSum.s += s; cSum.imp += imp;
            if (s > 0) {
                if (min < cSum.min) cSum.min = min;
                if (max > cSum.max) cSum.max = max;
            }

            // Global day totals
            const gdt = globalDayTotals[day];
            gdt.s += s; gdt.imp += imp;
            if (s > 0) {
                if (min < gdt.min) gdt.min = min;
                if (max > gdt.max) gdt.max = max;
            }

            // Global overall totals
            globalTotals.s += s; globalTotals.imp += imp;
            if (s > 0) {
                if (min < globalTotals.min) globalTotals.min = min;
                if (max > globalTotals.max) globalTotals.max = max;
            }
        });

        // 3. Render Body Rows
        Object.keys(matrix).sort().forEach((center, idx) => {
            const centerData = matrix[center];
            const centerId = `center-ps-${idx}`;

            // Center Summary Row
            let centerRow = `<tr class="toggle-row centro-group" style="cursor:pointer;" data-target=".${centerId}">`;
            centerRow += `<td class="sticky-col-1 border-end-dark"><i class="material-symbols-outlined align-middle exp-icon">chevron_right</i> ${center}</td>`;
            centerRow += `<td class="sticky-col-2 border-end-dark text-center"><span class="badge bg-light text-dark border">CENTRO</span></td>`;

            for (let d = 1; d <= maxDay; d++) {
                const t = centerData.dayTotals[d];
                const avg = t.s > 0 ? t.imp / t.s : 0;
                centerRow += `
                    <td class="text-end text-success bg-metric-s fw-semibold">${avg > 0 ? formatNumber(avg, 2) : '-'}</td>
                    <td class="text-end text-muted-value">${t.min !== Infinity ? formatNumber(t.min, 2) : '-'}</td>
                    <td class="text-end text-muted-value border-end">${t.max !== -Infinity ? formatNumber(t.max, 2) : '-'}</td>
                `;
            }
            // Center Total Column
            const cStrSum = centerData.totals;
            const cAvg = cStrSum.s > 0 ? cStrSum.imp / cStrSum.s : 0;
            centerRow += `
                <td class="text-end fw-bold text-success bg-metric-s">${cAvg > 0 ? formatNumber(cAvg, 2) : '-'}</td>
                <td class="text-end text-muted-value fw-bold">${cStrSum.min !== Infinity ? formatNumber(cStrSum.min, 2) : '-'}</td>
                <td class="text-end text-muted-value border-end fw-bold">${cStrSum.max !== -Infinity ? formatNumber(cStrSum.max, 2) : '-'}</td>
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
                    const info = vData.days[d] || { s: 0, imp: 0, min: 0, max: 0 };
                    const puS = info.s > 0 ? info.imp / info.s : 0;
                    varRow += `
                        <td class="text-end text-success" data-center="${center}" data-variedad="${variety}" data-dia="${d}">${puS > 0 ? formatNumber(puS, 2) : '-'}</td>
                        <td class="text-end text-muted-value">${info.min > 0 ? formatNumber(info.min, 2) : '-'}</td>
                        <td class="text-end text-muted-value border-end">${info.max > 0 ? formatNumber(info.max, 2) : '-'}</td>
                    `;
                }
                const vAvg = vData.totals.s > 0 ? vData.totals.imp / vData.totals.s : 0;
                varRow += `
                    <td class="text-end text-success fw-bold">${vAvg > 0 ? formatNumber(vAvg, 2) : '-'}</td>
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
            const avg = g.s > 0 ? g.imp / g.s : 0;
            footerHtml += `
                <td class="text-end fw-bold text-success">${avg > 0 ? formatNumber(avg, 2) : '-'}</td>
                <td class="text-end opacity-75 fs-9">${g.min !== Infinity ? formatNumber(g.min, 2) : '-'}</td>
                <td class="text-end opacity-75 fs-9 border-end">${g.max !== -Infinity ? formatNumber(g.max, 2) : '-'}</td>
            `;
        }
        const gAvg = globalTotals.s > 0 ? globalTotals.imp / globalTotals.s : 0;
        footerHtml += `
            <td class="text-end fw-extrabold text-success">${gAvg > 0 ? formatNumber(gAvg, 2) : '-'}</td>
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
        $('#tbl-pu-seco tbody td[data-dia]').addClass('dbl-click-export');
        $('#tbl-pu-seco tbody td[data-dia]').off('dblclick').on('dblclick', function () {
            const d = $(this).data();
            const url = window.baseUrl + '/ajax-exportar-detalle-preciounitarioseco';
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
