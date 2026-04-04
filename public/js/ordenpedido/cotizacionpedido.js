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
                selected_ids: selected,
                id_cotizacion_edit: $('#id_cotizacion_edit').val()
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
        var totalNeto = 0;
        var moneda = $('#moneda_id').val();
        var incluirIGV = $('#incluir_igv').is(':checked');

        // Manejar posibles comas decimales desde el servidor
        var tc_val = $('#tipo_cambio_actual').val() ? $('#tipo_cambio_actual').val().toString().replace(',', '.') : '0';
        var tipoCambio = parseFloat(tc_val) || 0;

        // Log para depuración
        console.log('--- Calculando Total ---');
        console.log('IGV Seleccionado: ', incluirIGV);

        $('.precio-producto').each(function () {
            var $row = $(this).closest('tr');
            var cantidad = parseFloat($row.find('.cantidad-producto').val()) || 0;
            var precio = parseFloat($(this).val()) || 0;
            
            totalNeto += (cantidad * precio);
        });

        var totalFinal = totalNeto;

        // Si incluye IGV, sumar 18%
        if (incluirIGV) {
            totalFinal = totalNeto * 1.18;
        }

        // Conversión a Dólares si aplica (sobre el total con o sin IGV)
        if (moneda === 'MOM0000000000002') { // Dólares
            if (tipoCambio > 0) {
                totalFinal = totalFinal / tipoCambio;
            } else {
                console.warn('Conversión fallida: Tipo de cambio es 0 o no disponible para hoy.');
            }
        }

        console.log('Total Final calculado: ', totalFinal);
        $('#total').val(totalFinal.toFixed(2));
    }

    $(document).on('change', '#incluir_igv', function() {
        calcularTotal();
    });

    $(document).on('change keyup', '.precio-producto, .cantidad-producto', function (e) {
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

        if (serie.trim().length === 0 || numero.trim().length === 0 || !fecha) {
            modalBonito({
                tipo: 'warn', icono: '⚠️', titulo: 'Datos Generales Incompletos',
                mensaje: 'Por favor, complete la <b>Serie, Número y Fecha</b> de la cotización.',
                ancho: '420px'
            });
            return;
        }

        if (ruc.trim().length === 0 || nombre.trim().length === 0 || direccion.trim().length === 0 || telefono.trim().length === 0) {
            modalBonito({
                tipo: 'warn', icono: '⚠️', titulo: 'Información del Proveedor',
                mensaje: 'Debe completar el <b>RUC, Razón Social, Dirección y Teléfono</b> del proveedor.',
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
                precio_igv: 0,
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
        formData.append('can_total', $('#total').val());
        formData.append('ind_igv', $('#incluir_igv').is(':checked') ? 1 : 0);
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
                                var item_id = getVal(archivo, 'DOCUMENTO_ITEM');
                                var item = `
                                    <li class="list-group-item" style="display: flex; justify-content: space-between; align-items: center; border-radius: 8px; margin-bottom: 5px;">
                                        <div>
                                            <i class="fa fa-file-pdf-o text-danger"></i> 
                                            <span class="nombre-archivo">${nom}.${ext}</span>
                                        </div>
                                        <button type="button" class="btn btn-xs btn-danger btn-eliminar-archivo-existente" 
                                                data-id="${item_id}" title="Eliminar archivo">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </li>`;
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
        var $li = $btn.closest('li');

        if ($li.hasClass('a-eliminar')) {
            // Desmarcar
            $li.removeClass('a-eliminar').css({
                'text-decoration': 'none',
                'opacity': '1',
                'background-color': '#fff'
            });
            $btn.find('i').attr('class', 'fa fa-trash');
            $btn.removeClass('btn-info').addClass('btn-danger');
            archivos_a_eliminar = archivos_a_eliminar.filter(id => id !== idItem);
        } else {
            // Marcar para eliminar
            $li.addClass('a-eliminar').css({
                'text-decoration': 'line-through',
                'opacity': '0.5',
                'background-color': '#f8d7da'
            });
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

});
