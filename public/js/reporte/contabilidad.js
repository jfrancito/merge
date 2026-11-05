$(document).ready(function(){
    var carpeta = $("#carpeta").val();



    $('#descargaranticipoprestamopdf').on('click', function(event){

        var _token              = $('#token').val();
        var centro_id           = $('#centro_id').select2().val();
        var fechainicio         = $('#fechainicio').val();        
        var fechafin            = $('#fechafin').val(); 

        /****** VALIDACIONES ********/
        if(centro_id.length<=0){
            alerterrorajax("Seleccione un centro para el reporte");
            return false;
        }
        if(fechainicio == ''){
            alerterrorajax("Seleccione una fecha de inicio");
            return false;
        }

        if(fechafin == ''){
            alerterrorajax("Seleccione una fecha de fin");
            return false;
        } 

        href = $(this).attr('data-href')+'/'+centro_id+'/'+fechainicio+'/'+fechafin;
        $(this).prop('href', href);
        return true;

    });

});