$(document).ready(function(){

    var carpeta = $("#carpeta").val();


    $(".areaacopio").on('click','.buscardocumentolqc', function() {

        event.preventDefault();

        var operacion_id            =   $('#operacion_id').val();
        var centro_id            =   $('#centro_id').val();

        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        data            =   {
                                _token                  : _token,
                                operacion_id            : operacion_id,
                                centro_id               : centro_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-gestion-acopio");


    });


    $(".areaacopio").on('dblclick','.btn_detalle_deuda', function(e) {

        var _token                  =   $('#token').val();
        var data_id_doc             =   $(this).attr('data_id_doc');
        var idopcion                =   $('#idopcion').val();

        data                        =   {
                                            _token                  : _token,
                                            data_id_doc             : data_id_doc,
                                            idopcion                : idopcion,
                                        };

        ajax_modal(data,"/ajax-modal-detalle-deuda-contrato",
                  "modal-detalle-entregable","modal-detalle-entregable-container");

    });



});
