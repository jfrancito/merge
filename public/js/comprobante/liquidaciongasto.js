
$(document).ready(function(){
    var carpeta = $("#carpeta").val();


    $(".liquidaciongasto").on('click','.btncargarsunat', function(e) {
        e.preventDefault(); // Prevenir recarga del formulario

        var RUTAXML                 =   $('#RUTAXML').val();
        var RUTAPDF                 =   $('#RUTAPDF').val();
        var RUTACDR                 =   $('#RUTACDR').val();
        var exml                    =   $('.exml').html();
        var epdf                    =   $('.epdf').html();
        var ecdr                    =   $('.ecdr').html();

        var _token                  =   $('#token').val();
        var ID_DOCUMENTO            =   $('#ID_DOCUMENTO').val();
        if(RUTAXML ==''){ alerterrorajax("No existe XML para Cargar."); return false;}

        data                                         =   {
                                                                _token                  : _token,
                                                                ID_DOCUMENTO            : ID_DOCUMENTO,
                                                                RUTAXML                 : RUTAXML,
                                                                RUTAPDF                 : RUTAPDF,
                                                                RUTACDR                 : RUTACDR,
                                                                exml                    : exml,
                                                                epdf                    : epdf,
                                                                ecdr                    : ecdr,

                                                         };   

        const link          =   '/ajax-leer-xml-lg-sunat';
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+link,
            data    :   data,
            success: function (data) {
                cerrarcargando();
                debugger;
                if(data.error == 0){
                    $('#serie').val(data.SERIE);
                    $('#numero').val(data.NUMERO);
                    $('#fecha_emision').val(data.FEC_VENTA);
                    $('#totaldetalle').val(data.TOTAL_VENTA_ORIG);

                    $('.MESSAGE').html(data.MESSAGE);
                    $('.NESTADOCP').html(data.NESTADOCP);
                    $('.NESTADORUC').html(data.NESTADORUC);
                    $('.NCONDDOMIRUC').html(data.NCONDDOMIRUC);

                    $('#SUCCESS').val(data.SUCCESS);
                    $('#MESSAGE').val(data.MESSAGE);
                    $('#ESTADOCP').val(data.ESTADOCP);
                    $('#NESTADOCP').val(data.NESTADOCP);
                    $('#ESTADORUC').val(data.ESTADORUC);
                    $('#NESTADORUC').val(data.NESTADORUC);
                    $('#CONDDOMIRUC').val(data.CONDDOMIRUC);
                    $('#NCONDDOMIRUC').val(data.NCONDDOMIRUC);
                    $('#NOMBREFILE').val(data.NOMBREFILE);
                    $('#RUTACOMPLETA').val(data.RUTACOMPLETA);
                    $('#empresa_id').append(
                        $('<option>', {
                            value: data.TXT_EMPRESA,
                            text: data.TXT_EMPRESA
                        })
                    ).val(data.TXT_EMPRESA);
                    $('#empresa_id').val(data.TXT_EMPRESA).trigger('change');
                    $('#EMPRESAID').val(data.TXT_EMPRESA);
                    //archivos
                    $('.sectorxmlmodal').show();
                    $('.DCC0000000000036').hide();
                    $('.DCC0000000000004').hide();

                    let valor = data.SERIE;
                    let primeraLetraSerire = valor.charAt(0);   
                    if(primeraLetraSerire=='E'){
                        if (data.RUTAPDF){
                            $('.DCC0000000000036').hide();
                        }else{
                            $('.DCC0000000000036').show();
                        }
                    }else{

                       if (data.RUTAPDF){
                            $('.DCC0000000000036').hide();
                        }else{
                            $('.DCC0000000000036').show();
                        }
                       if (data.RUTACDR){
                            $('.DCC0000000000004').hide();
                        }else{
                            $('.DCC0000000000004').show();
                        }
                    }


                    //DETALLE DEL PRODUCTO

                    $('#tdxml tbody').empty(); // Limpia la tabla primero
                    data.DETALLE.forEach(function(item, index) {
                        const fila = `
                          <tr>
                            <td class="cell-detail d${index}" style="position: relative;" >
                              <span style="display: block;"><b>PRODUCTO OSIRIS : </b> <dlabel class='TXT_PRODUCTO_OSIRIS'></dlabel></span>
                              <span style="display: block;"><b>PRODUCTO XML : </b> <dlabel class='TXT_PRODUCTO_XML'>${item.PRODUCTO}</dlabel></span>
                              <span style="display: block;"><b>CANTIDAD : </b> <dlabel class='CANTIDAD'>${item.CANTIDAD}</dlabel></span>
                              <span style="display: block;"><b>PRECIO : </b> <dlabel class='PRECIO'>${item.PRECIO_UNIT}</dlabel></span>
                              <span style="display: block;"><b>IND IGV : </b> <dlabel class='INDIGV'>${item.VAL_IGV_ORIG}</dlabel></span>
                              <span style="display: block;"><b>SUBTOTAL : </b> <dlabel class='SUBTOTAL'>${item.VAL_SUBTOTAL_SOL}</dlabel></span>
                              <span style="display: block;"><b>IGV : </b> <dlabel class='IGV'>${item.VAL_IGV_SOL}</dlabel></span>
                              <span style="display: block;"><b>TOTAL : </b> <dlabel class='TOTAL'>${item.VAL_VENTA_SOL}</dlabel></span>
                              <button type="button" data_item="${index}" data_producto="${item.PRODUCTO}" style="margin-top: 5px; float: right;" class="btn btn-rounded btn-space btn-success btn-sm relacionardetalledocumentolg">RELACIONAR PRODUCTO</button>
                            </td>
                          </tr>
                        `;
                        $('#tdxml tbody').append(fila);
                    });


                }else{
                    alerterrorajax(data.mensaje);
                }
                console.log(data);
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });


    });



    $(".liquidaciongasto").on('click','.btn_tarea_cpe_lg', function() {

        var _token                                   =   $('#token').val();
        var ID_DOCUMENTO                             =   $('#ID_DOCUMENTO').val();
        var idopcion                                 =   $('#idopcion').val();
        var ruc                                      =   $('#ruc_sunat').val();
        var td                                       =   $('#td').val();
        var serie                                    =   $('#serie_sunat').val();
        var correlativo                              =   $('#correlativo_sunat').val();
        if(ruc ==''){ alerterrorajax("Ingrese un ruc."); return false;}
        if(td ==''){ alerterrorajax("Seleccione un tipo de documento."); return false;}
        if(serie ==''){ alerterrorajax("Ingrese un serie."); return false;}
        if(correlativo ==''){ alerterrorajax("Ingrese un correlativo."); return false;}

        data                                         =   {
                                                                _token                  : _token,
                                                                ID_DOCUMENTO            : ID_DOCUMENTO,
                                                                ruc                     : ruc,
                                                                td                      : td,
                                                                serie                   : serie,
                                                                correlativo             : correlativo,
                                                                idopcion                : idopcion
                                                         };                                       
        abrircargando();
        $('a[href="#tareas"]').click();
        ajax_normal(data,"/tareas-de-cpe-sunat-lg");

    });


    $(".liquidaciongasto").on('click','.btn_buscar_cpe_lg', function() {

        var _token                                   =   $('#token').val();
        var ID_DOCUMENTO                             =   $('#ID_DOCUMENTO').val();
        var idopcion                                 =   $('#idopcion').val();

        var ruc                                      =   $('#ruc_sunat').val();
        var td                                       =   $('#td').val();
        var serie                                    =   $('#serie_sunat').val();
        var correlativo                              =   $('#correlativo_sunat').val();
        const link                                   =   '/buscar-de-cpe-sunat-lg';


        if(ruc ==''){ alerterrorajax("Ingrese un ruc."); return false;}
        if(td ==''){ alerterrorajax("Seleccione un tipo de documento."); return false;}
        if(serie ==''){ alerterrorajax("Ingrese un serie."); return false;}
        if(correlativo ==''){ alerterrorajax("Ingrese un correlativo."); return false;}

        data                                         =   {
                                                                _token                  : _token,
                                                                ID_DOCUMENTO            : ID_DOCUMENTO,
                                                                ruc                     : ruc,
                                                                td                      : td,
                                                                serie                   : serie,
                                                                correlativo             : correlativo,
                                                                idopcion                : idopcion
                                                         };                                       
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+link,
            data    :   data,
            success: function (data) {
                cerrarcargando();
                debugger;
                $('#modal-detalle-requerimiento').niftyModal('hide');
                if (data.nombre_xml) {
                    $('.exml').html(data.nombre_xml);
                    $('#NOMBREXML').val(data.nombre_xml);
                    $('#RUTAXML').val(data.ruta_xml);
                }
                if (data.nombre_pdf) {
                    $('.epdf').html(data.nombre_pdf);
                    $('#NOMBREPDF').val(data.nombre_pdf);
                    $('#RUTAPDF').val(data.ruta_pdf);
                }
                if (data.nombre_cdr) {
                    $('.ecdr').html(data.nombre_cdr);
                    $('#NOMBRECDR').val(data.nombre_cdr);
                    $('#RUTACDR').val(data.ruta_cdr);
                }
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });

    });


    $(".liquidaciongasto").on('click','.btnsunat', function() {

        var _token                                   =   $('#token').val();
        var ID_DOCUMENTO                             =   $('#ID_DOCUMENTO').val();
        var idopcion                                 =   $('#idopcion').val();

        data                                         =   {
                                                                _token                  : _token,
                                                                ID_DOCUMENTO            : ID_DOCUMENTO,
                                                                idopcion                : idopcion
                                                         };
                                        
        ajax_modal(data,"/ajax-modal-buscar-factura-sunat",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });



    $(".liquidaciongasto").on('click','.mdisel', function(e) {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        const documento_planilla    =   $(this).attr('data_documento_planilla'); // Obtener el id del checkbox
        var data_iddocumento        =   $('#ID_DOCUMENTO').val();

        const link                  =   '/ajax-select-documento-planilla';
        debugger;
        data                        =   {
                                            _token                  : _token,
                                            documento_planilla      : documento_planilla,
                                            data_iddocumento        : data_iddocumento
                                        };
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+link,
            data    :   data,
            success: function (data) {
                cerrarcargando();
                $('#modal-detalle-requerimiento').niftyModal('hide');

                $('#serie').val(data.SERIE);
                $('#numero').val(data.NUMERO);
                $('#fecha_emision').val(data.FECHA_EMI);
                $('#totaldetalle').val(data.TOTAL);
                $('#empresa_id').append(
                    $('<option>', {
                        value: data.EMPRESA,
                        text: data.EMPRESA
                    })
                ).val(data.EMPRESA);
                $('#cuenta_id').append(
                    $('<option>', {
                        value: data.COD_CUENTA,
                        text: data.TXT_CUENTA
                    })
                ).val(data.COD_CUENTA);
                $('#subcuenta_id').append(
                    $('<option>', {
                        value: data.COD_SUBCUENTA,
                        text: data.TXT_SUBCUENTA
                    })
                ).val(data.COD_SUBCUENTA);

                $('#cod_planila').val(data.COD_PLANILLA);
                $('#rutacompleta').val(data.rutacompleta);
                $('#nombrearchivo').val(data.nombrearchivo);

            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });

    });



    $(".liquidaciongasto").on('click','.buscardocumento', function() {

        event.preventDefault();

        var fecha_inicio         =   $('#fecha_inicio').val();
        var fecha_fin            =   $('#fecha_fin').val();
        var proveedor_id         =   $('#proveedor_id').val();
        var estado_id            =   $('#estado_id').val();
        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        //validacioones
        if(fecha_inicio ==''){ alerterrorajax("Seleccione una fecha inicio."); return false;}
        if(fecha_fin ==''){ alerterrorajax("Seleccione una fecha fin."); return false;}

        data            =   {
                                _token                  : _token,
                                fecha_inicio            : fecha_inicio,
                                fecha_fin               : fecha_fin,
                                proveedor_id            : proveedor_id,
                                estado_id               : estado_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-lg");

    });



    $(".liquidaciongasto").on('click','.filalg', function(e) {
        event.preventDefault();
        $('.dtlg').hide();
        $('.file-preview-frame').hide();
        $('.filalg').removeClass("ocultar");
        const data_valor    =   $(this).attr('data_valor');
        $('.'+data_valor).show();
        $('.filalg').removeClass("activofl");
        $(this).addClass("activofl");

    });



    $('.btnobservarcomporbatnte').on('click', function(event){
        event.preventDefault();

        var array_item     =   dataobservacion();
        const filas = document.querySelectorAll('.tablaobservacion tbody tr');
        // El número de filas:
        const cantidad = filas.length;
        debugger;
        if(array_item.length<=0){alerterrorajax('Seleccione por lo menos una fila'); return false;}
        if(array_item.length==cantidad){alerterrorajax('No se puede observar todas las filas en ese caso deberia extornarlo'); return false;}
        datastring = JSON.stringify(array_item);
        $('#data_observacion').val(datastring);
        $.confirm({
            title: '¿Confirma la Observacion?',
            content: 'Observacion el Comprobante',
            buttons: {
                confirmar: function () {
                    $( "#formpedidoobservar" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la Observacion');
                }
            }
        });

    });

    function dataobservacion(){
        var data = [];
        $(".tablaobservacion tbody tr").each(function(){
            nombre               = $(this).find('.input_asignar').attr('id');
            if(nombre != 'todo_asignar'){
                check            = $(this).find('.input_asignar');
                data_id          = $(this).attr('data_id');
                data_item        = $(this).attr('data_item')
                if($(check).is(':checked')){
                    data.push({
                        data_id         : data_id,
                        data_item       : data_item
                    });
                }                 
            }
        });
        return data;
    }



    $('.btnaprobarcomporbatnte').on('click', function(event){
        event.preventDefault();
        $.confirm({
            title: '¿Confirma la Aprobacion?',
            content: 'Aprobar el Comprobante',
            buttons: {
                confirmar: function () {
                    $( "#formpedido" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo Aprobacion');
                }
            }
        });

    });


    $('.btnrechazocomporbatnte').on('click', function(event){
        event.preventDefault();
        $.confirm({
            title: '¿Confirma el extorno?',
            content: 'Extornar el Comprobante',
            buttons: {
                confirmar: function () {
                    $( "#formpedidorechazar" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo el Extorno');
                }
            }
        });

    });


    $(".liquidaciongasto").on('change','#arendir_id', function(e) {
        var arendir_id      =   $('#arendir_id').val();
        if(arendir_id == 'SI'){
            $('.sectorarendir').show();

        }else{
            $('.sectorarendir').hide();
        }
    });


    $(".liquidaciongasto").on('change','#tipodoc_id', function(e) {

        var tipodoc_id      =   $('#tipodoc_id').val();
        $('#serie, #numero, #fecha_emision, #totaldetalle,#cod_planila').val('');
        $('#empresa_id').empty();
        $('#cuenta_id').empty();
        $('#subcuenta_id').empty();

        $('.DCC0000000000036').hide();
        $('.DCC0000000000004').hide();

        if(tipodoc_id == 'TDO0000000000070'){
            $('#serie, #numero, #fecha_emision').prop('readonly', true);
            $('#empresa_id').prop('disabled', true);
            $('#cuenta_id').prop('disabled', true);
            $('#subcuenta_id').prop('disabled', true);
            $('.sectorplanilla').show();
            $('.sectorxml').hide();

            //$('.sectorxmlmodal').show();
            //$('.DCC0000000000036').show();

        }else{
                if(tipodoc_id == 'TDO0000000000001'){
                    $('#serie, #numero, #fecha_emision').prop('readonly', true);
                    $('#empresa_id').prop('disabled', true);
                    $('.sectorplanilla').hide();
                    $('.sectorxml').show();
                    $('.sectorxmlmodal').hide();
                    $('.DCC0000000000036').hide();
                }else{
                    $('#serie, #numero, #fecha_emision').prop('readonly', false);
                    $('#empresa_id').prop('disabled', false);
                    $('#cuenta_id').prop('disabled', false);
                    $('#subcuenta_id').prop('disabled', false);
                    $('.sectorplanilla').hide();
                    $('.sectorxml').hide();
                    $('.sectorxmlmodal').show();
                    $('.DCC0000000000036').show();
                }
        }

        $('#SUCCESS').val('');
        $('#MESSAGE').val('');
        $('#ESTADOCP').val('');
        $('#NESTADOCP').val('');
        $('#ESTADORUC').val('');
        $('#NESTADORUC').val('');
        $('#CONDDOMIRUC').val('');
        $('#NCONDDOMIRUC').val('');
        $('#NOMBREFILE').val('');

        $('.MESSAGE').html('');
        $('.NESTADOCP').html('');
        $('.NESTADORUC').html('');
        $('.NCONDDOMIRUC').html('');

    });


    $(".liquidaciongasto").on('click','.cargardatosliq', function(e) {
        e.preventDefault(); // Prevenir recarga del formulario
        const archivo = $('#inputxml')[0].files[0];
        var _token                  =   $('#token').val();
        var ID_DOCUMENTO            =   $('#ID_DOCUMENTO').val();

        if (!archivo) {
            alert('Por favor selecciona un archivo XML.');
            return;
        }
        let formData = new FormData();
        formData.append('inputxml', archivo);
        formData.append('_token', _token);
        formData.append('ID_DOCUMENTO', ID_DOCUMENTO);

        const link          =   '/ajax-leer-xml-lg';
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+link,
            data: formData,
            processData: false, // IMPORTANTE: no procesar los datos
            contentType: false, // IMPORTANTE: no establecer content-type (jQuery lo hace)
            success: function (data) {
                cerrarcargando();
                debugger;
                if(data.error == 0){

                    $('#RUTAXML').val("");
                    $('#RUTAPDF').val("");
                    $('#RUTACDR').val("");
                    $('.exml').html("");
                    $('.epdf').html("");
                    $('.ecdr').html("");
                    $('#NOMBREXML').val("");
                    $('#NOMBREPDF').val("");
                    $('#NOMBRECDR').val("");




                    $('#serie').val(data.SERIE);
                    $('#numero').val(data.NUMERO);
                    $('#fecha_emision').val(data.FEC_VENTA);
                    $('#totaldetalle').val(data.TOTAL_VENTA_ORIG);

                    $('.MESSAGE').html(data.MESSAGE);
                    $('.NESTADOCP').html(data.NESTADOCP);
                    $('.NESTADORUC').html(data.NESTADORUC);
                    $('.NCONDDOMIRUC').html(data.NCONDDOMIRUC);

                    $('#SUCCESS').val(data.SUCCESS);
                    $('#MESSAGE').val(data.MESSAGE);
                    $('#ESTADOCP').val(data.ESTADOCP);
                    $('#NESTADOCP').val(data.NESTADOCP);
                    $('#ESTADORUC').val(data.ESTADORUC);
                    $('#NESTADORUC').val(data.NESTADORUC);
                    $('#CONDDOMIRUC').val(data.CONDDOMIRUC);
                    $('#NCONDDOMIRUC').val(data.NCONDDOMIRUC);
                    $('#NOMBREFILE').val(data.NOMBREFILE);
                    $('#RUTACOMPLETA').val(data.RUTACOMPLETA);
                    $('#empresa_id').append(
                        $('<option>', {
                            value: data.TXT_EMPRESA,
                            text: data.TXT_EMPRESA
                        })
                    ).val(data.TXT_EMPRESA);
                    $('#empresa_id').val(data.TXT_EMPRESA).trigger('change');
                    $('#EMPRESAID').val(data.TXT_EMPRESA);
                    //archivos
                    $('.sectorxmlmodal').show();
                    $('.DCC0000000000036').hide();
                    $('.DCC0000000000004').hide();

                    let valor = data.SERIE;
                    let primeraLetraSerire = valor.charAt(0);   
                    if(primeraLetraSerire=='E'){
                        $('.DCC0000000000036').show();
                    }else{
                        $('.DCC0000000000036').show();
                        $('.DCC0000000000004').show();
                    }


                    //DETALLE DEL PRODUCTO

                    $('#tdxml tbody').empty(); // Limpia la tabla primero
                    data.DETALLE.forEach(function(item, index) {
                        const fila = `
                          <tr>
                            <td class="cell-detail d${index}" style="position: relative;" >
                              <span style="display: block;"><b>PRODUCTO OSIRIS : </b> <dlabel class='TXT_PRODUCTO_OSIRIS'></dlabel></span>
                              <span style="display: block;"><b>PRODUCTO XML : </b> <dlabel class='TXT_PRODUCTO_XML'>${item.PRODUCTO}</dlabel></span>
                              <span style="display: block;"><b>CANTIDAD : </b> <dlabel class='CANTIDAD'>${item.CANTIDAD}</dlabel></span>
                              <span style="display: block;"><b>PRECIO : </b> <dlabel class='PRECIO'>${item.PRECIO_UNIT}</dlabel></span>
                              <span style="display: block;"><b>IND IGV : </b> <dlabel class='INDIGV'>${item.VAL_IGV_ORIG}</dlabel></span>
                              <span style="display: block;"><b>SUBTOTAL : </b> <dlabel class='SUBTOTAL'>${item.VAL_SUBTOTAL_SOL}</dlabel></span>
                              <span style="display: block;"><b>IGV : </b> <dlabel class='IGV'>${item.VAL_IGV_SOL}</dlabel></span>
                              <span style="display: block;"><b>TOTAL : </b> <dlabel class='TOTAL'>${item.VAL_VENTA_SOL}</dlabel></span>
                              <button type="button" data_item="${index}" data_producto="${item.PRODUCTO}" style="margin-top: 5px; float: right;" class="btn btn-rounded btn-space btn-success btn-sm relacionardetalledocumentolg">RELACIONAR PRODUCTO</button>
                            </td>
                          </tr>
                        `;
                        $('#tdxml tbody').append(fila);
                    });


                }else{
                    alerterrorajax(data.mensaje);
                }
                console.log(data);
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });


    });
    $(".liquidaciongasto").on('click','.btn-relacionar-producto-lg', function(e) {
        event.preventDefault();
        debugger;
        var producto_id             =   $('#producto_id').val();
        var data_item        =   $(this).attr('data_item');
        $('.d'+data_item).find('.TXT_PRODUCTO_OSIRIS').html(producto_id);
        $('#modal-detalle-requerimiento').niftyModal('hide');

    });

    $(".liquidaciongasto").on('click','.btnemitirliquidaciongasto', function(e) {
        event.preventDefault();
        var _token                  =   $('#token').val();

        $.confirm({
            title: '¿Confirma la emision?',
            content: 'Registro de emision de movilidad',
            buttons: {
                confirmar: function () {
                     $( "#frmpmemitir" ).submit();   
                },
                cancelar: function () {
                    $.alert('Se cancelo la emision');
                    window.location.reload();
                }
            }
        });

    });


    $(".liquidaciongasto").on('click','.btn-guardar-detalle-factura', function(e) {
        event.preventDefault();
        var _token                  =   $('#token').val();
        var tipodoc_id              =   $('#tipodoc_id').val();

        var RUTAXML                 =   $('#RUTAXML').val();
        var RUTAPDF                 =   $('#RUTAPDF').val();
        var RUTACDR                 =   $('#RUTACDR').val();


        var array_detalle_producto  =   $('#array_detalle_producto').val();
        abrircargando();
                

        if(tipodoc_id == 'TDO0000000000001'){
            //ver si tienes filas
            if ($('#tdxml tbody tr').length === 0) {
                alerterrorajax("La factura no tiene detalle"); cerrarcargando(); return false;
            }
            //recorrer la tabla y ver si no tiene aprobados
            var sw_asociado = 0;
            $('#tdxml tbody tr').each(function(index) {
                const productoOsiris = $(this).find('.TXT_PRODUCTO_OSIRIS').text();
                if(productoOsiris==''){
                    sw_asociado = 1;
                }

            });

            if(sw_asociado ==1){ alerterrorajax("Hay productos que no estan asociados"); cerrarcargando(); return false;}
            var valor              =   $('#serie').val();
            let primeraLetraSerire = valor.charAt(0); 
            if(primeraLetraSerire=='E'){
                let comprobante = $('#file-DCC0000000000036')[0].files.length > 0;

                if(RUTAXML==''){
                    if (!comprobante) {
                        alerterrorajax("Debe subir el comprobante electronico."); cerrarcargando(); return false;
                    }
                }else{
                    if(RUTAPDF==''){
                        if (!comprobante) {
                            alerterrorajax("Debe subir el comprobante electronico."); cerrarcargando(); return false;
                        }
                    }
                }


            }else{
                let xml = $('#file-DCC0000000000004')[0].files.length > 0;
                if(RUTAXML==''){
                    if (!xml) {
                        alerterrorajax("Debe subir el CDR en XML."); cerrarcargando(); return false;
                    }
                }else{
                    if(RUTACDR==''){
                        if (!comprobante) {
                            alerterrorajax("Debe subir el comprobante electronico."); cerrarcargando(); return false;
                        }
                    }
                }


                let comprobante = $('#file-DCC0000000000036')[0].files.length > 0;
                if(RUTAXML==''){
                    if (!comprobante) {
                        alerterrorajax("Debe subir el comprobante electronico."); cerrarcargando(); return false;
                    }
                }else{
                    if(RUTAPDF==''){
                        if (!comprobante) {
                            alerterrorajax("Debe subir el comprobante electronico."); cerrarcargando(); return false;
                        }
                    }
                }

            }
            let detalleArray = [];
            $('#tdxml tbody tr').each(function(index) {
                const fila = {
                    TXT_PRODUCTO_OSIRIS: $(this).find('.TXT_PRODUCTO_OSIRIS').text().trim(),
                    TXT_PRODUCTO_XML   : $(this).find('.TXT_PRODUCTO_XML').text().trim(),
                    CANTIDAD           : $(this).find('.CANTIDAD').text().trim(),
                    PRECIO             : $(this).find('.PRECIO').text().trim(),
                    INDIGV             : $(this).find('.INDIGV').text().trim(),
                    SUBTOTAL           : $(this).find('.SUBTOTAL').text().trim(),
                    IGV                : $(this).find('.IGV').text().trim(),
                    TOTAL              : $(this).find('.TOTAL').text().trim()
                };
                detalleArray.push(fila);
            });
            // Guardamos el array convertido a JSON en el input hidden
            $('#array_detalle_producto').val(JSON.stringify(detalleArray));
        }else{

            if(tipodoc_id != 'TDO0000000000070'){
                let comprobante = $('#file-DCC0000000000036')[0].files.length > 0;
                if (!comprobante) {
                    alerterrorajax("Debe subir el comprobante electronico."); cerrarcargando(); return false;
                }
            }
            
        }
        $( "#frmdetallelg" ).submit();

    });



    $(".liquidaciongasto").on('click','.btn-guardar-detalle-documento-lg', function(e) {
        event.preventDefault();
        var _token                  =   $('#token').val();
        var producto_id             =   $('#producto_id').val();
        var importe                 =   $('#importe').val();
        var igv_id                  =   $('#igv_id').val();

        if(producto_id ==''){ alerterrorajax("Seleccione una Producto."); return false;}
        if(importe ==''){ alerterrorajax("Ingrese un importe"); return false;}
        if(igv_id ==''){ alerterrorajax("Seleccione un igv."); return false;}

        $( "#agregarpmd" ).submit();
    });


    $(".liquidaciongasto").on('click','.btn-buscar-planilla', function() {
        // debugger;
        var _token                                   =   $('#token').val();
        var data_iddocumento                         =   $(this).attr('data_iddocumento');
        var idopcion                                 =   $('#idopcion').val();

        data                                         =   {
                                                                _token                  : _token,
                                                                data_iddocumento        : data_iddocumento,
                                                                idopcion                : idopcion
                                                         };
                                        
        ajax_modal(data,"/ajax-modal-buscar-planilla-lg",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });



    $(".liquidaciongasto").on('click','.modificardetalledocumentolg', function() {
        // debugger;
        var _token                                   =   $('#token').val();
        var data_iddocumento                         =   $(this).attr('data_iddocumento');
        var data_item                                =   $(this).attr('data_item');
        var data_item_documento                      =   $(this).attr('data_item_documento');
        var idopcion                                 =   $('#idopcion').val();

        data                        =   {
                                            _token                  : _token,
                                            data_iddocumento        : data_iddocumento,
                                            data_item               : data_item,
                                            data_item_documento     : data_item_documento,
                                            idopcion                : idopcion
                                        };
                                        
        ajax_modal(data,"/ajax-modal-modificar-detalle-documento-lg",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });


    $(".liquidaciongasto").on('click','.relacionardetalledocumentolg', function() {
        // debugger;
        var _token                                   =   $('#token').val();
        var data_item                                =   $(this).attr('data_item');
        var data_producto                            =   $(this).attr('data_producto');
        var idopcion                                 =   $('#idopcion').val();

        data                        =   {
                                            _token                  : _token,
                                            data_item               : data_item,
                                            data_producto           : data_producto,
                                            idopcion                : idopcion
                                        };
                                        
        ajax_modal(data,"/ajax-modal-relacionar-detalle-documento-lg",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });



    $(".liquidaciongasto").on('click','#btnempresacuenta', function() {

        event.preventDefault();
        var empresa_id              =   $('#empresa_id').val();
        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();
        var link                    =   "/ajax-combo-cuenta";
        var contenedor              =   "ajax_combo_cuenta";
        data                        =   {
                                            _token                  : _token,
                                            empresa_id              : empresa_id,
                                            idopcion                : idopcion
                                        };
        ajax_normal_combo(data,link,contenedor);
    });


    $(".liquidaciongasto").on('click','.btnguardarliquidaciongasto', function(e) {
        event.preventDefault();
        var _token                  =   $('#token').val();
        $.confirm({
            title: '¿Confirma el registro?',
            content: 'Registro de Liquidacion de Gastos',
            buttons: {
                confirmar: function () {
                     $( "#frmpm" ).submit();   
                },
                cancelar: function () {
                    $.alert('Se cancelo el registro');
                    window.location.reload();
                }
            }
        });

    });


    $(".liquidaciongasto").on('click','.agregardetalle', function(e) {
        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        const tabId                 =   '#registro';
        $('.nav-tabs a[href="' + tabId + '"]').tab('show');

    });


    $(".liquidaciongasto").on('change','#empresa_id', function() {
        var empresa_id = $('#empresa_id').val();
        var _token      = $('#token').val();
        debugger;

        var link                    =   "/ajax-combo-cuenta";
        var contenedor              =   "ajax_combo_cuenta";
        data                        =   {
                                            _token                  : _token,
                                            empresa_id              : empresa_id
                                        };
        ajax_normal_combo(data,link,contenedor);

    });


    $(".liquidaciongasto").on('change','#cuenta_id', function() {
        var cuenta_id = $('#cuenta_id').val();
        var _token      = $('#token').val();
        debugger;
        var link                    =   "/ajax-combo-subcuenta";
        var contenedor              =   "ajax_combo_subcuenta";
        data                        =   {
                                            _token                  : _token,
                                            cuenta_id              : cuenta_id
                                        };
        ajax_normal_combo(data,link,contenedor);

    });
    $(".liquidaciongasto").on('change','#flujo_id', function() {
        var flujo_id = $('#flujo_id').val();
        var _token      = $('#token').val();
        debugger;
        var link                    =   "/ajax-combo-item";
        var contenedor              =   "ajax_combo_item";
        data                        =   {
                                            _token                  : _token,
                                            flujo_id                : flujo_id
                                        };
        ajax_normal_combo(data,link,contenedor);

    });




    $(".liquidaciongasto").on('click','.btn-agregar-detalle-factura', function() {
        // debugger;
        var _token                                   =   $('#token').val();
        var data_iddocumento                         =   $(this).attr('data_iddocumento');
        var data_item                                =   $(this).attr('data_item');
        var idopcion                                 =   $('#idopcion').val();

        data                                         =   {
                                                                _token                  : _token,
                                                                data_iddocumento        : data_iddocumento,
                                                                data_item               : data_item,
                                                                idopcion                : idopcion
                                                         };
                                        
        ajax_modal(data,"/ajax-modal-detalle-documento-lg",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });





});




