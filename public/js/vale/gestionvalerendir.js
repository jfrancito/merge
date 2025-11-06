$(document).ready(function () {
    $(".valerendir").on('click', '.buscardocumento', function (event) {

        event.preventDefault();

        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var estado_id = $('#estado_id').val();
        var tipo_vale = $('#tipo_vale').val();
        var idopcion = $('#idopcion').val();
        var _token = $('#token').val();

        console.log("Fecha inicio:", fecha_inicio);
        console.log("Fecha fin:", fecha_fin);
        console.log("Estado:", estado_id);
        console.log("ID opción:", idopcion);

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
});
