
$(document).ready(function(){

$(".be-content").on('click','.checkbox_asignar', function() {

    var input   = $(this).siblings('.input_asignar');
    var accion  = $(this).attr('data-atr');

    var name    = $(this).attr('name');
    var check   = -1;
    var estado  = -1;
    
    console.log("check");

    if($(input).is(':checked')){

        check   = 0;
        estado  = false;

    }else{

        check   = 1;
        estado  = true;

    }
    validarrelleno(accion,name,estado,check);
});

});


var carpeta = $("#carpeta").val();
//ajax normal

function ajax_normal_combo(data,link,contenedor) {
    $(".listajax").html("");
    abrircargando();
    $.ajax({
        type    :   "POST",
        url     :   carpeta+link,
        data    :   data,
        success: function (data) {
            cerrarcargando();
            $("."+contenedor).html(data);

        },
        error: function (data) {
            cerrarcargando();
            error500(data);
        }
    });
}

function ajax_normal_section(data,link,section) {
    $("."+section).html("");
    abrircargando();
    $.ajax({
        type    :   "POST",
        url     :   carpeta+link,
        data    :   data,
        success: function (data) {
            cerrarcargando();
            $("."+section).html(data);

        },
        error: function (data) {
            cerrarcargando();
            error500(data);
        }
    });
}


function ajax_normal(data,link) {
    $(".listajax").html("");
    abrircargando();
    $.ajax({
        type    :   "POST",
        url     :   carpeta+link,
        data    :   data,
        success: function (data) {
            cerrarcargando();
            $(".listajax").html(data);

        },
        error: function (data) {
            cerrarcargando();
            error500(data);
        }
    });
}

function ajax_normal_cargar(data,link) {
    abrircargando();
    $.ajax({
        type    :   "POST",
        url     :   carpeta+link,
        data    :   data,
        success: function (data) {
            cerrarcargando();
            location.reload();
        },
        error: function (data) {
            cerrarcargando();
            error500(data);
        }
    });
}


function ajax_normal_form(data,link) {
    $(".formajax").html("");
    abrircargando();
    $.ajax({
        type    :   "POST",
        url     :   carpeta+link,
        data    :   data,
        success: function (data) {
            cerrarcargando();
            $(".formajax").html(data);

        },
        error: function (data) {
            cerrarcargando();
            error500(data);
        }
    });
}

function ajax_normal_form_alert(data,link,mensaje,click) {
    abrircargando();
    $.ajax({
        type    :   "POST",
        url     :   carpeta+link,
        data    :   data,
        success: function (data) {
            cerrarcargando();
            alertajax(mensaje);
             $( "."+click).click();
        },
        error: function (data) {
            cerrarcargando();
            error500(data);
        }
    });
}


function ajax_normal_guardar_lista(data,link,btnclick) {

    abrircargando();
    $.ajax({
        type    :   "POST",
        url     :   carpeta+link,
        data    :   data,
        success: function (data) {
            cerrarcargando();
            //console.log(data);
            $('.'+btnclick).click();
        },
        error: function (data) {
            cerrarcargando();
            error500(data);
        }
    });
}



function ajax_modal(data,link,modal,contenedor_ajax) {

    abrircargando();

    $.ajax({
        type    :   "POST",
        url     :   carpeta+link,
        data    :   data,
        success: function (data) {
            cerrarcargando();
            $('.'+contenedor_ajax).html(data);
            $('#'+modal).niftyModal();

        },
        error: function (data) {
            cerrarcargando();
            error500(data);
        }
    });
}


//atibutos vacios
function errorvacio(atributo,texto) {
    if(atributo ==''){ alerterrorajax(texto); return false;}
}




function validarrelleno(accion,name,estado,check,token){


    if (accion=='todas_asignar') {

        var table = $('.listatabla').DataTable();
        $(".listatabla tr").each(function(){
            nombre = $(this).find('.input_asignar').attr('id');
            if(nombre != 'todo_asignar'){
                $(this).find('.input_asignar').prop("checked", estado);
            }
        });
    }else{

        sw = 0;
        if(estado){
            $(".listatabla tr").each(function(){
                nombre = $(this).find('.input_asignar').attr('id');

                console.log($(this).find('.input_asignar').length);

                if(nombre != 'todo_asignar' && $(this).find('.input_asignar').length > 0){
                    if(!($(this).find('.input_asignar').is(':checked'))){
                        sw = sw + 1;
                    }
                }
            });
            if(sw==1){
                $("#todo_asignar").prop("checked", estado);
            }
        }else{
            $("#todo_asignar").prop("checked", estado);
        }           
    }
}
