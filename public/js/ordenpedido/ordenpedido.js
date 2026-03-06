$(document).ready(function () {

    /* ===============================
       VARIABLES GENERALES
       =============================== */

    var carpeta = $("#carpeta").val();
    let filaCount = 0;

    // Inicializar totales y visibilidad de campos
    setTimeout(() => {
        calcularTotalPedido();
    }, 500);

    /* ===============================
       FUNCIÓN MODAL BONITO (ÚNICA)
       =============================== */

    function modalBonito({ tipo, icono, titulo, mensaje, ancho = '360px', confirmar = false, onConfirm = null }) {

        const colores = {
            error: ['#ff416c', '#ff4b2b'],
            warn: ['#f7971e', '#ffd200'],
            info: ['#4facfe', '#00f2fe'],
            success: ['#00b09b', '#96c93d']
        };

        const botonesPorTipo = {
            error: 'btn-red',
            warn: 'btn-orange',
            success: 'btn-green',
            info: 'btn-blue'
        };

        const grad = colores[tipo] || colores.info;
        const claseBoton = botonesPorTipo[tipo] || 'btn-blue';

        const contenido = `
            <div style="position:relative;text-align:center;padding:40px 20px 25px;">
                <div style="
                    position:absolute;top:0;left:0;
                    width:100%;height:10px;
                    background:linear-gradient(135deg,${grad[0]},${grad[1]});
                    border-radius:6px 6px 0 0;">
                </div>

                <div style="
                    width:90px;height:90px;
                    border-radius:50%;
                    background:linear-gradient(135deg,${grad[0]},${grad[1]});
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    margin:0 auto 18px;
                    box-shadow:0 12px 25px rgba(0,0,0,.25);">
                    <span style="font-size:42px;color:white;">${icono}</span>
                </div>

                <h3 style="margin:0;font-weight:600;color:#2c3e50;">
                    ${titulo}
                </h3>

                <p style="margin-top:12px;font-size:15px;color:#555;">
                    ${mensaje}
                </p>
            </div>
        `;

        if (confirmar) {
            $.confirm({
                title: false,
                content: contenido,
                boxWidth: ancho,
                useBootstrap: false,
                animation: 'scale',
                buttons: {
                    confirmar: {
                        text: 'Guardar',
                        btnClass: 'btn-blue', // 👈 siempre azul
                        action: onConfirm
                    },
                    cancelar: {
                        text: 'Cancelar'
                    }
                }
            });
        } else {
            $.alert({
                title: false,
                content: contenido,
                boxWidth: ancho,
                useBootstrap: false,
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: claseBoton
                    }
                }
            });
        }
    }


    /* ===============================
       REGISTRAR ORDEN DE PEDIDO
       =============================== */

    /* ===============================
   REGISTRAR ORDEN DE PEDIDO
   =============================== */

    $(".ordenpedidoprincipal").on('click', '#asignarordenpedido', function (e) {
        e.preventDefault();

        let _token = $('#token').val();
        let fec_pedido = $('#fec_pedido').val();
        let cod_periodo = $('#cod_periodo').val();
        let cod_anio = $('#cod_anio').val();
        let cod_empr = $('#cod_empr').val();
        let cod_centro = $('#cod_centro').val();
        let cod_tipo_pedido = $('#cod_tipo_pedido').val();
        let cod_trabajador_solicita = $('#cod_trabajador_solicita').val();
        let cod_trabajador_autoriza = $('#cod_trabajador_autoriza').val();
        let cod_trabajador_aprueba_ger = $('#cod_trabajador_aprueba_ger').val();
        let cod_trabajador_aprueba_adm = $('#cod_trabajador_aprueba_adm').val();
        let txt_glosa = $('#txt_glosa').val();
        let cod_estado = $('#cod_estado').val();
        let cod_area = $('#cod_area').val();
        let orden_pedido_id = $('#orden_pedido_id').val();

        let opcion = !orden_pedido_id ? 'I' : 'U';

        /* ========= VALIDACIONES ========= */

        function errorCampo(mensaje) {
            modalBonito({
                tipo: 'error',
                icono: '❌',
                titulo: 'Campos obligatorios',
                mensaje: mensaje
            });
        }

        if (!cod_anio) return errorCampo('Debe seleccionar:<br><b>Año</b>');
        if (!cod_periodo) return errorCampo('Debe seleccionar:<br><b>Mes</b>');
        if (!cod_tipo_pedido) return errorCampo('Debe seleccionar:<br><b>Tipo Pedido</b>');
        if (!cod_trabajador_autoriza) return errorCampo('Debe seleccionar:<br><b>Usuario Autoriza</b>');
        if ($('#cod_trabajador_aprueba_ger').is(':visible') && !cod_trabajador_aprueba_ger) return errorCampo('Debe seleccionar:<br><b>Usuario Aprueba Gerencia</b>');
        if ($('#cod_trabajador_aprueba_adm').is(':visible') && !cod_trabajador_aprueba_adm) return errorCampo('Debe seleccionar:<br><b>Usuario Aprueba Administración</b>');
        if (!txt_glosa) return errorCampo('Debe completar:<br><b>Observación</b>');

        /* ========= DETALLE ========= */

        let detalles = [];
        $('#tabla_detalle_pedido tbody tr').each(function () {
            let tds = $(this).find('td');
            detalles.push({
                cod_producto: tds.eq(1).text().trim(),
                nom_producto: tds.eq(2).text().trim(),
                cod_categoria: tds.eq(3).text().trim(),
                nom_categoria: tds.eq(4).text().trim(),
                cantidad: parseInt(tds.eq(5).text().trim()) || 0,
                txt_observacion: tds.eq(8).text().trim(),
                opcion_detalle: 'I',
                detalle_id: null
            });
        });

        if (detalles.length === 0) {
            modalBonito({
                tipo: 'warn',
                icono: '🛒',
                titulo: 'No hay productos',
                mensaje: 'Debe agregar al menos <b>un producto</b>.'
            });
            return;
        }

        /* ========= CONFIRMAR ========= */

        modalBonito({
            tipo: 'info',
            icono: '📝',
            titulo: 'Confirmar registro',
            mensaje: '¿Deseas guardar la <b>Orden de Pedido</b>?',
            confirmar: true,
            onConfirm: function () {

                // Abrimos cargando solo cuando el usuario confirma
                abrircargando();

                $.ajax({
                    type: "POST",
                    url: carpeta + "/registrar_orden_pedido",
                    data: {
                        _token,
                        fec_pedido,
                        cod_periodo,
                        cod_anio,
                        cod_empr,
                        cod_centro,
                        cod_tipo_pedido,
                        cod_trabajador_solicita,
                        cod_trabajador_autoriza,
                        cod_trabajador_aprueba_ger,
                        cod_trabajador_aprueba_adm,
                        txt_glosa,
                        cod_estado,
                        cod_area,
                        orden_pedido_id,
                        opcion,
                        array_detalle: detalles
                    },

                    success: function (resp) {
                        modalBonito({
                            tipo: 'success',
                            icono: '✔',
                            titulo: 'Operación exitosa',
                            mensaje: 'La Orden de Pedido fue registrada correctamente.'
                        });

                        // 🔹 Dejamos el cargando activo y recargamos
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },

                    error: function (xhr) {
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: xhr.responseJSON?.message ||
                                'Ocurrió un error al guardar la Orden de Pedido.'
                        });
                        cerrarcargando(); // Cerramos solo si hay error
                    },
                });
            }
        });
    });

    $("#empresa_id").on('change', function (e) {
    //$(".ordenpedidoprincipal").on('change', '#empresa_id', function () {

        e.preventDefault();
        let empresa_id = $('#empresa_id').val();
        let _token = $('#token').val();

        debugger;

        data = {
            _token: _token,
            empresa_id: empresa_id
        };
/*
        $.ajax({
            type: "POST",
            url: carpeta + "/cargar-periodo-consolidado",
            data: {
                _token: _token,
                empresa_id: empresa_id
            },
            success: function (res) {
                debugger;

            },
            error: function (res) {
                debugger;
                error500(res);
            }
        });*/

        //ajax_normal_combo(data, "/cargar-periodo-consolidado", "ajax_periodo")

    });

    /* ===============================
       AGREGAR PRODUCTO
       =============================== */

    $('#agregar_producto').click(function (e) {
        e.preventDefault();

        let option = $('#cod_producto option:selected');
        let cod_producto = $('#cod_producto').val();
        let nom_producto = option.data('nombre');
        let cod_categoria = option.data('codcategoria');
        let nom_categoria = option.data('unidad');
        let cantidad = $('#cantidad').val();
        let precio = parseFloat(option.data('precio')) || 0;
        let subtotal = parseFloat(cantidad) * precio;
        let txt_observacion = $('#txt_observacion').val();

        if (!cod_producto) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠',
                titulo: 'Atención',
                mensaje: 'Debe seleccionar un producto.'
            });
            return;
        }

        if (!cantidad || cantidad <= 0) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠',
                titulo: 'Atención',
                mensaje: 'Ingrese cantidad, debe ser mayor a 0.'
            });
            return;
        }

        if (!cod_categoria) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠',
                titulo: 'Atención',
                mensaje: 'Coordinar con el área de compras para configurar su unidad.'
            });
            return;
        }

        if (!precio || precio <= 0) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠',
                titulo: 'Precio no configurado',
                mensaje: nom_producto + ' - coordinar con el área de compras el precio del producto.'
            });
            return;
        }




        let existe = false;
        $('#tabla_detalle_pedido tbody tr').each(function () {
            if ($(this).find('td:eq(1)').text() === cod_producto) {
                existe = true;
                return false;
            }
        });

        if (existe) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠',
                titulo: 'Producto duplicado',
                mensaje: 'Este producto ya fue agregado.'
            });
            return;
        }

        filaCount++;

        $('#tabla_detalle_pedido tbody').append(`
            <tr>
                <td class="text-center">${filaCount}</td>
                <td class="text-center">${cod_producto}</td>
                <td>${nom_producto}</td>
                <td style="display:none">${cod_categoria}</td>
                <td class="text-center">${nom_categoria}</td>
                <td class="text-center">${cantidad}</td>
                <td class="text-center">${precio.toFixed(2)}</td>
                <td class="text-center subtotal">${subtotal.toFixed(2)}</td>
                <td>${txt_observacion}</td>
            </tr>
        `);

        calcularTotalPedido();

        $('#cod_producto').val('').trigger('change');
        $('#cod_categoria').val('');
        $('#nom_categoria').val('');
        $('#cantidad').val('');
        $('#txt_observacion').val('');
    });

    function calcularTotalPedido() {

        let totalPedido = 0;

        // Sumar subtotales
        $('#tabla_detalle_pedido tbody .subtotal').each(function () {
            totalPedido += parseFloat($(this).text()) || 0;
        });

        $('#total_pedido').text(totalPedido.toFixed(2));

        if (typeof registrosMonto !== 'undefined' && Array.isArray(registrosMonto)) {

            // =========================
            // OBTENER UMBRALES
            // =========================

            // Gerencia
            let configGerencia = registrosMonto.find(r => r.COD_MONTO === 'IICHMO0000000001');
            let umbralGerencia = configGerencia ? parseFloat(configGerencia.MONTO) : 0;

            // Administración
            let configAdminMaestra = registrosMonto.find(r => r.COD_MONTO === 'IICHMO0000000002');
            let umbralAdminMaestra = configAdminMaestra ? parseFloat(configAdminMaestra.MONTO) : 0;


            // =========================
            // LÓGICA GERENCIA
            // =========================
            // Se muestra cuando supera el umbral de Administración (ej: 800)

            if (totalPedido > umbralAdminMaestra) {

                if ($('#cod_trabajador_aprueba_ger').closest('.col-md-6').is(':hidden')) {

                    modalBonito({
                        tipo: 'warn',
                        icono: '⚠️',
                        titulo: 'Atención',
                        mensaje: 'El monto total <b>superó los ' +
                                 umbralAdminMaestra.toFixed(2) +
                                 '</b>. Debe seleccionar el <b>Aprobador de Gerencia</b>.'
                    });
                }

                $('#cod_trabajador_aprueba_ger').closest('.col-md-6').show();

            } else {

                $('#cod_trabajador_aprueba_ger').closest('.col-md-6').hide();
                $('#cod_trabajador_aprueba_ger').val('').trigger('change');
            }


            // =========================
            // LÓGICA ADMINISTRACIÓN
            // =========================

            if (totalPedido > 0) {

                $('#cod_trabajador_aprueba_adm').closest('.col-md-6').show();

                // Valor base (0 – 800)
                let selectedAdmin = 'IATR000000000199';

                // Si supera 800 → cambia a IITR000000000391
                if (totalPedido > umbralAdminMaestra) {
                    selectedAdmin = 'IITR000000000391';
                }

                $('#cod_trabajador_aprueba_adm')
                    .val(selectedAdmin)
                    .trigger('change')
                    .prop('disabled', true);

            } else {

                $('#cod_trabajador_aprueba_adm').closest('.col-md-6').hide();
                $('#cod_trabajador_aprueba_adm')
                    .val('')
                    .trigger('change')
                    .prop('disabled', false);
            }
        }
    }

    /* $('#cod_anio').on('change', function () {

             let anio    = $(this).val();
             let empresa = $('#cod_empr').val();
             let carpeta = $('#carpeta').val();

             $('#cod_periodo').html('<option value="">Cargando...</option>');

             if (!anio) {
                 $('#cod_periodo').html('<option value="">Seleccione Mes</option>');
                 return;
             }

             $.ajax({
                 type: 'POST',
                 url: carpeta + '/obtener-meses',
                 data: {
                     _token: $('#token').val(),
                     anio: anio,
                     empresa: empresa
                 },
                 success: function (data) {

                     let options = '<option value="">Seleccione Mes</option>';

                     $.each(data, function (key, value) {
                         options += `<option value="${key}">${value}</option>`;
                     });

                     $('#cod_periodo')
                         .html(options)
                         .prop('disabled', false)
                         .trigger('change'); // select2
                 },
                 error: function () {
                     alert('Error al cargar los meses');
                 }
             });
         });*/

    /* ===============================
       SELECCIONAR / ELIMINAR FILA
       =============================== */

    $('#tabla_detalle_pedido tbody').on('click', 'tr', function () {
        $(this).addClass('fila-seleccionada').siblings().removeClass('fila-seleccionada');
    });

    $('#eliminar_producto').click(function () {
        let fila = $('#tabla_detalle_pedido tbody tr.fila-seleccionada');
        if (!fila.length) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠',
                titulo: 'Atención',
                mensaje: 'Debe seleccionar una fila.'
            });
            return;
        }
        fila.remove();
        filaCount = 0;
        $('#tabla_detalle_pedido tbody tr').each(function () {
            filaCount++;
            $(this).find('td:first').text(filaCount);
        });

        calcularTotalPedido();
    });


    $(".ordenpedidoprincipal").on('click', '.ver-detalle-pedido', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');

        var _token = $('#token').val();

        let data = {
            _token: _token,
            orden_pedido_id: orden_pedido_id,
        };

        // Limpiar contenido previo
        $(".modal-verdetallepedido-solicitud-container").html('');

        ajax_modal(
            data,
            "/ver_detalle_orden_pedido",
            "modal-verdetallepedido-solicitud",
            "modal-verdetallepedido-solicitud-container"
        );
    });

    /* ===============================
       DOBLE CLICK EDITAR PEDIDO
       =============================== */
    $(".ordenpedidoprincipal").on('dblclick', '.fila-pedido', function () {
        let id_pedido = $(this).data('id');
        let estado = $(this).data('estado');

        // SOLO PERMITIR EDITAR CUANDO ESTADO SEA ETM0000000000001
        if (estado !== 'ETM0000000000001') {
            modalBonito({
                tipo: 'warn',
                icono: '🚫',
                titulo: 'No se puede editar',
                mensaje: 'Este pedido no se encuentra en un estado que permita modificaciones.'
            });
            return;
        }

        abrircargando();

        $.ajax({
            type: "POST",
            url: carpeta + "/ajax-pedido-editar",
            data: {
                _token: $('#token').val(),
                id_pedido: id_pedido
            },
            success: function (resp) {
                cerrarcargando();

                if (resp.pedido) {
                    let p = resp.pedido;

                    // Llenar campos cabecera
                    $('#orden_pedido_id').val(p.ID_PEDIDO);
                    $('#id_pedido').val(p.ID_PEDIDO);
                    $('#nro_pedido').val(p.ID_PEDIDO); // O el folio si existe
                    $('#fec_pedido').val(p.FEC_PEDIDO ? p.FEC_PEDIDO.substring(0, 10) : "");
                    $('#cod_anio').val(p.COD_ANIO).trigger('change');
                    $('#cod_periodo').val(p.COD_PERIODO).trigger('change');
                    $('#cod_trabajador_autoriza').val(p.COD_TRABAJADOR_AUTORIZA).trigger('change');
                    $('#cod_trabajador_aprueba_ger').val(p.COD_TRABAJADOR_APRUEBA_GER).trigger('change');
                    $('#cod_trabajador_aprueba_adm').val(p.COD_TRABAJADOR_APRUEBA_ADM).trigger('change');
                    $('#cod_tipo_pedido').val(p.COD_TIPO_PEDIDO).trigger('change');
                    $('#txt_glosa').val(p.TXT_GLOSA);
                    $('#cod_estado').val(p.COD_ESTADO);

                    // Limpiar tabla detalle
                    let tbody = $('#tabla_detalle_pedido tbody');
                    tbody.empty();
                    filaCount = 0; // 👈 Reiniciamos contador para que siga la secuencia

                    // Llenar tabla detalle
                    if (resp.detalle && resp.detalle.length > 0) {
                        resp.detalle.forEach((det, index) => {
                            filaCount++; // 👈 Sincronizamos el contador global

                            let precio = parseFloat(det.PRECIO || 0);
                            let cantidad = parseFloat(det.CANTIDAD || 0);
                            let subtotal = (precio * cantidad).toFixed(2);

                            tbody.append(`
                                <tr class="fila-detalle-pedido-tabla" style="cursor: pointer;">
                                    <td class="text-center">${filaCount}</td>
                                    <td class="text-center font-bold">${det.COD_PRODUCTO}</td>
                                    <td>${det.NOM_PRODUCTO}</td>
                                    <td class="text-center" style="display:none;">${det.COD_CATEGORIA}</td>
                                    <td class="text-center">${det.NOM_CATEGORIA}</td>
                                    <td class="text-center font-bold">${parseInt(det.CANTIDAD)}</td>
                                    <td class="text-center">${precio.toFixed(2)}</td>
                                    <td class="text-center font-bold subtotal">${subtotal}</td>
                                    <td class="text-muted small">${det.TXT_OBSERVACION || '-'}</td>
                                </tr>
                            `);
                        });
                    }

                    calcularTotalPedido();

                    // Cambiar a la pestaña de registro
                    $('a[href="#crearpedido"]').tab('show');

                    modalBonito({
                        tipo: 'success',
                        icono: '✏️',
                        titulo: 'Pedido cargado',
                        mensaje: 'Los datos del pedido <b>' + id_pedido + '</b> han sido cargados para su edición.'
                    });
                }
            },
            error: function (xhr) {
                cerrarcargando();
                let errorMsg = xhr.responseJSON?.message || xhr.responseText || 'Error desconocido';
                modalBonito({
                    tipo: 'error',
                    icono: '❌',
                    titulo: 'Error al cargar pedido',
                    mensaje: 'No se pudo cargar la información.<br><small>' + errorMsg + '</small>'
                });
            }
        });
    });

    $(".ordenpedidoprincipal").on('click', '.ver-detalle-pedido-aut', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');

        var _token = $('#token').val();

        let data = {
            _token: _token,
            orden_pedido_id: orden_pedido_id,
        };

        // Limpiar contenido previo
        $(".modal-verdetallepedido-solicitud-container").html('');

        ajax_modal(
            data,
            "/ver_detalle_orden_pedido_aut",
            "modal-verdetallepedido-solicitud",
            "modal-verdetallepedido-solicitud-container"
        );
    });

    $(".ordenpedidoprincipal").on('click', '.ver-detalle-pedido-ger', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');

        var _token = $('#token').val();

        let data = {
            _token: _token,
            orden_pedido_id: orden_pedido_id,
        };

        // Limpiar contenido previo
        $(".modal-verdetallepedido-solicitud-container").html('');

        ajax_modal(
            data,
            "/ver_detalle_orden_pedido_ger",
            "modal-verdetallepedido-solicitud",
            "modal-verdetallepedido-solicitud-container"
        );
    });

    $(".ordenpedidoprincipal").on('click', '.ver-detalle-pedido-adm', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');

        var _token = $('#token').val();

        let data = {
            _token: _token,
            orden_pedido_id: orden_pedido_id,
        };

        // Limpiar contenido previo
        $(".modal-verdetallepedido-solicitud-container").html('');

        ajax_modal(
            data,
            "/ver_detalle_orden_pedido_adm",
            "modal-verdetallepedido-solicitud",
            "modal-verdetallepedido-solicitud-container"
        );
    });

    // GUARDAR CANTIDADES EDITADAS EN EL DETALLE
    $(".modal-verdetallepedido-solicitud-container").on('click', '.btn-editar-cantidades-aut', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();
        let cantidades = [];

        // Recolectar todas las cantidades de los inputs
        $(".input-cantidad-editar").each(function () {
            cantidades.push({
                cod_producto: $(this).data('prod'),
                cantidad: $(this).val()
            });
        });

        modalBonito({
            tipo: 'info',
            icono: '📝',
            titulo: 'Guardar Cambios',
            mensaje: '¿Está seguro de actualizar las cantidades de este pedido?',
            confirmar: true,
            onConfirm: function () {
                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/guardar_editar_detalle_pedido_aut',
                    data: {
                        _token: _token,
                        orden_pedido_id: orden_pedido_id,
                        cantidades: cantidades
                    },
                    success: function (resp) {
                        cerrarcargando();
                        if (resp.success) {
                            modalBonito({
                                tipo: 'success',
                                icono: '✔',
                                titulo: 'Éxito',
                                mensaje: resp.mensaje
                            });
                            // Cerrar modal
                            $.fn.niftyModal('close');
                        } else {
                            modalBonito({
                                tipo: 'error',
                                icono: '❌',
                                titulo: 'Error',
                                mensaje: resp.mensaje
                            });
                        }
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            titulo: 'Error',
                            mensaje: 'Ocurrió un error al intentar guardar.'
                        });
                    }
                });
            }
        });
    });

    $(".modal-verdetallepedido-solicitud-container").on('click', '.btn-editar-cantidades-ger', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();
        let cantidades = [];

        // Recolectar todas las cantidades de los inputs
        $(".input-cantidad-editar").each(function () {
            cantidades.push({
                cod_producto: $(this).data('prod'),
                cantidad: $(this).val()
            });
        });

        modalBonito({
            tipo: 'info',
            icono: '📝',
            titulo: 'Guardar Cambios',
            mensaje: '¿Está seguro de actualizar las cantidades de este pedido?',
            confirmar: true,
            onConfirm: function () {
                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/guardar_editar_detalle_pedido_ger',
                    data: {
                        _token: _token,
                        orden_pedido_id: orden_pedido_id,
                        cantidades: cantidades
                    },
                    success: function (resp) {
                        cerrarcargando();
                        if (resp.success) {
                            modalBonito({
                                tipo: 'success',
                                icono: '✔',
                                titulo: 'Éxito',
                                mensaje: resp.mensaje
                            });
                            // Cerrar modal
                            $.fn.niftyModal('close');
                        } else {
                            modalBonito({
                                tipo: 'error',
                                icono: '❌',
                                titulo: 'Error',
                                mensaje: resp.mensaje
                            });
                        }
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            titulo: 'Error',
                            mensaje: 'Ocurrió un error al intentar guardar.'
                        });
                    }
                });
            }
        });
    });

    $(".modal-verdetallepedido-solicitud-container").on('click', '.btn-editar-cantidades-adm', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();
        let cantidades = [];

        // Recolectar todas las cantidades de los inputs
        $(".input-cantidad-editar").each(function () {
            cantidades.push({
                cod_producto: $(this).data('prod'),
                cantidad: $(this).val()
            });
        });

        modalBonito({
            tipo: 'info',
            icono: '📝',
            titulo: 'Guardar Cambios',
            mensaje: '¿Está seguro de actualizar las cantidades de este pedido?',
            confirmar: true,
            onConfirm: function () {
                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/guardar_editar_detalle_pedido_adm',
                    data: {
                        _token: _token,
                        orden_pedido_id: orden_pedido_id,
                        cantidades: cantidades
                    },
                    success: function (resp) {
                        cerrarcargando();
                        if (resp.success) {
                            modalBonito({
                                tipo: 'success',
                                icono: '✔',
                                titulo: 'Éxito',
                                mensaje: resp.mensaje
                            });
                            // Cerrar modal
                            $.fn.niftyModal('close');
                        } else {
                            modalBonito({
                                tipo: 'error',
                                icono: '❌',
                                titulo: 'Error',
                                mensaje: resp.mensaje
                            });
                        }
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            titulo: 'Error',
                            mensaje: 'Ocurrió un error al intentar guardar.'
                        });
                    }
                });
            }
        });
    });



    $('#cod_producto').on('change', function () {
        let option = $(this).find(':selected');
        let unidad = option.data('unidad') || '';
        let ind_material_servicio = option.data('indmaterialservicio') || '';

        $('#unidad').val(unidad);

        if (ind_material_servicio === 'S') {
            $('#cantidad').val(1).prop('disabled', true);
        } else {
            $('#cantidad').val('').prop('disabled', false);
        }
    });


    $(".ordenpedidoprincipal").on('click', '.emitir-pedido', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();
        let boton = $(this);

        modalBonito({
            tipo: 'info',
            icono: '✅',
            titulo: 'Emitir Orden',
            mensaje: '¿Está seguro de <b>emitir</b> esta Orden de Pedido?',
            confirmar: true,
            onConfirm: function () {

                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/emitir_orden_pedido',
                    data: {
                        _token: _token,
                        orden_pedido_id: orden_pedido_id
                    },
                    success: function (resp) {

                        cerrarcargando();

                        modalBonito({
                            tipo: 'success',
                            icono: '✔',
                            titulo: 'Orden emitida',
                            mensaje: 'La Orden de Pedido fue emitida correctamente.'

                        });

                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: 'No se pudo emitir la orden.'
                        });
                    }
                });
            }
        });
    });

    $(".ordenpedidoprincipal").on('click', '.anular-pedido', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();
        let boton = $(this);

        modalBonito({
            tipo: 'error',
            icono: '❌',
            titulo: 'Anular Orden',
            mensaje: '¿Está seguro de <b>anular</b> esta Orden de Pedido?',
            confirmar: true,
            onConfirm: function () {

                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/anular_orden_pedido',
                    data: {
                        _token: _token,
                        orden_pedido_id: orden_pedido_id
                    },
                    success: function (resp) {

                        cerrarcargando();

                        modalBonito({
                            tipo: 'success',
                            icono: '✔',
                            titulo: 'Orden anulada',
                            mensaje: 'La Orden de Pedido fue anulada correctamente.'

                        });

                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: 'No se pudo anulada la orden.'
                        });
                    }
                });
            }
        });
    });


    $(".ordenpedidoprincipal").on('click', '.autorizar-pedido', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();
        let boton = $(this);

        modalBonito({
            tipo: 'info',
            icono: '✅',
            titulo: 'Autorizar Orden',
            mensaje: '¿Está seguro de <b>autorizar</b> esta Orden de Pedido?',
            confirmar: true,
            onConfirm: function () {

                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/autorizar_orden_pedido',
                    data: {
                        _token: _token,
                        orden_pedido_id: orden_pedido_id
                    },
                    success: function (resp) {

                        cerrarcargando();

                        modalBonito({
                            tipo: 'success',
                            icono: '✔',
                            titulo: 'Orden autorizada',
                            mensaje: 'La Orden de Pedido fue autorizada correctamente.'

                        });

                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: 'No se pudo aprobar la orden.'
                        });
                    }
                });
            }
        });
    });

    $(".ordenpedidoprincipal").on('click', '.rechazar-pedido', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();
        let boton = $(this);

        modalBonito({
            tipo: 'error',
            icono: '❌',
            titulo: 'Rechazar Orden',
            mensaje: '¿Está seguro de <b>rechazar</b> esta Orden de Pedido?',
            confirmar: true,
            onConfirm: function () {

                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/rechazar_orden_pedido',
                    data: {
                        _token: _token,
                        orden_pedido_id: orden_pedido_id
                    },
                    success: function (resp) {

                        cerrarcargando();

                        modalBonito({
                            tipo: 'success',
                            icono: '✔',
                            titulo: 'Orden rechazada',
                            mensaje: 'La Orden de Pedido fue rechazada correctamente.'

                        });

                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: 'No se pudo aprobar la orden.'
                        });
                    }
                });
            }
        });
    });

    $(".ordenpedidoprincipal").on('click', '.aprobar-pedido-ger', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();
        let boton = $(this);

        modalBonito({
            tipo: 'info',
            icono: '✅',
            titulo: 'Aprobar Orden',
            mensaje: '¿Está seguro de <b>aprobar</b> esta Orden de Pedido?',
            confirmar: true,
            onConfirm: function () {

                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/ap_ger_orden_pedido',
                    data: {
                        _token: _token,
                        orden_pedido_id: orden_pedido_id
                    },
                    success: function (resp) {

                        cerrarcargando();

                        modalBonito({
                            tipo: 'success',
                            icono: '✔',
                            titulo: 'Orden aprobada',
                            mensaje: 'La Orden de Pedido fue aprobada correctamente.'

                        });

                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: 'No se pudo aprobar la orden.'
                        });
                    }
                });
            }
        });
    });


    $(".ordenpedidoprincipal").on('click', '.aprobar-pedido-adm', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();
        let boton = $(this);

        modalBonito({
            tipo: 'info',
            icono: '✅',
            titulo: 'Aprobar Orden',
            mensaje: '¿Está seguro de <b>aprobar</b> esta Orden de Pedido?',
            confirmar: true,
            onConfirm: function () {

                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/ap_adm_orden_pedido',
                    data: {
                        _token: _token,
                        orden_pedido_id: orden_pedido_id
                    },
                    success: function (resp) {

                        cerrarcargando();

                        modalBonito({
                            tipo: 'success',
                            icono: '✔',
                            titulo: 'Orden aprobada',
                            mensaje: 'La Orden de Pedido fue aprobada correctamente.'

                        });

                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: 'No se pudo aprobar la orden.'
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.buscardocumento', function (event) {
        event.preventDefault();

        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var empresa_id = $('#empresa_id').val();   // ✅ usar misma variable
        var centro_pedido = $('#centro_pedido').val();
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

        var data = {
            _token: _token,
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin,
            empresa_id: empresa_id,       // ✅ corregido
            centro_pedido: centro_pedido,
            idopcion: idopcion
        };

        ajax_normal(data, "/ajax-buscar-documento-op");
    });

    $(document).on('click', '.buscarpedidoresumen', function (event) {
        event.preventDefault();

        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var empresa_id = $('#empresa_id').val();   // ✅ usar misma variable
        var centro_pedido = $('#centro_pedido').val();
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

        var data = {
            _token: _token,
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin,
            empresa_id: empresa_id,       // ✅ corregido
            centro_pedido: centro_pedido,
            idopcion: idopcion
        };

        ajax_normal(data, "/ajax-buscar-resumen-op");
    });

    $(document).on('click', '.buscarpedidoconsolidado', function (event) {
        event.preventDefault();

        var empresa_id = $('#empresa_id').val();
        var centro_id = $('#centro_id').val();
        var mes_pedido = $('#mes_pedido').val();
        var anio_pedido = $('#anio_pedido').val();
        var idopcion = $('#idopcion').val();
        var _token = $('#token').val();

        debugger;

        if ($.trim(centro_id) === '') {
            modalBonito({ tipo: 'warning', icono: '⚠️', titulo: 'Filtro requerido', mensaje: 'Por favor, seleccione un <b>Centro</b>.' });
            return false;
        }

        if ($.trim(mes_pedido) === '') {
            modalBonito({ tipo: 'warning', icono: '⚠️', titulo: 'Filtro requerido', mensaje: 'Por favor, seleccione un <b>Mes</b>.' });
            return false;
        }
        if ($.trim(anio_pedido) === '') {
            modalBonito({ tipo: 'warning', icono: '⚠️', titulo: 'Filtro requerido', mensaje: 'Por favor, seleccione un <b>Año</b>.' });
            return false;
        }

        var data = {
            _token: _token,
            empresa_id: empresa_id,
            centro_id: centro_id,
            mes_pedido: mes_pedido,
            anio_pedido: anio_pedido,
            idopcion: idopcion
        };

        ajax_normal(data, "/ajax-buscar-consolidado-op");

        // NUEVO: Buscar consolidados ya generados
        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-buscar-consolidado-generado',
            data: data,
            success: function (resp) {
                $('#bodyConsolidadoGenerado').html(resp);
            },
            error: function (e) {
                console.error("Error al buscar consolidados generados:", e);
                $('#bodyConsolidadoGenerado').html('<tr><td colspan="4" class="text-center text-danger">Error al cargar la lista.</td></tr>');
            }
        });
    });

    $(document).on('click', '.buscarpedidoconsolidadogeneral', function (event) {
        event.preventDefault();

        var empresa_id = $('#empresa_id').val();
        var mes_pedido = $('#mes_pedido').val();
        var anio_pedido = $('#anio_pedido').val();
        var idopcion = $('#idopcion').val();
        var _token = $('#token').val();

        if ($.trim(mes_pedido) === '') {
            modalBonito({ tipo: 'warning', icono: '⚠️', titulo: 'Filtro requerido', mensaje: 'Por favor, seleccione un <b>Mes</b>.' });
            return false;
        }
        if ($.trim(anio_pedido) === '') {
            modalBonito({ tipo: 'warning', icono: '⚠️', titulo: 'Filtro requerido', mensaje: 'Por favor, seleccione un <b>Año</b>.' });
            return false;
        }

        var data = {
            _token: _token,
            empresa_id: empresa_id,
            mes_pedido: mes_pedido,
            anio_pedido: anio_pedido,
            idopcion: idopcion
        };

        ajax_normal(data, "/ajax-buscar-consolidado-general-op");

    });

    $(".ordenpedido").on('click', '#descargarcomprobantemasivoexcelop', function () {

        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var empresa_id = $('#empresa_id').val();
        var centro_pedido = $('#centro_pedido').val();
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

        href = $(this).attr('data-href') + '/' + fecha_inicio + '/' + fecha_fin + '/' + empresa_id + '/' + centro_pedido + '/' + idopcion;
        $(this).prop('href', href);
        return true;
    });

    $(".ordenpedido").on('click', '#descargarresumenmasivoexcelop', function () {

        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var empresa_id = $('#empresa_id').val();
        var centro_pedido = $('#centro_pedido').val();
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

        href = $(this).attr('data-href') + '/' + fecha_inicio + '/' + fecha_fin + '/' + empresa_id + '/' + centro_pedido + '/' + idopcion;
        $(this).prop('href', href);
        return true;
    });

    $(".ordenpedido").on('click', '#descargarpedidomasivoexcelop', function () {

        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var empresa_id = $('#empresa_id').val();
        var centro_pedido = $('#centro_pedido').val();
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

        href = $(this).attr('data-href') + '/' + fecha_inicio + '/' + fecha_fin + '/' + empresa_id + '/' + centro_pedido + '/' + idopcion;
        $(this).prop('href', href);
        return true;
    });


    // Checkbox "Seleccionar todo"
    $(document).on('change', '#checkAll', function () {
        let checkboxes = document.querySelectorAll('.pedido_seleccionado');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // Botón Consolidar
    let productosConsolidados = {};

    $(document).on('click', '.btn-consolidar', function () {
        productosConsolidados = {};
        debugger;
        console.log("hola");
        if (typeof pedidosData === 'undefined' || !pedidosData) {
            console.error("pedidosData no está definido");
            return;
        }
        debugger;
        $('.pedido_seleccionado:checked').each(function () {
            let idPedido = $(this).val();
            let detalles = pedidosData[idPedido];


            debugger;
            if (detalles) {
                detalles.forEach(item => {
                    debugger;
                    let key = item.COD_PRODUCTO + '-' + item.COD_CENTRO+ '-' + item.COD_PERIODO;
                    console.log(key);
                    debugger;
                    if (!productosConsolidados[key]) {
                        productosConsolidados[key] = {
                            COD_PRODUCTO: item.COD_PRODUCTO,
                            PRODUCTO: item.NOM_PRODUCTO,
                            CANTIDAD: 0,
                            COD_MEDIDA: item.COD_UNIDAD,
                            MEDIDA: item.NOM_CATEGORIA,
                            COD_FAMILIA: item.COD_FAMILIA,
                            FAMILIA: item.NOM_CATEGORIA_FAMILIA,
                            STOCK: item.STOCK,
                            CAN_STOCK_RESERVADO: item.CAN_STOCK_RESERVADO,
                            COD_CENTRO: item.COD_CENTRO
                        };
                    }
                    productosConsolidados[key].CANTIDAD += parseFloat(item.CANTIDAD);
                });
            }
        });
        console.log();
        // Pintar tabla consolidada
        let tbody = $('#tablaConsolidado tbody');
        tbody.empty();
        $('#contenedor-detalle-producto-consolidado-general').hide();

        window.detallesPorProducto = {};

        Object.values(productosConsolidados).forEach(producto => {
            let diferencia = (parseFloat(producto.CANTIDAD) - parseFloat(producto.STOCK) + parseFloat(producto.CAN_STOCK_RESERVADO)).toFixed(2);

            window.detallesPorProducto[producto.COD_PRODUCTO] = {
                nombre: producto.PRODUCTO,
                pedidos: []
            };

            $('.pedido_seleccionado:checked').each(function () {
                let idPedido = $(this).val();
                let detalles = pedidosData[idPedido];
                if (detalles) {
                    detalles.forEach(item => {
                        if (item.COD_PRODUCTO === producto.COD_PRODUCTO) {
                            window.detallesPorProducto[producto.COD_PRODUCTO].pedidos.push({
                                fecha: item.FEC_PEDIDO,
                                pedido: item.ID_PEDIDO,
                                area: item.TXT_AREA,
                                glosa: item.TXT_GLOSA,
                                cantidad: item.CANTIDAD
                            });
                        }
                    });
                }
            });

            tbody.append(`
                <tr class="fila-producto" data-id="${producto.COD_PRODUCTO}">
                    <td>${producto.COD_PRODUCTO}</td>
                    <td>${producto.PRODUCTO}</td>
                    <td>${producto.MEDIDA}</td>
                    <td>${producto.CANTIDAD.toFixed(2)}</td>
                    <td>${producto.STOCK}</td>
                    <td>${producto.CAN_STOCK_RESERVADO}</td>
                    <td>${diferencia}</td>
                    <td>${producto.FAMILIA}</td>
                </tr>
            `);
        });
    });

    // Evento Doble Clic en la fila del Consolidado
    $(document).on('dblclick', '.fila-producto', function () {
        let codProducto = $(this).data('id');
        let data = window.detallesPorProducto[codProducto];

        if (data) {
            // Actualizar título
            $('#titulo-producto-detalle-general').text(data.nombre);

            // Referencia a la tabla inferior
            let tbodyInferior = $('#tablaDetalleInferiorGeneral tbody');
            tbodyInferior.empty();

            // Mostrar el contenedor
            $('#contenedor-detalle-producto-consolidado-general').slideDown();

            // Scroll suave hacia el detalle
            $('html, body').animate({
                scrollTop: $("#contenedor-detalle-producto-consolidado-general").offset().top
            }, 800);

            data.pedidos.forEach(p => {
                tbodyInferior.append(`
                    <tr>
                        <td class="text-center">${p.fecha}</td>
                        <td class="text-center font-bold">${p.pedido}</td>
                        <td>${p.area}</td>
                        <td class="text-muted small">${p.glosa}</td>
                        <td class="text-center font-bold" style="font-size: 1.1em;">
                            ${parseFloat(p.cantidad).toFixed(2)}
                        </td>
                    </tr>
                `);
            });
        }
    });
    // Botón Guardar Consolidado
    $(document).on('click', '.btn-guardar-consolidado', function (e) {
        e.preventDefault();

        let $boton = $(this);
        let pedidos_ids = [];

        $('.pedido_seleccionado:checked').each(function () {
            pedidos_ids.push($(this).val());
        });

        if (pedidos_ids.length === 0) {
            modalBonito({
                tipo: 'warning',
                titulo: 'Advertencia',
                mensaje: 'Debe seleccionar al menos un pedido para guardar el consolidado.'
            });
            return;
        }

        modalBonito({
            tipo: 'info',
            icono: '📝',
            titulo: 'Confirmar Guardado',
            mensaje: '¿Está seguro de guardar el consolidado de los pedidos seleccionados?',
            confirmar: true,
            onConfirm: function () {

                // 🔒 Deshabilitamos botón
                $boton.prop('disabled', true);

                // 🔒 Abrimos loader global
                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/guardar_consolidado_pedido',
                    data: {
                        _token: $('#token').val(),
                        pedidos_ids: pedidos_ids,
                        productos: Object.values(productosConsolidados)
                    },

                    success: function (resp) {

                        debugger;
                        console.log(resp);

                        if (resp.success) {

                            modalBonito({
                                tipo: 'success',
                                titulo: 'Éxito',
                                mensaje: resp.mensaje
                            });

                            // ⏳ Dejamos el loader activo
                            // 🔄 Recargamos la página
                            setTimeout(function () {
                                location.reload();
                            }, 1200);

                        } else {

                            // ❌ Solo cerramos loader si hay error
                            cerrarcargando();
                            $boton.prop('disabled', false);

                            modalBonito({
                                tipo: 'error',
                                titulo: 'Error',
                                mensaje: resp.mensaje
                            });
                        }
                    },

                    error: function (resp) {
                        debugger;
                        cerrarcargando();
                        $boton.prop('disabled', false);

                        modalBonito({
                            tipo: 'error',
                            titulo: 'Error',
                            mensaje: 'Ocurrió un error al intentar guardar el consolidado.'
                        });
                    }
                });
            }
        });
    });

    let id_consolidado_seleccionado = '';

    $(document).on('click', '.fila-consolidado-generado', function () {
        $('.fila-consolidado-generado').removeClass('background-fila-activa');
        $(this).addClass('background-fila-activa');

        id_consolidado_seleccionado = $(this).data('consolidado');

        buscarDetalleConsolidado();
    });



    function buscarDetalleConsolidado() {
        let familia_id = '';
        let _token = $('#token').val();

        // Solo buscar si ambos están presentes
        if (id_consolidado_seleccionado === '') {
            $('#lista-detalle-consolidado-container').html('');
            return;
        }

        abrircargando();

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-listar-detalle-consolidado-op',
            data: {
                _token: _token,
                id_consolidado: id_consolidado_seleccionado,
                familia_id: familia_id
            },
            success: function (html) {
                cerrarcargando();
                $('#lista-detalle-consolidado-container').html(html);
            },
            error: function (e) {
                cerrarcargando();
                console.error(e);
            }
        });
    }


    // Evento para GUARDAR las cantidades compradas editadas
    $(document).on('click', '#btn-guardar-detalle-consolidado-editado', function () {
        let detalles = [];
        let _token = $('#token').val();

        $('.fila-detalle-consolidado-generado').each(function () {
            let cod_producto = $(this).data('id');
            let cantidad = $(this).find('.input-descontar').val();
            detalles.push({
                cod_producto: cod_producto,
                cantidad: cantidad
            });
        });

        if (id_consolidado_seleccionado === '' || detalles.length === 0) {
            modalBonito({
                tipo: 'error',
                titulo: 'Error',
                mensaje: 'No hay datos para guardar.'
            });
            return;
        }

        abrircargando();

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-guardar-cantidad-comprada-op',
            data: {
                _token: _token,
                id_consolidado: id_consolidado_seleccionado,
                detalles: JSON.stringify(detalles)
            },
            success: function (res) {
                cerrarcargando();
                if (res.success) {
                    modalBonito({
                        tipo: 'success',
                        titulo: 'Éxito',
                        mensaje: res.mensaje
                    });
                    // Opcional: recargar el detalle para confirmar
                    buscarDetalleConsolidado();
                } else {
                    modalBonito({
                        tipo: 'error',
                        titulo: 'Error',
                        mensaje: res.mensaje
                    });
                }
            },
            error: function (e) {
                cerrarcargando();
                console.error(e);
                modalBonito({
                    tipo: 'error',
                    titulo: 'Error',
                    mensaje: 'Error en la petición al servidor.'
                });
            }
        });
    });

    // EVENTO PARA APROBAR EL CONSOLIDADO
    $(document).on('click', '#btn-aprobar-consolidado', function () {

        let _token = $('#token').val();
        let $boton = $(this);

        if (id_consolidado_seleccionado === '') {
            modalBonito({
                tipo: 'error',
                titulo: 'Error',
                mensaje: 'No hay un consolidado seleccionado.'
            });
            return;
        }

        modalBonito({
            tipo: 'info',
            icono: '✅',
            titulo: 'Cerrar Consolidado',
            mensaje: '¿Está seguro de <b>cerrar</b> este consolidado?',
            confirmar: true,
            onConfirm: function () {

                // 🔒 Deshabilitamos botón para evitar doble click
                $boton.prop('disabled', true);

                // 🔒 Abrimos loader global (bloquea toda la UI)
                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/ajax-aprobar-consolidado-op',
                    data: {
                        _token: _token,
                        id_consolidado: id_consolidado_seleccionado
                    },

                    success: function (res) {

                        if (res.success) {

                            modalBonito({
                                tipo: 'success',
                                icono: '✔',
                                titulo: 'Éxito',
                                mensaje: res.mensaje
                            });

                            // ⏳ Dejamos el loader activo
                            // 🔄 Recargamos sin cerrar loader
                            setTimeout(function () {
                                location.reload();
                            }, 1200);

                        } else {

                            // ❌ Solo cerramos loader si hubo error
                            cerrarcargando();
                            $boton.prop('disabled', false);

                            modalBonito({
                                tipo: 'error',
                                icono: '❌',
                                titulo: 'Error',
                                mensaje: res.mensaje
                            });
                        }
                    },

                    error: function (e) {

                        cerrarcargando();
                        $boton.prop('disabled', false);

                        console.error(e);

                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: 'Error en la petición al servidor.'
                        });
                    }
                });
            }
        });
    });
    // Evento Doble Clic en el DETALLE del Consolidado Generado
    $(document).on('dblclick', '.fila-detalle-consolidado-generado', function () {
        let cod_producto = $(this).data('id');
        let nom_producto = $(this).data('nombre');

        // La data completa viene en el atributo data-detalle (parseada desde el XML/String del backend)
        // Ejemplo de formato esperado: "FECHA [FLD] PEDIDO [FLD] AREA [FLD] GLOSA [FLD] CANTIDAD [SEP] ..."
        let detalle_string = $(this).data('detalle');
        let _token = $('#token').val();

        // Actualizar título
        $('#titulo-producto-detalle').text(nom_producto);

        // Referencia a la tabla inferior
        let tbodyInferior = $('#tablaDetalleInferior tbody');
        tbodyInferior.empty();

        // Mostrar el contenedor
        $('#contenedor-detalle-producto-consolidado').slideDown();

        // Scroll suave hacia el detalle
        $('html, body').animate({
            scrollTop: $("#contenedor-detalle-producto-consolidado").offset().top
        }, 800);

        if (detalle_string) {
            let pedidos = detalle_string.split(' [SEP] ');

            if (pedidos.length > 0 && pedidos[0] !== "") {
                pedidos.forEach(p_str => {
                    // Separador: ' [FLD] '
                    let partes = p_str.split(' [FLD] ');

                    // Aseguramos que tenga las partes mínimas
                    if (partes.length >= 2) {
                        let fecha = partes[0] ? partes[0].trim() : '';
                        let id = partes[1] ? partes[1].trim() : '';
                        let area = partes[2] ? partes[2].trim() : '';
                        let glosa = partes[3] ? partes[3].trim() : '';
                        let cantidad = partes[4] ? partes[4].trim() : "0.00";

                        // Limpieza de cantidad
                        cantidad = cantidad.replace(/[^0-9.]/g, '');
                        let cantFloat = parseFloat(cantidad);
                        if (isNaN(cantFloat)) cantFloat = 0.00;

                        tbodyInferior.append(`
                            <tr>
                                <td class="text-center">${fecha}</td>
                                <td class="text-center font-bold">${id}</td>
                                <td>${area}</td>
                                <td class="text-muted small">${glosa}</td>
                                <td class="text-center font-bold" style="font-size: 1.1em;">
                                    ${cantFloat.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                </td>
                            </tr>
                        `);
                    }
                });
            } else {
                tbodyInferior.html('<tr><td colspan="5" class="text-center">No hay detalles disponibles.</td></tr>');
            }

        } else {
            // Carga AJAX si no hay data-detalle (fallback)
            if (!id_consolidado_seleccionado || !cod_producto) return;

            tbodyInferior.html('<tr><td colspan="5" class="text-center">Cargando...</td></tr>');

            $.ajax({
                type: 'POST',
                url: carpeta + '/ajax-detalle-producto-consolidado-generado',
                data: {
                    _token: _token,
                    id_consolidado: id_consolidado_seleccionado,
                    cod_producto: cod_producto
                },
                success: function (res) {
                    if (res.success) {
                        tbodyInferior.empty();
                        if (res.detalles.length > 0) {
                            res.detalles.forEach(p => {
                                // Formatear fecha si es necesario (moment o nativo)
                                // Asumiendo que viene en formato YYYY-MM-DD
                                let fecha = p.FEC_PEDIDO;

                                tbodyInferior.append(`
                                    <tr>
                                        <td class="text-center">${fecha}</td>
                                        <td class="text-center font-bold">${p.ID_PEDIDO}</td>
                                        <td>${p.TXT_AREA}</td>
                                        <td class="text-muted small">${p.TXT_GLOSA || ''}</td>
                                        <td class="text-center font-bold" style="font-size: 1.1em;">
                                            ${parseFloat(p.CANTIDAD).toFixed(2)}
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            tbodyInferior.html('<tr><td colspan="5" class="text-center">No se encontraron registros.</td></tr>');
                        }
                    } else {
                        tbodyInferior.html(`<tr><td colspan="5" class="text-center text-danger">${res.mensaje}</td></tr>`);
                    }
                },
                error: function () {
                    tbodyInferior.html('<tr><td colspan="5" class="text-center text-danger">Error al cargar datos del servidor.</td></tr>');
                }
            });
        }
    });

    /* ===============================
       CONSOLIDAR GENERAL
       =============================== */
    $(document).on('click', '.btn-consolidar-general', function (e) {
        e.preventDefault();

        let tbody = $('#tabla_detalle_consolidado_general tbody');
        tbody.empty();
        $('#contenedor-detalle-producto-consolidado').hide();

        let seleccionados = [];
        $('.consolidado_seleccionado:checked').each(function () {
            seleccionados.push($(this));
        });

        if (seleccionados.length === 0) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Debe seleccionar',
                mensaje: 'Seleccione al menos un <b>consolidado</b> de la lista.'
            });
            return;
        }

        let totalDetalles = 0;
        let groupedProducts = {}; // 👈 AGREGADOR POR PRODUCTO

        seleccionados.forEach(function (chk) {
            let info = chk.data('detalle');

            if (typeof info === 'string') {
                try { info = JSON.parse(info); } catch (e) { console.error("Error parsing JSON", e); }
            }

            if (!Array.isArray(info)) {
                if (typeof info === 'object' && info !== null) info = Object.values(info);
                else info = [];
            }

            if (info && info.length > 0) {
                info.forEach(item => {
                    let key = item.COD_PRODUCTO;
                    if (!groupedProducts[key]) {
                        groupedProducts[key] = {
                            COD_PRODUCTO: item.COD_PRODUCTO,
                            NOM_PRODUCTO: item.NOM_PRODUCTO,
                            NOM_CATEGORIA_MEDIDA: item.NOM_CATEGORIA_MEDIDA || '',
                            NOM_CATEGORIA_FAMILIA: item.NOM_CATEGORIA_FAMILIA || '',
                            CANTIDAD: 0,
                            STOCK: 0,
                            RESERVADO: 0,
                            DIFERENCIA: 0,
                            DETALLE_POR_AREA: []
                        };
                    }

                    groupedProducts[key].CANTIDAD += parseFloat(item.CANTIDAD || 0);
                    groupedProducts[key].STOCK += parseFloat(item.STOCK || 0);
                    groupedProducts[key].RESERVADO += parseFloat(item.RESERVADO || 0);

                    if (item.DETALLE_POR_AREA) {
                        groupedProducts[key].DETALLE_POR_AREA.push(item.DETALLE_POR_AREA);
                    }
                    totalDetalles++;
                });
            }
        });

        // RENDERIZADO DE LAS FILAS AGRUPADAS
        Object.values(groupedProducts).forEach(item => {

            let sum_diff = item.CANTIDAD - item.STOCK + item.RESERVADO;
            let combinedDetalle = item.DETALLE_POR_AREA.join(' [SEP] ');

            tbody.append(`
                <tr class="fila-detalle-general" data-detalle-area="${combinedDetalle}" data-nombre="${item.NOM_PRODUCTO}">
                    <td>${item.COD_PRODUCTO}</td>
                    <td>${item.NOM_PRODUCTO}</td>
                    <td>${item.NOM_CATEGORIA_MEDIDA}</td>
                    <td class="text-center font-bold">${item.CANTIDAD.toFixed(2)}</td>
                    <td class="text-center">${item.STOCK.toFixed(2)}</td>
                    <td class="text-center">${item.RESERVADO.toFixed(2)}</td>
                    <td class="text-center">${sum_diff.toFixed(2)}</td>
                    <td>${item.NOM_CATEGORIA_FAMILIA}</td>
                </tr>
            `);
        });

        if (totalDetalles === 0) {
            tbody.append('<tr><td colspan="8" class="text-center">No se encontraron detalles.</td></tr>');
        }
    });

    /* ===============================
       DOBLE CLICK DETALLE GENERAL
       =============================== */
    $(document).on('dblclick', '.fila-detalle-general', function () {
        let detalle_string = $(this).data('detalle-area');
        let nom_producto = $(this).data('nombre');
        let tbodyInferior = $('#tablaDetalleInferior tbody');

        // Limpiar y preparar
        tbodyInferior.empty();
        $('#titulo-producto-detalle').text(nom_producto);
        $('#contenedor-detalle-producto-consolidado').slideDown();

        // Scroll suave hacia el detalle
        $('html, body').animate({
            scrollTop: $("#contenedor-detalle-producto-consolidado").offset().top
        }, 800);

        if (detalle_string) {
            // Separador de pedidos: ' [SEP] '
            let pedidos = detalle_string.split(' [SEP] ');

            if (pedidos.length > 0 && pedidos[0] !== "") {
                pedidos.forEach(p_str => {
                    // Separador de campos: ' [FLD] '
                    // Estructura esperada desde SQL:
                    // FECHA [FLD] ID_PEDIDO [FLD] AREA [FLD] GLOSA [FLD] CANTIDAD
                    let partes = p_str.split(' [FLD] ');

                    if (partes.length >= 2) {
                        let fecha = partes[0] ? partes[0].trim() : '';
                        let id = partes[1] ? partes[1].trim() : '';
                        let area = partes[2] ? partes[2].trim() : '';
                        let glosa = partes[3] ? partes[3].trim() : '-';
                        let cantidad = partes[4] ? partes[4].trim() : "0.00";
                        let centro = partes[5] ? partes[5].trim() : ''; // 🔥 Nuevo: Centro

                        // Limpieza de cantidad
                        let cantFloat = parseFloat(cantidad);
                        if (isNaN(cantFloat)) cantFloat = 0.00;

                        tbodyInferior.append(`
                            <tr>
                                <td class="text-center">${fecha}</td>
                                <td class="text-center font-bold">${id}</td>
                                <td class="text-center font-bold">${area}</td>
                                <td class="text-center font-bold">${centro}</td>
                                <td class="small">${glosa}</td>
                                <td class="text-center font-bold" style="font-size: 1.1em;">
                                    ${cantFloat.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                </td>
                            </tr>
                        `);
                    }
                });
            } else {
                tbodyInferior.html('<tr><td colspan="5" class="text-center">No hay detalles disponibles en la cadena.</td></tr>');
            }
        } else {
            tbodyInferior.html('<tr><td colspan="5" class="text-center">No hay detalles disponibles para este producto.</td></tr>');
        }
    });


    /* ===============================
       GUARDAR CONSOLIDADO GENERAL
       =============================== */
    $(".btn-guardar-consolidado-general").click(function (e) {
        e.preventDefault();

        let pedidos_ids = [];
        $('.consolidado_seleccionado:checked').each(function () {
            pedidos_ids.push($(this).val());
        });

        if (pedidos_ids.length === 0) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Debe seleccionar',
                mensaje: 'Seleccione al menos un <b>consolidado</b> para guardar.'
            });
            return;
        }

        modalBonito({
            tipo: 'info',
            icono: '💾',
            titulo: 'Guardar Consolidado General',
            mensaje: '¿Está seguro de generar el consolidado general con los ' + pedidos_ids.length + ' pedidos seleccionados?',
            confirmar: true,
            onConfirm: function () {
                abrircargando();
                $.ajax({
                    type: 'POST',
                    url: carpeta + '/guardar_consolidado_general', // Ahora es POST
                    data: {
                        _token: $('#token').val(),
                        pedidos_ids: pedidos_ids
                    },
                    success: function (resp) {
                        cerrarcargando();
                        if (resp.success) {
                            modalBonito({
                                tipo: 'success',
                                icono: '✔',
                                titulo: 'Éxito',
                                mensaje: resp.mensaje
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            modalBonito({
                                tipo: 'error',
                                icono: '❌',
                                titulo: 'Error',
                                mensaje: resp.mensaje
                            });
                        }
                    },
                    error: function (xhr) {
                        cerrarcargando();
                        let msg = 'Ocurrió un error al intentar guardar.';
                        if (xhr.responseJSON && xhr.responseJSON.mensaje) {
                            msg = xhr.responseJSON.mensaje;
                        }
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: msg
                        });
                        console.error(xhr);
                    }
                });
            }
        });
    });

    /* ===============================
       CONSOLIDADO GENERAL - SELECCIÓN Y DETALLE
       =============================== */
    let id_consolidado_general_seleccionado = '';
    let familia_id_seleccionado = '';
    $(document).on('dblclick', '.fila-consolidado-general-terminado', function () {
        $('.fila-consolidado-general-terminado').removeClass('background-fila-activa');
        $(this).addClass('background-fila-activa');

        id_consolidado_general_seleccionado = $(this).data('consolidado-general');
        familia_id_seleccionado = $(this).attr('data-familia-cod'); //$(this).data('data-familia-cod');

        debugger;

        buscarDetalleConsolidadoGeneral();
    });

    function buscarDetalleConsolidadoGeneral() {
        let familia_id = familia_id_seleccionado;
        $('#familia_id').val(familia_id);

        let _token = $('#token').val();

        if (id_consolidado_general_seleccionado === '') {
            $('#lista-detalle-consolidado-general-container').html('');
            return;
        }

        abrircargando();

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-listar-detalle-consolidado-general-op',
            data: {
                _token: _token,
                id_consolidado_general: id_consolidado_general_seleccionado,
                familia_id: familia_id
            },
            success: function (html) {
                cerrarcargando();
                $('#lista-detalle-consolidado-general-container').html(html);
            },
            error: function (e) {
                cerrarcargando();
                console.error(e);
                modalBonito({
                    tipo: 'error',
                    icono: '❌',
                    titulo: 'Error',
                    mensaje: 'Error al cargar los detalles del consolidado general.'
                });
            }
        });
    }

    // Evento para GUARDAR las cantidades compradas editadas GENERAL
    $(document).on('click', '#btn-guardar-detalle-consolidado-editado-general', function () {
        let detalles = [];
        let _token = $('#token').val();

        $('.fila-detalle-consolidado-general').each(function () {
            let cod_producto = $(this).data('id');
            let cantidad = $(this).find('.can_comprar_cant').val();
            if (cod_producto) {
                detalles.push({
                    cod_producto: cod_producto,
                    cantidad: cantidad
                });
            }
        });

        if (id_consolidado_general_seleccionado === '' || detalles.length === 0) {
            modalBonito({
                tipo: 'error',
                titulo: 'Error',
                mensaje: 'No hay datos para guardar.'
            });
            return;
        }

        abrircargando();

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-guardar-cantidad-comprada-general-op',
            data: {
                _token: _token,
                id_consolidado_general: id_consolidado_general_seleccionado,
                detalles: JSON.stringify(detalles)
            },
            success: function (res) {
                cerrarcargando();
                debugger;
                if (res.success) {
                    modalBonito({
                        tipo: 'success',
                        icono: '✔',
                        titulo: 'Éxito',
                        mensaje: res.mensaje
                    });
                    buscarDetalleConsolidadoGeneral();
                } else {
                    modalBonito({
                        tipo: 'error',
                        titulo: 'Error',
                        mensaje: res.mensaje
                    });
                }
            },
            error: function (e) {
                cerrarcargando();
                console.error(e);
                modalBonito({
                    tipo: 'error',
                    titulo: 'Error',
                    mensaje: 'Error en la petición al servidor.'
                });
            }
        });
    });

    $('a[href="#consoldadogeneralterminado"]').on('shown.bs.tab', function (e) {
        // Ajuste adicional si es necesario (por ejemplo, por responsive)
        setTimeout(function() {
            $('#lista-consolidado-general-terminado').DataTable().columns.adjust();
        }, 100);
    });

    /* ===============================
       DOBLE CLICK DETALLE CONSOLIDADO GENERAL
       =============================== */
    $(document).on('dblclick', '.fila-detalle-consolidado-general', function () {
        let detalle_string = $(this).data('detalle');
        let nom_producto = $(this).data('nombre');
        let tbodyInferior = $('#tablaDetalleInferiorGeneral tbody');
        let tableId = "#tablaDetalleInferiorGeneral";

        // ✅ 1. DESTRUIR DATATABLE EXISTENTE (si existe)
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }

        // Limpiar y preparar
        tbodyInferior.empty();
        $('#titulo-producto-detalle-general').text(nom_producto);
        $('#contenedor-detalle-producto-consolidado-general').slideDown();

        // Scroll suave hacia el detalle
        $('html, body').animate({
            scrollTop: $("#contenedor-detalle-producto-consolidado-general").offset().top
        }, 800);

        if (detalle_string) {
            // Separador de pedidos: ' [SEP] '
            let pedidos = detalle_string.split(' [SEP] ');

            if (pedidos.length > 0 && pedidos[0] !== "") {
                pedidos.forEach(p_str => {
                    // Separador de campos: ' [FLD] '
                    // Estructura esperada desde SQL:
                    // FECHA [FLD] ID_PEDIDO [FLD] AREA [FLD] GLOSA [FLD] CANTIDAD
                    let partes = p_str.split(' [FLD] ');

                    if (partes.length >= 2) {
                        let fecha = partes[0] ? partes[0].trim() : '';
                        let id = partes[1] ? partes[1].trim() : '';
                        let area = partes[2] ? partes[2].trim() : '';
                        let glosa = partes[3] ? partes[3].trim() : '-';
                        let cantidad = partes[4] ? partes[4].trim() : "0.00";
                        let centro = partes[5] ? partes[5].trim() : ''; // 🔥 Nuevo: Centro

                        // Limpieza de cantidad
                        let cantFloat = parseFloat(cantidad);
                        if (isNaN(cantFloat)) cantFloat = 0.00;

                        tbodyInferior.append(`
                            <tr>
                                <td class="text-center">${fecha}</td>
                                <td class="text-center font-bold">${id}</td>
                                <td class="text-center font-bold">${area}</td>
                                <td class="text-center font-bold">${centro}</td>
                                <td class="small">${glosa}</td>
                                <td class="text-center font-bold" style="font-size: 1.1em;">
                                    ${cantFloat.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                </td>
                            </tr>
                        `);
                    }
                });

                // ✅ 4. AHORA SÍ, INICIALIZAR DATATABLE (después de tener los datos)
                let newTable = $(tableId).DataTable({
                    responsive: true,
                    autoWidth: true,
                    lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
                    scrollX: true,
                    scrollY: "300px",
                    ordering: false,
                    pageLength: 5000,
                    destroy: false, // No es necesario porque ya destruimos manualmente
                    initComplete: function() {
                        // Ajustar columnas después de inicializar
                        this.api().columns.adjust();
                    }
                });

                // Ajuste adicional si es necesario (por ejemplo, por responsive)
                setTimeout(function() {
                    newTable.columns.adjust();
                }, 100);

            } else {
                tbodyInferior.html('<tr><td colspan="5" class="text-center">No hay detalles disponibles en la cadena.</td></tr>');
            }
        } else {
            tbodyInferior.html('<tr><td colspan="5" class="text-center">No hay detalles disponibles para este producto.</td></tr>');
        }
    });

    // EVENTO PARA APROBAR EL CONSOLIDADO GENERAL
    $(document).on('click', '#btn-aprobar-consolidado-general', function () {

        let _token = $('#token').val();
        let $boton = $(this);

        if (id_consolidado_general_seleccionado === '') {
            modalBonito({
                tipo: 'error',
                titulo: 'Error',
                mensaje: 'No hay un consolidado general seleccionado.'
            });
            return;
        }

        modalBonito({
            tipo: 'success',
            icono: '✅',
            titulo: 'Aprobar Consolidado General',
            mensaje: '¿Está seguro de <b>aprobar</b> este consolidado general?',
            confirmar: true,
            onConfirm: function () {

                // 🔒 Deshabilitamos botón para evitar doble click
                $boton.prop('disabled', true);

                // 🔒 Abrimos loader global (bloquea toda la UI)
                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/ajax-aprobar-consolidado-general-op',
                    data: {
                        _token: _token,
                        id_consolidado_general: id_consolidado_general_seleccionado
                    },

                    success: function (res) {

                        if (res.success) {

                            modalBonito({
                                tipo: 'success',
                                icono: '✔',
                                titulo: 'Éxito',
                                mensaje: res.mensaje
                            });

                            // 🔒 Mantenemos el loader activo
                            // 🔒 Bloqueamos todos los botones por seguridad
                            $('button').prop('disabled', true);

                            // 🔄 Recargamos la página
                            setTimeout(function () {
                                location.reload();
                            }, 1000);

                        } else {

                            cerrarcargando();
                            $boton.prop('disabled', false);

                            modalBonito({
                                tipo: 'error',
                                icono: '❌',
                                titulo: 'Error',
                                mensaje: res.mensaje
                            });
                        }
                    },

                    error: function (e) {

                        cerrarcargando();
                        $boton.prop('disabled', false);

                        console.error(e);

                        modalBonito({
                            tipo: 'error',
                            titulo: 'Error',
                            mensaje: 'Error en la petición al servidor.'
                        });
                    }
                });
            }
        });
    });

    // EVENTO PARA DESCARGAR EXCEL DEL DETALLE
    $(document).on('click', '#btn-descargar-excel', function (e) {
        e.preventDefault();
        if (typeof id_consolidado_general_seleccionado === 'undefined' || id_consolidado_general_seleccionado === '') {
            modalBonito({
                tipo: 'error',
                titulo: 'Error',
                mensaje: 'No hay un consolidado seleccionado.'
            });
            return;
        }

        let familia_id =  $('#familia_id').val();
        debugger;
        window.location.href = carpeta + '/descargar-excel-detalle-consolidado-general/' + id_consolidado_general_seleccionado + '/' + familia_id;
    });

    // EVENTO PARA DESCARGAR EXCEL DEL DETALLE
    $(document).on('click', '#btn-descargar-excel-area', function (e) {
        e.preventDefault();
        if (typeof id_consolidado_general_seleccionado === 'undefined' || id_consolidado_general_seleccionado === '') {
            modalBonito({
                tipo: 'error',
                titulo: 'Error',
                mensaje: 'No hay un consolidado seleccionado.'
            });
            return;
        }

        let familia_id =  $('#familia_id').val();
        debugger;
        window.location.href = carpeta + '/descargar-excel-detalle-consolidado-general-area/' + id_consolidado_general_seleccionado + '/' + familia_id;
    });

});
