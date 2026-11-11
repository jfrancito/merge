$(document).ready(function(){

    var carpeta = $("#carpeta").val();


    $(".hextorno").on('click','.verhistorialextorno', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        var data_cod_extorno        =   $(this).attr('data_cod_extorno');

        data                        =   {
                                            _token                  : _token,
                                            data_cod_extorno        : data_cod_extorno,
                                            idopcion                : idopcion
                                        };
        ajax_modal(data,"/ajax-modal-historial-extorno",
                  "modal-detalle-requerimiento-masivo","modal-detalle-requerimiento-masivo-container");

    });




});




