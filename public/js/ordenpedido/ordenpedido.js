$(document).ready(function () {

    /* ===============================
       VARIABLES GENERALES
       =============================== */

    var carpeta = $("#carpeta").val();
    let filaCount = 0;

    /* ===============================
       FUNCIÓN MODAL BONITO (ÚNICA)
       =============================== */

    function modalBonito({ tipo, icono, titulo, mensaje, ancho = '360px', confirmar = false, onConfirm = null }) {

        const colores = {
            error:   ['#ff416c', '#ff4b2b'],
            warn:    ['#f7971e', '#ffd200'],
            info:    ['#4facfe', '#00f2fe'],
            success: ['#00b09b', '#96c93d']
        };

        const botonesPorTipo = {
            error:   'btn-red',
            warn:    'btn-orange',
            success: 'btn-green',
            info:    'btn-blue'
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

    $(".ordenpedidoprincipal").on('click', '#asignarordenpedido', function (e) {
        e.preventDefault();
        abrircargando();

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
        let orden_pedido_id = $('#orden_pedido_id').val();

        let opcion = !orden_pedido_id ? 'I' : 'U';

        function errorCampo(mensaje) {
        cerrarcargando();
        modalBonito({
                tipo: 'error',
                icono: '❌',
                titulo: 'Campos obligatorios',
                mensaje: mensaje
            });
        }

        if (!cod_anio) {
            errorCampo('Debe seleccionar:<br><b>Año</b>');
            return;
        }

        if (!cod_periodo) {
            errorCampo('Debe seleccionar:<br><b>Mes</b>');
            return;
        }

        if (!cod_tipo_pedido) {
            errorCampo('Debe seleccionar:<br><b>Tipo Pedido</b>');
            return;
        }

        if (!cod_trabajador_autoriza) {
            errorCampo('Debe seleccionar:<br><b>Usuario Autoriza</b>');
            return;
        }

        if (!cod_trabajador_aprueba_ger) {
            errorCampo('Debe seleccionar:<br><b>Usuario Aprueba Gerencia</b>');
            return;
        }

        if (!cod_trabajador_aprueba_adm) {
            errorCampo('Debe seleccionar:<br><b>Usuario Aprueba Administración</b>');
            return;
        }

        if (!txt_glosa) {
            errorCampo('Debe completar:<br><b>Observación</b>');
            return;
        }


       
        /* ARMAR DETALLE */
        let detalles = [];
        $('#tabla_detalle_pedido tbody tr').each(function () {
            let tds = $(this).find('td');
            detalles.push({
                cod_producto: tds.eq(1).text().trim(),
                nom_producto: tds.eq(2).text().trim(),
                cod_categoria: tds.eq(3).text().trim(),
                nom_categoria: tds.eq(4).text().trim(),
                cantidad: parseInt(tds.eq(5).text().trim()) || 0,
                txt_observacion: tds.eq(6).text().trim(),
                opcion_detalle: 'I',
                detalle_id: null
            });
        });

        if (detalles.length === 0) {
            cerrarcargando();
            modalBonito({
                tipo: 'warn',
                icono: '🛒',
                titulo: 'No hay productos',
                mensaje: 'Debe agregar al menos <b>un producto</b> para guardar la Orden de Pedido.'
            });
            return;
        }

        cerrarcargando();

        /* CONFIRMAR */
        modalBonito({
            tipo: 'info',
            icono: '📝',
            titulo: 'Confirmar registro',
            mensaje: '¿Deseas guardar la <b>Orden de Pedido</b>?<br>Esta acción no se puede deshacer.',
            confirmar: true,
            onConfirm: function () {
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
                        orden_pedido_id,
                        opcion,
                        array_detalle: detalles
                    },
                    success: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'success',
                            icono: '✔',
                            titulo: 'Operación exitosa',
                            mensaje: 'La Orden de Pedido fue registrada correctamente.'
                        });
                        location.reload();
                    }
                });
            }
        });
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
                <td>${txt_observacion}</td>
            </tr>
        `);

        $('#cod_producto').val('').trigger('change');
        $('#cod_categoria').val('');
        $('#nom_categoria').val('');
        $('#cantidad').val('');
        $('#txt_observacion').val('');
    });


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
    });


    $(".ordenpedidoprincipal").on('click', '.ver-detalle-pedido', function(e) {
        e.preventDefault(); 

        let orden_pedido_id = $(this).data('id'); 

        var _token = $('#token').val();

        let data = {
            _token: _token,
            orden_pedido_id: orden_pedido_id,
        };

        // Limpiar contenido previo
        $("#modal-verdetallepedido-solicitud-container").html('');

        ajax_modal(
            data, 
            "/ver_detalle_orden_pedido",
            "modal-verdetallepedido-solicitud",
            "modal-verdetallepedido-solicitud-container"
        );
    });

    $('#cod_producto').on('change', function () {
        let option = $(this).find(':selected');

        let unidad = option.data('unidad') || '';

        $('#unidad').val(unidad);
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

});
