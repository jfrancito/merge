$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    $(".cfedocumento").on('click','.buscardocumento', function() {

        event.preventDefault();

        var fecha_inicio         =   $('#fecha_inicio').val();
        var fecha_fin            =   $('#fecha_fin').val();
        var proveedor_id         =   $('#proveedor_id').val();
        var estado_id            =   $('#estado_id').val();
        var operacion_id         =   $('#operacion_id').val();
        debugger;

        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        //validacioones
        if(fecha_inicio ==''){ alerterrorajax("Seleccione una fecha inicio."); return false;}
        if(fecha_fin ==''){ alerterrorajax("Seleccione una fecha fin."); return false;}

        data            =   {
                                _token                  : _token,
                                fecha_inicio            : fecha_inicio,
                                fecha_fin               : fecha_fin,
                                proveedor_id            : proveedor_id,
                                estado_id               : estado_id,
                                operacion_id               : operacion_id,

                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-fe");

    });


    $(".agestioncomprobante").on('click','.buscardocumentoadmin', function() {

        event.preventDefault();

        var operacion_id            =   $('#operacion_id').val();
        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        data            =   {
                                _token                  : _token,
                                operacion_id            : operacion_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-gestion-admin");

    });





});




