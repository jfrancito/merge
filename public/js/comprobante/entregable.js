$(document).ready(function(){

    var carpeta = $("#carpeta").val();


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




