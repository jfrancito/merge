$(document).ready(function(){

    var carpeta = $("#carpeta").val();
    $(".registrocomprobante").on('click','.btn-guardar-xml', function(e) {
        var _token                  =   $('#token').val();
        var te                      =   $('#te').val();
        if(te =='0'){ alerterrorajax("Hay errores en la validacion del XML."); return false;}
        return true;
    });

});




