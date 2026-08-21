$(document).ready(function () {
    var carpeta = $("#carpeta").val();

    /**
     * FUNCIÓN MODAL BONITO (Para mantener el estilo premium del proyecto)
     */
    function modalBonito({ tipo, icono, titulo, mensaje, ancho = '360px', confirmar = false, onConfirm = null }) {
        const colores = {
            error: ['#ff416c', '#ff4b2b'],
            warn: ['#ff416c', '#ff4b2b'],
            info: ['#4facfe', '#00f2fe'],
            success: ['#00b09b', '#96c93d']
        };

        const botonesPorTipo = {
            error: 'btn-red',
            warn: 'btn-red',
            success: 'btn-green',
            info: 'btn-blue'
        };

        const grad = colores[tipo] || colores.info;
        
        let circleStyle = '';
        let iconStyle = '';
        
        if (tipo === 'error' || tipo === 'warn') {
            circleStyle = `width:90px;height:90px;border-radius:50%;background:#ffffff;border:3px solid #ff4b2b;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;box-shadow:0 12px 25px rgba(255,75,43,0.15);`;
            iconStyle = `font-size:42px;color:#ff4b2b;`;
        } else {
            circleStyle = `width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,${grad[0]},${grad[1]});display:flex;align-items:center;justify-content:center;margin:0 auto 18px;box-shadow:0 12px 25px rgba(0,0,0,.25);`;
            iconStyle = `font-size:42px;color:white;`;
        }

        const contenido = `
            <div style="position:relative;text-align:center;padding:40px 20px 25px;">
                <div style="position:absolute;top:0;left:0;width:100%;height:10px;background:linear-gradient(135deg,${grad[0]},${grad[1]});border-radius:6px 6px 0 0;"></div>
                <div style="${circleStyle}">
                    <span style="${iconStyle}">${icono}</span>
                </div>
                <h3 style="margin:0;font-weight:600;color:#2c3e50;">${titulo}</h3>
                <p style="margin-top:12px;font-size:15px;color:#555;">${mensaje}</p>
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
                        text: 'Aceptar',
                        btnClass: botonesPorTipo[tipo] || 'btn-blue',
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
                        btnClass: botonesPorTipo[tipo] || 'btn-blue'
                    }
                }
            });
        }
    }

    // Función para buscar/listar órdenes de compra
    function buscarOrdenes() {
        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var empresa_id = $('#empresa_id').val();
        var centro_id = $('#centro_id').val();
        var tipo_compra = $('#tipo_compra').val();
        var moneda_id = $('#moneda_id').val();
        var idopcion = $('#idopcion').val();
        var _token = $('#token').val();

        if ($.trim(fecha_inicio) === '') {
            modalBonito({
                tipo: 'warn',
                icono: '📅',
                titulo: 'Campo Requerido',
                mensaje: 'Por favor, seleccione una <b>Fecha de Inicio</b>.'
            });
            return false;
        }
        if ($.trim(fecha_fin) === '') {
            modalBonito({
                tipo: 'warn',
                icono: '📅',
                titulo: 'Campo Requerido',
                mensaje: 'Por favor, seleccione una <b>Fecha de Fin</b>.'
            });
            return false;
        }

        if (typeof abrircargando === 'function') abrircargando();

        // Ocultar y vaciar el panel de detalle al realizar una nueva búsqueda
        $("#detalle-orden-compras-container").slideUp(200).html("");

        $.ajax({
            type: "POST",
            url: carpeta + "/ajax-listar-orden-compras",
            data: {
                _token: _token,
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                empresa_id: empresa_id,
                centro_id: centro_id,
                tipo_compra: tipo_compra,
                moneda_id: moneda_id,
                idopcion: idopcion
            },
            success: function (resp) {
                if (typeof cerrarcargando === 'function') cerrarcargando();
                $(".listajax").html(resp);
            },
            error: function (xhr) {
                if (typeof cerrarcargando === 'function') cerrarcargando();
                modalBonito({
                    tipo: 'error',
                    icono: '❌',
                    titulo: 'Error',
                    mensaje: 'Ocurrió un error al buscar las órdenes de compra.'
                });
            }
        });
    }

    // Búsqueda sólo se ejecuta al hacer clic en el botón de búsqueda

    // Evento de búsqueda al hacer clic en el botón Buscar
    $(document).on('click', '.buscarpedidoresumen', function (e) {
        e.preventDefault();
        buscarOrdenes();
    });

    // Acción de Cargar Detalle de la Orden de Compra en la parte inferior
    $(document).on('click', '.btn-ver-detalle', function (e) {
        e.preventDefault();
        var cod_orden = $(this).data('codorden');
        var idopcion = $('#idopcion').val();
        var _token = $('#token').val();

        if (typeof abrircargando === 'function') abrircargando();

        $.ajax({
            type: "POST",
            url: carpeta + "/ajax-cargar-detalle-orden-compra",
            data: {
                _token: _token,
                cod_orden: cod_orden,
                idopcion: idopcion
            },
            success: function (resp) {
                if (typeof cerrarcargando === 'function') cerrarcargando();
                $("#detalle-orden-compras-container").html(resp).slideDown(300);
                
                // Scroll suave al contenedor del detalle
                $('html, body').animate({
                    scrollTop: $("#detalle-orden-compras-container").offset().top - 20
                }, 500);
            },
            error: function (xhr) {
                if (typeof cerrarcargando === 'function') cerrarcargando();
                modalBonito({
                    tipo: 'error',
                    icono: '❌',
                    titulo: 'Error',
                    mensaje: 'Ocurrió un error al cargar el detalle de la orden de compra.'
                });
            }
        });
    });

    // Acción de Ocultar/Cerrar el Detalle
    $(document).on('click', '.btn-cerrar-detalle', function (e) {
        e.preventDefault();
        $("#detalle-orden-compras-container").slideUp(300, function() {
            $(this).html("");
        });
    });

    // Acción de Aprobar Orden de Compra (desde el detalle)
    $(document).on('click', '.btn-aprobar-oc', function (e) {
        e.preventDefault();
        var cod_orden = $(this).data('codorden');
        var _token = $('#token').val();

        modalBonito({
            tipo: 'info',
            icono: '✔',
            titulo: 'Confirmar Aprobación',
            mensaje: '¿Está seguro de <b>APROBAR</b> la Orden de Compra <b>' + cod_orden + '</b>?',
            confirmar: true,
            onConfirm: function () {
                if (typeof abrircargando === 'function') abrircargando();

                $.ajax({
                    type: "POST",
                    url: carpeta + "/ajax-aprobar-orden-compra",
                    data: {
                        _token: _token,
                        cod_orden: cod_orden
                    },
                    success: function (resp) {
                        if (typeof cerrarcargando === 'function') cerrarcargando();
                        if (resp.success) {
                            modalBonito({
                                tipo: 'success',
                                icono: '✔',
                                titulo: '¡Aprobada!',
                                mensaje: resp.mensaje
                            });
                            // Ocultar y limpiar el panel de detalle
                            $("#detalle-orden-compras-container").slideUp(200).html("");
                            // Recargar listado principal
                            buscarOrdenes();
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
                        if (typeof cerrarcargando === 'function') cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error de servidor',
                            mensaje: 'Ocurrió un error al intentar aprobar la orden.'
                        });
                    }
                });
            }
        });
    });

    // Acción de Rechazar Orden de Compra (desde el detalle)
    $(document).on('click', '.btn-rechazar-oc', function (e) {
        e.preventDefault();
        var cod_orden = $(this).data('codorden');
        var _token = $('#token').val();

        modalBonito({
            tipo: 'warn',
            icono: '❌',
            titulo: 'Confirmar Rechazo',
            mensaje: '¿Está seguro de <b>RECHAZAR</b> la Orden de Compra <b>' + cod_orden + '</b>?',
            confirmar: true,
            onConfirm: function () {
                if (typeof abrircargando === 'function') abrircargando();

                $.ajax({
                    type: "POST",
                    url: carpeta + "/ajax-rechazar-orden-compra",
                    data: {
                        _token: _token,
                        cod_orden: cod_orden
                    },
                    success: function (resp) {
                        if (typeof cerrarcargando === 'function') cerrarcargando();
                        if (resp.success) {
                            modalBonito({
                                tipo: 'success',
                                icono: '✔',
                                titulo: '¡Rechazada!',
                                mensaje: resp.mensaje
                            });
                            // Ocultar y limpiar el panel de detalle
                            $("#detalle-orden-compras-container").slideUp(200).html("");
                            // Recargar listado principal
                            buscarOrdenes();
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
                        if (typeof cerrarcargando === 'function') cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error de servidor',
                            mensaje: 'Ocurrió un error al intentar rechazar la orden.'
                        });
                    }
                });
            }
        });
    });
});
