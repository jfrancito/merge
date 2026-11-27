
$(document).ready(function () {

	var carpeta = $("#carpeta").val();
	$(document).on('change', '.checkboxcataf', function(e) {
	    let $checkbox = $(this);  // Guardamos referencia al checkbox
	    if ($checkbox.attr('data-asignado') !== '1') {
	        return;
	    }
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

	


	window.afItemsMasivo = null;

	$(document).on('change', '#chkSelectAllAF', function () {
		var checked = $(this).is(':checked');
		$('.checkboxcataf').each(function () {
			if ($(this).attr('data-asignado') !== '1') {
				$(this).prop('checked', checked);
			}
		});
	});

	$(document).on('click', '#btnActivoFijoMasivo', function (e) {
		e.preventDefault();
		var items = [];
		$('.checkboxcataf:checked').each(function () {
			if ($(this).attr('data-asignado') !== '1') {
				items.push({
					codprod: $(this).attr('attcodprod'),
					cantprod: $(this).attr('attcantprod'),
					codlote: $(this).attr('attcodlote'),
					nrolinea: $(this).attr('attnrolinea'),
					txtnombprod: $(this).attr('atttxtnombprod'),
					txtdetprod: $(this).attr('atttxtdetprod'),
					idcheckbox: $(this).attr('id')
				});
			}
		});

		if (items.length === 0) {
			alerterrorajax('Seleccione al menos un ítem para asignar categoría de Activo Fijo.');
			return;
		}

		window.afItemsMasivo = items;
		var first = items[0];
		var data = {
			_token: $('#token').val(),
			idoc: $('#idoc').val(),
			idopcion: $('#idopcion').val(),
			codprod: first.codprod,
			cantprod: first.cantprod,
			codlote: first.codlote,
			nrolinea: first.nrolinea,
			txtdetprod: first.txtdetprod,
			txtnombprod: first.txtnombprod,
			idcheckbox: first.idcheckbox
		};
		ajax_modal_local(data, "/ajax-modal-activo-fijo-categoria",
			"modal-content-categoria-af", "modal-content-categoria-af-container");
	});

	$(document).on('click', '.btnActivoFijo', function (e) {
		window.afItemsMasivo = null;
		// debugger;
		e.preventDefault();
		let codprod     =   $(this).attr("attcodprod");
		let cantprod    =   $(this).attr("attcantprod");
		let codlote    =   $(this).attr("attcodlote");
		let nrolinea    =   $(this).attr("attnrolinea");
		let txtnombprod    =   $(this).attr("atttxtnombprod");
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
	    
	    var form 		= 	$(this);
        form.parsley().validate();
        if (!form.parsley().isValid()) {
            return false;
        }

	    var url  		= 	form.attr('action');
	    var idfila		=	$('#idfila').val();
		var _token      =   $('#token').val();
		var idopcion    =   $('#idopcion').val();
		var idoc    	=   $('#idoc').val();

	    let COD_CATEGORIA_AF    =   $('#COD_CATEGORIA_AF').val();
	    let COD_PRODUCTO     	=   $('#COD_PRODUCTO').val();
	    let catPrincipal        =   $('#cat_principal').val();

	    if (!COD_CATEGORIA_AF || COD_CATEGORIA_AF === '' || COD_CATEGORIA_AF === 'OBRAS_EN_CURSO' || COD_CATEGORIA_AF === 'POR_RECIBIR') {
	        alerterrorajax('Debe seleccionar una categoría o sub-opción válida.');
	        return false;
	    }

	    let area = $('#area_clasif').val() || 'Produccion';
	    let proceso = (area === 'Produccion') ? ($('#proceso_clasif').val() || 'Pilado') : ((area === 'Gasto adm') ? 'Gastos Adm' : 'Gastos de Venta');

	    function enviarClasificacionAF() {
	        let COD_TABLA     		=   $('#COD_TABLA').val();
	        let NRO_LINEA     		=   $('#NRO_LINEA').val();
	        let COD_LOTE     		=   $('#COD_LOTE').val();
	        let CAN_PRODUCTO     	=   $('#CAN_PRODUCTO').val();
	        let TXT_DETALLE_PRODUCTO =   $('#TXT_DETALLE_PRODUCTO').val();
	        let TXT_NOMBRE_PRODUCTO =   $('#TXT_NOMBRE_PRODUCTO').val();
	        let idcheckbox     		=   $('#idcheckbox').val();
	        let tasa_depreciacion   =   $('#txt_tasa_depreciacion').val();
	        let es_arrendamiento    =   $('#chk_es_arrendamiento').is(':checked') ? 1 : 0;
	        let es_leasing          =   $('#chk_es_leasing').is(':checked') ? 1 : 0;
	        let anios_contrato      =   $('#anios_contrato').val();
			
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
							tasa_depreciacion:	tasa_depreciacion,
							es_arrendamiento:	es_arrendamiento,
							es_leasing		:	es_leasing,
							anios_contrato:		anios_contrato,
							area			:	area,
							proceso			:	proceso,
						};

	        abrircargando('Guardando Clasificación...', 1);

	        if (window.afItemsMasivo && window.afItemsMasivo.length > 0) {
	            var itemsMasivo = window.afItemsMasivo;
	            var requests = itemsMasivo.map(function(item) {
	                var itemData = $.extend({}, data, {
	                    COD_PRODUCTO: item.codprod,
	                    NRO_LINEA: item.nrolinea,
	                    COD_LOTE: item.codlote,
	                    CAN_PRODUCTO: item.cantprod,
	                    TXT_NOMBRE_PRODUCTO: item.txtnombprod,
	                    TXT_DETALLE_PRODUCTO: item.txtdetprod,
	                    idcheckbox: item.idcheckbox
	                });
	                return $.ajax({
	                    type: "POST",
	                    url: url,
	                    data: itemData
	                });
	            });

	            $.when.apply($, requests).done(function() {
	                cerrarcargando();
	                $('#modal-content-categoria-af').niftyModal('hide');
	                $('body').css('overflow', 'auto');
	                $('.be-wrapper').css('filter', 'none');
	                itemsMasivo.forEach(function(item) {
	                    $('#' + item.idcheckbox).prop('checked', true).attr('data-asignado', '1');
	                });
	                $('#chkSelectAllAF').prop('checked', false);
	                window.afItemsMasivo = null;
	                alertajax('Categoría de Activo Fijo asignada a los ítems seleccionados.');
	            }).fail(function(xhr) {
	                cerrarcargando();
	                console.error(xhr.responseText);
	                $('#modal-content-categoria-af').niftyModal('hide');
	                $('body').css('overflow', 'auto');
	                $('.be-wrapper').css('filter', 'none');
	                window.afItemsMasivo = null;
	                alerterrorajax('Ocurrió un error al guardar la categoría en uno o más ítems.');
	            });
	            return;
	        }

	        $.ajax({
	            type: "POST",
	            url: url,
	            data: data,
	            success: function(response){
	                cerrarcargando();
	                if(!response.error){
	                    $('#modal-content-categoria-af').niftyModal('hide');
	                    $('body').css('overflow', 'auto');
	                    $('.be-wrapper').css('filter', 'none');
	                    alertajax(response.mensaje);
	                    $('#'+response.idcheckbox).prop('checked',true);
	                } else {
	                    $('#modal-content-categoria-af').niftyModal('hide');
	                    $('body').css('overflow', 'auto');
	                    $('.be-wrapper').css('filter', 'none');
	                    alerterrorajax(response.mensaje);
	                }
	            },
	            error: function(xhr){
	                cerrarcargando();
	                console.error(xhr.responseText);
	                $('#modal-content-categoria-af').niftyModal('hide');
	                $('body').css('overflow', 'auto');
	                $('.be-wrapper').css('filter', 'none');
	                alerterrorajax('Ocurrió un error al guardar la categoría.');
	            }
	        });
	    }

	    enviarClasificacionAF();
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
				       	console.log(response.mensaje);
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

	            // Mover el modal al body para evitar que el filtro blur de be-wrapper lo afecte
	            $('#'+modal).appendTo('body');

	            // Inicializar y abrir modal Nifty
	            $('#'+modal).niftyModal('show'); 
	            
	            // Efecto difuminado y bloqueo de scroll
	            $('body').css('overflow', 'hidden');
	            $('.be-wrapper').css('filter', 'blur(3px)');
	            
	            // Inicializar parsley
	            if ($('#frmAgregarCategoriaActivoFijo').length > 0) {
	                $('#frmAgregarCategoriaActivoFijo').parsley();
	            }
	        },
	        error: function (data) {
	            cerrarcargando();
	            error500(data);
	        }
	    });
	}

});
