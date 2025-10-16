function toggleContent() {
    var longText = document.getElementById('longText');
    var button = document.getElementById('toggleButton');
    if (longText.classList.contains('collapsed')) {
        longText.classList.remove('collapsed');
        button.innerHTML = "- Ver Menos";
    } else {
        longText.classList.add('collapsed');
        button.innerHTML = "+ Ver Más";
    }
}

// Inicialmente colapsar el contenido adicional
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('longText').classList.add('collapsed');
});


$(document).ready(function () {

    var carpeta = $("#carpeta").val();

    $(".secaprobar").on('click', '.mdidetoi', function (e) {
        var _token = $('#token').val();
        var idopcion = $('#idopcion').val();
        const data_doc = $(this).attr('data_doc');

        data = {
            _token: _token,
            data_doc: data_doc
        };
        ajax_modal(data, "/ajax-detalle-documento",
            "modal-detalle-requerimiento", "modal-detalle-requerimiento-container");


    });
//reparable

    $("#fecha_asiento_reparable").on('change', function (e) {

        let fecha = $('#fecha_asiento_reparable').val();
        let _token = $('#token').val();

        if (fecha === null || fecha.trim() === "") {
            $.alert({
                title: 'Error',
                content: 'No hay fecha seleccionada',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            })
            return false;
        }

        $.ajax({
            type: "POST",
            url: carpeta + "/obtener-periodo-tipo-cambio",
            data: { _token: _token, fecha: fecha },
            success: function (res) {
                $('#tipo_cambio_asiento_reparable').val(res.tipoCambio);

                window.selects['anio_asiento_reparable'].setSelected(res.anio.trim());
                $('#anio_asiento_reparable').trigger('change');

                setTimeout(function () {
                    window.selects['periodo_asiento_reparable'].setSelected(res.periodo.trim())
                    $('#periodo_asiento_reparable').trigger('change');
                }, 1000);

            },
            error: function (res) {
                error500(res);
            }
        });

    });

    $("#tipo_cambio_asiento_reparable").on('change', function (e) {

        let moneda = $('#moneda_asiento_reparable').val();
        let tc = $('#tipo_cambio_asiento_reparable').val();
        tc.replaceAll(/[\$,]/g, "");
        let arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable").value);

        if (moneda === null || moneda.trim() === "") {
            $.alert({
                title: 'Error',
                content: 'No hay moneda seleccionada',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        if (!tc || parseFloat(tc) === 0) {
            $.alert({
                title: 'Error',
                content: 'El tipo de cambio no puede ser 0',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (parseInt(item.COD_ESTADO) === 1) {
                if (moneda === 'MON0000000000001') {
                    item.CAN_DEBE_ME = redondear4(parseFloat(item.CAN_DEBE_MN) / parseFloat(tc));
                    item.CAN_HABER_ME = redondear4(parseFloat(item.CAN_HABER_MN) / parseFloat(tc));
                } else {
                    item.CAN_DEBE_MN = redondear4(parseFloat(item.CAN_DEBE_ME) / parseFloat(tc));
                    item.CAN_HABER_MN = redondear4(parseFloat(item.CAN_HABER_ME) / parseFloat(tc));
                }
            }
        });

        document.getElementById("asiento_detalle_reparable").value = JSON.stringify(arrayDetalle);

        // Después de actualizar arrayDetalle
        let table = $('#asientodetallereparable').DataTable();

        $("#asientodetallereparable tbody tr").each(function () {
            let fila = $(this);
            let codAsiento = fila.attr('data_codigo');
            arrayDetalle.forEach(item => {
                let asiento_id_editar = item.COD_ASIENTO_MOVIMIENTO;

                if (codAsiento === asiento_id_editar) {
                    // obtenemos el índice de la fila
                    let rowIdx = table.row(fila).index();

                    // actualizamos celdas por columna
                    table.cell(rowIdx, 1).data(item.TXT_CUENTA_CONTABLE);                       // Cuenta
                    table.cell(rowIdx, 2).data(item.TXT_GLOSA);                        // Descripción
                    table.cell(rowIdx, 3).data(number_format(item.CAN_DEBE_MN, 4));       // Debe MN
                    table.cell(rowIdx, 4).data(number_format(item.CAN_HABER_MN, 4));      // Haber MN
                    table.cell(rowIdx, 5).data(number_format(item.CAN_DEBE_ME, 4));       // Debe ME
                    table.cell(rowIdx, 6).data(number_format(item.CAN_HABER_ME, 4));      // Haber ME
                }
            });
        });

        // redibujar la tabla → esto dispara footerCallback y recalcula totales
        table.columns.adjust().draw();

    });

    $('#tipo_igv_id_reparable').on('change', function () {
        switch ($(this).val()) {
            case "CTI0000000000002":
            case "CTI0000000000003":
                $('#porc_tipo_igv_id_reparable')
                    .val('0')
                    .trigger('change')
                    .prop('disabled', true);
                break;

            case "CTI0000000000001":
                $('#porc_tipo_igv_id_reparable')
                    .val('18')
                    .trigger('change')
                    .prop('disabled', false);
                break;

            default:
                $('#porc_tipo_igv_id_reparable')
                    .val('')
                    .trigger('change')
                    .prop('disabled', true);
                break;
        }
    });

    $("#anio_asiento_reparable").on('change', function () {

        event.preventDefault();
        let anio = $('#anio_asiento').val();
        let _token = $('#token').val();
        //validacioones
        if (anio == '') {
            alerterrorajax("Seleccione un anio.");
            return false;
        }
        data = {
            _token: _token,
            anio: anio
        };

        ajax_normal_combo(data, "/ajax-combo-periodo-xanio-xempresareparable", "ajax_anio_asiento_reparable")

    });

    $(".btn-regresar-lista-reparable").on('click', function (e) {
        $('.tablageneralreparable').toggle("slow");
        $('.editarcuentasreparable').toggle("slow");
        setTimeout(function () {
            $('#asientodetallereparable').DataTable().columns.adjust().draw();
        }, 3000); // espera medio segundo o el tiempo necesario
    });

    $(document).on('click', ".editar-cuenta-reparable", function (e) {

        let data_codigo = $(this).parents('.fila').attr('data_codigo');
        let data_moneda = $(this).parents('.fila').attr('data_moneda');
        let data_tc = $(this).parents('.fila').attr('data_tc');
        let arrayDetalle = null;
        let data_cuenta_id = '';
        let data_debe_mn = 0.0000;
        let data_haber_mn = 0.0000;
        let data_debe_me = 0.0000;
        let data_haber_me = 0.0000;
        let data_afecto = '';
        let data_porc_afecto = '';
        let afecto = '';
        let partida = 'COP0000000000001';
        let monto = 0.0000;

        if (data_moneda === null || data_moneda.trim() === "") {
            $.alert({
                title: 'Error',
                content: 'No hay moneda seleccionada',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        if (!data_tc || parseFloat(data_tc) === 0) {
            $.alert({
                title: 'Error',
                content: 'El tipo de cambio no puede ser 0',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable").value);

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (item.COD_ASIENTO_MOVIMIENTO === data_codigo) {
                data_cuenta_id = item.COD_CUENTA_CONTABLE;
                data_debe_mn = item.CAN_DEBE_MN;
                data_haber_mn = item.CAN_HABER_MN;
                data_debe_me = item.CAN_DEBE_ME;
                data_haber_me = item.CAN_HABER_ME;
                data_afecto = item.COD_DOC_CTBLE_REF;
                data_porc_afecto = item.COD_ORDEN_REF;
                return; // saltar esta iteración
            }
        });

        switch (data_afecto) {
            case 'AIGV':
                afecto = 'CTI0000000000001';
                break;
            case 'IIGV':
                afecto = 'CTI0000000000002';
                break;
            case 'EIGV':
                afecto = 'CTI0000000000003';
                break;
            default:
                afecto = '';
                break;
        }

        if (parseFloat(data_haber_mn) > 0) {
            partida = 'COP0000000000002';
        }

        monto = parseFloat(data_debe_me) + parseFloat(data_haber_me);

        if (data_moneda === 'MON0000000000001') {
            monto = parseFloat(data_debe_mn) + parseFloat(data_haber_mn);
        }

        //$('#cuenta_contable_id_reparable').val(data_cuenta_id.trim()).trigger('change');
        //$('#partida_id_reparable').val(partida.trim()).trigger('change');
        //$('#tipo_igv_id_reparable').val(afecto.trim()).trigger('change');
        //$('#porc_tipo_igv_id_reparable').val(data_porc_afecto.trim()).trigger('change');

        window.selects['cuenta_contable_id_reparable'].setSelected(data_cuenta_id.trim());
        window.selects['partida_id_reparable'].setSelected(partida.trim());
        window.selects['tipo_igv_id_reparable'].setSelected(afecto.trim());
        window.selects['porc_tipo_igv_id_reparable'].setSelected(data_porc_afecto.trim());
        $('#cuenta_contable_id_reparable').trigger('change');
        $('#partida_id_reparable').trigger('change');
        $('#tipo_igv_id_reparable').trigger('change');
        $('#porc_tipo_igv_id_reparable').trigger('change');

        $('#monto_reparable').val(monto);

        $('#asiento_id_editar_reparable').val(data_codigo);
        $('#moneda_id_editar_reparable').val(data_moneda);
        $('#tc_editar_reparable').val(data_tc);
        $('#titulodetallereparable').text('Modificar Detalle');
        $('.btn-registrar-movimiento-reparable').hide();
        $('.btn-editar-movimiento-reparable').show();
        $('.tablageneralreparable').toggle("slow");
        $('.editarcuentasreparable').toggle("slow");

    });

    $(document).on('click', ".eliminar-cuenta-reparable", function (e) {

        let data_codigo = $(this).parents('.fila').attr('data_codigo');
        let arrayDetalle = null;

        arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable").value);

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (item.COD_ASIENTO_MOVIMIENTO === data_codigo) {
                item.COD_ESTADO = '0';
                return; // saltar esta iteración
            }
        });

        document.getElementById("asiento_detalle_reparable").value = JSON.stringify(arrayDetalle);

        let table = $('#asientodetallereparable').DataTable();
        let row = $(this).closest('tr');
        table.row(row).remove().draw();

        //$(this).closest("tr").remove();

    });

    $(".agregar-linea-reparable").on('click', function (e) {

        let data_codigo = 'ASTMOV';
        let data_moneda = document.getElementById("moneda_asiento_reparable").value;
        let data_tc = document.getElementById("tipo_cambio_asiento_reparable").value;
        let arrayDetalle = null;
        let data_cuenta_id = '';
        let data_porc_afecto = '';
        let afecto = '';
        let partida = '';
        let monto = 0.0000;

        if (data_moneda === null || data_moneda.trim() === "") {
            $.alert({
                title: 'Error',
                content: 'No hay moneda seleccionada',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        if (!data_tc || parseFloat(data_tc) === 0) {
            $.alert({
                title: 'Error',
                content: 'El tipo de cambio no puede ser 0',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable").value);

        data_codigo = data_codigo + (arrayDetalle.length + 1).toString();

        window.selects['cuenta_contable_id_reparable'].setSelected(data_cuenta_id.trim());
        window.selects['partida_id_reparable'].setSelected(partida.trim());
        window.selects['tipo_igv_id_reparable'].setSelected(afecto.trim());
        window.selects['porc_tipo_igv_id_reparable'].setSelected(data_porc_afecto.trim());
        $('#cuenta_contable_id_reparable').trigger('change');
        $('#partida_id_reparable').trigger('change');
        $('#tipo_igv_id_reparable').trigger('change');
        $('#porc_tipo_igv_id_reparable').trigger('change');
        $('#monto_reparable').val(monto);

        $('#asiento_id_editar_reparable').val(data_codigo);
        $('#moneda_id_editar_reparable').val(data_moneda);
        $('#tc_editar_reparable').val(data_tc);
        $('#titulodetallereparable').text('Registrar Detalle');
        $('.btn-editar-movimiento-reparable').hide();
        $('.btn-registrar-movimiento-reparable').show();
        $('.tablageneralreparable').toggle("slow");
        $('.editarcuentasreparable').toggle("slow");

    });

    $(".btn-editar-movimiento-reparable").on('click', function (e) {

        let cuenta_contable_id = $('#cuenta_contable_id_reparable').val();
        let afecto_igv = $('#tipo_igv_id_reparable').val();
        let porc_afecto_igv = $('#porc_tipo_igv_id_reparable').val();
        let monto = $('#monto_reparable').val();
        monto = monto.replaceAll(/[\$,]/g, "");
        let partida_id = $('#partida_id_reparable').val();
        let activo = $('#activo_reparable').val();
        let texto = $("#cuenta_contable_id_reparable option:selected").text();
        let numero_cuenta = texto.split(" - ")[0];
        let glosa_cuenta = texto.split(" - ")[1];

        let asiento_id_editar = $('#asiento_id_editar_reparable').val();
        let moneda_id_editar = $('#moneda_id_editar_reparable').val();
        let tc_editar = $('#tc_editar_reparable').val();

        let arrayDetalle = null;
        let can_debe_mn = 0.0000;
        let can_haber_mn = 0.0000;
        let can_debe_me = 0.0000;
        let can_haber_me = 0.0000;

        if (monto === '' || monto === '0.0000') {
            alerterrorajax("Ingrese un monto");
            return false;
        }
        if (cuenta_contable_id === '') {
            alerterrorajax("Seleccione una cuenta contable.");
            return false;
        }
        if (partida_id === '') {
            alerterrorajax("Seleccione una partida.");
            return false;
        }

        switch (afecto_igv) {
            case 'CTI0000000000001':
                afecto_igv = 'AIGV';
                break;
            case 'CTI0000000000002':
                afecto_igv = 'IIGV';
                break;
            case 'CTI0000000000003':
                afecto_igv = 'EIGV';
                break;
            default:
                afecto_igv = '';
                break;
        }

        switch (afecto_igv) {
            case 'AIGV':
                if (porc_afecto_igv === '' || porc_afecto_igv === '0') {
                    alerterrorajax("Selecciono Afecto debe tener porcentaje de IGV.");
                    return false;
                }
                break;
            case 'IIGV':
                if (porc_afecto_igv === '10' || porc_afecto_igv === '18') {
                    alerterrorajax("Selecciono Inafecto no puede tener porcentaje de IGV.");
                    return false;
                }
                break;
            case 'EIGV':
                if (porc_afecto_igv === '10' || porc_afecto_igv === '18') {
                    alerterrorajax("Selecciono Exonerado no puede tener porcentaje de IGV.");
                    return false;
                }
                break;
            default:
                if (porc_afecto_igv === '10' || porc_afecto_igv === '18' || porc_afecto_igv === '0') {
                    alerterrorajax("No se selecciono afecto IGV no puede ingresar porcentaje de IGV.");
                    return false;
                }
                break;
        }

        arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable").value);

        if (moneda_id_editar === 'MON0000000000001') {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = redondear4(parseFloat(monto));
                can_haber_mn = 0.0000;
                can_debe_me = redondear4(parseFloat(monto) / tc_editar);
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = redondear4(parseFloat(monto));
                can_debe_me = 0.0000;
                can_haber_me = redondear4(parseFloat(monto) / tc_editar);
            }
        } else {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = redondear4(parseFloat(monto) * tc_editar);
                can_haber_mn = 0.0000;
                can_debe_me = redondear4(parseFloat(monto));
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = redondear4(parseFloat(monto) * tc_editar);
                can_debe_me = 0.0000;
                can_haber_me = redondear4(parseFloat(monto));
            }
        }

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (parseInt(item.COD_ESTADO) === 1) {
                if (item.COD_ASIENTO_MOVIMIENTO === asiento_id_editar) {
                    item.COD_CUENTA_CONTABLE = cuenta_contable_id;
                    item.TXT_CUENTA_CONTABLE = numero_cuenta;
                    item.TXT_GLOSA = glosa_cuenta;
                    item.COD_PRODUCTO = '';
                    item.TXT_NOMBRE_PRODUCTO = '';
                    item.COD_LOTE = '';
                    item.NRO_LINEA_PRODUCTO = '0';
                    item.CAN_DEBE_MN = can_debe_mn;
                    item.CAN_HABER_MN = can_haber_mn;
                    item.CAN_DEBE_ME = can_debe_me;
                    item.CAN_HABER_ME = can_haber_me;
                    item.COD_DOC_CTBLE_REF = afecto_igv;
                    item.COD_ORDEN_REF = porc_afecto_igv;
                    item.COD_ESTADO = activo;
                }
            }
        });

        document.getElementById("asiento_detalle_reparable").value = JSON.stringify(arrayDetalle);
        // Después de actualizar arrayDetalle
        let table = $('#asientodetallereparable').DataTable();

        $("#asientodetallereparable tbody tr").each(function () {
            let fila = $(this);
            let codAsiento = fila.attr('data_codigo');

            if (codAsiento === asiento_id_editar) {
                // obtenemos el índice de la fila
                let rowIdx = table.row(fila).index();

                // actualizamos celdas por columna
                table.cell(rowIdx, 1).data(numero_cuenta);                       // Cuenta
                table.cell(rowIdx, 2).data(glosa_cuenta);                        // Descripción
                table.cell(rowIdx, 3).data(number_format(can_debe_mn, 4));       // Debe MN
                table.cell(rowIdx, 4).data(number_format(can_haber_mn, 4));      // Haber MN
                table.cell(rowIdx, 5).data(number_format(can_debe_me, 4));       // Debe ME
                table.cell(rowIdx, 6).data(number_format(can_haber_me, 4));      // Haber ME
            }
        });

// redibujar la tabla → esto dispara footerCallback y recalcula totales
        table.columns.adjust().draw();
        /*
        $("#asientodetallereparable tbody tr").each(function () {
            let fila = $(this);

            // buscamos en la fila el hidden con el id del asiento
            let codAsiento = fila.attr('data_codigo');

            if (codAsiento === asiento_id_editar) {
                // Actualizar las celdas visibles de la tabla
                fila.find(".col-cuenta").text(numero_cuenta);
                fila.find(".col-glosa").text(glosa_cuenta);
                fila.find(".col-debe-mn").text(number_format(can_debe_mn, 4));
                fila.find(".col-haber-mn").text(number_format(can_haber_mn, 4));
                fila.find(".col-debe-me").text(number_format(can_debe_me, 4));
                fila.find(".col-haber-me").text(number_format(can_haber_me, 4));
            }
        });*/

        $('.tablageneralreparable').toggle("slow");
        $('.editarcuentasreparable').toggle("slow");

        setTimeout(function () {
            $('#asientodetallereparable').DataTable().columns.adjust().draw();
        }, 3000); // espera medio segundo o el tiempo necesario
    });

    $(".btn-registrar-movimiento-reparable").on('click', function (e) {

        let cuenta_contable_id = $('#cuenta_contable_id_reparable').val();
        let afecto_igv = $('#tipo_igv_id_reparable').val();
        let porc_afecto_igv = $('#porc_tipo_igv_id_reparable').val();
        let monto = $('#monto_reparable').val();
        monto = monto.replaceAll(/[\$,]/g, "");
        let partida_id = $('#partida_id_reparable').val();
        let activo = $('#activo_reparable').val();
        let texto = $("#cuenta_contable_id_reparable option:selected").text();
        let numero_cuenta = texto.split(" - ")[0];
        let glosa_cuenta = texto.split(" - ")[1];

        let asiento_id_editar = $('#asiento_id_editar_reparable').val();
        let moneda_id_editar = $('#moneda_id_editar_reparable').val();
        let tc_editar = $('#tc_editar_reparable').val();

        let arrayDetalle = null;
        let can_debe_mn = 0.0000;
        let can_haber_mn = 0.0000;
        let can_debe_me = 0.0000;
        let can_haber_me = 0.0000;
        let ind_producto = 0;

        if (monto === '' || monto === '0.0000') {
            alerterrorajax("Ingrese un monto");
            return false;
        }
        if (cuenta_contable_id === '') {
            alerterrorajax("Seleccione una cuenta contable.");
            return false;
        }
        if (partida_id === '') {
            alerterrorajax("Seleccione una partida.");
            return false;
        }

        switch (afecto_igv) {
            case 'CTI0000000000001':
                afecto_igv = 'AIGV';
                break;
            case 'CTI0000000000002':
                afecto_igv = 'IIGV';
                break;
            case 'CTI0000000000003':
                afecto_igv = 'EIGV';
                break;
            default:
                afecto_igv = '';
                break;
        }

        switch (afecto_igv) {
            case 'AIGV':
                if (porc_afecto_igv === '' || porc_afecto_igv === '0') {
                    alerterrorajax("Selecciono Afecto debe tener porcentaje de IGV.");
                    return false;
                }
                break;
            case 'IIGV':
                if (porc_afecto_igv === '10' || porc_afecto_igv === '18') {
                    alerterrorajax("Selecciono Inafecto no puede tener porcentaje de IGV.");
                    return false;
                }
                break;
            case 'EIGV':
                if (porc_afecto_igv === '10' || porc_afecto_igv === '18') {
                    alerterrorajax("Selecciono Exonerado no puede tener porcentaje de IGV.");
                    return false;
                }
                break;
            default:
                if (porc_afecto_igv === '10' || porc_afecto_igv === '18' || porc_afecto_igv === '0') {
                    alerterrorajax("No se selecciono afecto IGV no puede ingresar porcentaje de IGV.");
                    return false;
                }
                break;
        }

        arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable").value);

        if (moneda_id_editar === 'MON0000000000001') {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = redondear4(parseFloat(monto));
                can_haber_mn = 0.0000;
                can_debe_me = redondear4(parseFloat(monto) / tc_editar);
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = redondear4(parseFloat(monto));
                can_debe_me = 0.0000;
                can_haber_me = redondear4(parseFloat(monto) / tc_editar);
            }
        } else {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = redondear4(parseFloat(monto) * tc_editar);
                can_haber_mn = 0.0000;
                can_debe_me = redondear4(parseFloat(monto));
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = redondear4(parseFloat(monto) * tc_editar);
                can_debe_me = 0.0000;
                can_haber_me = redondear4(parseFloat(monto));
            }
        }

        if (afecto_igv !== '') {
            ind_producto = 1;
        }

        // Nuevo objeto con todos los campos
        let nuevoMovimiento = {
            "COD_ASIENTO_MOVIMIENTO": asiento_id_editar,
            "COD_EMPR": "IACHEM0000010394",
            "COD_CENTRO": "CEN0000000000002",
            "COD_ASIENTO": "IIBEAC0000000001",
            "COD_CUENTA_CONTABLE": cuenta_contable_id,
            "IND_PRODUCTO": ind_producto,
            "TXT_CUENTA_CONTABLE": numero_cuenta,
            "TXT_GLOSA": glosa_cuenta,
            "CAN_DEBE_MN": can_debe_mn,
            "CAN_HABER_MN": can_haber_mn,
            "CAN_DEBE_ME": can_debe_me,
            "CAN_HABER_ME": can_haber_me,
            "NRO_LINEA": "4",
            "COD_CUO": "",
            "IND_EXTORNO": "0",
            "TXT_TIPO_REFERENCIA": "",
            "TXT_REFERENCIA": "",
            "COD_USUARIO_CREA_AUD": "1CIX00000001",
            "FEC_USUARIO_CREA_AUD": "2025-08-19 14:30:00",
            "COD_USUARIO_MODIF_AUD": "",
            "FEC_USUARIO_MODIF_AUD": "2025-08-19 14:30:00",
            "COD_ESTADO": activo,
            "COD_DOC_CTBLE_REF": afecto_igv,
            "COD_ORDEN_REF": porc_afecto_igv,
            "COD_PRODUCTO": "",
            "TXT_NOMBRE_PRODUCTO": "",
            "COD_LOTE": "",
            "NRO_LINEA_PRODUCTO": "0",
            "COD_EMPR_CLI_REF": "",
            "TXT_EMPR_CLI_REF": "",
            "DOCUMENTO_REF": "",
            "CODIGO_CONTABLE": ""
        };

        arrayDetalle.push(nuevoMovimiento);

        let table = $('#asientodetallereparable').DataTable();

        // Crear la fila con atributos y estilos
        let nuevaFila = `
            <tr class="fila" data_codigo="${asiento_id_editar}"
                data_moneda="${moneda_id_editar}" data_tc="${tc_editar}">
                <td class="col-codigo">${asiento_id_editar}</td>
                <td class="col-cuenta">${numero_cuenta}</td>
                <td class="col-glosa">${glosa_cuenta}</td>
                <td class="col-debe-mn" style="text-align: right">${number_format(can_debe_mn, 4)}</td>
                <td class="col-haber-mn" style="text-align: right">${number_format(can_haber_mn, 4)}</td>
                <td class="col-debe-me" style="text-align: right">${number_format(can_debe_me, 4)}</td>
                <td class="col-haber-me" style="text-align: right">${number_format(can_haber_me, 4)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary editar-cuenta-reparable">
                        ✏ Editar
                    </button>
                    <button type="button" class="btn btn-sm btn-danger eliminar-cuenta-reparable">
                        🗑 Eliminar
                    </button>
                </td>
            </tr>
        `;

        document.getElementById("asiento_detalle_reparable").value = JSON.stringify(arrayDetalle);
        // Después de actualizar arrayDetalle
        table.row.add($(nuevaFila)).draw(false);

        $('.tablageneralreparable').toggle("slow");
        $('.editarcuentasreparable').toggle("slow");

        setTimeout(function () {
            table.columns.adjust().draw();
        }, 3000); // espera medio segundo o el tiempo necesario
    });

    //nuevo reparable
    //no reparable

    $(".diferencia-montos").on('click', function (e) {
        let totalDebeMN = 0;
        let totalHaberMN = 0;
        let totalDebeME = 0;
        let totalHaberME = 0;
        let diferencia = 0;
        let diferenciaME = 0;
        let table = $('#asientodetalle').DataTable();
        let arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);
        let data_asiento = $(this).attr("data");
        let array_text = "asiento_detalle_compra";
        let table_text = "#asientodetalle tbody tr";
        let totalAsiento = parseFloat(document.getElementById("total_xml").value.replaceAll(/[\$,]/g, "")) || 0;
        let totalAsientoOriginal = parseFloat(document.getElementById("total_xml").value.replaceAll(/[\$,]/g, "")) || 0;
        let moneda = $('#moneda_asiento').val();
        let tc = $('#tipo_cambio_asiento').val().replaceAll(/[\$,]/g, "");

        if (moneda === null || moneda.trim() === "") {
            $.alert({
                title: 'Error',
                content: 'No hay moneda seleccionada',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        if (!tc || parseFloat(tc) === 0) {
            $.alert({
                title: 'Error',
                content: 'El tipo de cambio no puede ser 0',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        switch (data_asiento) {
            case 'C':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);
                table = $('#asientodetalle').DataTable();
                array_text = "asiento_detalle_compra";
                table_text = "#asientodetalle tbody tr";
                totalAsiento = parseFloat(document.getElementById("total_xml").value.replaceAll(/[\$,]/g, "")) || 0;
                totalAsientoOriginal = parseFloat(document.getElementById("total_xml").value.replaceAll(/[\$,]/g, "")) || 0;
                break;
            case 'RV':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable_reversion").value);
                table = $('#asientodetallereversion').DataTable();
                array_text = "asiento_detalle_reparable_reversion";
                table_text = "#asientodetallereversion tbody tr";
                totalAsiento = parseFloat(document.getElementById("total_xml").value.replaceAll(/[\$,]/g, "")) || 0;
                totalAsientoOriginal = parseFloat(document.getElementById("total_xml").value.replaceAll(/[\$,]/g, "")) || 0;
                break;
            case 'D':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_deduccion").value);
                table = $('#asientodetallededuccion').DataTable();
                array_text = "asiento_detalle_deduccion";
                table_text = "#asientodetallededuccion tbody tr";
                totalAsiento = parseFloat(document.getElementById("anticipo_xml").value.replaceAll(/[\$,]/g, "")) || 0;
                totalAsientoOriginal = parseFloat(document.getElementById("anticipo_xml").value.replaceAll(/[\$,]/g, "")) || 0;
                break;
            case 'P':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_percepcion").value);
                table = $('#asientodetallepercepcion').DataTable();
                array_text = "asiento_detalle_percepcion";
                table_text = "#asientodetallepercepcion tbody tr";
                totalAsiento = parseFloat(document.getElementById("percepcion_xml").value.replaceAll(/[\$,]/g, "")) || 0;
                totalAsientoOriginal = parseFloat(document.getElementById("percepcion_xml").value.replaceAll(/[\$,]/g, "")) || 0;
                break;
        }

        // recorrer filas y acumular
        $(table_text).each(function () {
            let debeMN = parseFloat($(this).find("td:eq(3)").text().replaceAll(/[\$,]/g, "")) || 0; // Debe MN
            let haberMN = parseFloat($(this).find("td:eq(4)").text().replaceAll(/[\$,]/g, "")) || 0; // Haber MN
            let debeME = parseFloat($(this).find("td:eq(5)").text().replaceAll(/[\$,]/g, "")) || 0; // Debe ME
            let haberME = parseFloat($(this).find("td:eq(6)").text().replaceAll(/[\$,]/g, "")) || 0; // Haber ME

            totalDebeMN += debeMN;
            totalHaberMN += haberMN;
            totalDebeME += debeME;
            totalHaberME += haberME;
        });

        totalDebeMN = redondear4(totalDebeMN);
        totalHaberMN = redondear4(totalHaberMN);
        totalDebeME = redondear4(totalDebeME);
        totalHaberME = redondear4(totalHaberME);

        // calcular diferencia
        diferencia = totalHaberMN - totalDebeMN;

        diferencia = redondear4(diferencia);

        if (moneda === 'MON0000000000001') {
            totalAsiento = redondear4(totalAsientoOriginal);
        } else {
            totalAsiento = redondear4(totalAsientoOriginal * parseFloat(tc));
        }

        // si la diferencia es menor o igual a 0.1, ajustar
        if (Math.abs(diferencia) > 0 && Math.abs(diferencia) < 0.1) {

            // Recorrerlo
            for (let item of arrayDetalle) {
                if (totalAsiento > totalHaberMN || totalAsiento < totalHaberMN) {
                    if (!/^40/.test(item.TXT_CUENTA_CONTABLE) && parseFloat(item.CAN_HABER_MN) > 0.0000) {
                        if (totalAsiento > totalHaberMN) {
                            item.CAN_HABER_MN = redondear4(parseFloat(item.CAN_HABER_MN) + Math.abs(diferencia));
                        } else {
                            item.CAN_HABER_MN = redondear4(parseFloat(item.CAN_HABER_MN) - Math.abs(diferencia));
                        }
                        break; // ✅ Rompe el bucle
                    }
                }

                if (totalAsiento > totalDebeMN || totalAsiento < totalDebeMN) {
                    if (!/^40/.test(item.TXT_CUENTA_CONTABLE) && parseFloat(item.CAN_DEBE_MN) > 0.0000) {
                        if (totalAsiento > totalDebeMN) {
                            item.CAN_DEBE_MN = redondear4(parseFloat(item.CAN_DEBE_MN) + Math.abs(diferencia));
                        } else {
                            item.CAN_DEBE_MN = redondear4(parseFloat(item.CAN_DEBE_MN) - Math.abs(diferencia));
                        }
                        break; // ✅ Rompe el bucle
                    }
                }
            }

            document.getElementById(array_text).value = JSON.stringify(arrayDetalle);

            // recorrer filas y hacer el cambio
            $(table_text).each(function () {
                let fila = $(this);

                // obtenemos el índice de la fila
                let rowIdx = table.row(fila).index();

                // obtenemos el numero de cuenta
                let numero_cuenta = table.cell(rowIdx, 1).data();

                // ejemplo: obtener el valor actual de la columna 3 (Debe MN)
                let debeMN = parseFloat(table.cell(rowIdx, 3).data().replaceAll(/[\$,]/g, "")) || 0;
                let haberMN = parseFloat(table.cell(rowIdx, 4).data().replaceAll(/[\$,]/g, "")) || 0;

                if (totalAsiento > totalHaberMN || totalAsiento < totalHaberMN) {
                    if (!/^40/.test(numero_cuenta) && haberMN > 0.0000) {
                        let nuevoHaberMN = totalAsiento > totalHaberMN
                            ? haberMN + Math.abs(diferencia)
                            : haberMN - Math.abs(diferencia);

                        table.cell(rowIdx, 4).data(number_format(nuevoHaberMN, 4));
                        table.row(rowIdx).invalidate().draw(false);

                        return false; // ✅ Rompe el bucle de jQuery.each
                    }
                }

                if (totalAsiento > totalDebeMN || totalAsiento < totalDebeMN) {
                    if (!/^40/.test(numero_cuenta) && debeMN > 0.0000) {
                        let nuevoDebeMN = totalAsiento > totalDebeMN
                            ? debeMN + Math.abs(diferencia)
                            : debeMN - Math.abs(diferencia);

                        table.cell(rowIdx, 3).data(number_format(nuevoDebeMN, 4));
                        table.row(rowIdx).invalidate().draw(false);

                        return false; // ✅ Rompe el bucle de jQuery.each
                    }
                }
            });

            // redibujar la tabla → esto dispara footerCallback y recalcula totales
            table.columns.adjust().draw();

            //alert("🔄 Totales ajustados automáticamente (diferencia menor o igual a 0.1).");
            $.alert({
                title: 'Success',
                content: "🔄 Totales de Moneda Nacional ajustados automáticamente (diferencia menor o igual a 0.1).",
                type: 'green',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-green',
                    }
                }
            });
        } else if (diferencia !== 0) {
            //alert("⚠️ Los totales no cuadran. Diferencia: " + diferencia.toFixed(2));
            $.alert({
                title: 'Error',
                content: "⚠️ Los totales de Moneda Nacional no cuadran. Diferencia: " + diferencia.toFixed(2),
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
        }

        debugger;

        // calcular diferencia
        diferencia = totalHaberME - totalDebeME;

        diferencia = redondear4(diferencia);

        if (moneda === 'MON0000000000001') {
            totalAsiento = redondear4(totalAsientoOriginal / parseFloat(tc));
        } else {
            totalAsiento = redondear4(totalAsientoOriginal);
        }

        // si la diferencia es menor o igual a 0.1, ajustar
        if (Math.abs(diferencia) > 0 && Math.abs(diferencia) < 0.1) {

            debugger;

            // Recorrerlo
            for (let item of arrayDetalle) {
                debugger;
                //if (totalAsiento > totalHaberME || totalAsiento < totalHaberME) {
                if (totalDebeME > totalHaberME || totalDebeME < totalHaberME) {
                    if (!/^40/.test(item.TXT_CUENTA_CONTABLE) && parseFloat(item.CAN_HABER_ME) > 0.0000) {
                        //if (totalAsiento > totalHaberME) {
                        if (totalDebeME > totalHaberME) {
                            item.CAN_HABER_ME = redondear4(parseFloat(item.CAN_HABER_ME) + Math.abs(diferencia));
                        } else {
                            item.CAN_HABER_ME = redondear4(parseFloat(item.CAN_HABER_ME) - Math.abs(diferencia));
                        }
                        break; // ✅ aquí se rompe el bucle
                    }
                }

                //if (totalAsiento > totalDebeME || totalAsiento < totalDebeME) {
                if (totalHaberME > totalDebeME || totalHaberME < totalDebeME) {
                    if (!/^40/.test(item.TXT_CUENTA_CONTABLE) && parseFloat(item.CAN_DEBE_ME) > 0.0000) {
                        //if (totalAsiento > totalDebeME) {
                        if (totalHaberME > totalDebeME) {
                            item.CAN_DEBE_ME = redondear4(parseFloat(item.CAN_DEBE_ME) + Math.abs(diferencia));
                        } else {
                            item.CAN_DEBE_ME = redondear4(parseFloat(item.CAN_DEBE_ME) - Math.abs(diferencia));
                        }
                        break; // ✅ aquí se rompe el bucle
                    }
                }
            }

            document.getElementById(array_text).value = JSON.stringify(arrayDetalle);

            // recorrer filas y hacer el cambio
            $(table_text).each(function (index) {
                debugger;
                let fila = $(this);
                let rowIdx = table.row(fila).index();
                let numero_cuenta = table.cell(rowIdx, 1).data();

                let debeME = parseFloat(table.cell(rowIdx, 5).data().replaceAll(/[\$,]/g, "")) || 0;
                let haberME = parseFloat(table.cell(rowIdx, 6).data().replaceAll(/[\$,]/g, "")) || 0;

                //if (totalAsiento > totalHaberME || totalAsiento < totalHaberME) {
                if (totalDebeME > totalHaberME || totalDebeME < totalHaberME) {
                    if (!/^40/.test(numero_cuenta) && haberME > 0) {
                        //let nuevoHaberME = totalAsiento > totalHaberME
                        let nuevoHaberME = totalDebeME > totalHaberME
                            ? haberME + Math.abs(diferencia)
                            : haberME - Math.abs(diferencia);

                        table.cell(rowIdx, 6).data(number_format(nuevoHaberME, 4));
                        table.row(rowIdx).invalidate().draw(false);

                        return false; // ✅ en jQuery .each, return false rompe el bucle
                    }
                }

                //if (totalAsiento > totalDebeME || totalAsiento < totalDebeME) {
                if (totalHaberME > totalDebeME || totalHaberME < totalDebeME) {
                    if (!/^40/.test(numero_cuenta) && debeME > 0) {
                        //let nuevoDebeME = totalAsiento > totalDebeME
                        let nuevoDebeME = totalHaberME > totalDebeME
                            ? debeME + Math.abs(diferencia)
                            : debeME - Math.abs(diferencia);

                        table.cell(rowIdx, 5).data(number_format(nuevoDebeME, 4));
                        table.row(rowIdx).invalidate().draw(false);

                        return false; // ✅ corta el bucle en jQuery
                    }
                }
            });

            // redibujar la tabla → esto dispara footerCallback y recalcula totales
            table.columns.adjust().draw();

            //alert("🔄 Totales ajustados automáticamente (diferencia menor o igual a 0.1).");
            $.alert({
                title: 'Success',
                content: "🔄 Totales de Moneda Extrajera ajustados automáticamente (diferencia menor o igual a 0.1).",
                type: 'green',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-green',
                    }
                }
            });
        } else if (diferencia !== 0) {
            //alert("⚠️ Los totales no cuadran. Diferencia: " + diferencia.toFixed(2));
            $.alert({
                title: 'Error',
                content: "⚠️ Los totales de Moneda Extrajera no cuadran. Diferencia: " + diferencia.toFixed(2),
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
        }
    });

    $("#tipo_cambio_asiento").on('change', function (e) {

        let moneda = $('#moneda_asiento').val();
        let tc = $('#tipo_cambio_asiento').val();
        tc.replaceAll(/[\$,]/g, "");
        let arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);
        let table = $('#asientodetalle').DataTable();

        if (moneda === null || moneda.trim() === "") {
            $.alert({
                title: 'Error',
                content: 'No hay moneda seleccionada',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        if (!tc || parseFloat(tc) === 0) {
            $.alert({
                title: 'Error',
                content: 'El tipo de cambio no puede ser 0',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (parseInt(item.COD_ESTADO) === 1) {
                if (moneda === 'MON0000000000001') {
                    item.CAN_DEBE_ME = redondear4(parseFloat(item.CAN_DEBE_MN) / parseFloat(tc));
                    item.CAN_HABER_ME = redondear4(parseFloat(item.CAN_HABER_MN) / parseFloat(tc));
                } else {
                    item.CAN_DEBE_MN = redondear4(parseFloat(item.CAN_DEBE_ME) / parseFloat(tc));
                    item.CAN_HABER_MN = redondear4(parseFloat(item.CAN_HABER_ME) / parseFloat(tc));
                }
            }
        });

        document.getElementById("asiento_detalle_compra").value = JSON.stringify(arrayDetalle);

        // Después de actualizar arrayDetalle

        $("#asientodetalle tbody tr").each(function () {
            let fila = $(this);
            let codAsiento = fila.attr('data_codigo');
            arrayDetalle.forEach(item => {
                let asiento_id_editar = item.COD_ASIENTO_MOVIMIENTO;

                if (codAsiento === asiento_id_editar) {
                    // obtenemos el índice de la fila
                    let rowIdx = table.row(fila).index();

                    // actualizamos celdas por columna
                    table.cell(rowIdx, 1).data(item.TXT_CUENTA_CONTABLE);                       // Cuenta
                    table.cell(rowIdx, 2).data(item.TXT_GLOSA);                        // Descripción
                    table.cell(rowIdx, 3).data(number_format(item.CAN_DEBE_MN, 4));       // Debe MN
                    table.cell(rowIdx, 4).data(number_format(item.CAN_HABER_MN, 4));      // Haber MN
                    table.cell(rowIdx, 5).data(number_format(item.CAN_DEBE_ME, 4));       // Debe ME
                    table.cell(rowIdx, 6).data(number_format(item.CAN_HABER_ME, 4));      // Haber ME
                }
            });
        });

        // redibujar la tabla → esto dispara footerCallback y recalcula totales
        table.columns.adjust().draw();

        arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable_reversion").value);
        table = $('#asientodetallereversion').DataTable();

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (parseInt(item.COD_ESTADO) === 1) {
                if (moneda === 'MON0000000000001') {
                    item.CAN_DEBE_ME = redondear4(parseFloat(item.CAN_DEBE_MN) / parseFloat(tc));
                    item.CAN_HABER_ME = redondear4(parseFloat(item.CAN_HABER_MN) / parseFloat(tc));
                } else {
                    item.CAN_DEBE_MN = redondear4(parseFloat(item.CAN_DEBE_ME) / parseFloat(tc));
                    item.CAN_HABER_MN = redondear4(parseFloat(item.CAN_HABER_ME) / parseFloat(tc));
                }
            }
        });

        document.getElementById("asiento_detalle_reparable_reversion").value = JSON.stringify(arrayDetalle);

        // Después de actualizar arrayDetalle

        $("#asientodetallereversion tbody tr").each(function () {
            let fila = $(this);
            let codAsiento = fila.attr('data_codigo');
            arrayDetalle.forEach(item => {
                let asiento_id_editar = item.COD_ASIENTO_MOVIMIENTO;

                if (codAsiento === asiento_id_editar) {
                    // obtenemos el índice de la fila
                    let rowIdx = table.row(fila).index();

                    // actualizamos celdas por columna
                    table.cell(rowIdx, 1).data(item.TXT_CUENTA_CONTABLE);                       // Cuenta
                    table.cell(rowIdx, 2).data(item.TXT_GLOSA);                        // Descripción
                    table.cell(rowIdx, 3).data(number_format(item.CAN_DEBE_MN, 4));       // Debe MN
                    table.cell(rowIdx, 4).data(number_format(item.CAN_HABER_MN, 4));      // Haber MN
                    table.cell(rowIdx, 5).data(number_format(item.CAN_DEBE_ME, 4));       // Debe ME
                    table.cell(rowIdx, 6).data(number_format(item.CAN_HABER_ME, 4));      // Haber ME
                }
            });
        });

        // redibujar la tabla → esto dispara footerCallback y recalcula totales
        table.columns.adjust().draw();

        arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_deduccion").value);
        table = $('#asientodetallededuccion').DataTable();

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (parseInt(item.COD_ESTADO) === 1) {
                if (moneda === 'MON0000000000001') {
                    item.CAN_DEBE_ME = redondear4(parseFloat(item.CAN_DEBE_MN) / parseFloat(tc));
                    item.CAN_HABER_ME = redondear4(parseFloat(item.CAN_HABER_MN) / parseFloat(tc));
                } else {
                    item.CAN_DEBE_MN = redondear4(parseFloat(item.CAN_DEBE_ME) / parseFloat(tc));
                    item.CAN_HABER_MN = redondear4(parseFloat(item.CAN_HABER_ME) / parseFloat(tc));
                }
            }
        });

        document.getElementById("asiento_detalle_deduccion").value = JSON.stringify(arrayDetalle);

        // Después de actualizar arrayDetalle

        $("#asientodetallededuccion tbody tr").each(function () {
            let fila = $(this);
            let codAsiento = fila.attr('data_codigo');
            arrayDetalle.forEach(item => {
                let asiento_id_editar = item.COD_ASIENTO_MOVIMIENTO;

                if (codAsiento === asiento_id_editar) {
                    // obtenemos el índice de la fila
                    let rowIdx = table.row(fila).index();

                    // actualizamos celdas por columna
                    table.cell(rowIdx, 1).data(item.TXT_CUENTA_CONTABLE);                       // Cuenta
                    table.cell(rowIdx, 2).data(item.TXT_GLOSA);                        // Descripción
                    table.cell(rowIdx, 3).data(number_format(item.CAN_DEBE_MN, 4));       // Debe MN
                    table.cell(rowIdx, 4).data(number_format(item.CAN_HABER_MN, 4));      // Haber MN
                    table.cell(rowIdx, 5).data(number_format(item.CAN_DEBE_ME, 4));       // Debe ME
                    table.cell(rowIdx, 6).data(number_format(item.CAN_HABER_ME, 4));      // Haber ME
                }
            });
        });

        // redibujar la tabla → esto dispara footerCallback y recalcula totales
        table.columns.adjust().draw();

        arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_percepcion").value);
        table = $('#asientodetallepercepcion').DataTable();

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (parseInt(item.COD_ESTADO) === 1) {
                if (moneda === 'MON0000000000001') {
                    item.CAN_DEBE_ME = redondear4(parseFloat(item.CAN_DEBE_MN) / parseFloat(tc));
                    item.CAN_HABER_ME = redondear4(parseFloat(item.CAN_HABER_MN) / parseFloat(tc));
                } else {
                    item.CAN_DEBE_MN = redondear4(parseFloat(item.CAN_DEBE_ME) / parseFloat(tc));
                    item.CAN_HABER_MN = redondear4(parseFloat(item.CAN_HABER_ME) / parseFloat(tc));
                }
            }
        });

        document.getElementById("asiento_detalle_percepcion").value = JSON.stringify(arrayDetalle);

        // Después de actualizar arrayDetalle

        $("#asientodetallepercepcion tbody tr").each(function () {
            let fila = $(this);
            let codAsiento = fila.attr('data_codigo');
            arrayDetalle.forEach(item => {
                let asiento_id_editar = item.COD_ASIENTO_MOVIMIENTO;

                if (codAsiento === asiento_id_editar) {
                    // obtenemos el índice de la fila
                    let rowIdx = table.row(fila).index();

                    // actualizamos celdas por columna
                    table.cell(rowIdx, 1).data(item.TXT_CUENTA_CONTABLE);                       // Cuenta
                    table.cell(rowIdx, 2).data(item.TXT_GLOSA);                        // Descripción
                    table.cell(rowIdx, 3).data(number_format(item.CAN_DEBE_MN, 4));       // Debe MN
                    table.cell(rowIdx, 4).data(number_format(item.CAN_HABER_MN, 4));      // Haber MN
                    table.cell(rowIdx, 5).data(number_format(item.CAN_DEBE_ME, 4));       // Debe ME
                    table.cell(rowIdx, 6).data(number_format(item.CAN_HABER_ME, 4));      // Haber ME
                }
            });
        });

        // redibujar la tabla → esto dispara footerCallback y recalcula totales
        table.columns.adjust().draw();

    });

    $("#fecha_asiento").on('change', function (e) {

        let fecha = $('#fecha_asiento').val();
        let _token = $('#token').val();

        if (fecha === null || fecha.trim() === "") {
            $.alert({
                title: 'Error',
                content: 'No hay fecha seleccionada',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            })
            return false;
        }

        $.ajax({
            type: "POST",
            url: carpeta + "/obtener-periodo-tipo-cambio",
            data: { _token: _token, fecha: fecha },
            success: function (res) {
                $('#tipo_cambio_asiento').val(res.tipoCambio);

                window.selects['anio_asiento'].setSelected(res.anio.trim());
                $('#anio_asiento').trigger('change');

                setTimeout(function () {
                    window.selects['periodo_asiento'].setSelected(res.periodo.trim())
                    $('#periodo_asiento').trigger('change');
                }, 1000);

            },
            error: function (res) {
                error500(res);
            }
        });

    });

    $(".btn-guardar_asiento").on('click', function () {

        let arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);
        let arrayCabecera = JSON.parse(document.getElementById("asiento_cabecera_compra").value);
        let cadenaNumeroCuenta = '';
        let periodo_asiento = $("#periodo_asiento").val();
        let comprobante_asiento = $("#comprobante_asiento").val();
        let moneda_id_editar = $("#moneda_asiento").val();
        let tc_editar = $("#tipo_cambio_asiento").val();
        let proveedor_asiento = $("#empresa_asiento").val();
        let tipo_asiento = $("#tipo_asiento").val();
        let fecha_asiento = $("#fecha_asiento").val();
        let tipo_comprobante = $("#tipo_documento_asiento").val();
        let serie_comprobante = $("#serie_asiento").val();
        let numero_comprobante = $("#numero_asiento").val();
        let tipo_comprobante_ref = $("#tipo_documento_ref").val();
        let serie_comprobante_ref = $("#serie_ref_asiento").val();
        let numero_comprobante_ref = $("#numero_ref_asiento").val();
        let glosa_asiento = $("#glosa_asiento").val();
        let tipo_descuento = $("#tipo_descuento_asiento").val();
        let constancia_des = $("#const_detraccion_asiento").val();
        let fecha_des = $("#fecha_detraccion_asiento").val();
        let porcentaje_des = $("#porcentaje_detraccion").val();
        let total_des = $("#total_detraccion_asiento").val();

        let table = $('#asientodetalle').DataTable();

        let totalDebeMN = $(table.column(3).footer()).text().trim();
        let totalHaberMN = $(table.column(4).footer()).text().trim();
        let totalDebeME = $(table.column(5).footer()).text().trim();
        let totalHaberME = $(table.column(6).footer()).text().trim();

        //if (moneda_id_editar === 'MON0000000000001') {
        if (totalDebeMN !== totalHaberMN) {
            $.alert({
                title: 'Error',
                content: 'El asiento no cuadra verificar los totales de la moneda nacional en el debe y haber',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false; // Detiene la ejecución
        }
        //} else {
        if (totalDebeME !== totalHaberME) {
            $.alert({
                title: 'Error',
                content: 'El asiento no cuadra verificar los totales de la moneda extranjera en el debe y haber',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false; // Detiene la ejecución
        }
        //}

        // Array de todos los valores
        let campos = [
            {nombre: "Periodo", valor: periodo_asiento},
            {nombre: "Comprobante", valor: comprobante_asiento},
            {nombre: "Moneda", valor: moneda_id_editar},
            {nombre: "Tipo de Cambio", valor: tc_editar},
            {nombre: "Proveedor", valor: proveedor_asiento},
            {nombre: "Tipo Asiento", valor: tipo_asiento},
            {nombre: "Fecha", valor: fecha_asiento},
            {nombre: "Tipo Comprobante", valor: tipo_comprobante},
            {nombre: "Serie", valor: serie_comprobante},
            {nombre: "Número", valor: numero_comprobante},
        ];

        // Recorremos y validamos
        for (let campo of campos) {
            if (!campo.valor || campo.valor === "") {
                $.alert({
                    title: 'Error',
                    content: 'El campo ' + campo.nombre + ' no puede estar vacío.',
                    type: 'red',
                    buttons: {
                        ok: {
                            text: 'OK',
                            btnClass: 'btn-red',
                        }
                    }
                });
                return false; // Detiene la ejecución
            }
        }

        let base_imponible = 0.0000;
        let base_imponible_10 = 0.0000;
        let base_ivap = 0.0000;
        let base_inafecto = 0.0000;
        let base_exonerado = 0.0000;
        let total_igv = 0.0000;
        let total_ivap = 0.0000;

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (parseInt(item.COD_ESTADO) === 1) {
                switch (item.COD_DOC_CTBLE_REF) {
                    case 'AIGV':
                        if (item.COD_ORDEN_REF === '18') {
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible = base_imponible + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            } else {
                                base_imponible = base_imponible + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            }
                        } else if (item.COD_ORDEN_REF === '10') {
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            } else {
                                base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            }
                        }
                        break;
                    case 'IIGV':
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        } else {
                            base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        }
                        break;
                    case 'EIGV':
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_exonerado = base_exonerado + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        } else {
                            base_exonerado = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        }
                        break;
                }
                if (/^4011/.test(item.TXT_CUENTA_CONTABLE)) {
                    if (moneda_id_editar !== 'MON0000000000001') {
                        total_igv = total_igv + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                    } else {
                        total_igv = total_igv + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                    }
                }
                if (!/^4011/.test(item.TXT_CUENTA_CONTABLE) && !/^42/.test(item.TXT_CUENTA_CONTABLE) && !/^43/.test(item.TXT_CUENTA_CONTABLE)) {
                    if (cadenaNumeroCuenta === '') {
                        cadenaNumeroCuenta = item.TXT_CUENTA_CONTABLE;
                    } else {
                        cadenaNumeroCuenta = cadenaNumeroCuenta + ',' + item.TXT_CUENTA_CONTABLE;
                    }
                }
            }
        });

        arrayCabecera.forEach(item => {
            item.COD_CATEGORIA_MONEDA = moneda_id_editar;
            item.CAN_TIPO_CAMBIO = Number(tc_editar.replaceAll(/[\$,]/g, "")) || 0;
            item.FEC_ASIENTO = new Date(fecha_asiento);
            item.COD_PERIODO = periodo_asiento;
            item.COD_EMPR_CLI = proveedor_asiento;
            item.COD_CATEGORIA_TIPO_ASIENTO = tipo_asiento;
            item.COD_CATEGORIA_TIPO_DOCUMENTO = tipo_comprobante;
            item.NRO_SERIE = serie_comprobante;
            item.NRO_DOC = numero_comprobante;
            item.COD_CATEGORIA_TIPO_DOCUMENTO_REF = tipo_comprobante_ref;
            item.NRO_SERIE_REF = serie_comprobante_ref;
            item.NRO_DOC_REF = numero_comprobante_ref;
            item.TXT_GLOSA = glosa_asiento;
            item.COD_CATEGORIA_TIPO_DETRACCION = tipo_descuento;
            item.NRO_DETRACCION = constancia_des;
            item.FEC_DETRACCION = new Date(fecha_des);
            item.CAN_DESCUENTO_DETRACCION = Number(porcentaje_des) || 0;
            item.CAN_TOTAL_DETRACCION = Number(total_des) || 0;
            item.TXT_REFERENCIA = comprobante_asiento.split("-")[0];
            item.TOTAL_BASE_IMPONIBLE = base_imponible;
            item.TOTAL_BASE_IMPONIBLE_10 = base_imponible_10;
            item.TOTAL_BASE_INAFECTA = base_inafecto;
            item.TOTAL_BASE_EXONERADA = base_exonerado;
            item.TOTAL_IGV = total_igv;
            item.TOTAL_AFECTO_IVAP = base_ivap;
            item.TOTAL_IVAP = total_ivap;
        });

        let data_input = '';

        $('#asientolista tbody tr').each(function () {
            if ($(this).hasClass('selected')) {
                // Cambiar estilo o atributo de las celdas de esta fila
                data_input = $(this).attr('data_input');
                $(this).attr('data_asiento_cabecera', JSON.stringify(arrayCabecera));
                $(this).attr('data_asiento_detalle', JSON.stringify(arrayDetalle));
                if (data_input === 'C') {
                    $('#nro_cuenta_contable').val(cadenaNumeroCuenta);
                }
            }
        });

        $('#listone').addClass('active');
        $('#listtwo').removeClass('active');
        $('#listtree').removeClass('active');
        $('#astcabgeneral').addClass('active');
        $('#astcabcomplementario').removeClass('active');
        $('#astdetgeneral').removeClass('active');

        $('.pnlasientos').hide();
        $('#asientolista').focus();
    })

    $('#tipo_igv_id').on('change', function () {
        switch ($(this).val()) {
            case "CTI0000000000002":
            case "CTI0000000000003":
                $('#porc_tipo_igv_id')
                    .val('0')
                    .trigger('change')
                    .prop('disabled', true);
                break;

            case "CTI0000000000001":
                $('#porc_tipo_igv_id')
                    .val('18')
                    .trigger('change')
                    .prop('disabled', false);
                break;

            default:
                $('#porc_tipo_igv_id')
                    .val('')
                    .trigger('change')
                    .prop('disabled', true);
                break;
        }
    });

    $('#tipo_documento_asiento').on('change', function () {
        switch ($(this).val()) {
            case "TDO0000000000002":
            case "TDO0000000000066":
                window.selects['tipo_asiento'].setSelected('TAS0000000000007');
                $('#tipo_asiento').trigger('change').prop('disabled', true);
                break;
            default:
                window.selects['tipo_asiento'].setSelected('TAS0000000000004');
                $('#tipo_asiento').trigger('change').prop('disabled', false);
                break;
        }
    });

    $(document).on('click', ".ver-asiento", function (e) {
        e.preventDefault();
        if ($('.editarcuentas').is(':visible')) {
            $('.tablageneral').toggle("slow");
            $('.editarcuentas').toggle("slow");
        }
        setTimeout(function () {
            $('#asientodetalle').DataTable().columns.adjust().draw();
        }, 3000); // espera medio segundo o el tiempo necesario

        let $tr = $(this).closest("tr");

        let data_asiento_cabecera = $tr.attr('data_asiento_cabecera');
        let data_asiento_detalle = $tr.attr('data_asiento_detalle');
        let form_id_editar = $tr.attr('data_indicador');

        $('#asientolista tbody tr').removeClass('selected');

        $tr.addClass('selected');

        $('#asiento_cabecera_compra').val(data_asiento_cabecera);
        $('#asiento_detalle_compra').val(data_asiento_detalle);

        let arrayCabecera = JSON.parse(document.getElementById("asiento_cabecera_compra").value);
        let arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);

        // Crear la fila con atributos y estilos
        let nuevaFila = ``;

        let asiento_id_editar = '';
        let fecha_asiento = new Date();
        let periodo_asiento = '';

        let moneda_id_editar = '';
        let tc_editar = 0.0000;
        let comprobante_asiento = '';
        let proveedor_asiento = '';
        let proveedor_asiento_txt = '';
        let tipo_asiento = '';

        let numero_cuenta = '';
        let glosa_cuenta = '';
        let can_debe_mn = 0.0000;
        let can_haber_mn = 0.0000;
        let can_debe_me = 0.0000;
        let can_haber_me = 0.0000;

        let base_imponible = 0.0000;
        let base_imponible_10 = 0.0000;
        let base_ivap = 0.0000;
        let base_inafecto = 0.0000;
        let base_exonerado = 0.0000;
        let total_igv = 0.0000;
        let total_ivap = 0.0000;
        let total = 0.0000;
        let tipo_comprobante = '';
        let serie_comprobante = '';
        let numero_comprobante = '';
        let tipo_comprobante_ref = '';
        let serie_comprobante_ref = '';
        let numero_comprobante_ref = '';
        let glosa_asiento = '';
        let tipo_descuento = '';
        let constancia_des = '';
        let fecha_des = '';
        let porcentaje_des = '';
        let total_des = '';

        arrayCabecera.forEach(item => {
            moneda_id_editar = item.COD_CATEGORIA_MONEDA;
            tc_editar = parseFloat(item.CAN_TIPO_CAMBIO);
            fecha_asiento = new Date(item.FEC_ASIENTO);
            periodo_asiento = item.COD_PERIODO;
            proveedor_asiento = item.COD_EMPR_CLI;
            proveedor_asiento_txt = item.TXT_EMPR_CLI;
            tipo_asiento = item.COD_CATEGORIA_TIPO_ASIENTO;
            tipo_comprobante = item.COD_CATEGORIA_TIPO_DOCUMENTO;
            serie_comprobante = item.NRO_SERIE;
            numero_comprobante = item.NRO_DOC;
            tipo_comprobante_ref = item.COD_CATEGORIA_TIPO_DOCUMENTO_REF;
            serie_comprobante_ref = item.NRO_SERIE_REF;
            numero_comprobante_ref = item.NRO_DOC_REF;
            glosa_asiento = item.TXT_GLOSA;
            tipo_descuento = item.COD_CATEGORIA_TIPO_DETRACCION;
            constancia_des = item.NRO_DETRACCION;
            fecha_des = item.FEC_DETRACCION;
            porcentaje_des = item.CAN_DESCUENTO_DETRACCION;
            total_des = item.CAN_TOTAL_DETRACCION;
            comprobante_asiento = item.TXT_REFERENCIA;
            base_imponible = parseFloat(item.TOTAL_BASE_IMPONIBLE);
            base_imponible_10 = parseFloat(item.TOTAL_BASE_IMPONIBLE_10);
            base_ivap = parseFloat(item.TOTAL_AFECTO_IVAP);
            base_inafecto = parseFloat(item.TOTAL_BASE_INAFECTA);
            base_exonerado = parseFloat(item.TOTAL_BASE_EXONERADA);
            total_igv = parseFloat(item.TOTAL_IGV);
            total_ivap = parseFloat(item.TOTAL_IVAP);
            total = parseFloat(item.TOTAL_BASE_IMPONIBLE) + parseFloat(item.TOTAL_BASE_IMPONIBLE_10) + parseFloat(item.TOTAL_AFECTO_IVAP) + parseFloat(item.TOTAL_BASE_INAFECTA) + parseFloat(item.TOTAL_BASE_EXONERADA) + parseFloat(item.TOTAL_IGV) + parseFloat(item.TOTAL_IVAP);
        });

        $("#asientototales tbody tr").each(function () {
            let fila = $(this);

            // Actualizar las celdas visibles de la tabla
            fila.find(".col-base-imponible").text(number_format(base_imponible, 4));
            fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4));
            fila.find(".col-base-ivap").text(number_format(base_ivap, 4));
            fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4));
            fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4));
            fila.find(".col-igv").text(number_format(total_igv, 4));
            fila.find(".col-ivap").text(number_format(total_ivap, 4));
            fila.find(".col-total").text(number_format(total, 4));

        });

        let table = $('#asientodetalle').DataTable();

        table.clear().draw();

        arrayDetalle.forEach(item => {
            if (parseInt(item.COD_ESTADO) === 1) {
                asiento_id_editar = item.COD_ASIENTO_MOVIMIENTO;
                numero_cuenta = item.TXT_CUENTA_CONTABLE;
                glosa_cuenta = item.TXT_GLOSA;
                can_debe_mn = parseFloat(item.CAN_DEBE_MN);
                can_haber_mn = parseFloat(item.CAN_HABER_MN);
                can_debe_me = parseFloat(item.CAN_DEBE_ME);
                can_haber_me = parseFloat(item.CAN_HABER_ME);
                nuevaFila = `
            <tr class="fila" data_codigo="${asiento_id_editar}" data_asiento="${form_id_editar}"
                data_moneda="${moneda_id_editar}" data_tc="${tc_editar}">
                <td class="col-codigo">${asiento_id_editar}</td>
                <td class="col-cuenta">${numero_cuenta}</td>
                <td class="col-glosa">${glosa_cuenta}</td>
                <td class="col-debe-mn" style="text-align: right">${number_format(can_debe_mn, 4)}</td>
                <td class="col-haber-mn" style="text-align: right">${number_format(can_haber_mn, 4)}</td>
                <td class="col-debe-me" style="text-align: right">${number_format(can_debe_me, 4)}</td>
                <td class="col-haber-me" style="text-align: right">${number_format(can_haber_me, 4)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary editar-cuenta">
                        ✏ Editar
                    </button>
                    <button type="button" class="btn btn-sm btn-danger eliminar-cuenta">
                        🗑 Eliminar
                    </button>
                </td>
            </tr>
        `;
                table.row.add($(nuevaFila)).draw(false);

            }
        });

        let anio = fecha_asiento.getFullYear();

        window.selects['anio_asiento'].setSelected(anio.toString());
        window.selects['moneda_asiento'].setSelected(moneda_id_editar.trim());

        document.querySelector('#empresa_asiento').tomselect.addOption({
            id: proveedor_asiento,
            text: proveedor_asiento_txt
        });
        document.querySelector('#empresa_asiento').tomselect.setValue(proveedor_asiento.trim());

        window.selects['tipo_asiento'].setSelected(tipo_asiento.trim());
        window.selects['tipo_documento_asiento'].setSelected(tipo_comprobante.trim());
        window.selects['tipo_documento_ref'].setSelected(tipo_comprobante_ref.trim());
        window.selects['tipo_descuento_asiento'].setSelected(tipo_descuento.trim());
        $('#anio_asiento').trigger('change');
        $('#moneda_asiento').trigger('change');
        $('#tipo_asiento').trigger('change');
        $('#tipo_documento_asiento').trigger('change');
        $('#tipo_documento_ref').trigger('change');
        $('#tipo_descuento_asiento').trigger('change');

        //$('#anio_asiento').val(anio.toString()).trigger('change');
        $('#comprobante_asiento').val(comprobante_asiento);
        //$('#moneda_asiento').val(moneda_id_editar).trigger('change');
        $('#tipo_cambio_asiento').val(tc_editar);
        //$('#empresa_asiento').val(proveedor_asiento).trigger('change');
        //$('#tipo_asiento').val(tipo_asiento).trigger('change');

        // Formatear a YYYY-MM-DD
        let fechaFormateada = fecha_asiento.toISOString().split('T')[0];

        // Pasar valor al input con jQuery
        $('#fecha_asiento').val(fechaFormateada);
        //$('#tipo_documento_asiento').val(tipo_comprobante).trigger('change');
        $('#serie_asiento').val(serie_comprobante);
        $('#numero_asiento').val(numero_comprobante);
        //$('#tipo_documento_ref').val(tipo_comprobante_ref).trigger('change');
        $('#serie_ref_asiento').val(serie_comprobante_ref);
        $('#numero_ref_asiento').val(numero_comprobante_ref);
        $('#glosa_asiento').val(glosa_asiento);

        //$('#tipo_descuento_asiento').val(tipo_descuento).trigger('change');
        $('#const_detraccion_asiento').val(constancia_des);
        $('#fecha_detraccion_asiento').val(fecha_des);
        $('#porcentaje_detraccion').val(porcentaje_des);
        $('#total_detraccion_asiento').val(total_des);

        if (tipo_asiento === 'TAS0000000000007') {
            $('#asientototales').hide();
        } else {
            $('#asientototales').show();
        }

        $('.pnlasientos').show();
        $('.pnlasientos').focus();
        $('#asientodetalle').DataTable().columns.adjust().draw();

        setTimeout(function () {
            //$('#periodo_asiento').val(periodo_asiento).trigger('change');
            window.selects['periodo_asiento'].setSelected(periodo_asiento.trim())
        }, 1000); // espera medio segundo o el tiempo necesario

        cerrarcargando();

    });

    $(".btn-regresar-lista").on('click', function (e) {
        $('.tablageneral').toggle("slow");
        $('.editarcuentas').toggle("slow");
        setTimeout(function () {
            $('#asientodetalle').DataTable().columns.adjust().draw();
        }, 3000); // espera medio segundo o el tiempo necesario
    });

    $(".btn-registrar-movimiento").on('click', function (e) {

        let cuenta_contable_id = $('#cuenta_contable_id').val();
        let afecto_igv = $('#tipo_igv_id').val();
        let porc_afecto_igv = $('#porc_tipo_igv_id').val();
        let monto = $('#monto').val();
        monto = monto.replaceAll(/[\$,]/g, "");
        let partida_id = $('#partida_id').val();
        let activo = $('#activo').val();
        let texto = $("#cuenta_contable_id option:selected").text();
        let numero_cuenta = texto.split(" - ")[0];
        let glosa_cuenta = texto.split(" - ")[1];

        let asiento_id_editar = $('#asiento_id_editar').val();
        let form_id_editar = $('#form_id_editar').val();
        let moneda_id_editar = $('#moneda_id_editar').val();
        let tc_editar = $('#tc_editar').val();

        let arrayDetalle = null;
        let arrayCabecera = null;
        let can_debe_mn = 0.0000;
        let can_haber_mn = 0.0000;
        let can_debe_me = 0.0000;
        let can_haber_me = 0.0000;
        let ind_producto = 0;

        if (monto === '' || monto === '0.0000') {
            alerterrorajax("Ingrese un monto");
            return false;
        }
        if (cuenta_contable_id === '') {
            alerterrorajax("Seleccione una cuenta contable.");
            return false;
        }
        if (partida_id === '') {
            alerterrorajax("Seleccione una partida.");
            return false;
        }

        switch (afecto_igv) {
            case 'CTI0000000000001':
                afecto_igv = 'AIGV';
                break;
            case 'CTI0000000000002':
                afecto_igv = 'IIGV';
                break;
            case 'CTI0000000000003':
                afecto_igv = 'EIGV';
                break;
            default:
                afecto_igv = '';
                break;
        }

        switch (afecto_igv) {
            case 'AIGV':
                if (porc_afecto_igv === '' || porc_afecto_igv === '0') {
                    alerterrorajax("Selecciono Afecto debe tener porcentaje de IGV.");
                    return false;
                }
                break;
            case 'IIGV':
                if (porc_afecto_igv === '10' || porc_afecto_igv === '18') {
                    alerterrorajax("Selecciono Inafecto no puede tener porcentaje de IGV.");
                    return false;
                }
                break;
            case 'EIGV':
                if (porc_afecto_igv === '10' || porc_afecto_igv === '18') {
                    alerterrorajax("Selecciono Exonerado no puede tener porcentaje de IGV.");
                    return false;
                }
                break;
            default:
                if (porc_afecto_igv === '10' || porc_afecto_igv === '18' || porc_afecto_igv === '0') {
                    alerterrorajax("No se selecciono afecto IGV no puede ingresar porcentaje de IGV.");
                    return false;
                }
                break;
        }

        switch (form_id_editar) {
            case 'C':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);
                break;
            case 'RV':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable_reversion").value);
                break;
            case 'D':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_deduccion").value);
                break;
            case 'P':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_percepcion").value);
                break;
        }

        if (moneda_id_editar === 'MON0000000000001') {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = redondear4(parseFloat(monto));
                can_haber_mn = 0.0000;
                can_debe_me = redondear4(parseFloat(monto) / tc_editar);
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = redondear4(parseFloat(monto));
                can_debe_me = 0.0000;
                can_haber_me = redondear4(parseFloat(monto) / tc_editar);
            }
        } else {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = redondear4(parseFloat(monto) * tc_editar);
                can_haber_mn = 0.0000;
                can_debe_me = redondear4(parseFloat(monto));
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = redondear4(parseFloat(monto) * tc_editar);
                can_debe_me = 0.0000;
                can_haber_me = redondear4(parseFloat(monto));
            }
        }

        if (afecto_igv !== '') {
            ind_producto = 1;
        }

        // Nuevo objeto con todos los campos
        let nuevoMovimiento = {
            "COD_ASIENTO_MOVIMIENTO": asiento_id_editar,
            "COD_EMPR": "IACHEM0000010394",
            "COD_CENTRO": "CEN0000000000002",
            "COD_ASIENTO": "IIBEAC0000000001",
            "COD_CUENTA_CONTABLE": cuenta_contable_id,
            "IND_PRODUCTO": ind_producto,
            "TXT_CUENTA_CONTABLE": numero_cuenta,
            "TXT_GLOSA": glosa_cuenta,
            "CAN_DEBE_MN": can_debe_mn,
            "CAN_HABER_MN": can_haber_mn,
            "CAN_DEBE_ME": can_debe_me,
            "CAN_HABER_ME": can_haber_me,
            "NRO_LINEA": "4",
            "COD_CUO": "",
            "IND_EXTORNO": "0",
            "TXT_TIPO_REFERENCIA": "",
            "TXT_REFERENCIA": "",
            "COD_USUARIO_CREA_AUD": "1CIX00000001",
            "FEC_USUARIO_CREA_AUD": "2025-08-19 14:30:00",
            "COD_USUARIO_MODIF_AUD": "",
            "FEC_USUARIO_MODIF_AUD": "2025-08-19 14:30:00",
            "COD_ESTADO": activo,
            "COD_DOC_CTBLE_REF": afecto_igv,
            "COD_ORDEN_REF": porc_afecto_igv,
            "COD_PRODUCTO": "",
            "TXT_NOMBRE_PRODUCTO": "",
            "COD_LOTE": "",
            "NRO_LINEA_PRODUCTO": "0",
            "COD_EMPR_CLI_REF": "",
            "TXT_EMPR_CLI_REF": "",
            "DOCUMENTO_REF": "",
            "CODIGO_CONTABLE": ""
        };

        arrayDetalle.push(nuevoMovimiento);

        let base_imponible = 0.0000;
        let base_imponible_10 = 0.0000;
        let base_ivap = 0.0000;
        let base_inafecto = 0.0000;
        let base_exonerado = 0.0000;
        let total_igv = 0.0000;
        let total_ivap = 0.0000;
        let total = 0.0000;

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (parseInt(item.COD_ESTADO) === 1) {
                switch (item.COD_DOC_CTBLE_REF) {
                    case 'AIGV':
                        if (item.COD_ORDEN_REF === '18') {
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible = base_imponible + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            } else {
                                base_imponible = base_imponible + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            }
                        } else if (item.COD_ORDEN_REF === '10') {
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            } else {
                                base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            }
                        }
                        break;
                    case 'IIGV':
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        } else {
                            base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        }
                        break;
                    case 'EIGV':
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_exonerado = base_exonerado + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        } else {
                            base_exonerado = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        }
                        break;
                }
                if (/^4011/.test(item.TXT_CUENTA_CONTABLE)) {
                    if (moneda_id_editar !== 'MON0000000000001') {
                        total_igv = total_igv + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                    } else {
                        total_igv = total_igv + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                    }
                }
            }
        });

        total = base_imponible + base_imponible_10 + base_ivap + base_inafecto + base_exonerado + total_igv + total_ivap;

        // Crear la fila con atributos y estilos
        let nuevaFila = `
            <tr class="fila" data_codigo="${asiento_id_editar}" data_asiento="${form_id_editar}"
                data_moneda="${moneda_id_editar}" data_tc="${tc_editar}">
                <td class="col-codigo">${asiento_id_editar}</td>
                <td class="col-cuenta">${numero_cuenta}</td>
                <td class="col-glosa">${glosa_cuenta}</td>
                <td class="col-debe-mn" style="text-align: right">${number_format(can_debe_mn, 4)}</td>
                <td class="col-haber-mn" style="text-align: right">${number_format(can_haber_mn, 4)}</td>
                <td class="col-debe-me" style="text-align: right">${number_format(can_debe_me, 4)}</td>
                <td class="col-haber-me" style="text-align: right">${number_format(can_haber_me, 4)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary editar-cuenta">
                        ✏ Editar
                    </button>
                    <button type="button" class="btn btn-sm btn-danger eliminar-cuenta">
                        🗑 Eliminar
                    </button>
                </td>
            </tr>
        `;

        let table = $('#asientodetalle').DataTable();

        switch (form_id_editar) {
            case 'C':
                arrayCabecera = JSON.parse(document.getElementById("asiento_cabecera_compra").value);
                // Recorrerlo
                arrayCabecera.forEach(item => {
                    item.TOTAL_BASE_IMPONIBLE = base_imponible;
                    item.TOTAL_BASE_IMPONIBLE_10 = base_imponible_10;
                    item.TOTAL_BASE_INAFECTA = base_inafecto;
                    item.TOTAL_BASE_EXONERADA = base_exonerado;
                    item.TOTAL_IGV = total_igv;
                    item.TOTAL_AFECTO_IVAP = base_ivap;
                    item.TOTAL_IVAP = total_ivap;
                });
                document.getElementById("asiento_cabecera_compra").value = JSON.stringify(arrayCabecera);
                document.getElementById("asiento_detalle_compra").value = JSON.stringify(arrayDetalle);
                // Después de actualizar arrayDetalle
                table = $('#asientodetalle').DataTable();
                table.row.add($(nuevaFila)).draw(false);
                table.columns.adjust().draw();
                //$("#asientodetalle tbody").append(nuevaFila);
                $("#asientototales tbody tr").each(function () {
                    let fila = $(this);

                    // Actualizar las celdas visibles de la tabla
                    fila.find(".col-base-imponible").text(number_format(base_imponible, 4));
                    fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4));
                    fila.find(".col-base-ivap").text(number_format(base_ivap, 4));
                    fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4));
                    fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4));
                    fila.find(".col-igv").text(number_format(total_igv, 4));
                    fila.find(".col-ivap").text(number_format(total_ivap, 4));
                    fila.find(".col-total").text(number_format(total, 4));

                });
                break;
            case 'RV':
                document.getElementById("asiento_detalle_reparable_reversion").value = JSON.stringify(arrayDetalle);
                // Después de actualizar arrayDetalle
                table = $('#asientodetallereversion').DataTable();
                table.row.add($(nuevaFila)).draw(false);
                table.columns.adjust().draw();
                //$("#asientodetallereversion tbody").append(nuevaFila);
                break;
            case 'D':
                document.getElementById("asiento_detalle_deduccion").value = JSON.stringify(arrayDetalle);
                // Después de actualizar arrayDetalle
                table = $('#asientodetallededuccion').DataTable();
                table.row.add($(nuevaFila)).draw(false);
                table.columns.adjust().draw();
                //$("#asientodetallededuccion tbody").append(nuevaFila);
                break;
            case 'P':
                arrayCabecera = JSON.parse(document.getElementById("asiento_cabecera_percepcion").value);
                // Recorrerlo
                arrayCabecera.forEach(item => {
                    item.TOTAL_BASE_IMPONIBLE = base_imponible;
                    item.TOTAL_BASE_IMPONIBLE_10 = base_imponible_10;
                    item.TOTAL_BASE_INAFECTA = base_inafecto;
                    item.TOTAL_BASE_EXONERADA = base_exonerado;
                    item.TOTAL_IGV = total_igv;
                    item.TOTAL_AFECTO_IVAP = base_ivap;
                    item.TOTAL_IVAP = total_ivap;
                });
                document.getElementById("asiento_cabecera_percepcion").value = JSON.stringify(arrayCabecera);
                document.getElementById("asiento_detalle_percepcion").value = JSON.stringify(arrayDetalle);
                // Después de actualizar arrayDetalle
                table = $('#asientodetallepercepcion').DataTable();
                table.row.add($(nuevaFila)).draw(false);
                table.columns.adjust().draw();
                //$("#asientodetallepercepcion tbody").append(nuevaFila);
                $("#asiento_totales_percepcion tbody tr").each(function () {
                    let fila = $(this);

                    // Actualizar las celdas visibles de la tabla
                    fila.find(".col-base-imponible").text(number_format(base_imponible, 4));
                    fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4));
                    fila.find(".col-base-ivap").text(number_format(base_ivap, 4));
                    fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4));
                    fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4));
                    fila.find(".col-igv").text(number_format(total_igv, 4));
                    fila.find(".col-ivap").text(number_format(total_ivap, 4));
                    fila.find(".col-total").text(number_format(total, 4));

                });
                break;
        }
        $('.tablageneral').toggle("slow");
        $('.editarcuentas').toggle("slow");
        setTimeout(function () {
            $('#asientodetalle').DataTable().columns.adjust().draw();
        }, 3000); // espera medio segundo o el tiempo necesario
    });

    $(".btn-editar-movimiento").on('click', function (e) {

        let cuenta_contable_id = $('#cuenta_contable_id').val();
        let afecto_igv = $('#tipo_igv_id').val();
        let porc_afecto_igv = $('#porc_tipo_igv_id').val();
        let monto = $('#monto').val();
        monto = monto.replaceAll(/[\$,]/g, "");
        let partida_id = $('#partida_id').val();
        let activo = $('#activo').val();
        let texto = $("#cuenta_contable_id option:selected").text();
        let numero_cuenta = texto.split(" - ")[0];
        let glosa_cuenta = texto.split(" - ")[1];

        let asiento_id_editar = $('#asiento_id_editar').val();
        let form_id_editar = $('#form_id_editar').val();
        let moneda_id_editar = $('#moneda_id_editar').val();
        let tc_editar = $('#tc_editar').val();

        let arrayDetalle = null;
        let arrayCabecera = null;
        let can_debe_mn = 0.0000;
        let can_haber_mn = 0.0000;
        let can_debe_me = 0.0000;
        let can_haber_me = 0.0000;

        if (monto === '' || monto === '0.0000') {
            alerterrorajax("Ingrese un monto");
            return false;
        }
        if (cuenta_contable_id === '') {
            alerterrorajax("Seleccione una cuenta contable.");
            return false;
        }
        if (partida_id === '') {
            alerterrorajax("Seleccione una partida.");
            return false;
        }

        switch (afecto_igv) {
            case 'CTI0000000000001':
                afecto_igv = 'AIGV';
                break;
            case 'CTI0000000000002':
                afecto_igv = 'IIGV';
                break;
            case 'CTI0000000000003':
                afecto_igv = 'EIGV';
                break;
            default:
                afecto_igv = '';
                break;
        }

        switch (afecto_igv) {
            case 'AIGV':
                if (porc_afecto_igv === '' || porc_afecto_igv === '0') {
                    alerterrorajax("Selecciono Afecto debe tener porcentaje de IGV.");
                    return false;
                }
                break;
            case 'IIGV':
                if (porc_afecto_igv === '10' || porc_afecto_igv === '18') {
                    alerterrorajax("Selecciono Inafecto no puede tener porcentaje de IGV.");
                    return false;
                }
                break;
            case 'EIGV':
                if (porc_afecto_igv === '10' || porc_afecto_igv === '18') {
                    alerterrorajax("Selecciono Exonerado no puede tener porcentaje de IGV.");
                    return false;
                }
                break;
            default:
                if (porc_afecto_igv === '10' || porc_afecto_igv === '18' || porc_afecto_igv === '0') {
                    alerterrorajax("No se selecciono afecto IGV no puede ingresar porcentaje de IGV.");
                    return false;
                }
                break;
        }

        switch (form_id_editar) {
            case 'C':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);
                break;
            case 'RV':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable_reversion").value);
                break;
            case 'D':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_deduccion").value);
                break;
            case 'P':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_percepcion").value);
                break;
        }

        if (moneda_id_editar === 'MON0000000000001') {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = redondear4(parseFloat(monto));
                can_haber_mn = 0.0000;
                can_debe_me = redondear4(parseFloat(monto) / tc_editar);
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = redondear4(parseFloat(monto));
                can_debe_me = 0.0000;
                can_haber_me = redondear4(parseFloat(monto) / tc_editar);
            }
        } else {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = redondear4(parseFloat(monto) * tc_editar);
                can_haber_mn = 0.0000;
                can_debe_me = redondear4(parseFloat(monto));
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = redondear4(parseFloat(monto) * tc_editar);
                can_debe_me = 0.0000;
                can_haber_me = redondear4(parseFloat(monto));
            }
        }

        let base_imponible = 0.0000;
        let base_imponible_10 = 0.0000;
        let base_ivap = 0.0000;
        let base_inafecto = 0.0000;
        let base_exonerado = 0.0000;
        let total_igv = 0.0000;
        let total_ivap = 0.0000;
        let total = 0.0000;

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (parseInt(item.COD_ESTADO) === 1) {
                if (item.COD_ASIENTO_MOVIMIENTO === asiento_id_editar) {
                    item.COD_CUENTA_CONTABLE = cuenta_contable_id;
                    item.TXT_CUENTA_CONTABLE = numero_cuenta;
                    item.TXT_GLOSA = glosa_cuenta;
                    item.COD_PRODUCTO = '';
                    item.TXT_NOMBRE_PRODUCTO = '';
                    item.COD_LOTE = '';
                    item.NRO_LINEA_PRODUCTO = '0';
                    item.CAN_DEBE_MN = can_debe_mn;
                    item.CAN_HABER_MN = can_haber_mn;
                    item.CAN_DEBE_ME = can_debe_me;
                    item.CAN_HABER_ME = can_haber_me;
                    item.COD_DOC_CTBLE_REF = afecto_igv;
                    item.COD_ORDEN_REF = porc_afecto_igv;
                    item.COD_ESTADO = activo;
                }
                switch (item.COD_DOC_CTBLE_REF) {
                    case 'AIGV':
                        if (item.COD_ORDEN_REF === '18') {
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible = base_imponible + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            } else {
                                base_imponible = base_imponible + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            }
                        } else if (item.COD_ORDEN_REF === '10') {
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            } else {
                                base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            }
                        }
                        break;
                    case 'IIGV':
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        } else {
                            base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        }
                        break;
                    case 'EIGV':
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_exonerado = base_exonerado + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        } else {
                            base_exonerado = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        }
                        break;
                }
                if (/^4011/.test(item.TXT_CUENTA_CONTABLE)) {
                    if (moneda_id_editar !== 'MON0000000000001') {
                        total_igv = total_igv + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                    } else {
                        total_igv = total_igv + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                    }
                }
            }
        });

        total = base_imponible + base_imponible_10 + base_ivap + base_inafecto + base_exonerado + total_igv + total_ivap;

        let table = $('#asientodetalle').DataTable();

        switch (form_id_editar) {
            case 'C':
                arrayCabecera = JSON.parse(document.getElementById("asiento_cabecera_compra").value);
                // Recorrerlo
                arrayCabecera.forEach(item => {
                    item.TOTAL_BASE_IMPONIBLE = base_imponible;
                    item.TOTAL_BASE_IMPONIBLE_10 = base_imponible_10;
                    item.TOTAL_BASE_INAFECTA = base_inafecto;
                    item.TOTAL_BASE_EXONERADA = base_exonerado;
                    item.TOTAL_IGV = total_igv;
                    item.TOTAL_AFECTO_IVAP = base_ivap;
                    item.TOTAL_IVAP = total_ivap;
                });
                document.getElementById("asiento_cabecera_compra").value = JSON.stringify(arrayCabecera);
                document.getElementById("asiento_detalle_compra").value = JSON.stringify(arrayDetalle);
                // Después de actualizar arrayDetalle
                table = $('#asientodetalle').DataTable();

                $("#asientodetalle tbody tr").each(function () {
                    let fila = $(this);
                    let codAsiento = fila.attr('data_codigo');

                    if (codAsiento === asiento_id_editar) {
                        // obtenemos el índice de la fila
                        let rowIdx = table.row(fila).index();

                        // actualizamos celdas por columna
                        table.cell(rowIdx, 1).data(numero_cuenta);                       // Cuenta
                        table.cell(rowIdx, 2).data(glosa_cuenta);                        // Descripción
                        table.cell(rowIdx, 3).data(number_format(can_debe_mn, 4));       // Debe MN
                        table.cell(rowIdx, 4).data(number_format(can_haber_mn, 4));      // Haber MN
                        table.cell(rowIdx, 5).data(number_format(can_debe_me, 4));       // Debe ME
                        table.cell(rowIdx, 6).data(number_format(can_haber_me, 4));      // Haber ME
                    }
                });

                // redibujar la tabla → esto dispara footerCallback y recalcula totales
                table.columns.adjust().draw();
                /*
                $("#asientodetalle tbody tr").each(function () {
                    let fila = $(this);

                    // buscamos en la fila el hidden con el id del asiento
                    let codAsiento = fila.attr('data_codigo');

                    if (codAsiento === asiento_id_editar) {
                        // Actualizar las celdas visibles de la tabla
                        fila.find(".col-cuenta").text(numero_cuenta);
                        fila.find(".col-glosa").text(glosa_cuenta);
                        fila.find(".col-debe-mn").text(number_format(can_debe_mn, 4));
                        fila.find(".col-haber-mn").text(number_format(can_haber_mn, 4));
                        fila.find(".col-debe-me").text(number_format(can_debe_me, 4));
                        fila.find(".col-haber-me").text(number_format(can_haber_me, 4));
                    }
                });*/
                $("#asientototales tbody tr").each(function () {
                    let fila = $(this);

                    // Actualizar las celdas visibles de la tabla
                    fila.find(".col-base-imponible").text(number_format(base_imponible, 4));
                    fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4));
                    fila.find(".col-base-ivap").text(number_format(base_ivap, 4));
                    fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4));
                    fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4));
                    fila.find(".col-igv").text(number_format(total_igv, 4));
                    fila.find(".col-ivap").text(number_format(total_ivap, 4));
                    fila.find(".col-total").text(number_format(total, 4));

                });
                break;
            case 'RV':
                document.getElementById("asiento_detalle_reparable_reversion").value = JSON.stringify(arrayDetalle);
                // Después de actualizar arrayDetalle
                table = $('#asientodetallereversion').DataTable();

                $("#asientodetallereversion tbody tr").each(function () {
                    let fila = $(this);
                    let codAsiento = fila.attr('data_codigo');

                    if (codAsiento === asiento_id_editar) {
                        // obtenemos el índice de la fila
                        let rowIdx = table.row(fila).index();

                        // actualizamos celdas por columna
                        table.cell(rowIdx, 1).data(numero_cuenta);                       // Cuenta
                        table.cell(rowIdx, 2).data(glosa_cuenta);                        // Descripción
                        table.cell(rowIdx, 3).data(number_format(can_debe_mn, 4));       // Debe MN
                        table.cell(rowIdx, 4).data(number_format(can_haber_mn, 4));      // Haber MN
                        table.cell(rowIdx, 5).data(number_format(can_debe_me, 4));       // Debe ME
                        table.cell(rowIdx, 6).data(number_format(can_haber_me, 4));      // Haber ME
                    }
                });

                // redibujar la tabla → esto dispara footerCallback y recalcula totales
                table.columns.adjust().draw();
                /*
                $("#asientodetallereversion tbody tr").each(function () {
                    let fila = $(this);

                    // buscamos en la fila el hidden con el id del asiento
                    let codAsiento = fila.attr('data_codigo');

                    if (codAsiento === asiento_id_editar) {
                        // Actualizar las celdas visibles de la tabla
                        fila.find(".col-cuenta").text(numero_cuenta);
                        fila.find(".col-glosa").text(glosa_cuenta);
                        fila.find(".col-debe-mn").text(number_format(can_debe_mn, 4));
                        fila.find(".col-haber-mn").text(number_format(can_haber_mn, 4));
                        fila.find(".col-debe-me").text(number_format(can_debe_me, 4));
                        fila.find(".col-haber-me").text(number_format(can_haber_me, 4));
                    }
                });*/
                break;
            case 'D':
                document.getElementById("asiento_detalle_deduccion").value = JSON.stringify(arrayDetalle);
                // Después de actualizar arrayDetalle
                table = $('#asientodetallededuccion').DataTable();

                $("#asientodetallededuccion tbody tr").each(function () {
                    let fila = $(this);
                    let codAsiento = fila.attr('data_codigo');

                    if (codAsiento === asiento_id_editar) {
                        // obtenemos el índice de la fila
                        let rowIdx = table.row(fila).index();

                        // actualizamos celdas por columna
                        table.cell(rowIdx, 1).data(numero_cuenta);                       // Cuenta
                        table.cell(rowIdx, 2).data(glosa_cuenta);                        // Descripción
                        table.cell(rowIdx, 3).data(number_format(can_debe_mn, 4));       // Debe MN
                        table.cell(rowIdx, 4).data(number_format(can_haber_mn, 4));      // Haber MN
                        table.cell(rowIdx, 5).data(number_format(can_debe_me, 4));       // Debe ME
                        table.cell(rowIdx, 6).data(number_format(can_haber_me, 4));      // Haber ME
                    }
                });

                // redibujar la tabla → esto dispara footerCallback y recalcula totales
                table.columns.adjust().draw();
                /*
                $("#asientodetallededuccion tbody tr").each(function () {
                    let fila = $(this);

                    // buscamos en la fila el hidden con el id del asiento
                    let codAsiento = fila.attr('data_codigo');

                    if (codAsiento === asiento_id_editar) {
                        // Actualizar las celdas visibles de la tabla
                        fila.find(".col-cuenta").text(numero_cuenta);
                        fila.find(".col-glosa").text(glosa_cuenta);
                        fila.find(".col-debe-mn").text(number_format(can_debe_mn, 4));
                        fila.find(".col-haber-mn").text(number_format(can_haber_mn, 4));
                        fila.find(".col-debe-me").text(number_format(can_debe_me, 4));
                        fila.find(".col-haber-me").text(number_format(can_haber_me, 4));
                    }
                });*/
                break;
            case 'P':
                arrayCabecera = JSON.parse(document.getElementById("asiento_cabecera_percepcion").value);
                // Recorrerlo
                arrayCabecera.forEach(item => {
                    item.TOTAL_BASE_IMPONIBLE = base_imponible;
                    item.TOTAL_BASE_IMPONIBLE_10 = base_imponible_10;
                    item.TOTAL_BASE_INAFECTA = base_inafecto;
                    item.TOTAL_BASE_EXONERADA = base_exonerado;
                    item.TOTAL_IGV = total_igv;
                    item.TOTAL_AFECTO_IVAP = base_ivap;
                    item.TOTAL_IVAP = total_ivap;
                });
                document.getElementById("asiento_cabecera_percepcion").value = JSON.stringify(arrayCabecera);
                document.getElementById("asiento_detalle_percepcion").value = JSON.stringify(arrayDetalle);
                // Después de actualizar arrayDetalle
                table = $('#asientodetallepercepcion').DataTable();

                $("#asientodetallepercepcion tbody tr").each(function () {
                    let fila = $(this);
                    let codAsiento = fila.attr('data_codigo');

                    if (codAsiento === asiento_id_editar) {
                        // obtenemos el índice de la fila
                        let rowIdx = table.row(fila).index();

                        // actualizamos celdas por columna
                        table.cell(rowIdx, 1).data(numero_cuenta);                       // Cuenta
                        table.cell(rowIdx, 2).data(glosa_cuenta);                        // Descripción
                        table.cell(rowIdx, 3).data(number_format(can_debe_mn, 4));       // Debe MN
                        table.cell(rowIdx, 4).data(number_format(can_haber_mn, 4));      // Haber MN
                        table.cell(rowIdx, 5).data(number_format(can_debe_me, 4));       // Debe ME
                        table.cell(rowIdx, 6).data(number_format(can_haber_me, 4));      // Haber ME
                    }
                });

                // redibujar la tabla → esto dispara footerCallback y recalcula totales
                table.columns.adjust().draw();
                /*
                $("#asientodetallepercepcion tbody tr").each(function () {
                    let fila = $(this);

                    // buscamos en la fila el hidden con el id del asiento
                    let codAsiento = fila.attr('data_codigo');

                    if (codAsiento === asiento_id_editar) {
                        // Actualizar las celdas visibles de la tabla
                        fila.find(".col-cuenta").text(numero_cuenta);
                        fila.find(".col-glosa").text(glosa_cuenta);
                        fila.find(".col-debe-mn").text(number_format(can_debe_mn, 4));
                        fila.find(".col-haber-mn").text(number_format(can_haber_mn, 4));
                        fila.find(".col-debe-me").text(number_format(can_debe_me, 4));
                        fila.find(".col-haber-me").text(number_format(can_haber_me, 4));
                    }
                });*/
                $("#asiento_totales_percepcion tbody tr").each(function () {
                    let fila = $(this);

                    // Actualizar las celdas visibles de la tabla
                    fila.find(".col-base-imponible").text(number_format(base_imponible, 4));
                    fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4));
                    fila.find(".col-base-ivap").text(number_format(base_ivap, 4));
                    fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4));
                    fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4));
                    fila.find(".col-igv").text(number_format(total_igv, 4));
                    fila.find(".col-ivap").text(number_format(total_ivap, 4));
                    fila.find(".col-total").text(number_format(total, 4));

                });
                break;
        }
        $('.tablageneral').toggle("slow");
        $('.editarcuentas').toggle("slow");
        setTimeout(function () {
            $('#asientodetalle').DataTable().columns.adjust().draw();
        }, 3000); // espera medio segundo o el tiempo necesario
    });

    $(".agregar-linea").on('click', function (e) {

        let data_codigo = 'ASTMOV';
        let data_asiento = $(this).attr("data");
        let data_moneda = document.getElementById("moneda_asiento").value;
        let data_tc = document.getElementById("tipo_cambio_asiento").value;
        let arrayDetalle = null;
        let data_cuenta_id = '';
        let data_porc_afecto = '';
        let afecto = '';
        let partida = '';
        let monto = 0.0000;

        if (data_moneda === null || data_moneda.trim() === "") {
            $.alert({
                title: 'Error',
                content: 'No hay moneda seleccionada',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        if (!data_tc || parseFloat(data_tc) === 0) {
            $.alert({
                title: 'Error',
                content: 'El tipo de cambio no puede ser 0',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        switch (data_asiento) {
            case 'C':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);
                break;
            case 'RV':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable_reversion").value);
                break;
            case 'D':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_deduccion").value);
                break;
            case 'P':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_percepcion").value);
                break;
        }

        data_codigo = data_codigo + (arrayDetalle.length + 1).toString();

        /*
        $('#cuenta_contable_id').val(data_cuenta_id.trim()).trigger('change');
        $('#partida_id').val(partida.trim()).trigger('change');
        $('#tipo_igv_id').val(afecto.trim()).trigger('change');
        $('#porc_tipo_igv_id').val(data_porc_afecto.trim()).trigger('change');
         */
        window.selects['cuenta_contable_id'].setSelected(data_cuenta_id.trim());
        window.selects['partida_id'].setSelected(partida.trim());
        window.selects['tipo_igv_id'].setSelected(afecto.trim());
        window.selects['porc_tipo_igv_id'].setSelected(data_porc_afecto.trim());
        $('#cuenta_contable_id').trigger('change');
        $('#partida_id').trigger('change');
        $('#tipo_igv_id').trigger('change');
        $('#porc_tipo_igv_id').trigger('change');
        $('#monto').val(monto);

        $('#asiento_id_editar').val(data_codigo);
        $('#form_id_editar').val(data_asiento);
        $('#moneda_id_editar').val(data_moneda);
        $('#tc_editar').val(data_tc);
        $('#titulodetalle').text('Registrar Detalle');
        $('.btn-editar-movimiento').hide();
        $('.btn-registrar-movimiento').show();
        $('.tablageneral').toggle("slow");
        $('.editarcuentas').toggle("slow");

    });

    $(document).on('click', ".eliminar-cuenta", function (e) {

        let data_codigo = $(this).parents('.fila').attr('data_codigo');
        let data_asiento = $(this).parents('.fila').attr('data_asiento');
        let moneda_id_editar = $(this).parents('.fila').attr('data_moneda');
        let arrayDetalle = null;
        let arrayCabecera = null;

        switch (data_asiento) {
            case 'C':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);
                break;
            case 'RV':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable_reversion").value);
                break;
            case 'D':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_deduccion").value);
                break;
            case 'P':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_percepcion").value);
                break;
        }

        let base_imponible = 0.0000;
        let base_imponible_10 = 0.0000;
        let base_ivap = 0.0000;
        let base_inafecto = 0.0000;
        let base_exonerado = 0.0000;
        let total_igv = 0.0000;
        let total_ivap = 0.0000;
        let total = 0.0000;

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (item.COD_ASIENTO_MOVIMIENTO === data_codigo) {
                item.COD_ESTADO = '0';
            }
            if (parseInt(item.COD_ESTADO) === 1) {
                switch (item.COD_DOC_CTBLE_REF) {
                    case 'AIGV':
                        if (item.COD_ORDEN_REF === '18') {
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible = base_imponible + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            } else {
                                base_imponible = base_imponible + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            }
                        } else if (item.COD_ORDEN_REF === '10') {
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            } else {
                                base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            }
                        }
                        break;
                    case 'IIGV':
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        } else {
                            base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        }
                        break;
                    case 'EIGV':
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_exonerado = base_exonerado + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        } else {
                            base_exonerado = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        }
                        break;
                }
                if (/^4011/.test(item.TXT_CUENTA_CONTABLE)) {
                    if (moneda_id_editar !== 'MON0000000000001') {
                        total_igv = total_igv + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                    } else {
                        total_igv = total_igv + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                    }
                }
            }
        });

        total = base_imponible + base_imponible_10 + base_ivap + base_inafecto + base_exonerado + total_igv + total_ivap;

        switch (data_asiento) {
            case 'C':
                arrayCabecera = JSON.parse(document.getElementById("asiento_cabecera_compra").value);
                // Recorrerlo
                arrayCabecera.forEach(item => {
                    item.TOTAL_BASE_IMPONIBLE = base_imponible;
                    item.TOTAL_BASE_IMPONIBLE_10 = base_imponible_10;
                    item.TOTAL_BASE_INAFECTA = base_inafecto;
                    item.TOTAL_BASE_EXONERADA = base_exonerado;
                    item.TOTAL_IGV = total_igv;
                    item.TOTAL_AFECTO_IVAP = base_ivap;
                    item.TOTAL_IVAP = total_ivap;
                });
                console.log(arrayCabecera);
                document.getElementById("asiento_cabecera_compra").value = JSON.stringify(arrayCabecera);
                document.getElementById("asiento_detalle_compra").value = JSON.stringify(arrayDetalle);
                $("#asientototales tbody tr").each(function () {
                    let fila = $(this);

                    // Actualizar las celdas visibles de la tabla
                    fila.find(".col-base-imponible").text(number_format(base_imponible, 4));
                    fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4));
                    fila.find(".col-base-ivap").text(number_format(base_ivap, 4));
                    fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4));
                    fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4));
                    fila.find(".col-igv").text(number_format(total_igv, 4));
                    fila.find(".col-ivap").text(number_format(total_ivap, 4));
                    fila.find(".col-total").text(number_format(total, 4));

                });
                break;
            case 'P':
                arrayCabecera = JSON.parse(document.getElementById("asiento_cabecera_percepcion").value);
                // Recorrerlo
                arrayCabecera.forEach(item => {
                    item.TOTAL_BASE_IMPONIBLE = base_imponible;
                    item.TOTAL_BASE_IMPONIBLE_10 = base_imponible_10;
                    item.TOTAL_BASE_INAFECTA = base_inafecto;
                    item.TOTAL_BASE_EXONERADA = base_exonerado;
                    item.TOTAL_IGV = total_igv;
                    item.TOTAL_AFECTO_IVAP = base_ivap;
                    item.TOTAL_IVAP = total_ivap;
                });
                document.getElementById("asiento_cabecera_percepcion").value = JSON.stringify(arrayCabecera);
                document.getElementById("asiento_detalle_percepcion").value = JSON.stringify(arrayDetalle);
                $("#asiento_totales_percepcion tbody tr").each(function () {
                    let fila = $(this);

                    // Actualizar las celdas visibles de la tabla
                    fila.find(".col-base-imponible").text(number_format(base_imponible, 4));
                    fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4));
                    fila.find(".col-base-ivap").text(number_format(base_ivap, 4));
                    fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4));
                    fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4));
                    fila.find(".col-igv").text(number_format(total_igv, 4));
                    fila.find(".col-ivap").text(number_format(total_ivap, 4));
                    fila.find(".col-total").text(number_format(total, 4));

                });
                break;
        }

        let table = $('#asientodetalle').DataTable();
        let row = $(this).closest('tr');
        table.row(row).remove().draw();

        //$(this).closest("tr").remove();

    });

    $(document).on('click', ".editar-cuenta", function (e) {

        let data_codigo = $(this).parents('.fila').attr('data_codigo');
        let data_asiento = $(this).parents('.fila').attr('data_asiento');
        let data_moneda = $(this).parents('.fila').attr('data_moneda');
        let data_tc = $(this).parents('.fila').attr('data_tc');
        let arrayDetalle = null;
        let data_cuenta_id = '';
        let data_debe_mn = 0.0000;
        let data_haber_mn = 0.0000;
        let data_debe_me = 0.0000;
        let data_haber_me = 0.0000;
        let data_afecto = '';
        let data_porc_afecto = '';
        let afecto = '';
        let partida = 'COP0000000000001';
        let monto = 0.0000;

        if (data_moneda === null || data_moneda.trim() === "") {
            $.alert({
                title: 'Error',
                content: 'No hay moneda seleccionada',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        if (!data_tc || parseFloat(data_tc) === 0) {
            $.alert({
                title: 'Error',
                content: 'El tipo de cambio no puede ser 0',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false;
        }

        switch (data_asiento) {
            case 'C':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);
                break;
            case 'RV':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable_reversion").value);
                break;
            case 'D':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_deduccion").value);
                break;
            case 'P':
                arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_percepcion").value);
                break;
        }

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (item.COD_ASIENTO_MOVIMIENTO === data_codigo) {
                data_cuenta_id = item.COD_CUENTA_CONTABLE === null ? '' : item.COD_CUENTA_CONTABLE;
                data_debe_mn = item.CAN_DEBE_MN;
                data_haber_mn = item.CAN_HABER_MN;
                data_debe_me = item.CAN_DEBE_ME;
                data_haber_me = item.CAN_HABER_ME;
                data_afecto = item.COD_DOC_CTBLE_REF;
                data_porc_afecto = item.COD_ORDEN_REF;
                return; // saltar esta iteración
            }
        });

        switch (data_afecto) {
            case 'AIGV':
                afecto = 'CTI0000000000001';
                break;
            case 'IIGV':
                afecto = 'CTI0000000000002';
                break;
            case 'EIGV':
                afecto = 'CTI0000000000003';
                break;
            default:
                afecto = '';
                break;
        }

        if (parseFloat(data_haber_mn) > 0) {
            partida = 'COP0000000000002';
        }

        monto = parseFloat(data_debe_me) + parseFloat(data_haber_me);

        if (data_moneda === 'MON0000000000001') {
            monto = parseFloat(data_debe_mn) + parseFloat(data_haber_mn);
        }

        //$('#cuenta_contable_id').val(data_cuenta_id.trim()).trigger('change');
        //$('#partida_id').val(partida.trim()).trigger('change');
        //$('#tipo_igv_id').val(afecto.trim()).trigger('change');
        //$('#porc_tipo_igv_id').val(data_porc_afecto.trim()).trigger('change');

        window.selects['cuenta_contable_id'].setSelected(data_cuenta_id.trim());
        window.selects['partida_id'].setSelected(partida.trim());
        window.selects['tipo_igv_id'].setSelected(afecto.trim());
        window.selects['porc_tipo_igv_id'].setSelected(data_porc_afecto.trim());
        $('#cuenta_contable_id').trigger('change');
        $('#partida_id').trigger('change');
        $('#tipo_igv_id').trigger('change');
        $('#porc_tipo_igv_id').trigger('change');

        $('#monto').val(monto);

        $('#asiento_id_editar').val(data_codigo);
        $('#form_id_editar').val(data_asiento);
        $('#moneda_id_editar').val(data_moneda);
        $('#tc_editar').val(data_tc);
        $('#titulodetalle').text('Modificar Detalle');
        $('.btn-registrar-movimiento').hide();
        $('.btn-editar-movimiento').show();
        $('.tablageneral').toggle("slow");
        $('.editarcuentas').toggle("slow");

    });

    $("#anio_asiento").on('change', function () {

        event.preventDefault();
        let anio = $('#anio_asiento').val();
        let _token = $('#token').val();
        //validacioones
        if (anio == '') {
            alerterrorajax("Seleccione un anio.");
            return false;
        }
        data = {
            _token: _token,
            anio: anio
        };

        ajax_normal_combo(data, "/ajax-combo-periodo-xanio-xempresa", "ajax_anio_asiento")

    });

    $('#tipo_asiento').on('change', function () {
        if ($(this).val() === "TAS0000000000003" || $(this).val() === "TAS0000000000004") {
            $('#asientototales').show();
        } else {
            $('#asientototales').hide();
        }
    });

    $("#porcentaje_detraccion").on('keypress keyup keydown change', function (e) {

        let total_documento = $('#total_xml').val().replace(',', '');
        let porc_descuento = $(this).val().replace(',', '');
        let total = parseFloat(total_documento) * parseFloat(porc_descuento) / 100;
        $('#total_detraccion_asiento').val(Math.round(total));

    });

    $("#tipo_descuento_asiento").on('change', function () {

        event.preventDefault();
        let tipo_descuento = $('#tipo_descuento_asiento').val();

        if (tipo_descuento === 'DCT0000000000002') {
            $('#porcentaje_detraccion').prop('disabled', false);
            $('#const_detraccion_asiento').prop('disabled', false);
            $('#fecha_detraccion_asiento').prop('disabled', false);
            $('#porcentaje_detraccion').val(1.00);
        } else {
            $('#porcentaje_detraccion').prop('disabled', true);
            $('#const_detraccion_asiento').prop('disabled', true);
            $('#fecha_detraccion_asiento').prop('disabled', true);
            $('#porcentaje_detraccion').val(0.00);
            $('#total_detraccion').val(0.00);
        }

    });
//nuevo
    $('.elimnaritem').on('click', function (event) {
        event.preventDefault();
        var href = $(this).attr('href');

        $.confirm({
            title: '¿Confirma la Eliminacion?',
            content: 'Eliminar item del Comprobante',
            buttons: {
                confirmar: function () {
                    window.location.href = href;
                },
                cancelar: function () {
                    $.alert('Se cancelo Eliminacion');
                }
            }
        });

    });

    $('.btnaprobarcomporbatnte').on('click', function (event) {
        event.preventDefault();

        abrircargando();

        let nro_cuenta = $('#nro_cuenta_contable').val();

        let detalles = [];
        $('#asientolista tbody tr').each(function () {
            data_input = $(this).attr('data_input');
            if (nro_cuenta === '' && data_input === 'C') {
                let arrayDetalle = JSON.parse($(this).attr('data_asiento_detalle'));
                let cadenaNumeroCuenta = '';
                // Recorrerlo
                arrayDetalle.forEach(item => {
                    if (parseInt(item.COD_ESTADO) === 1) {
                        if (!/^4011/.test(item.TXT_CUENTA_CONTABLE) && !/^42/.test(item.TXT_CUENTA_CONTABLE) && !/^43/.test(item.TXT_CUENTA_CONTABLE)) {
                            if (cadenaNumeroCuenta === '') {
                                cadenaNumeroCuenta = item.TXT_CUENTA_CONTABLE;
                            } else {
                                if (!cadenaNumeroCuenta.includes(item.TXT_CUENTA_CONTABLE)) {
                                    cadenaNumeroCuenta = cadenaNumeroCuenta + ',' + item.TXT_CUENTA_CONTABLE;
                                }
                            }
                        }
                    }
                });
                $('#nro_cuenta_contable').val(cadenaNumeroCuenta);
            }

            detalles.push({
                cabecera: $(this).attr('data_asiento_cabecera'),
                detalle: $(this).attr('data_asiento_detalle'),
            });
        });

        $('#asientosgenerados').val(JSON.stringify(detalles));

        $.confirm({
            title: '¿Confirma la Aprobacion?',
            content: 'Aprobar el Comprobante',
            buttons: {
                confirmar: function () {
                    $("#formpedido").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo Aprobacion');
                }
            }
        });

    });

    $('.btnobservarcomporbatnte').on('click', function (event) {
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Observacion?',
            content: 'Observacion el Comprobante',
            buttons: {
                confirmar: function () {
                    $("#formpedidoobservar").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la Observacion');
                }
            }
        });

    });

    $('.btnreparablecomporbatnte').on('click', function (event) {
        event.preventDefault();

        let table = $('#asientodetallereparable').DataTable();

        let totalDebeMN = $(table.column(3).footer()).text().trim();
        let totalHaberMN = $(table.column(4).footer()).text().trim();
        let totalDebeME = $(table.column(5).footer()).text().trim();
        let totalHaberME = $(table.column(6).footer()).text().trim();

        let periodo_asiento = $("#periodo_asiento_reparable").val();
        let comprobante_asiento = $("#comprobante_asiento_reparable").val();
        let moneda_id_editar = $("#moneda_asiento_reparable").val();
        let tc_editar = $("#tipo_cambio_asiento_reparable").val();
        let proveedor_asiento = $("#empresa_asiento_reparable").val();
        let tipo_asiento = $("#tipo_asiento_reparable").val();
        let fecha_asiento = $("#fecha_asiento_reparable").val();
        let tipo_comprobante = $("#tipo_documento_asiento_reparable").val();
        let serie_comprobante = $("#serie_asiento_reparable").val();
        let numero_comprobante = $("#numero_asiento_reparable").val();

        //if (moneda_id_editar === 'MON0000000000001') {
        if (totalDebeMN !== totalHaberMN) {
            $.alert({
                title: 'Error',
                content: 'El asiento no cuadra verificar los totales de la moneda nacional en el debe y haber',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false; // Detiene la ejecución
        }
        //} else {
        if (totalDebeME !== totalHaberME) {
            $.alert({
                title: 'Error',
                content: 'El asiento no cuadra verificar los totales de la moneda extranjera en el debe y haber',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-red',
                    }
                }
            });
            return false; // Detiene la ejecución
        }
        //}

        // Array de todos los valores
        let campos = [
            {nombre: "Periodo", valor: periodo_asiento},
            {nombre: "Comprobante", valor: comprobante_asiento},
            {nombre: "Moneda", valor: moneda_id_editar},
            {nombre: "Tipo de Cambio", valor: tc_editar},
            {nombre: "Proveedor", valor: proveedor_asiento},
            {nombre: "Tipo Asiento", valor: tipo_asiento},
            {nombre: "Fecha", valor: fecha_asiento},
            {nombre: "Tipo Comprobante", valor: tipo_comprobante},
            {nombre: "Serie", valor: serie_comprobante},
            {nombre: "Número", valor: numero_comprobante},
        ];

        // Recorremos y validamos
        for (let campo of campos) {
            if (!campo.valor || campo.valor === "") {
                $.alert({
                    title: 'Error',
                    content: 'El campo ' + campo.nombre + ' no puede estar vacío.',
                    type: 'red',
                    buttons: {
                        ok: {
                            text: 'OK',
                            btnClass: 'btn-red',
                        }
                    }
                });
                return false; // Detiene la ejecución
            }
        }

        $.confirm({
            title: '¿Confirma la Observacion?',
            content: 'Observacion el Comprobante',
            buttons: {
                confirmar: function () {
                    $("#formpedidoreparable").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la Observacion');
                }
            }
        });

    });

    $('.btnrechazocomporbatnte').on('click', function (event) {
        event.preventDefault();
        $.confirm({
            title: '¿Confirma el extorno?',
            content: 'Extornar el Comprobante',
            buttons: {
                confirmar: function () {
                    $("#formpedidorechazar").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo el Extorno');
                }
            }
        });

    });


    $('.btnrecomendarcomprobante').on('click', function (event) {
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Recomendacion?',
            content: 'Recomendacion del Comprobante',
            buttons: {
                confirmar: function () {
                    $("#formpedidorecomendar").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la Recomendacion');
                }
            }
        });

    });


    $('.btnguardarcliente').on('click', function (event) {
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Aprobacion?',
            content: 'Aprobar el Comprobante',
            buttons: {
                confirmar: function () {
                    $("#formpedido").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo Aprobacion');
                }
            }
        });

    });


    $('.btnextornar').on('click', function (event) {
        event.preventDefault();
        $.confirm({
            title: '¿Confirma el Extorno?',
            content: 'Extorno el Comprobante',
            buttons: {
                confirmar: function () {
                    $("#formpedido").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo el Extorno');
                }
            }
        });

    });


    $('.btnobservar').on('click', function (event) {
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Observacion?',
            content: 'Observacion el Comprobante',
            buttons: {
                confirmar: function () {
                    $("#formpedido").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la Observacion');
                }
            }
        });

    });


    $('.btnrecomendar').on('click', function (event) {
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Recomendacion?',
            content: 'Recomendacion del Comprobante',
            buttons: {
                confirmar: function () {
                    $("#formpedido").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la Recomendacion');
                }
            }
        });

    });


    $('#preaprobar').on('click', function (event) {
        event.preventDefault();
        data = dataenviar();
        if (data.length <= 0) {
            alerterrorajax("Seleccione por lo menos un Comprobante");
            return false;
        }
        var datastring = JSON.stringify(data);
        $('#pedido').val(datastring);
        $.confirm({
            title: '¿Confirma la Pre Aprobacion?',
            content: 'Pre Aprobar los Comprobantes',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    $("#formpedido").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo Pre Aprobacion');
                }
            }
        });

    });


    function dataenviar() {
        var data = [];
        $(".listatabla tr").each(function () {
            check = $(this).find('input');
            nombre = $(this).find('input').attr('id');
            if (nombre != 'todo') {
                if ($(check).is(':checked')) {
                    data.push({id: $(check).attr("id")});
                }
            }
        });
        return data;
    }

    function redondear4(num) {
        return Math.round((num + Number.EPSILON) * 10000) / 10000;
    }

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

    // Ajustar columnas al cambiar de tab
    $('a[data-toggle="tab"], a[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
        $('#asientodetalle').DataTable().columns.adjust().draw();
        $('#asientodetallereversion').DataTable().columns.adjust().draw();
        $('#asientodetallededuccion').DataTable().columns.adjust().draw();
        $('#asientodetallepercepcion').DataTable().columns.adjust().draw();
        $('#asientodetallereparable').DataTable().columns.adjust().draw();
    });

});
