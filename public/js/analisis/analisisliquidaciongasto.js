$(document).ready(function () {
    var charts = {};
    var datatable = null;

    // Handle Button Filters logic (MULTISELECT)
    $('.filter-btn').on('click', function () {
        var container = $(this).closest('.filter-buttons-container');
        var targetId = container.data('target');

        // Toggle Active Class (allowing multiple)
        $(this).toggleClass('active');

        // Check if at least one is active, if not, maybe it's better to keep at least one?
        // Let's just collect whatever is active.
        updateHiddenValue(targetId);

        // Reload Dashboards
        loadAllDashboards();
    });

    // Select All logic
    $('.select-all').on('click', function () {
        console.log("Evento Seleccionar Todo:", $(this).data('target'));
        var targetId = $(this).data('target');
        var container = $('#container_' + targetId);
        container.find('.filter-btn').addClass('active');
        updateHiddenValue(targetId);
        loadAllDashboards();
    });

    // Deselect All logic
    $('.deselect-all').on('click', function () {
        console.log("Evento Quitar Todo:", $(this).data('target'));
        var targetId = $(this).data('target');
        var container = $('#container_' + targetId);
        container.find('.filter-btn').removeClass('active');
        updateHiddenValue(targetId);
        loadAllDashboards();
    });

    function updateHiddenValue(targetId) {
        var container = $('#container_' + targetId);
        var totalButtons = container.find('.filter-btn').length;
        var activeButtons = container.find('.filter-btn.active');
        var selectedValues = [];

        activeButtons.each(function () {
            selectedValues.push($(this).data('value'));
        });

        // IF ALL ARE SELECTED, SEND EMPTY STRING (NO FILTER = SHOW ALL)
        if (activeButtons.length === totalButtons) {
            $('#' + targetId).val('');
        }
        // IF NONE ARE SELECTED, SEND A DUMMY VALUE TO RETURN NOTHING
        else if (activeButtons.length === 0) {
            $('#' + targetId).val('null');
        }
        else {
            $('#' + targetId).val(selectedValues.join(','));
        }
    }

    // Initialize initial hidden values (since all are active by default)
    $('.filter-buttons-container').each(function () {
        var targetId = $(this).data('target');
        updateHiddenValue(targetId);
    });

    // Handle initial loading
    loadAllDashboards();

    // Event listeners
    $('#btn_actualizar').on('click', function () {
        loadAllDashboards();
    });

    $('select').on('change', function () {
        loadAllDashboards();
    });

    // Load dashboards based on active tab or all?
    // Let's load the active tab and reload on switch
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href").replace('#', '');
        loadDashboard(target);
    });

    function loadAllDashboards() {
        var activeTab = $('.nav-tabs li.active a').attr('href').replace('#', '');
        loadDashboard(activeTab);
    }

    function getFilters() {
        return {
            ano: $('#ano').val(),
            mes: $('#mes').val(),
            empresa_id: $('#empresa_id').val(),
            moneda_id: $('#moneda_id').val(),
            estado_id: $('#estado_id').val(),
            idopcion: $('#idopcion').val(),
            _token: $('#token').val()
        };
    }

    var lastDashboardData = null;
    var lastDashboardType = 'ejecutivo';

    function loadDashboard(tipo) {
        var filters = getFilters();
        var tipoMap = {
            'dashboard1': 'ejecutivo',
            'dashboard2': 'areacentro',
            'dashboard3': 'proveedores',
            'dashboard4': 'responsables',
            'dashboard5': 'detalle'
        };

        var backendTipo = tipoMap[tipo] || 'ejecutivo';
        filters.tipo = backendTipo;
        lastDashboardType = backendTipo;

        var ajaxUrl = $('#ajax_url').val();

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: filters,
            beforeSend: function () {
                $('.btn-filter-action').attr('disabled', true);
                $('#main-loader').css('display', 'flex');
            },
            success: function (data) {
                lastDashboardData = data;
                renderDashboard(backendTipo, data);
            },
            complete: function () {
                $('.btn-filter-action').attr('disabled', false);
                $('#main-loader').css('display', 'none');
            },
            error: function (err) {
                console.error("Error cargando dashboard:", err);
                $('#main-loader').css('display', 'none');
            }
        });
    }

    function getFullAttributeMap(row) {
        return {
            'ID_LIQUIDACION': row.ID_LIQUIDACION || '',
            'SERIE_REGISTRO': row.SERIE_REGISTRO || '',
            'NUMERO_REGISTRO': row.NUMERO_REGISTRO || '',
            'ESTADO_LIQUIDACION': row.ESTADO_LIQUIDACION || '',
            'USUARIO_REGISTRO': row.USUARIO_REGISTRO || '',
            'FECHA_REGISTRO': row.FECHA_REGISTRO || '',
            'ID_EMPRESA': row.ID_EMPRESA || '',
            'NOMBRE_EMPRESA': row.NOMBRE_EMPRESA || '',
            'RUC_EMPRESA': row.RUC_EMPRESA || '',
            'ID_CENTRO_TRABAJO': row.ID_CENTRO_TRABAJO || '',
            'NOMBRE_CENTRO_TRABAJO': row.NOMBRE_CENTRO_TRABAJO || '',
            'ID_AREA_TRABAJO': row.ID_AREA_TRABAJO || '',
            'NOMBRE_AREA_TRABAJO': row.NOMBRE_AREA_TRABAJO || '',
            'ID_TRABAJADOR': row.ID_TRABAJADOR || '',
            'NOMBRE_TRABAJADOR': row.NOMBRE_TRABAJADOR || '',
            'ID_JEFE_AUTORIZA': row.ID_JEFE_AUTORIZA || '',
            'NOMBRE_JEFE_AUTORIZA': row.NOMBRE_JEFE_AUTORIZA || '',
            'FECHA_EMISION': row.FECHA_EMISION || '',
            'ANIO': row.ANIO || '',
            'MES': row.MES || '',
            'MES_NOMBRE': row.MES_NOMBRE || '',
            'SEMANA': row.SEMANA || '',
            'TRIMESTRE': row.TRIMESTRE || '',
            'TIPO_DOCUMENTO': row.TIPO_DOCUMENTO || '',
            'SERIE_DOCUMENTO': row.SERIE_DOCUMENTO || '',
            'NUMERO_DOCUMENTO': row.NUMERO_DOCUMENTO || '',
            'FECHA_DOCUMENTO': row.FECHA_DOCUMENTO || '',
            'ID_PROVEEDOR': row.ID_PROVEEDOR || '',
            'NOMBRE_PROVEEDOR': row.NOMBRE_PROVEEDOR || '',
            'RUC_PROVEEDOR': row.RUC_PROVEEDOR || '',
            'ID_PRODUCTO': row.ID_PRODUCTO || '',
            'NOMBRE_PRODUCTO': row.NOMBRE_PRODUCTO || '',
            'MONEDA': row.MONEDA || '',
            'CANTIDAD': row.CANTIDAD || 0,
            'PRECIO_UNITARIO': row.PRECIO_UNITARIO || 0,
            'SUBTOTAL': row.SUBTOTAL || 0,
            'IMPUESTO': row.IMPUESTO || 0,
            'TOTAL_GENERAL': row.TOTAL_GENERAL || 0
        };
    }

    $('#btn_export_excel').on('click', async function () {
        if (!lastDashboardData) {
            alert("Cargue datos primero");
            return;
        }

        $('#main-loader').css('display', 'flex').find('.loader-text').text('Generando Reporte Visual (Capturando Gráficos)...');

        try {
            const workbook = new ExcelJS.Workbook();
            const sheetCharts = workbook.addWorksheet('Gráficos Visuales');
            const sheetData = workbook.addWorksheet('Detalle de Datos');

            // 1. PROCESS CHARTS
            var activeTabId = $('.nav-tabs li.active a').attr('href');
            var $canvases = $(activeTabId).find('canvas');

            let currentRow = 2;
            sheetCharts.getColumn(2).width = 100; // Wide column for charts

            for (let i = 0; i < $canvases.length; i++) {
                const canvas = $canvases[i];
                const chartImg = canvas.toDataURL('image/png');

                const imageId = workbook.addImage({
                    base64: chartImg,
                    extension: 'png',
                });

                // Title for each chart
                sheetCharts.getRow(currentRow - 1).getCell(2).value = "GRÁFICO: " + ($(canvas).closest('.card').find('.card-header').text().toUpperCase() || "ANALÍTICO");
                sheetCharts.getRow(currentRow - 1).getCell(2).font = { bold: true, size: 12, color: { argb: 'FF2C3E50' } };

                sheetCharts.addImage(imageId, {
                    tl: { col: 1, row: currentRow },
                    ext: { width: 700, height: 400 }
                });

                currentRow += 24; // Skip space for next chart
            }

            // 2. PROCESS DATA
            var rawData = [];
            if (lastDashboardType === 'detalle') {
                rawData = lastDashboardData;
            } else {
                rawData = lastDashboardData.detalle || lastDashboardData;
                if (!Array.isArray(rawData)) rawData = [lastDashboardData];
            }

            const exportData = rawData.map(row => getFullAttributeMap(row));

            if (exportData.length > 0) {
                const columns = Object.keys(exportData[0]).map(key => ({
                    header: key.replace(/_/g, ' '),
                    key: key,
                    width: 20
                }));
                sheetData.columns = columns;
                sheetData.addRows(exportData);

                // Styling headers
                sheetData.getRow(1).font = { bold: true, color: { argb: 'FFFFFFFF' } };
                sheetData.getRow(1).height = 25;
                sheetData.getRow(1).alignment = { vertical: 'middle', horizontal: 'center' };
                sheetData.getRow(1).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FF2C3E50' }
                };
            }

            // Write and Save
            const buffer = await workbook.xlsx.writeBuffer();
            const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            saveAs(blob, "Reporte_Audita_" + lastDashboardType + "_" + moment().format('YYYYMMDD_HHmm') + ".xlsx");

        } catch (e) {
            console.error("Error exportando excel:", e);
            alert("Error al generar el Excel con gráficos");
        } finally {
            $('#main-loader').css('display', 'none').find('.loader-text').text('Actualizando reporte...');
        }
    });

    function renderDashboard(tipo, data) {
        switch (tipo) {
            case 'ejecutivo':
                renderEjecutivo(data);
                break;
            case 'areacentro':
                renderAreaCentro(data);
                break;
            case 'proveedores':
                renderProveedores(data);
                break;
            case 'responsables':
                renderResponsables(data);
                break;
            case 'detalle':
                renderDetalle(data);
                break;
        }
    }

    // --- RENDER FUNCTIONS ---

    function renderEjecutivo(data) {
        $('#kpi_total_general').text('S/ ' + formatNumber(data.total_general));
        $('#kpi_total_documentos').text(data.total_documentos);
        $('#kpi_ticket_promedio').text('S/ ' + formatNumber(data.ticket_promedio));
        $('#kpi_total_trabajadores').text(data.total_trabajadores);
        $('#kpi_max_gasto').text('S/ ' + formatNumber(data.max_gasto));

        // Calculate current month gasto or last month if "All" is selected
        var currentMonth = $('#mes').val();
        var currentYear = $('#ano').val();
        var gastoMes;

        if (currentMonth != '' && currentYear != '') {
            gastoMes = data.evolucion_mensual.find(x => x.MES == currentMonth && x.ANIO == currentYear);
        } else {
            // If "All", show the latest month available in the data
            gastoMes = data.evolucion_mensual[data.evolucion_mensual.length - 1];
        }

        var labelMes = gastoMes ? (gastoMes.MES + '/' + gastoMes.ANIO) : 'del Mes';
        $('#dashboard1 .card-kpi .title:contains("Gastos")').last().text('Gastos ' + labelMes);
        $('#kpi_gasto_mes').text('S/ ' + formatNumber(gastoMes ? gastoMes.total : 0));

        // Charts
        updateChart('evolucion_mensual', 'line', {
            labels: data.evolucion_mensual.map(x => x.MES + '/' + x.ANIO),
            datasets: [{
                label: 'Gasto Mensual',
                data: data.evolucion_mensual.map(x => x.total),
                borderColor: '#5cb85c',
                backgroundColor: 'rgba(92, 184, 92, 0.1)',
                fill: true,
                tension: 0.4
            }]
        });

        updateChart('por_moneda', 'pie', {
            labels: data.por_moneda.map(x => x.MONEDA),
            datasets: [{
                data: data.por_moneda.map(x => x.total),
                backgroundColor: ['#5cb85c', '#428bca', '#f0ad4e']
            }]
        });

        updateChart('tipo_documento', 'doughnut', {
            labels: data.por_tipo_documento.map(x => x.TIPO_DOCUMENTO),
            datasets: [{
                data: data.por_tipo_documento.map(x => x.cantidad),
                backgroundColor: generateColors(data.por_tipo_documento.length)
            }]
        });

        updateChart('top_areas_exec', 'bar', {
            labels: data.top_areas.map(x => x.NOMBRE_AREA_TRABAJO),
            datasets: [{
                label: 'Gasto por Área',
                data: data.top_areas.map(x => x.total),
                backgroundColor: '#5bc0de'
            }]
        }, { indexAxis: 'y' });

        updateChart('top_proveedores_exec', 'bar', {
            labels: data.top_proveedores.map(x => x.NOMBRE_PROVEEDOR),
            datasets: [{
                label: 'Gasto Total',
                data: data.top_proveedores.map(x => x.total),
                backgroundColor: '#428bca'
            }]
        }, { indexAxis: 'y' });
    }

    function renderAreaCentro(data) {
        updateChart('por_area', 'bar', {
            labels: data.por_area.map(x => x.NOMBRE_AREA_TRABAJO),
            datasets: [{
                label: 'Gasto por Área',
                data: data.por_area.map(x => x.total),
                backgroundColor: '#5bc0de'
            }]
        }, { indexAxis: 'y' });

        updateChart('por_centro', 'bar', {
            labels: data.por_centro.map(x => x.NOMBRE_CENTRO_TRABAJO),
            datasets: [{
                label: 'Gasto por Centro',
                data: data.por_centro.map(x => x.total),
                backgroundColor: '#f0ad4e'
            }]
        });
    }

    function renderProveedores(data) {
        updateChart('top_proveedores', 'bar', {
            labels: data.top_proveedores.map(x => x.NOMBRE_PROVEEDOR),
            datasets: [{
                label: 'Top 10 Proveedores',
                data: data.top_proveedores.map(x => x.total),
                backgroundColor: '#428bca'
            }]
        }, { indexAxis: 'y' });

        updateChart('participacion_proveedor', 'doughnut', {
            labels: data.top_proveedores.map(x => x.NOMBRE_PROVEEDOR),
            datasets: [{
                data: data.top_proveedores.map(x => x.total),
                backgroundColor: generateColors(data.top_proveedores.length)
            }]
        });
    }

    function renderResponsables(data) {
        updateChart('por_trabajador', 'bar', {
            labels: data.por_solicitante.slice(0, 10).map(x => x.NOMBRE_TRABAJADOR),
            datasets: [{
                label: 'Ranking Solicitantes',
                data: data.por_solicitante.slice(0, 10).map(x => x.total),
                backgroundColor: '#5cb85c'
            }]
        }, { indexAxis: 'y' });

        updateChart('por_jefe', 'bar', {
            labels: data.por_autorizador.slice(0, 10).map(x => x.NOMBRE_JEFE_AUTORIZA),
            datasets: [{
                label: 'Gasto Autorizado',
                data: data.por_autorizador.slice(0, 10).map(x => x.total),
                backgroundColor: '#d9534f'
            }]
        });
    }

    function renderDetalle(data) {
        if (datatable) {
            datatable.destroy();
        }

        var html = '';
        data.forEach(function (row) {
            html += `<tr>
                <td>${row.ID_LIQUIDACION || ''}</td>
                <td>${row.SERIE_REGISTRO || ''}</td>
                <td>${row.NUMERO_REGISTRO || ''}</td>
                <td><span class="badge ${getStatusBadge(row.ESTADO_LIQUIDACION)}">${row.ESTADO_LIQUIDACION || ''}</span></td>
                <td>${row.USUARIO_REGISTRO || ''}</td>
                <td>${row.FECHA_REGISTRO || ''}</td>
                <td>${row.ID_EMPRESA || ''}</td>
                <td>${row.NOMBRE_EMPRESA || ''}</td>
                <td>${row.RUC_EMPRESA || ''}</td>
                <td>${row.ID_CENTRO_TRABAJO || ''}</td>
                <td>${row.NOMBRE_CENTRO_TRABAJO || ''}</td>
                <td>${row.ID_AREA_TRABAJO || ''}</td>
                <td>${row.NOMBRE_AREA_TRABAJO || ''}</td>
                <td>${row.ID_TRABAJADOR || ''}</td>
                <td>${row.NOMBRE_TRABAJADOR || ''}</td>
                <td>${row.ID_JEFE_AUTORIZA || ''}</td>
                <td>${row.NOMBRE_JEFE_AUTORIZA || ''}</td>
                <td>${row.FECHA_EMISION || ''}</td>
                <td>${row.ANIO || ''}</td>
                <td>${row.MES || ''}</td>
                <td>${row.MES_NOMBRE || ''}</td>
                <td>${row.SEMANA || ''}</td>
                <td>${row.TRIMESTRE || ''}</td>
                <td>${row.TIPO_DOCUMENTO || ''}</td>
                <td>${row.SERIE_DOCUMENTO || ''}</td>
                <td>${row.NUMERO_DOCUMENTO || ''}</td>
                <td>${row.FECHA_DOCUMENTO || ''}</td>
                <td>${row.ID_PROVEEDOR || ''}</td>
                <td>${row.NOMBRE_PROVEEDOR || ''}</td>
                <td>${row.RUC_PROVEEDOR || ''}</td>
                <td>${row.ID_PRODUCTO || ''}</td>
                <td>${row.NOMBRE_PRODUCTO || ''}</td>
                <td>${row.MONEDA || ''}</td>
                <td class="text-right">${formatNumber(row.CANTIDAD || 0)}</td>
                <td class="text-right">${formatNumber(row.PRECIO_UNITARIO || 0)}</td>
                <td class="text-right">${formatNumber(row.SUBTOTAL || 0)}</td>
                <td class="text-right">${formatNumber(row.IMPUESTO || 0)}</td>
                <td class="text-right">${formatNumber(row.TOTAL_GENERAL || 0)}</td>
            </tr>`;
        });

        $('#tbl_detalle tbody').html(html);

        if ($.fn.DataTable.isDataTable('#tbl_detalle')) {
            $('#tbl_detalle').DataTable().destroy();
        }

        datatable = $('#tbl_detalle').DataTable({
            "order": [[0, "desc"]],
            "pageLength": 25,
            "scrollX": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ]
        });
    }

    // --- HELPERS ---

    function updateChart(id, type, chartData, options = {}) {
        var canvas = document.getElementById('chart_' + id);
        if (!canvas) {
            console.warn("Canvas not found for chart ID:", id);
            return;
        }

        if (charts[id]) {
            charts[id].destroy();
        }

        var ctx = canvas.getContext('2d');
        charts[id] = new Chart(ctx, {
            type: type,
            data: chartData,
            options: $.extend(true, {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }, options)
        });
    }

    function formatNumber(num) {
        return parseFloat(num).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function generateColors(len) {
        var colors = ['#5cb85c', '#428bca', '#f0ad4e', '#d9534f', '#5bc0de', '#2b3e50', '#777', '#333', '#8e44ad', '#2c3e50'];
        while (colors.length < len) {
            colors.push('#' + Math.floor(Math.random() * 16777215).toString(16));
        }
        return colors.slice(0, len);
    }

    function getStatusBadge(status) {
        switch (status) {
            case 'APROBADO': return 'badge-success';
            case 'OBSERVADO': return 'badge-warning';
            case 'ANULADO': return 'badge-danger';
            default: return 'badge-default';
        }
    }
});
