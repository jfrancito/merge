function mostrarAlertaPremium(tipo, mensaje) {
    let titulo = tipo === 'success' ? '¡Bien Hecho!' : '¡Error!';
    let iconoHtml = tipo === 'success' 
        ? '<i class="mdi mdi-check"></i>' 
        : '<i class="mdi mdi-close"></i>';
    
    let iconoClase = tipo === 'success' ? 'success' : 'error';
    
    $('#iconoPremiumAlerta').removeClass('success error').addClass(iconoClase).html(iconoHtml);
    $('#tituloPremiumAlerta').text(titulo);
    $('#mensajePremiumAlerta').text(mensaje);
    
    $('#modalPremiumAlerta').modal('show');
}

$(document).ready(function () {
        var carpeta = $("#carpeta").val();



        $('#filtrarpersonal').on('click', function () {
                let _token   = $('#token').val();
                let sede     = $('#sede_select').val();
                let gerencia = $('#gerencia_select').val();
                let area     = $('#area_select').val();

                if (!sede || !gerencia || !area) {
                    mostrarAlertaPremium('error', 'Debe completar todos los campos (Sede, Gerencia y Área) para poder filtrar.');
                    return false;
                }

            $.ajax({
                    type: "POST",
                    url: carpeta + "/filtro_personal_autoriza",
                    data: {
                        _token   : _token,
                        sede     : sede,
                        gerencia : gerencia,
                        area     : area
                    },
                    success: function(response) {
                        let table = $('#personalautoriza').DataTable();

                        // Destruir select2 previos
                        try {
                            $('#personalautoriza .select-personal').select2('destroy');
                            $('#personalautoriza .select-tipo-linea').select2('destroy');
                        } catch (e) {}

                        table.clear().draw();

                       
                        const tipos_linea = response.tipos_linea || window.tipos_linea || {};
                        const data = response.data || response || [];
                        const todos_los_trabajadores = response.todos_los_trabajadores || [];

                        if (data.length > 0) {
                            data.forEach(function(item) {
                                const nombreCompleto = `${item.nombres} ${item.apellidopaterno} ${item.apellidomaterno}`;

                               
                              // Crear el select de Tipo de Línea y marcar el valor actual si existe
                                let selectTipoLinea = '<select class="form-control select-tipo-linea" style="width:200px;">';
                                selectTipoLinea += '<option value="">-- Seleccionar --</option>';
                                Object.entries(tipos_linea).forEach(function([cod_linea, txt_linea]) {
                                    const selected = (cod_linea === item.cod_linea_autorizado) ? 'selected' : '';
                                    selectTipoLinea += `<option value="${cod_linea}" ${selected}>${txt_linea}</option>`;
                                });
                                selectTipoLinea += '</select>';


                               
                                let opciones = '<select class="form-control select-personal" style="width:100%; min-width:220px;">';
                                opciones += '<option value="">-- Seleccionar --</option>';
                                todos_los_trabajadores.forEach(function(opt) {
                                    const nombreOpt = `${opt.apellidopaterno} ${opt.apellidomaterno} ${opt.nombres}`;
                                    const selected = (opt.cod_trab === item.cod_autorizado) ? 'selected' : '';
                                    opciones += `<option value="${opt.cod_trab}" ${selected}>${nombreOpt}</option>`;
                                });
                                opciones += '</select>';

                               
                                table.row.add([
                                    nombreCompleto + `<input type="hidden" class="cod-trab" value="${item.cod_trab}">`,
                                    selectTipoLinea,
                                    item.cadgerencia + `<input type="hidden" class="gerencia-id" value="${item.gerencia_id}">`,
                                    item.cadarea + `<input type="hidden" class="area-id" value="${item.area_id}">`,
                                    item.cadcargo + `<input type="hidden" class="cargo-id" value="${item.cargo_id}">`,
                                    opciones
                                ]).draw(false);
                            });

                            // Inicializar select2 con buscador interactivo
                            $('#personalautoriza .select-personal').select2({
                                placeholder: "-- Seleccionar --",
                                allowClear: true,
                                width: '100%'
                            });

                            $('#personalautoriza .select-tipo-linea').select2({
                                placeholder: "-- Seleccionar --",
                                allowClear: true,
                                width: '100%'
                            });
                        } else {
                            $('.ajaxvacio').html(`
                                <div class="icon-vacio" style="background: linear-gradient(135deg, #e53e3e 0%, #fc8181 100%) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important;">
                                    <i class="fa fa-exclamation-circle" style="font-size: 22px;"></i>
                                </div>
                                <p style="color: #e53e3e; font-weight: 600; margin: 0;">No se encontraron trabajadores activos con los filtros seleccionados.</p>
                            `);
                        }
                    },
                    error: function () {
                        mostrarAlertaPremium('error', 'Error al filtrar personal');
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
            const gerencia = fila.find('td').eq(2).text().trim();
            const area = fila.find('td').eq(3).text().trim();
            const cargo = fila.find('td').eq(4).text().trim();
            
            const gerencia_id = fila.find('.gerencia-id').val();
            const area_id = fila.find('.area-id').val();
            const cargo_id = fila.find('.cargo-id').val();
            const cod_trab = fila.find('.cod-trab').val();


            const cod_autoriza = fila.find('select.select-personal').val();  
            const txt_autoriza = fila.find('select.select-personal option:selected').text().trim();


            const cod_linea = fila.find('select.select-tipo-linea').val() || null;
            const txt_linea = fila.find('select.select-tipo-linea option:selected').val() ? fila.find('select.select-tipo-linea option:selected').text().trim() : null;

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
                    txt_autoriza: txt_autoriza,
                    cod_linea: cod_linea,   
                    txt_linea: txt_linea
                });
            }
        });

        if (dataAGuardar.length === 0) {
            mostrarAlertaPremium('error', 'Debe seleccionar al menos un responsable para autorizar.');
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
                    mostrarAlertaPremium('success', 'Registros guardados correctamente.');

                    // Limpia filtros
                    $('#sede_select').val('').trigger('change');
                    $('#gerencia_select').val('').trigger('change');
                    $('#area_select').val('').trigger('change');

                    let table = $('#personalautoriza').DataTable();
                    table.clear().draw();
                } else {
                    mostrarAlertaPremium('error', response.message || 'Error inesperado.');
                }
            },
            error: function () {
                mostrarAlertaPremium('error', 'Error al guardar los datos.');
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