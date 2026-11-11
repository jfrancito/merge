$(document).ready(function () {

        var carpeta = $("#carpeta").val();

        $(".apruebaprincipal").on('click', '#asignarpersonalaprueba', function (e) {
            e.preventDefault();

                let _token              = $('#token').val();
                let sede                = $('#sede_select').val();
                let usuario_aprueba     = $('#usuario_select').val();
                let personal_aprueba_id = $('#personal_aprueba_id').val();

            // AQUÍ VIENE LO QUE TE DECÍA:
            let area  = $('#area_hidden').val();  // <-- Se obtiene el área desde el campo oculto
            let cargo = $('#cargo_hidden').val(); // <-- Se obtiene el cargo desde el campo oculto

            let opcion = (!personal_aprueba_id ? 'I' : 'U');

            if (!sede || !area || !cargo || !usuario_aprueba) {
                alerterrorajax("Todos los campos son obligatorios.");
                return;
            }

            $.ajax({
                type: "POST",
                url: carpeta + "/registrar_personal_aprueba",
                data: {
                    _token: _token,
                    sede: sede,
                    area: area,               // 👈 Ya no provienen de selects visibles
                    cargo: cargo,
                    usuario_aprueba: usuario_aprueba,
                    personal_aprueba_id: personal_aprueba_id,
                    opcion: opcion
                },
                success: function (data) {
                    if (data.error) {
                        alerterrorajax(data.error);
                        return;
                    }

                    alertajax("Personal registrado correctamente.");
                    location.reload();
                },
                error: function (data) {
                    error500(data);
                }
            });
        });

        $('#usuario_select').on('change', function () {
            let usuario_aprueba = $(this).val();
            let _token = $('#token').val();

            if (!usuario_aprueba) return;

            $.ajax({
                type: "POST",
                url: carpeta + "/obtener_area_cargo",
                data: {
                    _token: _token,
                    cod_trab: usuario_aprueba
                },
                success: function (data) {
                    $('#area_hidden').val(data.area_id);
                    $('#cargo_hidden').val(data.cargo_id);
                },
                error: function () {
                    alerterrorajax('No se pudo obtener el área y cargo del usuario.');
                }
            });
        });




        $(".apruebaprincipal").on('dblclick', '.dobleclickpc', function (e) {

            let _token = $('#token').val();
            let personalaprueba_id = $(this).attr('data_personal_aprueba');

            $.ajax({
                  type    :   "POST",
                  url     :   carpeta+"/data_personal_aprueba",
                  data    :   {
                                _token: _token,
                                personalaprueba_id: personalaprueba_id                                               
                              },
               
                success: function (data) {

                   let data_left = JSON.parse(data);
                     
                     $('#sede_select').val(data_left["0"]["COD_CENTRO"]).trigger('change');;
                     $('#area_select').val(data_left["0"]["COD_AREA"]).trigger('change');;
                     $('#cargo_select').val(data_left["0"]["COD_CARGO"]).trigger('change');;
                     $('#usuario_select').val(data_left.COD_APRUEBA).trigger('change');
              


                    $('#personal_aprueba_id').val(personalaprueba_id); 
                    $('#asignarpersonalaprueba').text('Modificar'); 
                },
                error: function (data) {
                    error500(data);
                }
            });
        }); 


        $(".apruebaprincipal").on('click', '.delete-registropersonalaprueba', function(e) {
            e.preventDefault();
            
            var personalaprueba_id = $(this).closest('tr').attr('data_personal_aprueba');
            var _token = $('#token').val();

            $.ajax({
                    type: "POST",
                    url: carpeta + "/eliminar_personal_aprueba",
                    data: {
                        _token: _token,
                        personalaprueba_id: personalaprueba_id
                    },

                success: function(response) {    
                        if (response.success) {       
                        $('tr[data_personal_aprueba="'+personalaprueba_id+'"]').remove();        
                       // location.reload();        

                       alertajax('Registro eliminado correctamente.');
                        } else {
                            alerterrorajax('Error al eliminar el personal aprueba.');
                        }
                },

                error: function(data) {
                    alerterrorajax('Error al eliminar el personal aprueba.');           
                }
            });             
        });

});
