$(document).ready(function () {

    let carpeta = $("#carpeta").val();

    $(".inventarioconsolidado").on('click', '.buscarinventarioformato', function () {

        event.preventDefault();
        let _token = $('#token').val();
        let fecha_hasta = $('#fecha_hasta').val();

        if (fecha_hasta === '') {
            alerterrorajax("Seleccione una fecha.");
            return false;
        }
        var cod_empr     =   $('#cod_empr').val();

        data = {
            _token: _token,
            fecha_hasta: fecha_hasta,
            cod_empr: cod_empr
        };

        ajax_normal(data, "/ajax-reporte-inventario");

    });

    $(".inventarioconsolidado").on('click','.descargararchivoinv', function() {

        event.preventDefault();
        let fecha_hasta = $('#fecha_hasta').val();

        if (fecha_hasta === '') {
            alerterrorajax("Seleccione una fecha.");
            return false;
        }
        var cod_empr     =   $('#cod_empr').val();

        $('#formdescargar').submit();

    });

});
