$(function () {
    "use strict";

    let filters = {
        anio: [],
        mes: [],
        centro: []
    };

    let chartPrecios = null;
    let chartVariacion = null;

    init();

    function init() {
        const $lastYearBtn = $('#filter-anio .btn-filter').first();
        if ($lastYearBtn.length) {
            $lastYearBtn.addClass('active');
            filters.anio.push($lastYearBtn.data('value').toString());
        }

        const currentMonth = new Date().getMonth() + 1;
        const $currentMonthBtn = $(`#filter-mes .btn-filter[data-value="${currentMonth}"]`);
        if ($currentMonthBtn.length) {
            $currentMonthBtn.addClass('active');
            filters.mes.push($currentMonthBtn.data('value').toString());
        } else {
            const $lastMonthBtn = $('#filter-mes .btn-filter').last();
            if ($lastMonthBtn.length) {
                $lastMonthBtn.addClass('active');
                filters.mes.push($lastMonthBtn.data('value').toString());
            }
        }

        $('#filter-centro .btn-filter').addClass('active');
        $('#filter-centro .btn-filter').each(function () {
            filters.centro.push($(this).data('value').toString());
        });

        $('.btn-filter').on('click', function () {
            const $btn = $(this);
            const parentId = $btn.parent().attr('id');
            const filterKey = parentId.replace('filter-', '');
            const value = $btn.data('value').toString();

            if ($btn.hasClass('active')) {
                $btn.removeClass('active');
                filters[filterKey] = filters[filterKey].filter(v => v !== value);
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

        loadReport();
    }

    function loadReport() {
        if (filters.anio.length === 0) {
            $('.loading-spinner').hide();
            return;
        }

        $('.loading-spinner').show();

        $.ajax({
            url: window.baseUrl + '/ajax-listado-tendencia',
            type: 'POST',
            data: {
                anio: filters.anio.join(','),
                mes: filters.mes.join(','),
                centro: filters.centro.join(','),
                _token: $('#token').val()
            },
            success: function (response) {
                renderDailyChart(response.daily);
                renderMonthlyChart(response.monthly);
                $('.loading-spinner').hide();
            },
            error: function (xhr) {
                console.error("Error al cargar tendencia:", xhr);
                $('.chart-card div[id^="chart"]').html('<div class="text-center py-5 text-danger">Error al cargar datos</div>');
            }
        });
    }

    function renderDailyChart(data) {
        const days = [];
        const pUnitH = [];
        const pUnitS = [];
        const pUnitM = [];

        data.forEach(item => {
            const totalH = parseFloat(item.total_peso_humedo) || 0;
            const totalS = parseFloat(item.total_peso_seco) || 0;
            const totalImp = parseFloat(item.total_importe) || 0;
            const totalCompPond = parseFloat(item.total_compra_ponderada) || 0;

            days.push(item.dia_numero_compra);
            pUnitH.push(totalH > 0 ? parseFloat((totalImp / totalH).toFixed(2)) : null);
            pUnitS.push(totalS > 0 ? parseFloat((totalImp / totalS).toFixed(2)) : null);
            pUnitM.push(totalH > 0 ? parseFloat((totalCompPond / totalH).toFixed(2)) : null);
        });

        const options = {
            series: [
                { name: 'P Unt H', data: pUnitH },
                { name: 'P Unt S', data: pUnitS },
                { name: 'P Unt M', data: data.some(i => i.total_compra_ponderada > 0) ? pUnitM : [] }
            ],
            chart: { type: 'line', height: 400, zoom: { enabled: false } },
            colors: ['#007bff', '#ff7d05', '#6c757d'],
            stroke: { curve: 'straight', width: 3 },
            markers: { size: 4 },
            xaxis: { type: 'category', categories: days, title: { text: 'Día' } },
            yaxis: {
                title: { text: 'Precio (S/.)' },
                labels: { formatter: val => val ? val.toFixed(2) : '' },
                min: min => Math.max(0, min - 0.2)
            },
            tooltip: { shared: true, y: { formatter: val => val ? "S/. " + val.toFixed(2) : "N/A" } },
            legend: { position: 'top' }
        };

        if (chartPrecios) chartPrecios.destroy();
        chartPrecios = new ApexCharts(document.querySelector("#chart-precios"), options);
        chartPrecios.render();
    }

    function renderMonthlyChart(data) {
        const months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        const pUnitH = [];
        const pUnitS = [];
        const varHS = [];

        const dataMap = {};
        data.forEach(item => {
            dataMap[item.mes_numero_compra] = item;
        });

        months.forEach(m => {
            const item = dataMap[m];
            if (item) {
                const totalH = parseFloat(item.total_peso_humedo) || 0;
                const totalS = parseFloat(item.total_peso_seco) || 0;
                const totalImp = parseFloat(item.total_importe) || 0;

                const valH = totalH > 0 ? parseFloat((totalImp / totalH).toFixed(2)) : 0;
                const valS = totalS > 0 ? parseFloat((totalImp / totalS).toFixed(2)) : 0;
                const diff = parseFloat((valS - valH).toFixed(2));

                pUnitH.push(valH);
                pUnitS.push(valS);
                varHS.push(diff);
            } else {
                pUnitH.push(0);
                pUnitS.push(0);
                varHS.push(0);
            }
        });

        const options = {
            series: [
                { name: 'P Unt H', type: 'column', data: pUnitH },
                { name: 'P Unt S', type: 'column', data: pUnitS },
                { name: 'Var H/S', type: 'column', data: varHS }
            ],
            chart: { type: 'bar', height: 400, toolbar: { show: true } },
            colors: ['#70ad47', '#5b9bd5', '#ffc000'], // Green, Blue, Yellow as in Excel
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded',
                    dataLabels: { position: 'top' }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: val => val > 0 ? val.toFixed(2) : '',
                style: { fontSize: '10px', colors: ['#304758'] },
                offsetY: -20
            },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: { categories: months, title: { text: 'Mes' } },
            yaxis: {
                title: { text: 'Precio / Variación (S/.)' },
                labels: { formatter: val => val.toFixed(2) }
            },
            fill: { opacity: 1 },
            tooltip: { y: { formatter: val => "S/. " + val.toFixed(2) } },
            legend: { position: 'right' }
        };

        if (chartVariacion) chartVariacion.destroy();
        chartVariacion = new ApexCharts(document.querySelector("#chart-variacion-mensual"), options);
        chartVariacion.render();
    }
});
