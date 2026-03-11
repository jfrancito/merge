 $(document).ready(function(){

    var carpeta = $("#carpeta").val();

  $(".contratoacopio").on('change', '#empresa_id', function () {
        var empresa_id = $('#empresa_id').val();
        var _token = $('#token').val();
        debugger;

        var link = "/ajax-combo-cuenta-anti";
        var contenedor = "ajax_combo_cuenta";
        data = {
            _token: _token,
            empresa_id: empresa_id
        };
        ajax_normal_combo(data, link, contenedor);

    });

    $(".contratoacopio").on('change', '#cuenta_id', function () {
        var cuenta_id = $('#cuenta_id').val();
        var _token = $('#token').val();
        debugger;
        var link = "/ajax-combo-subcuenta-anti";
        var contenedor = "ajax_combo_subcuenta";
        data = {
            _token: _token,
            cuenta_id: cuenta_id
        };
        ajax_normal_combo(data, link, contenedor);

    });


    // Inicializar máscara para importe
    $('.importe_mask').inputmask({ 
        'alias': 'numeric', 
        'groupSeparator': ',', 
        'autoGroup': true, 
        'digits': 2, 
        'digitsOptional': false, 
        'prefix': '', 
        'placeholder': '0'
    });



    function calcularTotalProyeccion() {
        var total = 0;
        $('.importe_detalle_val').each(function() {
            var valor = $(this).val();
            if(!isNaN(valor) && valor.length > 0) {
                total += parseFloat(valor);
            }
        });
        
        // Formatear como moneda visualmente
        var totalFormateado = total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        $('#footer-total').text(totalFormateado);
    }

    // Eliminar detalle
    $('#tbody-proyeccion').on('click', '.btn-remove-detalle', function() {
        $(this).closest('tr').remove();
        calcularTotalProyeccion();
    });

    // Evento para agregar nuevo detalle desde los inputs generales
    $('.btn-agregar-detalle').on('click', function(e) {
        e.preventDefault();
        
        var fecha = $('#fecha_detalle_input').val();
        var tercero_id = $('#tercero_id_detalle_input').val();
        
        // Tratar de obtener el nombre o usar el id (que sirve como tag)
        var tercero_text = '';
        var selectData = $('#tercero_id_detalle_input').select2('data');
        if(selectData && selectData.length > 0) {
            tercero_text = selectData[0].text;
        } else {
            tercero_text = tercero_id;
        }

        var importe_texto = $('#importe_detalle_input').val();
        var importe_num = importe_texto.replace(/,/g, '');

        if (!fecha || !tercero_id || !importe_texto || parseFloat(importe_num) <= 0) {
            alerterrorajax('Debe completar la Fecha, Tercero a Pagar (o escribir uno nuevo) y el Importe mayor a 0 para agregarlo.');
            return;
        }

        // VALIDACIÓN: La suma total de detalles no puede superar al importe a habilitar
        var total_actual_detalles = 0;
        $('.importe_detalle_val').each(function() {
            total_actual_detalles += parseFloat($(this).val()) || 0;
        });
        
        var importe_habilitar = parseFloat($('#importe_habilitar').val().replace(/,/g, '')) || 0;
        var nuevo_monto = parseFloat(importe_num);
        
        if ((total_actual_detalles + nuevo_monto) > (importe_habilitar + 0.01)) { // Tolerancia mínima por decimales
            alerterrorajax('La suma de los anticipos (S/ ' + (total_actual_detalles + nuevo_monto).toLocaleString('en-US', {minimumFractionDigits: 2}) + ') no puede superar el Importe a Habilitar (S/ ' + importe_habilitar.toLocaleString('en-US', {minimumFractionDigits: 2}) + ').');
            return;
        }

        var importeFormateado = parseFloat(importe_num).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        
        var rowHtml = '<tr>' +
                        '<td style="vertical-align: middle;">' +
                            fecha +
                            '<input type="hidden" name="fecha_detalle[]" value="' + fecha + '">' +
                        '</td>'+
                        '<td style="vertical-align: middle;">' +
                            tercero_text +
                            '<input type="hidden" name="tercero_id_detalle[]" value="' + tercero_id + '">' +
                        '</td>' +
                        '<td style="vertical-align: middle;">' +
                            'S/ ' + importeFormateado +
                            '<input type="hidden" name="importe_detalle[]" class="importe_detalle_val" value="' + importe_num + '">' +
                        '</td>' +
                        '<td style="text-align:center; vertical-align: middle;">' +
                            '<button type="button" class="btn btn-danger btn-sm btn-remove-detalle" style="padding: 6px 12px; border-radius: 4px;"><i class="mdi mdi-delete"></i></button>' +
                        '</td>' +
                      '</tr>';
        
        $('#tbody-proyeccion').append(rowHtml);

        calcularTotalProyeccion();

        // Limpiar inputs
        $('#fecha_detalle_input').val('');
        $('#tercero_id_detalle_input').val(null).trigger('change');
        $('#importe_detalle_input').val('');
        
    });

    function calcularProyeccion() {
        var total = parseFloat($('#total').val().replace(/,/g, '')) || 0;
        var precio = parseFloat($('#precio_referencia').val().replace(/,/g, '')) || 0;
        var proyeccion = total * precio;
        
        $('#proyeccion').val(proyeccion.toFixed(2)).trigger('input');

        // Validar si el importe habilitar actual ya supera la nueva proyección
        validarImporteHabilitar();
    }

    function validarImporteHabilitar() {
        var proyeccion = parseFloat($('#proyeccion').val().replace(/,/g, '')) || 0;
        var habilitar = parseFloat($('#importe_habilitar').val().replace(/,/g, '')) || 0;

        // Validar contra la suma de detalles ya agregados
        var total_detalles = 0;
        $('.importe_detalle_val').each(function() {
            total_detalles += parseFloat($(this).val()) || 0;
        });

        if (habilitar < (total_detalles - 0.01)) {
            alerterrorajax('El "Importe a Habilitar" (S/ ' + habilitar.toLocaleString('en-US', {minimumFractionDigits: 2}) + ') no puede ser menor a la suma de los anticipos ya registrados (S/ ' + total_detalles.toLocaleString('en-US', {minimumFractionDigits: 2}) + ').');
            $('#importe_habilitar').val(total_detalles.toFixed(2)).trigger('input');
            return;
        }

        if (habilitar > (proyeccion + 0.01)) {
            alerterrorajax('El "Importe a Habilitar" no puede ser mayor a la "Proyección" (S/ ' + proyeccion.toLocaleString('en-US', {minimumFractionDigits: 2}) + ').');
            $('#importe_habilitar').val(proyeccion.toFixed(2)).trigger('input');
        }
    }

    // Escuchar cambios en total y precio de referencia
    $('#total, #precio_referencia').on('keyup change input', function() {
        calcularProyeccion();
    });

    // Escuchar cambios en importe_habilitar
    $('#importe_habilitar').on('blur change', function() {
        validarImporteHabilitar();
    });

    // Validación y confirmación antes de guardar
    $('#frmpm').on('submit', function(e) {
        e.preventDefault();

        var filas_detalle = $('#tbody-proyeccion tr').length;
        if (filas_detalle === 0) {
            alerterrorajax('Debe agregar al menos un anticipo en la Proyección de Anticipos.');
            return false;
        }

        var form = this;

        $.confirm({
            title: '¿Confirma el registro?',
            content: '¿Está seguro de guardar este Contrato de Acopio?',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    form.submit();
                },
                cancelar: function () {
                    // $.alert('Se canceló el registro');
                }
            }
        });
    });



});



