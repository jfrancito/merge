$(document).ready(function () {
    var carpeta = $("#carpeta").val();
    var _token = $("#token").val();

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

        abrircargando();

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-listar-consolidado-general-aprobado',
            data: {
                _token: _token
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

    // Confirmar selección en el modal
    $(document).on('click', '.btn-confirmar-seleccion-consolidado', function (e) {

        var selected = [];
        var yaImportados = [];

        $('.check-consolidado:checked').each(function () {
            var id = $(this).val();
            var existe = false;

            // Buscar el ID del consolidado en la columna 3 (índice 3 en nth-child) de la tabla principal
            $('#table-productos-seleccionados tbody tr').each(function () {
                if ($(this).find('td:nth-child(3)').text().trim() === id) {
                    existe = true;
                    return false;
                }
            });

            if (existe) {
                yaImportados.push(id);
            } else {
                selected.push(id);
            }
        });

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
                selected_ids: selected
            },
            success: function (data) {
                cerrarcargando();
                
                var $container = $('#lista-productos-cotizacion');
                var $existingTable = $container.find('#table-productos-seleccionados');

                if ($existingTable.length > 0 && !$container.find('.message-empty').length) {
                    
                    // Si ya existe la tabla, extraemos solo las filas <tr> del tbody
                    var $newData = $(data);
                    var $newRows = $newData.find('#table-productos-seleccionados tbody tr');
                    var table = $('#table-productos-seleccionados').DataTable();

                    $newRows.each(function () {
                        table.row.add($(this)).draw(false);
                    });

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
                calcularTotal();
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

    /* ===============================
       CALCULAR TOTAL ESTIMADO DINÁMICO
       =============================== */
    /* ===============================
       ACTUALIZAR TOTAL DINÁMICO
       =============================== */
    function calcularTotal() {
        var totalSoles = 0;
        var moneda = $('#moneda_id').val();

        // Manejar posibles comas decimales desde el servidor
        var tc_val = $('#tipo_cambio_actual').val() ? $('#tipo_cambio_actual').val().toString().replace(',', '.') : '0';
        var tipoCambio = parseFloat(tc_val) || 0;

        // Log para depuración
        console.log('--- Calculando Total ---');
        console.log('Moneda seleccionada: ', moneda);
        console.log('Tipo de Cambio Hoy: ', tipoCambio);

        $('.precio-producto').each(function () {
            var $row = $(this).closest('tr');
            var cantidad = parseFloat($row.find('.cantidad-producto').val()) || 0;
            var precio = parseFloat($(this).val()) || 0;
            var precio_igv = parseFloat($row.find('.precio-igv-producto').val()) || 0;
            
            // PRECIO se trata como precio sin IGV (exonerado)
            // PRECIO IGV se trata como base a la que se le suma el 18%
            totalSoles += (cantidad * precio) + (cantidad * precio_igv * 1.18);
        });

        console.log('Total en Soles acumulado: ', totalSoles);

        var totalFinal = totalSoles;

        if (moneda === 'MOM0000000000002') { // Dólares
            if (tipoCambio > 0) {
                totalFinal = totalSoles / tipoCambio;
            } else {
                console.warn('Conversión fallida: Tipo de cambio es 0 o no disponible para hoy.');
            }
        }

        console.log('Cálculo final: ', totalFinal);
        $('#total').val(totalFinal.toFixed(2));
    }

    $(document).on('change keyup', '.precio-producto, .precio-igv-producto, .cantidad-producto', function (e) {
        calcularTotal();
    });

    /* ===============================
       CAMBIO DE SÍMBOLO DE MONEDA
       =============================== */
    $(document).on('change', '#moneda_id', function (e) {
        var moneda = $(this).val();
        var simbolo = moneda === 'MOM0000000000001' ? 'S/' : '$';
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

                selected.each(function () {
                    $(this).closest('tr').remove();
                });

                // Disparar recalculado del total
                $('.precio-producto').first().trigger('change');
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
       GUARDAR COTIZACIÓN (CABECERA)
       =============================== */
    $(document).on('click', '.btn-guardar-cotizacion', function (e) {

        // 1. Validaciones básicas
        var ruc = $('#ruc_proveedor').val();
        var nombre = $('#nombre_proveedor').val();
        var numero = $('#numero').val();

        if (ruc.trim().length === 0 || nombre.trim().length === 0) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Datos Faltantes',
                mensaje: 'Debe ingresar la información del proveedor (RUC y Razón Social).',
                ancho: '400px'
            });
            return;
        }

        if (numero.trim().length === 0) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Datos Faltantes',
                mensaje: 'Debe ingresar el número de la cotización.',
                ancho: '400px'
            });
            return;
        }

        var tipo_pago = $('#tipo_pago_id').val();
        var moneda = $('#moneda_id').val();

        if (!tipo_pago) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Dato Faltante',
                mensaje: 'Debe seleccionar un tipo de pago.',
                ancho: '400px'
            });
            return;
        }

        if (!moneda) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Dato Faltante',
                mensaje: 'Debe seleccionar una moneda.',
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
                nom_familia: $el.data('nom-familia')
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
            var precio_igv = parseFloat($row.find('.precio-igv-producto').val()) || 0;
            
            if (precio <= 0 && precio_igv <= 0) {
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
                mensaje: 'El producto <b>' + nombreProductoInvalido + '</b> no tiene un precio asignado. Por favor, ingrese un monto mayor a 0 en PRECIO o PRECIO IGV.',
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
        formData.append('can_total', $('#total').val());
        formData.append('detalles', JSON.stringify(detalles));

        // Adjuntar el archivo si existe
        var fileInput = $('#archivo_cotizacion_crear')[0];
        if (fileInput && fileInput.files.length > 0) {
            formData.append('archivo', fileInput.files[0]);
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

        abrircargando();

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-listar-detalle-cotizacion',
            data: {
                _token: _token,
                id_cotizacion: id_cotizacion
            },
            success: function (data) {
                cerrarcargando();
                $('#modal-detalle-cotizacion-container').html(data);
                $('#modal-detalle-cotizacion').niftyModal('show');
            },
            error: function () {
                cerrarcargando();
                modalBonito({
                    tipo: 'error',
                    icono: '❌',
                    titulo: 'Error',
                    mensaje: 'No se pudo cargar el detalle de la cotización.',
                    ancho: '400px'
                });
            }
        });
    });

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
                if (res.success) {
                    var cot = res.cotizacion;

                    // 1. Llenar campos de cabecera
                    $('#id_cotizacion_edit').val(cot.ID_COTIZACION);
                    $('#nro_cotizacion').val(cot.ID_COTIZACION);
                    $('#fecha_cotizacion').val(cot.FEC_COTIZACION.substring(0, 10));
                    $('#serie').val(cot.NRO_SERIE);
                    $('#numero').val(cot.NRO_DOC);
                    $('#ruc_proveedor').val(cot.NRO_RUC);
                    $('#nombre_proveedor').val(cot.NOM_EMPR_PROVEEDOR);
                    $('#direccion').val(cot.NOM_DIRECCION);
                    $('#telefono').val(cot.TXT_TELEFONO);
                    $('#validez').val(cot.FEC_VALIDEZ);
                    $('#entrega').val(cot.FEC_ENTREGA);
                    $('#observacion').val(cot.TXT_OBSERVACION);
                    $('#total').val(parseFloat(cot.CAN_TOTAL).toFixed(2));

                    // 2. Llenar Select2
                    $('#tipo_pago_id').val(cot.COD_CATEGORIA_TIPO_PAGO).trigger('change');
                    $('#moneda_id').val(cot.COD_CATEGORIA_MONEDA).trigger('change');

                    // 3. Cargar Detalle de Productos
                    $('#lista-productos-cotizacion').html(res.productos_html);

                    // 4. Cambiar interfaz a modo edición
                    $('.btn-guardar-cotizacion').html('<i class="mdi mdi-content-save"></i> Actualizar Cotización');
                    $('.header-principal').html('<i class="mdi mdi-receipt"></i> EDITAR COTIZACIÓN: ' + cot.ID_COTIZACION);

                    // 5. Cambiar de pestaña
                    $('a[href="#crearcotizacionpedido"]').tab('show');

                    modalBonito({
                        tipo: 'info',
                        icono: '📝',
                        titulo: 'Modo Edición',
                        mensaje: 'Se han cargado los datos de la cotización <b>' + cot.ID_COTIZACION + '</b> para su modificación.',
                        ancho: '400px'
                    });

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
                    mensaje: 'No se pudo obtener los datos para editar.',
                    ancho: '400px'
                });
            }
        });
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
        $('#total').val('0.00');
        $('#lista-productos-cotizacion').html('<div class="text-center p-5 message-empty"><i class="mdi mdi-cart-outline icon-large"></i><p>Seleccione los consolidados para cargar los productos a cotizar.</p></div>');
        
        $('.btn-guardar-cotizacion').html('<i class="mdi mdi-content-save"></i> Generar Cotización');
        $('.header-principal').html('<i class="mdi mdi-receipt"></i> COTIZACIÓN ORDEN PEDIDO');
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
                // Aquí iría la lógica de aprobación (AJAX)
                $.alert('Lógica de aprobación pendiente de implementar.');
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

});
