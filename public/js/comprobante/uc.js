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

        $('#cuenta_contable_id_reparable').val(data_cuenta_id.trim()).trigger('change');
        $('#partida_id_reparable').val(partida.trim()).trigger('change');
        $('#tipo_igv_id_reparable').val(afecto.trim()).trigger('change');
        $('#porc_tipo_igv_id_reparable').val(data_porc_afecto.trim()).trigger('change');
        $('#monto_reparable').val(monto);

        $('#asiento_id_editar_reparable').val(data_codigo);
        $('#moneda_id_editar_reparable').val(data_moneda);
        $('#tc_editar_reparable').val(data_tc);

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
                item.COD_ESTADO = 0;
                return; // saltar esta iteración
            }
        });

        $(this).closest("tr").remove();

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

        arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable").value);

        data_codigo = data_codigo + (arrayDetalle.length + 1).toString();

        $('#cuenta_contable_id_reparable').val(data_cuenta_id.trim()).trigger('change');
        $('#partida_id_reparable').val(partida.trim()).trigger('change');
        $('#tipo_igv_id_reparable').val(afecto.trim()).trigger('change');
        $('#porc_tipo_igv_id_reparable').val(data_porc_afecto.trim()).trigger('change');
        $('#partida_id_reparable').val(partida).trigger('change');
        $('#monto_reparable').val(monto);

        $('#asiento_id_editar_reparable').val(data_codigo);
        $('#moneda_id_editar_reparable').val(data_moneda);
        $('#tc_editar_reparable').val(data_tc);

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
        monto = monto.replace(",", "");
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
        }

        arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable").value);

        if (moneda_id_editar === 'MON0000000000001') {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = monto;
                can_haber_mn = 0.0000;
                can_debe_me = redondear4(parseFloat(monto) / tc_editar);
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = monto;
                can_debe_me = 0.0000;
                can_haber_me = redondear4(parseFloat(monto) / tc_editar);
            }
        } else {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = redondear4(parseFloat(monto) * tc_editar);
                can_haber_mn = 0.0000;
                can_debe_me = monto;
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = redondear4(parseFloat(monto) * tc_editar);
                can_debe_me = 0.0000;
                can_haber_me = monto;
            }
        }

        // Recorrerlo
        arrayDetalle.forEach(item => {
            if (parseInt(item.COD_ESTADO) === 1) {
                if (item.COD_ASIENTO_MOVIMIENTO === asiento_id_editar) {
                    item.COD_CUENTA_CONTABLE = cuenta_contable_id;
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
        $("#asientodetallereparable tbody tr").each(function () {
            let fila = $(this);

            // buscamos en la fila el hidden con el id del asiento
            let codAsiento = fila.attr('data_codigo');

            if (codAsiento === asiento_id_editar) {
                // Actualizar las celdas visibles de la tabla
                fila.find(".col-cuenta").text(numero_cuenta);
                fila.find(".col-glosa").text(glosa_cuenta);
                fila.find(".col-debe-mn").text(number_format(can_debe_mn, 4, ',', '.'));
                fila.find(".col-haber-mn").text(number_format(can_haber_mn, 4, ',', '.'));
                fila.find(".col-debe-me").text(number_format(can_debe_me, 4, ',', '.'));
                fila.find(".col-haber-me").text(number_format(can_haber_me, 4, ',', '.'));
            }
        });

        $('.tablageneralreparable').toggle("slow");
        $('.editarcuentasreparable').toggle("slow");
    });

    $(".btn-registrar-movimiento-reparable").on('click', function (e) {

        let cuenta_contable_id = $('#cuenta_contable_id_reparable').val();
        let afecto_igv = $('#tipo_igv_id_reparable').val();
        let porc_afecto_igv = $('#porc_tipo_igv_id_reparable').val();
        let monto = $('#monto_reparable').val();
        monto = monto.replace(",", "");
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
        }

        arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_reparable").value);

        if (moneda_id_editar === 'MON0000000000001') {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = monto;
                can_haber_mn = 0.0000;
                can_debe_me = redondear4(parseFloat(monto) / tc_editar);
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = monto;
                can_debe_me = 0.0000;
                can_haber_me = redondear4(parseFloat(monto) / tc_editar);
            }
        } else {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = redondear4(parseFloat(monto) * tc_editar);
                can_haber_mn = 0.0000;
                can_debe_me = monto;
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = redondear4(parseFloat(monto) * tc_editar);
                can_debe_me = 0.0000;
                can_haber_me = monto;
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

        // Crear la fila con atributos y estilos
        let nuevaFila = `
            <tr class="fila" data_codigo="${asiento_id_editar}"
                data_moneda="${moneda_id_editar}" data_tc="${tc_editar}">
                <td>${asiento_id_editar}</td>
                <td>${numero_cuenta}</td>
                <td>${glosa_cuenta}</td>
                <td style="text-align: right">${number_format(can_debe_mn, 4, ',', '.')}</td>
                <td style="text-align: right">${number_format(can_haber_mn, 4, ',', '.')}</td>
                <td style="text-align: right">${number_format(can_debe_me, 4, ',', '.')}</td>
                <td style="text-align: right">${number_format(can_haber_me, 4, ',', '.')}</td>
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
        $("#asientodetallereparable tbody").append(nuevaFila);

        $('.tablageneralreparable').toggle("slow");
        $('.editarcuentasreparable').toggle("slow");
    });

    // LINEAS JAVASCRIPT NO REPARABLES
    $(".btn-regresar-lista").on('click', function (e) {
        $('.tablageneral').toggle("slow");
        $('.editarcuentas').toggle("slow");
    });

    $(".btn-registrar-movimiento").on('click', function (e) {

        let cuenta_contable_id = $('#cuenta_contable_id').val();
        let afecto_igv = $('#tipo_igv_id').val();
        let porc_afecto_igv = $('#porc_tipo_igv_id').val();
        let monto = $('#monto').val();
        monto = monto.replace(",", "");
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
                can_debe_mn = monto;
                can_haber_mn = 0.0000;
                can_debe_me = redondear4(parseFloat(monto) / tc_editar);
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = monto;
                can_debe_me = 0.0000;
                can_haber_me = redondear4(parseFloat(monto) / tc_editar);
            }
        } else {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = redondear4(parseFloat(monto) * tc_editar);
                can_haber_mn = 0.0000;
                can_debe_me = monto;
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = redondear4(parseFloat(monto) * tc_editar);
                can_debe_me = 0.0000;
                can_haber_me = monto;
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
                            base_imponible = base_imponible + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible = base_imponible + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            }
                        } else if (item.COD_ORDEN_REF === '10') {
                            base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            }
                        }
                        break;
                    case 'IIGV':
                        base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        }
                        break;
                    case 'EIGV':
                        base_exonerado = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_exonerado = base_exonerado + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        }
                        break;
                }
                if (/^40/.test(item.TXT_CUENTA_CONTABLE)) {
                    total_igv = total_igv + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                    if (moneda_id_editar !== 'MON0000000000001') {
                        total_igv = total_igv + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                    }
                }
            }
        });

        total = base_imponible + base_imponible_10 + base_ivap + base_inafecto + base_exonerado + total_igv + total_ivap;

        // Crear la fila con atributos y estilos
        let nuevaFila = `
            <tr class="fila" data_codigo="${asiento_id_editar}" data_asiento="${form_id_editar}"
                data_moneda="${moneda_id_editar}" data_tc="${tc_editar}">
                <td>${asiento_id_editar}</td>
                <td>${numero_cuenta}</td>
                <td>${glosa_cuenta}</td>
                <td style="text-align: right">${number_format(can_debe_mn, 4, ',', '.')}</td>
                <td style="text-align: right">${number_format(can_haber_mn, 4, ',', '.')}</td>
                <td style="text-align: right">${number_format(can_debe_me, 4, ',', '.')}</td>
                <td style="text-align: right">${number_format(can_haber_me, 4, ',', '.')}</td>
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
                $("#asientodetalle tbody").append(nuevaFila);
                $("#asientototales tbody tr").each(function () {
                    let fila = $(this);

                    // Actualizar las celdas visibles de la tabla
                    fila.find(".col-base-imponible").text(number_format(base_imponible, 4, ',', '.'));
                    fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4, ',', '.'));
                    fila.find(".col-base-ivap").text(number_format(base_ivap, 4, ',', '.'));
                    fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4, ',', '.'));
                    fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4, ',', '.'));
                    fila.find(".col-igv").text(number_format(total_igv, 4, ',', '.'));
                    fila.find(".col-ivap").text(number_format(total_ivap, 4, ',', '.'));
                    fila.find(".col-total").text(number_format(total, 4, ',', '.'));

                });
                break;
            case 'RV':
                document.getElementById("asiento_detalle_reparable_reversion").value = JSON.stringify(arrayDetalle);
                // Después de actualizar arrayDetalle
                $("#asientodetallereversion tbody").append(nuevaFila);
                break;
            case 'D':
                document.getElementById("asiento_detalle_deduccion").value = JSON.stringify(arrayDetalle);
                // Después de actualizar arrayDetalle
                $("#asientodetallededuccion tbody").append(nuevaFila);
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
                $("#asientodetallepercepcion tbody").append(nuevaFila);
                $("#asiento_totales_percepcion tbody tr").each(function () {
                    let fila = $(this);

                    // Actualizar las celdas visibles de la tabla
                    fila.find(".col-base-imponible").text(number_format(base_imponible, 4, ',', '.'));
                    fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4, ',', '.'));
                    fila.find(".col-base-ivap").text(number_format(base_ivap, 4, ',', '.'));
                    fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4, ',', '.'));
                    fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4, ',', '.'));
                    fila.find(".col-igv").text(number_format(total_igv, 4, ',', '.'));
                    fila.find(".col-ivap").text(number_format(total_ivap, 4, ',', '.'));
                    fila.find(".col-total").text(number_format(total, 4, ',', '.'));

                });
                break;
        }
        $('.tablageneral').toggle("slow");
        $('.editarcuentas').toggle("slow");
    });

    $(".btn-editar-movimiento").on('click', function (e) {

        let cuenta_contable_id = $('#cuenta_contable_id').val();
        let afecto_igv = $('#tipo_igv_id').val();
        let porc_afecto_igv = $('#porc_tipo_igv_id').val();
        let monto = $('#monto').val();
        monto = monto.replace(",", "");
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
                can_debe_mn = monto;
                can_haber_mn = 0.0000;
                can_debe_me = redondear4(parseFloat(monto) / tc_editar);
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = monto;
                can_debe_me = 0.0000;
                can_haber_me = redondear4(parseFloat(monto) / tc_editar);
            }
        } else {
            if (partida_id === 'COP0000000000001') {
                can_debe_mn = redondear4(parseFloat(monto) * tc_editar);
                can_haber_mn = 0.0000;
                can_debe_me = monto;
                can_haber_me = 0.0000;
            } else {
                can_debe_mn = 0.0000;
                can_haber_mn = redondear4(parseFloat(monto) * tc_editar);
                can_debe_me = 0.0000;
                can_haber_me = monto;
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
                            base_imponible = base_imponible + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible = base_imponible + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            }
                        } else if (item.COD_ORDEN_REF === '10') {
                            base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            }
                        }
                        break;
                    case 'IIGV':
                        base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        }
                        break;
                    case 'EIGV':
                        base_exonerado = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_exonerado = base_exonerado + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        }
                        break;
                }
                if (/^40/.test(item.TXT_CUENTA_CONTABLE)) {
                    total_igv = total_igv + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                    if (moneda_id_editar !== 'MON0000000000001') {
                        total_igv = total_igv + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                    }
                }
            }
        });

        total = base_imponible + base_imponible_10 + base_ivap + base_inafecto + base_exonerado + total_igv + total_ivap;

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
                $("#asientodetalle tbody tr").each(function () {
                    let fila = $(this);

                    // buscamos en la fila el hidden con el id del asiento
                    let codAsiento = fila.attr('data_codigo');

                    if (codAsiento === asiento_id_editar) {
                        // Actualizar las celdas visibles de la tabla
                        fila.find(".col-cuenta").text(numero_cuenta);
                        fila.find(".col-glosa").text(glosa_cuenta);
                        fila.find(".col-debe-mn").text(number_format(can_debe_mn, 4, ',', '.'));
                        fila.find(".col-haber-mn").text(number_format(can_haber_mn, 4, ',', '.'));
                        fila.find(".col-debe-me").text(number_format(can_debe_me, 4, ',', '.'));
                        fila.find(".col-haber-me").text(number_format(can_haber_me, 4, ',', '.'));
                    }
                });
                $("#asientototales tbody tr").each(function () {
                    let fila = $(this);

                    // Actualizar las celdas visibles de la tabla
                    fila.find(".col-base-imponible").text(number_format(base_imponible, 4, ',', '.'));
                    fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4, ',', '.'));
                    fila.find(".col-base-ivap").text(number_format(base_ivap, 4, ',', '.'));
                    fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4, ',', '.'));
                    fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4, ',', '.'));
                    fila.find(".col-igv").text(number_format(total_igv, 4, ',', '.'));
                    fila.find(".col-ivap").text(number_format(total_ivap, 4, ',', '.'));
                    fila.find(".col-total").text(number_format(total, 4, ',', '.'));

                });
                break;
            case 'RV':
                document.getElementById("asiento_detalle_reparable_reversion").value = JSON.stringify(arrayDetalle);
                // Después de actualizar arrayDetalle
                $("#asientodetallereversion tbody tr").each(function () {
                    let fila = $(this);

                    // buscamos en la fila el hidden con el id del asiento
                    let codAsiento = fila.attr('data_codigo');

                    if (codAsiento === asiento_id_editar) {
                        // Actualizar las celdas visibles de la tabla
                        fila.find(".col-cuenta").text(numero_cuenta);
                        fila.find(".col-glosa").text(glosa_cuenta);
                        fila.find(".col-debe-mn").text(number_format(can_debe_mn, 4, ',', '.'));
                        fila.find(".col-haber-mn").text(number_format(can_haber_mn, 4, ',', '.'));
                        fila.find(".col-debe-me").text(number_format(can_debe_me, 4, ',', '.'));
                        fila.find(".col-haber-me").text(number_format(can_haber_me, 4, ',', '.'));
                    }
                });
                break;
            case 'D':
                document.getElementById("asiento_detalle_deduccion").value = JSON.stringify(arrayDetalle);
                // Después de actualizar arrayDetalle
                $("#asientodetallededuccion tbody tr").each(function () {
                    let fila = $(this);

                    // buscamos en la fila el hidden con el id del asiento
                    let codAsiento = fila.attr('data_codigo');

                    if (codAsiento === asiento_id_editar) {
                        // Actualizar las celdas visibles de la tabla
                        fila.find(".col-cuenta").text(numero_cuenta);
                        fila.find(".col-glosa").text(glosa_cuenta);
                        fila.find(".col-debe-mn").text(number_format(can_debe_mn, 4, ',', '.'));
                        fila.find(".col-haber-mn").text(number_format(can_haber_mn, 4, ',', '.'));
                        fila.find(".col-debe-me").text(number_format(can_debe_me, 4, ',', '.'));
                        fila.find(".col-haber-me").text(number_format(can_haber_me, 4, ',', '.'));
                    }
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
                // Después de actualizar arrayDetalle
                $("#asientodetallepercepcion tbody tr").each(function () {
                    let fila = $(this);

                    // buscamos en la fila el hidden con el id del asiento
                    let codAsiento = fila.attr('data_codigo');

                    if (codAsiento === asiento_id_editar) {
                        // Actualizar las celdas visibles de la tabla
                        fila.find(".col-cuenta").text(numero_cuenta);
                        fila.find(".col-glosa").text(glosa_cuenta);
                        fila.find(".col-debe-mn").text(number_format(can_debe_mn, 4, ',', '.'));
                        fila.find(".col-haber-mn").text(number_format(can_haber_mn, 4, ',', '.'));
                        fila.find(".col-debe-me").text(number_format(can_debe_me, 4, ',', '.'));
                        fila.find(".col-haber-me").text(number_format(can_haber_me, 4, ',', '.'));
                    }
                });
                $("#asiento_totales_percepcion tbody tr").each(function () {
                    let fila = $(this);

                    // Actualizar las celdas visibles de la tabla
                    fila.find(".col-base-imponible").text(number_format(base_imponible, 4, ',', '.'));
                    fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4, ',', '.'));
                    fila.find(".col-base-ivap").text(number_format(base_ivap, 4, ',', '.'));
                    fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4, ',', '.'));
                    fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4, ',', '.'));
                    fila.find(".col-igv").text(number_format(total_igv, 4, ',', '.'));
                    fila.find(".col-ivap").text(number_format(total_ivap, 4, ',', '.'));
                    fila.find(".col-total").text(number_format(total, 4, ',', '.'));

                });
                break;
        }
        $('.tablageneral').toggle("slow");
        $('.editarcuentas').toggle("slow");
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

        $('#cuenta_contable_id').val(data_cuenta_id.trim()).trigger('change');
        $('#partida_id').val(partida.trim()).trigger('change');
        $('#tipo_igv_id').val(afecto.trim()).trigger('change');
        $('#porc_tipo_igv_id').val(data_porc_afecto.trim()).trigger('change');
        $('#partida_id').val(partida).trigger('change');
        $('#monto').val(monto);

        $('#asiento_id_editar').val(data_codigo);
        $('#form_id_editar').val(data_asiento);
        $('#moneda_id_editar').val(data_moneda);
        $('#tc_editar').val(data_tc);

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
                item.COD_ESTADO = 0;
            }
            if (parseInt(item.COD_ESTADO) === 1) {
                switch (item.COD_DOC_CTBLE_REF) {
                    case 'AIGV':
                        if (item.COD_ORDEN_REF === '18') {
                            base_imponible = base_imponible + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible = base_imponible + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            }
                        } else if (item.COD_ORDEN_REF === '10') {
                            base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                            if (moneda_id_editar !== 'MON0000000000001') {
                                base_imponible_10 = base_imponible_10 + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                            }
                        }
                        break;
                    case 'IIGV':
                        base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_inafecto = base_inafecto + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        }
                        break;
                    case 'EIGV':
                        base_exonerado = base_inafecto + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                        if (moneda_id_editar !== 'MON0000000000001') {
                            base_exonerado = base_exonerado + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                        }
                        break;
                }
                if (/^40/.test(item.TXT_CUENTA_CONTABLE)) {
                    total_igv = total_igv + parseFloat(item.CAN_DEBE_MN) + parseFloat(item.CAN_HABER_MN);
                    if (moneda_id_editar !== 'MON0000000000001') {
                        total_igv = total_igv + parseFloat(item.CAN_DEBE_ME) + parseFloat(item.CAN_HABER_ME);
                    }
                }
            }
        });

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

                $("#asientototales tbody tr").each(function () {
                    let fila = $(this);

                    // Actualizar las celdas visibles de la tabla
                    fila.find(".col-base-imponible").text(number_format(base_imponible, 4, ',', '.'));
                    fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4, ',', '.'));
                    fila.find(".col-base-ivap").text(number_format(base_ivap, 4, ',', '.'));
                    fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4, ',', '.'));
                    fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4, ',', '.'));
                    fila.find(".col-igv").text(number_format(total_igv, 4, ',', '.'));
                    fila.find(".col-ivap").text(number_format(total_ivap, 4, ',', '.'));
                    fila.find(".col-total").text(number_format(total, 4, ',', '.'));

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

                $("#asiento_totales_percepcion tbody tr").each(function () {
                    let fila = $(this);

                    // Actualizar las celdas visibles de la tabla
                    fila.find(".col-base-imponible").text(number_format(base_imponible, 4, ',', '.'));
                    fila.find(".col-base-imponible-10").text(number_format(base_imponible_10, 4, ',', '.'));
                    fila.find(".col-base-ivap").text(number_format(base_ivap, 4, ',', '.'));
                    fila.find(".col-base-inafecto").text(number_format(base_inafecto, 4, ',', '.'));
                    fila.find(".col-base-exonerado").text(number_format(base_exonerado, 4, ',', '.'));
                    fila.find(".col-igv").text(number_format(total_igv, 4, ',', '.'));
                    fila.find(".col-ivap").text(number_format(total_ivap, 4, ',', '.'));
                    fila.find(".col-total").text(number_format(total, 4, ',', '.'));

                });
                break;
        }

        $(this).closest("tr").remove();

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

        $('#cuenta_contable_id').val(data_cuenta_id.trim()).trigger('change');
        $('#partida_id').val(partida.trim()).trigger('change');
        $('#tipo_igv_id').val(afecto.trim()).trigger('change');
        $('#porc_tipo_igv_id').val(data_porc_afecto.trim()).trigger('change');
        $('#monto').val(monto);

        $('#asiento_id_editar').val(data_codigo);
        $('#form_id_editar').val(data_asiento);
        $('#moneda_id_editar').val(data_moneda);
        $('#tc_editar').val(data_tc);

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
            debugger;
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
