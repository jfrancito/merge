// Función global para que sea accesible desde onclick y desde cualquier listener
function buscarCotizacionesSinOC() {
    var carpeta = $("#carpeta").val();
    if (!carpeta || carpeta === 'undefined' || carpeta === '') {
        carpeta = '/merge';
    }

    var fecha_inicio = $('#fecha_inicio').val();
    var fecha_fin = $('#fecha_fin').val();
    var cod_centro = $('#cod_centro').val();
    var idopcion = $('#idopcion').val();
    var _token = $('#token').val();

    if (!fecha_inicio || $.trim(fecha_inicio) === '') {
        if (typeof $.alert === 'function') {
            $.alert({
                title: 'Validación',
                content: 'Por favor, ingrese una <b>Fecha de Inicio</b> válida.',
                type: 'orange'
            });
        } else {
            alert('Por favor, ingrese una Fecha de Inicio válida.');
        }
        return false;
    }

    if (!fecha_fin || $.trim(fecha_fin) === '') {
        if (typeof $.alert === 'function') {
            $.alert({
                title: 'Validación',
                content: 'Por favor, ingrese una <b>Fecha Fin</b> válida.',
                type: 'orange'
            });
        } else {
            alert('Por favor, ingrese una Fecha Fin válida.');
        }
        return false;
    }

    // Animación de estado en el botón
    var $btn = $('#btnBuscarCotizaciones');
    var textoOriginal = '<i class="fa fa-search" style="color:#ffffff !important;"></i> BUSCAR COTIZACIONES';
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin" style="color:#ffffff !important;"></i> BUSCANDO...');

    // Mostrar estado de carga en el contenedor
    $('#contenedor-resultado-cotizaciones').html(
        '<div class="text-center" style="padding: 70px 20px;">' +
            '<i class="fa fa-spinner fa-spin fa-3x" style="color: #2563eb; margin-bottom: 15px;"></i>' +
            '<h4 style="color: #1e293b; font-weight: 600;">Consultando cotizaciones sin orden de compra...</h4>' +
            '<p style="color: #64748b; font-size: 13px;">Por favor espere un momento mientras procesamos la información.</p>' +
        '</div>'
    );

    if (typeof abrircargando === 'function') {
        abrircargando();
    }

    $.ajax({
        type: "POST",
        url: carpeta + "/ajax-buscar-cotizaciones-sin-oc",
        data: {
            _token: _token,
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin,
            cod_centro: cod_centro,
            idopcion: idopcion
        },
        success: function (resp) {
            if (typeof cerrarcargando === 'function') cerrarcargando();
            $btn.prop('disabled', false).html(textoOriginal);
            $("#contenedor-resultado-cotizaciones").html(resp);
        },
        error: function (xhr) {
            if (typeof cerrarcargando === 'function') cerrarcargando();
            $btn.prop('disabled', false).html(textoOriginal);

            var msg = 'Ocurrió un error al consultar las cotizaciones.';
            if (xhr.responseJSON && xhr.responseJSON.mensaje) {
                msg = xhr.responseJSON.mensaje;
            }

            $('#contenedor-resultado-cotizaciones').html(
                '<div class="text-center" style="padding: 50px 20px; color: #dc2626;">' +
                    '<i class="fa fa-exclamation-triangle fa-3x" style="margin-bottom: 15px;"></i>' +
                    '<h4 style="font-weight: 700;">Error al obtener resultados</h4>' +
                    '<p style="color: #64748b; font-size: 13px;">' + msg + '</p>' +
                '</div>'
            );

            if (typeof $.alert === 'function') {
                $.alert({
                    title: 'Error',
                    content: msg,
                    type: 'red'
                });
            } else {
                alert(msg);
            }
        }
    });
}

// Vinculación en document ready
$(document).ready(function () {
    $(document).on('click', '#btnBuscarCotizaciones, .btn-modern-search', function (e) {
        e.preventDefault();
        buscarCotizacionesSinOC();
    });

    // Abrir Modal de Asociación de OC
    $(document).on('click', '.btn-asociar-oc', function (e) {
        e.preventDefault();
        var id_cotizacion = $(this).data('id');
        var carpeta = $("#carpeta").val();
        if (!carpeta || carpeta === 'undefined' || carpeta === '') {
            carpeta = '/merge';
        }
        var _token = $('#token').val();

        $('#modal-asociar-oc-contenido').html(
            '<div class="text-center" style="padding: 60px 20px;">' +
                '<i class="fa fa-spinner fa-spin fa-3x" style="color: #2563eb; margin-bottom: 15px;"></i>' +
                '<h4 style="color: #1e293b; font-weight: 600;">Cargando Órdenes de Compra disponibles...</h4>' +
                '<p style="color: #64748b; font-size: 13px;">Buscando coincidencias para la empresa y el centro de la cotización.</p>' +
            '</div>'
        );
        $('#modalAsociarOC').modal('show');

        $.ajax({
            type: "POST",
            url: carpeta + "/ajax-modal-asociar-oc",
            data: {
                _token: _token,
                id_cotizacion: id_cotizacion
            },
            success: function (resp) {
                $('#modal-asociar-oc-contenido').html(resp);
            },
            error: function (xhr) {
                var msg = 'Ocurrió un error al cargar las órdenes de compra.';
                if (xhr.responseJSON && xhr.responseJSON.mensaje) {
                    msg = xhr.responseJSON.mensaje;
                }
                $('#modal-asociar-oc-contenido').html(
                    '<div class="text-center" style="padding: 40px 20px; color: #dc2626;">' +
                        '<i class="fa fa-exclamation-triangle fa-3x" style="margin-bottom: 12px;"></i>' +
                        '<h4 style="font-weight: 700;">Error</h4>' +
                        '<p style="color: #64748b; font-size: 13px;">' + msg + '</p>' +
                        '<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 15px;">Cerrar</button>' +
                    '</div>'
                );
            }
        });
    });

    // Confirmar e interactuar con la asociación
    $(document).on('click', '.btn-confirmar-asociar-oc', function (e) {
        e.preventDefault();
        var $btn = $(this);
        var id_cotizacion = $btn.data('cotizacion');
        var cod_orden = $btn.data('orden');
        var carpeta = $("#carpeta").val();
        if (!carpeta || carpeta === 'undefined' || carpeta === '') {
            carpeta = '/merge';
        }
        var _token = $('#token').val();

        function ejecutarAsociacion() {
            var btnHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

            if (typeof abrircargando === 'function') {
                abrircargando('Asociando cotización con orden de compra...');
            }

            $.ajax({
                type: "POST",
                url: carpeta + "/ajax-guardar-asociacion-cot-oc",
                data: {
                    _token: _token,
                    id_cotizacion: id_cotizacion,
                    cod_orden: cod_orden
                },
                success: function (resp) {
                    if (typeof cerrarcargando === 'function') cerrarcargando();
                    $('#modalAsociarOC').modal('hide');

                    if (typeof $.alert === 'function') {
                        $.alert({
                            title: '¡Operación Exitosa!',
                            icon: 'fa fa-check-circle',
                            theme: 'modern',
                            type: 'green',
                            animation: 'scale',
                            closeAnimation: 'scale',
                            backgroundDismiss: true,
                            columnClass: 'col-md-5 col-md-offset-4 col-sm-7 col-sm-offset-3 col-xs-12',
                            onOpenBefore: function () {
                                $('.jconfirm-bg').css({
                                    'backdrop-filter': 'blur(5px)',
                                    '-webkit-backdrop-filter': 'blur(5px)',
                                    'opacity': '0.75'
                                });
                            },
                            content: '' +
                                '<div style="padding: 10px 0 5px; text-align: center;">' +
                                    '<div style="width: 58px; height: 58px; background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">' +
                                        '<i class="fa fa-check fa-2x" style="color: #059669;"></i>' +
                                    '</div>' +
                                    '<h4 style="color: #0f172a; font-weight: 700; margin-top: 0; margin-bottom: 8px; font-size: 16px;">' +
                                        'Vinculación Completada' +
                                    '</h4>' +
                                    '<p style="color: #475569; font-size: 13.5px; line-height: 1.5; margin-bottom: 15px;">' +
                                        (resp.mensaje || 'La cotización se asoció exitosamente con la orden de compra.') +
                                    '</p>' +
                                    '<div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 10px 14px; font-size: 12px; color: #64748b;">' +
                                        '<i class="fa fa-refresh mr-1 text-primary"></i> La lista de cotizaciones se actualizará automáticamente.' +
                                    '</div>' +
                                '</div>',
                            buttons: {
                                ok: {
                                    text: '<i class="fa fa-check mr-1"></i> Aceptar',
                                    btnClass: 'btn-green',
                                    action: function () {
                                        buscarCotizacionesSinOC();
                                    }
                                }
                            }
                        });
                    } else {
                        alert(resp.mensaje || 'Asociación realizada correctamente.');
                        buscarCotizacionesSinOC();
                    }
                },
                error: function (xhr) {
                    if (typeof cerrarcargando === 'function') cerrarcargando();
                    $btn.prop('disabled', false).html(btnHtml);

                    var msg = 'Ocurrió un error al guardar la asociación.';
                    if (xhr.responseJSON && xhr.responseJSON.mensaje) {
                        msg = xhr.responseJSON.mensaje;
                    }

                    if (typeof $.alert === 'function') {
                        $.alert({
                            title: 'Error de Asociación',
                            icon: 'fa fa-exclamation-triangle',
                            theme: 'modern',
                            type: 'red',
                            animation: 'scale',
                            closeAnimation: 'scale',
                            columnClass: 'col-md-5 col-md-offset-4 col-sm-7 col-sm-offset-3 col-xs-12',
                            onOpenBefore: function () {
                                $('.jconfirm-bg').css({
                                    'backdrop-filter': 'blur(5px)',
                                    '-webkit-backdrop-filter': 'blur(5px)',
                                    'opacity': '0.75'
                                });
                            },
                            content: '' +
                                '<div style="padding: 10px 0 5px; text-align: center;">' +
                                    '<div style="width: 58px; height: 58px; background: #fef2f2; border: 2px solid #fecaca; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">' +
                                        '<i class="fa fa-times fa-2x" style="color: #dc2626;"></i>' +
                                    '</div>' +
                                    '<h4 style="color: #0f172a; font-weight: 700; margin-top: 0; margin-bottom: 8px; font-size: 16px;">' +
                                        'No se pudo completar la asociación' +
                                    '</h4>' +
                                    '<p style="color: #475569; font-size: 13.5px; line-height: 1.5; margin-bottom: 0;">' +
                                        msg +
                                    '</p>' +
                                '</div>',
                            buttons: {
                                ok: {
                                    text: 'Entendido',
                                    btnClass: 'btn-red'
                                }
                            }
                        });
                    } else {
                        alert(msg);
                    }
                }
            });
        }

        if (typeof $.confirm === 'function') {
            $.confirm({
                title: '¿Confirmar Asociación?',
                icon: 'fa fa-link',
                theme: 'modern',
                type: 'blue',
                animation: 'scale',
                closeAnimation: 'scale',
                backgroundDismiss: false,
                columnClass: 'col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12',
                onOpenBefore: function () {
                    $('.jconfirm-bg').css({
                        'backdrop-filter': 'blur(5px)',
                        '-webkit-backdrop-filter': 'blur(5px)',
                        'opacity': '0.75'
                    });
                },
                content: '' +
                    '<div style="padding: 10px 0 5px;">' +
                        '<p style="color: #475569; font-size: 14px; margin-bottom: 18px; line-height: 1.5;">' +
                            '¿Está seguro de vincular la cotización seleccionada con la siguiente orden de compra?' +
                        '</p>' +
                        '<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-around; gap: 10px;">' +
                            '<div style="text-align: center;">' +
                                '<span style="display: block; font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 4px;">Cotización</span>' +
                                '<span class="badge" style="background: #eff6ff; color: #1d4ed8; font-weight: 700; font-size: 13px; border: 1px solid #bfdbfe; padding: 6px 12px; border-radius: 8px;">' +
                                    '<i class="fa fa-hashtag mr-1"></i>' + id_cotizacion +
                                '</span>' +
                            '</div>' +
                            '<div style="color: #94a3b8; font-size: 18px;">' +
                                '<i class="fa fa-arrow-right"></i>' +
                            '</div>' +
                            '<div style="text-align: center;">' +
                                '<span style="display: block; font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 4px;">Orden Compra</span>' +
                                '<span class="badge" style="background: #f0fdf4; color: #15803d; font-weight: 700; font-size: 13px; border: 1px solid #bbf7d0; padding: 6px 12px; border-radius: 8px;">' +
                                    '<i class="fa fa-file-text-o mr-1"></i>' + cod_orden +
                                '</span>' +
                            '</div>' +
                        '</div>' +
                        '<p style="color: #94a3b8; font-size: 12px; margin-top: 14px; margin-bottom: 0; text-align: center;">' +
                            '<i class="fa fa-info-circle mr-1"></i> Esta acción registrará la referencia en el sistema.' +
                        '</p>' +
                    '</div>',
                buttons: {
                    confirmar: {
                        text: '<i class="fa fa-check mr-1"></i> Sí, Asociar',
                        btnClass: 'btn-blue',
                        action: function () {
                            ejecutarAsociacion();
                        }
                    },
                    cancelar: {
                        text: '<i class="fa fa-times mr-1"></i> Cancelar',
                        btnClass: 'btn-default',
                        action: function () {}
                    }
                }
            });
        } else {
            if (confirm('¿Está seguro de asociar la Cotización ' + id_cotizacion + ' con la Orden de Compra ' + cod_orden + '?')) {
                ejecutarAsociacion();
            }
        }
    });

    // Búsqueda inicial automática
    buscarCotizacionesSinOC();
});
