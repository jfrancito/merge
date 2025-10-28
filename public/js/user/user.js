$(document).ready(function(){


	var carpeta = $("#carpeta").val();


	$('#personal').on('change', function() {
	    var dataUsuario = $(this).find(':selected').attr('data_usuario');
	    $("#name").val(dataUsuario.trim());
	    
	    //console.log(dataUsuario);
	});




    $('#buscartrabajador').on('click', function(event){

    	var dni 	= $("#dni").val();
    	var _token 	= $('#token').val();
        abrircargando();
		$(".trabajadorencontrado").html("");

        $.ajax({
            type	: 	"POST",
            url		: 	carpeta+"/ajax-dato-del-trabajador",
            data	: 	{
            				_token	: _token,
            				dni 	: dni
            	 		},
            success: function (data) {
            	cerrarcargando();
            	$(".trabajadorencontrado").html(data);
            },
            error: function (data) {
            	cerrarcargando();
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });

    });	

    

    $(".ajaxpersonal").on('change','#empresa_id', function() {
        var empresa_id = $('#empresa_id').val();
        var _token      = $('#token').val();

        $.ajax({
            
            type    :   "POST",
            url     :   carpeta+"/ajax-select-local",
            data    :   {
                            _token  : _token,
                            empresa_id : empresa_id
                        },
            success: function (data) {

                $(".ajaxlocal").html(data);
            },
            error: function (data) {

                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });
    });


    $('.selectrol').on('click', function(event){
    	event.preventDefault();
    	var idrol 	= $(this).attr("id");
    	var _token 	= $('#token').val();
		$(".listadoopciones").html("");
		$(".menu-roles li").removeClass( "active" )
		$(this).parents('li').addClass("active");

        $.ajax({
            type	: 	"POST",
            url		: 	carpeta+"/ajax-listado-de-opciones",
            data	: 	{
            				_token: _token,
            				idrol : idrol
            	 		},
            success: function (data) {
            	//console.log(data);
            	$(".listadoopciones").html(data);
            },
            error: function (data) {
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });

    });	



	$(".listadoopciones").on('click','label', function() {

		var input 	= $(this).siblings('input');
		var accion	= $(this).attr('data-atr');
		var name	= $(this).attr('name');
		var _token 	= $('#token').val()
		var check 	= -1;
		var estado 	= -1;
		

		if($(input).is(':checked')){ 
			check 	= 0;
			estado 	= false;
		}else{
			check = 1;
			estado 	= true;
		}

		data = validarrelleno(accion,name,estado,check,_token);

        $.ajax({
            type	: 	"POST",
            url		: 	carpeta+"/ajax-activar-permisos",
            data	: 	data,
            success: function (data) {

				alertajax("Realizado con exito");
            	console.log(data);

            },
            error: function (data) {
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });
		
	});


	$(".listadoperfiles").on('click','label', function() {

		var input 		= $(this).siblings('input');
		var idempresa	= $(this).attr('data-idempresa');
		var idcentro	= $(this).attr('data-idcentro');
		var idusuario	= $(this).attr('data_idusuario');
		var _token 		= $('#token').val()
		var check 		= -1;
		var estado 		= -1;
		
		if($(input).is(':checked')){ 
			check 	= 0;
			estado 	= false;
		}else{
			check = 1;
			estado 	= true;
		}

        $.ajax({
            type	: 	"POST",
            url		: 	carpeta+"/ajax-activar-perfiles",
            data    :   {
                            _token  		: _token,
                            idempresa 		: idempresa,
                            idcentro 		: idcentro,
                            idusuario 		: idusuario,
                            check 			: check
                        },
            success: function (data) {

				alertajax("Realizado con exito");
            	console.log(data);

            },
            error: function (data) {
                if(data.status = 500){
                    /** error 505 **/
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });
		
	});




	function validarrelleno(accion,name,estado,check,token){

		var ver = 0,anadir = 0,modificar=0,todas = 0;
		var data = {};
		if (accion=='todas') {

			$("#1"+name).prop("checked", estado);
			$("#2"+name).prop("checked", estado);
			$("#3"+name).prop("checked", estado);
			data = 		{
							_token		: token,
							idrolopcion : name ,
							ver 		: check ,
							anadir  	: check , 
							modificar 	: check ,
							todas 		: check
						};
		}else{
			if (accion=='ver') {
				if (estado==false){

					$("#2"+name).prop("checked", estado);
					$("#3"+name).prop("checked", estado);
					$("#4"+name).prop("checked", estado);	
					data = {
						_token		: token,
						idrolopcion : name ,
						ver 		: 0 ,
						anadir  	: 0 , 
						modificar 	: 0 ,
						todas 		: 0
					}
				}else{
					data = {
						_token		: token,
						idrolopcion : name ,
						ver 		: 1 ,
						anadir  	: 0 , 
						modificar 	: 0 ,
						todas 		: 0
					}
				}
			}else{

				if (accion=='anadir') {

					if (estado==false){

						$("#4"+name).prop("checked", estado);
						if($("#1"+name).is(':checked')) {ver = 1;}else{ver=0;}
						if($("#3"+name).is(':checked')) {modificar = 1;}else{modificar=0;}
						if($("#4"+name).is(':checked')) {todas = 1;}else{todas=0;}	

						data = {
							_token		: token,
							idrolopcion : name ,
							ver 		: ver ,
							anadir  	: 0 , 
							modificar 	: modificar ,
							todas 		: todas
						}

					}else{

						$("#1"+name).prop("checked", estado);
						if($("#1"+name).is(':checked')) {ver = 1;}else{ver=0;}
						if($("#3"+name).is(':checked')) {modificar = 1;}else{modificar=0;}
						if(ver == 1  && modificar ==1) {$("#4"+name).prop("checked", estado);}						
						if($("#4"+name).is(':checked')) {todas = 1;}else{todas=0;}	


						data = {
							_token		: token,
							idrolopcion : name ,
							ver 		: ver ,
							anadir  	: 1 , 
							modificar 	: modificar ,
							todas 		: todas
						}
					}
				}else{

					if (estado==false){

						$("#4"+name).prop("checked", estado);
						if($("#1"+name).is(':checked')) {ver = 1;}else{ver=0;}
						if($("#2"+name).is(':checked')) {anadir = 1;}else{anadir=0;}
						if($("#4"+name).is(':checked')) {todas = 1;}else{todas=0;}	

						data = {
							_token		: token,
							idrolopcion : name ,
							ver 		: ver ,
							anadir  	: anadir , 
							modificar 	: 0 ,
							todas 		: todas
						}

					}else{

						$("#1"+name).prop("checked", estado);
						if($("#1"+name).is(':checked')) {ver = 1;}else{ver=0;}
						if($("#2"+name).is(':checked')) {anadir = 1;}else{anadir=0;}
						if(ver == 1  && anadir ==1) {$("#4"+name).prop("checked", estado);}
						if($("#4"+name).is(':checked')) {todas = 1;}else{todas=0;}

						data = {
							_token		: token,
							idrolopcion : name ,
							ver 		: ver ,
							anadir  	: anadir , 
							modificar 	: 1 ,
							todas 		: todas
						}
					}


				}
			}
		}

		return data;

	}



});