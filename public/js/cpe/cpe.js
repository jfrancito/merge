$(document).ready(function(){
    var carpeta = $("#carpeta").val();
    $(".containercpe").on('click','.btn_cargando', function() {
        //event.preventDefault();
        //abrircargando();
        //abrircargando();

    });

    $('.frmbuscar').submit(function() {
        // Aquí puedes ejecutar cualquier código que desees después de enviar el formulario
        abrircargando();
    });

});




