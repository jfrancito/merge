
$(document).ready(function () {

	var carpeta = $("#carpeta").val();
	$('.tablainformacion .checkboxcataf').on('change', function(e) {
	    let $checkbox = $(this);  // Guardamos referencia al checkbox
	    let estadoAnterior = !$checkbox.prop('checked'); // Estado previo al cambio

	    if ($checkbox.prop('checked')) {
	        // Si se intenta marcar y no corresponde
	        e.preventDefault();
	        $checkbox.prop('checked', false);
	        return;
	    } else {
	        $.confirm({
	            title: '¿Confirma Eliminar Categoria?',
	            content: 'Eliminar Categoria Activo Fijo',
	            buttons: {
	                confirmar: function () {
	                    EliminarRegistroCategoriaActivoFijo($checkbox.attr('id'));
	                },
	                cancelar: function () {
	                    $.alert('Se canceló Eliminación');
	                    // Volvemos al estado anterior
	                    $checkbox.prop('checked', estadoAnterior);
	                }
	            }
	        });
	    }
	});

	


	$(".tablainformacion .btnActivoFijo").on('click', function (e) {
		// debugger;
		e.preventDefault();
		let codprod     =   $(this).attr("attcodprod");
		let cantprod    =   $(this).attr("attcantprod");
		let codlote    =   $(this).attr("attcodlote");
		let nrolinea    =   $(this).attr("attnrolinea");
		let txtnombprod    =   $(this).attr("attnombprod");
		let txtdetprod    =   $(this).attr("atttxtdetprod");

		let idcheckbox    	=   $(this).attr("idcheckbox");
		var _token      =   $('#token').val();
		var idopcion    =   $('#idopcion').val();
		var idoc    	=   $('#idoc').val();

		 data	=	{
						_token		:	_token,
						idoc		:	idoc,
						idopcion	:	idopcion,
						codprod		:	codprod,
						cantprod	:	cantprod,
						codlote		:	codlote,
						nrolinea	:	nrolinea,
						txtdetprod	:	txtdetprod,
						txtnombprod	:	txtnombprod,
						idcheckbox	:	idcheckbox,
					};
  		ajax_modal_local(data,"/ajax-modal-activo-fijo-categoria",
                  "modal-content-categoria-af","modal-content-categoria-af-container");
	});

	$('#modal-content-categoria-af').on('submit', '#frmAgregarCategoriaActivoFijo', function(e){
	    e.preventDefault();
	    // alert('holll'); // ✅ ahora sí debe dispararse
	    // debugger;
	    var form 		= 	$(this);
	    var url  		= 	form.attr('action');
	    var idfila		=	$('#idfila').val();
		var _token      =   $('#token').val();
		var idopcion    =   $('#idopcion').val();
		var idoc    	=   $('#idoc').val();

	    let COD_CATEGORIA_AF    =   $('#COD_CATEGORIA_AF').val();
	    let COD_PRODUCTO     	=   $('#COD_PRODUCTO').val();
	    let COD_TABLA     		=   $('#COD_TABLA').val();
	    let NRO_LINEA     		=   $('#NRO_LINEA').val();
	    let COD_LOTE     		=   $('#COD_LOTE').val();
	    let CAN_PRODUCTO     	=   $('#CAN_PRODUCTO').val();
	    let TXT_DETALLE_PRODUCTO =   $('#TXT_DETALLE_PRODUCTO').val();
	    let TXT_NOMBRE_PRODUCTO =   $('#TXT_NOMBRE_PRODUCTO').val();
	    let idcheckbox     		=   $('#idcheckbox').val();
		
	    var data	=	{
						_token		:	_token,
						idoc		:	idoc,
						idopcion	:	idopcion,
						COD_CATEGORIA_AF:	COD_CATEGORIA_AF,
						COD_PRODUCTO	:	COD_PRODUCTO,
						COD_TABLA		:	COD_TABLA,
						NRO_LINEA		:	NRO_LINEA,
						COD_LOTE		:	COD_LOTE,
						CAN_PRODUCTO	:	CAN_PRODUCTO,
						TXT_NOMBRE_PRODUCTO	:	TXT_NOMBRE_PRODUCTO,
						TXT_DETALLE_PRODUCTO	:	TXT_DETALLE_PRODUCTO,
						idcheckbox		:	idcheckbox,
					};
	    $.ajax({
	        type: "POST",
	        url: url,
	        data: data,
	        success: function(response){
	              if(!response.error){
				        $('#modal-content-categoria-af').niftyModal('hide');
				        alertajax(response.mensaje);
				       	console.error(response.mensaje);
				       	// abrircargando('Registrando Categoria');
				       	// debugger;
				       	$('#'+response.idcheckbox).prop('checked',true);
				        // location.reload();
				       	// debugger;
				        // alertajax('CATEGORIZADO CORRECTAMENTE');
				  } else {
				  		$('#modal-content-categoria-af').niftyModal('hide');
				       alertajax(response.mensaje);
				  }

	        },
	        error: function(xhr){
	            console.error(xhr.responseText);
	            $('#modal-content-categoria-af').niftyModal('hide');
	            alert('Ocurrió un error al guardar');
	        }
	    });
	});



	function EliminarRegistroCategoriaActivoFijo(idcheckbox)
	{
		// alertajax(idcheckbox);
		var _token      = $('#token').val();
        var control  	=	$('#'+idcheckbox);
        // alertajax(control.prop('checked'));

       	let codprod     =   control.attr("attcodprod");
		let cantprod    =   control.attr("attcantprod");
		let codlote    	=   control.attr("attcodlote");
		let nrolinea    =   control.attr("attnrolinea");
		let txtnombprod =   control.attr("attnombprod");
		let txtdetprod  =   control.attr("atttxtdetprod");
		var _token      =   $('#token').val();
		var idopcion    =   $('#idopcion').val();
		var idoc    	=   $('#idoc').val();
		let link 	=	'/eliminar-activo-fijo-categoria/'+idopcion+'/'+idoc+'/'+codprod+'/'+codlote+'/'+nrolinea;
		let url     =   carpeta+link;
		debugger;
		data	=	{
						_token		:	_token,
						idoc		:	idoc,
						idopcion	:	idopcion,
						codprod		:	codprod,
						cantprod	:	cantprod,
						codlote		:	codlote,
						nrolinea	:	nrolinea,
						txtdetprod	:	txtdetprod,
						txtnombprod	:	txtnombprod,
						idcheckbox	:	idcheckbox,
					};
		abrircargando();
		$.ajax({
	        type: "POST",
	        url: url,
	        data: data,
	        success: function(response){
        		cerrarcargando();
	              if(!response.error){
					debugger;
				        // $('#modal-content-categoria-af').niftyModal('hide');
				        alertajax(response.mensaje);
				       	console.error(response.mensaje);
				       	$('#'+response.idcheckbox).prop('checked',false);
				        
				  } else {
						debugger;
				  		// $('#modal-content-categoria-af').niftyModal('hide');
				       alertajax(response.mensaje);
				  }

	        },
	        error: function(xhr){
	        	debugger;
	        	cerrarcargando();
	            console.error(xhr.responseText);
	            alert('Ocurrió un error el eliminar Categoria AF');
	        }
	    });
		return true;
	}

	function ajax_modal_local(data,link,modal,contenedor_ajax) {
	    abrircargando();

	    $.ajax({
	        type    :   "POST",
	        url     :   carpeta+link,
	        data    :   data,
	        success: function (data) {
	            cerrarcargando();
	            $('.'+contenedor_ajax).html(data);

	            // Inicializar y abrir modal Nifty
	            $('#'+modal).niftyModal('show'); 
	            // O prueba con $('#'+modal).openModal();
	        },
	        error: function (data) {
	            cerrarcargando();
	            error500(data);
	        }
	    });
	}

});
