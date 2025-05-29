$(document).ready(function(){
    var carpeta = $("#carpeta").val();



    $(".agestioncomprobante").on('click','.verlote', function(e) {

        $('input[type=search]').val("").change();
        $("#nso").DataTable().search("").draw();
        var _token                  =   $('#token').val();
        var data_lote               =   $(this).attr('data_lote');
        quitarcheck(data_lote);
        agregarcheck(data_lote);
        $('#modal-detalle-requerimiento').niftyModal('hide');

        $('input[type=search]').val(data_lote).change();
        $("#nso").DataTable().search(data_lote).draw();

    });

    $(".agestioncomprobante").on('click','.eliminarlote', function(e) {

        var _token                  =   $('#token').val();
        var data_lote               =   $(this).attr('data_lote');

        $.confirm({
            title: '¿Confirma la Eliminacion?',
            content: 'Elimnar los Comprobantes',
            buttons: {
                confirmar: function () {
                    ajax_eliminar_lote_estiba(data_lote);
                    $('#modal-detalle-requerimiento').niftyModal('hide');
                },
                cancelar: function () {
                    $.alert('Se cancelo Eliminacion');
                    window.location.reload();
                }
            }
        });

    });


    $(".agestioncomprobante").on('click','.lotescomision', function(e) {


        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        var operacion_sel           =   'COMISION';



        data                        =   {
                                            _token                  : _token,
                                            idopcion                : idopcion,
                                            operacion_sel           : operacion_sel,
                                        };

        ajax_modal(data,"/ajax-modal-detalle-lotes-comision",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });

    $(".agestioncomprobante").on('click','.migrarcomisionadmin', function() {
        event.preventDefault();
        $('input[type=search]').val('').change();
        $("#nso").DataTable().search("").draw();

        validar =dataenviarvalidar();
        if(validar.length>0){alerterrorajax(validar); return false;}

        data = dataenviar();
        if(data.length<=0){alerterrorajax('Seleccione por lo menos una fila'); return false;}
        var datastring = JSON.stringify(data);

        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();
        $('#jsondocumenos').val(datastring);
        $('#formre').submit();

    });




    $(".agestioncomprobante").on('click','.detalleestibs', function() {
        event.preventDefault();
        $('input[type=search]').val('').change();
        $("#nso").DataTable().search("").draw();
        data = dataenviar();
        if(data.length<=0){alerterrorajax('Seleccione por lo menos una fila'); return false;}
        var datastring = JSON.stringify(data);

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        data                        =   {
                                            _token                  : _token,
                                            idopcion                : idopcion,
                                            datastring                : datastring,
                                        };
        ajax_modal(data,"/ajax-modal-detalle-comision",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");
    });

    function ajax_eliminar_lote_estiba(lote){

        var _token      = $('#token').val();
        data            =   {
                                _token                  : _token,
                                lote                    : lote
                            };
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+'/ajax-eliminar-lote-comision',
            data    :   data,
            success: function (data) {
                cerrarcargando();
                $('.buscardocumentoadmin').trigger('click');
                alertajax("Eliminacion asignado exitosa");
                //$(".listajax").html(data);

            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });
    }



    $(".agestioncomprobante").on('click','.buscardocumentoadmin', function() {

        event.preventDefault();
        var banco_id                =   $('#banco_id').val();
        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();
        var fecha_inicio            =   $('#fecha_inicio').val();
        var fecha_fin               =   $('#fecha_fin').val();


        if(banco_id ==''){ alerterrorajax("Seleccione una banco."); return false;}
        if(fecha_inicio ==''){ alerterrorajax("Seleccione una fecha inicio."); return false;}
        if(fecha_fin ==''){ alerterrorajax("Seleccione una fecha fin."); return false;}


        data            =   {
                                _token                  : _token,
                                banco_id                : banco_id,
                                idopcion                : idopcion,
                                fecha_inicio            : fecha_inicio,
                                fecha_fin               : fecha_fin

                            };
        ajax_normal(data,"/ajax-buscar-documento-comision-admin");

    });


    $(".agestioncomprobante").on('change','.input_asignar', function() {
        suma_totales_cantidad();
    });

    function agregarcheck(lote){
        var data = [];
        $(".listatabla tr").each(function(){
            nombre          = $(this).find('.input_asignar').attr('id');
            if(nombre != 'todo_asignar'){
                check                       = $(this).find('.input_asignar');
                data_requerimiento_id       = $(this).attr('data_requerimiento_id');
                data_lote                   = $(this).attr('data_lote');
                if(data_lote == lote){
                    check.prop('checked', !check.prop('checked'));
                }
            }
        });
        return data;
    }

   function quitarcheck(lote){
        var data = [];
        $(".listatabla tr").each(function(){
            nombre          = $(this).find('.input_asignar').attr('id');
            if(nombre != 'todo_asignar'){
                check   = $(this).find('.input_asignar');
                check.prop('checked', false);
            }
        });
        return data;
    }


    function dataenviarvalidar(){
        var mensaje = '';
        $(".listatabla tr").each(function(){
            nombre          = $(this).find('.input_asignar').attr('id');
            if(nombre != 'todo_asignar'){
                
                check                       = $(this).find('.input_asignar');
                data_requerimiento_id       = $(this).attr('data_requerimiento_id');
                atender                     = parseFloat($(this).find('.importecomision').val());
                total                       = parseFloat($(this).attr('data_total'));
                total_atendido              = parseFloat($(this).attr('data_total_atendido'));
                if($(check).is(':checked')){
                    if(atender > (total-total_atendido)){
                        mensaje = 'Documento ' +data_requerimiento_id + ' supera lo que puede atender';
                    }
                }

            }
        });
        return mensaje;
    }


    function dataenviar(){
        var data = [];
        $(".listatabla tr").each(function(){
            nombre          = $(this).find('.input_asignar').attr('id');
            if(nombre != 'todo_asignar'){
                
                check                       = $(this).find('.input_asignar');
                data_requerimiento_id       = $(this).attr('data_requerimiento_id');
                atender                     = parseFloat($(this).find('.importecomision').val());
                if($(check).is(':checked')){
                    data.push({
                        data_requerimiento_id  : data_requerimiento_id,
                        atender                : atender,
                    });
                }

            }
        });
        return data;
    }

    function suma_totales_cantidad(){

        var data_total = 0;
        var can_total = 0;
        $(".listatabla tr").each(function(){
            nombre          = $(this).find('.input_asignar').attr('id');
            if(nombre != 'todo_asignar'){
                check                       = $(this).find('.input_asignar');
                total                       = parseFloat($(this).attr('data_total'));
                total_atendido              = parseFloat($(this).attr('data_total_atendido'));
                atender                     = parseFloat($(this).find('.importecomision').val());

                if($(check).is(':checked')){
                    data_total = data_total+atender;
                    can_total = can_total+1;
                }

            }
        });
        let numeroFormateado = data_total.toLocaleString('es-PE', {
            minimumFractionDigits: 2, // Cantidad mínima de decimales
            maximumFractionDigits: 4  // Cantidad máxima de decimales
        });

        $('.totalseleccion').html(numeroFormateado);
        $('.cantidaseleccion').html(can_total);
    }


});




