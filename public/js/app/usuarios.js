$(document).ready(function(){

    $('.sectioniconos .icon-container .icon span').on('click',function(event){
        let valor = $(this).attr('class');
        // let longitud = valor.length() -9;
        icono = valor.substring(10)
        $('#icono').val(icono);

    });



});



