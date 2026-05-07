$(document).ready(function () {

    let carpeta = $("#carpeta").val();

    $(".reportedivsaldos").on('click', '.buscareportedivsaldos', function () {

        event.preventDefault();
        let id_opcion = $('#idopcion').val();
        let _token = $('#token').val();
        let fecha_fin = $('#endDate').val();
        let opcion = $('input[name="opcion"]:checked').val();

        if (fecha_fin === '') {
            alerterrorajax("Seleccione una fecha corte.");
            return false;
        }

        data = {
            _token: _token,
            idopcion: id_opcion,
            fecha_fin: fecha_fin,
            opcion: opcion
        };

        ajax_normal(data, "/ajax-reporte-div-saldos");

    });

    $(".reportedivsaldos").on('click','.descargararchivo', function() {

        event.preventDefault();
        let fecha_fin = $('#endDate').val();

        if (fecha_fin === '') {
            alerterrorajax("Seleccione una fecha corte.");
            return false;
        }

        $('#formdescargar').submit();

    });

});
