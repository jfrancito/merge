$(document).ready(function () {
    var carpeta = $("#carpeta").val();

    /**
     * FUNCIÓN MODAL BONITO (Para mantener el estilo premium del proyecto)
     */
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
        const contenido = `
            <div style="position:relative;text-align:center;padding:40px 20px 25px;">
                <div style="position:absolute;top:0;left:0;width:100%;height:10px;background:linear-gradient(135deg,${grad[0]},${grad[1]});border-radius:6px 6px 0 0;"></div>
                <div style="width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,${grad[0]},${grad[1]});display:flex;align-items:center;justify-content:center;margin:0 auto 18px;box-shadow:0 12px 25px rgba(0,0,0,.25);">
                    <span style="font-size:42px;color:white;">${icono}</span>
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
                        text: 'Actualizar',
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
                        text: 'OK',
                        btnClass: botonesPorTipo[tipo] || 'btn-blue'
                    }
                }
            });
        }
    }

    /**
     * Doble clic en una fila de la tabla para cargar los datos en los combos superiores.
     */
    $(document).on('dblclick', '.fila-monto', function () {
        const codarea = $(this).data('codarea');
        const monto = $(this).data('monto');

        if (codarea) {
            // Seteamos el valor en el select2 y disparamos el evento change para que se refresque visualmente
            $('#nombre_config').val(codarea).trigger('change');
            // Seteamos el monto
            $('#monto').val(monto);

            // Resaltar la fila seleccionada
            $('.fila-monto').removeClass('fila-monto-activa');
            $(this).addClass('fila-monto-activa');
        }
    });

    /**
     * Acción del botón Modificar
     */
    $('#btn_modificar_monto').on('click', function (e) {
        e.preventDefault();

        const cod_area = $('#nombre_config').val();
        const monto = $('#monto').val();
        const _token = $('#token').val();

        if (!cod_area) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Selección requerida',
                mensaje: 'Debe seleccionar un <b>Área / Configuración</b>.'
            });
            return;
        }

        if (monto === "" || monto < 0) {
            modalBonito({
                tipo: 'warn',
                icono: '💰',
                titulo: 'Monto inválido',
                mensaje: 'Ingrese un <b>monto válido</b> (entero positivo).'
            });
            return;
        }

        modalBonito({
            tipo: 'info',
            icono: '📝',
            titulo: 'Confirmar cambio',
            mensaje: '¿Deseas actualizar el monto para esta área?',
            confirmar: true,
            onConfirm: function () {

                if (typeof abrircargando === 'function') abrircargando();

                $.ajax({
                    type: "POST",
                    url: carpeta + "/modificar-monto-orden-pedido",
                    data: {
                        _token: _token,
                        cod_area: cod_area,
                        monto: monto
                    },
                    success: function (resp) {
                        if (typeof cerrarcargando === 'function') cerrarcargando();

                        if (resp.success) {
                            modalBonito({
                                tipo: 'success',
                                icono: '✔',
                                titulo: '¡Éxito!',
                                mensaje: resp.mensaje
                            });
                            setTimeout(() => {
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
                        if (typeof cerrarcargando === 'function') cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error de servidor',
                            mensaje: 'Ocurrió un error inesperado al procesar la solicitud.'
                        });
                    }
                });
            }
        });
    });
});
