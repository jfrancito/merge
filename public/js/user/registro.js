    
$(document).ready(function(){

    var carpeta = $("#carpeta").val();
    $(".registroruc").on('click','.buscarruc', function(e) {

        var _token          = $('#token').val();
        var ruc             = $('#ruc').val();

        debugger;

        $.ajax({

            type    :   "POST",
            url     :   carpeta+"/ajax-buscar-proveedor",
            data    :   {
                            _token          : _token,
                            ruc             : ruc,
                        },
            success: function (data) {
                        debugger;
                $('.encontro_proveedor').html(data);   
                debugger;                
            },
            error: function (data) {
                if(data.status = 500){
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });

    });

    $(".registroruc").on('click','.btn-registrate', function(e) {

        event.preventDefault();
        var idactivo       =   $('#idactivo').val();
        var mensaje       =   $('.mensaje').html();
        debugger;
        if(idactivo == 0){ alerterrorajax(mensaje); return false;}
        return true;

    });






});


