$(document).ready(function () {
        var carpeta = $("#carpeta").val();

        $('#filtrarpersonal').on('click', function () {

                let _token   = $('#token').val();
                let sede     = $('#sede_select').val();
                let gerencia = $('#gerencia_select').val();
                let area     = $('#area_select').val();

                $.ajax({
                    type: "POST",
                    url: carpeta + "/filtro_personal_autoriza",
                    data: {
                        _token   : _token,
                        sede     : sede,
                        gerencia : gerencia,
                        area     : area
                    },
                    success: function(data) {
                    let table = $('#personalautoriza').DataTable();
                    table.clear().draw();

                    if (data.length > 0) {
                        data.forEach(function(item) {
                            const nombreCompleto = item.nombres + ' ' + item.apellidopaterno + ' ' + item.apellidomaterno;

                    let opciones = '<select class="form-control select-personal">';
                    opciones += '<option value="">-- Seleccionar --</option>';

                    data.forEach(function(opt) {
                        const nombreOpt = opt.nombres + ' ' + opt.apellidopaterno + ' ' + opt.apellidomaterno;
                        const selected = (opt.cod_trab === item.cod_autorizado) ? 'selected' : '';
                        opciones += `<option value="${opt.cod_trab}" ${selected}>${nombreOpt}</option>`;
                    });

                    opciones += '</select>';
                            table.row.add([
                                    nombreCompleto + `<input type="hidden" class="cod-trab" value="${item.cod_trab}">`,
                                    item.cadgerencia + `<input type="hidden" class="gerencia-id" value="${item.gerencia_id}">`,
                                    item.cadarea + `<input type="hidden" class="area-id" value="${item.area_id}">`,
                                    item.cadcargo + `<input type="hidden" class="cargo-id" value="${item.cargo_id}">`,
                                    opciones
                                    ]).draw(false);
                            });
                    } else {
                            $('.ajaxvacio').html("No se encontraron resultados con los filtros seleccionados.");
                        }
                    },
                    error: function () {
                        alerterrorajax('Error al filtrar personal');
                    }
                });
            });


           $('#btnGuardarPersonal').on('click', function () {
           let _token = $('#token').val();
           let sede = $('#sede_select').val();
           let dataAGuardar = [];

        $('#personalautoriza tbody tr').each(function () {
            const fila = $(this);
            const personal = fila.find('td').eq(0).text().trim();
            const gerencia = fila.find('td').eq(1).text().trim();
            const area = fila.find('td').eq(2).text().trim();
            const cargo = fila.find('td').eq(3).text().trim();
            
            const gerencia_id = fila.find('.gerencia-id').val();
            const area_id = fila.find('.area-id').val();
            const cargo_id = fila.find('.cargo-id').val();
            const cod_trab = fila.find('.cod-trab').val();


            const cod_autoriza = fila.find('select.select-personal').val();  
            const txt_autoriza = fila.find('select.select-personal option:selected').text().trim();

            if (cod_autoriza !== '') {
                dataAGuardar.push({
                     cod_trab: cod_trab,
                    personal: personal,
                    gerencia: gerencia,
                    gerencia_id: gerencia_id,
                    area: area,
                    area_id: area_id,
                    cargo: cargo,
                    cargo_id: cargo_id,
                    cod_autoriza: cod_autoriza,
                    txt_autoriza: txt_autoriza
                });
            }
                });

        if (dataAGuardar.length === 0) {
            alerterrorajax('Debe seleccionar al menos un responsable para autorizar.');
            return;
        }

        $.ajax({
            type: "POST",
            url: carpeta + "/guardar_personal_autoriza",
            data: {
                _token: _token,
                registros: dataAGuardar,
                centro_osiris_id: sede
            },
            success: function (response) {
                if (response.success) {
                    alertajax('Registros guardados correctamente.');

                    // Limpia filtros
                    $('#sede_select').val('').trigger('change');
                    $('#gerencia_select').val('').trigger('change');
                    $('#area_select').val('').trigger('change');

                    let table = $('#personalautoriza').DataTable();
                    table.clear().draw();
                } else {
                    alerterrorajax(response.message || 'Error inesperado.');
                }
            },
            error: function () {
                alerterrorajax('Error al guardar los datos.');
            }
        });
    });

});







  /*

        console.log(sede);

        data = {
            _token                                   : _token,
                       sede                             : sede,
                       gerencia                         : gerencia,
                       area                             : area
                };

        ajax_normal_combo(data, "/filtro_personal_autoriza", "listaajax")*/