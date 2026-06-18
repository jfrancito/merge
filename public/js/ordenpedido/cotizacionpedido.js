$(document).ready(function () {
    var carpeta = $("#carpeta").val();
    var _token = $("#token").val();
    var archivos_a_eliminar = [];
    var cargando_edicion = false;

    /* ===============================
       FUNCIÓN MODAL BONITO (ÚNICA)
       =============================== */
    function modalBonito(opciones) {
        var tipo = opciones.tipo || 'info';
        var icono = opciones.icono || 'ℹ️';
        var titulo = opciones.titulo || 'Información';
        var mensaje = opciones.mensaje || '';
        var ancho = opciones.ancho || '360px';
        var confirmar = opciones.confirmar || false;
        var onConfirm = opciones.onConfirm || null;

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
                        text: 'Aceptar',
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
                        text: 'Entendido',
                        btnClass: claseBoton
                    }
                }
            });
        }
    }


    /* ===============================
       MOSTRAR BOTONES SEGÚN INDICADOR
       =============================== */
    $(document).on('change', '#ind_mat_o_ser', function (e) {
        var val = $(this).val();
        if (val === 'M') {
            $('.btn-seleccionar-consolidados').fadeIn();
            $('.btn-seleccionar-pedidos').hide();
        } else if (val === 'S') {
            $('.btn-seleccionar-consolidados').hide();
            $('.btn-seleccionar-pedidos').fadeIn();
        } else {
            $('.btn-seleccionar-consolidados').hide();
            $('.btn-seleccionar-pedidos').hide();
        }
    });


    /* ===============================
       BUSCAR PROVEEDOR POR RUC
       =============================== */
    $(document).on('click', '.btn-search-premium', function (e) {

        var ruc = $('#ruc_proveedor').val();

        if (ruc.trim().length === 0) {

            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Campo Obligatorio',
                mensaje: 'Debe de Ingresar RUC para poder realizar la búsqueda.',
                ancho: '400px'
            });

            $('#ruc_proveedor').focus();
            return;
        }

        var btn = $(this);
        var icon = btn.find('i');
        var originalClass = icon.attr('class');

        icon.attr('class', 'fa fa-spinner fa-spin');
        btn.prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-buscar-proveedor-ruc',
            data: {
                _token: _token,
                ruc: ruc
            },
            success: function (data) {
                if (data.success) {

                    if (data.nombre) $('#nombre_proveedor').val(data.nombre);
                    if (data.direccion) $('#direccion').val(data.direccion);
                    if (data.telefono) $('#telefono').val(data.telefono);

                    $('.premium-input').addClass('success-pulse');
                    setTimeout(() => $('.premium-input').removeClass('success-pulse'), 1500);

                } else {

                    modalBonito({
                        tipo: 'error',
                        icono: '❌',
                        titulo: 'No encontrado',
                        mensaje: 'No se encontró ningún proveedor con el RUC ingresado.',
                        ancho: '400px'
                    });

                }
            },
            error: function () {
                modalBonito({
                    tipo: 'error',
                    icono: '❗',
                    titulo: 'Error de Conexión',
                    mensaje: 'Ocurrió un error inesperado al consultar la base de datos.',
                    ancho: '400px'
                });
            },
            complete: function () {
                icon.attr('class', originalClass);
                btn.prop('disabled', false);
            }
        });
    });

    /* ===============================
       MODAL SELECCIONAR CONSOLIDADOS
       =============================== */
    $(document).on('click', '.btn-seleccionar-consolidados', function (e) {
        
        var $existingTable = $('#table-productos-seleccionados');
        var hasItems = $('.precio-producto').length > 0;

        if (hasItems && $existingTable.data('tipo') === 'S') {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Mezcla No Permitida',
                mensaje: 'Usted está cotizando servicios, no se puede agregar un consolidado de materiales.<br><br>Debe eliminar los servicios actuales si desea cotizar materiales.',
                ancho: '500px'
            });
            return;
        }

        abrircargando();

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-listar-consolidado-general-aprobado',
            data: {
                _token: _token,
                id_cotizacion_edit: $('#id_cotizacion_edit').val()
            },
            success: function (data) {
                cerrarcargando();
                $('.modal-seleccionar-consolidado-general-container').html(data);
                $('#modal-seleccionar-consolidado-general').niftyModal('show');
            },
            error: function () {
                cerrarcargando();
                modalBonito({
                    tipo: 'error',
                    icono: '❌',
                    titulo: 'Error',
                    mensaje: 'No se pudo cargar la lista de consolidados.',
                    ancho: '400px'
                });
            }
        });
    });

    /* ===============================
       MODAL SELECCIONAR PEDIDOS (SERVICIOS)
       =============================== */
    $(document).on('click', '.btn-seleccionar-pedidos', function (e) {

        var $existingTable = $('#table-productos-seleccionados');
        var hasItems = $('.precio-producto').length > 0;

        if (hasItems && $existingTable.data('tipo') === 'M') {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Mezcla No Permitida',
                mensaje: 'Usted está cotizando materiales, no se puede agregar servicios de pedidos.<br><br>Debe eliminar los materiales actuales si desea cotizar servicios.',
                ancho: '500px'
            });
            return;
        }

        abrircargando();

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-listar-pedidos-aprobados-servicio',
            data: {
                _token: _token,
                id_cotizacion_edit: $('#id_cotizacion_edit').val()
            },
            success: function (data) {
                cerrarcargando();
                $('.modal-seleccionar-pedido-container').html(data);
                $('#modal-seleccionar-pedido').niftyModal('show');
            },
            error: function () {
                cerrarcargando();
                modalBonito({
                    tipo: 'error',
                    icono: '❌',
                    titulo: 'Error',
                    mensaje: 'No se pudo cargar la lista de pedidos de servicios.',
                    ancho: '400px'
                });
            }
        });
    });

    /* ===============================
       CAMBIO TIPO COTIZACIÓN
       =============================== */
    $(document).on('change', '#txt_tipo_cotizacion', function (e) {
        var tipo = $(this).val();

        if (tipo === 'SIN COTIZACION') {
            abrircargando();
            $.ajax({
                type: 'POST',
                url: carpeta + '/ajax-get-correlativo-sin-cotizacion',
                data: {
                    _token: _token
                },
                success: function (res) {
                    cerrarcargando();
                    if (res.success) {
                        $('#serie').val(res.serie).prop('readonly', true);
                        $('#numero').val(res.numero).prop('readonly', true);
                    }
                },
                error: function () {
                    cerrarcargando();
                    modalBonito({
                        tipo: 'error',
                        icono: '❌',
                        titulo: 'Error',
                        mensaje: 'No se pudo generar el correlativo.',
                        ancho: '400px'
                    });
                }
            });
        } else {
            // Si es CON COTIZACION o Seleccione, habilitamos y limpiamos (si no es edición)
            if (!cargando_edicion) {
                $('#serie').val('').prop('readonly', false);
                $('#numero').val('').prop('readonly', false);
            } else {
                $('#serie').prop('readonly', false);
                $('#numero').prop('readonly', false);
            }
        }
    });

    // Confirmar selección en el modal
    $(document).on('click', '.btn-confirmar-seleccion-consolidado', function (e) {

        var selected = [];
        var yaImportados = [];
        var centros = [];

        $('.check-consolidado:checked').each(function () {
            var id = $(this).val();
            var centro = $(this).attr('data-centro');
            
            if (centro && !centros.includes(centro)) {
                centros.push(centro);
            }
            selected.push(id);
        });

        // VALIDACIÓN DE CENTROS
        if (centros.length > 1) {
            modalBonito({
                tipo: 'error',
                icono: '❌',
                titulo: 'Centros Diferentes',
                mensaje: 'No puede seleccionar consolidados de diferentes centros para una misma cotización.<br><br>Centros detectados: <b>' + centros.join(', ') + '</b>',
                ancho: '500px'
            });
            return;
        }

        if (selected.length === 0) {
            if (yaImportados.length > 0) {
                modalBonito({
                    tipo: 'warn',
                    icono: '⚠️',
                    titulo: 'Ya Importados',
                    mensaje: 'Los consolidados seleccionados ya se encuentran en la lista de productos.',
                    ancho: '420px'
                });
            } else {
                modalBonito({
                    tipo: 'warn',
                    icono: '⚠️',
                    titulo: 'Sin Selección',
                    mensaje: 'Debe seleccionar al menos un consolidado para continuar.',
                    ancho: '400px'
                });
            }
            return;
        }

        abrircargando();

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-listar-detalle-consolidado-general-seleccionado',
            data: {
                _token: _token,
                selected_ids: selected,
                id_cotizacion_edit: $('#id_cotizacion_edit').val()
            },
            success: function (data) {
                cerrarcargando();
                
                var $container = $('#lista-productos-cotizacion');
                var $existingTable = $container.find('#table-productos-seleccionados');

                var hasActiveItems = $('.precio-producto').length > 0;

                if ($existingTable.length > 0 && hasActiveItems) {
                    
                    // Si ya existe la tabla, extraemos solo las filas <tr> del tbody
                    var $newData = $(data);
                    var $newRows = $newData.find('#table-productos-seleccionados tbody tr');
                    var table = $('#table-productos-seleccionados').DataTable();

                    $newRows.each(function () {
                        var $newRow = $(this);
                        var $newPriceEl = $newRow.find('.precio-producto');
                        var codProd = $newPriceEl.data('cod-producto');
                        var existingRow = null;

                        // Buscar si el producto ya existe en la tabla actual
                        table.rows().every(function () {
                            var $row = $(this.node());
                            var currentCod = $.trim($row.find('.precio-producto').data('cod-producto'));
                            if (currentCod === $.trim(codProd)) {
                                existingRow = this;
                                return false;
                            }
                        });

                        if (existingRow) {
                            // FUSIONAR INTELIGENTE: Sumar solo lo que no esté ya en el breakdown
                            var $rowNode = $(existingRow.node());
                            var $oldPriceEl = $rowNode.find('.precio-producto');
                            var $cantInput = $rowNode.find('.cantidad-producto');

                            var oldBreakdown = $oldPriceEl.data('breakdown') || [];
                            var newBreakdown = $newPriceEl.data('breakdown') || [];
                            
                            var cantARealmenteAgregar = 0;
                            var idsARealmenteAgregar = [];
                            
                            newBreakdown.forEach(function(nb) {
                                // Verificar si este ID de consolidado ya aportó a este producto en esta fila
                                var yaExisteEnBreakdown = oldBreakdown.some(function(ob) { return ob.id === nb.id; });
                                if (!yaExisteEnBreakdown) {
                                    oldBreakdown.push(nb);
                                    cantARealmenteAgregar += parseFloat(nb.cant);
                                    idsARealmenteAgregar.push(nb.id);
                                }
                            });

                            if (cantARealmenteAgregar > 0) {
                                // Actualizar Cantidad
                                var currentCant = parseFloat($cantInput.val()) || 0;
                                $cantInput.val((currentCant + cantARealmenteAgregar).toFixed(2));
                                
                                // Actualizar Max Cantidad (Atributo de validación)
                                var currentMax = parseFloat($cantInput.attr('data-max-cantidad')) || 0;
                                $cantInput.attr('data-max-cantidad', (currentMax + cantARealmenteAgregar).toFixed(2));

                                // Actualizar IDs en la columna 3
                                var oldIds = $oldPriceEl.data('id-consolidado').toString();
                                var joinedIds = oldIds + ' - ' + idsARealmenteAgregar.join(' - ');
                                
                                $oldPriceEl.data('id-consolidado', joinedIds);
                                $oldPriceEl.data('breakdown', oldBreakdown);
                                $rowNode.find('td:nth-child(3)').html('<b>' + joinedIds + '</b>');
                            }
                        } else {
                            // AGREGAR: Es un producto nuevo en la lista
                            table.row.add($newRow).draw(false);
                        }
                    });

                    table.draw();
                    reordenarItems();

                    modalBonito({
                        tipo: 'success',
                        icono: '✅',
                        titulo: 'Productos Agregados',
                        mensaje: 'Se han añadido ' + $newRows.length + ' productos adicionales a la lista.',
                        ancho: '400px'
                    });

                } else {
                    // Primera carga o estaba vacío
                    $container.html(data);
                    modalBonito({
                        tipo: 'success',
                        icono: '✅',
                        titulo: 'Productos Cargados',
                        mensaje: 'Se han importado los productos seleccionados correctamente.',
                        ancho: '400px'
                    });
                }

                $('#modal-seleccionar-consolidado-general').niftyModal('hide');
                $('#incluir_igv').trigger('change');
            },
            error: function () {
                cerrarcargando();
                modalBonito({
                    tipo: 'error',
                    icono: '❌',
                    titulo: 'Error',
                    mensaje: 'Ocurrió un error al cargar el detalle de los consolidados.',
                    ancho: '400px'
                });
            }
        });
    });

    // Confirmar selección de Pedidos (Servicios) en el modal
    $(document).on('click', '.btn-confirmar-seleccion-pedidos', function (e) {

        var selected = [];
        var centros = [];

        $('.check-pedido:checked').each(function () {
            var id = $(this).val();
            var centro = $(this).attr('data-centro');
            
            if (centro && !centros.includes(centro)) {
                centros.push(centro);
            }
            selected.push(id);
        });

        // VALIDACIÓN DE CENTROS
        if (centros.length > 1) {
            modalBonito({
                tipo: 'error',
                icono: '❌',
                titulo: 'Centros Diferentes',
                mensaje: 'No puede seleccionar pedidos de diferentes centros para una misma cotización.<br><br>Centros detectados: <b>' + centros.join(', ') + '</b>',
                ancho: '500px'
            });
            return;
        }

        if (selected.length === 0) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Sin Selección',
                mensaje: 'Debe seleccionar al menos un pedido para continuar.',
                ancho: '400px'
            });
            return;
        }

        abrircargando();

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-listar-detalle-pedidos-aprobados-seleccionados',
            data: {
                _token: _token,
                selected_ids: selected,
                id_cotizacion_edit: $('#id_cotizacion_edit').val()
            },
            success: function (data) {
                cerrarcargando();
                
                var $container = $('#lista-productos-cotizacion');
                var $existingTable = $container.find('#table-productos-seleccionados');

                var hasActiveItems = $('.precio-producto').length > 0;

                if ($existingTable.length > 0 && hasActiveItems) {
                    
                    var $newData = $(data);
                    var $newRows = $newData.find('#table-productos-seleccionados tbody tr');
                    var table = $('#table-productos-seleccionados').DataTable();

                    $newRows.each(function () {
                        var $newRow = $(this);
                        var $newPriceEl = $newRow.find('.precio-producto');
                        var codProd = $newPriceEl.data('cod-producto');
                        var idPedido = $newPriceEl.data('id-consolidado');

                        var existingRow = null;

                        table.rows().every(function () {
                            var $row = $(this.node());
                            var currentCod = $.trim($row.find('.precio-producto').data('cod-producto'));
                            var currentPed = $.trim($row.find('.precio-producto').data('id-consolidado'));
                            if (currentCod === $.trim(codProd) && currentPed === $.trim(idPedido)) {
                                existingRow = this;
                                return false;
                            }
                        });

                        if (!existingRow) {
                            table.row.add($newRow).draw(false);
                        }
                    });

                    table.draw();
                    reordenarItems();

                    modalBonito({
                        tipo: 'success',
                        icono: '✅',
                        titulo: 'Servicios Agregados',
                        mensaje: 'Se han añadido los servicios adicionales a la lista.',
                        ancho: '400px'
                    });

                } else {
                    $container.html(data);
                    modalBonito({
                        tipo: 'success',
                        icono: '✅',
                        titulo: 'Servicios Cargados',
                        mensaje: 'Se han importado los servicios del pedido correctamente.',
                        ancho: '400px'
                    });
                }

                $('#modal-seleccionar-pedido').niftyModal('hide');
                $('#incluir_igv').trigger('change');
            },
            error: function () {
                cerrarcargando();
                modalBonito({
                    tipo: 'error',
                    icono: '❌',
                    titulo: 'Error',
                    mensaje: 'Ocurrió un error al cargar el detalle de los pedidos.',
                    ancho: '400px'
                });
            }
        });
    });

    /* ===============================
       CALCULAR TOTAL ESTIMADO DINÁMICO
       =============================== */
    /* ===============================
       ACTUALIZAR TOTAL DINÁMICO
       =============================== */
    function calcularTotal() {
        var totalFinal = 0;
        var moneda = $('#moneda_id').val();
        var incluirIGV = $('#incluir_igv').is(':checked');

        $('.precio-producto').each(function () {
            var $row = $(this).closest('tr');
            var cantidad = parseFloat($row.find('.cantidad-producto').val()) || 0;
            
            // Si incluye IGV, sumamos usando la columna de PRECIO IGV
            // Si no, usamos la columna de PRECIO base
            var precioUsar = incluirIGV 
                ? (parseFloat($row.find('.precio-igv-producto').val()) || 0)
                : (parseFloat($(this).val()) || 0);
            
            totalFinal += (cantidad * precioUsar);
        });

        $('#total').val(totalFinal.toFixed(2));
    }

    function verificarPrecioAnterior($input) {
        var $row = $input.closest('tr');
        var $alerta = $row.find('.precio-alerta-info');
        if ($alerta.length === 0) return;

        var precioActual = parseFloat($input.val()) || 0;
        var precioAnterior = parseFloat($input.data('precio-compra-anterior')) || 0;

        if (precioAnterior > 0) {
            precioActual = Math.round(precioActual * 100) / 100;
            precioAnterior = Math.round(precioAnterior * 100) / 100;

            if (precioActual > precioAnterior) {
                $alerta.html('<div style="display: flex; align-items: center; justify-content: center; gap: 3px; line-height: 1.25; padding: 2px 0;"><i class="mdi mdi-alert" style="font-size: 14px; color: #a04000; display: inline-block; vertical-align: middle;"></i><span style="font-family: inherit; font-size: 10.5px; letter-spacing: -0.1px;">Última OC: <b style="font-weight: 800;">S/ ' + precioAnterior.toFixed(2) + '</b> <span style="font-weight: 800; color: #a04000;">(Mayor)</span></span></div>')
                       .css({
                           'background': '#fdf2e9',
                           'border': '1px solid #fadbd8',
                           'color': '#a04000',
                           'padding': '5px 8px',
                           'margin': '5px auto 0 auto',
                           'border-radius': '6px',
                           'display': 'block',
                           'box-shadow': '0 2px 4px rgba(0, 0, 0, 0.05)',
                           'width': '125px',
                           'text-align': 'center'
                       });
                $input.css({
                    'border-color': '#f5b041',
                    'box-shadow': '0 0 4px rgba(245, 176, 65, 0.5)'
                });
            } else if (precioActual < precioAnterior && precioActual > 0) {
                $alerta.html('<div style="display: flex; align-items: center; justify-content: center; gap: 3px; line-height: 1.25; padding: 2px 0;"><i class="mdi mdi-arrow-down-bold-circle" style="font-size: 14px; color: #117864; display: inline-block; vertical-align: middle;"></i><span style="font-family: inherit; font-size: 10.5px; letter-spacing: -0.1px;">Última OC: <b style="font-weight: 800;">S/ ' + precioAnterior.toFixed(2) + '</b> <span style="font-weight: 800; color: #117864;">(Menor)</span></span></div>')
                       .css({
                           'background': '#e8f8f5',
                           'border': '1px solid #d1f2eb',
                           'color': '#117864',
                           'padding': '5px 8px',
                           'margin': '5px auto 0 auto',
                           'border-radius': '6px',
                           'display': 'block',
                           'box-shadow': '0 2px 4px rgba(0, 0, 0, 0.05)',
                           'width': '125px',
                           'text-align': 'center'
                       });
                $input.css({
                    'border-color': '#5dade2',
                    'box-shadow': '0 0 4px rgba(93, 173, 226, 0.5)'
                });
            } else {
                $alerta.hide().html('');
                $input.css({
                    'border-color': '',
                    'box-shadow': ''
                });
            }
        } else {
            $alerta.hide().html('');
            $input.css({
                'border-color': '',
                'box-shadow': ''
            });
        }
    }

    function inicializarAlertasPrecio() {
        $('.precio-producto').each(function () {
            verificarPrecioAnterior($(this));
        });
    }

    $(document).on('change', '#incluir_igv', function() {
        var incluirIGV = $(this).is(':checked');
        var cod_centro_usuario = $('#cod_centro_usuario').val();
        var centros_especiales = ['CEN0000000000004', 'CEN0000000000006'];
        var multiplier = centros_especiales.includes(cod_centro_usuario) ? 1.0 : 1.18;

        $('.precio-producto').each(function() {
            var $row = $(this).closest('tr');
            var precio = parseFloat($(this).val()) || 0;
            var precioIGV = incluirIGV ? (precio * multiplier) : 0;
            $row.find('.precio-igv-producto').val(precioIGV.toFixed(4));
        });
        calcularTotal();
        inicializarAlertasPrecio();
    });

    $(document).on('change keyup', '.precio-producto', function (e) {
        var $row = $(this).closest('tr');
        var incluirIGV = $('#incluir_igv').is(':checked');
        var cod_centro_usuario = $('#cod_centro_usuario').val();
        var centros_especiales = ['CEN0000000000004', 'CEN0000000000006'];
        var multiplier = centros_especiales.includes(cod_centro_usuario) ? 1.0 : 1.18;

        var precio = parseFloat($(this).val()) || 0;
        var precioIGV = incluirIGV ? (precio * multiplier) : 0;
        $row.find('.precio-igv-producto').val(precioIGV.toFixed(4));
        calcularTotal();
        verificarPrecioAnterior($(this));
    });

    $(document).on('change keyup', '.precio-igv-producto', function (e) {
        var $row = $(this).closest('tr');
        var incluirIGV = $('#incluir_igv').is(':checked');
        var cod_centro_usuario = $('#cod_centro_usuario').val();
        var centros_especiales = ['CEN0000000000004', 'CEN0000000000006'];
        var divisor = centros_especiales.includes(cod_centro_usuario) ? 1.0 : 1.18;

        if (!incluirIGV) {
            $(this).val('0.00');
            return;
        }

        var precioIGV = parseFloat($(this).val()) || 0;
        var precio = precioIGV / divisor;
        $row.find('.precio-producto').val(precio.toFixed(4));
        calcularTotal();
        verificarPrecioAnterior($row.find('.precio-producto'));
    });

    $(document).on('change keyup', '.cantidad-producto', function (e) {
        calcularTotal();
    });

    /* ===============================
       CAMBIO DE SÍMBOLO DE MONEDA
       =============================== */
    $(document).on('change', '#moneda_id', function (e) {
        var moneda = $(this).val();
        var simbolo = moneda === 'MON0000000000001' ? 'S/' : '$';
        $('.moneda-simbolo').text(simbolo);
        calcularTotal();
    });

    /* ===============================
       ELIMINAR PRODUCTOS SELECCIONADOS
       =============================== */
    $(document).on('change', '.check-todos-productos', function (e) {
        var isChecked = $(this).is(':checked');
        $('.check-producto').prop('checked', isChecked);
    });

    $(document).on('click', '.btn-eliminar-seleccionados', function (e) {

        var selected = $('.check-producto:checked');

        if (selected.length === 0) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Sin Selección',
                mensaje: 'Debe seleccionar al menos un producto para eliminar.',
                ancho: '400px'
            });
            return;
        }

        modalBonito({
            tipo: 'warn',
            icono: '🗑️',
            titulo: 'Confirmar Eliminación',
            mensaje: '¿Está seguro de eliminar ' + selected.length + ' producto(s) de la lista?',
            confirmar: true,
            onConfirm: function () {
                var table = $('#table-productos-seleccionados').DataTable();

                selected.each(function () {
                    var $row = $(this).closest('tr');
                    table.row($row).remove();
                });

                table.draw();
                
                // Disparar recalculado del total
                calcularTotal();
                reordenarItems();

                modalBonito({
                    tipo: 'success',
                    icono: '✅',
                    titulo: 'Eliminado',
                    mensaje: 'Productos eliminados de la cotización.',
                    ancho: '400px'
                });

                // Si no quedan productos, limpiar el total
                if ($('.precio-producto').length === 0) {
                    $('#total').val('0.00');
                }
            }
        });
    });

    /* ===============================
       REORDENAR ITEMS (CORRELATIVO)
       =============================== */
    function reordenarItems() {
        $('#table-productos-seleccionados tbody tr').each(function (index) {
            $(this).find('td:nth-child(2)').text(index + 1);
        });
    }

    /* ===============================
       VALIDACIÓN CANTIDAD MÁXIMA
       =============================== */
    $(document).on('change keyup', '.cantidad-producto', function (e) {
        var $input = $(this);
        var max = parseFloat($input.attr('data-max-cantidad')) || 0;
        var val = parseFloat($input.val()) || 0;
        
        if (max > 0 && val > max) {
            $input.val(max.toFixed(2));
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Límite Excedido',
                mensaje: 'La cantidad ingresada no puede superar el saldo pendiente del consolidado (Máximo: <b>' + max.toFixed(2) + '</b>).',
                ancho: '450px'
            });
        }
        calcularTotal();
    });

    /* ===============================
       GUARDAR COTIZACIÓN (CABECERA)
       =============================== */
    $(document).on('click', '.btn-guardar-cotizacion', function (e) {

        // 1. Validaciones básicas de cabecera
        var ruc       = $('#ruc_proveedor').val();
        var nombre    = $('#nombre_proveedor').val();
        var numero    = $('#numero').val();
        var serie     = $('#serie').val();
        var fecha     = $('#fecha_cotizacion').val();
        var direccion = $('#direccion').val();
        var telefono  = $('#telefono').val();
        var validez   = $('#validez').val();
        var entrega   = $('#entrega').val();
        var tipo_pago = $('#tipo_pago_id').val();
        var moneda    = $('#moneda_id').val();
        var tipo_cot  = $('#txt_tipo_cotizacion').val();

        if (!tipo_cot) {
            modalBonito({
                tipo: 'warn', icono: '⚠️', titulo: 'Tipo de Cotización',
                mensaje: 'Debe seleccionar el <b>Tipo de Cotización</b> (CON/SIN).',
                ancho: '400px'
            });
            return;
        }

        if (serie.trim().length === 0 || numero.trim().length === 0 || !fecha) {
            modalBonito({
                tipo: 'warn', icono: '⚠️', titulo: 'Datos Generales Incompletos',
                mensaje: 'Por favor, complete la <b>Serie, Número y Fecha</b> de la cotización.',
                ancho: '420px'
            });
            return;
        }

        if (serie.trim().length < 4) {
            modalBonito({
                tipo: 'warn', icono: '⚠️', titulo: 'Serie Inválida',
                mensaje: 'La <b>Serie</b> debe tener exactamente 4 caracteres (Ej: 0001 o S001).',
                ancho: '420px'
            });
            return;
        }

        if (ruc.trim().length === 0 || nombre.trim().length === 0 || direccion.trim().length === 0) {
            modalBonito({
                tipo: 'warn', icono: '⚠️', titulo: 'Información del Proveedor',
                mensaje: 'Debe completar el <b>RUC, Razón Social y Dirección</b> del proveedor.',
                ancho: '450px'
            });
            return;
        }

        if (!validez || parseInt(validez) <= 0 || !entrega || parseInt(entrega) <= 0) {
            modalBonito({
                tipo: 'warn', icono: '⚠️', titulo: 'Vigencia y Entrega',
                mensaje: 'Los campos <b>Validez y Tiempo de Entrega</b> deben tener valores mayores a 0.',
                ancho: '420px'
            });
            return;
        }

        if (!tipo_pago || !moneda) {
            modalBonito({
                tipo: 'warn', icono: '⚠️', titulo: 'Pago y Moneda',
                mensaje: 'Debe seleccionar el <b>Tipo de Pago</b> y la <b>Moneda</b>.',
                ancho: '400px'
            });
            return;
        }

        // 2. Recolectar datos de cabecera y detalle
        var detalles = [];
        $('.precio-producto').each(function () {
            var $el = $(this);
            var $row = $el.closest('tr');
            detalles.push({
                id_consolidado: $el.data('id-consolidado'),
                cod_producto: $el.data('cod-producto'),
                nom_producto: $el.data('nom-producto'),
                cod_medida: $el.data('cod-medida'),
                nom_medida: $el.data('nom-medida'),
                cantidad: $row.find('.cantidad-producto').val(),
                precio: $el.val(),
                precio_igv: $row.find('.precio-igv-producto').val(),
                cod_familia: $el.data('cod-familia'),
                nom_familia: $el.data('nom-familia'),
                breakdown: $el.data('breakdown')
            });
        });

        if (detalles.length === 0) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Sin Productos',
                mensaje: 'La cotización debe tener al menos un producto.',
                ancho: '400px'
            });
            return;
        }

        // --- NUEVA VALIDACIÓN DE PRECIOS > 0 ---
        var precioInvalido = false;
        var nombreProductoInvalido = '';

        $('.precio-producto').each(function () {
            var $row = $(this).closest('tr');
            var precio = parseFloat($(this).val()) || 0;
            
            if (precio <= 0) {
                precioInvalido = true;
                nombreProductoInvalido = $row.find('td:nth-child(5)').text(); // PRODUCTO (índice 1-based para td:nth-child)
                return false;
            }
        });

        if (precioInvalido) {
            modalBonito({
                tipo: 'warn',
                icono: '💰',
                titulo: 'Precio Requerido',
                mensaje: 'El producto <b>' + nombreProductoInvalido + '</b> no tiene un precio asignado. Por favor, ingrese un monto mayor a 0 en PRECIO.',
                ancho: '450px'
            });
            return;
        }
        // ----------------------------------------

        var id_cotizacion_edit = $('#id_cotizacion_edit').val();
        var formData = new FormData();
        formData.append('_token', _token);
        formData.append('id_cotizacion_edit', id_cotizacion_edit);
        formData.append('fec_cotizacion', $('#fecha_cotizacion').val());
        formData.append('nro_serie', $('#serie').val());
        formData.append('nro_doc', $('#numero').val());
        formData.append('nro_ruc', ruc);
        formData.append('nom_empr_proveedor', nombre);
        formData.append('txt_telefono', $('#telefono').val());
        formData.append('nom_direccion', $('#direccion').val());
        formData.append('fec_validez', $('#validez').val());
        formData.append('fec_entrega', $('#entrega').val());
        formData.append('cod_categoria_moneda', $('#moneda_id').val());
        formData.append('txt_categoria_moneda', $('#moneda_id option:selected').text());
        formData.append('cod_categoria_tipo_pago', $('#tipo_pago_id').val());
        formData.append('txt_categoria_tipo_pago', $('#tipo_pago_id option:selected').text());
        formData.append('txt_observacion', $('#observacion').val());
        formData.append('txt_tipo_cotizacion', $('#txt_tipo_cotizacion').val());
        formData.append('can_total', $('#total').val());
        formData.append('ind_igv', $('#incluir_igv').is(':checked') ? 1 : 0);
        var tableTipo = $('#table-productos-seleccionados').data('tipo') || 'M';
        formData.append('ind_mat_o_ser', tableTipo);
        formData.append('detalles', JSON.stringify(detalles));
        formData.append('archivos_a_eliminar', JSON.stringify(archivos_a_eliminar));

        // Adjuntar el archivo si existe
        var fileInput = $('#archivo_cotizacion_crear')[0];
        if (fileInput && fileInput.files.length > 0) {
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append('archivo[]', fileInput.files[i]);
            }
        }

        // 3. Confirmación
        var mensajeConfirm = id_cotizacion_edit ? '¿Está seguro de que desea <b>ACTUALIZAR</b> esta cotización?' : '¿Está seguro de que desea <b>GENERAR</b> esta cotización?';
        var tituloConfirm = id_cotizacion_edit ? 'Confirmar Actualización' : 'Confirmar Guardado';

        modalBonito({
            tipo: 'info',
            icono: '❓',
            titulo: tituloConfirm,
            mensaje: mensajeConfirm,
            confirmar: true,
            onConfirm: function () {

                abrircargando();

                $.ajax({
                    type: 'POST',
                    url: carpeta + '/ajax-guardar-cotizacion',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        cerrarcargando();
                        if (res.success) {

                            modalBonito({
                                tipo: 'success',
                                icono: '✅',
                                titulo: 'Éxito',
                                mensaje: res.mensaje,
                                ancho: '400px'
                            });

                            // Recargar después de éxito
                            setTimeout(function () {
                                location.reload();
                            }, 2000);

                        } else {
                            modalBonito({
                                tipo: 'error',
                                icono: '❌',
                                titulo: 'Error',
                                mensaje: res.message,
                                ancho: '400px'
                            });
                        }
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error',
                            mensaje: 'Ocurrió un error en el servidor.',
                            ancho: '400px'
                        });
                    }
                });
            }
        });

    });

    /* ===============================
    VER DETALLE DE COTIZACIÓN
    =============================== */
    $(document).on('click', '.ver-detalle-cotizacion', function (e) {
        var id_cotizacion = $(this).data('id');
        if (!id_cotizacion) return;

        // Mostrar el header del tab y activarlo
        $('#tab-header-detalle').fadeIn();
        $('.nav-tabs a[href="#detallecotizacion"]').tab('show');

        // Limpiar contenedor y mostrar cargando
        $('#contenedor-detalle-cotizacion-tab').html(`
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
                id_cotizacion: id_cotizacion
            },
            success: function (data) {
                $('#contenedor-detalle-cotizacion-tab').html(data);
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

    window.cerrarDetalleCotizacionTab = function() {
        $('#tab-header-detalle').fadeOut();
        $('.nav-tabs a[href="#listacotizacionpedido"]').tab('show');
    };

    /* =================================
    GESTIÓN DE ARCHIVOS (COTIZACIÓN)
    ================================= */

    /* =================================
 GESTIÓN DE ARCHIVOS (COTIZACIÓN)
 ================================= */
    /* =================================
    EDITAR COTIZACIÓN
    ================================= */
    $(document).on('click', '.editar-cotizacion', function (e) {
        var id_cotizacion = $(this).data('id');
        if (!id_cotizacion) return;

        abrircargando();

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-editar-cotizacion',
            data: {
                _token: _token,
                id_cotizacion: id_cotizacion
            },
            success: function (res) {
                cerrarcargando();
                try {
                    if (res.success) {
                        var cot = res.cotizacion;
                        cargando_edicion = true; // Activar flag para evitar reset

                        // Función auxiliar para obtener propiedades sin importar el caso
                        var getVal = function (obj, prop) {
                            if (!obj) return '';
                            var val = obj[prop] !== undefined && obj[prop] !== null ? obj[prop] :
                                     (obj[prop.toUpperCase()] !== undefined && obj[prop.toUpperCase()] !== null ? obj[prop.toUpperCase()] :
                                     (obj[prop.toLowerCase()] !== undefined && obj[prop.toLowerCase()] !== null ? obj[prop.toLowerCase()] : ''));
                            return String(val).trim();
                        };

                        // 1. Llenar campos de cabecera
                        var id_cot = getVal(cot, 'ID_COTIZACION');
                        $('#id_cotizacion_edit').val(id_cot);
                        $('#nro_cotizacion').val(id_cot);
                        
                        var fec_cot = getVal(cot, 'FEC_COTIZACION');
                        if (fec_cot && typeof fec_cot === 'string') {
                            $('#fecha_cotizacion').val(fec_cot.substring(0, 10));
                        }
                        
                        $('#serie').val(getVal(cot, 'NRO_SERIE'));
                        $('#numero').val(getVal(cot, 'NRO_DOC'));
                        
                        $('#ruc_proveedor').val(getVal(cot, 'NRO_RUC'));
                        $('#nombre_proveedor').val(getVal(cot, 'NOM_EMPR_PROVEEDOR'));
                        $('#direccion').val(getVal(cot, 'NOM_DIRECCION'));
                        $('#telefono').val(getVal(cot, 'TXT_TELEFONO'));
                        
                        $('#validez').val(getVal(cot, 'FEC_VALIDEZ') || getVal(cot, 'CAN_VALIDEZ'));
                        $('#entrega').val(getVal(cot, 'FEC_ENTREGA') || getVal(cot, 'CAN_ENTREGA'));
                        
                        $('#observacion').val(getVal(cot, 'TXT_OBSERVACION'));
                        $('#txt_tipo_cotizacion').val(getVal(cot, 'TXT_TIPO_COTIZACION')).trigger('change');
                        
                        // Restaurar estado de IGV
                        var ind_igv = getVal(cot, 'IND_IGV');
                        $('#incluir_igv').prop('checked', ind_igv == '1' || ind_igv == 1);

                        var total_db = parseFloat(getVal(cot, 'CAN_TOTAL') || 0);
                        $('#total').val(total_db.toFixed(2));

                        // 2. Llenar Select2
                        var cod_pago = getVal(cot, 'COD_CATEGORIA_TIPO_PAGO');
                        if (cod_pago) { $('#tipo_pago_id').val(cod_pago).trigger('change'); }
                        
                        var cod_moneda = getVal(cot, 'COD_CATEGORIA_MONEDA');
                        if (cod_moneda) { $('#moneda_id').val(cod_moneda).trigger('change'); }

                        // 3. Cargar Detalle de Productos
                        if (res.productos_html) {
                            $('#lista-productos-cotizacion').html(res.productos_html);
                            setTimeout(function(){
                                $('.check-producto').prop('checked', true);
                                calcularTotal();
                                inicializarAlertasPrecio();
                            }, 500);
                        }

                        // 4. Cambiar interfaz a modo edición
                        $('.btn-guardar-cotizacion').html('<i class="mdi mdi-content-save"></i> Actualizar Cotización');
                        $('.header-principal').html('<i class="mdi mdi-receipt"></i> EDITAR COTIZACIÓN: ' + (id_cot || ''));

                        // 5. Cambiar de pestaña
                        $('a[href="#crearcotizacionpedido"]').tab('show');

                        // 6. Cargar Archivos Adjuntos Actuales
                        var $listaArchivos = $('#lista-archivos-existentes');
                        $listaArchivos.empty();
                        archivos_a_eliminar = []; 

                        if (res.archivos && res.archivos.length > 0) {
                            $('#archivos-existentes-contenedor').show();
                            res.archivos.forEach(function (archivo) {
                                var nom = getVal(archivo, 'NOMBRE_ARCHIVO');
                                var ext = getVal(archivo, 'EXTENSION');
                                var url = getVal(archivo, 'URL_ARCHIVO');
                                var item_id = getVal(archivo, 'DOCUMENTO_ITEM');
                                
                                // Codificar URL para el visor
                                var b64 = btoa(url);

                                var item = `
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 preview-file-existente" data-id="${item_id}" style="margin-bottom: 20px;">
                                        <div class="panel panel-default shadow-soft card-archivo-existente" style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #fff; transition: all 0.3s;">
                                            <div class="panel-heading" style="background: #f39c12; color: #fff; padding: 5px 10px; font-size: 11px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${nom}.${ext}">
                                                <i class="fa fa-file-pdf-o"></i> ${nom}.${ext}
                                            </div>
                                            <div class="panel-body" style="padding: 10px; text-align: center; position: relative;">
                                                <div class="capa-anulado" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(231, 76, 60, 0.2); z-index: 5; align-items: center; justify-content: center; color: #c0392b; font-weight: bold; font-size: 14px;">
                                                    <span style="background: #fff; padding: 5px 10px; border-radius: 4px; border: 2px solid #c0392b; transform: rotate(-15deg);">ELIMINAR</span>
                                                </div>
                                                <div style="height: 150px; position: relative; background: #f8f9fa; border-radius: 4px; overflow: hidden;">
                                                    <object data="${carpeta}/descargar-archivo-informe/${b64}" type="application/pdf" style="width: 100%; height: 100%;">
                                                        <div style="padding-top: 40px; color: #999;">
                                                            <i class="fa fa-file-pdf-o" style="font-size: 50px; color: #e74c3c;"></i>
                                                            <p style="font-size: 11px; margin-top: 10px;">Archivo Adjunto</p>
                                                        </div>
                                                    </object>
                                                </div>
                                                <div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                                                    <a href="${carpeta}/descargar-archivo-informe/${b64}" target="_blank" class="btn btn-xs btn-default" title="Ver archivo">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-xs btn-danger btn-eliminar-archivo-existente" 
                                                            data-id="${item_id}" title="Marcar para eliminar">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                                $listaArchivos.append(item);
                            });
                        } else {
                            $('#archivos-existentes-contenedor').hide();
                        }

                        modalBonito({
                            tipo: 'info',
                            icono: '📝',
                            titulo: 'Modo Edición',
                            mensaje: 'Se han cargado los datos de la cotización <b>' + (id_cot || '') + '</b>',
                            ancho: '400px'
                        });

                        // Desactivar flag después de que la pestaña se haya mostrado
                        setTimeout(function() { cargando_edicion = false; }, 1000);

                    } else {
                        modalBonito({ tipo: 'error', icono: '❌', titulo: 'Error', mensaje: res.message, ancho: '400px' });
                    }
                } catch (e) {
                    console.error("Error en el procesamiento de edición:", e);
                    modalBonito({ tipo: 'error', icono: '❌', titulo: 'Error JS', mensaje: 'Error al cargar datos: ' + e.message, ancho: '400px' });
                }
            },
            error: function () {
                cerrarcargando();
                modalBonito({
                    tipo: 'error',
                    icono: '❌',
                    titulo: 'Error',
                    mensaje: 'No se pudo obtener los datos para editar.',
                    ancho: '400px'
                });
            }
        });
    });

    /* =================================
    MARCAR ARCHIVOS EXISTENTES PARA ELIMINAR
    ================================= */
    $(document).on('click', '.btn-eliminar-archivo-existente', function () {
        var $btn = $(this);
        var idItem = $btn.data('id');
        var $card = $btn.closest('.card-archivo-existente');
        var $capa = $card.find('.capa-anulado');

        if ($card.hasClass('a-eliminar')) {
            // Desmarcar
            $card.removeClass('a-eliminar').css({
                'opacity': '1',
                'border-color': '#ddd'
            });
            $capa.fadeOut();
            $btn.find('i').attr('class', 'fa fa-trash');
            $btn.removeClass('btn-info').addClass('btn-danger');
            archivos_a_eliminar = archivos_a_eliminar.filter(id => id !== idItem);
        } else {
            // Marcar para eliminar
            $card.addClass('a-eliminar').css({
                'opacity': '0.7',
                'border-color': '#e74c3c'
            });
            $capa.css('display', 'flex').hide().fadeIn();
            $btn.find('i').attr('class', 'fa fa-undo'); // Cambiar a deshacer
            $btn.removeClass('btn-danger').addClass('btn-info');
            archivos_a_eliminar.push(idItem);
        }
    });

    function resetearFormularioCotizacion() {
        $('#id_cotizacion_edit').val('');
        $('#serie').val('');
        $('#numero').val('');
        $('#ruc_proveedor').val('');
        $('#nombre_proveedor').val('');
        $('#direccion').val('');
        $('#telefono').val('');
        $('#validez').val('');
        $('#entrega').val('');
        $('#observacion').val('');
        $('#txt_tipo_cotizacion').val('').trigger('change');
        $('#total').val('0.00');
        $('#incluir_igv').prop('checked', false);
        $('#lista-productos-cotizacion').html('<div class="text-center p-5 message-empty"><i class="mdi mdi-cart-outline icon-large"></i><p>Seleccione los consolidados para cargar los productos a cotizar.</p></div>');
        
        $('.btn-guardar-cotizacion').html('<i class="mdi mdi-content-save"></i> Generar Cotización');
        $('.header-principal').html('<i class="mdi mdi-receipt"></i> COTIZACIÓN ORDEN PEDIDO');
 
        $('#archivos-existentes-contenedor').hide();
        $('#lista-archivos-existentes').empty();
        $('#archivo_cotizacion_crear').val('');
        archivos_a_eliminar = [];
    }

    $(document).on('click', '.btn-cancelar', function (e) {
        resetearFormularioCotizacion();
        $('a[href="#listacotizacionpedido"]').tab('show');
    });

    /* =================================
    APROBAR COTIZACIÓN
    ================================= */
    $(document).on('click', '.aprobar-cotizacion', function (e) {
        var id_cotizacion = $(this).data('id');
        modalBonito({
            tipo: 'info',
            icono: '❓',
            titulo: 'Confirmar Aprobación',
            mensaje: '¿Está seguro de que desea aprobar la cotización <b>' + id_cotizacion + '</b>?',
            confirmar: true,
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
                                tipo: 'success',
                                icono: '✅',
                                titulo: 'Aprobado',
                                mensaje: res.mensaje,
                                ancho: '400px'
                            });

                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            modalBonito({
                                tipo: 'error',
                                icono: '❌',
                                titulo: 'Error',
                                mensaje: res.mensaje,
                                ancho: '400px'
                            });
                        }
                    },
                    error: function (xhr) {
                        cerrarcargando();
                        var res = xhr.responseJSON;
                        var errorMsg = res && res.mensaje ? res.mensaje : ('Error en el servidor (' + xhr.status + ')');
                        
                        modalBonito({
                            tipo: 'error',
                            icono: '❌',
                            titulo: 'Error en Servidor',
                            mensaje: '<b>No se pudo completar la aprobación:</b><br>' + errorMsg,
                            ancho: '450px'
                        });
                    }
                });
            }
        });
    });

    /* =================================
    GESTIÓN DE ARCHIVOS (COTIZACIÓN)
    ================================= */
    $(document).on('click', '.btn-subir-archivo', function (e) {
        var id = $(this).data('id');
        if (id) {
            $('#file_' + id).click();
        } else {
            $('.input-file-general-cotizacion').click();
        }
    });

    $(document).on('change', '.input-file-cotizacion', function (e) {
        var id_cotizacion = $(this).data('id');
        var file = this.files[0];
        if (!file) return;

        if (file.type !== 'application/pdf') {
            modalBonito({
                tipo: 'error', icono: '⚠️', titulo: 'Formato inválido',
                mensaje: 'Solo se permiten archivos PDF.', ancho: '400px'
            });
            $(this).val('');
            return;
        }

        var formData = new FormData();
        formData.append('archivo', file);
        formData.append('id_cotizacion', id_cotizacion);
        formData.append('_token', _token);

        abrircargando();

        $.ajax({
            url: carpeta + '/ajax-subir-archivo-cotizacion',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                cerrarcargando();
                if (res.ok) {
                    modalBonito({
                        tipo: 'success', icono: '✅', titulo: 'Éxito',
                        mensaje: 'Archivo subido correctamente.', ancho: '400px'
                    });
                } else {
                    modalBonito({
                        tipo: 'error', icono: '❌', titulo: 'Error',
                        mensaje: res.mensaje || 'No se pudo subir el archivo.', ancho: '400px'
                    });
                }
            },
            error: function () {
                cerrarcargando();
                modalBonito({
                    tipo: 'error', icono: '❌', titulo: 'Error de Red',
                    mensaje: 'Ocurrió un error al intentar subir el archivo.', ancho: '400px'
                });
            }
        });
        $(this).val('');
    });

    /* ===============================
       BUSCADOR PRINCIPAL DE COTIZACIONES
       =============================== */
    $(document).on('keyup', '#buscar_cotizacion_principal', function () {
        var valor = $(this).val().toLowerCase();
        $("#tabla_cotizaciones tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
        });
    });

    /* =================================
       VALIDACIÓN TELÉFONO (SOLO 9 NÚMEROS)
       ================================= */
    $(document).on('input', '#telefono', function () {
        this.value = this.value.replace(/[^0-9]/g, ''); // Eliminar todo lo que no sea número
    });


    /* =================================
       RESET AL CAMBIAR DE PESTAÑA SI VENIMOS DE EDICIÓN
       ================================= */
    $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
        var target = $(e.target).attr("href");
        if (target === "#crearcotizacionpedido") {
            // Si hay un ID de edición Y NO estamos cargándola activamente, significa que el usuario cambió manualmente
            if ($('#id_cotizacion_edit').val() !== "" && !cargando_edicion) {
                resetearFormularioCotizacion();
            }
        }
    });

    /* =================================
       ELIMINAR COTIZACIÓN
       ================================= */
    $(document).on('click', '.eliminar-cotizacion', function (e) {
        var id_cotizacion = $(this).data('id');
        var _token = $('#token').val();

        modalBonito({
            tipo: 'warning',
            icono: '⚠️',
            titulo: '¿Eliminar Cotización?',
            mensaje: "¿Desea eliminar la cotización (" + id_cotizacion + ")? Esta acción liberará los productos para cotizar de nuevo.",
            confirmar: true,
            ancho: '450px',
            onConfirm: function () {
                abrircargando();
                $.ajax({
                    type: "POST",
                    url: carpeta + "/ajax-eliminar-cotizacion",
                    data: {
                        _token: _token,
                        id_cotizacion: id_cotizacion
                    },
                    success: function (res) {
                        cerrarcargando();
                        if (res.success) {
                            modalBonito({
                                tipo: 'success', icono: '✅', titulo: 'Éxito',
                                mensaje: res.message, ancho: '400px'
                            });
                            setTimeout(function () { location.reload(); }, 1500);
                        } else {
                            modalBonito({
                                tipo: 'error', icono: '❌', titulo: 'Error',
                                mensaje: res.message, ancho: '400px'
                            });
                        }
                    },
                    error: function () {
                        cerrarcargando();
                        modalBonito({
                            tipo: 'error', icono: '❌', titulo: 'Error de Red',
                            mensaje: 'Ocurrió un error al intentar eliminar la cotización.', ancho: '400px'
                        });
                    }
                });
            }
        });
    });

    /* =================================
       AUTO-COMPLETAR NÚMERO CON CEROS
       ================================= */
    $(document).on('blur', '#numero', function () {
        var valor = $(this).val().trim();
        if (valor !== '') {
            var padded = valor.padStart(8, '0');
            $(this).val(padded);
        }
    });

    $(document).on('blur', '#serie', function () {
        var valor = $(this).val().trim();
        if (valor !== '' && valor.length < 4) {
            // Si empieza por letra (ej: S1), rellenamos con ceros después de la letra -> S001
            if (/^[a-zA-Z]/.test(valor)) {
                var letra = valor.charAt(0);
                var resto = valor.substring(1);
                var padded = letra + resto.padStart(3, '0');
                $(this).val(padded.toUpperCase());
            } else {
                // Si es solo número (ej: 1), rellenamos normal -> 0001
                var padded = valor.padStart(4, '0');
                $(this).val(padded);
            }
        }
    });

    $(document).on('input', '#numero', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    /* =================================
       PREVISUALIZACIÓN DE ARCHIVOS
       ================================= */
    $(document).on('change', '#archivo_cotizacion_crear', function() {
        var input = this;
        var container = $('#previsualizacion-archivos-cotizacion');
        container.empty().show();

        if (input.files && input.files.length > 0) {
            $.each(input.files, function(i, file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var fileUrl = e.target.result;
                    var cardHtml = `
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" style="margin-bottom: 20px;">
                            <div class="panel panel-default shadow-soft" style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #fff;">
                                <div class="panel-heading" style="background: #1d3a6d; color: #fff; padding: 5px 10px; font-size: 11px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${file.name}">
                                    <i class="fa fa-file-pdf-o"></i> ${file.name}
                                </div>
                                <div class="panel-body" style="padding: 10px; text-align: center;">
                                    <div style="height: 160px; position: relative; background: #f8f9fa; border-radius: 4px; overflow: hidden;">
                                        <object data="${fileUrl}" type="application/pdf" style="width: 100%; height: 100%;">
                                            <div style="padding-top: 40px; color: #999;">
                                                <i class="fa fa-file-pdf-o" style="font-size: 50px; color: #e74c3c;"></i>
                                                <p style="font-size: 11px; margin-top: 10px;">Vista previa no disponible</p>
                                            </div>
                                        </object>
                                    </div>
                                    <div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 10px; color: #777; font-weight: bold;">
                                            ${(file.size / 1024 / 1024).toFixed(2)} MB
                                        </span>
                                        <a href="${fileUrl}" target="_blank" class="btn btn-xs btn-primary" title="Ver en pantalla completa" style="border-radius: 4px;">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    container.append(cardHtml);
                };
                reader.readAsDataURL(file);
            });
        } else {
            container.hide();
        }
    });

});
