$(document).ready(function () {
    var carpeta = $("#carpeta").val();

    /* ===============================
       MODAL BONITO
       =============================== */
    function modalBonito({ tipo, icono, titulo, mensaje, ancho = '380px', confirmar = false, onConfirm = null }) {
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
            <div style="position:relative;text-align:center;padding:35px 20px 20px;">
                <div style="
                    position:absolute;top:0;left:0;
                    width:100%;height:8px;
                    background:linear-gradient(135deg,${grad[0]},${grad[1]});
                    border-radius:6px 6px 0 0;">
                </div>

                <div style="
                    width:75px;height:75px;
                    border-radius:50%;
                    background:linear-gradient(135deg,${grad[0]},${grad[1]});
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    margin:0 auto 15px;
                    box-shadow:0 10px 20px rgba(0,0,0,.15);">
                    <span style="font-size:36px;color:white;">${icono}</span>
                </div>

                <h3 style="margin:0 0 10px;font-weight:700;color:#2c3e50;font-size:18px;">
                    ${titulo}
                </h3>

                <div style="margin-top:10px;font-size:14px;color:#555;text-align:left;">
                    ${mensaje}
                </div>
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
                        text: 'Confirmar',
                        btnClass: 'btn-blue',
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
                        text: 'Aceptar',
                        btnClass: claseBoton
                    }
                }
            });
        }
    }

    /* ==============================================================
       1. VER DETALLE DE LA ORDEN DE PEDIDO (MANTENIMIENTO)
       ============================================================== */
    $(".ordenpedidoprincipal").on('click', '.ver-detalle-pedido-man', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();

        // Mostrar tab de detalle y cambiar foco
        $('#tab-detalle-pedido-man').show();
        $('.nav-tabs a[href="#detallepedidoman"]').tab('show');

        // Estado cargando
        $("#detalle-pedido-man-container").html(`
            <div class="text-center" style="padding: 80px 0;">
                <i class="fa fa-spinner fa-spin fa-3x text-primary" style="margin-bottom: 15px;"></i>
                <p class="text-muted fw-bold" style="font-size: 15px;">Cargando detalle del pedido ${orden_pedido_id}...</p>
            </div>
        `);

        // Desplazamiento suave hacia arriba
        $('html, body').animate({ scrollTop: 0 }, 'fast');

        $.ajax({
            type: 'POST',
            url: carpeta + "/ver_detalle_orden_pedido_man",
            data: {
                _token: _token,
                orden_pedido_id: orden_pedido_id
            },
            success: function (html) {
                $("#detalle-pedido-man-container").html(html);
            },
            error: function () {
                $('#tab-detalle-pedido-man').hide();
                $('.nav-tabs a[href="#ordenpedidoautorizaman"]').tab('show');
                modalBonito({
                    tipo: 'error',
                    icono: '❌',
                    titulo: 'Error',
                    mensaje: 'No se pudo cargar el detalle del pedido.'
                });
            }
        });
    });

    /* ==============================================================
       2. RECALCULAR SUBTOTAL Y TOTAL GENERAL AL CAMBIAR CANTIDAD
       ============================================================== */
    $(document).on('input', '.input-cantidad-man-val', function () {
        let fila = $(this).closest('tr');
        let cantidad = parseFloat($(this).val()) || 0;
        let precio = parseFloat($(this).data('precio')) || 0;
        let subtotal = cantidad * precio;

        fila.find('.cell-subtotal').text('S/ ' + subtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

        let totalGeneral = 0;
        $('#tabla-detalle-tab-man tbody tr').each(function () {
            let inputCant = $(this).find('.input-cantidad-man-val');
            let cant = inputCant.length ? (parseFloat(inputCant.val()) || 0) : 0;
            let prec = inputCant.length ? (parseFloat(inputCant.data('precio')) || 0) : 0;
            totalGeneral += (cant * prec);
        });

        $('.total-general-man').text('S/ ' + totalGeneral.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    });

    /* ==============================================================
       3. EDITAR CANTIDADES (JEFE DE MANTENIMIENTO)
       ============================================================== */
    $(".ordenpedidoprincipal").on('click', '.btn-editar-cantidades-man', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();
        let cantidades = [];

        $(".input-cantidad-man-val").each(function () {
            cantidades.push({
                cod_producto: $(this).data('prod'),
                cantidad: $(this).val()
            });
        });

        modalBonito({
            tipo: 'info',
            icono: '📝',
            titulo: 'Guardar Cantidades',
            mensaje: '¿Está seguro de actualizar las cantidades autorizadas para esta orden de pedido?',
            confirmar: true,
            onConfirm: function () {
                if (typeof abrircargando === 'function') abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/guardar_editar_detalle_pedido_man',
                    data: {
                        _token: _token,
                        orden_pedido_id: orden_pedido_id,
                        cantidades: cantidades
                    },
                    success: function (resp) {
                        if (typeof cerrarcargando === 'function') cerrarcargando();
                        if (resp.success) {
                            modalBonito({
                                tipo: 'success',
                                icono: '✔',
                                titulo: 'Éxito',
                                mensaje: resp.mensaje || 'Cantidades actualizadas correctamente.'
                            });
                        } else {
                            modalBonito({
                                tipo: 'error',
                                icono: '❌',
                                titulo: 'Error al Guardar',
                                mensaje: resp.mensaje
                            });
                        }
                    },
                    error: function () {
                        if (typeof cerrarcargando === 'function') cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: 'Ocurrió un error al intentar guardar los cambios.'
                        });
                    }
                });
            }
        });
    });

    /* ==============================================================
       4. AUTORIZAR ORDEN DE PEDIDO (JEFE DE MANTENIMIENTO)
       ============================================================== */
    $(".ordenpedidoprincipal").on('click', '.autorizar-pedido-man', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();
        let cantidades = [];

        $(".input-cantidad-man-val").each(function () {
            cantidades.push({
                cod_producto: $(this).data('prod'),
                cantidad: $(this).val()
            });
        });

        modalBonito({
            tipo: 'info',
            icono: '✅',
            titulo: 'Autorizar Pedido',
            mensaje: '¿Está seguro de <b>autorizar</b> esta Orden de Pedido como <b>Jefe de Mantenimiento</b>?<br><small class="text-muted">El pedido pasará a la siguiente etapa de aprobación por el Jefe de Área.</small>',
            confirmar: true,
            onConfirm: function () {
                if (typeof abrircargando === 'function') abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/autorizar_orden_pedido_man',
                    data: {
                        _token: _token,
                        orden_pedido_id: orden_pedido_id,
                        cantidades: cantidades
                    },
                    success: function (resp) {
                        if (typeof cerrarcargando === 'function') cerrarcargando();

                        if (resp.success) {
                            modalBonito({
                                tipo: 'success',
                                icono: '✔',
                                titulo: 'Pedido Autorizado',
                                mensaje: 'La Orden de Pedido fue autorizada correctamente por el Jefe de Mantenimiento.'
                            });

                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            modalBonito({
                                tipo: 'error',
                                icono: '❌',
                                titulo: 'Error',
                                mensaje: resp.mensaje || 'No se pudo autorizar el pedido.'
                            });
                        }
                    },
                    error: function () {
                        if (typeof cerrarcargando === 'function') cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: 'Ocurrió un error inesperado al autorizar el pedido.'
                        });
                    }
                });
            }
        });
    });

    /* ==============================================================
       5. RECHAZAR ORDEN DE PEDIDO (JEFE DE MANTENIMIENTO)
       ============================================================== */
    $(".ordenpedidoprincipal").on('click', '.rechazar-pedido-man', function (e) {
        e.preventDefault();

        let orden_pedido_id = $(this).data('id');
        let _token = $('#token').val();

        modalBonito({
            tipo: 'error',
            icono: '❌',
            titulo: 'Rechazar Pedido',
            ancho: '420px',
            mensaje: '¿Está seguro de <b>rechazar</b> esta Orden de Pedido como <b>Jefe de Mantenimiento</b>?<br><br>' +
                '<div class="form-group" style="text-align:left;">' +
                '<label style="color:#d9534f;font-weight:700;font-size:13px;">Motivo del rechazo:</label>' +
                '<textarea id="motivo_rechazo_man" class="form-control" rows="3" placeholder="Escriba aquí el motivo por el cual rechaza el pedido..." style="border:1px solid #d9534f;border-radius:6px;resize:vertical;"></textarea>' +
                '</div>',
            confirmar: true,
            onConfirm: function () {
                let motivo = $('#motivo_rechazo_man').val();
                if (!motivo || motivo.trim() === "") {
                    if (typeof alerterrorajax === 'function') {
                        alerterrorajax("Debe ingresar un motivo de rechazo.");
                    } else {
                        alert("Debe ingresar un motivo de rechazo.");
                    }
                    return false;
                }

                if (typeof abrircargando === 'function') abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/rechazar_orden_pedido_man',
                    data: {
                        _token: _token,
                        orden_pedido_id: orden_pedido_id,
                        motivo: motivo
                    },
                    success: function (resp) {
                        if (typeof cerrarcargando === 'function') cerrarcargando();

                        if (resp.success) {
                            modalBonito({
                                tipo: 'success',
                                icono: '✔',
                                titulo: 'Pedido Rechazado',
                                mensaje: 'La Orden de Pedido fue rechazada correctamente.'
                            });

                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            modalBonito({
                                tipo: 'error',
                                icono: '❌',
                                titulo: 'Error',
                                mensaje: resp.mensaje || 'No se pudo rechazar el pedido.'
                            });
                        }
                    },
                    error: function () {
                        if (typeof cerrarcargando === 'function') cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: 'Ocurrió un error inesperado al rechazar el pedido.'
                        });
                    }
                });
            }
        });
    });

});
