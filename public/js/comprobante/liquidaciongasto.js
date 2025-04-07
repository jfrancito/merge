
$(document).ready(function(){
    var carpeta = $("#carpeta").val();

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


    $(".liquidaciongasto").on('click','.mdisel', function(e) {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        const documento_planilla    =   $(this).attr('data_documento_planilla'); // Obtener el id del checkbox
        const link                  =   '/ajax-select-documento-planilla';

        data                        =   {
                                            _token                  : _token,
                                            documento_planilla      : documento_planilla
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



            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });

    });


    $(".liquidaciongasto").on('change','#tipodoc_id', function(e) {
        debugger;
        var tipodoc_id      =   $('#tipodoc_id').val();

        $('#serie, #numero, #fecha_emision, #totaldetalle,#cod_planila').val('');
        $('#empresa_id').empty();
        $('#cuenta_id').empty();
        $('#subcuenta_id').empty();

        if(tipodoc_id == 'TDO0000000000070'){
            $('#serie, #numero, #fecha_emision').prop('readonly', true);
            $('#empresa_id').prop('disabled', true);
            $('#cuenta_id').prop('disabled', true);
            $('#subcuenta_id').prop('disabled', true);
            $('.sectorplanilla').show();


            //$('.pickerfechadet').datetimepicker('remove'); // Deshabilitar el datetimepicker


        }else{
            $('#serie, #numero, #fecha_emision').prop('readonly', false);
            $('#empresa_id').prop('disabled', false);
            $('#cuenta_id').prop('disabled', false);
            $('#subcuenta_id').prop('disabled', false);
            $('.sectorplanilla').hide();
            //$('.pickerfechadet').datetimepicker();
        }
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




