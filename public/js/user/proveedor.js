$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    $(".proveedor").on('click','.editar_datos_proveedor', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        data                        =   {
                                            _token                  : _token
                                        };

        ajax_modal(data,"/ajax-modal-configuracion-datos-proveedor-detalle",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });


    $(".proveedor").on('click','.editar_datos_contacto', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        data                        =   {
                                            _token                  : _token
                                        };

        ajax_modal(data,"/ajax-modal-configuracion-datos-contacto-detalle",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });


    $(".proveedor").on('click','.agregar_cuenta_bancaria', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        data                        =   {
                                            _token                  : _token
                                        };

        ajax_modal(data,"/ajax-modal-configuracion-cuenta-bancaria",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });


    $(".proveedor").on('click','.btn-guardar-configuracion-cb', function() {

        var banco_id                            =   $('#banco_id').val();
        var tipocuenta_id                       =   $('#tipocuenta_id').val();
        var moneda_id                           =   $('#moneda_id').val();
        var numerocuenta                        =   $('#numerocuenta').val();
        var numerocuentacci                     =   $('#numerocuentacci').val();

        //validacioones
        if(banco_id ==''){ alerterrorajax("Seleccione una banco."); return false;}
        if(tipocuenta_id ==''){ alerterrorajax("Seleccione una tipo de cuenta."); return false;}
        if(moneda_id ==''){ alerterrorajax("Seleccione una moneda."); return false;}
        if(numerocuenta ==''){ alerterrorajax("Ingrese un numero de cuenta."); return false;}
        if(numerocuentacci ==''){ alerterrorajax("Ingrese un numero de cuenta CCI."); return false;}
        return true;

    });


    $(".proveedor").on('click','.btn-eliminar-cb', function() {

        var data_COD_EMPR_TITULAR              =   $(this).attr('data_COD_EMPR_TITULAR');
        var data_COD_EMPR_BANCO                =   $(this).attr('data_COD_EMPR_BANCO');
        var data_COD_CATEGORIA_MONEDA          =   $(this).attr('data_COD_CATEGORIA_MONEDA');
        var data_TXT_TIPO_REFERENCIA           =   $(this).attr('data_TXT_TIPO_REFERENCIA');
        var data_TXT_NRO_CUENTA_BANCARIA       =   $(this).attr('data_TXT_NRO_CUENTA_BANCARIA');
        var _token                  =   $('#token').val();
        data                        =   {
                                            _token                          : _token,
                                            data_COD_EMPR_TITULAR           : data_COD_EMPR_TITULAR,
                                            data_COD_EMPR_BANCO             : data_COD_EMPR_BANCO,
                                            data_COD_CATEGORIA_MONEDA       : data_COD_CATEGORIA_MONEDA,
                                            data_TXT_TIPO_REFERENCIA        : data_TXT_TIPO_REFERENCIA,
                                            data_TXT_NRO_CUENTA_BANCARIA    : data_TXT_NRO_CUENTA_BANCARIA,
                                        };
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+'/ajax-eliminar-cb',
            data    :   data,
            success: function (data) {
                cerrarcargando();
                alertajax("Registro Exitoso");
                location.reload();
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });
        return true;

    });




    




});
