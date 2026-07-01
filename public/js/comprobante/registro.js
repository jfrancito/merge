function toggleContent() {
  var longText = document.getElementById('longText');
  var button = document.getElementById('toggleButton');
  if (longText.classList.contains('collapsed')) {
    longText.classList.remove('collapsed');
    button.innerHTML = "- Ver Menos";
  } else {
    longText.classList.add('collapsed');
    button.innerHTML = "+ Ver Más";
  }
}




$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    $(".registrocomprobante").on('click','.ver_cuenta_bancaria', function() {

        var _token                  =   $('#token').val();
        var prefijo_id              =   $('#prefijo_id').val();
        var orden_id                =   $('#orden_id').val();
        var idopcion                =   $('#idopcion').val();
        data                        =   {
                                            _token                  : _token,
                                            prefijo_id              : prefijo_id,
                                            orden_id                : orden_id,
                                        };

        ajax_modal(data,"/ajax-modal-ver-cuenta-bancaria-contrato",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });


    $(".registrocomprobante").on('click','.ver_cuenta_bancaria_pg', function() {

        var _token                  =   $('#token').val();
        var prefijo_id              =   $('#prefijo_id').val();
        var orden_id                =   $('#orden_id').val();
        var idopcion                =   $('#idopcion').val();
        data                        =   {
                                            _token                  : _token,
                                            prefijo_id              : prefijo_id,
                                            orden_id                : orden_id,
                                        };

        ajax_modal(data,"/ajax-modal-ver-cuenta-bancaria-pg",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });


    $(".registrocomprobante").on('click','.ver_cuenta_bancaria_estiba', function() {

        var _token                  =   $('#token').val();
        var prefijo_id              =   $('#prefijo_id').val();
        var orden_id                =   $('#orden_id').val();
        var empresa_id              =   $('#empresa_id').val();
        var idopcion                =   $('#idopcion').val();

        data                        =   {
                                            _token                  : _token,
                                            prefijo_id              : prefijo_id,
                                            orden_id                : orden_id,
                                            empresa_id              : empresa_id,
                                        };

        ajax_modal(data,"/ajax-modal-ver-cuenta-bancaria-estiba",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });


    $(".registrocomprobante").on('click','.ver_cuenta_bancaria_oc', function() {

        var _token                  =   $('#token').val();
        var prefijo_id              =   $('#prefijo_id').val();
        var orden_id                =   $('#orden_id').val();
        var idopcion                =   $('#idopcion').val();
        data                        =   {
                                            _token                  : _token,
                                            prefijo_id              : prefijo_id,
                                            orden_id                : orden_id,
                                        };

        ajax_modal(data,"/ajax-modal-ver-cuenta-bancaria-oc",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });

    $(".registrocomprobante").on('click','.ver_cuenta_bancaria_liq_com_an', function() {

        var _token                  =   $('#token').val();
        var prefijo_id              =   $('#prefijo_id').val();
        var orden_id                =   $('#orden_id').val();
        var idopcion                =   $('#idopcion').val();
        data                        =   {
                                            _token                  : _token,
                                            prefijo_id              : prefijo_id,
                                            orden_id                : orden_id,
                                        };

        ajax_modal(data,"/ajax-modal-ver-cuenta-bancaria-liq-com-an",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });

    $(".registrocomprobante").on('click','.agregar_cuenta_bancaria_oc', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        var prefijo_id              =   $('#prefijo_id').val();
        var orden_id                =   $('#orden_id').val();

        debugger;


        data                        =   {
                                            _token                  : _token,
                                            prefijo_id              : prefijo_id,
                                            orden_id                : orden_id,
                                            idopcion                : idopcion,

                                        };

        ajax_modal(data,"/ajax-modal-configuracion-cuenta-bancaria-oc",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });

    $(".registrocomprobante").on('click','.agregar_grupo_marketing_oc', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        var prefijo_id              =   $('#prefijo_id').val();
        var orden_id                =   $('#orden_id').val();

        data                        =   {
                                            _token                  : _token,
                                            prefijo_id              : prefijo_id,
                                            orden_id                : orden_id,
                                            idopcion                : idopcion,

                                        };

        ajax_modal(data,"/ajax-modal-configuracion-grupo-oc",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });


    $(".registrocomprobante").on('click','.agregar_cuenta_bancaria', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        var prefijo_id              =   $('#prefijo_id').val();
        var orden_id                =   $('#orden_id').val();
        debugger;
        data                        =   {
                                            _token                  : _token,
                                            prefijo_id              : prefijo_id,
                                            orden_id                : orden_id,
                                            idopcion                : idopcion,

                                        };

        ajax_modal(data,"/ajax-modal-configuracion-cuenta-bancaria-contrato",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });

    $(".registrocomprobante").on('click','.agregar_cuenta_bancaria_pg', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        var prefijo_id              =   $('#prefijo_id').val();
        var orden_id                =   $('#orden_id').val();
        data                        =   {
                                            _token                  : _token,
                                            prefijo_id              : prefijo_id,
                                            orden_id                : orden_id,
                                            idopcion                : idopcion,

                                        };

        ajax_modal(data,"/ajax-modal-configuracion-cuenta-bancaria-pg",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });


    $(".registrocomprobante").on('click','.agregar_cuenta_bancaria_liq_com_an', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        var prefijo_id              =   $('#prefijo_id').val();
        var orden_id                =   $('#orden_id').val();
        data                        =   {
                                            _token                  : _token,
                                            prefijo_id              : prefijo_id,
                                            orden_id                : orden_id,
                                            idopcion                : idopcion,

                                        };

        ajax_modal(data,"/ajax-modal-configuracion-cuenta-bancaria-liq-com-an",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });

    $(".registrocomprobante").on('click','.agregar_cuenta_bancaria_estiba', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        var prefijo_id              =   $('#prefijo_id').val();
        var orden_id                =   $('#orden_id').val();
        var empresa_id              =   $('#empresa_id').val();


        data                        =   {
                                            _token                  : _token,
                                            prefijo_id              : prefijo_id,
                                            orden_id                : orden_id,
                                            empresa_id              : empresa_id,
                                            idopcion                : idopcion,

                                        };

        ajax_modal(data,"/ajax-modal-configuracion-cuenta-bancaria-estiba",
                  "modal-configuracion-usuario-detalle","modal-configuracion-usuario-detalle-container");

    });





    function setSelect2Readonly(selector, readonly) {
        if (readonly) {
            $(selector).attr('readonly', true);
            $(selector).on('select4:opening select4:closing', function(e) {
                e.preventDefault();
            });
        } else {
            $(selector).removeAttr('readonly');
            $(selector).off('select4:opening select4:closing');
        }
    }

    $(".registrocomprobante").on('change','.entidadbancooc', function() {


        var _token              =   $('#token').val();
        var entidadbanco_id     =   $(this).val();
        var prefijo_id          =   $('#prefijo_id').val();
        var orden_id            =   $('#orden_id').val();

        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009', 'BAM0000000000011', 'BAM0000000000013', 'BAM0000000000014', 'BAM0000000000015'];

        if(valores.includes(entidadbanco_id)){
            $('.ajax_cb').addClass('ocultar');
        }else{
            $('.ajax_cb').removeClass('ocultar');
        }

        debugger;

        $.ajax({
              type    :     "POST",
              url     :     carpeta+"/ajax-cuenta-bancaria-proveedor-oc",
              data    :     {
                                _token              : _token,
                                entidadbanco_id     : entidadbanco_id,
                                prefijo_id          : prefijo_id,
                                orden_id            : orden_id
                            },
                success: function (data) {
                    $('.ajax_cb').html(data);
                },
                error: function (data) {
                    error500(data);
                }
        });
    });

    $(".registrocomprobante").on('change','.entidadbancoliquidacioncompraanticipo', function() {


        var _token              =   $('#token').val();
        var entidadbanco_id     =   $(this).val();
        var prefijo_id          =   $('#prefijo_id').val();
        var orden_id            =   $('#orden_id').val();

        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009', 'BAM0000000000011', 'BAM0000000000013', 'BAM0000000000014', 'BAM0000000000015'];

        if(valores.includes(entidadbanco_id)){
            $('.ajax_cb').addClass('ocultar');
        }else{
            $('.ajax_cb').removeClass('ocultar');
        }

        debugger;

        $.ajax({
              type    :     "POST",
              url     :     carpeta+"/ajax-cuenta-bancaria-proveedor-liquidacioncompraanticipo",
              data    :     {
                                _token              : _token,
                                entidadbanco_id     : entidadbanco_id,
                                prefijo_id          : prefijo_id,
                                orden_id            : orden_id
                            },
                success: function (data) {
                    $('.ajax_cb').html(data);
                },
                error: function (data) {
                    error500(data);
                }
        });
    });


    $(".registrocomprobante").on('change','#pago_detraccion', function() {

        debugger;

        var _token              =   $('#token').val();
        var pago_detraccion     =   $(this).val();
        var empresa_id          =   $('#empresa_id').val();

        if(empresa_id == pago_detraccion){
            $('#file-DCC0000000000009').removeAttr('required');
            $('.autodetraccion').addClass('ocultar');
        }else{
            $('#file-DCC0000000000009').prop('required', true);
            $('.autodetraccion').removeClass('ocultar');
        }

    });

    $(".registrocomprobante").on('change','#cb_id', function() {


        var _token                          =   $('#token').val();

        var data_entidadbanco_id            =   $(this).attr('data_entidadbanco_id');
        var data_empresa_cliente_id         =   $(this).attr('data_empresa_cliente_id');
        var cb_id                           =   $('#cb_id').val();


        $.ajax({
              type    :     "POST",
              url     :     carpeta+"/ajax-moneda-ajax-cuenta",
              data    :     {
                                _token                      : _token,
                                data_entidadbanco_id        : data_entidadbanco_id,
                                data_empresa_cliente_id     : data_empresa_cliente_id,
                                cb_id                       : cb_id
                            },
                success: function (data) {
                    $('.moneda_ajax').html(data);
                },
                error: function (data) {
                    error500(data);
                }
        });
    });





    $(".registrocomprobante").on('change','.entidadbancopg', function() {

        debugger;

        var _token              =   $('#token').val();
        var entidadbanco_id     =   $(this).val();
        var prefijo_id          =   $('#prefijo_id').val();
        var orden_id            =   $('#orden_id').val();


        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009', 'BAM0000000000011', 'BAM0000000000013', 'BAM0000000000014', 'BAM0000000000015'];

        if(valores.includes(entidadbanco_id)){
            $('.ajax_cb').addClass('ocultar');
        }else{
            $('.ajax_cb').removeClass('ocultar');
        }


        $.ajax({
              type    :     "POST",
              url     :     carpeta+"/ajax-cuenta-bancaria-proveedor-pg",
              data    :     {
                                _token              : _token,
                                entidadbanco_id     : entidadbanco_id,
                                prefijo_id          : prefijo_id,
                                orden_id            : orden_id
                            },
                success: function (data) {
                    $('.ajax_cb').html(data);
                },
                error: function (data) {
                    error500(data);
                }
        });
    });


    $(".registrocomprobante").on('change','.entidadbanco', function() {

        debugger;

        var _token              =   $('#token').val();
        var entidadbanco_id     =   $(this).val();
        var prefijo_id          =   $('#prefijo_id').val();
        var orden_id            =   $('#orden_id').val();


        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009', 'BAM0000000000011', 'BAM0000000000013', 'BAM0000000000014', 'BAM0000000000015'];

        if(valores.includes(entidadbanco_id)){
            $('.ajax_cb').addClass('ocultar');
        }else{
            $('.ajax_cb').removeClass('ocultar');
        }


        debugger;

        $.ajax({
              type    :     "POST",
              url     :     carpeta+"/ajax-cuenta-bancaria-proveedor-contrato",
              data    :     {
                                _token              : _token,
                                entidadbanco_id     : entidadbanco_id,
                                prefijo_id          : prefijo_id,
                                orden_id            : orden_id
                            },
                success: function (data) {
                    $('.ajax_cb').html(data);
                },
                error: function (data) {
                    error500(data);
                }
        });
    });

    $(".registrocomprobante").on('change','.entidadbancoestiba', function() {

        debugger;

        var _token              =   $('#token').val();
        var entidadbanco_id     =   $(this).val();
        var prefijo_id          =   $('#prefijo_id').val();
        var orden_id            =   $('#orden_id').val();
        var empresa_id          =   $('#empresa_id').val();
        debugger;

        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009', 'BAM0000000000011', 'BAM0000000000013', 'BAM0000000000014', 'BAM0000000000015'];

        if(valores.includes(entidadbanco_id)){
            $('.ajax_cb').addClass('ocultar');
        }else{
            $('.ajax_cb').removeClass('ocultar');
        }

        $.ajax({
              type    :     "POST",
              url     :     carpeta+"/ajax-cuenta-bancaria-proveedor-estiba",
              data    :     {
                                _token              : _token,
                                entidadbanco_id     : entidadbanco_id,
                                prefijo_id          : prefijo_id,
                                empresa_id          : empresa_id,
                                orden_id            : orden_id
                            },
                success: function (data) {
                    $('.ajax_cb').html(data);
                },
                error: function (data) {
                    error500(data);
                }
        });
    });


    $(".registrocomprobante").on('click','.btn-guardar-xml-comision', function(e) {

        event.preventDefault();
        var _token                  =   $('#token').val();
        var te                      =   $('#te').val();
        if(te =='0'){ alerterrorajax("Hay errores en la validacion del XML."); return false;}
        $.confirm({
            title: '¿Confirmar la validación?',
            content: 'Merge de Comprobante',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    $( "#formguardardatos" ).submit();

                    setTimeout(function() {
                       cerrarcargando();
                    }, 8000);
 
                },
                cancelar: function () {
                    $.alert('Se cancelo la validación');
                }
            }
        });


    });

    $(".registrocomprobante").on('click','.btn-guardar-xml-estiba', function(e) {

        event.preventDefault();
        var _token                  =   $('#token').val();
        var te                      =   $('#te').val();
        var entidadbanco_id         =   $('#entidadbanco_id').val();
        var monto_total             =   parseFloat($('#monto_total').val());
        var ctadetraccion           =   $('#ctadetraccion').val();
        var tipo_detraccion_id      =   $('#tipo_detraccion_id').val();
        var monto_detraccion        =   $('#monto_detraccion').val();
        var pago_detraccion         =   $('#pago_detraccion').val();
        var valor_igv               =   $('#valor_igv').val();
        var tipo_documento_id       =   $('#tipo_documento_id').val();
        if(tipo_documento_id == '01'){
            if(valor_igv>0){
                if(monto_total > 401){ 
                    if(ctadetraccion.trim() ==''){ alerterrorajax("Ingrese una Cuenta de Detraccion."); return false;}
                    if(tipo_detraccion_id ==''){ alerterrorajax("Seleeccione un valor de detraccion"); return false;}
                    if(monto_detraccion =='0'){ alerterrorajax("Ingrese Monto de Detraccion."); return false;}
                    if(pago_detraccion ==''){ alerterrorajax("Seleeccione un pago de detraccion"); return false;}
                }
            }
        }
        var cb_id                   =   $('#cb_id').val();
        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009','BAM0000000000011', 'BAM0000000000013', 'BAM0000000000014', 'BAM0000000000015'];
        if(!valores.includes(entidadbanco_id)){
            if(cb_id==''){
                alerterrorajax("Seleccione una Cuenta Bancaria."); return false;
            }
        }
        if(te =='0'){ alerterrorajax("Hay errores en la validacion del XML."); return false;}
        //informacion de maquina
        captureDeviceInfo().then(info => {
            // Convertimos el objeto a texto JSON para que viaje en el input
            $('#device_info').val(JSON.stringify(info));
            
            console.log("Datos capturados listos para enviar");
        });
        
        $.confirm({
            title: '¿Confirmar la validación?',
            content: 'Merge de Comprobante',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    $( "#formguardardatos" ).submit();

                    setTimeout(function() {
                       cerrarcargando();
                    }, 8000);
 
                },
                cancelar: function () {
                    $.alert('Se cancelo la validación');
                }
            }
        });


    });

    $(".registrocomprobante").on('click','.btn-guardar-xml-contrato', function(e) {

        event.preventDefault();
        var _token                  =   $('#token').val();
        var te                      =   $('#te').val();
        var entidadbanco_id         =   $('#entidadbanco_id').val();
        var monto_total             =   parseFloat($('#monto_total').val());
        var ctadetraccion           =   $('#ctadetraccion').val();
        var tipo_detraccion_id      =   $('#tipo_detraccion_id').val();
        var monto_detraccion        =   $('#monto_detraccion').val();
        var pago_detraccion         =   $('#pago_detraccion').val();
        var valor_igv               =   $('#valor_igv').val();

        if(valor_igv>0){
            if(monto_total > 401){ 
                if(ctadetraccion.trim() ==''){ alerterrorajax("Ingrese una Cuenta de Detraccion."); return false;}
                if(tipo_detraccion_id ==''){ alerterrorajax("Seleeccione un valor de detraccion"); return false;}
                if(monto_detraccion =='0'){ alerterrorajax("Ingrese Monto de Detraccion."); return false;}
                if(pago_detraccion ==''){ alerterrorajax("Seleeccione un pago de detraccion"); return false;}
            }
        }

        var cb_id                   =   $('#cb_id').val();
        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009','BAM0000000000011', 'BAM0000000000013', 'BAM0000000000014', 'BAM0000000000015'];
        if(!valores.includes(entidadbanco_id)){
            if(cb_id==''){
                alerterrorajax("Seleccione una Cuenta Bancaria."); return false;
            }
        }
        if(te =='0'){ alerterrorajax("Hay errores en la validacion del XML."); return false;}

        //informacion de maquina
        captureDeviceInfo().then(info => {
            // Convertimos el objeto a texto JSON para que viaje en el input
            $('#device_info').val(JSON.stringify(info));
            
            console.log("Datos capturados listos para enviar");
        });


        $.confirm({
            title: '¿Confirmar la validación?',
            content: 'Merge de Comprobante',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    $( "#formguardardatos" ).submit();

                    setTimeout(function() {
                       cerrarcargando();
                    }, 8000);
 
                },
                cancelar: function () {
                    $.alert('Se cancelo la validación');
                }
            }
        });


    });

    $(".registrocomprobante").on('click','.btn-guardar-xml-liquidacion-compra-anticipo', function(e) {

        event.preventDefault();
        var _token                  =   $('#token').val();
        var te                      =   $('#te').val();
        var entidadbanco_id         =   $('#entidadbanco_id').val();
        var monto_total             =   parseFloat($('#monto_total').val());
        var ctadetraccion           =   $('#ctadetraccion').val();
        var tipo_detraccion_id      =   $('#tipo_detraccion_id').val();
        var monto_detraccion        =   $('#monto_detraccion').val();
        var pago_detraccion         =   $('#pago_detraccion').val();
        var valor_igv               =   $('#valor_igv').val();

        if(valor_igv>0){
            if(monto_total > 401){ 
                if(ctadetraccion.trim() ==''){ alerterrorajax("Ingrese una Cuenta de Detraccion."); return false;}
                if(tipo_detraccion_id ==''){ alerterrorajax("Seleeccione un valor de detraccion"); return false;}
                if(monto_detraccion =='0'){ alerterrorajax("Ingrese Monto de Detraccion."); return false;}
                if(pago_detraccion ==''){ alerterrorajax("Seleeccione un pago de detraccion"); return false;}
            }
        }

        var cb_id                   =   $('#cb_id').val();
        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009','BAM0000000000011','BAM0000000000013', 'BAM0000000000014', 'BAM0000000000015'];
        if(!valores.includes(entidadbanco_id)){
            if(cb_id==''){
                alerterrorajax("Seleccione una Cuenta Bancaria."); return false;
            }
        }
        if(te =='0'){ alerterrorajax("Hay errores en la validacion del XML."); return false;}

        //informacion de maquina
        captureDeviceInfo().then(info => {
            // Convertimos el objeto a texto JSON para que viaje en el input
            $('#device_info').val(JSON.stringify(info));
            
            console.log("Datos capturados listos para enviar");
        });

        $.confirm({
            title: '¿Confirmar la validación?',
            content: 'Merge de Comprobante',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    $( "#formguardardatos" ).submit();

                    setTimeout(function() {
                       cerrarcargando();
                    }, 8000);
 
                },
                cancelar: function () {
                    $.alert('Se cancelo la validación');
                }
            }
        });


    });

    $(".registrocomprobante").on('click','.btn-guardar-xml-nota-credito', function(e) {

        event.preventDefault();
        var _token                  =   $('#token').val();
        var te                      =   $('#te').val();
        
        var monto_total             =   parseFloat($('#monto_total').val());        
        var valor_igv               =   $('#valor_igv').val();        
        
        if(te =='0'){ alerterrorajax("Hay errores en la validacion del XML."); return false;}
        $.confirm({
            title: '¿Confirmar la validación?',
            content: 'Merge de Comprobante',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    $( "#formguardardatos" ).submit();

                    setTimeout(function() {
                       cerrarcargando();
                    }, 8000);
 
                },
                cancelar: function () {
                    $.alert('Se cancelo la validación');
                }
            }
        });


    });

    $(".registrocomprobante").on('click','.btn-guardar-xml-nota-debito', function(e) {

        event.preventDefault();
        var _token                  =   $('#token').val();
        var te                      =   $('#te').val();
        
        var monto_total             =   parseFloat($('#monto_total').val());        
        var valor_igv               =   $('#valor_igv').val();        
        
        if(te =='0'){ alerterrorajax("Hay errores en la validacion del XML."); return false;}
        $.confirm({
            title: '¿Confirmar la validación?',
            content: 'Merge de Comprobante',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    $( "#formguardardatos" ).submit();

                    setTimeout(function() {
                       cerrarcargando();
                    }, 8000);
 
                },
                cancelar: function () {
                    $.alert('Se cancelo la validación');
                }
            }
        });


    });


    $(".registrocomprobante").on('click','.btn-guardar-xml', function(e) {

        event.preventDefault();
        var _token                  =   $('#token').val();
        var te                      =   $('#te').val();
        var entidadbanco_id         =   $('#entidadbanco_id').val();
        var cb_id                   =   $('#cb_id').val();
        var detraccion              =   $('#detraccion').val();
        var grupo                   =   $('#grupo_data').val();


        var ctadetraccion           =   $('#ctadetraccion').val();
        var monto_detraccion        =   $('#monto_detraccion').val();
        var pago_detraccion         =   $('#pago_detraccion').val();

        //informacion de maquina
        captureDeviceInfo().then(info => {
            // Convertimos el objeto a texto JSON para que viaje en el input
            $('#device_info').val(JSON.stringify(info));
            
            console.log("Datos capturados listos para enviar");
        });

        if(detraccion>0){
            if(ctadetraccion.trim() ==''){ alerterrorajax("Ingrese una Cuenta de Detraccion."); return false;}
            if(monto_detraccion =='0'){ alerterrorajax("Ingrese Monto de Detraccion."); return false;}
            if(pago_detraccion ==''){ alerterrorajax("Seleeccione un pago de detraccion"); return false;}            
        }
        var grupo_id           =   $('#grupo_id').val();
        if(grupo>0){
            if(grupo_id ==''){ alerterrorajax("Seleeccione un grupo"); return false;}            
        }

        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009','BAM0000000000011', 'BAM0000000000013', 'BAM0000000000014', 'BAM0000000000015'];

        if(!valores.includes(entidadbanco_id)){
            if(cb_id==''){
                alerterrorajax("Seleccione una Cuenta Bancaria."); return false;
            }
        }

        if(te =='0'){ alerterrorajax("Hay errores en la validacion del XML."); return false;}

        //informacion de maquina
        captureDeviceInfo().then(info => {
            // Convertimos el objeto a texto JSON para que viaje en el input
            $('#device_info').val(JSON.stringify(info));
            
            console.log("Datos capturados listos para enviar");
        });

        $.confirm({
            title: '¿Confirmar la validación?',
            content: 'Merge de Comprobante',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    $( "#formguardardatos" ).submit();

                    setTimeout(function() {
                       cerrarcargando();
                    }, 8000);
 
                },
                cancelar: function () {
                    $.alert('Se cancelo la validación');
                }
            }
        });


    });

    $(".registrocomprobante").on('click','.btn-guardar-sin-xml', function(e) {

        event.preventDefault();
        var _token                  =   $('#token').val();
        var te                      =   $('#te').val();
        var entidadbanco_id         =   $('#entidadbanco_id').val();
        var cb_id                   =   $('#cb_id').val();
        var detraccion              =   $('#detraccion').val();

        var serie                   =   $('#serie').val();
        var numero                  =   $('#numero').val();
        var fechaventa              =   $('#fechaventa').val();
        var fechavencimiento        =   $('#fechavencimiento').val();

        if(serie ==''){ alerterrorajax("Ingrese Serie Factura"); return false;}
        if(numero ==''){ alerterrorajax("Ingrese Numero Factura"); return false;}
        if(fechaventa ==''){ alerterrorajax("Ingrese Fecha Venta Factura"); return false;}
        if(fechavencimiento ==''){ alerterrorajax("Ingrese Fecha Vencimiento Factura"); return false;}

        var ctadetraccion           =   $('#ctadetraccion').val();
        var monto_detraccion        =   $('#monto_detraccion').val();
        var pago_detraccion         =   $('#pago_detraccion').val();

        debugger;
        if(detraccion>0){
            if(ctadetraccion.trim() ==''){ alerterrorajax("Ingrese una Cuenta de Detraccion."); return false;}
            if(monto_detraccion =='0'){ alerterrorajax("Ingrese Monto de Detraccion."); return false;}
            if(pago_detraccion ==''){ alerterrorajax("Seleeccione un pago de detraccion"); return false;}            
        }

        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009','BAM0000000000011', 'BAM0000000000013', 'BAM0000000000014', 'BAM0000000000015'];

        if(!valores.includes(entidadbanco_id)){
            if(cb_id==''){
                alerterrorajax("Seleccione una Cuenta Bancaria."); return false;
            }
        }

        if(te =='0'){ alerterrorajax("Hay errores en la validacion del XML."); return false;}

        //informacion de maquina
        captureDeviceInfo().then(info => {
            // Convertimos el objeto a texto JSON para que viaje en el input
            $('#device_info').val(JSON.stringify(info));
            
            console.log("Datos capturados listos para enviar");
        });

        $.confirm({
            title: '¿Confirmar la validación?',
            content: 'Merge de Comprobante',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    $( "#formguardardatos" ).submit();

                    setTimeout(function() {
                       cerrarcargando();
                    }, 8000);
 
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

    // Inicializar fileinputs de comisiones
    var tarchivosDataEl = document.getElementById('tarchivos-data');
    if (tarchivosDataEl) {
        var tarchivos = JSON.parse(tarchivosDataEl.textContent);
        tarchivos.forEach(function(item) {
            var options = {
                theme: 'fa5',
                language: 'es',
                allowedFileExtensions: [item.formato]
            };
            if (item.initialPreview && item.initialPreview.length > 0) {
                options.initialPreview = item.initialPreview;
                options.initialPreviewAsData = true;
                options.initialPreviewFileType = 'pdf';
                options.initialPreviewConfig = item.initialPreviewConfig;
                options.overwriteInitial = false;
            }
            $('#file-' + item.cod_categoria).fileinput(options);
        });
    }

    // =========================================================================
    // VISOR DE PDFS MASIVOS Y BUSCADOR EN TIEMPO REAL
    // =========================================================================

    var visiblePdfs = [];
    var currentPdfIndex = -1;

    // Función para actualizar la lista de PDFs que están visibles en la interfaz
    function actualizarPdfsVisibles() {
        visiblePdfs = [];
        $('.pdf-item').each(function() {
            var item = $(this);
            if (item.css('display') !== 'none') {
                visiblePdfs.push({
                    nombre: item.attr('data-nombre'),
                    url: item.attr('data-url'),
                    originalIndex: parseInt(item.attr('data-index'))
                });
            }
        });
    }

    // Función para previsualizar un PDF específico dentro de la lista visible
    function mostrarPdf(index) {
        if (index < 0 || index >= visiblePdfs.length) {
            return;
        }

        currentPdfIndex = index;
        var pdf = visiblePdfs[currentPdfIndex];

        // Actualizar datos del visor en el modal
        $('#previewPdfTitle').text(pdf.nombre);
        $('#pdfPreviewIframe').attr('src', pdf.url);
        $('#btnDownloadPdf').attr('href', pdf.url);
        $('#previewPdfCounter').text('Doc ' + (currentPdfIndex + 1) + ' de ' + visiblePdfs.length);

        // Habilitar/Deshabilitar botones de navegación secuencial
        if (currentPdfIndex === 0) {
            $('#btnPrevPdf').prop('disabled', true).addClass('disabled').css('opacity', '0.5');
        } else {
            $('#btnPrevPdf').prop('disabled', false).removeClass('disabled').css('opacity', '1');
        }

        if (currentPdfIndex === visiblePdfs.length - 1) {
            $('#btnNextPdf').prop('disabled', true).addClass('disabled').css('opacity', '0.5');
        } else {
            $('#btnNextPdf').prop('disabled', false).removeClass('disabled').css('opacity', '1');
        }
    }

    // Evento al hacer clic en el botón de Previsualizar
    $(".registrocomprobante").on('click', '.btn-preview-pdf', function(e) {
        e.preventDefault();
        var originalIndex = parseInt($(this).attr('data-index'));
        
        // Recalcular los PDFs visibles basados en el buscador
        actualizarPdfsVisibles();

        // Encontrar la posición del archivo seleccionado en el subconjunto de archivos visibles
        var visibleIndex = visiblePdfs.findIndex(function(pdf) {
            return pdf.originalIndex === originalIndex;
        });

        if (visibleIndex !== -1) {
            mostrarPdf(visibleIndex);
            $('#previewPdfModal').modal('show');
        }
    });

    // Controladores de navegación secuencial (Anterior / Siguiente)
    $('#btnPrevPdf').on('click', function(e) {
        e.preventDefault();
        if (currentPdfIndex > 0) {
            mostrarPdf(currentPdfIndex - 1);
        }
    });

    $('#btnNextPdf').on('click', function(e) {
        e.preventDefault();
        if (currentPdfIndex < visiblePdfs.length - 1) {
            mostrarPdf(currentPdfIndex + 1);
        }
    });

    // Soporte para navegación con atajos de teclado (Flechas Izquierda / Derecha)
    $(document).on('keydown', function(e) {
        if ($('#previewPdfModal').hasClass('in') || $('#previewPdfModal').is(':visible')) {
            if (e.keyCode === 37) { // Flecha Izquierda (Anterior)
                if (currentPdfIndex > 0) {
                    mostrarPdf(currentPdfIndex - 1);
                }
            } else if (e.keyCode === 39) { // Flecha Derecha (Siguiente)
                if (currentPdfIndex < visiblePdfs.length - 1) {
                    mostrarPdf(currentPdfIndex + 1);
                }
            }
        }
    });

    // Limpiar el recurso del iframe al cerrar el modal para liberar memoria y detener la descarga
    $('#previewPdfModal').on('hide.bs.modal', function() {
        $('#pdfPreviewIframe').attr('src', '');
    });

    // Lógica del buscador en tiempo real
    $('.registrocomprobante').on('keyup', '#buscar-pdf-input', function() {
        var query = $(this).val().toLowerCase().trim();
        var totalEncontrados = 0;

        $('.pdf-item').each(function() {
            var item = $(this);
            var nombreArchivo = item.attr('data-nombre').toLowerCase();

            if (nombreArchivo.indexOf(query) > -1) {
                item.show();
                totalEncontrados++;
            } else {
                item.hide();
            }
        });

        // Mostrar un mensaje si no se encontraron documentos coincidentes
        $('#no-pdfs-found-alert').remove();
        if (totalEncontrados === 0) {
            $('#pdf-list-container').append(
                '<div id="no-pdfs-found-alert" style="text-align: center; padding: 25px 15px; color: #888;">' +
                '<i class="mdi mdi-alert-circle-outline" style="font-size: 32px; display: block; margin-bottom: 5px; color: #ff5722;"></i>' +
                'No se encontraron documentos con ese nombre.' +
                '</div>'
            );
        }
    });

    // Actualizar el contador de archivos seleccionados (nuevos por subir) en tiempo real
    $('.registrocomprobante').on('change', '#file-DCC0000000000048', function() {
        var badge = $('#badge-pdf-count');
        if (badge.length > 0) {
            var initialCount = parseInt(badge.attr('data-initial')) || 0;
            var selectedCount = this.files ? this.files.length : 0;
            
            if (selectedCount > 0) {
                badge.text(initialCount + ' Guardados + ' + selectedCount + ' por Guardar');
                badge.css('background', '#4caf50'); // Verde para indicar archivos pendientes de guardar
            } else {
                badge.text(initialCount + ' Archivos Cargados');
                badge.css('background', '#ff5722'); // Color naranja original
            }
        }
    });

    // Restaurar badge si se limpian los archivos seleccionados en el plugin
    $('.registrocomprobante').on('filecleared', '#file-DCC0000000000048', function() {
        var badge = $('#badge-pdf-count');
        if (badge.length > 0) {
            var initialCount = parseInt(badge.attr('data-initial')) || 0;
            badge.text(initialCount + ' Archivos Cargados');
            badge.css('background', '#ff5722');
        }
    });

});




