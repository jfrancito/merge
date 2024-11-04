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


    $(".registrocomprobante").on('change','.entidadbancooc', function() {

        debugger;

        var _token              =   $('#token').val();
        var entidadbanco_id     =   $(this).val();
        var prefijo_id          =   $('#prefijo_id').val();
        var orden_id            =   $('#orden_id').val();

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




    $(".registrocomprobante").on('click','.btn-guardar-xml', function(e) {

        event.preventDefault();
        var _token                  =   $('#token').val();
        var te                      =   $('#te').val();
        var entidadbanco_id         =   $('#entidadbanco_id').val();
        var cb_id                   =   $('#cb_id').val();



        if(entidadbanco_id!='BAM0000000000007'){
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




