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

// Inicialmente colapsar el contenido adicional
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('longText').classList.add('collapsed');
});



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

    $(".registrocomprobante").on('click','.agregar_cuenta_bancaria', function() {

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

        ajax_modal(data,"/ajax-modal-configuracion-cuenta-bancaria-contrato",
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

        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009'];

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






    $(".registrocomprobante").on('change','.entidadbanco', function() {

        debugger;

        var _token              =   $('#token').val();
        var entidadbanco_id     =   $(this).val();
        var prefijo_id          =   $('#prefijo_id').val();
        var orden_id            =   $('#orden_id').val();

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
        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009'];
        if(!valores.includes(entidadbanco_id)){
            if(cb_id==''){
                alerterrorajax("Seleccione una Cuenta Bancaria."); return false;
            }
        }
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
                    }, 6000);
 
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
        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009'];
        if(!valores.includes(entidadbanco_id)){
            if(cb_id==''){
                alerterrorajax("Seleccione una Cuenta Bancaria."); return false;
            }
        }
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
                    }, 6000);
 
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


        var ctadetraccion           =   $('#ctadetraccion').val();
        var monto_detraccion        =   $('#monto_detraccion').val();
        var pago_detraccion         =   $('#pago_detraccion').val();

        debugger;
        if(detraccion>0){
            if(ctadetraccion.trim() ==''){ alerterrorajax("Ingrese una Cuenta de Detraccion."); return false;}
            if(monto_detraccion =='0'){ alerterrorajax("Ingrese Monto de Detraccion."); return false;}
            if(pago_detraccion ==''){ alerterrorajax("Seleeccione un pago de detraccion"); return false;}            
        }

        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009'];

        if(!valores.includes(entidadbanco_id)){
            if(cb_id==''){
                alerterrorajax("Seleccione una Cuenta Bancaria."); return false;
            }
        }

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
                    }, 6000);
 
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

        var valores = ['BAM0000000000007', 'BAM0000000000008', 'BAM0000000000009'];

        if(!valores.includes(entidadbanco_id)){
            if(cb_id==''){
                alerterrorajax("Seleccione una Cuenta Bancaria."); return false;
            }
        }

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
                    }, 6000);
 
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



});




