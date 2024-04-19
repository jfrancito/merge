$(document).ready(function(){

    var carpeta = $("#carpeta").val();

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
