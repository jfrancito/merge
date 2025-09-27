$(document).ready(function () {
    let carpeta = $("#carpeta").val();

    $('.pnlasientos').hide();

    //nuevo

    $(".diferencia-montos").on('click', function (e) {
        let totalDebeMN = 0;
        let totalHaberMN = 0;
        let totalDebeME = 0;
        let totalHaberME = 0;
        let diferencia = 0;
        let table = $('#asientodetalle').DataTable();
        let arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);
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

        // recorrer filas y acumular
        $("#asientodetalle tbody tr").each(function () {
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
                        break; // ✅ detener al encontrar el primero
                    }
                }
                if (totalAsiento > totalDebeMN || totalAsiento < totalDebeMN) {
                    if (!/^40/.test(item.TXT_CUENTA_CONTABLE) && parseFloat(item.CAN_DEBE_MN) > 0.0000) {
                        if (totalAsiento > totalDebeMN) {
                            item.CAN_DEBE_MN = redondear4(parseFloat(item.CAN_DEBE_MN) + Math.abs(diferencia));
                        } else {
                            item.CAN_DEBE_MN = redondear4(parseFloat(item.CAN_DEBE_MN) - Math.abs(diferencia));
                        }
                        break; // ✅ detener al encontrar el primero
                    }
                }
            }

            document.getElementById("asiento_detalle_compra").value = JSON.stringify(arrayDetalle);

            // recorrer filas y hacer el cambio
            $("#asientodetalle tbody tr").each(function () {
                let fila = $(this);

                let rowIdx = table.row(fila).index();
                let numero_cuenta = table.cell(rowIdx, 1).data();

                let debeMN = parseFloat(table.cell(rowIdx, 3).data().replaceAll(/[\$,]/g, "")) || 0;
                let haberMN = parseFloat(table.cell(rowIdx, 4).data().replaceAll(/[\$,]/g, "")) || 0;

                if (totalAsiento > totalHaberMN || totalAsiento < totalHaberMN) {
                    if (!/^40/.test(numero_cuenta) && haberMN > 0.0000) {
                        let nuevoHaberMN = totalAsiento > totalHaberMN
                            ? haberMN + Math.abs(diferencia)
                            : haberMN - Math.abs(diferencia);

                        table.cell(rowIdx, 4).data(number_format(nuevoHaberMN, 4));
                        table.row(rowIdx).invalidate().draw(false);

                        return false; // ✅ corta el $.each
                    }
                }

                if (totalAsiento > totalDebeMN || totalAsiento < totalDebeMN) {
                    if (!/^40/.test(numero_cuenta) && debeMN > 0.0000) {
                        let nuevoDebeMN = totalAsiento > totalDebeMN
                            ? debeMN + Math.abs(diferencia)
                            : debeMN - Math.abs(diferencia);

                        table.cell(rowIdx, 3).data(number_format(nuevoDebeMN, 4));
                        table.row(rowIdx).invalidate().draw(false);

                        return false; // ✅ corta el $.each
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

        // calcular diferencia
        diferencia = totalDebeME - totalHaberME;

        if (moneda === 'MON0000000000001') {
            totalAsiento = redondear4(totalAsientoOriginal / parseFloat(tc));
        } else {
            totalAsiento = redondear4(totalAsientoOriginal);
        }

        debugger;

        // si la diferencia es menor o igual a 0.1, ajustar
        if (Math.abs(diferencia) > 0 && Math.abs(diferencia) < 0.1) {

            // Recorrerlo
            for (let item of arrayDetalle) {
                if (totalAsiento > totalHaberME || totalAsiento < totalHaberME) {
                    if (!/^40/.test(item.TXT_CUENTA_CONTABLE) && parseFloat(item.CAN_HABER_ME) > 0.0000) {
                        if (totalAsiento > totalHaberME) {
                            item.CAN_HABER_ME = redondear4(parseFloat(item.CAN_HABER_ME) + Math.abs(diferencia));
                        } else {
                            item.CAN_HABER_ME = redondear4(parseFloat(item.CAN_HABER_ME) - Math.abs(diferencia));
                        }
                        break; // ✅ rompe el bucle
                    }
                }

                if (totalAsiento > totalDebeME || totalAsiento < totalDebeME) {
                    if (!/^40/.test(item.TXT_CUENTA_CONTABLE) && parseFloat(item.CAN_DEBE_ME) > 0.0000) {
                        if (totalAsiento > totalDebeME) {
                            item.CAN_DEBE_ME = redondear4(parseFloat(item.CAN_DEBE_ME) + Math.abs(diferencia));
                        } else {
                            item.CAN_DEBE_ME = redondear4(parseFloat(item.CAN_DEBE_ME) - Math.abs(diferencia));
                        }
                        break; // ✅ rompe el bucle
                    }
                }
            }

            document.getElementById("asiento_detalle_compra").value = JSON.stringify(arrayDetalle);

            // recorrer filas y hacer el cambio
            $("#asientodetalle tbody tr").each(function () {
                let fila = $(this);

                let rowIdx = table.row(fila).index();
                let numero_cuenta = table.cell(rowIdx, 1).data();

                let debeME = parseFloat(table.cell(rowIdx, 5).data().replaceAll(/[\$,]/g, "")) || 0;
                let haberME = parseFloat(table.cell(rowIdx, 6).data().replaceAll(/[\$,]/g, "")) || 0;

                if (totalAsiento > totalHaberME || totalAsiento < totalHaberME) {
                    if (!/^40/.test(numero_cuenta) && haberME > 0.0000) {
                        let nuevoHaberME = totalAsiento > totalHaberME
                            ? haberME + Math.abs(diferencia)
                            : haberME - Math.abs(diferencia);

                        table.cell(rowIdx, 6).data(number_format(nuevoHaberME, 4));
                        table.row(rowIdx).invalidate().draw(false);

                        return false; // ✅ rompe el bucle jQuery.each
                    }
                }

                if (totalAsiento > totalDebeME || totalAsiento < totalDebeME) {
                    if (!/^40/.test(numero_cuenta) && debeME > 0.0000) {
                        let nuevoDebeME = totalAsiento > totalDebeME
                            ? debeME + Math.abs(diferencia)
                            : debeME - Math.abs(diferencia);

                        table.cell(rowIdx, 5).data(number_format(nuevoDebeME, 4));
                        table.row(rowIdx).invalidate().draw(false);

                        return false; // ✅ rompe el bucle jQuery.each
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

    $('#tipo_documento_asiento').on('change', function () {
        switch ($(this).val()) {
            case "TDO0000000000002":
            case "TDO0000000000066":
            case "TDO0000000000010":
                window.selects['tipo_asiento'].setSelected('TAS0000000000007');
                $('#tipo_asiento').trigger('change').prop('disabled', true);
                break;
            default:
                window.selects['tipo_asiento'].setSelected('TAS0000000000004');
                $('#tipo_asiento').trigger('change').prop('disabled', false);
                break;
        }
    });

    $("#tipo_cambio_asiento").on('change', function (e) {

        let moneda = $('#moneda_asiento').val();
        let tc = $('#tipo_cambio_asiento').val();
        tc.replaceAll(/[\$,]/g, "");
        let arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);

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
        let table = $('#asientodetalle').DataTable();

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

    });

    $(".btn-regresar-lista").on('click', function (e) {
        $('.tablageneral').toggle("slow");
        $('.editarcuentas').toggle("slow");
        setTimeout(function () {
            $('#asientodetalle').DataTable().columns.adjust().draw();
        }, 3000); // espera medio segundo o el tiempo necesario
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

    $(".btn-guardar_asiento").on('click', function () {

        let arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);
        let arrayCabecera = JSON.parse(document.getElementById("asiento_cabecera_compra").value);

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
            }
        });

        arrayCabecera.forEach(item => {
            item.COD_CATEGORIA_MONEDA = moneda_id_editar;
            item.CAN_TIPO_CAMBIO = Number(tc_editar.replace(/,/g, "")) || 0;
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
            item.CODIGO_CONTABLE = comprobante_asiento.split("-")[1];
            item.TOTAL_BASE_IMPONIBLE = base_imponible;
            item.TOTAL_BASE_IMPONIBLE_10 = base_imponible_10;
            item.TOTAL_BASE_INAFECTA = base_inafecto;
            item.TOTAL_BASE_EXONERADA = base_exonerado;
            item.TOTAL_IGV = total_igv;
            item.TOTAL_AFECTO_IVAP = base_ivap;
            item.TOTAL_IVAP = total_ivap;
        });

        $('#tblactivos tbody tr').each(function () {
            if ($(this).hasClass('activofl')) {
                // Cambiar estilo o atributo de las celdas de esta fila
                $(this).attr('data_asiento_cabecera', JSON.stringify(arrayCabecera));
                $(this).attr('data_asiento_detalle', JSON.stringify(arrayDetalle));
            }
        });

        $('#listone').addClass('active');
        $('#listtwo').removeClass('active');
        $('#listtree').removeClass('active');
        $('#astcabgeneral').addClass('active');
        $('#astcabcomplementario').removeClass('active');
        $('#astdetgeneral').removeClass('active');

        $('.pnlasientos').hide();
        $('.pnldetallesdocumentos').focus();
    })

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
                let table = $('#asientodetalle').DataTable();

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

    //nuevo

    $(".cfedocumento").on('click', '.buscartareas', function () {

        var _token = $('#token').val();
        var idopcion = $('#idopcion').val();

        data = {
            _token: _token,
            idopcion: idopcion
        };

        ajax_modal(data, "/ajax-modal-buscar-factura-sunat-tareas",
            "modal-detalle-requerimiento", "modal-detalle-requerimiento-container");

    });


    $(".liquidaciongasto").on('click', '.ver_cuenta_bancaria', function () {

        var _token = $('#token').val();
        var ID_DOCUMENTO = $('#ID_DOCUMENTO').val();
        var idopcion = $('#idopcion').val();
        data = {
            _token: _token,
            ID_DOCUMENTO: ID_DOCUMENTO,
        };

        ajax_modal(data, "/ajax-modal-ver-cuenta-bancaria-lq",
            "modal-configuracion-usuario-detalle", "modal-configuracion-usuario-detalle-container");

    });


    $(".liquidaciongasto").on('change', '#tipopago_id', function () {

        var _token = $('#token').val();
        var tipopago_id = $(this).val();
        var ID_DOCUMENTO = $('#ID_DOCUMENTO').val();
        $('.detallecuenta').hide();
        if (tipopago_id == 'MPC0000000000002') {

            $('.detallecuenta').show();
        }

    });


    $(".liquidaciongasto").on('change', '.entidadbanco', function () {


        var _token = $('#token').val();
        var entidadbanco_id = $(this).val();
        var ID_DOCUMENTO = $('#ID_DOCUMENTO').val();

        $.ajax({
            type: "POST",
            url: carpeta + "/ajax-cuenta-bancaria-proveedor-lq",
            data: {
                _token: _token,
                entidadbanco_id: entidadbanco_id,
                ID_DOCUMENTO: ID_DOCUMENTO
            },
            success: function (data) {
                $('.ajax_cb').html(data);
            },
            error: function (data) {
                error500(data);
            }
        });
    });

    $(".liquidaciongasto").on('click', '.agregar_cuenta_bancaria', function () {

        var _token = $('#token').val();
        var idopcion = $('#idopcion').val();
        var ID_DOCUMENTO = $('#ID_DOCUMENTO').val();

        data = {
            _token: _token,
            ID_DOCUMENTO: ID_DOCUMENTO,
            idopcion: idopcion,

        };

        ajax_modal(data, "/ajax-modal-configuracion-cuenta-bancaria-lq",
            "modal-configuracion-usuario-detalle", "modal-configuracion-usuario-detalle-container");

    });


    $(".liquidaciongasto").on('click', '#descargarcomprobantemasivoexcel', function () {

        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var proveedor_id = $('#proveedor_id').val();
        var estado_id = $('#estado_id').val();
        var idopcion = $('#idopcion').val();
        var _token = $('#token').val();

        //validacioones
        if (fecha_inicio == '') {
            alerterrorajax("Seleccione una fecha inicio.");
            return false;
        }
        if (fecha_fin == '') {
            alerterrorajax("Seleccione una fecha fin.");
            return false;
        }

        href = $(this).attr('data-href') + '/' + fecha_inicio + '/' + fecha_fin + '/' + proveedor_id + '/' + estado_id + '/' + idopcion;
        $(this).prop('href', href);
        return true;


    });


    $(".liquidaciongasto").on('change', '#moneda_sel_c_id', function (e) {

        var _token = $('#token').val();
        var empresa_id = $('#empresa_id').val();
        var moneda_sel_id = $('#moneda_sel_c_id').val();
        var link = "/ajax-combo-cuenta-xmoneda";
        var contenedor = "ajax_combo_cuenta_moneda";
        debugger;

        data = {
            _token: _token,
            empresa_id: empresa_id,
            moneda_sel_id: moneda_sel_id
        };

        ajax_normal_combo(data, link, contenedor);

    });


    $(".liquidaciongasto").on('click', '.btn-guardar-whatsapp', function () {

        var _token = $('#token').val();
        var whatsapp = $('#whatsapp').val();
        if (!/^\d{9}$/.test(whatsapp)) {
            alerterrorajax("El número de WhatsApp debe tener exactamente 9 dígitos");
            return false;
        }
        const link = '/guardar-numero-de-whatsapp';

        data = {
            _token: _token,
            whatsapp: whatsapp
        };
        abrircargando();
        $.ajax({
            type: "POST",
            url: carpeta + link,
            data: data,
            success: function (data) {
                cerrarcargando();
                alertajax('Se registro su whatsapp.');

            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });

    });


    $(".liquidaciongasto").on('click', '.btncargarsunat', function (e) {
        e.preventDefault(); // Prevenir recarga del formulario

        var RUTAXML = $('#RUTAXML').val();
        var RUTAPDF = $('#RUTAPDF').val();
        var RUTACDR = $('#RUTACDR').val();
        var exml = $('.exml').html();
        var epdf = $('.epdf').html();
        var ecdr = $('.ecdr').html();

        var _token = $('#token').val();
        var ID_DOCUMENTO = $('#ID_DOCUMENTO').val();
        if (RUTAXML == '') {
            alerterrorajax("No existe XML para Cargar.");
            return false;
        }

        data = {
            _token: _token,
            ID_DOCUMENTO: ID_DOCUMENTO,
            RUTAXML: RUTAXML,
            RUTAPDF: RUTAPDF,
            RUTACDR: RUTACDR,
            exml: exml,
            epdf: epdf,
            ecdr: ecdr,

        };

        const link = '/ajax-leer-xml-lg-sunat';
        abrircargando();
        $.ajax({
            type: "POST",
            url: carpeta + link,
            data: data,
            success: function (data) {
                cerrarcargando();
                debugger;
                if (data.error == 0) {
                    $('#serie').val(data.SERIE);
                    $('#numero').val(data.NUMERO);
                    $('#fecha_emision').val(data.FEC_VENTA);
                    $('#totaldetalle').val(data.TOTAL_VENTA_ORIG);

                    $('.MESSAGE').html(data.MESSAGE);
                    $('.NESTADOCP').html(data.NESTADOCP);
                    $('.NESTADORUC').html(data.NESTADORUC);
                    $('.NCONDDOMIRUC').html(data.NCONDDOMIRUC);

                    $('#SUCCESS').val(data.SUCCESS);
                    $('#MESSAGE').val(data.MESSAGE);
                    $('#ESTADOCP').val(data.ESTADOCP);
                    $('#NESTADOCP').val(data.NESTADOCP);
                    $('#ESTADORUC').val(data.ESTADORUC);
                    $('#NESTADORUC').val(data.NESTADORUC);
                    $('#CONDDOMIRUC').val(data.CONDDOMIRUC);
                    $('#NCONDDOMIRUC').val(data.NCONDDOMIRUC);
                    $('#NOMBREFILE').val(data.NOMBREFILE);
                    $('#RUTACOMPLETA').val(data.RUTACOMPLETA);
                    $('#empresa_id').append(
                        $('<option>', {
                            value: data.TXT_EMPRESA,
                            text: data.TXT_EMPRESA
                        })
                    ).val(data.TXT_EMPRESA);
                    $('#empresa_id').val(data.TXT_EMPRESA).trigger('change');
                    $('#EMPRESAID').val(data.TXT_EMPRESA);
                    //archivos
                    $('.sectorxmlmodal').show();
                    $('.DCC0000000000036').hide();
                    $('.DCC0000000000004').hide();

                    let valor = data.SERIE;
                    let primeraLetraSerire = valor.charAt(0);
                    if (primeraLetraSerire == 'E') {
                        if (data.RUTAPDF) {
                            $('.DCC0000000000036').hide();
                        } else {
                            $('.DCC0000000000036').show();
                        }
                    } else {

                        if (data.RUTAPDF) {
                            $('.DCC0000000000036').hide();
                        } else {
                            $('.DCC0000000000036').show();
                        }
                        if (data.RUTACDR) {
                            $('.DCC0000000000004').hide();
                        } else {
                            $('.DCC0000000000004').show();
                        }
                    }


                    //DETALLE DEL PRODUCTO

                    $('#tdxml tbody').empty(); // Limpia la tabla primero
                    data.DETALLE.forEach(function (item, index) {
                        const fila = `
                          <tr>
                            <td class="cell-detail d${index}" style="position: relative;" >
                              <span style="display: block;"><b>PRODUCTO OSIRIS : </b> <dlabel class='TXT_PRODUCTO_OSIRIS'></dlabel></span>
                              <span style="display: block;"><b>PRODUCTO XML : </b> <dlabel class='TXT_PRODUCTO_XML'>${item.PRODUCTO}</dlabel></span>
                              <span style="display: block;"><b>CANTIDAD : </b> <dlabel class='CANTIDAD'>${item.CANTIDAD}</dlabel></span>
                              <span style="display: block;"><b>PRECIO : </b> <dlabel class='PRECIO'>${item.PRECIO_UNIT}</dlabel></span>
                              <span style="display: block;"><b>IND IGV : </b> <dlabel class='INDIGV'>${item.VAL_IGV_ORIG}</dlabel></span>
                              <span style="display: block;"><b>SUBTOTAL : </b> <dlabel class='SUBTOTAL'>${item.VAL_SUBTOTAL_SOL}</dlabel></span>
                              <span style="display: block;"><b>IGV : </b> <dlabel class='IGV'>${item.VAL_IGV_SOL}</dlabel></span>
                              <span style="display: block;"><b>TOTAL : </b> <dlabel class='TOTAL'>${item.VAL_VENTA_SOL}</dlabel></span>
                              <button type="button" data_item="${index}" data_producto="${item.PRODUCTO}" style="margin-top: 5px; float: right;" class="btn btn-rounded btn-space btn-success btn-sm relacionardetalledocumentolg">RELACIONAR PRODUCTO</button>
                            </td>
                          </tr>
                        `;
                        $('#tdxml tbody').append(fila);
                    });


                } else {
                    alerterrorajax(data.mensaje);
                }
                console.log(data);
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });


    });

    $(".cfedocumento").on('click', '.btn-extonar-lg', function (e) {
        event.preventDefault();
        var _token = $('#token').val();
        $.confirm({
            title: '¿Confirma el extorno?',
            content: 'Extorno de Liquidacion de Gastos',
            buttons: {
                confirmar: function () {
                    $("#forextornar").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo el extorno');
                    window.location.reload();
                }
            }
        });
    });

    $(".liquidaciongasto").on('click', '.btn-extonar-detalle-lg', function (e) {
        event.preventDefault();
        var _token = $('#token').val();
        var data_item = $(this).attr('data_item');

        $.confirm({
            title: '¿Confirma el extorno?',
            content: 'Extorno de Detalle Liquidacion de Gastos',
            buttons: {
                confirmar: function () {
                    $("#forextornardetallelq" + data_item).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo el extorno');
                    window.location.reload();
                }
            }
        });
    });


    $(".liquidaciongasto").on('click', '.btn_tarea_cpe_lg', function () {

        var _token = $('#token').val();
        var ID_DOCUMENTO = $('#ID_DOCUMENTO').val();
        var idopcion = $('#idopcion').val();
        var ruc = $('#ruc_sunat').val();
        var td = $('#td').val();
        var serie = $('#serie_sunat').val();
        var correlativo = $('#correlativo_sunat').val();
        if (ruc == '') {
            alerterrorajax("Ingrese un ruc.");
            return false;
        }
        if (td == '') {
            alerterrorajax("Seleccione un tipo de documento.");
            return false;
        }
        if (serie == '') {
            alerterrorajax("Ingrese un serie.");
            return false;
        }
        if (correlativo == '') {
            alerterrorajax("Ingrese un correlativo.");
            return false;
        }

        data = {
            _token: _token,
            ID_DOCUMENTO: ID_DOCUMENTO,
            ruc: ruc,
            td: td,
            serie: serie,
            correlativo: correlativo,
            idopcion: idopcion
        };
        abrircargando();
        $('a[href="#tareas"]').click();
        ajax_normal(data, "/tareas-de-cpe-sunat-lg");

    });


    $(".liquidaciongasto").on('click', '.mdicloselq', function () {

        var _token = $('#token').val();
        const data_id = $(this).attr('data_id');
        const data_ruc = $(this).attr('data_ruc');
        const data_td = $(this).attr('data_td');
        const data_serie = $(this).attr('data_serie');
        const data_numero = $(this).attr('data_numero');
        var idopcion = $('#idopcion').val();
        const link = '/eliminar-de-cpe-sunat-lg-personal';

        data = {
            _token: _token,
            data_id: data_id,
            data_ruc: data_ruc,
            data_td: data_td,
            data_serie: data_serie,
            data_numero: data_numero,
            idopcion: idopcion
        };

        $.confirm({
            title: '¿Confirma la Eliminacion?',
            content: 'Eliminacion del Comprobante',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    $.ajax({
                        type: "POST",
                        url: carpeta + link,
                        data: data,
                        success: function (data) {
                            cerrarcargando();
                            location.reload();
                        },
                        error: function (data) {
                            cerrarcargando();
                            error500(data);
                        }
                    });

                },
                cancelar: function () {
                    $.alert('Se cancelo la Eliminacion');
                }
            }
        });


    });

    $(".liquidaciongasto").on('click', '.traerpdf', function () {


        var _token = $('#token').val();
        var idopcion = $('#idopcion').val();

        var serie = $('#serie').val();
        var numero = $('#numero').val();
        var empresa_id = $('#empresa_id').val();
        var ID_DOCUMENTO = $('#ID_DOCUMENTO').val();
        var SUCCESS = $('#SUCCESS').val();


        if (SUCCESS == '') {
            alerterrorajax("Valide el documento");
            return false;
        }

        const link = '/pdf-sunat-personal';
        data = {
            _token: _token,
            serie: serie,
            numero: numero,
            empresa_id: empresa_id,
            ID_DOCUMENTO: ID_DOCUMENTO,
            idopcion: idopcion
        };
        abrircargando();
        $.ajax({
            type: "POST",
            url: carpeta + link,
            data: data,
            success: function (data) {
                cerrarcargando();
                debugger;

                if (data.cod_error == 0) {
                    $('.DCC0000000000036').hide();
                    $('.PDFSUNAT').html("PDF ENCONTRADO EN SUNAT");
                    $('#RUTACOMPLETAPDF').val(data.ruta_completa);
                    $('#NOMBREPDF').val(data.nombre_archivo);

                } else {
                    alerterrorajax(data.mensaje);
                    $('.PDFSUNAT').html("");
                    $('.DCC0000000000036').show();
                }

                console.log(data);
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });


    });


    $(".liquidaciongasto").on('click', '.mdisellq', function () {

        var _token = $('#token').val();
        const data_id = $(this).attr('data_id');
        const data_ruc = $(this).attr('data_ruc');
        const data_td = $(this).attr('data_td');
        const data_serie = $(this).attr('data_serie');
        const data_numero = $(this).attr('data_numero');
        var idopcion = $('#idopcion').val();
        const link = '/buscar-de-cpe-sunat-lg-personal';

        debugger;
        data = {
            _token: _token,
            data_id: data_id,
            data_ruc: data_ruc,
            data_td: data_td,
            data_serie: data_serie,
            data_numero: data_numero,
            idopcion: idopcion
        };
        abrircargando();
        $.ajax({
            type: "POST",
            url: carpeta + link,
            data: data,
            success: function (data) {
                cerrarcargando();
                debugger;
                $('#modal-detalle-requerimiento').niftyModal('hide');
                if (data.nombre_xml) {
                    $('.exml').html(data.nombre_xml);
                    $('#NOMBREXML').val(data.nombre_xml);
                    $('#RUTAXML').val(data.ruta_xml);
                }
                if (data.nombre_pdf) {
                    $('.epdf').html(data.nombre_pdf);
                    $('#NOMBREPDF').val(data.nombre_pdf);
                    $('#RUTAPDF').val(data.ruta_pdf);
                }
                if (data.nombre_cdr) {
                    $('.ecdr').html(data.nombre_cdr);
                    $('#NOMBRECDR').val(data.nombre_cdr);
                    $('#RUTACDR').val(data.ruta_cdr);
                }
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });

    });


    $(".liquidaciongasto").on('click', '.btn_buscar_cpe_lg', function () {

        var _token = $('#token').val();
        var ID_DOCUMENTO = $('#ID_DOCUMENTO').val();
        var idopcion = $('#idopcion').val();

        var ruc = $('#ruc_sunat').val();
        var td = $('#td').val();
        var serie = $('#serie_sunat').val();
        var correlativo = $('#correlativo_sunat').val();
        const link = '/buscar-de-cpe-sunat-lg';
        serie = serie.toUpperCase();

        if (ruc == '') {
            alerterrorajax("Ingrese un ruc.");
            return false;
        }
        if (td == '') {
            alerterrorajax("Seleccione un tipo de documento.");
            return false;
        }
        if (serie == '') {
            alerterrorajax("Ingrese un serie.");
            return false;
        }
        if (correlativo == '') {
            alerterrorajax("Ingrese un correlativo.");
            return false;
        }

        data = {
            _token: _token,
            ID_DOCUMENTO: ID_DOCUMENTO,
            ruc: ruc,
            td: td,
            serie: serie,
            correlativo: correlativo,
            idopcion: idopcion
        };
        abrircargando();
        $.ajax({
            type: "POST",
            url: carpeta + link,
            data: data,
            success: function (data) {
                cerrarcargando();
                debugger;
                var sw = 0;


                if (data.nombre_xml) {
                    $('.exml').html(data.nombre_xml);
                    $('#NOMBREXML').val(data.nombre_xml);
                    $('#RUTAXML').val(data.ruta_xml);
                    sw = sw + 1;
                }
                if (data.nombre_pdf) {
                    $('.epdf').html(data.nombre_pdf);
                    $('#NOMBREPDF').val(data.nombre_pdf);
                    $('#RUTAPDF').val(data.ruta_pdf);
                    sw = sw + 1;
                }
                if (data.nombre_cdr) {
                    $('.ecdr').html(data.nombre_cdr);
                    $('#NOMBRECDR').val(data.nombre_cdr);
                    $('#RUTACDR').val(data.ruta_cdr);
                    sw = sw + 1;
                }

                if (!serie.startsWith('F')) {
                    if (sw == 2) {
                        $('#modal-detalle-requerimiento').niftyModal('hide');
                    }
                } else {
                    if (sw == 3) {
                        $('#modal-detalle-requerimiento').niftyModal('hide');
                    }
                }

            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });

    });


    $(".liquidaciongasto").on('click', '.btnsunat', function () {

        var _token = $('#token').val();
        var ID_DOCUMENTO = $('#ID_DOCUMENTO').val();
        var idopcion = $('#idopcion').val();

        data = {
            _token: _token,
            ID_DOCUMENTO: ID_DOCUMENTO,
            idopcion: idopcion
        };

        ajax_modal(data, "/ajax-modal-buscar-factura-sunat",
            "modal-detalle-requerimiento", "modal-detalle-requerimiento-container");

    });


    $(".liquidaciongasto").on('click', '.mdisel', function (e) {

        var _token = $('#token').val();
        var idopcion = $('#idopcion').val();
        const documento_planilla = $(this).attr('data_documento_planilla'); // Obtener el id del checkbox
        var data_iddocumento = $('#ID_DOCUMENTO').val();

        const link = '/ajax-select-documento-planilla';
        debugger;
        data = {
            _token: _token,
            documento_planilla: documento_planilla,
            data_iddocumento: data_iddocumento
        };
        abrircargando();
        $.ajax({
            type: "POST",
            url: carpeta + link,
            data: data,
            success: function (data) {
                cerrarcargando();

                debugger;
                $('#modal-detalle-requerimiento').niftyModal('hide');

                $('#serie').val(data.SERIE);
                $('#numero').val(data.NUMERO);
                $('#fecha_emision').val(data.FECHA_EMI);
                $('#totaldetalle').val(data.TOTAL);
                $('#empresa_id').append(
                    $('<option>', {
                        value: data.EMPRESA,
                        text: data.EMPRESA
                    })
                ).val(data.EMPRESA);
                $('#cuenta_id').append(
                    $('<option>', {
                        value: data.COD_CUENTA,
                        text: data.TXT_CUENTA
                    })
                ).val(data.COD_CUENTA);
                $('#subcuenta_id').append(
                    $('<option>', {
                        value: data.COD_SUBCUENTA,
                        text: data.TXT_SUBCUENTA
                    })
                ).val(data.COD_SUBCUENTA);

                $('#cod_planila').val(data.COD_PLANILLA);
                $('#rutacompleta').val(data.rutacompleta);
                $('#nombrearchivo').val(data.nombrearchivo);
                $('#glosadet').val(data.glosa);

            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });

    });


    $(".cfedocumento").on('click', '.buscardocumento', function () {

        event.preventDefault();

        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var idopcion = $('#idopcion').val();
        var _token = $('#token').val();

        //validacioones
        if (fecha_inicio == '') {
            alerterrorajax("Seleccione una fecha inicio.");
            return false;
        }
        if (fecha_fin == '') {
            alerterrorajax("Seleccione una fecha fin.");
            return false;
        }

        data = {
            _token: _token,
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin,
            idopcion: idopcion
        };
        ajax_normal(data, "/ajax-buscar-documento-uc-lg");

    });


    $(".liquidaciongasto").on('click', '.buscardocumento', function () {

        event.preventDefault();

        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var proveedor_id = $('#proveedor_id').val();
        var estado_id = $('#estado_id').val();
        var idopcion = $('#idopcion').val();
        var _token = $('#token').val();

        //validacioones
        if (fecha_inicio == '') {
            alerterrorajax("Seleccione una fecha inicio.");
            return false;
        }
        if (fecha_fin == '') {
            alerterrorajax("Seleccione una fecha fin.");
            return false;
        }

        data = {
            _token: _token,
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin,
            proveedor_id: proveedor_id,
            estado_id: estado_id,
            idopcion: idopcion
        };
        ajax_normal(data, "/ajax-buscar-documento-lg");

    });


    $(".liquidaciongasto").on('click', '.filalg', function (e) {
        event.preventDefault();
        debugger;
        abrircargando();
        $('.dtlg').hide();
        $('.file-preview-frame').hide();
        $('.filalg').removeClass("ocultar");
        const data_valor = $(this).attr('data_valor');
        $('.' + data_valor).show();
        $('.filalg').removeClass("activofl");
        $(this).addClass("activofl");
        let data_valor_id = $(this).attr('data_valor_id');

        let data_asiento_cabecera = $(this).attr('data_asiento_cabecera');
        let data_asiento_detalle = $(this).attr('data_asiento_detalle');

        let totallg = $(this).find('td').eq(6).text().trim();
        $('#total_xml').val(totallg);

        if (data_valor_id === '1') {
            $('#asiento_cabecera_compra').val(data_asiento_cabecera);
            $('#asiento_detalle_compra').val(data_asiento_detalle);

            let arrayCabecera = JSON.parse(document.getElementById("asiento_cabecera_compra").value);
            let arrayDetalle = JSON.parse(document.getElementById("asiento_detalle_compra").value);

            // Crear la fila con atributos y estilos
            let nuevaFila = ``;

            let asiento_id_editar = '';
            let fecha_asiento = new Date();
            let periodo_asiento = '';
            let form_id_editar = 'C';
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
                total_des = item.CAN_TOTAL_DESCUENTO;
                comprobante_asiento = item.TXT_REFERENCIA + '-' + item.CODIGO_CONTABLE;
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

            //$('#anio_asiento').val(anio.toString()).trigger('change');

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

            $('#comprobante_asiento').val(comprobante_asiento);
            $('#tipo_cambio_asiento').val(tc_editar);

            /*
            $('#comprobante_asiento').val(comprobante_asiento);
            $('#moneda_asiento').val(moneda_id_editar).trigger('change');
            $('#tipo_cambio_asiento').val(tc_editar);
            $('#empresa_asiento').val(proveedor_asiento).trigger('change');
            $('#tipo_asiento').val(tipo_asiento).trigger('change');
            */
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
        }

        cerrarcargando();

    });

    $('.btnobservarcomporbatnte').on('click', function (event) {
        event.preventDefault();

        var array_item = dataobservacion();
        const filas = document.querySelectorAll('.tablaobservacion tbody tr');
        // El número de filas:
        const cantidad = filas.length;
        debugger;
        if (array_item.length <= 0) {
            alerterrorajax('Seleccione por lo menos una fila');
            return false;
        }
        if (array_item.length == cantidad) {
            alerterrorajax('No se puede observar todas las filas en ese caso deberia extornarlo');
            return false;
        }
        datastring = JSON.stringify(array_item);
        $('#data_observacion').val(datastring);
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

    function dataobservacion() {
        var data = [];
        $(".tablaobservacion tbody tr").each(function () {
            nombre = $(this).find('.input_asignar').attr('id');
            if (nombre != 'todo_asignar') {
                check = $(this).find('.input_asignar');
                data_id = $(this).attr('data_id');
                data_item = $(this).attr('data_item')
                if ($(check).is(':checked')) {
                    data.push({
                        data_id: data_id,
                        data_item: data_item
                    });
                }
            }
        });
        return data;
    }


    $('.btnaprobarcomporbatnteconta').on('click', function (event) {
        event.preventDefault();
        abrircargando();
        let url = $(this).data('url');

        let detalles = [];
        $('#tblactivos tbody tr').each(function () {
            let data_valor_id = $(this).attr('data_valor_id');
            if (data_valor_id === '1') {
                detalles.push({
                    cabecera: $(this).attr('data_asiento_cabecera'),
                    detalle: $(this).attr('data_asiento_detalle'),
                });
            }
        });

        let descripcion = $('#descripcion').val();
        let token = $('#token').val();

        $.confirm({
            title: '¿Confirma la Aprobacion?',
            content: 'Aprobar el Comprobante',
            buttons: {
                confirmar: function () {
                    //$("#formpedido").submit();
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {_token: token, detalles: detalles, descripcion: descripcion},
                        success: function (res) {
                            if (res.status === "success") {
                                $.alert({
                                    title: 'Bien Hecho',
                                    content: res.mensaje,
                                    type: 'green',
                                    buttons: {
                                        ok: {
                                            text: 'OK',
                                            btnClass: 'btn-green',
                                            action: function () {
                                                // Recarga o redirige inmediatamente al dar OK
                                                window.location.href = res.redirect;
                                            }
                                        }
                                    }
                                });
                            } else {
                                $.alert({
                                    title: 'Error',
                                    content: res.mensaje,
                                    type: 'red',
                                    buttons: {
                                        ok: {
                                            text: 'OK',
                                            btnClass: 'btn-red',
                                            action: function () {
                                                // Recarga o redirige inmediatamente al dar OK
                                                window.location.href = res.redirect;
                                            }
                                        }
                                    }
                                });
                            }
                            // Redirigir automáticamente después de 5 minutos
                            setTimeout(function () {
                                window.location.href = res.redirect;
                            }, 300000);
                        },
                        error: function (res) {
                            console.log(res);
                            error500(res);
                        }
                    });

                },
                cancelar: function () {
                    $.alert('Se cancelo Aprobacion');
                }
            }
        });

    });

    $('.btnaprobarcomporbatnte').on('click', function (event) {
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Aprobacion?',
            content: 'Aprueba el Comprobante',
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


    $(".liquidaciongasto").on('change', '#arendir_id', function (e) {
        var arendir_id = $('#arendir_id').val();
        if (arendir_id == 'SI') {
            $('.sectorarendir').show();

        } else {
            $('.sectorarendir').hide();
        }
    });


    $(".liquidaciongasto").on('change', '#arendir_sel_id', function (e) {

        var arendir_sel_id = $('#arendir_sel_id').val();
        var idopcion = $('#idopcion').val();
        var _token = $('#token').val();
        var link = "/ajax-combo-autoriza";
        var contenedor = "ajax_combo_autoriza";
        data = {
            _token: _token,
            arendir_sel_id: arendir_sel_id,
            idopcion: idopcion
        };
        ajax_normal_combo(data, link, contenedor);


    });


    $(".liquidaciongasto").on('change', '#tipodoc_id', function (e) {

        var tipodoc_id = $('#tipodoc_id').val();
        $('#serie, #numero, #fecha_emision, #totaldetalle,#cod_planila').val('');
        $('#empresa_id').empty();
        $('#cuenta_id').empty();
        $('#subcuenta_id').empty();

        $('.DCC0000000000036').hide();
        $('.DCC0000000000004').hide();
        $('#totaldetalle').prop('readonly', true);

        limpiarxml();


        if (tipodoc_id == 'TDO0000000000070') {
            $('#serie, #numero, #fecha_emision').prop('readonly', true);
            $('#empresa_id').prop('disabled', true);
            $('#cuenta_id').prop('disabled', true);
            $('#subcuenta_id').prop('disabled', true);
            $('.sectorplanilla').show();
            $('.sectorxml').hide();

            //$('.sectorxmlmodal').show();
            //$('.DCC0000000000036').show();

        } else {
            if (tipodoc_id == 'TDO0000000000001') {

                //$('#serie, #numero, #fecha_emision').prop('readonly', true);
                $('#empresa_id').prop('disabled', false);
                $('.sectorplanilla').hide();
                $('#totaldetalle').prop('readonly', false);
                $('.sectorxml').show();
                $('.sectorxmlmodal').show();
                $('.DCC0000000000036').show();

            } else {
                $('#serie, #numero, #fecha_emision').prop('readonly', false);
                $('#empresa_id').prop('disabled', false);
                $('#cuenta_id').prop('disabled', false);
                $('#subcuenta_id').prop('disabled', false);
                $('.sectorplanilla').hide();
                $('.sectorxml').hide();
                $('.sectorxmlmodal').show();
                $('.DCC0000000000036').show();
            }
        }

        $('#SUCCESS').val('');
        $('#MESSAGE').val('');
        $('#ESTADOCP').val('');
        $('#NESTADOCP').val('');
        $('#ESTADORUC').val('');
        $('#NESTADORUC').val('');
        $('#CONDDOMIRUC').val('');
        $('#NCONDDOMIRUC').val('');
        $('#NOMBREFILE').val('');

        $('.MESSAGE').html('');
        $('.NESTADOCP').html('');
        $('.NESTADORUC').html('');
        $('.NCONDDOMIRUC').html('');

    });


    $(".liquidaciongasto").on('click', '.cargardatosliq', function (e) {
        e.preventDefault(); // Prevenir recarga del formulario
        const archivo = $('#inputxml')[0].files[0];
        var _token = $('#token').val();
        var ID_DOCUMENTO = $('#ID_DOCUMENTO').val();

        if (!archivo) {
            alert('Por favor selecciona un archivo XML.');
            return;
        }
        let formData = new FormData();
        formData.append('inputxml', archivo);
        formData.append('_token', _token);
        formData.append('ID_DOCUMENTO', ID_DOCUMENTO);

        const link = '/ajax-leer-xml-lg';
        abrircargando();
        $.ajax({
            type: "POST",
            url: carpeta + link,
            data: formData,
            processData: false, // IMPORTANTE: no procesar los datos
            contentType: false, // IMPORTANTE: no establecer content-type (jQuery lo hace)
            success: function (data) {
                cerrarcargando();
                debugger;
                if (data.error == 0) {

                    $('#RUTAXML').val("");
                    $('#RUTAPDF').val("");
                    $('#RUTACDR').val("");
                    $('.exml').html("");
                    $('.epdf').html("");
                    $('.ecdr').html("");
                    $('#NOMBREXML').val("");
                    $('#NOMBREPDF').val("");
                    $('#NOMBRECDR').val("");


                    $('#serie').val(data.SERIE);
                    $('#numero').val(data.NUMERO);
                    $('#fecha_emision').val(data.FEC_VENTA);
                    $('#totaldetalle').val(data.TOTAL_VENTA_ORIG);

                    $('.MESSAGE').html(data.MESSAGE);
                    $('.NESTADOCP').html(data.NESTADOCP);
                    $('.NESTADORUC').html(data.NESTADORUC);
                    $('.NCONDDOMIRUC').html(data.NCONDDOMIRUC);

                    $('#SUCCESS').val(data.SUCCESS);
                    $('#MESSAGE').val(data.MESSAGE);
                    $('#ESTADOCP').val(data.ESTADOCP);
                    $('#NESTADOCP').val(data.NESTADOCP);
                    $('#ESTADORUC').val(data.ESTADORUC);
                    $('#NESTADORUC').val(data.NESTADORUC);
                    $('#CONDDOMIRUC').val(data.CONDDOMIRUC);
                    $('#NCONDDOMIRUC').val(data.NCONDDOMIRUC);
                    $('#NOMBREFILE').val(data.NOMBREFILE);
                    $('#RUTACOMPLETA').val(data.RUTACOMPLETA);
                    $('#empresa_id').append(
                        $('<option>', {
                            value: data.TXT_EMPRESA,
                            text: data.TXT_EMPRESA
                        })
                    ).val(data.TXT_EMPRESA);
                    $('#empresa_id').val(data.TXT_EMPRESA).trigger('change');
                    $('#EMPRESAID').val(data.TXT_EMPRESA);
                    //archivos
                    $('.sectorxmlmodal').show();
                    $('.DCC0000000000036').hide();
                    $('.DCC0000000000004').hide();

                    let valor = data.SERIE;
                    let primeraLetraSerire = valor.charAt(0);
                    if (primeraLetraSerire == 'E') {
                        $('.DCC0000000000036').show();
                    } else {
                        $('.DCC0000000000036').show();
                        $('.DCC0000000000004').show();
                    }


                    //DETALLE DEL PRODUCTO

                    $('#tdxml tbody').empty(); // Limpia la tabla primero
                    data.DETALLE.forEach(function (item, index) {
                        const fila = `
                          <tr>
                            <td class="cell-detail d${index}" style="position: relative;" >
                              <span style="display: block;"><b>PRODUCTO OSIRIS : </b> <dlabel class='TXT_PRODUCTO_OSIRIS'></dlabel></span>
                              <span style="display: block;"><b>PRODUCTO XML : </b> <dlabel class='TXT_PRODUCTO_XML'>${item.PRODUCTO}</dlabel></span>
                              <span style="display: block;"><b>CANTIDAD : </b> <dlabel class='CANTIDAD'>${item.CANTIDAD}</dlabel></span>
                              <span style="display: block;"><b>PRECIO : </b> <dlabel class='PRECIO'>${item.PRECIO_UNIT}</dlabel></span>
                              <span style="display: block;"><b>IND IGV : </b> <dlabel class='INDIGV'>${item.VAL_IGV_ORIG}</dlabel></span>
                              <span style="display: block;"><b>SUBTOTAL : </b> <dlabel class='SUBTOTAL'>${item.VAL_SUBTOTAL_SOL}</dlabel></span>
                              <span style="display: block;"><b>IGV : </b> <dlabel class='IGV'>${item.VAL_IGV_SOL}</dlabel></span>
                              <span style="display: block;"><b>TOTAL : </b> <dlabel class='TOTAL'>${item.VAL_VENTA_SOL}</dlabel></span>
                              <button type="button" data_item="${index}" data_producto="${item.PRODUCTO}" style="margin-top: 5px; float: right;" class="btn btn-rounded btn-space btn-success btn-sm relacionardetalledocumentolg">RELACIONAR PRODUCTO</button>
                            </td>
                          </tr>
                        `;
                        $('#tdxml tbody').append(fila);
                    });


                } else {
                    alerterrorajax(data.mensaje);
                }
                console.log(data);
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });


    });

    $(".liquidaciongasto").on('click', '.limpiarxml', function (e) {
        limpiarxml();
    });


    function limpiarxml() {
        $('#serie, #numero, #totaldetalle, #fecha_emision').prop('readonly', false);
        $('#fecha_emision').css('pointer-events', 'auto').datetimepicker('enable');
        $('.input-group-addon').css({'pointer-events': 'auto', 'cursor': 'pointer'});
        $('#empresa_id').prop({
            'readonly': false,
            'disabled': false  // Asegurar que no esté deshabilitado
        }).next('.select2-container').css('pointer-events', 'auto');

        $('.MESSAGE').html("");
        $('.NESTADOCP').html("");
        $('.NESTADORUC').html("");
        $('.NCONDDOMIRUC').html("");
        $('#SUCCESS').val("");
        $('#MESSAGE').val("");
        $('#ESTADOCP').val("");
        $('#NESTADOCP').val("");
        $('#ESTADORUC').val("");
        $('#NESTADORUC').val("");
        $('#CONDDOMIRUC').val("");
        $('#NCONDDOMIRUC').val("");
        $('#NOMBREFILE').val("");
        $('#RUTACOMPLETA').val("");
        $('.PDFSUNAT').html("");
        $('#RUTACOMPLETAPDF').val("");

    }


    $(".liquidaciongasto").on('click', '.validarxml', function (e) {
        e.preventDefault(); // Prevenir recarga del formulario

        var _token = $('#token').val();
        var serie = $('#serie').val();
        var numero = $('#numero').val();
        var fecha_emision = $('#fecha_emision').val();
        var totaldetalle = $('#totaldetalle').val();
        var empresa_id = $('#empresa_id').val();

        debugger;

        if (serie == '') {
            alerterrorajax("Ingrese una serie.");
            return false;
        }
        if (numero == '') {
            alerterrorajax("Ingrese una numero.");
            return false;
        }
        if (fecha_emision == '') {
            alerterrorajax("Ingrese una fecha de emision.");
            return false;
        }
        if (totaldetalle == '') {
            alerterrorajax("Ingrese una total.");
            return false;
        }
        if (empresa_id == '') {
            alerterrorajax("Seleccione una empresa.");
            return false;
        }
        if (!empresa_id || empresa_id === '') {
            alerterrorajax("Seleccione una empresa.");
            return false;
        }

        $('#serie').prop('readonly', true);
        $('#numero').prop('readonly', true);
        $('#fecha_emision').prop('readonly', true).css('pointer-events', 'none');
        $('.input-group-addon').css('pointer-events', 'none').css('cursor', 'not-allowed');
        $('#totaldetalle').prop('readonly', true);
        //$('#empresa_id').prop('disabled', false).prop('readonly', true);
        $('#empresa_id').prop('readonly', true)
            .next('.select2-container').css('pointer-events', 'none');


        data = {
            _token: _token,
            serie: serie,
            numero: numero,
            fecha_emision: fecha_emision,
            totaldetalle: totaldetalle,
            empresa_id: empresa_id
        };

        const link = '/ajax-leer-xml-lg-validar';
        abrircargando();
        $.ajax({
            type: "POST",
            url: carpeta + link,
            data: data,
            success: function (data) {
                cerrarcargando();
                debugger;
                if (data.error == 0) {

                    $('.MESSAGE').html(data.MESSAGE);
                    $('.NESTADOCP').html(data.NESTADOCP);
                    $('.NESTADORUC').html(data.NESTADORUC);
                    $('.NCONDDOMIRUC').html(data.NCONDDOMIRUC);
                    $('#SUCCESS').val(data.SUCCESS);
                    $('#MESSAGE').val(data.MESSAGE);
                    $('#ESTADOCP').val(data.ESTADOCP);
                    $('#NESTADOCP').val(data.NESTADOCP);
                    $('#ESTADORUC').val(data.ESTADORUC);
                    $('#NESTADORUC').val(data.NESTADORUC);
                    $('#CONDDOMIRUC').val(data.CONDDOMIRUC);
                    $('#NCONDDOMIRUC').val(data.NCONDDOMIRUC);
                    $('#NOMBREFILE').val(data.NOMBREFILE);
                    $('#RUTACOMPLETA').val(data.RUTACOMPLETA);
                    //archivos
                    $('.sectorxmlmodal').show();

                } else {
                    alerterrorajax(data.mensaje);
                }
                console.log(data);
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });


    });


    $(".liquidaciongasto").on('click', '.btn-relacionar-producto-lg', function (e) {
        event.preventDefault();
        debugger;
        var producto_id = $('#producto_id').val();
        var data_item = $(this).attr('data_item');
        $('.d' + data_item).find('.TXT_PRODUCTO_OSIRIS').html(producto_id);
        $('#modal-detalle-requerimiento').niftyModal('hide');

    });

    $(".liquidaciongasto").on('click', '.btnemitirliquidaciongasto', function (e) {
        event.preventDefault();
        var _token = $('#token').val();
        var tipopago_id = $('#tipopago_id').val();
        var entidadbanco_id = $('#entidadbanco_id').val();
        var cb_id = $('#cb_id').val();

        if (tipopago_id == 'MPC0000000000002') {
            if (entidadbanco_id == '') {
                alerterrorajax("Seleccione Entidad Bancaria.");
                return false;
            }
            if (cb_id == '') {
                alerterrorajax("Seleccione Entidad Bancaria.");
                return false;
            }
        }


        $.confirm({
            title: '¿Confirma la emision?',
            content: 'Registro de emision de liquidacion de gastos',
            buttons: {
                confirmar: function () {
                    $("#frmpmemitir").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la emision');
                    window.location.reload();
                }
            }
        });

    });


    $(".liquidaciongasto").on('click', '.btn-guardar-detalle-factura', function (e) {
        event.preventDefault();
        var _token = $('#token').val();
        var tipodoc_id = $('#tipodoc_id').val();

        var RUTAXML = $('#RUTAXML').val();
        var RUTAPDF = $('#RUTAPDF').val();
        var RUTACDR = $('#RUTACDR').val();

        var cuenta_id = $('#cuenta_id').val();
        var subcuenta_id = $('#subcuenta_id').val();
        var RUTACOMPLETAPDF = $('#RUTACOMPLETAPDF').val();


        if (cuenta_id == '') {
            alerterrorajax("Seleccione una Cuenta.");
            return false;
        }
        if (subcuenta_id == '') {
            alerterrorajax("Seleccione una Sub Cuenta");
            return false;
        }


        var array_detalle_producto = $('#array_detalle_producto').val();
        abrircargando();


        if (tipodoc_id == 'TDO0000000000001') {

            if (RUTACOMPLETAPDF == "") {
                let comprobante = $('#file-DCC0000000000036')[0].files.length > 0;
                if (!comprobante) {
                    alerterrorajax("Debe subir el comprobante electronico.");
                    cerrarcargando();
                    return false;
                }
            }

            var producto_id_factura = $('#producto_id_factura').val();
            var igv_id_factura = $('#igv_id_factura').val();
            var ESTADOCP = $('#ESTADOCP').val();
            var ESTADORUC = $('#ESTADORUC').val();
            if (ESTADOCP != '1') {
                alerterrorajax("Debe validar el documento.");
                cerrarcargando();
                return false;
            }
            if (ESTADORUC == '') {
                alerterrorajax("Debe validar el documento.");
                cerrarcargando();
                return false;
            }
            if (producto_id_factura == '') {
                alerterrorajax("Seleccione un Producto.");
                cerrarcargando();
                return false;
            }
            if (igv_id_factura == '') {
                alerterrorajax("Seleccione si es Afecto");
                cerrarcargando();
                return false;
            }

        } else {

            if (tipodoc_id != 'TDO0000000000070') {
                let comprobante = $('#file-DCC0000000000036')[0].files.length > 0;
                if (!comprobante) {
                    alerterrorajax("Debe subir el comprobante electronico.");
                    cerrarcargando();
                    return false;
                }
            }

        }
        $("#frmdetallelg").submit();

    });


    $(".liquidaciongasto").on('click', '.btn-guardar-detalle-documento-lg', function (e) {
        event.preventDefault();
        var _token = $('#token').val();
        var producto_id = $('#producto_id').val();
        var importe = $('#importe').val();
        var igv_id = $('#igv_id').val();

        if (producto_id == '') {
            alerterrorajax("Seleccione una Producto.");
            return false;
        }
        if (importe == '') {
            alerterrorajax("Ingrese un importe");
            return false;
        }
        if (igv_id == '') {
            alerterrorajax("Seleccione un igv.");
            return false;
        }

        $("#agregarpmd").submit();
    });


    $(".liquidaciongasto").on('click', '.btn-buscar-planilla', function () {
        // debugger;
        var _token = $('#token').val();
        var data_iddocumento = $(this).attr('data_iddocumento');
        var idopcion = $('#idopcion').val();

        data = {
            _token: _token,
            data_iddocumento: data_iddocumento,
            idopcion: idopcion
        };

        ajax_modal(data, "/ajax-modal-buscar-planilla-lg",
            "modal-detalle-requerimiento", "modal-detalle-requerimiento-container");

    });


    $(".liquidaciongasto").on('click', '.modificardetalledocumentolg', function () {
        // debugger;
        var _token = $('#token').val();
        var data_iddocumento = $(this).attr('data_iddocumento');
        var data_item = $(this).attr('data_item');
        var data_item_documento = $(this).attr('data_item_documento');
        var idopcion = $('#idopcion').val();

        data = {
            _token: _token,
            data_iddocumento: data_iddocumento,
            data_item: data_item,
            data_item_documento: data_item_documento,
            idopcion: idopcion
        };

        ajax_modal(data, "/ajax-modal-modificar-detalle-documento-lg",
            "modal-detalle-requerimiento", "modal-detalle-requerimiento-container");

    });


    $(".liquidaciongasto").on('click', '.relacionardetalledocumentolg', function () {
        // debugger;
        var _token = $('#token').val();
        var data_item = $(this).attr('data_item');
        var data_producto = $(this).attr('data_producto');
        var idopcion = $('#idopcion').val();

        data = {
            _token: _token,
            data_item: data_item,
            data_producto: data_producto,
            idopcion: idopcion
        };

        ajax_modal(data, "/ajax-modal-relacionar-detalle-documento-lg",
            "modal-detalle-requerimiento", "modal-detalle-requerimiento-container");

    });


    $(".liquidaciongasto").on('click', '#btnempresacuenta', function () {

        event.preventDefault();
        var empresa_id = $('#empresa_id').val();
        var idopcion = $('#idopcion').val();
        var _token = $('#token').val();
        var link = "/ajax-combo-cuenta";
        var contenedor = "ajax_combo_cuenta";
        data = {
            _token: _token,
            empresa_id: empresa_id,
            idopcion: idopcion
        };
        ajax_normal_combo(data, link, contenedor);
    });


    $(".liquidaciongasto").on('click', '.btnguardarliquidaciongasto', function (e) {
        event.preventDefault();
        var _token = $('#token').val();
        var arendir_id = $('#arendir_id').val();
        var arendir_sel_id = $('#arendir_sel_id').val();

        if (arendir_id == 'SI') {
            if (arendir_sel_id == '') {
                alerterrorajax("Seleccione una ARENDIR.");
                return false;
            }
        }

        $.confirm({
            title: '¿Confirma el registro?',
            content: 'Registro de Liquidacion de Gastos',
            buttons: {
                confirmar: function () {
                    $("#frmpm").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo el registro');
                    window.location.reload();
                }
            }
        });

    });


    $(".liquidaciongasto").on('click', '.agregardetalle', function (e) {
        var _token = $('#token').val();
        var idopcion = $('#idopcion').val();
        const tabId = '#registro';
        $('.nav-tabs a[href="' + tabId + '"]').tab('show');

    });


    $(".liquidaciongasto").on('change', '#empresa_id', function () {
        var empresa_id = $('#empresa_id').val();
        var _token = $('#token').val();
        debugger;

        var link = "/ajax-combo-cuenta";
        var contenedor = "ajax_combo_cuenta";
        data = {
            _token: _token,
            empresa_id: empresa_id
        };
        ajax_normal_combo(data, link, contenedor);

    });


    $(".liquidaciongasto").on('change', '#cuenta_id', function () {
        var cuenta_id = $('#cuenta_id').val();
        var _token = $('#token').val();
        debugger;
        var link = "/ajax-combo-subcuenta";
        var contenedor = "ajax_combo_subcuenta";
        data = {
            _token: _token,
            cuenta_id: cuenta_id
        };
        ajax_normal_combo(data, link, contenedor);

    });
    $(".liquidaciongasto").on('change', '#flujo_id', function () {
        var flujo_id = $('#flujo_id').val();
        var _token = $('#token').val();
        debugger;
        var link = "/ajax-combo-item";
        var contenedor = "ajax_combo_item";
        data = {
            _token: _token,
            flujo_id: flujo_id
        };
        ajax_normal_combo(data, link, contenedor);

    });


    $(".liquidaciongasto").on('click', '.btn-agregar-detalle-factura', function () {
        // debugger;
        var _token = $('#token').val();
        var data_iddocumento = $(this).attr('data_iddocumento');
        var data_item = $(this).attr('data_item');
        var idopcion = $('#idopcion').val();

        let existe = false;
        // Recorrer todas las filas de la tabla
        let tieneDatos = false;
        $(".ltabladet tbody tr").each(function () {
            console.log($(this).text().trim());
            debugger;
            if ($(this).text().trim() !== "") { // Verifica que la fila no esté vacía
                tieneDatos = true;
            }
        });

        if (tieneDatos === true) {
            alerterrorajax("Ya tiene un registro en el detalle solo se permite un solo detalle.");
        } else {

            data = {
                _token: _token,
                data_iddocumento: data_iddocumento,
                data_item: data_item,
                idopcion: idopcion
            };

            ajax_modal(data, "/ajax-modal-detalle-documento-lg",
                "modal-detalle-requerimiento", "modal-detalle-requerimiento-container");

        }


    });


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
    });

});




