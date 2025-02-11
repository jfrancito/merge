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

    $(".secaprobar").on('click','.mdidetoi', function(e) {
        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        const data_doc              =   $(this).attr('data_doc');

        data                        =   {
                                            _token                  : _token,
                                            data_doc                : data_doc
                                        };
        ajax_modal(data,"/ajax-detalle-documento",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");


    });




    $('.elimnaritem').on('click', function(event){
        event.preventDefault();
        var href = $(this).attr('href');

        $.confirm({
            title: '¿Confirma la Eliminacion?',
            content: 'Eliminar item del Comprobante',
            buttons: {
                confirmar: function () {
                    window.location.href = href;
                },
                cancelar: function () {
                    $.alert('Se cancelo Eliminacion');
                }
            }
        });

    });

    $('.btnaprobarcomporbatnte').on('click', function(event){
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Aprobacion?',
            content: 'Aprobar el Comprobante',
            buttons: {
                confirmar: function () {
                    $( "#formpedido" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo Aprobacion');
                }
            }
        });

    });

    $('.btnobservarcomporbatnte').on('click', function(event){
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Observacion?',
            content: 'Observacion el Comprobante',
            buttons: {
                confirmar: function () {
                    $( "#formpedidoobservar" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la Observacion');
                }
            }
        });

    });

    $('.btnreparablecomporbatnte').on('click', function(event){
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Observacion?',
            content: 'Observacion el Comprobante',
            buttons: {
                confirmar: function () {
                    $( "#formpedidoreparable" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la Observacion');
                }
            }
        });

    });

    $('.btnrechazocomporbatnte').on('click', function(event){
        event.preventDefault();
        $.confirm({
            title: '¿Confirma el extorno?',
            content: 'Extornar el Comprobante',
            buttons: {
                confirmar: function () {
                    $( "#formpedidorechazar" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo el Extorno');
                }
            }
        });

    });




    $('.btnrecomendarcomprobante').on('click', function(event){
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Recomendacion?',
            content: 'Recomendacion del Comprobante',
            buttons: {
                confirmar: function () {
                    $( "#formpedidorecomendar" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la Recomendacion');
                }
            }
        });

    });







    $('.btnguardarcliente').on('click', function(event){
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Aprobacion?',
            content: 'Aprobar el Comprobante',
            buttons: {
                confirmar: function () {
                    $( "#formpedido" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo Aprobacion');
                }
            }
        });

    });


    $('.btnextornar').on('click', function(event){
        event.preventDefault();
        $.confirm({
            title: '¿Confirma el Extorno?',
            content: 'Extorno el Comprobante',
            buttons: {
                confirmar: function () {
                    $( "#formpedido" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo el Extorno');
                }
            }
        });

    });


    $('.btnobservar').on('click', function(event){
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Observacion?',
            content: 'Observacion el Comprobante',
            buttons: {
                confirmar: function () {
                    $( "#formpedido" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la Observacion');
                }
            }
        });

    });


    $('.btnrecomendar').on('click', function(event){
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Recomendacion?',
            content: 'Recomendacion del Comprobante',
            buttons: {
                confirmar: function () {
                    $( "#formpedido" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la Recomendacion');
                }
            }
        });

    });




    $('#preaprobar').on('click', function(event){
        event.preventDefault();
        data = dataenviar();
        if(data.length<=0){alerterrorajax("Seleccione por lo menos un Comprobante");return false;}
        var datastring = JSON.stringify(data);
        $('#pedido').val(datastring);
        $.confirm({
            title: '¿Confirma la Pre Aprobacion?',
            content: 'Pre Aprobar los Comprobantes',
            buttons: {
                confirmar: function () {
                    abrircargando();
                    $( "#formpedido" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo Pre Aprobacion');
                }
            }
        });

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
