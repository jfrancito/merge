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

    // EVENTO: Cambio de Departamento
    $('#departamento').on('change', function () {
        var cod_departamento = $(this).val();

        // Limpiar Provincia y Distrito
        $('#provincia').empty().append('<option value="">-- Seleccione Provincia --</option>').trigger('change');
        $('#distrito').empty().append('<option value="">-- Seleccione Distrito --</option>').trigger('change');

        if (cod_departamento) {
            $.ajax({
                type: 'POST',
                url: carpeta + '/obtener_provincia_por_departamento',
                data: {
                    _token: _token,
                    cod_departamento: cod_departamento
                },
                success: function (data) {
                    $.each(data, function (index, element) {
                        $('#provincia').append('<option value="' + element.cod_categoria + '">' + element.nom_categoria + '</option>');
                    });
                    $('#provincia').trigger('change.select2');
                },
                error: function () {
                    console.error("Error al cargar provincias");
                }
            });
        }
    });

    // EVENTO: Cambio de Provincia
    $('#provincia').on('change', function () {
        var cod_provincia = $(this).val();

        // Limpiar Distrito
        $('#distrito').empty().append('<option value="">-- Seleccione Distrito --</option>').trigger('change');

        if (cod_provincia) {
            $.ajax({
                type: 'POST',
                url: carpeta + '/obtener_distrito_por_provincia',
                data: {
                    _token: _token,
                    cod_provincia: cod_provincia
                },
                success: function (data) {
                    $.each(data, function (index, element) {
                        $('#distrito').append('<option value="' + element.cod_categoria + '">' + element.nom_categoria + '</option>');
                    });
                    $('#distrito').trigger('change.select2');
                },
                error: function () {
                    console.error("Error al cargar distritos");
                }
            });
        }
    });

    // EVENTO: Guardar Matriz
    $('.btn-guardar-matriz').on('click', function(e) {
        e.preventDefault();
        var origen = $('#origen').val();
        var nom_origen = $('#origen option:selected').text();
        var departamento = $('#departamento').val();
        var nom_departamento = $('#departamento option:selected').text();
        var provincia = $('#provincia').val();
        var nom_provincia = $('#provincia option:selected').text();
        var distrito = $('#distrito').val();
        var nom_distrito = $('#distrito option:selected').text();

        if(!origen || !departamento || !provincia || !distrito) {
            alert("Por favor, complete todos los filtros de ubicación antes de guardar.");
            return;
        }

        var datos = [];
        $('.table-matrix tbody tr').each(function() {
            var inputCells = $(this).find('input.input-importe');
            inputCells.each(function() {
                var val = $(this).val();
                // Omitir comas del formato de inputmask y parsear a float
                var floatVal = parseFloat(val.replace(/,/g, ''));
                if (!isNaN(floatVal) && floatVal > 0) {
                    datos.push({
                        cod_tipo: $(this).data('cod-tipo'),
                        txt_nom_tipo: $(this).data('txt-tipo'),
                        cod_linea: $(this).data('cod-linea'),
                        txt_linea: $(this).data('txt-linea'),
                        importe: floatVal
                    });
                }
            });
        });

        if (datos.length === 0) {
            alert("Debe ingresar al menos un importe mayor a 0.");
            return;
        }

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> GUARDANDO...');

        $.ajax({
            type: 'POST',
            url: carpeta + '/guardar_matriz_viaticos',
            data: {
                _token: _token,
                origen: origen,
                nom_origen: nom_origen,
                departamento: departamento,
                nom_departamento: nom_departamento,
                provincia: provincia,
                nom_provincia: nom_provincia,
                distrito: distrito,
                nom_distrito: nom_distrito,
                datos: datos
            },
            success: function(data) {
                if(data.success) {
                    alert(data.message);
                    // Opcional: limpiar los inputs
                    // $('.input-importe').val('');
                } else {
                    alert(data.message);
                }
            },
            error: function() {
                alert("Ocurrió un error al guardar la información.");
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="mdi mdi-content-save"></i> GUARDAR CONFIGURACIÓN');
            }
        });
    });
});
