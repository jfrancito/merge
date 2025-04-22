$(document).ready(function () {
    let carpeta = $("#carpeta").val();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        let target = $(e.target).attr("href"); // Obtén la pestaña activa
        console.log(target);
        switch (target) {
            case "#ccobrar":
                $('#cesii').DataTable().destroy();
                $('#cesii').DataTable({
                    responsive: true,
                    autoWidth: true,
                    lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
                    scrollX: true,
                    scrollY: "300px",
                    ordering: false,
                });
                break;
            case "#ccobrarrel":
                $('#cesic').DataTable().destroy();
                $('#cesic').DataTable({
                    responsive: true,
                    autoWidth: true,
                    lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
                    scrollX: true,
                    scrollY: "300px",
                    ordering: false,
                });
                break;
        }
        /*if (target === "#cargas" || target === "#paquetes") {
            $('#tablamindatabultos').DataTable().destroy();
            $('#tablamindatabultos').DataTable();
        }*/
    });

    $(".reportecomprasenvases").on('click', '.descargararchivo', function () {

        event.preventDefault();
        let fecha_ini = $('#fecha_ini').val();
        let fecha_fin = $('#fecha_fin').val();

        if (fecha_ini === undefined || fecha_ini === '') {
            alerterrorajax("Seleccione una fecha inicio.");
            return false;
        }

        if (fecha_fin === undefined || fecha_fin === '') {
            alerterrorajax("Seleccione una fecha fin.");
            return false;
        }

        $('#formdescargar').submit();

    });

    $(".reportecomprasenvases").on('click', '.buscarces', function () {

        event.preventDefault();
        let id_opcion = $('#idopcion').val();
        let _token = $('#token').val();
        let fecha_ini = $('#fecha_ini').val();
        let fecha_fin = $('#fecha_fin').val();
        let cod_empresa = $('#empresas').val();
        let cod_familia = $('#familia').val();

        if (fecha_ini === undefined || fecha_ini === '') {
            alerterrorajax("Seleccione una fecha inicio.");
            return false;
        }

        if (fecha_fin === undefined || fecha_fin === '') {
            alerterrorajax("Seleccione una fecha fin.");
            return false;
        }

        data = {
            _token: _token,
            idopcion: id_opcion,
            fecha_fin: fecha_fin,
            fecha_ini: fecha_ini,
            cod_empresa: cod_empresa,
            cod_familia: cod_familia
        };

        ajax_normal(data, "/obtener-reporte-compras-envases-sede");

    });

});
