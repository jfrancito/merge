var App = (function () {
    'use strict';
    //console.log("entro");
    App.dataTables = function () {

        //We use this to apply style to certain elements
        $.extend(true, $.fn.dataTable.defaults, {
            dom:
                "<'row be-datatable-header'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row be-datatable-body'<'col-sm-12'tr>>" +
                "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
        });


        $("#tdpm").dataTable({
            "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]]
        });

        $("#nso").dataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf'
            ],
            "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
            columnDefs: [{
                targets: "_all",
                sortable: false
            }]
        });

        $("#nsovale").dataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf'
            ],
            "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
            columnDefs: [{
                targets: "_all",
                sortable: false
            }]
        });


        $("#nso_check").dataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf'
            ],
            "lengthMenu": [[2000, 3000, -1], [2000, 3000, "All"]],
            columnDefs: [{
                targets: "_all",
                sortable: false
            }]
        });

        $("#nso_obs_le").dataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf'
            ],
            "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
            columnDefs: [{
                targets: "_all",
                sortable: false
            }]
        });

        $("#nso_his_le").dataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf'
            ],
            "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
            columnDefs: [{
                targets: "_all",
                sortable: false
            }]
        });
        

        $("#nso_obs").dataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf'
            ],
            "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
            columnDefs: [{
                targets: "_all",
                sortable: false
            }]
        });
        $("#despacholocen").dataTable({
            "lengthMenu": [[50, 100, -1], [50, 100, "All"]],
            order: [[5, "desc"]],
            "bPaginate": false
        });

        $("#asientodetalle").dataTable({
            responsive: true,
            autoWidth: false,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "200px",
            ordering: false,
            searching: false,
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();

                // helper para convertir texto a número
                let intVal = function (i) {
                    return typeof i === 'string'
                        ? parseFloat(i.replace(/[\$,]/g, '')) || 0
                        : typeof i === 'number'
                            ? i
                            : 0;
                };

                // columnas numéricas a sumar (basado en tu orden)
                let cols = [3, 4, 5, 6];

                cols.forEach(function (colIdx) {
                    let total = api
                        .column(colIdx, { page: 'current' })
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    // mostrar con 2 decimales
                    $(api.column(colIdx).footer()).html(number_format(total, 4));
                });
            }
        });

        $("#asientodetallereparable").dataTable({
            responsive: true,
            autoWidth: false,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "200px",
            ordering: false,
            searching: false,
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();

                // helper para convertir texto a número
                let intVal = function (i) {
                    return typeof i === 'string'
                        ? parseFloat(i.replace(/[\$,]/g, '')) || 0
                        : typeof i === 'number'
                            ? i
                            : 0;
                };

                // columnas numéricas a sumar (basado en tu orden)
                let cols = [3, 4, 5, 6];

                cols.forEach(function (colIdx) {
                    let total = api
                        .column(colIdx, { page: 'current' })
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    // mostrar con 2 decimales
                    $(api.column(colIdx).footer()).html(total.toFixed(4));
                });
            }
        });

        $("#asientodetallededuccion").dataTable({
            responsive: true,
            autoWidth: false,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "200px",
            ordering: false,
            searching: false,
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();

                // helper para convertir texto a número
                let intVal = function (i) {
                    return typeof i === 'string'
                        ? parseFloat(i.replace(/[\$,]/g, '')) || 0
                        : typeof i === 'number'
                            ? i
                            : 0;
                };

                // columnas numéricas a sumar (basado en tu orden)
                let cols = [3, 4, 5, 6];

                cols.forEach(function (colIdx) {
                    let total = api
                        .column(colIdx, { page: 'current' })
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    // mostrar con 2 decimales
                    $(api.column(colIdx).footer()).html(total.toFixed(4));
                });
            }
        });

        $("#asientodetallereversion").dataTable({
            responsive: true,
            autoWidth: false,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "200px",
            ordering: false,
            searching: false,
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();

                // helper para convertir texto a número
                let intVal = function (i) {
                    return typeof i === 'string'
                        ? parseFloat(i.replace(/[\$,]/g, '')) || 0
                        : typeof i === 'number'
                            ? i
                            : 0;
                };

                // columnas numéricas a sumar (basado en tu orden)
                let cols = [3, 4, 5, 6];

                cols.forEach(function (colIdx) {
                    let total = api
                        .column(colIdx, { page: 'current' })
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    // mostrar con 2 decimales
                    $(api.column(colIdx).footer()).html(total.toFixed(4));
                });
            }
        });

        $("#asientodetallepercepcion").dataTable({
            responsive: true,
            autoWidth: false,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "200px",
            ordering: false,
            searching: false,
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();

                // helper para convertir texto a número
                let intVal = function (i) {
                    return typeof i === 'string'
                        ? parseFloat(i.replace(/[\$,]/g, '')) || 0
                        : typeof i === 'number'
                            ? i
                            : 0;
                };

                // columnas numéricas a sumar (basado en tu orden)
                let cols = [3, 4, 5, 6];

                cols.forEach(function (colIdx) {
                    let total = api
                        .column(colIdx, { page: 'current' })
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    // mostrar con 2 decimales
                    $(api.column(colIdx).footer()).html(total.toFixed(4));
                });
            }
        });

        $("#table1").dataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf'
            ],
            "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
            order: [[0, "asc"]]
        });

        //Remove search & paging dropdown
        $("#table2").dataTable({
            pageLength: 6,
            dom: "<'row be-datatable-body'<'col-sm-12'tr>>" +
                "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
        });


        $("#estiba").dataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf'
            ],
            "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]]
        });


        //Enable toolbar button functions
        $("#table3").dataTable({
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ],
            "lengthMenu": [[6, 10, 25, 50, -1], [6, 10, 25, 50, "All"]],
            dom: "<'row be-datatable-header'<'col-sm-6'l><'col-sm-6 text-right'B>>" +
                "<'row be-datatable-body'<'col-sm-12'tr>>" +
                "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
        });

        $("#cxct").dataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });

        $("#cxcr").dataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });

        $("#reporteliquidaciones").dataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });

        $("#cxpt").dataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });

        $("#cxpr").dataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });

        $("#cesii").dataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });

        $("#cesic").dataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });

        $("#iscomercial").dataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });

        $("#isinternacional").dataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });

      $("#tablavalespendiente").dataTable({
          responsive: true,
          autoWidth: true,
          lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
          scrollX: true,
          scrollY: "300px",
          ordering: false,
      });

      $("#tablavalespendienteaprueba").dataTable({
          responsive: true,
          autoWidth: true,
          lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
          scrollX: true,
          scrollY: "300px",
          ordering: false,
      });

        $("#tablaliquidacionespendientes").dataTable({
          responsive: true,
          autoWidth: true,
          lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
          scrollX: true,
          scrollY: "300px",
          ordering: false,
      });

       $("#tablaDocumentoxml_cdr").dataTable({
          responsive: true,
          autoWidth: true,
          lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
          scrollX: true,
          scrollY: "300px",
          ordering: false,
      });

      $("#tablalistanegraproveedores").dataTable({
          responsive: true,
          autoWidth: true,
          lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
          scrollX: true,
          scrollY: "300px",
          ordering: false,
      });

      $("#tablalistafirmavale").dataTable({
          responsive: true,
          autoWidth: true,
          lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
          scrollX: true,
          scrollY: "300px",
          ordering: false,
      });

      $("#tablalistafirmavaleaprobados").dataTable({
          responsive: true,
          autoWidth: true,
          lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
          scrollX: true,
          scrollY: "300px",
          ordering: false,
      });


      $("#importegastos").dataTable({
          responsive: true,
          autoWidth: true,
          lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
          scrollX: true,
          scrollY: "300px",
          ordering: false,
      });

      if (!$.fn.DataTable.isDataTable('#vale')) {
          $('#vale').DataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });
      }

        if (!$.fn.DataTable.isDataTable('#vale')) {
            $('#vale').DataTable({
                responsive: true,
                autoWidth: true,
                lengthMenu: [[10, 20, 50], [10, 20, 50]],
                scrollX: true,
                scrollY: "300px",
                ordering: false
            });
        }

        
        $("#valeaprobado").dataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });

        function number_format(num, decimals = 0, decimal_separator = ".", thousands_separator = ",") {
            if (isNaN(num) || num === null) return "0";

            // Asegurar número flotante
            let n = parseFloat(num);

            // Redondear a la cantidad de decimales indicada
            let fixed = n.toFixed(decimals);

            // Separar parte entera y decimal
            let parts = fixed.split(".");

            // Insertar separador de miles en la parte entera
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_separator);

            // Unir con el separador de decimales
            return parts.join(decimals > 0 ? decimal_separator : "");
        }


    };

    return App;
})(App || {});
