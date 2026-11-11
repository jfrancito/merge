$(document).ready(function(){
    var carpeta = $("#carpeta").val();



    $('#descargarpedidoestadoexcel').on('click', function(event){

        var _token              = $('#token').val();
        var estado_id           = $('#estado_id').select2().val();
        var finicio             = $('#finicio').val();        
        var ffin                = $('#ffin').val(); 
        var centro_id           = $('#centro_id').select2().val();



        /****** VALIDACIONES ********/

        if(centro_id.length<=0){
            alerterrorajax("Seleccione un centro para el reporte");
            return false;
        }

        
        if(estado_id.length<=0){
            alerterrorajax("Seleccione un estado para el reporte");
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


        href = $(this).attr('data-href')+'/'+finicio+'/'+ffin+'/'+estado_id+'/'+centro_id;
        $(this).prop('href', href);
        return true;
    });


    $('#buscarreportepedidoestado').on('click', function(event){

        var _token              = $('#token').val();
        var estado_id           = $('#estado_id').select2().val();
        var centro_id           = $('#centro_id').select2().val();

        var finicio             = $('#finicio').val();        
        var ffin                = $('#ffin').val(); 

        /****** VALIDACIONES ********/

        if(centro_id.length<=0){
            alerterrorajax("Seleccione un centro para el reporte");
            return false;
        }


        if(estado_id.length<=0){
            alerterrorajax("Seleccione un estado para el reporte");
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

        var textoajax   = $('.listapedidoestado').html(); 
        $(".listapedidoestado").html("");

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-reporte-pedido-estado",
            data    :   {
                            _token          : _token,
                            estado_id       : estado_id,
                            centro_id       : centro_id,
                            finicio         : finicio,
                            ffin            : ffin,                           
                        },
            success: function (data) {
                cerrarcargando();
                $(".listapedidoestado").html(data);                
            },
            error: function (data) {

                cerrarcargando();
                
                if(data.status = 500){

                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    $(".listapedidoestado").html(textoajax);  
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });


    });





    $('#buscarreporteprecioproducto').on('click', function(event){

        var _token              = $('#token').val();
        var cuenta_id           = $('#cuenta_id').select2().val();
        var tipoprecio_id           = $('#tipoprecio_id').select2().val();


        if(cuenta_id.length<=0){
            alerterrorajax("Seleccione un cliente para el reporte");
            return false;
        }

        abrircargando();

        var textoajax   = $('.listaprecioproducto').html(); 
        $(".listaprecioproducto").html("");

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-reporte-lista-precio-producto",
            data    :   {
                            _token          : _token,
                            cuenta_id       : cuenta_id,
                            tipoprecio_id   : tipoprecio_id,                            
                        },
            success: function (data) {
                cerrarcargando();
                $(".listaprecioproducto").html(data);                
            },
            error: function (data) {

                cerrarcargando();
                
                if(data.status = 500){

                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    $(".listaprecioproducto").html(textoajax);  
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });


    });



    $('#buscarreporteevolucionprecioproducto').on('click', function(event){

        var _token              = $('#token').val();
        var cuenta_id           = $('#cuenta_id').select2().val();
        var fechafin            = $('#fechafin').val(); 


        if(cuenta_id.length<=0){
            alerterrorajax("Seleccione un cliente para el reporte");
            return false;
        }

        if(fechafin == ''){
            alerterrorajax("Seleccione un día");
            return false;
        } 


        abrircargando();

        var textoajax   = $('.listaprecioproducto').html(); 
        $(".listaprecioproducto").html("");

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-reporte-lista-evolucion-precio-producto",
            data    :   {
                            _token          : _token,
                            cuenta_id       : cuenta_id,
                            fechafin        : fechafin,                            
                        },
            success: function (data) {
                cerrarcargando();
                $(".listaprecioproducto").html(data);                
            },
            error: function (data) {

                cerrarcargando();
                
                if(data.status = 500){

                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    $(".listaprecioproducto").html(textoajax);  
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });


    });


    $('#descargarpreciomayoristaexcel').on('click', function(event){

        var _token              = $('#token').val();
        var fechafin            = $('#fechafin').val();

        if(fechafin == ''){
            alerterrorajax("Seleccione un día");
            return false;
        } 

        href = $(this).attr('data-href')+'/'+fechafin;
        $(this).prop('href', href);
        return true;
    });



    $('#descargarpreciomayoristapdf').on('click', function(event){

        var _token              = $('#token').val();
        var fechafin            = $('#fechafin').val(); 

        if(fechafin == ''){
            alerterrorajax("Seleccione un día");
            return false;
        } 

        href = $(this).attr('data-href')+'/'+fechafin;
        $(this).prop('href', href);
        return true;

    });




    $('#descargarprecioclienteexcel').on('click', function(event){

        var _token              = $('#token').val();
        var cuenta_id           = $('#cuenta_id').select2().val();
        var tipoprecio_id           = $('#tipoprecio_id').select2().val();

        if(cuenta_id.length<=0){
            alerterrorajax("Seleccione un cliente para el reporte");
            return false;
        }

        href = $(this).attr('data-href')+'/'+cuenta_id+'/'+tipoprecio_id;
        $(this).prop('href', href);
        return true;


    });


    $('#descargarprecioclientepdf').on('click', function(event){


        var _token              = $('#token').val();
        var cuenta_id           = $('#cuenta_id').select2().val();
        var tipoprecio_id           = $('#tipoprecio_id').select2().val();

        if(cuenta_id.length<=0){
            alerterrorajax("Seleccione un cliente para el reporte");
            return false;
        }
        
        href = $(this).attr('data-href')+'/'+cuenta_id+'/'+tipoprecio_id;
        $(this).prop('href', href);
        return true;


    });


    $('#descargarevolucionprecioclientepdf').on('click', function(event){


        var _token              = $('#token').val();
        var cuenta_id           = $('#cuenta_id').select2().val();
        var fechafin            = $('#fechafin').val(); 


        if(cuenta_id.length<=0){
            alerterrorajax("Seleccione un cliente para el reporte");
            return false;
        }
        

        if(fechafin == ''){
            alerterrorajax("Seleccione un día");
            return false;
        } 

        href = $(this).attr('data-href')+'/'+cuenta_id+'/'+fechafin;
        $(this).prop('href', href);
        return true;


    });


    $('#descargarevolucionprecioclienteexcel').on('click', function(event){

        var _token              = $('#token').val();
        var cuenta_id           = $('#cuenta_id').select2().val();
        var fechafin            = $('#fechafin').val();

        if(cuenta_id.length<=0){
            alerterrorajax("Seleccione un cliente para el reporte");
            return false;
        }

        if(fechafin == ''){
            alerterrorajax("Seleccione un día");
            return false;
        } 



        href = $(this).attr('data-href')+'/'+cuenta_id+'/'+fechafin;
        $(this).prop('href', href);
        return true;


    });


});