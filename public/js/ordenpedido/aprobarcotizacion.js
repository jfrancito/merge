$(document).ready(function () {
    var carpeta = $("#carpeta").val();
    var _token = $("#token").val();

    // 1. Inicializar DataTables con paginación de 10
    if ($.fn.dataTable) {
        try {
            $('.tabla-cotizaciones-aprob').dataTable({
                "pageLength": 10,
                "searching": true,
                "ordering": true,
                "dom": "<'row be-datatable-body'<'col-sm-12'tr>>" +
                       "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>",
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        } catch (e) {
            console.warn("DataTable initialization failed: ", e);
        }
    }

    // Buscador local en tiempo real para las tablas de cada pestaña conectado a DataTables
    $(document).on('keyup', '.buscar-tabla-local', function() {
        var value = $(this).val();
        if ($.fn.dataTable) {
            var table = $(this).closest('.panel-body').find('table').DataTable();
            table.search(value).draw();
        }
    });

    // 2. Ver Detalle de Cotización
    $(document).on('click', '.ver-detalle-cotizacion', function (e) {
        e.preventDefault();
        var id_cotizacion = $(this).data('id');
        if (!id_cotizacion) return;

        // Mostrar el header del tab y activarlo
        $('#tab-detalle-pedido').fadeIn();
        $('.nav-tabs a[href="#detallepedido"]').tab('show');

        // Limpiar contenedor y mostrar cargando
        $('#detalle-pedido-container').html(`
            <div class="text-center" style="padding: 100px;">
                <i class="fa fa-spinner fa-spin fa-4x text-primary" style="margin-bottom: 20px;"></i>
                <h4 class="text-muted">Cargando información detallada de <b>${id_cotizacion}</b>...</h4>
            </div>
        `);

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-listar-detalle-cotizacion',
            data: {
                _token: _token,
                id_cotizacion: id_cotizacion,
                es_aprobacion: true
            },
            success: function (data) {
                $('#detalle-pedido-container').html(data);
            },
            error: function () {
                modalBonito({
                    tipo: 'error', icono: '❌', titulo: 'Error',
                    mensaje: 'No se pudo cargar el detalle de la cotización.', ancho: '400px'
                });
                cerrarDetalleCotizacionTab();
            }
        });
    });

    // 3. Cerrar Detalle de Cotización
    window.cerrarDetalleCotizacionTab = function() {
        $('#tab-detalle-pedido').fadeOut();
        $('.nav-tabs a[href="#ordenpedido"]').tab('show');
    };

    // 4. Modal Bonito
    function modalBonito(opciones) {
        var tipo = opciones.tipo || 'info';
        var icono = opciones.icono || 'ℹ️';
        var titulo = opciones.titulo || 'Información';
        var mensaje = opciones.mensaje || '';
        var ancho = opciones.ancho || '360px';
        var confirmar = opciones.confirmar || false;
        var onConfirm = opciones.onConfirm || null;
        var botonConfirmarText = opciones.botonConfirmarText || 'Aceptar';
        var botonCancelarText = opciones.botonCancelarText || 'Cancelar';

        var colores = {
            error: ['#ff416c', '#ff4b2b'],
            warn: ['#f7971e', '#ffd200'],
            info: ['#4facfe', '#00f2fe'],
            success: ['#00b09b', '#96c93d']
        };

        var botonesPorTipo = {
            error: 'btn-red',
            warn: 'btn-orange',
            success: 'btn-green',
            info: 'btn-blue'
        };

        var grad = colores[tipo] || colores.info;
        var claseBoton = botonesPorTipo[tipo] || 'btn-blue';

        const contenido = `
            <div style="position:relative;text-align:center;padding:40px 20px 25px;">
                <div style="position:absolute;top:0;left:0;width:100%;height:10px;background:linear-gradient(135deg,${grad[0]},${grad[1]});border-radius:6px 6px 0 0;"></div>
                <div style="width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,${grad[0]},${grad[1]});display:flex;align-items:center;justify-content:center;margin:0 auto 18px;box-shadow:0 12px 25px rgba(0,0,0,.25);"><span style="font-size:42px;color:white;">${icono}</span></div>
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
                        text: botonConfirmarText,
                        btnClass: claseBoton,
                        action: onConfirm
                    },
                    cancelar: {
                        text: botonCancelarText
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
                        text: 'Entendido',
                        btnClass: claseBoton
                    }
                }
            });
        }
    }

    // 5. Eliminar/Rechazar Cotización
    $(document).on('click', '.eliminar-cotizacion', function (e) {
        var id_cotizacion = $(this).data('id');
        modalBonito({
            tipo: 'error',
            icono: '⚠️',
            titulo: 'Confirmar Rechazo/Anulación',
            mensaje: '¿Está seguro de que desea rechazar/anular la cotización <b>' + id_cotizacion + '</b>?',
            ancho: '420px',
            confirmar: true,
            botonConfirmarText: 'Rechazar/Anular',
            botonCancelarText: 'Cancelar',
            onConfirm: function () {
                abrircargando();
                $.ajax({
                    type: 'POST',
                    url: carpeta + '/ajax-eliminar-cotizacion',
                    data: {
                        _token: _token,
                        id_cotizacion: id_cotizacion
                    },
                    success: function (res) {
                        cerrarcargando();
                        if (res.success) {
                            modalBonito({
                                tipo: 'success', icono: '✅', titulo: 'Rechazado/Anulado',
                                mensaje: res.mensaje, ancho: '400px'
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            modalBonito({
                                tipo: 'error', icono: '❌', titulo: 'Error',
                                mensaje: res.mensaje, ancho: '400px'
                            });
                        }
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error', icono: '❌', titulo: 'Error',
                            mensaje: 'Error de servidor.', ancho: '400px'
                        });
                    }
                });
            }
        });
    });

    // 6. Aprobar Cotización (Gerencia)
    $(document).on('click', '.aprobar-cotizacion', function (e) {
        e.preventDefault();
        var id_cotizacion = $(this).data('id');
        modalBonito({
            tipo: 'info',
            icono: '❓',
            titulo: 'Confirmar Aprobación',
            mensaje: '¿Está seguro de que desea aprobar la cotización <b>' + id_cotizacion + '</b>?',
            ancho: '420px',
            confirmar: true,
            botonConfirmarText: 'Aceptar',
            botonCancelarText: 'Cancelar',
            onConfirm: function () {
                abrircargando();
                $.ajax({
                    type: 'POST',
                    url: carpeta + '/ajax-aprobar-cotizacion',
                    data: {
                        _token: _token,
                        id_cotizacion: id_cotizacion
                    },
                    success: function (res) {
                        cerrarcargando();
                        if (res.success) {
                            modalBonito({
                                tipo: 'success', icono: '✅', titulo: 'Aprobado',
                                mensaje: res.mensaje, ancho: '400px'
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            modalBonito({
                                tipo: 'error', icono: '❌', titulo: 'Error',
                                mensaje: res.mensaje, ancho: '400px'
                            });
                        }
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error', icono: '❌', titulo: 'Error',
                            mensaje: 'Error de servidor.', ancho: '400px'
                        });
                    }
                });
            }
        });
    });
});
