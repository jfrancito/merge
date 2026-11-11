$(document).ready(function(){

    var carpeta = $("#carpeta").val();


    $(".apafaconei").on('click','.btn-next', function(e) {
        $('.nav-tabs .apafa').tab('show');
    });

    $(".apafaconei").on('click','.btn-buscar_dni', function(e) {
        event.preventDefault();
        var data_dni                =   $(this).attr('data_dni');
        var data_nombre             =   $(this).attr('data_nombre');
        var dni                     =   $('#'+data_dni).val();

        var _token                  =   $('#token').val();
        actualizar_ajax_dni(_token,carpeta,dni,data_nombre);


    });


    function actualizar_ajax_dni(_token,carpeta,dni,nombre,apellidopaterno,apellidomaterno){
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-buscar-dni-ugel",
            data    :   {
                            _token          : _token,
                            dni             : dni
                        },
            success: function (data){
                cerrarcargando();
                debugger;
                var array        = $.parseJSON(data);
                var nombrea      = array[1];
                var apellidopa   = array[2];
                var apellidoma   = array[3];
                $('#'+nombre).val(nombrea+' '+apellidopa+' '+apellidoma);
            
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });
    }



});

