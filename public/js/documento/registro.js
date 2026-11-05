$(document).ready(function(){

    var carpeta = $("#carpeta").val();
    $(".registrocomprobante").on('click','.btn-guardar-xml', function(e) {

        event.preventDefault();
        var _token                  =   $('#token').val();
        var te                      =   $('#te').val();
        if(te =='0'){ alerterrorajax("Hay errores en la validacion del XML."); return false;}

        $.confirm({
            title: '¿Confirmar la validación?',
            content: 'Merge de Comprobante',
            buttons: {
                confirmar: function () {
                    //abrircargando();
                    $( "#formguardardatos" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la validación');
                }
            }
        });


    });

    $(".registrocomprobante").on('click','#cargardatosliq', function(e) {
        abrircargando();
    });




    $(".registrocomprobante").on('click','.buscardocumenoosiris', function() {

        var _token              = $('#token').val();

        var tipodoc_id          = $('#tipodoc_id').select2().val();
        var centro_id           = $('#centro_id').select2().val();
        var empresa_id          = $('#empresa_id').select2().val();
        var tiposervicio_id     = $('#tiposervicio_id').select2().val();
        var fecha_inicio        = $('#fecha_inicio').val();
        var fecha_fin           = $('#fecha_fin').val();

        if(tipodoc_id ==''){ alerterrorajax("Seleccione un tipo de documento"); return false;}
        if(centro_id ==''){ alerterrorajax("Seleccione un centro"); return false;}
        if(empresa_id ==''){ alerterrorajax("Seleccione una empresa"); return false;}
        if(tiposervicio_id ==''){ alerterrorajax("Seleccione un tipo de servicio"); return false;}
        if(fecha_inicio ==''){ alerterrorajax("Seleccione una fecha inicio"); return false;}
        if(fecha_fin ==''){ alerterrorajax("Seleccione una fecha fin"); return false;}

        abrircargando();
        $.ajax({
            
            type    :   "POST",
            url     :   carpeta+"/ajax-modal-lista-documento-osiris",
            data    :   {
                            _token          : _token,
                            tipodoc_id      : tipodoc_id,
                            centro_id       : centro_id,
                            empresa_id      : empresa_id,
                            tiposervicio_id : tiposervicio_id,
                            fecha_inicio    : fecha_inicio,
                            fecha_fin       : fecha_fin,
                        },
            success: function (data) {
                cerrarcargando();
                $('.modal-detalledocumento-container').html(data);
                $('#modal-detalledocumento').niftyModal();
            },
            error: function (data) {
                error500(data);
            }
        });

    });



    $(".registrocomprobante").on('click','.buscardocumentosmerge', function() {

        var _token              = $('#token').val();

        var fecha_inicio        = $('#fecha_inicio_m').val();
        var fecha_fin           = $('#fecha_fin_m').val();

        if(fecha_inicio ==''){ alerterrorajax("Seleccione una fecha inicio"); return false;}
        if(fecha_fin ==''){ alerterrorajax("Seleccione una fecha fin"); return false;}

        abrircargando();
        $.ajax({
            
            type    :   "POST",
            url     :   carpeta+"/ajax-modal-lista-documento-merge",
            data    :   {
                            _token          : _token,
                            fecha_inicio    : fecha_inicio,
                            fecha_fin       : fecha_fin,
                        },
            success: function (data) {
                cerrarcargando();
                $('.modal-detalledocumento-container').html(data);
                $('#modal-detalledocumento').niftyModal();
            },
            error: function (data) {
                error500(data);
            }
        });

    });



    $(".registrocomprobante").on('click','#agregardocumentosmerge', function() {

        event.preventDefault();
        debugger;
        var _token                  = $('#token').val();
        var array_detalle_merge    = $('#array_detalle_merge').val();
        var opcion_id               = $('#opcion').val();

        $('input[type=search]').val('').change();
        $("#despacholocen").DataTable().search("").draw();
        data_documento = datadocumentomerge();
        if(data_documento.length<=0){alerterrorajax('Seleccione por lo menos una fila'); return false;}
        $('#modal-detalledocumento').niftyModal('hide');

        $.ajax({

            type    :   "POST",
            url     :   carpeta+"/ajax-modal-agregar-documento-merge",
            data    :   {
                            _token                  : _token,
                            data_documento          : data_documento,
                            array_detalle_merge     : array_detalle_merge,
                            opcion_id               : opcion_id,
                        },    
            success: function (data) {
                cerrarcargando();
                $('.listajax_merge').html(data);
            },
            error: function (data) {
                error500(data);
            }
        });



    });



    $(".registrocomprobante").on('click','#agregardocumentos', function() {

        event.preventDefault();
        debugger;
        var _token                  = $('#token').val();
        var array_detalle_osiris    = $('#array_detalle_osiris').val();
        var opcion_id               = $('#opcion').val();

        $('input[type=search]').val('').change();
        $("#despacholocen").DataTable().search("").draw();
        data_documento = datadocumentoosiris();
        if(data_documento.length<=0){alerterrorajax('Seleccione por lo menos una fila'); return false;}
        $('#modal-detalledocumento').niftyModal('hide');

        $.ajax({

            type    :   "POST",
            url     :   carpeta+"/ajax-modal-agregar-documento-osiris",
            data    :   {
                            _token                  : _token,
                            data_documento          : data_documento,
                            array_detalle_osiris    : array_detalle_osiris,
                            opcion_id               : opcion_id,
                        },    
            success: function (data) {
                cerrarcargando();
                $('.listajax_osiris').html(data);
            },
            error: function (data) {
                error500(data);
            }
        });



    });


    function datadocumentoosiris(){
        var data = [];
        $(".lista_tabla_osiris tbody tr").each(function(){

            check                = $(this).find('.input_asignar_oc');
            documento_id         = $(this).attr('data_documento_id');

            if($(check).is(':checked')){
                data.push({
                    documento_id     : documento_id,
                });
            }        

        });
        return data;
    }



    function datadocumentomerge(){
        var data = [];
        $(".lista_tabla_merge tbody tr").each(function(){

            check                = $(this).find('.input_asignar_oc');
            documento_id         = $(this).attr('data_documento_id');

            if($(check).is(':checked')){
                data.push({
                    documento_id     : documento_id,
                });
            }        

        });
        return data;
    }



});




