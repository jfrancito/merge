$(document).ready(function(){

    var carpeta = $("#carpeta").val();


    $(".areaacopio").on('click','.buscardocumento', function() {

        event.preventDefault();

        var operacion_id            =   $('#operacion_id').val();
        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        data            =   {
                                _token                  : _token,
                                operacion_id            : operacion_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-gestion-acopio");


    });





});
