$(document).ready(function () {
    let carpeta = $("#carpeta").val();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        let target = $(e.target).attr("href"); // Obtén la pestaña activa
        console.log(target);
        switch (target) {
            case "#isinternacional":
                $('#isinternacional').DataTable().destroy();
                $('#isinternacional').DataTable({
                    responsive: true,
                    autoWidth: true,
                    lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
                    scrollX: true,
                    scrollY: "300px",
                    ordering: false,
                });
                break;
            case "#iscomercial":
                $('#iscomercial').DataTable().destroy();
                $('#iscomercial').DataTable({
                    responsive: true,
                    autoWidth: true,
                    lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
                    scrollX: true,
                    scrollY: "300px",
                    ordering: false,
                });
                break;
        }
    });

    $(".reporteingresossalidas").on('click', '.descargararchivo', function () {

        event.preventDefault();
        let fecha = $('#fechaCorte').val();
        let tipo_producto = $('#tipoProducto').val();

        if (fecha === undefined || fecha === '') {
            alerterrorajax("Seleccione una fecha corte.");
            return false;
        }

        if (tipo_producto === undefined || tipo_producto === '') {
            alerterrorajax("Seleccione un tipo de producto.");
            return false;
        }

        $('#formdescargar').submit();

    });

    $(".reporteingresossalidas").on('click', '.buscarise', function () {

        event.preventDefault();
        let id_opcion = $('#idopcion').val();
        let _token = $('#token').val();
        let empresa = $('#empresa').val();
        let centro = $('#centro').val();
        let fecha = $('#fechaCorte').val();
        let producto = $('#producto').val();
        let subfamilia = $('#subfamilia').val();
        let familia = $('#familia').val();
        let tipo_producto = $('#tipoProducto').val();

        if (fecha === undefined || fecha === '') {
            alerterrorajax("Seleccione una fecha corte.");
            return false;
        }

        if (tipo_producto === undefined || tipo_producto === '') {
            alerterrorajax("Seleccione un tipo de producto.");
            return false;
        }

        data = {
            _token: _token,
            id_opcion: id_opcion,
            producto: producto,
            subfamilia: subfamilia,
            familia: familia,
            tipo_producto: tipo_producto,
            empresa: empresa,
            centro: centro,
            fecha: fecha,
        };

        ajax_normal(data, "/obtener-ingresos-salidas-envases");

    });

    $("#tipoProducto").on('change', function () {

        event.preventDefault();
        let id_opcion = $('#idopcion').val();
        let _token = $('#token').val();
        let producto = $('#producto').val();
        let subfamilia = $('#subfamilia').val();
        let familia = $('#familia').val();
        let tipo_producto = $('#tipoProducto').val();

        if (tipo_producto === undefined || tipo_producto === '') {
            alerterrorajax("Seleccione tipo producto");
            return false;
        }

        data = {
            _token: _token,
            id_opcion: id_opcion,
            producto: producto,
            subfamilia: subfamilia,
            familia: familia,
            tipo_producto: tipo_producto
        };

        ajax_normal_combo(data, "/obtener-combo-familia","ajax_familia_listar");
        ajax_normal_combo(data, "/obtener-combo-producto","ajax_producto_listar");

    });

    $(".reporteingresossalidas").on('change', '.select3', function () {

        event.preventDefault();
        let id_opcion = $('#idopcion').val();
        let _token = $('#token').val();
        let producto = $('#producto').val();
        let subfamilia = $('#subfamilia').val();
        let familia = $('#familia').val();
        let tipo_producto = $('#tipoProducto').val();

        if (familia === undefined || familia === '') {
            alerterrorajax("Seleccione familia");
            return false;
        }

        data = {
            _token: _token,
            id_opcion: id_opcion,
            producto: producto,
            subfamilia: subfamilia,
            familia: familia,
            tipo_producto: tipo_producto
        };

        ajax_normal_combo(data, "/obtener-combo-subfamilia","ajax_subfamilia_listar");
        ajax_normal_combo(data, "/obtener-combo-producto","ajax_producto_listar");

    });

    $(".reporteingresossalidas").on('change', '.select4', function () {

        event.preventDefault();
        let id_opcion = $('#idopcion').val();
        let _token = $('#token').val();
        let producto = $('#producto').val();
        let subfamilia = $('#subfamilia').val();
        let familia = $('#familia').val();
        let tipo_producto = $('#tipoProducto').val();

        if (subfamilia === undefined || subfamilia === '') {
            alerterrorajax("Seleccione subfamilia");
            return false;
        }

        data = {
            _token: _token,
            id_opcion: id_opcion,
            producto: producto,
            subfamilia: subfamilia,
            familia: familia,
            tipo_producto: tipo_producto
        };

        ajax_normal_combo(data, "/obtener-combo-producto","ajax_producto_listar");

    });
});
