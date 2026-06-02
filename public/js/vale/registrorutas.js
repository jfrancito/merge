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
});
