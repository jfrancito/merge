var App = (function () {
    'use strict';

    App.dataTables = function() {

        if ($("#Listaunidadesneumatico").length) {
            console.log("Inicializando DataTable en Listaunidadesneumatico...");

            $("#Listaunidadesneumatico").dataTable({
                lengthMenu: [[100, 200, 300, -1], [100, 200, 300, "Todos"]],
                autoWidth: true,
                responsive: true,
                paging: true,
                info: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ]
            });

        } else {
            console.warn("Tabla Listaunidadesneumatico no encontrada.");
        }

    };

    return App;
})();
