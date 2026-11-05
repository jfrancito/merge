$(document).ready(function () {
    let carpeta = $("#carpeta").val();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        let target = $(e.target).attr("href"); // Obtén la pestaña activa
        console.log(target);
        switch (target) {
            case "#ccobrar":
                $('#cxct').DataTable().destroy();
                $('#cxct').DataTable({
                    responsive: true,
                    autoWidth: true,
                    lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
                    scrollX: true,
                    scrollY: "300px",
                    //ordering: false,
                });
                break;
            case "#ccobrarrel":
                $('#cxcr').DataTable().destroy();
                $('#cxcr').DataTable({
                    responsive: true,
                    autoWidth: true,
                    lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
                    scrollX: true,
                    scrollY: "300px",
                    //ordering: false,
                });
                break;
            case "#cpagar":
                $('#cxpt').DataTable().destroy();
                $('#cxpt').DataTable({
                    responsive: true,
                    autoWidth: true,
                    lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
                    scrollX: true,
                    scrollY: "300px",
                    //ordering: false,
                });
                break;
            case "#cpagarrel":
                $('#cxpr').DataTable().destroy();
                $('#cxpr').DataTable({
                    responsive: true,
                    autoWidth: true,
                    lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
                    scrollX: true,
                    scrollY: "300px",
                    //ordering: false,
                });
                break;
        }
        /*if (target === "#cargas" || target === "#paquetes") {
            $('#tablamindatabultos').DataTable().destroy();
            $('#tablamindatabultos').DataTable();
        }*/
    });

    $(".reportecuentasaldo").on('click', '.descargararchivo', function () {

        event.preventDefault();
        let fecha_fin = $('#endDate').val();

        if (fecha_fin === '') {
            alerterrorajax("Seleccione una fecha fin.");
            return false;
        }

        $('#formdescargar').submit();

    });

    $(".reportecuentasaldo").on('click', '.buscarccp', function () {

        event.preventDefault();
        let id_opcion = $('#idopcion').val();
        let _token = $('#token').val();
        let fecha_fin = $('#endDate').val();
        let tc_venta = $('#tc_venta').val();
        let tc_compra = $('#tc_compra').val();
        let cod_centro = $('#centro').val();
        let tipo_cuenta = $('#tipocontrato').val();

        if (fecha_fin === undefined || fecha_fin === '') {
            alerterrorajax("Seleccione una fecha fin.");
            return false;
        }

        data = {
            _token: _token,
            idopcion: id_opcion,
            fecha_fin: fecha_fin,
            tc_venta: tc_venta,
            tc_compra: tc_compra,
            cod_centro: cod_centro,
            tipo_cuenta: tipo_cuenta
        };

        ajax_normal(data, "/obtener-reporte-cuentas-saldo");

    });

    $('#endDate').on('keydown', function (event) {

        if (event.key === 'Enter') {
            let _token = $('#token').val();
            let endDate = $('#endDate').val();

            /****** VALIDACIONES ********/
            if (endDate === undefined || endDate === '') {
                alerterrorajax("Seleccione una fecha de inicio");
                return false;
            }

            /*
            let data = {
                _token: _token,
                endDate: endDate
            }*/

            abrircargando();

            //ajax_normal_combo(data, "/obtener_tipo_cambio", "listajax")

            $.ajax({
                type: "POST",
                url: carpeta + "/obtener_tipo_cambio",
                data: {
                    _token: _token,
                    endDate: endDate
                },
                success: function (data) {
                    cerrarcargando();
                    $('#tc_compra').val(data.CAN_COMPRA);
                    $('#tc_venta').val(data.CAN_VENTA);
                },
                error: function (data) {
                    cerrarcargando();
                    if (data.status === 500) {
                        let contenido = 'HUBO UN ERROR POR PARTE DEL SERVIDOR';
                        alerterror505ajax($(contenido).find('.trace-message').html());
                    }
                }
            });
        }

    });

});
