$(document).ready(function () {
    var charts = {};
    var datatable = null;
    var lastDashboardData = { f1: null, f2: null };
    var lastDashboardType = { f1: 'ejecutivo', f2: 'comparativos' };

    // --- FILTER LOGIC (PREFIXED) ---

    $('.filter-btn').on('click', function () {
        var container = $(this).closest('.filter-buttons-container');
        var targetId = container.data('target');
        var selectType = container.data('select') || 'multi';

        if (selectType === 'single') {
            container.find('.filter-btn').removeClass('active');
            $(this).addClass('active');
        } else {
            $(this).toggleClass('active');
        }

        updateHiddenValue(targetId);
        reloadActivePhase();
    });

    $('.f-select-all').on('click', function () {
        var targetId = $(this).data('target');
        $('#container_' + targetId).find('.filter-btn').addClass('active');
        updateHiddenValue(targetId);
        reloadActivePhase();
    });

    $('.f-deselect-all').on('click', function () {
        var targetId = $(this).data('target');
        $('#container_' + targetId).find('.filter-btn').removeClass('active');
        updateHiddenValue(targetId);
        reloadActivePhase();
    });

    function updateHiddenValue(targetId) {
        var container = $('#container_' + targetId);
        var totalButtons = container.find('.filter-btn').length;
        var activeButtons = container.find('.filter-btn.active');
        var selectedValues = [];

        activeButtons.each(function () {
            selectedValues.push($(this).data('value'));
        });

        if (activeButtons.length === totalButtons) {
            $('#' + targetId).val('');
        } else if (activeButtons.length === 0) {
            $('#' + targetId).val('null');
        } else {
            $('#' + targetId).val(selectedValues.join(','));
        }
    }

    // Initialize all hidden values
    $('.filter-buttons-container').each(function () {
        updateHiddenValue($(this).data('target'));
    });

    // --- DASHBOARD LOADING ---

    function getActivePhase() {
        return $('#fase1_operativo').hasClass('active') ? 'f1' : 'f2';
    }

    function reloadActivePhase() {
        var phase = getActivePhase();
        if (phase === 'f1') {
            var activeSubTab = $('#fase1_operativo .nav-tabs li.active a').attr('href').replace('#', '');
            loadDashboard(activeSubTab, 'f1');
        } else {
            loadDashboard('dashboard7', 'f2');
        }
    }

    // Handle Tab Changes
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href").replace('#', '');
        if (target === 'fase1_operativo' || target === 'fase2_comparativo') {
            reloadActivePhase();
        } else if (target.startsWith('dashboard')) {
            loadDashboard(target, 'f1');
        }
    });

    function getFilters(phase) {
        var filters = {
            idopcion: $('#idopcion').val(),
            _token: $('#token').val()
        };

        if (phase === 'f1') {
            filters.ano = $('#f1_ano').val();
            filters.mes = $('#f1_mes').val();
            filters.empresa_id = $('#f1_empresa_id').val();
            filters.moneda_id = $('#f1_moneda_id').val();
            filters.estado_id = $('#f1_estado_id').val();
        } else {
            filters.ano = $('#f2_ano').val();
            filters.mes = $('#f2_mes').val();
            filters.empresa_id = $('#f2_empresa_id').val();
            filters.moneda_id = $('#f2_moneda_id').val();
            filters.centro_id = $('#f2_centro_id').val();
            filters.area_id = $('#f2_area_id').val();
            filters.comparar_vs = $('#comparar_vs').val();
        }
        return filters;
    }

    function loadDashboard(tabId, phase) {
        var filters = getFilters(phase);
        var tipoMap = {
            'dashboard1': 'ejecutivo',
            'dashboard2': 'areacentro',
            'dashboard3': 'proveedores',
            'dashboard4': 'responsables',
            'dashboard6': 'productos',
            'dashboard7': 'comparativos',
            'dashboard5': 'detalle'
        };

        var backendTipo = tipoMap[tabId] || 'ejecutivo';
        filters.tipo = backendTipo;
        lastDashboardType[phase] = backendTipo;

        var loader = (phase === 'f1') ? $('#loader_f1') : $('#loader_f2');
        var ajaxUrl = $('#ajax_url').val();

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: filters,
            beforeSend: function () {
                loader.css('display', 'flex');
            },
            success: function (data) {
                lastDashboardData[phase] = data;
                renderDashboard(backendTipo, data);
            },
            complete: function () {
                loader.css('display', 'none');
            },
            error: function (err) {
                console.error("Error cargando dashboard:", err);
                loader.css('display', 'none');
            }
        });
    }

    // --- EXPORT LOGIC ---

    $('.btn-download-excel').on('click', async function () {
        var phase = $(this).attr('id') === 'btn_export_excel_f1' ? 'f1' : 'f2';
        var data = lastDashboardData[phase];
        var type = lastDashboardType[phase];

        if (!data) {
            alert("No hay datos para exportar");
            return;
        }

        var loader = (phase === 'f1') ? $('#loader_f1') : $('#loader_f2');
        loader.css('display', 'flex').find('.loader-text').text('Generando Excel...');

        try {
            const workbook = new ExcelJS.Workbook();
            const sheetCharts = workbook.addWorksheet('Gráficos Visuales');
            const sheetData = workbook.addWorksheet('Detalle de Datos');

            // Find charts in active phase content
            var containerId = (phase === 'f1') ? '#fase1_operativo' : '#fase2_comparativo';
            var activeTabSelector = (phase === 'f1') ? $('.nav-tabs li.active a[href^="#dashboard"]').attr('href') : '#dashboard7_container';

            var $canvases = $(containerId).find(activeTabSelector).find('canvas');
            if (phase === 'f2') $canvases = $('#dashboard7_container').find('canvas');

            let currentRow = 2;
            sheetCharts.getColumn(2).width = 100;

            for (let i = 0; i < $canvases.length; i++) {
                const canvas = $canvases[i];
                const chartImg = canvas.toDataURL('image/png');
                const imageId = workbook.addImage({ base64: chartImg, extension: 'png' });

                sheetCharts.getRow(currentRow - 1).getCell(2).value = "REPORTE: " + ($(canvas).closest('.card').find('.card-header').text().toUpperCase() || "ANÁLISIS");
                sheetCharts.getRow(currentRow - 1).getCell(2).font = { bold: true, size: 12 };

                sheetCharts.addImage(imageId, { tl: { col: 1, row: currentRow }, ext: { width: 700, height: 400 } });
                currentRow += 24;
            }

            // Data Sheet
            var rawData = (type === 'detalle') ? data : (data.detalle || []);
            if (!Array.isArray(rawData)) rawData = [data];

            const exportData = rawData.map(row => getFullAttributeMap(row));
            if (exportData.length > 0) {
                sheetData.columns = Object.keys(exportData[0]).map(k => ({ header: k.replace(/_/g, ' '), key: k, width: 20 }));
                sheetData.addRows(exportData);
                sheetData.getRow(1).font = { bold: true, color: { argb: 'FFFFFFFF' } };
                sheetData.getRow(1).fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF2C3E50' } };
            }

            const buffer = await workbook.xlsx.writeBuffer();
            saveAs(new Blob([buffer]), "Reporte_" + phase.toUpperCase() + "_" + type + "_" + moment().format('YYYYMMDD') + ".xlsx");
        } catch (e) {
            console.error("Export Error:", e);
            alert("Error al exportar");
        } finally {
            loader.css('display', 'none').find('.loader-text').text('Procesando...');
        }
    });

    // --- RENDERING ---

    function renderDashboard(tipo, data) {
        switch (tipo) {
            case 'ejecutivo': renderEjecutivo(data); break;
            case 'areacentro': renderAreaCentro(data); break;
            case 'proveedores': renderProveedores(data); break;
            case 'responsables': renderResponsables(data); break;
            case 'productos': renderProductos(data); break;
            case 'comparativos': renderComparativos(data); break;
            case 'detalle': renderDetalle(data); break;
        }
    }

    function renderEjecutivo(data) {
        $('#kpi_total_general').text('S/ ' + formatNumber(data.total_general));
        $('#kpi_total_documentos').text(data.total_documentos);
        $('#kpi_ticket_promedio').text('S/ ' + formatNumber(data.ticket_promedio));
        $('#kpi_total_trabajadores').text(data.total_trabajadores);

        updateChart('evolucion_mensual', 'line', {
            labels: data.evolucion_mensual.map(x => x.MES + '/' + x.ANIO),
            datasets: [{ label: 'Gasto Mensual', data: data.evolucion_mensual.map(x => x.total), borderColor: '#5cb85c', backgroundColor: 'rgba(92, 184, 92, 0.1)', fill: true, tension: 0.4 }]
        });

        updateChart('por_moneda', 'pie', {
            labels: data.por_moneda.map(x => x.MONEDA),
            datasets: [{ data: data.por_moneda.map(x => x.total), backgroundColor: ['#5cb85c', '#428bca', '#f0ad4e'] }]
        });

        updateChart('tipo_documento', 'doughnut', {
            labels: data.por_tipo_documento.map(x => x.TIPO_DOCUMENTO),
            datasets: [{ data: data.por_tipo_documento.map(x => x.cantidad), backgroundColor: generateColors(data.por_tipo_documento.length) }]
        });

        updateChart('top_areas_exec', 'bar', {
            labels: data.top_areas.map(x => x.NOMBRE_AREA_TRABAJO),
            datasets: [{ label: 'Gasto por Área', data: data.top_areas.map(x => x.total), backgroundColor: '#5bc0de' }]
        }, { indexAxis: 'y' });
    }

    function renderAreaCentro(data) {
        updateChart('por_area', 'bar', {
            labels: data.por_area.map(x => x.NOMBRE_AREA_TRABAJO),
            datasets: [{ label: 'Gasto por Área', data: data.por_area.map(x => x.total), backgroundColor: '#5bc0de' }]
        }, { indexAxis: 'y' });

        updateChart('por_centro', 'bar', {
            labels: data.por_centro.map(x => x.NOMBRE_CENTRO_TRABAJO),
            datasets: [{ label: 'Gasto por Centro', data: data.por_centro.map(x => x.total), backgroundColor: '#f0ad4e' }]
        });
    }

    function renderProveedores(data) {
        updateChart('top_proveedores', 'bar', {
            labels: data.top_proveedores.map(x => x.NOMBRE_PROVEEDOR),
            datasets: [{ label: 'Ranking Proveedores', data: data.top_proveedores.map(x => x.total), backgroundColor: '#428bca' }]
        }, { indexAxis: 'y' });

        updateChart('participacion_proveedor', 'doughnut', {
            labels: data.top_proveedores.map(x => x.NOMBRE_PROVEEDOR),
            datasets: [{ data: data.top_proveedores.map(x => x.total), backgroundColor: generateColors(data.top_proveedores.length) }]
        });
    }

    function renderResponsables(data) {
        updateChart('por_trabajador', 'bar', {
            labels: data.por_solicitante.slice(0, 10).map(x => x.NOMBRE_TRABAJADOR),
            datasets: [{ label: 'Ranking Solicitantes', data: data.por_solicitante.slice(0, 10).map(x => x.total), backgroundColor: '#5cb85c' }]
        }, { indexAxis: 'y' });

        updateChart('por_jefe', 'bar', {
            labels: data.por_autorizador.slice(0, 10).map(x => x.NOMBRE_JEFE_AUTORIZA),
            datasets: [{ label: 'Gasto Autorizado', data: data.por_autorizador.slice(0, 10).map(x => x.total), backgroundColor: '#d9534f' }]
        });
    }

    function renderProductos(data) {
        updateChart('top_productos', 'bar', {
            labels: data.top_productos.map(x => x.NOMBRE_PRODUCTO),
            datasets: [{ label: 'Top 10 Productos', data: data.top_productos.map(x => x.total), backgroundColor: '#f0ad4e' }]
        }, { indexAxis: 'y' });

        updateChart('participacion_producto', 'doughnut', {
            labels: data.top_productos.map(x => x.NOMBRE_PRODUCTO),
            datasets: [{ data: data.top_productos.map(x => x.total), backgroundColor: generateColors(data.top_productos.length) }]
        });
    }

    function renderComparativos(data) {
        const kpis = data.kpis;
        // Basic KPIs
        $('#lbl_periodo_actual').text(kpis.label_actual || 'Este Periodo');
        $('#lbl_periodo_prev').text(kpis.label_prev || 'Periodo Anterior');

        $('#comp_gasto_actual').text('S/ ' + formatNumber(kpis.actual));
        $('#comp_gasto_prev').text('S/ ' + formatNumber(kpis.anterior));
        $('#comp_variacion_abs').text('S/ ' + formatNumber(kpis.variacion_abs));

        let pctSign = kpis.variacion_pct > 0 ? '+' : '';
        $('#comp_variacion_pct').text(pctSign + formatNumber(kpis.variacion_pct) + '%');

        // Styles
        const color = kpis.variacion_abs > 0 ? '#d9534f' : '#5cb85c'; // Red if spent more, Green if saved
        $('#card_variacion_abs, #card_variacion_pct').css('border-left-color', color);
        $('#comp_variacion_abs, #comp_variacion_pct').css('color', color);

        // NEW: Update the chart legend with specific dates for ALL strategic charts
        if (kpis.label_actual && kpis.label_prev) {
            let labelText = `${kpis.label_actual} vs ${kpis.label_prev}`;
            $('#lbl_chart_impact_dates').text(labelText);
            $('#lbl_chart_impact_prov_dates').text(labelText);
            $('#lbl_chart_efficiency_dates').text(labelText);
        }

        // Analysis of Variances by Product (Replaces Tendencia)
        if (data.comparativo_producto) {
            // Sort by variation to get biggest impacts (positive and negative)
            let sortedProducts = [...data.comparativo_producto].sort((a, b) => b.variacion_abs - a.variacion_abs);

            // Get Top 5 Increases (Winners of spending) and Top 5 Savings
            let topIncreases = sortedProducts.slice(0, 5).filter(x => x.variacion_abs > 0);
            let topSavings = sortedProducts.slice(-5).filter(x => x.variacion_abs < 0);

            // Merge for one chart: Impacts
            let impactData = [...topIncreases, ...topSavings];

            updateChart('comp_producto', 'bar', {
                labels: impactData.map(x => x.categoria),
                datasets: [{
                    label: 'Variación de Gasto',
                    data: impactData.map(x => x.variacion_abs),
                    backgroundColor: impactData.map(x => x.variacion_abs > 0 ? 'rgba(217, 83, 79, 0.7)' : 'rgba(92, 184, 92, 0.7)'),
                    borderColor: impactData.map(x => x.variacion_abs > 0 ? '#d9534f' : '#5cb85c'),
                    borderWidth: 1
                }]
            }, {
                indexAxis: 'y',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let val = context.raw;
                                let prefix = val > 0 ? "Se gastó MÁS: " : "Se ahorró: ";
                                return prefix + "S/ " + formatNumber(Math.abs(val));
                            }
                        }
                    }
                }
            });
        }

        // 1. ¿Quién empujó el gasto? (Impacto Real por Proveedor)
        if (data.comparativo_proveedor) {
            let impactData = [...data.comparativo_proveedor].slice(0, 10);
            updateChart('comp_proveedor', 'bar', {
                labels: impactData.map(x => x.categoria),
                datasets: [{
                    label: 'Impacto en Soles (Actual vs Anterior)',
                    data: impactData.map(x => x.variacion_abs),
                    backgroundColor: impactData.map(x => x.variacion_abs > 0 ? 'rgba(217, 83, 79, 0.7)' : 'rgba(92, 184, 92, 0.7)'),
                    borderColor: impactData.map(x => x.variacion_abs > 0 ? '#d9534f' : '#5cb85c'),
                    borderWidth: 1
                }]
            }, {
                indexAxis: 'y',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let val = context.raw;
                                let prefix = val > 0 ? "Impacto (SUBIÓ): " : "Impacto (BAJÓ): ";
                                return prefix + "S/ " + formatNumber(Math.abs(val));
                            }
                        }
                    }
                }
            });
        }

        // 2. Eficiencia: Ticket Promedio por Sede
        if (data.comparativo_centro) {
            let ticketData = [...data.comparativo_centro].slice(0, 8);
            updateChart('comp_responsable', 'bar', {
                labels: ticketData.map(x => x.categoria),
                datasets: [
                    { label: 'Ticket Actual', data: ticketData.map(x => x.ticket_actual), backgroundColor: '#3498db' },
                    { label: 'Ticket Anterior', data: ticketData.map(x => x.ticket_anterior), backgroundColor: '#95a5a6' }
                ]
            }, {
                indexAxis: 'y',
                plugins: {
                    tooltip: {
                        callbacks: {
                            afterLabel: function (context) {
                                let item = ticketData[context.dataIndex];
                                let prefix = item.ticket_variacion_pct >= 0 ? "+" : "";
                                return "Variación Costo: " + prefix + formatNumber(item.ticket_variacion_pct) + "%";
                            }
                        }
                    }
                }
            });
        }

        // 3. Keep Area and Center as standard comparison
        const catConfigs = [
            { id: 'area', data: data.comparativo_area.slice(0, 8) },
            { id: 'centro', data: data.comparativo_centro.slice(0, 8) }
        ];

        catConfigs.forEach(c => {
            updateChart('comp_' + c.id, 'bar', {
                labels: c.data.map(x => x.categoria),
                datasets: [
                    { label: kpis.label_actual, data: c.data.map(x => x.actual), backgroundColor: '#3498db' },
                    { label: kpis.label_prev, data: c.data.map(x => x.anterior), backgroundColor: '#95a5a6' }
                ]
            }, {
                indexAxis: (c.id === 'centro' ? 'x' : 'y'),
                plugins: {
                    tooltip: {
                        callbacks: {
                            afterLabel: function (context) {
                                let item = c.data[context.dataIndex];
                                let pct = formatNumber(item.variacion_pct);
                                let prefix = item.variacion_abs >= 0 ? "+" : "";
                                return "Variación Monto: " + prefix + pct + "%";
                            }
                        }
                    }
                }
            });
        });
    }

    function renderDetalle(data) {
        if (datatable) datatable.destroy();
        var html = data.map(row => `<tr>
            <td>${row.ID_LIQUIDACION || ''}</td><td>${row.SERIE_REGISTRO || ''}</td><td>${row.NUMERO_REGISTRO || ''}</td>
            <td><span class="badge ${getStatusBadge(row.ESTADO_LIQUIDACION)}">${row.ESTADO_LIQUIDACION || ''}</span></td>
            <td>${row.USUARIO_REGISTRO || ''}</td><td>${row.FECHA_REGISTRO || ''}</td><td>${row.NOMBRE_EMPRESA || ''}</td>
            <td>${row.NOMBRE_CENTRO_TRABAJO || ''}</td><td>${row.NOMBRE_AREA_TRABAJO || ''}</td><td>${row.NOMBRE_TRABAJADOR || ''}</td>
            <td>${row.NOMBRE_JEFE_AUTORIZA || ''}</td><td>${row.FECHA_EMISION || ''}</td><td>${row.ANIO || ''}</td>
            <td>${row.MES || ''}</td><td>${row.TIPO_DOCUMENTO || ''}</td><td>${row.NUMERO_DOCUMENTO || ''}</td>
            <td>${row.NOMBRE_PROVEEDOR || ''}</td><td>${row.NOMBRE_PRODUCTO || ''}</td><td>${row.MONEDA || ''}</td>
            <td class="text-right">${formatNumber(row.TOTAL_GENERAL || 0)}</td>
        </tr>`).join('');

        $('#tbl_detalle tbody').html(html);
        datatable = $('#tbl_detalle').DataTable({ "order": [[0, "desc"]], "pageLength": 25, "scrollX": true, "language": { "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" }, dom: 'Bfrtip', buttons: ['excel'] });
    }

    // --- HELPERS ---

    function getFullAttributeMap(row) {
        return {
            'ID_LIQUIDACION': row.ID_LIQUIDACION || '', 'SERIE_REGISTRO': row.SERIE_REGISTRO || '', 'NUMERO_REGISTRO': row.NUMERO_REGISTRO || '',
            'ESTADO_LIQUIDACION': row.ESTADO_LIQUIDACION || '', 'USUARIO_REGISTRO': row.USUARIO_REGISTRO || '', 'FECHA_REGISTRO': row.FECHA_REGISTRO || '',
            'NOMBRE_EMPRESA': row.NOMBRE_EMPRESA || '', 'NOMBRE_CENTRO_TRABAJO': row.NOMBRE_CENTRO_TRABAJO || '', 'NOMBRE_AREA_TRABAJO': row.NOMBRE_AREA_TRABAJO || '',
            'NOMBRE_TRABAJADOR': row.NOMBRE_TRABAJADOR || '', 'NOMBRE_JEFE_AUTORIZA': row.NOMBRE_JEFE_AUTORIZA || '', 'FECHA_EMISION': row.FECHA_EMISION || '',
            'ANIO': row.ANIO || '', 'MES': row.MES || '', 'TIPO_DOCUMENTO': row.TIPO_DOCUMENTO || '', 'NUMERO_DOCUMENTO': row.NUMERO_DOCUMENTO || '',
            'NOMBRE_PROVEEDOR': row.NOMBRE_PROVEEDOR || '', 'NOMBRE_PRODUCTO': row.NOMBRE_PRODUCTO || '', 'MONEDA': row.MONEDA || '', 'TOTAL_GENERAL': row.TOTAL_GENERAL || 0
        };
    }

    function updateChart(id, type, chartData, options = {}) {
        var canvas = document.getElementById('chart_' + id);
        if (!canvas) return;
        if (charts[id]) charts[id].destroy();
        charts[id] = new Chart(canvas.getContext('2d'), { type: type, data: chartData, options: $.extend(true, { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }, options) });
    }

    function formatNumber(num) { return parseFloat(num).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
    function generateColors(len) { var colors = ['#5cb85c', '#428bca', '#f0ad4e', '#d9534f', '#5bc0de', '#2c3e50']; while (colors.length < len) colors.push('#' + Math.floor(Math.random() * 16777215).toString(16)); return colors.slice(0, len); }
    function getStatusBadge(s) { switch (s) { case 'APROBADO': return 'badge-success'; case 'OBSERVADO': return 'badge-warning'; case 'ANULADO': return 'badge-danger'; default: return 'badge-default'; } }

    reloadActivePhase();
});
