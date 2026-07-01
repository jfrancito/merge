$(document).ready(function () {
    // Inicializar Select2 en los combos de ubicación si aún no lo están
    $('.select2').select2({
        width: '100%'
    });

    // Inicializar máscara de moneda (0.00)
    $('.dinero').inputmask("currency", {
        prefix: "",
        radixPoint: ".",
        groupSeparator: ",",
        digits: 2,
        autoGroup: true,
        rightAlign: true,
        allowMinus: false,
        placeholder: "0.00"
    });

    // Obtener las variables base
    var carpeta = $("#carpeta").val();
    var _token = $('#token').val();

    // EVENTO: Cambio de Departamento y Provincia han sido removidos a petición del usuario.
    // Ahora el combo Distrito carga todo directamente igual que el Origen.

    // FUNCIÓN: Mostrar Modal Premium
    function mostrarAlertaPremium(mensaje, tipo) {
        var titulo = "Atención";
        var iconHtml = "";
        
        if (tipo === 'success') {
            titulo = "¡Éxito!";
            iconHtml = '<div style="animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);"><i class="fa fa-check-circle" style="color: #10b981; font-size: 75px; text-shadow: 0 8px 15px rgba(16, 185, 129, 0.3);"></i></div>';
            $('#modalAlertPremium .btn').removeClass('btn-primary btn-danger').addClass('btn-success').css('background', '#10b981');
        } else if (tipo === 'error') {
            titulo = "¡Ups! Ocurrió un problema";
            iconHtml = '<div style="animation: shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;"><i class="fa fa-times-circle" style="color: #ef4444; font-size: 75px; text-shadow: 0 8px 15px rgba(239, 68, 68, 0.3);"></i></div>';
            $('#modalAlertPremium .btn').removeClass('btn-primary btn-success').addClass('btn-danger').css('background', '#ef4444');
        } else if (tipo === 'warning') {
            titulo = "Aviso Importante";
            iconHtml = '<div style="animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);"><i class="fa fa-exclamation-triangle" style="color: #f59e0b; font-size: 70px; text-shadow: 0 8px 15px rgba(245, 158, 11, 0.3);"></i></div>';
            $('#modalAlertPremium .btn').removeClass('btn-success btn-danger').addClass('btn-primary').css('background', '#3b82f6');
        }
        
        $('#modalAlertTitle').text(titulo);
        $('#modalAlertMessage').text(mensaje);
        $('#modalAlertIcon').html(iconHtml);
        $('#modalAlertPremium').modal('show');
    }

    // EVENTO: Buscador en tiempo real de Rutas Creadas
    $('#buscador-rutas').on('keyup', function() {
        var term = $(this).val().toLowerCase();
        $('.accordion-premium .panel').each(function() {
            var text = $(this).find('.route-header-premium').text().toLowerCase();
            if (text.indexOf(term) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // EVENTO: Click en Modificar
    $(document).on('click', '.btn-modificar', function(e) {
        e.preventDefault();
        var cod_origen = $(this).data('origen');
        var cod_destino = $(this).data('destino');

        // Cargar combos y bloquear
        $('#origen').val(cod_origen).trigger('change.select2').prop('disabled', true);
        $('#distrito').val(cod_destino).trigger('change.select2').prop('disabled', true);

        // Activar modo Edición
        $('#ind_tipo_operacion').val('U');
        $('.btn-guardar-matriz').html('<i class="fa fa-save"></i> ACTUALIZAR RUTA');
        $('.btn-limpiar-ruta').show();

        // Limpiar cajas
        $('.input-importe').val('');

        // Leer matriz readonly del acordeon
        var $accordion = $(this).closest('.panel');
        $accordion.find('.td-matriz-readonly').each(function() {
            var cod_tipo = $(this).data('cod-tipo');
            var cod_linea = $(this).data('cod-linea');
            var importe = $(this).data('importe');
            
            if (importe > 0) {
                // Cargar en la cajita
                $('.input-importe[data-cod-tipo="'+cod_tipo+'"][data-cod-linea="'+cod_linea+'"]').val(importe).trigger('change'); // trigger change for inputmask
            }
        });

        // Cambiar de pestaña usando el evento click personalizado y subir scroll
        $('.nav-tabs-premium a[href="#tab-configurar"]').trigger('click');
        $('html, body').animate({ scrollTop: 0 }, 'fast');
    });

    // EVENTO: Eliminar Ruta
    $(document).on('click', '.btn-eliminar', function(e) {
        e.preventDefault();
        var cod_origen = $(this).data('origen');
        var cod_destino = $(this).data('destino');
        var btn = $(this);

        $('#modalConfirmMessage').text('¿Está seguro de que desea eliminar todos los importes de esta ruta? Esta acción es irreversible.');
        
        // Asignar el evento al botón de confirmación, quitando previamente cualquier evento anterior
        $('#btnConfirmAction').off('click').on('click', function() {
            // Cerrar el modal y bloquear el botón origen
            $('#modalConfirmPremium').modal('hide');
            btn.prop('disabled', true);
            
            $.ajax({
                type: 'POST',
                url: carpeta + '/eliminar_matriz_viaticos',
                data: {
                    _token: _token,
                    origen: cod_origen,
                    distrito: cod_destino
                },
                success: function(data) {
                    if (data.success) {
                        mostrarAlertaPremium(data.message, 'success');
                        $('#modalAlertPremium').on('hidden.bs.modal', function () {
                            window.location.reload();
                        });
                    } else {
                        mostrarAlertaPremium(data.message, 'error');
                        btn.prop('disabled', false);
                    }
                },
                error: function() {
                    mostrarAlertaPremium("Ocurrió un error inesperado al eliminar la ruta.", 'error');
                    btn.prop('disabled', false);
                }
            });
        });
        
        // Mostrar el modal
        $('#modalConfirmPremium').modal('show');
    });

    // EVENTO: Limpiar / Nueva Ruta
    $('.btn-limpiar-ruta').on('click', function(e) {
        e.preventDefault();
        $('#origen').val('').trigger('change.select2').prop('disabled', false);
        $('#distrito').val('').trigger('change.select2').prop('disabled', false);
        $('#ind_tipo_operacion').val('I');
        $('.btn-guardar-matriz').html('<i class="mdi mdi-content-save"></i> GUARDAR CONFIGURACIÓN');
        $(this).hide();
        $('.input-importe').val('');
    });

    // EVENTO: Guardar Matriz
    $('.btn-guardar-matriz').on('click', function(e) {
        e.preventDefault();
        var origen = $('#origen').val();
        var nom_origen = $('#origen option:selected').text();
        var distrito = $('#distrito').val();
        var nom_distrito = $('#distrito option:selected').text();
        var ind_tipo_operacion = $('#ind_tipo_operacion').val();

        if(!origen || !distrito) {
            mostrarAlertaPremium("Por favor, seleccione el Origen y el Distrito antes de continuar.", 'warning');
            return;
        }

        var datos = [];
        $('.table-matrix tbody tr').each(function() {
            var inputCells = $(this).find('input.input-importe');
            inputCells.each(function() {
                var val = $(this).val();
                // Omitir comas del formato de inputmask y parsear a float
                var floatVal = parseFloat(val.replace(/,/g, ''));
                
                // Si está vacío o no es un número, lo guardamos como 0
                if (isNaN(floatVal)) {
                    floatVal = 0;
                }
                
                datos.push({
                    cod_tipo: $(this).data('cod-tipo'),
                    txt_nom_tipo: $(this).data('txt-tipo'),
                    cod_linea: $(this).data('cod-linea'),
                    txt_linea: $(this).data('txt-linea'),
                    importe: floatVal.toFixed(2)
                });
            });
        });

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> GUARDANDO...');

        $.ajax({
            type: 'POST',
            url: carpeta + '/guardar_matriz_viaticos',
            data: {
                _token: _token,
                ind_tipo_operacion: ind_tipo_operacion,
                origen: origen,
                nom_origen: nom_origen,
                distrito: distrito,
                nom_distrito: nom_distrito,
                datos: datos
            },
            success: function(data) {
                if(data.success) {
                    mostrarAlertaPremium(data.message, 'success');
                    $('#modalAlertPremium').on('hidden.bs.modal', function () {
                        window.location.reload();
                    });
                } else {
                    mostrarAlertaPremium(data.message, 'error');
                }
            },
            error: function() {
                mostrarAlertaPremium("Ocurrió un error al guardar la información. Contacte con sistemas.", 'error');
            },
            complete: function() {
                var btnText = $('#ind_tipo_operacion').val() === 'U' ? 'ACTUALIZAR RUTA' : 'GUARDAR CONFIGURACIÓN';
                btn.prop('disabled', false).html('<i class="mdi mdi-content-save"></i> ' + btnText);
            }
        });
    });
});
