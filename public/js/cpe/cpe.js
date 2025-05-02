$(document).ready(function(){
    var carpeta = $("#carpeta").val();
    $(".containercpe").on('click','.btn_cargando', function() {
        //event.preventDefault();
        //abrircargando();
        //abrircargando();

    });

    $('.frmbuscar').submit(function() {
        // Aquí puedes ejecutar cualquier código que desees después de enviar el formulario
        abrircargando();
    });


    $(".cfedocumento").on('click','.buscardocumentorr', function() {

        event.preventDefault();
        var fechainicio             =   $('#fechainicio').val();
        var fechafin                =   $('#fechafin').val();
        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();


        data            =   {
                                _token                  : _token,
                                fechainicio             : fechainicio,
                                fechafin                : fechafin,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-vaidar-rr");

    });



    $(".cfedocumento").on('click','.buscardocumento', function() {

        event.preventDefault();
        var periodo_id           =   $('#periodo_id').val();
        var empresa_id           =   $('#empresa_id').val();
        var idopcion             =   $('#idopcion').val();
        debugger;
        var _token               =   $('#token').val();
        //validacioones
        if(periodo_id ==''){ alerterrorajax("Seleccione una periodo."); return false;}
        if(empresa_id =='' || empresa_id == null){ alerterrorajax("Seleccione un proveedor."); return false;}

        data            =   {
                                _token                  : _token,
                                periodo_id              : periodo_id,
                                empresa_id              : empresa_id,

                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-sire-compra");

    });


    $(".cfedocumento").on('dblclick','.dobleclickpc', function(e) {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        var data_cliente            =   $(this).attr('data_cliente');
        var fechainicio             =   $('#fechainicio').val();
        var fechafin                =   $('#fechafin').val();
        data                        =   {
                                            _token                  : _token,
                                            data_cliente            : data_cliente,
                                            fechainicio             : fechainicio,
                                            fechafin                : fechafin,
                                            idopcion                : idopcion,
                                        };

        ajax_modal(data,"/ajax-modal-vaidar-rr-is",
                  "modal-detalle-rr","modal-detalle-rr-container");




    });



});




