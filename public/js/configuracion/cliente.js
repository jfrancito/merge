$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    $(".formcliente").on('change','#tipo_documento_id', function() {
        debugger;
        var tipodocumento = $('#tipo_documento_id').select2('data');
        var tipo_documento_id = $('#tipo_documento_id').val();
        var cadtipodocumento  =   '';
        if(tipodocumento){
            tipo_documento_id   =   tipodocumento[0].id;
            cadtipodocumento    =   tipodocumento[0].text;
        }
        if(cadtipodocumento=='SIN DOC'){
            // alerterror505ajax(cadtipodocumento);
            var _token      = $('#token').val();
            // alerterrorajax('DEBE SELECCIONAR UN LOTE PARA CLONAR');
            // return false;
            $.ajax({
            
                type    :   "POST",
                url     :   carpeta+"/ajax-cargar-ndoc-cliente-sin-documentos",
                data    :   {
                                _token  : _token
                                // tipo_documento_id : tipo_documento_id
                            },
                success: function (data) {
                    $(".formcliente #numerodocumento").val(data);
                },
                error: function (data) {

                    console.log('Error:', data);
                }
            });
            $(".formcliente #sindocumento").val(1); 
        }
        else{
            $(".formcliente #numerodocumento").val('');
            $(".formcliente #sindocumento").val(0);
        }
        // return false;        
    });

	$(".ajaxubigeo").on('change','#departamento_id', function() {
		debugger;
        var departamento_id = $('#departamento_id').val();
    	var _token 		= $('#token').val();

        $.ajax({
            
            type	: 	"POST",
            url		: 	carpeta+"/ajax-select-provincia",
            data	: 	{
            				_token	: _token,
            				departamento_id : departamento_id
            	 		},
            success: function (data) {

            	$(".ajaxprovincia").html(data);
            },
            error: function (data) {

                console.log('Error:', data);
            }
        });
    });

	$(".ajaxubigeo").on('change','#provincia_id', function() {

		var provincia_id = $('#provincia_id').val();

    	var _token 		= $('#token').val();

        $.ajax({

            type	: 	"POST",
            url		: 	carpeta+"/ajax-select-distrito",
            data	: 	{
            				_token	: _token,
            				provincia_id : provincia_id
            	 		},
            success: function (data) {

            	$(".ajaxdistrito").html(data);
            },
            error: function (data) {

                console.log('Error:', data);
            }
        });
    });


});