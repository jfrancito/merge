$(document).ready(function () {
    let carpeta = $("#carpeta").val();


    $('.btnrechazocomporbatnte').on('click', function (event) {
        event.preventDefault();
        $.confirm({
            title: '¿Confirma el extorno?',
            content: 'Extornar el Comprobante',
            buttons: {
                confirmar: function () {
                    $("#formpedidorechazar").submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo el Extorno');
                }
            }
        });

    });

    $('.btnaprobarcomporbatnteconta').on('click', function(event){
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


});




