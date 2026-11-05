$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    $('.extornarapagocontrato').on('click', function(event){

        debugger;
        event.preventDefault();
        var href = $(this).attr('href');

        $.confirm({
            title: '¿Confirma el Extorno?',
            content: 'Extorno de pago del Comprobante',
            buttons: {
                confirmar: function () {
                    window.location.href = href;
                },
                cancelar: function () {
                    $.alert('Se cancelo el extorno');
                }
            }
        });

    });


    $(".areatesoreria").on('click','.elimnaritem', function() {
        event.preventDefault();
        var data_tipoarchivo        =   $(this).attr('data_tipoarchivo');
        var data_nombrearchivo      =   $(this).attr('data_nombrearchivo');
        var data_linea              =   $(this).attr('data_linea');
        var data_iddocumento        =   $(this).attr('data_iddocumento');
        var _token                  =   $('#token').val();
        debugger;

        data                        =   {
                                            _token                  : _token,
                                            data_tipoarchivo        : data_tipoarchivo,
                                            data_nombrearchivo      : data_nombrearchivo,
                                            data_linea              : data_linea,
                                            data_iddocumento        : data_iddocumento,
                                        };

        $.confirm({
            title: '¿Confirma la Eliminacion?',
            content: 'Eliminar item del pago de Comprobante',
            buttons: {
                confirmar: function () {
                    ajax_normal_modal(data,"/ajax-eliminar-archivo-item-pp");
                },
                cancelar: function () {
                    $.alert('Se cancelo Eliminacion');
                }
            }
        });

    });



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

    $('.extornarapago').on('click', function(event){

        debugger;
        event.preventDefault();
        var href = $(this).attr('href');

        $.confirm({
            title: '¿Confirma el Extorno?',
            content: 'Extorno de pago del Comprobante',
            buttons: {
                confirmar: function () {
                    window.location.href = href;
                },
                cancelar: function () {
                    $.alert('Se cancelo el extorno');
                }
            }
        });

    });



    $(".areatesoreria").on('click','.buscardocumento', function() {

        event.preventDefault();

        var operacion_id            =   $('#operacion_id').val();
        var estadopago_id           =   $('#estadopago_id').val();
        var proveedor_id            =   $('#proveedor_id').val();

        var fecha_inicio            =   $('#fecha_inicio').val();
        var fecha_fin               =   $('#fecha_fin').val();

        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        data            =   {
                                _token                  : _token,
                                operacion_id            : operacion_id,
                                estadopago_id           : estadopago_id,
                                proveedor_id            : proveedor_id,
                                fecha_inicio            : fecha_inicio,
                                fecha_fin               : fecha_fin,

                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-gestion-tesoreria");

    });

    $(".areatesoreria").on('click','.buscardocumentopagado', function() {

        event.preventDefault();

        var operacion_id            =   $('#operacion_id').val();
        var fecha_inicio            =   $('#fecha_inicio').val();
        var fecha_fin               =   $('#fecha_fin').val();

        var proveedor_id            =   $('#proveedor_id').val();
        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        data            =   {
                                _token                  : _token,
                                operacion_id            : operacion_id,
                                fecha_inicio            : fecha_inicio,
                                fecha_fin               : fecha_fin,
                                proveedor_id            : proveedor_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-gestion-tesoreria-pagado");

    });


    $(".areatesoreria").on('dblclick','.dobleclickpcestiba', function(e) {

        var _token                  =   $('#token').val();
        var data_requerimiento_id   =   $(this).attr('data_requerimiento_id');
        var data_linea              =   $(this).attr('data_linea');
        var operacion_id            =   $('#operacion_id').val();

        var idopcion                =   $('#idopcion').val();

        data                        =   {
                                            _token                  : _token,
                                            data_requerimiento_id   : data_requerimiento_id,
                                            data_linea              : data_linea,
                                            idopcion                : idopcion,
                                            operacion_id            : operacion_id,
                                        };
        ajax_modal(data,"/ajax-modal-tesoreria-pago-estiba",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

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

    $(".areatesoreria").on('dblclick','.dobleclickpcpagado', function(e) {

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
        ajax_modal(data,"/ajax-modal-tesoreria-pago-pagado",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });

    $(".areatesoreria").on('dblclick','.dobleclickpcpagadocontrato', function(e) {

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
        ajax_modal(data,"/ajax-modal-tesoreria-pago-pagado-contrato",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });

    $(".areatesoreria").on('dblclick','.dobleclickpcpagadocomision', function(e) {

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
        ajax_modal(data,"/ajax-modal-tesoreria-pago-pagado-comision",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });






    $(".areatesoreria").on('click','.asignarmasivo', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        var operacion_id            =   $('#operacion_id').val();

        var array_item              =   datamasivo();
        if(array_item.length<=0){alerterrorajax('No existe ningun registro'); return false;}
        datastring = JSON.stringify(array_item);

        data                        =   {
                                            _token                  : _token,
                                            datastring              : datastring,
                                            operacion_id            : operacion_id,
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
