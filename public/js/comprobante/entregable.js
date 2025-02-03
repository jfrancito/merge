$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    $(".cfedocumento").on('click','.mdisel', function(e) {
        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        const data_folio            =   $(this).attr('data_folio'); // Obtener el id del checkbox
        const link                  =   '/ajax-select-folio-pagos'
        data                        =   {
                                            _token                  : _token,
                                            data_folio              : data_folio
                                        };
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+link,
            data    :   data,
            success: function (data) {
                location.reload();
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });

    });

    $(".cfedocumento").on('click','.mdiex', function(e) {
        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        const data_folio            =   $(this).attr('data_folio'); // Obtener el id del checkbox
        data                        =   {
                                            _token                  : _token,
                                            data_folio              : data_folio
                                        };
        $.confirm({
            title: '¿Confirma el extorno?',
            content: '¿Confirma el extorno',
            buttons: {
                confirmar: function () {
                    alertajax("Se realizo el extorno correctamente");
                    ajax_extornar(data,"/ajax-extornar-folio-pagos");
                },
                cancelar: function () {
                    $.alert('Se cancelo el extorno');
                }
            }
        });
    });

    $(".cfedocumento").on('click','.mdidet', function(e) {
        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        const data_folio            =   $(this).attr('data_folio');
        const tabId                 =   '#detallefolios';
        data                        =   {
                                            _token                  : _token,
                                            data_folio              : data_folio
                                        };
        const link                  =   '/ajax-detalle-folio-pagos'
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+link,
            data    :   data,
            success: function (data) {
                cerrarcargando();
                $(".detalle_folio").html(data);
                $('.nav-tabs a[href="' + tabId + '"]').tab('show');
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });


    });

    $(".cfedocumento").on('click','.mdisave', function(e) {
        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        const data_folio            =   $(this).attr('data_folio');
        const data_glosa            =   $(this).attr('data_glosa');
        const data_cantidad         =   $(this).attr('data_cantidad');
        const data_banco            =   $(this).attr('data_banco');
        const tabId                 =   '#guardarfolio';
        $('#folio').val(data_folio);
        $('#glosa_g').val(data_glosa);
        $('#banco').val(data_banco);
        $('#cantidad').val(data_cantidad);
        $('.nav-tabs a[href="' + tabId + '"]').tab('show');
        

        // data                        =   {
        //                                     _token                  : _token,
        //                                     data_folio              : data_folio
        //                                 };

        // const link                  =   '/validar-retencion-folio-pagos'
        // abrircargando();
        // $.ajax({
        //     type    :   "POST",
        //     url     :   carpeta+link,
        //     data    :   data,
        //     success: function (data) {
        //         cerrarcargando();
        //         $(".detalle_folio").html(data);
        //         $('#folio').val(data_folio);
        //         $('#glosa_g').val(data_glosa);
        //         $('.nav-tabs a[href="' + tabId + '"]').tab('show');
        //     },
        //     error: function (data) {
        //         cerrarcargando();
        //         error500(data);
        //     }
        // });

    });




    function ajax_extornar(data,link) {

        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+link,
            data    :   data,
            success: function (data) {
                location.reload();
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });
    }



    $(".cfedocumento").on('click','.loteentregable', function(e) {
        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        data                        =   {
                                            _token                  : _token,
                                            idopcion                : idopcion
                                        };
        ajax_modal(data,"/ajax-modal-detalle-folios",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });


    $(".cfedocumento").on('click','.selectfolio', function(e) {
        var _token      =   $('#token').val();
        const isChecked = $(this).is(':checked'); // Verificar si está marcado
        const id        = $(this).attr('id'); // Obtener el id del checkbox
        var folio_sel   =   $('#folio_sel').val();
        var check       = 0;
        if (isChecked) {
            check       = 1;
        }
        const folios_hit = $(".folios_hit").html(); // Verificar si está marcado
        //validar folios_hit
        if(folio_sel ==''){ alerterrorajax("Seleccione un folio"); return false;}
        const link      = '/ajax-crear-folio-pagos';
        var thischeck   =  $(this);
        data                        =   {
                                            _token                  : _token,
                                            check                   : check,
                                            folio_sel               : folio_sel,
                                            id                      : id,
                                        };
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+link,
            data    :   data,
            success: function (response) {
                cerrarcargando();

                if(response.ope_ind=='0'){
                    $('.folios_hit').html(response.lote_ver);
                    alertajax(response.mensaje);
                }else{//hay error
                    thischeck.prop('checked', false);
                    alerterrorajax(response.mensaje);
                }
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });

    });



    $(".cfedocumento").on('dblclick','.dobleclickpc', function(e) {

        var _token                  =   $('#token').val();
        var data_requerimiento_id   =   $(this).attr('data_requerimiento_id');
        var idopcion                =   $('#idopcion').val();

        data                        =   {
                                            _token                  : _token,
                                            data_requerimiento_id   : data_requerimiento_id,
                                            idopcion                : idopcion,
                                        };

        ajax_modal(data,"/ajax-modal-detalle-entregable",
                  "modal-detalle-entregable","modal-detalle-entregable-container");

    });


    $(".cfedocumento").on('click','#descargarcomprobantemasivoexcel', function() {


        var operacion_id         =   $('#operacion_id').val();
        var idopcion             =   $('#idopcion').val();
        var _token               =   $('#token').val();

        debugger;

        href = $(this).attr('data-href')+'/'+operacion_id+'/'+idopcion;
        $(this).prop('href', href);
        return true;


    });


    $(".cfedocumento").on('dblclick','.btn_detalle_deuda', function(e) {

        var _token                  =   $('#token').val();
        var data_id_doc             =   $(this).attr('data_id_doc');
        var idopcion                =   $('#idopcion').val();

        data                        =   {
                                            _token                  : _token,
                                            data_id_doc             : data_id_doc,
                                            idopcion                : idopcion,
                                        };

        ajax_modal(data,"/ajax-modal-detalle-deuda-contrato",
                  "modal-detalle-entregable","modal-detalle-entregable-container");

    });



    $(".cfedocumento").on('click','.buscardocumentofolio', function() {

        event.preventDefault();

        var operacion_id         =   $('#operacion_id').val();
        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();


        data            =   {
                                _token                  : _token,
                                operacion_id               : operacion_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-fe-entregable-folio");

    });



    $(".cfedocumento").on('click','.buscardocumento', function() {

        event.preventDefault();

        var fecha_inicio         =   $('#fecha_inicio').val();
        var fecha_fin            =   $('#fecha_fin').val();

        var area_id              =   $('#area_id').val();
        var empresa_id           =   $('#empresa_id').val();
        var centro_id            =   $('#centro_id').val();
        var operacion_id         =   $('#operacion_id').val();
        var banco_id         =   $('#banco_id').val();

        
        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        //validacioones
        if(fecha_inicio ==''){ alerterrorajax("Seleccione una fecha inicio."); return false;}
        if(fecha_fin ==''){ alerterrorajax("Seleccione una fecha fin."); return false;}

        data            =   {
                                _token                  : _token,
                                fecha_inicio            : fecha_inicio,
                                fecha_fin               : fecha_fin,
                                empresa_id              : empresa_id,
                                area_id                 : area_id,
                                banco_id                 : banco_id,
                                centro_id               : centro_id,
                                operacion_id               : operacion_id,

                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-fe-entregable");

    });


    $(".cfedocumento").on('click','.asignarmasivo', function() {

        event.preventDefault();
        $('input[type=search]').val('').change();
        $("#nso_check").DataTable().search("").draw();
        var glosa   =   $('#glosa').val();
        if(glosa ==''){ alerterrorajax("Ingrese una glosa."); return false;}

        data = dataenviar();
        if(data.length<=0){alerterrorajax('Seleccione por lo menos una fila'); return false;}

        var datastring = JSON.stringify(data);
        var idopcion   =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        var fecha_inicio         =   $('#fecha_inicio').val();
        var fecha_fin            =   $('#fecha_fin').val();
        var area_id              =   $('#area_id').val();
        var empresa_id           =   $('#empresa_id').val();
        var centro_id            =   $('#centro_id').val();
        var operacion_id         =   $('#operacion_id').val();

        

        data            =   {
                                _token                  : _token,
                                datastring              : datastring,

                                fecha_inicio            : fecha_inicio,
                                fecha_fin               : fecha_fin,
                                area_id                 : area_id,
                                empresa_id              : empresa_id,
                                centro_id               : centro_id,
                                operacion_id            : operacion_id,
                                glosa                   : glosa,

                                idopcion                : idopcion
                            };

        //console.log(data);


        $.confirm({
            title: '¿Confirma la Aprobacion?',
            content: '¿Confirma los Comprobantes',
            buttons: {
                confirmar: function () {
                    ajax_normal(data,"/ajax-guardar-masivo-entregable");
                },
                cancelar: function () {
                    $.alert('Se cancelo Aprobacion');
                }
            }
        });


    });




    function dataenviar(){
        var data = [];
        $(".listatabla tr").each(function(){

            nombre          = $(this).find('.input_asignar').attr('id');
            if(nombre != 'todo_asignar'){

                check                       = $(this).find('.input_asignar');
                data_requerimiento_id       = $(this).attr('data_requerimiento_id');
                if($(check).is(':checked')){
                    data.push({
                        data_requerimiento_id  : data_requerimiento_id,
                    });
                }

            }
        });
        return data;
    }



});




