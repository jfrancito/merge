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
    $(".areaadministracion").on('dblclick','.btn_detalle_deuda', function(e) {

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
    

    $(".areaadministracion").on('click','.buscardocumento', function() {

        event.preventDefault();

        var operacion_id            =   $('#operacion_id').val();
        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        data            =   {
                                _token                  : _token,
                                operacion_id            : operacion_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-gestion-administracion");

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
