/**
 * Conciliación de Liquidación de Gastos y Vales
 */

(function ($) {
    'use strict';

    var ConciliacionReporte = {
        config: {
            urlBuscar: '',
            csrfToken: '',
        },

        init: function () {
            this.config.urlBuscar = urlBase + '/buscar-reporte-conciliacion';
            this.config.urlExportarDetalle = urlBase + '/exportar-excel-conciliacion-detalle';
            this.config.csrfToken = csrfToken;

            // Eliminamos initSelect2 e initDatePickers porque ya los llamas 
            // manualmente en el Blade con App.formElements()
            this.bindEvents();
        },

        bindEvents: function () {
            var self = this;
            $(document).on('click', '#btnBuscar', function (e) {
                e.preventDefault();
                self.buscarReporte();
            });

            // Evento Doble Click en resultados para exportar detalle (Drill-down)
            $('#resultadosReporte').on('dblclick', 'td', function () {
                var trabajador = $('#trabajador').val();
                var fechaInicio = $('#fecha_inicio').val();
                var fechaFin = $('#fecha_fin').val();

                if (!trabajador || !fechaInicio || !fechaFin) {
                    alert('Por favor, realice una búsqueda primero.');
                    return;
                }

                // Crear formulario dinámico para POST download
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = self.config.urlExportarDetalle;
                form.target = '_blank';

                var params = {
                    _token: self.config.csrfToken,
                    trabajador: trabajador,
                    fecha_inicio: fechaInicio,
                    fecha_fin: fechaFin
                };

                for (var key in params) {
                    var hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';
                    hiddenField.name = key;
                    hiddenField.value = params[key];
                    form.appendChild(hiddenField);
                }

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            });
        },

        showLoading: function () { $('#loadingOverlay').fadeIn(200); },
        hideLoading: function () { $('#loadingOverlay').fadeOut(200); },

        buscarReporte: function () {
            var self = this;
            var trabajador = $('#trabajador').val();
            var fechaInicio = $('#fecha_inicio').val();
            var fechaFin = $('#fecha_fin').val();

            // Validaciones previas
            if (!trabajador || trabajador === '') {
                alert('Por favor, seleccione un trabajador.');
                return false;
            }

            if (!fechaInicio || fechaInicio === '' || !fechaFin || fechaFin === '') {
                alert('Por favor, seleccione el rango de fechas.');
                return false;
            }

            if (!this.config.csrfToken) {
                alert('Error de sesión: Token CSRF no disponible.');
                return false;
            }

            this.showLoading();

            $.ajax({
                url: this.config.urlBuscar,
                type: 'POST',
                data: {
                    _token: this.config.csrfToken,
                    trabajador: trabajador,
                    fecha_inicio: fechaInicio,
                    fecha_fin: fechaFin
                },
                dataType: 'json',
                success: function (response) {
                    self.hideLoading();
                    if (response.success) {
                        self.renderizarReporte(response);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function () {
                    self.hideLoading();
                    alert('Error de conexión al buscar reporte.');
                }
            });
        },

        renderizarReporte: function (res) {
            var self = this;
            var data = res.data;
            var destinos = res.destinos;
            var trabajadores = res.trabajadores;

            // Datos para el Resumen Ejecutivo
            var nombreEmpresa = $('.panel-subtitle').text().trim() || 'INDUAMERICA';
            var nombreTrabajador = $('#trabajador option:selected').text().trim();
            var fechaInicio = $('#fecha_inicio').val();
            var fechaFin = $('#fecha_fin').val();

            var $summaryHeader = $('#summaryHeader');
            var $thead = $('#theadConciliacion');
            var $tbody = $('#tbodyConciliacion');
            var $tfoot = $('#tfootConciliacion');

            // 1. Renderizar Resumen Ejecutivo
            var htmlSummary = '<div class="report-summary-header">';

            // Empresa
            htmlSummary += '  <div class="summary-item">';
            htmlSummary += '    <div class="summary-icon"><i class="mdi mdi-city"></i></div>';
            htmlSummary += '    <div class="summary-content">';
            htmlSummary += '      <span class="summary-label">Empresa</span>';
            htmlSummary += '      <span class="summary-value">' + nombreEmpresa + '</span>';
            htmlSummary += '    </div>';
            htmlSummary += '  </div>';

            // Trabajador
            htmlSummary += '  <div class="summary-item">';
            htmlSummary += '    <div class="summary-icon"><i class="mdi mdi-account-tie"></i></div>';
            htmlSummary += '    <div class="summary-content">';
            htmlSummary += '      <span class="summary-label">Responsable</span>';
            htmlSummary += '      <span class="summary-value">' + nombreTrabajador + '</span>';
            htmlSummary += '    </div>';
            htmlSummary += '  </div>';

            // Periodo
            htmlSummary += '  <div class="summary-item">';
            htmlSummary += '    <div class="summary-icon"><i class="mdi mdi-calendar-range"></i></div>';
            htmlSummary += '    <div class="summary-content">';
            htmlSummary += '      <span class="summary-label">Periodo</span>';
            htmlSummary += '      <span class="summary-value">' + fechaInicio + ' hasta ' + fechaFin + '</span>';
            htmlSummary += '    </div>';
            htmlSummary += '  </div>';

            htmlSummary += '</div>';

            $summaryHeader.html(htmlSummary).fadeIn(300);

            // 2. Renderizar Cabecera Dinámica (3 Niveles)
            var colSpanDestinos = destinos.length + 1; // Destinos + Columna TOTAL
            var htmlHead = '';

            // Fila 1: Concepto | Gasto | NOMBRE TRABAJADOR | Excesos
            htmlHead += '<tr>';
            htmlHead += '  <th rowspan="3" style="vertical-align: middle;">CONCEPTO</th>';
            htmlHead += '  <th rowspan="3" style="vertical-align: middle;">GASTO</th>';
            htmlHead += '  <th colspan="' + colSpanDestinos + '" class="text-center">' + nombreTrabajador.toUpperCase() + '</th>';
            htmlHead += '  <th rowspan="3" style="vertical-align: middle;">EXCESOS</th>';
            htmlHead += '</tr>';

            // Fila 2: VALES
            htmlHead += '<tr>';
            htmlHead += '  <th colspan="' + colSpanDestinos + '" class="text-center">VALES</th>';
            htmlHead += '</tr>';

            // Fila 3: Destinos individualmente | TOTAL
            htmlHead += '<tr>';
            destinos.forEach(function (des) {
                htmlHead += '  <th class="text-center">' + des.toUpperCase() + '</th>';
            });
            htmlHead += '  <th class="text-center">TOTAL</th>';
            htmlHead += '</tr>';

            $thead.html(htmlHead);

            // 2. Renderizar Cuerpo y Totales
            $tbody.empty();
            if (data.length === 0) {
                $tbody.html('<tr><td colspan="' + (colSpanDestinos + 3) + '" class="text-center">No hay datos</td></tr>');
                $tfoot.empty();
                return;
            }

            var totalGastoGral = 0;
            var totalExcesosGral = 0;
            var totalesDestinos = {};
            destinos.forEach(function (d) { totalesDestinos[d] = 0; });
            var totalValesGral = 0;

            var htmlBody = '';
            data.forEach(function (row) {
                totalGastoGral += row.gasto;
                totalExcesosGral += row.exceso;
                totalValesGral += row.total_vales;

                htmlBody += '<tr>';
                htmlBody += '  <td>' + row.concepto + '</td>';
                htmlBody += '  <td class="text-right">' + self.formatoSoles(row.gasto) + '</td>';

                destinos.forEach(function (des) {
                    var val = row.vales[des] || 0;
                    totalesDestinos[des] += val;
                    htmlBody += '  <td class="text-right">' + (val > 0 ? self.formatoSoles(val) : '-') + '</td>';
                });

                htmlBody += '  <td class="text-right" style="font-weight:bold;">' + self.formatoSoles(row.total_vales) + '</td>';

                var claseExceso = row.exceso < 0 ? 'text-danger' : (row.exceso > 0 ? 'text-success' : '');
                htmlBody += '  <td class="text-right ' + claseExceso + '" style="font-weight:bold;">' + self.formatoSoles(row.exceso) + '</td>';
                htmlBody += '</tr>';
            });
            $tbody.html(htmlBody);

            // 3. Renderizar Footer (TOTALES) - IMPORTANTE: Antes de DataTable
            var htmlFoot = '<tr style="background:#f9f9f9; font-weight:bold;">';
            htmlFoot += '  <td>TOTAL</td>';
            htmlFoot += '  <td class="text-right">' + self.formatoSoles(totalGastoGral) + '</td>';

            destinos.forEach(function (des) {
                htmlFoot += '  <td class="text-right">' + self.formatoSoles(totalesDestinos[des]) + '</td>';
            });

            htmlFoot += '  <td class="text-right">' + self.formatoSoles(totalValesGral) + '</td>';

            var claseExcesoGral = totalExcesosGral < 0 ? 'text-danger' : (totalExcesosGral > 0 ? 'text-success' : '');
            htmlFoot += '  <td class="text-right ' + claseExcesoGral + '">' + self.formatoSoles(totalExcesosGral) + '</td>';
            htmlFoot += '</tr>';
            $tfoot.html(htmlFoot);

            // 4. Inicializar DataTables con botones de Exportación
            if ($.fn.DataTable.isDataTable('#tablaConciliacion')) {
                $('#tablaConciliacion').DataTable().destroy();
            }

            $('#tablaConciliacion').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "searching": false,
                "dom": 'Bfrtip',
                "buttons": [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="mdi mdi-file-excel"></i> EXCEL',
                        className: 'dt-button buttons-excel',
                        title: 'CONCILIACION_GASTOS',
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="mdi mdi-file-pdf"></i> PDF',
                        className: 'dt-button buttons-pdf',
                        title: 'CONCILIACION_GASTOS',
                        footer: true,
                        orientation: 'landscape',
                        pageSize: 'A4'
                    }
                ],
                "language": {
                    "emptyTable": "No hay datos para mostrar con los filtros seleccionados"
                }
            });
        },

        formatoSoles: function (monto) {
            return parseFloat(monto).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    };

    $(document).ready(function () {
        ConciliacionReporte.init();
    });

})(jQuery);
