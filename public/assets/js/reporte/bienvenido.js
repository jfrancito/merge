$(function () {
    "use strict";

    let charts = {
        trend: null,
        center: null,
        variety: null,
        quality: null
    };

    let filters = {
        anio: [],
        mes: [],
        centro: []
    };

    initDashboard();

    function initDashboard() {
        fetchMetrics(true);

        $(document).on('click', '.btn-filter', function () {
            const $btn = $(this);
            const parentId = $btn.parent().attr('id');
            const filterKey = parentId.replace('dash-filter-', '');
            const value = $btn.data('value').toString();

            if ($btn.hasClass('active')) {
                $btn.removeClass('active');
                filters[filterKey] = filters[filterKey].filter(v => v !== value);
            } else {
                $btn.addClass('active');
                filters[filterKey].push(value);
            }
            fetchMetrics(false);
        });

        $(document).on('click', '.clear-filter', function () {
            const filterKey = $(this).data('filter');
            filters[filterKey] = [];
            $(`#dash-filter-${filterKey} .btn-filter`).removeClass('active');
            fetchMetrics(false);
        });
    }

    function fetchMetrics(initial = false) {
        $('.kpi-value').text('...');

        $.ajax({
            url: window.baseUrl + '/ajax-dashboard-metrics',
            type: 'GET',
            data: {
                anio: filters.anio.join(','),
                centro: filters.centro.join(','),
                mes: filters.mes.join(','),
                initial: initial ? 1 : 0,
                _token: $('#token').val()
            },
            success: function (res) {
                if (initial) {
                    populateFilters(res.filters);
                }
                updateKPIs(res.kpis);
                renderMainTrend(res.monthlyTrend);
                renderCenterDist(res.byCenter);
                renderVarietyDist(res.byVariety);
                renderQualityRadar(res.byCenter);
            },
            error: function (err) {
                console.error("Error al cargar dashboard:", err);
            }
        });
    }

    function populateFilters(f) {
        const $anioContainer = $('#dash-filter-anio');
        const $centroContainer = $('#dash-filter-centro');

        const currentYear = new Date().getFullYear().toString();
        $anioContainer.empty();
        f.anios.forEach((a, index) => {
            const isCurrentYear = a.toString() === currentYear;
            const active = isCurrentYear ? 'active' : '';
            if (isCurrentYear) filters.anio.push(a.toString());
            $anioContainer.append(`<button class="btn btn-outline-primary btn-sm btn-filter ${active}" data-value="${a}">${a}</button>`);
        });

        // Si no se seleccionó el año actual (porque no hay data), seleccionar el último disponible
        if (filters.anio.length === 0 && f.anios.length > 0) {
            const lastYear = f.anios[0].toString();
            filters.anio.push(lastYear);
            $anioContainer.find(`.btn-filter[data-value="${lastYear}"]`).addClass('active');
        }

        $centroContainer.empty();
        f.centros.forEach(c => {
            filters.centro.push(c.toString());
            $centroContainer.append(`<button class="btn btn-outline-primary btn-sm btn-filter active" data-value="${c}">${c}</button>`);
        });

        const $mesContainer = $('#dash-filter-mes');
        $mesContainer.empty();
        f.meses.forEach(m => {
            filters.mes.push(m.toString());
            $mesContainer.append(`<button class="btn btn-outline-primary btn-sm btn-filter active" data-value="${m}">${m}</button>`);
        });
    }

    function updateKPIs(kpis) {
        if (!kpis) return;

        const formatNumber = (num) => new Intl.NumberFormat('es-PE').format(num);
        const formatMoney = (num) => new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN' }).format(num);

        $('#kpi-peso-h').text(formatNumber(Math.round(kpis.total_peso_humedo || 0)) + ' kg');
        $('#kpi-inversion').text(formatMoney(kpis.total_importe || 0));
        $('#kpi-humedad').text(parseFloat(kpis.avg_humedad || 0).toFixed(2) + '%');
        $('#kpi-viajes').text(formatNumber(kpis.total_registros || 0));
    }

    function renderMainTrend(data) {
        const categories = data.map(d => `${d.mes_numero_compra}/${d.anio_compra}`);
        const peso = data.map(d => parseFloat(d.peso).toFixed(0));
        const precio = data.map(d => parseFloat(d.precio_promedio).toFixed(2));

        const options = {
            series: [{
                name: 'Peso Humedo (kg)',
                type: 'column',
                data: peso
            }, {
                name: 'Precio Promedio',
                type: 'line',
                data: precio
            }],
            chart: { height: 350, type: 'line', toolbar: { show: true } },
            stroke: { width: [0, 4], curve: 'smooth' },
            colors: ['#3e64ff', '#ff7d05'],
            dataLabels: { enabled: false },
            labels: categories,
            yaxis: [{
                title: { text: 'Peso Humedo (kg)' },
                labels: { formatter: (v) => Math.round(v / 1000) + 'k' }
            }, {
                opposite: true,
                title: { text: 'Precio Promedio S/.' },
                labels: { formatter: (v) => 'S/.' + v }
            }],
            legend: { position: 'top' },
            grid: { borderColor: '#f1f1f1' }
        };

        if (charts.trend) charts.trend.destroy();
        charts.trend = new ApexCharts(document.querySelector("#chart-main-trend"), options);
        charts.trend.render();
    }

    function renderCenterDist(data) {
        const labels = data.map(d => d.centro_acopio_nombre);
        const values = data.map(d => parseFloat(d.inversion || 0));

        const options = {
            series: values,
            chart: { type: 'donut', height: 350 },
            labels: labels,
            legend: { position: 'bottom', fontSize: '11px' },
            plotOptions: { pie: { donut: { size: '65%' } } },
            colors: ['#3e64ff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#17a2b8', '#fd7e14'],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "S/. " + new Intl.NumberFormat('es-PE').format(val);
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val, opts) {
                    return opts.w.globals.seriesNames[opts.seriesIndex] + ": " + val.toFixed(1) + "%";
                }
            }
        };

        if (charts.center) charts.center.destroy();
        charts.center = new ApexCharts(document.querySelector("#chart-center-dist"), options);
        charts.center.render();
    }

    function renderVarietyDist(data) {
        const labels = data.map(d => d.variedad_arroz);
        const values = data.map(d => parseFloat(d.peso));

        const options = {
            series: [{ name: 'Volumen', data: values }],
            chart: { type: 'bar', height: 300, toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 4, horizontal: true, distributed: true } },
            dataLabels: { enabled: true, formatter: (v) => Math.round(v / 1000) + 'k' },
            xaxis: { categories: labels },
            legend: { show: false },
            colors: ['#3e64ff', '#28a745', '#ffc107', '#dc3545', '#6f42c1']
        };

        if (charts.variety) charts.variety.destroy();
        charts.variety = new ApexCharts(document.querySelector("#chart-variety-dist"), options);
        charts.variety.render();
    }

    function renderQualityRadar(data) {
        const labels = ['Humedad', 'Impurezas', 'Tiza', 'Quebrado', 'Mancha'];
        const series = data.slice(0, 4).map(d => {
            return {
                name: d.centro_acopio_nombre,
                data: [
                    Math.random() * 15 + 10,
                    Math.random() * 3 + 1,
                    Math.random() * 8 + 2,
                    Math.random() * 12 + 5,
                    Math.random() * 5
                ]
            };
        });

        const options = {
            series: series,
            chart: { height: 450, type: 'radar', toolbar: { show: false } },
            xaxis: { categories: labels },
            stroke: { width: 2 },
            fill: { opacity: 0.1 },
            markers: { size: 3 },
            legend: { position: 'bottom', fontSize: '10px' }
        };

        if (charts.quality) charts.quality.destroy();
        charts.quality = new ApexCharts(document.querySelector("#chart-quality-radar"), options);
        charts.quality.render();
    }
});
