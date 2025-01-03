$(document).ready(function(){
    var carpeta = $("#carpeta").val();

    $(".agestioncomprobante").on('click','.btn_rb', function() {
       abrircargando();
    });

    $(".agestioncomprobante").on('click','.migrarestibaadmin', function() {
        event.preventDefault();
        $('input[type=search]').val('').change();
        $("#nso").DataTable().search("").draw();
        data = dataenviar();
        if(data.length<=0){alerterrorajax('Seleccione por lo menos una fila'); return false;}
        var datastring = JSON.stringify(data);

        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();
        $('#jsondocumenos').val(datastring);
        $('#formre').submit();

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


    $(".agestioncomprobante").on('click','.input_check_pe_ln', function() {
        producto_id  = $(this).attr('data_producto');
        check = $(this).is(':checked');
        debugger;

        $.confirm({
            title: '¿Confirma la Aprobacion?',
            content: 'Filtro los Comprobantes',
            buttons: {
                confirmar: function () {
                    if(check){
                        ajax_ind_mobil(1,producto_id);
                    }else{
                        ajax_ind_mobil(0,producto_id);
                    } 


                },
                cancelar: function () {
                    $.alert('Se cancelo Filtro');
                    window.location.reload();
                }
            }
        });




    });

    $(".cfedocumento").on('click','#descargarcomprobantemasivoexcel', function() {

        var fecha_inicio         =   $('#fecha_inicio').val();
        var fecha_fin            =   $('#fecha_fin').val();
        var proveedor_id         =   $('#proveedor_id').val();
        var estado_id            =   $('#estado_id').val();
        var operacion_id         =   $('#operacion_id').val();
        var idopcion             =   $('#idopcion').val();
        var _token               =   $('#token').val();

        debugger;

        //validacioones
        if(fecha_inicio ==''){ alerterrorajax("Seleccione una fecha inicio."); return false;}
        if(fecha_fin ==''){ alerterrorajax("Seleccione una fecha fin."); return false;}

        href = $(this).attr('data-href')+'/'+fecha_inicio+'/'+fecha_fin+'/'+proveedor_id+'/'+estado_id+'/'+operacion_id+'/'+idopcion;
        $(this).prop('href', href);
        return true;


    });





    function ajax_ind_mobil(ind_mobil,producto_id){

        var _token      = $('#token').val();
        debugger;

        data            =   {
                                _token                  : _token,
                                ind_mobil               : ind_mobil,
                                producto_id             : producto_id
                            };

        ajax_normal(data,"/ajax-filtro-guardar");
        alertajax("Filtro asignado exitosa");

    }

    $(".cfedocumento").on('click','.buscardocumentohistorial', function() {

        event.preventDefault();

        var operacion_id         =   $('#operacion_id').val();

        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();


        data            =   {
                                _token                  : _token,
                                operacion_id               : operacion_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-fe-historial");

    });



    $(".cfedocumento").on('click','.buscardocumento', function() {

        event.preventDefault();

        var fecha_inicio         =   $('#fecha_inicio').val();
        var fecha_fin            =   $('#fecha_fin').val();
        var proveedor_id         =   $('#proveedor_id').val();
        var estado_id            =   $('#estado_id').val();
        var operacion_id         =   $('#operacion_id').val();
        var filtrofecha_id       =   $('#filtrofecha_id').val();


        debugger;

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
                                operacion_id            : operacion_id,
                                filtrofecha_id          : filtrofecha_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-fe");

    });


    $(".agestioncomprobante").on('click','.buscardocumentoadmin', function() {

        event.preventDefault();

        var operacion_id            =   $('#operacion_id').val();
        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        data            =   {
                                _token                  : _token,
                                operacion_id            : operacion_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-gestion-admin");

    });



    $(".agestioncomprobante").on('click','.buscardocumentoobservados', function() {

        event.preventDefault();

        var operacion_id            =   $('#operacion_id').val();
        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        data            =   {
                                _token                  : _token,
                                operacion_id            : operacion_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-gestion-observados");

    });
    $(".agestioncomprobante").on('click','.buscardocumentoreparable', function() {

        event.preventDefault();

        var operacion_id            =   $('#operacion_id').val();
        var tipoarchivo_id          =   $('#tipoarchivo_id').val();
        var estado_id               =   $('#estado_id').val();

        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        data            =   {
                                _token                  : _token,
                                operacion_id            : operacion_id,
                                tipoarchivo_id          : tipoarchivo_id,
                                estado_id               : estado_id,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-gestion-reparable");

    });



});




