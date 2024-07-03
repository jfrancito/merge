$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    $('#aprobar').on('click', function(event){
        event.preventDefault();
        data = dataenviar();
        if(data.length<=0){alerterrorajax("Seleccione por lo menos un Comprobante");return false;}
        var datastring = JSON.stringify(data);
        $('#pedido').val(datastring);

        $.confirm({
            title: '¿Confirma la Aprobacion?',
            content: 'Aprobar los Comprobantes',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    $( "#formpedido" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo Aprobacion');
                }
            }
        });

    });

    $(".areatesoreria").on('click','.buscardocumento', function() {

        event.preventDefault();

        var operacion_id            =   $('#operacion_id').val();
        var estadopago_id           =   $('#estadopago_id').val();

        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        data            =   {
                                _token                  : _token,
                                operacion_id            : operacion_id,
                                estadopago_id           : estadopago_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-gestion-tesoreria");

    });


    $(".areatesoreria").on('dblclick','.dobleclickpc', function(e) {

        var _token                  =   $('#token').val();
        var data_requerimiento_id   =   $(this).attr('data_requerimiento_id');
        var data_linea              =   $(this).attr('data_linea');


        var idopcion                =   $('#idopcion').val();

        data                        =   {
                                            _token                  : _token,
                                            data_requerimiento_id   : data_requerimiento_id,
                                            data_linea              : data_linea,
                                            idopcion                : idopcion,
                                        };
        ajax_modal(data,"/ajax-modal-tesoreria-pago",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });



    function dataenviar(){
            var data = [];
            $(".listatabla tr").each(function(){
                check   = $(this).find('input');
                nombre  = $(this).find('input').attr('id');
                debugger;
                if(nombre != 'todo'){
                    if($(check).is(':checked')){
                        data.push({id: $(check).attr("id")});
                    }               
                }
            });
            return data;
    }

});
