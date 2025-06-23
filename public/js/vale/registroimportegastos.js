$(document).ready(function(){

    var carpeta = $("#carpeta").val();

   $(".importegastosprincipal").on('click', '#asignarimportegastos', function(e) {
    e.preventDefault();

    let _token                  = $('#token').val();
    let cod_centro              = $('#cliente_select').val();
    let cod_departamento        = $('#cliente_select1').val();
    let cod_provincia           = $('#cliente_select2').val();
    let cod_distrito            = $('#cliente_select3').val();
    let can_total_importe       = $('#can_total_importe').val();
    let cod_tipo                = $('#cod_tipo').val();
    let ind_destino             = $('#ind_destino').val();
    let can_combustible         = $('#can_combustible').val();
    let importe_gastos_id       = $('#importe_gastos_id').val();
    let opcion                  = (!importe_gastos_id ? 'I' : 'U');

    if (!cod_centro || !cod_departamento || !cod_provincia || !cod_distrito || !can_total_importe || !cod_tipo || !ind_destino) {
        alerterrorajax("Todos los campos son obligatorios.");
        return;
    }

    if (parseFloat(can_total_importe) < 0 || isNaN(parseFloat(can_total_importe))) {
        alerterrorajax("El campo 'importe' debe ser un número positivo mayor a cero.");
        return;
    }

    // VALIDACIÓN DEL IND_DESTINO según COD_DISTRITO
    $.ajax({
        type: "POST",
        url: carpeta + "/validar_destino_distrito",
        data: {
            _token: _token,
            cod_distrito : cod_distrito,
            cod_centro   : cod_centro
        },
        success: function(response) {
            let destinoExistente = response.ind_destino;

            if (destinoExistente !== null && parseInt(destinoExistente) !== parseInt(ind_destino)) {
                alerterrorajax("El distrito ya tiene un indicador diferente asignado. Debe usar el mismo valor.");
                return;
            }

            // Si pasa validación, recién guarda
            $.ajax({
                type: "POST",
                url: carpeta + "/registrar_importe_gastos",
                data: {
                    _token: _token,
                    cod_centro: cod_centro,
                    cod_departamento: cod_departamento,
                    cod_provincia: cod_provincia,
                    cod_distrito: cod_distrito,
                    can_total_importe: can_total_importe,
                    cod_tipo: cod_tipo,
                    ind_destino: ind_destino,
                    can_combustible : can_combustible,
                    importe_gastos_id: importe_gastos_id,
                    opcion: opcion
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


       $(".importegastosprincipal").on('dblclick', '.dobleclickpc', function (e) {
    let _token = $('#token').val();
    let importegastos_id = $(this).attr('data_importe_gastos');

    $.ajax({
        type: "POST",
        url: carpeta + "/data_importe_gastos",
        data: {
            _token: _token,
            importegastos_id: importegastos_id
        },
        success: function (data) {
            let data_left = JSON.parse(data);

            // Llenamos el centro directamente
         
        $('#cliente_select').val(data_left["0"]["COD_CENTRO"]).trigger('change');;
            // Variables necesarias
            let cod_departamento = data_left[0]["COD_DEPARTAMENTO"];
            let cod_provincia    = data_left[0]["COD_PROVINCIA"];
            let cod_distrito     = data_left[0]["COD_DISTRITO"];

            // Seleccionamos el departamento (sin trigger)
            $('#cliente_select1').val(cod_departamento);

            // Paso 1: cargar provincias
            $.ajax({
                type: "POST",
                url: carpeta + "/obtener_provincia_por_departamento",
                data: {
                    _token: _token,
                    cod_departamento: cod_departamento
                },
                success: function (provincias) {
                    let $provinciaSelect = $('#cliente_select2');
                    $provinciaSelect.empty();
                    $provinciaSelect.append('<option value="">Seleccione Provincia</option>');

                    $.each(provincias, function(index, provincia) {
                        $provinciaSelect.append('<option value="' + provincia.cod_categoria + '">' + provincia.nom_categoria + '</option>');
                    });

                    // Seleccionamos la provincia
                    $provinciaSelect.val(cod_provincia);

                    // Paso 2: cargar distritos
                    $.ajax({
                        type: "POST",
                        url: carpeta + "/obtener_distrito_por_provincia",
                        data: {
                            _token: _token,
                            cod_provincia: cod_provincia
                        },
                        success: function (distritos) {
                            let $distritoSelect = $('#cliente_select3');
                            $distritoSelect.empty();
                            $distritoSelect.append('<option value="">Seleccione Distrito</option>');

                            $.each(distritos, function(index, distrito) {
                                $distritoSelect.append('<option value="' + distrito.cod_categoria + '">' + distrito.nom_categoria + '</option>');
                            });

                            // Seleccionamos el distrito
                            $distritoSelect.val(cod_distrito);
                        },
                        error: function (data) {
                            error500(data);
                        }
                    });
                },
                error: function (data) {
                    error500(data);
                }
            });

              $('#cliente_select1').val(data_left["0"]["COD_DEPARTAMENTO"]).trigger('change');;
            $('#can_total_importe').val(data_left["0"]["CAN_TOTAL_IMPORTE"]);
            $('#cod_tipo').val(data_left["0"]["COD_TIPO"]).trigger('change');;
            $('#ind_destino').val(data_left["0"]["IND_DESTINO"]).trigger('change');;
            $('#can_combustible').val(data_left["0"]["CAN_COMBUSTIBLE"]);

            $('#importe_gastos_id').val(importegastos_id);
            $('#asignarimportegastos').text('Modificar');
        },
        error: function (data) {
            error500(data);
        }
    });
});





   $('#cliente_select').val(data_left["0"]["COD_CENTRO"]).trigger('change');;
                     $('#cliente_select1').val(data_left["0"]["COD_DEPARTAMENTO"]).trigger('change');;
                     $('#cliente_select2').val(data_left["0"]["COD_PROVINCIA"]).trigger('change');;
                     $('#cliente_select3').val(data_left["0"]["COD_DISTRITO"]).trigger('change');;
                     $('#can_total_importe').val(data_left["0"]["CAN_TOTAL_IMPORTE"]);
                     $('#cod_tipo').val(data_left["0"]["COD_TIPO"]).trigger('change');;
                     $('#ind_destino').val(data_left["0"]["IND_DESTINO"]).trigger('change');;
                     $('#can_combustible').val(data_left["0"]["CAN_COMBUSTIBLE"]);


   

    $(".importegastosprincipal").on('click', '.delete-registroimportegastos', function(e) {
            e.preventDefault();
            
            var importegastos_id = $(this).closest('tr').attr('data_importe_gastos');
            var _token = $('#token').val();

            $.ajax({
                    type: "POST",
                    url: carpeta + "/eliminar_importe_gastos",
                    data: {
                        _token: _token,
                        importegastos_id: importegastos_id
                    },

                success: function(response) {    
                        if (response.success) {       
                        $('tr[data_importe_gastos="'+importegastos_id+'"]').remove();        
                       // location.reload();        

                       alertajax('Registro eliminado correctamente.');
                        } else {
                            alerterrorajax('Error al eliminar el importe de gastos.');
                        }
                },

                error: function(data) {
                    alerterrorajax('Error al eliminar el importe de gastos.');           
                }
            });  

             
        });






    $(".importegastosprincipal").on('change', '#cliente_select1', function(e) {
        e.preventDefault();
        let cod_departamento = $(this).val();  
        let _token = $('#token').val();

        $.ajax({
            type: "POST",
            url: carpeta + "/obtener_provincia_por_departamento",
            data: {
                _token: _token,
                cod_departamento: cod_departamento
            },
            success: function (data) {
                let $provinciaSelect = $('#cliente_select2'); 
                $provinciaSelect.empty(); 
                $provinciaSelect.append('<option value="">Seleccione Provincia</option>'); 

                $.each(data, function(index, provincia) {
                    $provinciaSelect.append('<option value="' + provincia.cod_categoria + '">' + provincia.nom_categoria + '</option>');
                });
            },
            error: function (data) {
                error500(data);
            }
        });
    });


    $(".importegastosprincipal").on('change', '#cliente_select2', function(e) {
         
        e.preventDefault();
        let cod_provincia = $(this).val();  
        let _token = $('#token').val();

        $.ajax({
            type: "POST",
            url: carpeta + "/obtener_distrito_por_provincia", 
            data: {
                _token: _token,
                cod_provincia: cod_provincia
            },
            success: function (data) {
                let $distritoSelect = $('#cliente_select3'); 
               $distritoSelect.empty(); 
                $distritoSelect.append('<option value="">Seleccione Distrito</option>'); 

                $.each(data, function(index, distrito) {
                    $distritoSelect.append('<option value="' + distrito.cod_categoria + '">' + distrito.nom_categoria + '</option>');
                });
            },
            error: function (data) {
                error500(data);
            }
        });
    });


    
       $(document).ready(function () {
            $('#importegastos tbody').on('click', 'tr', function () {    
                $('#importegastos tbody tr').removeClass('selected');
                $(this).addClass('selected');
            });
        });


});
