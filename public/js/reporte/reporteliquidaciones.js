$(document).ready(function () {
    let carpeta = $("#carpeta").val();

    $(".reporteliquidaciones").on('click', '.descargararchivo', function () {

        event.preventDefault();
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();

        if (startDate === undefined || startDate === '') {
            alerterrorajax("Seleccione una fecha inicio.");
            return false;
        }

        if (endDate === undefined || endDate === '') {
            alerterrorajax("Seleccione una fecha fin.");
            return false;
        }

        $('#formdescargar').submit();

    });

    $(".reporteliquidaciones").on('click', '.buscarliquidaciones', function () {

        event.preventDefault();

        let id_opcion = $('#idopcion').val();
        let _token = $('#token').val();
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();
        let employee = $('#employee').val();

        if (startDate === undefined || startDate === '') {
            alerterrorajax("Seleccione una fecha inicio.");
            return false;
        }

        if (endDate === undefined || endDate === '') {
            alerterrorajax("Seleccione una fecha fin.");
            return false;
        }

        data = {
            _token: _token,
            idopcion: id_opcion,
            startDate: startDate,
            endDate: endDate,
            employee: employee
        };

        ajax_normal(data, "/obtener-reporte-liquidaciones-trabajador");

    });


});
