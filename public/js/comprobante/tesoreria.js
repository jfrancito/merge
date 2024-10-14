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

    $(".areatesoreria").on('dblclick','.dobleclickpccontrato', function(e) {

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
        ajax_modal(data,"/ajax-modal-tesoreria-pago-contrato",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

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


    $(".areatesoreria").on('click','.asignarmasivo', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();


        var array_item              =   datamasivo();
        if(array_item.length<=0){alerterrorajax('No existe ningun registro'); return false;}
        datastring = JSON.stringify(array_item);

        data                        =   {
                                            _token                  : _token,
                                            datastring              : datastring,
                                            idopcion                : idopcion
                                        };

        ajax_modal(data,"/ajax-modal-tesoreria-pago-masivo",
                  "modal-detalle-requerimiento-masivo","modal-detalle-requerimiento-masivo-container");

    });


    function datamasivo(){
        var data = [];

        $(".listatabla tr").each(function(){

            check                       = $(this).find('input');
            data_requerimiento_id       = $(this).attr('data_requerimiento_id');

            data_orden_compra           = $(this).attr('data_orden_compra');
            data_proveedor              = $(this).attr('data_proveedor');
            data_serie                  = $(this).attr('data_serie');            
            data_numero                 = $(this).attr('data_numero');
            data_total                  = $(this).attr('data_total');

            if($(check).is(':checked')){
                data.push({
                    id: data_requerimiento_id,
                    data_orden_compra: data_orden_compra,
                    data_proveedor: data_proveedor,
                    data_serie: data_serie,
                    data_numero: data_numero,
                    data_total: data_total,

                });



            } 

        });

        return data;
    }


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
