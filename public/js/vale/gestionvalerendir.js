$(document).ready(function () {
    $(".valerendir").on('click', '.buscardocumento', function (event) {

        event.preventDefault();

        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var estado_id = $('#estado_id').val();
        var tipo_vale = $('#tipo_vale').val();
        var idopcion = $('#idopcion').val();
        var _token = $('#token').val();

        if ($.trim(fecha_inicio) === '') {
            alerterrorajax("Seleccione una fecha inicio.");
            return false;
        }
        if ($.trim(fecha_fin) === '') {
            alerterrorajax("Seleccione una fecha fin.");
            return false;
        }

        data = {
            _token: _token,
            fecha_inicio : fecha_inicio,
            fecha_fin    : fecha_fin,
            estado_id    : estado_id,
            tipo_vale    : tipo_vale,
            idopcion     : idopcion
        };
        ajax_normal(data, "/ajax-buscar-documento-vl");

    });


    $(".valerendir").on('click', '.verdetalleimporte-valegestion', function(e) {
        e.preventDefault();

        let valerendir_id = $(this).closest('tr').attr('data_vale_rendir'); 
        var _token = $('#token').val();

            if (!valerendir_id) {
                alert("No se encontró el ID del vale.");
                return;
            }

            let data = {
                _token: _token,
                valerendir_id: valerendir_id,
            };

            ajax_modal(
                data,
                "/ver_detalle_importe_vale_gestion",
                "modal-verdetalleimportedocumentogestion-solicitud",
                "modal-verdetalleimportedocumentogestion-solicitud-container"
            );
     });


    $(".valerendir").on('click', '.verdetalle-valegestion', function(e) {
        e.preventDefault();

        let valerendir_id = $(this).closest('tr').attr('data_vale_rendir'); 
        var _token = $('#token').val();

            if (!valerendir_id) {
                alert("No se encontró el ID del vale.");
                return;
            }

            let data = {
                _token: _token,
                valerendir_id: valerendir_id,
            };

            ajax_modal(
                data,
                "/ver_detalle_vale_gestion",
                "modal-verdetalledocumentogestion-solicitud",
                "modal-verdetalledocumentogestion-solicitud-container"
            );
     });

    $(".valerendir").on('click', '.aumdetalleimporte-valegestion', function(e) {
        e.preventDefault();

        let valerendir_id = $(this).closest('tr').attr('data_vale_rendir'); 
        var _token = $('#token').val();

            if (!valerendir_id) {
                alert("No se encontró el ID del vale.");
                return;
            }

            let data = {
                _token: _token,
                valerendir_id: valerendir_id,
            };

            ajax_modal(
                data,
                "/aum_detalle_importe_vale_gestion",
                "modal-aumdetalleimportedocumentogestion-solicitud",
                "modal-aumdetalleimportedocumentogestion-solicitud-container"
            );
     });

    $(document).on('click', '#btn_guardar_aumento_dias', function () {
        var vale_id = $('#vale_id').val();
        var aumento_dias = $('#aumento_dias').val();
        var _token = $('#token').val();

        if ($.trim(aumento_dias) === '') {
            alerterrorajax("Ingrese el número de días a aumentar.");
            return false;
        }

        var data = {
            _token: _token,
            vale_id: vale_id,
            aumento_dias: aumento_dias
        };

        $.ajax({
            type: "POST",
            url: carpeta + "/actualizar_dias_vale",
            data: data,
            dataType: "json",
            success: function (response) {
               
                if (response.success) {
                    alertajax(response.success);

                    setTimeout(function() {
                    location.reload();
                }, 1000);
                
                } else if (response.error) {
                    alerterrorajax(response.error);

                } else {
                    alerterrorajax("Ocurrió un error inesperado.");
                }
            },
            error: function (xhr, status, error) {
                alerterrorajax("Error al guardar: " + error);
            }
        });
    });


    $(document).on('click', '#btn_guardar', function () {

        let detalles = [];

        $(".input-importe").each(function () {

            let valor = $(this).val();
            let id = $(this).data("detalle-id");
            let destino = $(this).data("destino");
            let nomdestino = $(this).data("nomdestino");
            let nomtipo = $(this).data("nomtipo");
            let linea = $(this).data("linea");

            detalles.push({
                id: id,
                destino: destino,
                linea: linea,
                nomtipo : nomtipo,
                nomdestino : nomdestino,
                importe: valor
            });
        });

        $.ajax({
            type: "POST",
            url: carpeta + "/actualizar_importe_vale",
            data: {
                _token: $('#token').val(),
                detalles: detalles
            },
            success: function(response) {
                if (response.success) {
                    alertajax("Importes actualizados correctamente");
                    location.reload();
                } else {
                    alerterrorajax("Error: " + response.error);
                }
            }
        });
    });


});
