$(document).ready(function(){
    var carpeta = $("#carpeta").val();


    $('#buscarreporteguiadetraccion').on('click', function(event){

        var _token              = $('#token').val();
        var centro_id           = $('#centro_id').select2().val();
        var finicio             = $('#fechainicio').val();        
        var ffin                = $('#fechafin').val(); 

        /****** VALIDACIONES ********/
        if(centro_id.length<=0){
            alerterrorajax("Seleccione un centro para el reporte");
            return false;
        }
        if(finicio == ''){
            alerterrorajax("Seleccione una fecha de inicio");
            return false;
        }

        if(ffin == ''){
            alerterrorajax("Seleccione una fecha de fin");
            return false;
        } 

        abrircargando();
        var textoajax   = $('.listajax').html(); 
        $(".listajax").html("");

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-reporte-pago-detracciones",
            data    :   {
                            _token          : _token,
                            centro_id       : centro_id,
                            finicio         : finicio,
                            ffin            : ffin,                           
                        },
            success: function (data) {
                cerrarcargando();
                $(".listajax").html(data);                
            },
            error: function (data) {
                cerrarcargando();
                if(data.status = 500){
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    $(".listajax").html(textoajax);  
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });


    });


});