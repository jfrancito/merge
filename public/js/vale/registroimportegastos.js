$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    // ===================== GUARDAR / ACTUALIZAR =====================
    $(".importegastosprincipal").on('click', '#asignarimportegastos', function(e) {
        e.preventDefault();

        let _token            = $('#token').val();
        let cod_centro        = $('#cliente_select').val();
        let cod_departamento  = $('#cliente_select1').val();
        let cod_provincia     = $('#cliente_select2').val();
        let cod_distrito      = $('#cliente_select3').val();
        let can_total_importe = $('#can_total_importe').val();
        let cod_tipo          = $('#cod_tipo').val();
        let ind_destino       = $('#ind_destino').val();
        let can_combustible   = $('#can_combustible').val();
        let cod_linea         = $('#cliente_select4').val();
        let importe_gastos_id = $('#importe_gastos_id').val();
        let opcion            = (!importe_gastos_id ? 'I' : 'U');

        if (!cod_centro || !cod_departamento || !cod_provincia || !cod_distrito || 
            !can_total_importe || !cod_tipo || !ind_destino || !cod_linea) {
            alerterrorajax("Todos los campos son obligatorios.");
            return;
        }

        if (parseFloat(can_total_importe) < 0 || isNaN(parseFloat(can_total_importe))) {
            alerterrorajax("El campo 'importe' debe ser un número positivo mayor a cero.");
            return;
        }

        // VALIDAR DESTINO
        $.ajax({
            type: "POST",
            url: carpeta + "/validar_destino_distrito",
            data: {
                _token: _token,
                cod_distrito: cod_distrito,
                cod_centro: cod_centro
            },
            success: function(response) {
                let destinoExistente = response.ind_destino;

                if (destinoExistente !== null && parseInt(destinoExistente) !== parseInt(ind_destino)) {
                    alerterrorajax("El distrito ya tiene un indicador diferente asignado. Debe usar el mismo valor.");
                    return;
                }

                // GUARDAR O ACTUALIZAR
                $.ajax({
                    type: "POST",
                    url: carpeta + "/registrar_importe_gastos",
                    data: {
                        _token,
                        cod_centro,
                        cod_departamento,
                        cod_provincia,
                        cod_distrito,
                        can_total_importe,
                        cod_tipo,
                        ind_destino,
                        can_combustible,
                        cod_linea,
                        importe_gastos_id,
                        opcion
                    },
                    success: function(data) {
                        if (data.error) {
                            alerterrorajax(data.error);
                            return;
                        }
                        alertajax("Importe registrado correctamente.");
                        location.reload();
                    },
                    error: function(data) {
                        error500(data);
                    }
                });
            },
            error: function(error) {
                alerterrorajax("Error validando el distrito.");
            }
        });
    });

    // ===================== DOBLE CLICK: EDITAR =====================
    $(document).on('dblclick', '#importegastos tbody tr td', function () {
            const $celda = $(this);
            const $fila = $celda.closest('tr');
            const _token = $('#token').val();
            const carpeta = $("#carpeta").val();

            // Detectar qué columna fue la clickeada
            const colIndex = $celda.index();
            let importegastos_id = null;

            if (colIndex === 5) { // columna "Gerente"
                importegastos_id = $fila.data('id-gerente');
            } else if (colIndex === 6) { // columna "Jefe"
                importegastos_id = $fila.data('id-jefe');
            } else if (colIndex === 7) { // columna "Demás Líneas"
                importegastos_id = $fila.data('id-demas');
            } else {
                return; // no hacer nada si hacen doble clic en otra celda
            }

            if (!importegastos_id) {
                alerterrorajax("No hay un importe registrado en esta línea.");
                return;
            }

            // Solicitar datos al backend para cargar el formulario
            $.ajax({
                type: "POST",
                url: carpeta + "/data_importe_gastos",
                data: {
                    _token: _token,
                    importegastos_id: importegastos_id
                },
                success: function (data) {
                    let data_left = JSON.parse(data);

                    // === Llenar el formulario ===
                    $('#cliente_select').val(data_left["0"]["COD_CENTRO"]).trigger('change');
                    let cod_departamento = (data_left[0]["COD_DEPARTAMENTO"] || '').trim().toUpperCase();
                    $('#cliente_select1').val(cod_departamento).trigger('change.select2');
                    let cod_provincia    = data_left[0]["COD_PROVINCIA"];
                    let cod_distrito     = data_left[0]["COD_DISTRITO"];

                    // Cargar provincias (manual, sin depender del change)
                    $.ajax({
                        type: "POST",
                        url: carpeta + "/obtener_provincia_por_departamento",
                        data: { _token, cod_departamento },
                        success: function (provincias) {
                            let $provinciaSelect = $('#cliente_select2');
                            $provinciaSelect.empty().append('<option value="">Seleccione Provincia</option>');
                            $.each(provincias, function(index, provincia) {
                                $provinciaSelect.append('<option value="' + provincia.cod_categoria + '">' + provincia.nom_categoria + '</option>');
                            });

                            // Seleccionamos provincia
                            $provinciaSelect.val(cod_provincia);

                            // Cargar distritos
                            $.ajax({
                                type: "POST",
                                url: carpeta + "/obtener_distrito_por_provincia",
                                data: { _token, cod_provincia },
                                success: function (distritos) {
                                    let $distritoSelect = $('#cliente_select3');
                                    $distritoSelect.empty().append('<option value="">Seleccione Distrito</option>');
                                    $.each(distritos, function(index, distrito) {
                                        $distritoSelect.append('<option value="' + distrito.cod_categoria + '">' + distrito.nom_categoria + '</option>');
                                    });
                                    $distritoSelect.val(cod_distrito);
                                }
                            });
                        }
                    });

                    $('#can_total_importe').val(data_left["0"]["CAN_TOTAL_IMPORTE"]);
                    $('#cod_tipo').val(data_left["0"]["COD_TIPO"]).trigger('change');
                    $('#ind_destino').val(data_left["0"]["IND_DESTINO"]).trigger('change');
                    $('#can_combustible').val(data_left["0"]["CAN_COMBUSTIBLE"]);
                    $('#cliente_select4').val(data_left["0"]["COD_LINEA"]).trigger('change');
                    $('#importe_gastos_id').val(importegastos_id);

                    $('#asignarimportegastos').text('Modificar');
                },
                error: function (data) {
                    error500(data);
                }
        });
    });


    // ===================== ELIMINAR =====================
    $(".importegastosprincipal").on('click', '.delete-registroimportegastos', function(e) {
        e.preventDefault();

        var importegastos_id = $(this).closest('tr').attr('data_importe_gastos');
        var _token = $('#token').val();

        $.ajax({
            type: "POST",
            url: carpeta + "/eliminar_importe_gastos",
            data: { _token, importegastos_id },
            success: function(response) {
                if (response.success) {
                    $('tr[data_importe_gastos="'+importegastos_id+'"]').remove();
                    alertajax('Registro eliminado correctamente.');
                     location.reload();
                } else {
                    alerterrorajax('Error al eliminar el importe de gastos.');
                }
            },
            error: function(data) {
                alerterrorajax('Error al eliminar el importe de gastos.');
            }
        });
    });

    // ===================== DEPENDENCIAS: DEPARTAMENTO → PROVINCIA =====================
    $(".importegastosprincipal").on('change', '#cliente_select1', function(e) {
        e.preventDefault();
        let cod_departamento = $(this).val();  
        let _token = $('#token').val();

        $.ajax({
            type: "POST",
            url: carpeta + "/obtener_provincia_por_departamento",
            data: { _token, cod_departamento },
            success: function (data) {
                let $provinciaSelect = $('#cliente_select2');
                $provinciaSelect.empty().append('<option value="">Seleccione Provincia</option>');
                $.each(data, function(index, provincia) {
                    $provinciaSelect.append('<option value="' + provincia.cod_categoria + '">' + provincia.nom_categoria + '</option>');
                });
            },
            error: function (data) { error500(data); }
        });
    });

    // ===================== DEPENDENCIAS: PROVINCIA → DISTRITO =====================
    $(".importegastosprincipal").on('change', '#cliente_select2', function(e) {
        e.preventDefault();
        let cod_provincia = $(this).val();  
        let _token = $('#token').val();

        $.ajax({
            type: "POST",
            url: carpeta + "/obtener_distrito_por_provincia", 
            data: { _token, cod_provincia },
            success: function (data) {
                let $distritoSelect = $('#cliente_select3');
                $distritoSelect.empty().append('<option value="">Seleccione Distrito</option>');
                $.each(data, function(index, distrito) {
                    $distritoSelect.append('<option value="' + distrito.cod_categoria + '">' + distrito.nom_categoria + '</option>');
                });
            },
            error: function (data) { error500(data); }
        });
    });

    // ===================== SELECCIONAR FILA =====================
    $(document).on('click', '#importegastos tbody tr', function () {    
        $('#importegastos tbody tr').removeClass('selected');
        $(this).addClass('selected');
    });

    // ===================== OBTENER IDS AGRUPADOS (Gerente / Jefe / Demás) =====================
    $(".importegastosprincipal").on('click', '#importegastos td', function () {
        const fila = $(this).closest('tr');

        const idGerente = fila.data('id-gerente');
        const idJefe    = fila.data('id-jefe');
        const idDemas   = fila.data('id-demas');

        console.log("ID Gerente:", idGerente);
        console.log("ID Jefe:", idJefe);
        console.log("ID Demás:", idDemas);

        // Ejemplo: si quieres llenar un input oculto con uno de los IDs
        // $('#importe_gastos_id').val(idGerente || idJefe || idDemas);
    });
});
