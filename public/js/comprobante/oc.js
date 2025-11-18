$(document).ready(function(){
    var carpeta = $("#carpeta").val();

    $(".agestioncomprobante").on('change','.input_asignar', function() {
        var operacion_sel           =   $('#operacion_sel').val();

        if (operacion_sel === 'DOCUMENTO_INTERNO_COMPRA') {

            // Permitir solo uno seleccionado
            if ($(this).is(":checked")) {
                $(".input_asignar").not(this).prop("checked", false);
            }
        }
        
        suma_totales_cantidad();
    });


    $(".cfedocumento").on('click','.ver_cuenta_bancaria_indi', function() {

        var _token                  =   $('#token').val();
        const orden_id              =   $(this).attr('data_orden_id');
        const data_banco_codigo     =   $(this).attr('data_banco_codigo');
        const data_numero_cuenta    =   $(this).attr('data_numero_cuenta');
        var idopcion                =   $('#idopcion').val();

        data                        =   {
                                            _token                  : _token,
                                            orden_id                : orden_id,
                                            data_banco_codigo       : data_banco_codigo,
                                            data_numero_cuenta      : data_numero_cuenta,
                                            idopcion                : idopcion,
                                        };
                                        
        ajax_modal(data,"/ajax-modal-ver-cuenta-bancaria-oc-individual",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");



    });


    $(".agestioncomprobante").on('change','.selectoperacion', function() {


        var _token              =   $('#token').val();
        var operacion_id        =   $(this).val();
        var valores = array_canjes();
        debugger;
        if(valores.includes(operacion_id)){
            $('.sec_estiba').removeClass('ocultar');
        }else{
            $('.sec_estiba').addClass('ocultar');
        }
        $.ajax({
              type    :     "POST",
              url     :     carpeta+"/ajax-estiba-proveedor-estiba",
              data    :     {
                                _token              : _token,
                                operacion_id        : operacion_id
                            },
                success: function (data) {
                    $('.ajax_proveedor').html(data);
                },
                error: function (data) {
                    error500(data);
                }
        });



    });

    $(".agestioncomprobante").on('click','.verlote', function(e) {

        $('input[type=search]').val("").change();
        $("#nso").DataTable().search("").draw();
        var _token                  =   $('#token').val();
        var data_lote               =   $(this).attr('data_lote');
        quitarcheck(data_lote);
        agregarcheck(data_lote);
        $('#modal-detalle-requerimiento').niftyModal('hide');

        $('input[type=search]').val(data_lote).change();
        $("#nso").DataTable().search(data_lote).draw();

    });

    $(".agestioncomprobante").on('click','.eliminarlote', function(e) {

        var _token                  =   $('#token').val();
        var data_lote               =   $(this).attr('data_lote');

        $.confirm({
            title: '¿Confirma la Eliminacion?',
            content: 'Elimnar los Comprobantes',
            buttons: {
                confirmar: function () {
                    ajax_eliminar_lote_estiba(data_lote);
                    $('#modal-detalle-requerimiento').niftyModal('hide');
                },
                cancelar: function () {
                    $.alert('Se cancelo Eliminacion');
                    window.location.reload();
                }
            }
        });

    });


    function agregarcheck(lote){
        var data = [];
        $(".listatabla tr").each(function(){
            nombre          = $(this).find('.input_asignar').attr('id');
            if(nombre != 'todo_asignar'){
                check                       = $(this).find('.input_asignar');
                data_requerimiento_id       = $(this).attr('data_requerimiento_id');
                data_lote                   = $(this).attr('data_lote');
                if(data_lote == lote){
                    check.prop('checked', !check.prop('checked'));
                }
            }
        });
        return data;
    }

   function quitarcheck(lote){
        var data = [];
        $(".listatabla tr").each(function(){
            nombre          = $(this).find('.input_asignar').attr('id');
            if(nombre != 'todo_asignar'){
                check   = $(this).find('.input_asignar');
                check.prop('checked', false);
            }
        });
        return data;
    }



    $(".agestioncomprobante").on('click','.btn-guardar-configuracion_re', function() {
       abrircargando();
    });


    $(".agestioncomprobante").on('click','.btn_rb', function() {
       abrircargando();
    });

    $(".agestioncomprobante").on('click','.lotesestibas', function(e) {


        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        var operacion_sel           =   $('#operacion_sel').val();



        data                        =   {
                                            _token                  : _token,
                                            idopcion                : idopcion,
                                            operacion_sel           : operacion_sel,
                                        };

        ajax_modal(data,"/ajax-modal-detalle-lotes",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });


    $(".agestioncomprobante").on('click','.detalleestibs', function() {
        event.preventDefault();
        $('input[type=search]').val('').change();
        $("#nso").DataTable().search("").draw();
        data = dataenviar();
        if(data.length<=0){alerterrorajax('Seleccione por lo menos una fila'); return false;}
        var datastring = JSON.stringify(data);

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        data                        =   {
                                            _token                  : _token,
                                            idopcion                : idopcion,
                                            datastring                : datastring,
                                        };
        ajax_modal(data,"/ajax-modal-detalle-estibas",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");
    });


    $(".agestioncomprobante").on('click','.migrarestibaadmin', function() {
        event.preventDefault();
        $('input[type=search]').val('').change();
        $("#nso").DataTable().search("").draw();
        data = dataenviar();

        if(data.length<=0){alerterrorajax('Seleccione por lo menos una fila'); return false;}

        if($('#operacion_sel').val() === 'DOCUMENTO_INTERNO_COMPRA'){
            if(data[0].data_mergetotal>data[0].data_totalmax){alerterrorajax('TOTAL MERGE debe ser menor o igual q el TOTAL: '+data[0].data_totalmax); return false;}    
        }

        var datastring = JSON.stringify(data);

        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();
        $('#jsondocumenos').val(datastring);
        $('#formre').submit();

    });

    function dataenviar(){
        var data = [];
        var operacion = $('#operacion_sel').val(); // obtenemos el tipo de operación

        $(".listatabla tr").each(function(){
            nombre          = $(this).find('.input_asignar').attr('id');
            if(nombre != 'todo_asignar'){
                check                       = $(this).find('.input_asignar');
                data_requerimiento_id       = $(this).attr('data_requerimiento_id');
                data_lote                   = $(this).attr('data_lote');                
                // if($(check).is(':checked')){
                //     data.push({
                //         data_requerimiento_id  : data_requerimiento_id,
                //     });
                // }
                if($(check).is(':checked')){
                    // objeto base
                    var item = { data_requerimiento_id: data_requerimiento_id };

                    // Solo para DOCUMENTO_INTERNO_COMPRA agregamos input_mergetotal
                    if(operacion === 'DOCUMENTO_INTERNO_COMPRA'){
                        var total                       = parseFloat($(this).attr('data_total'));
                        var totalmerge                  = parseFloat($(this).attr('data_mergetotal'));
                        var totalmax                    = total-totalmerge;

                        var input_mergetotal = parseFloat($(this).find('.input_mergetotal').val()) || 0;                        

                        item.data_totalmax = totalmax;
                        item.data_mergetotal = input_mergetotal;
                        item.data_lote = data_lote;
                    }

                    data.push(item);
                }

            }
        });
        debugger;
        return data;
    }

    function suma_totales_cantidad(){

        var data_total = 0;
        var can_total = 0;
        $(".listatabla tr").each(function(){
            nombre          = $(this).find('.input_asignar').attr('id');
            if(nombre != 'todo_asignar'){
                check                       = $(this).find('.input_asignar');
                total                       = parseFloat($(this).attr('data_total'));
                if($(check).is(':checked')){

                    if($('#operacion_sel').val() === 'DOCUMENTO_INTERNO_COMPRA'){
                        var input_mergetotal                       = parseFloat($(this).find('.input_mergetotal').val()) || 0;
                        data_total = input_mergetotal;
                    }
                    else{
                        data_total = data_total+total;    
                    }
                    
                    can_total = can_total+1;
                }
            }
        });        

        let numeroFormateado = data_total.toLocaleString('es-PE', {
            minimumFractionDigits: 2, // Cantidad mínima de decimales
            maximumFractionDigits: 4  // Cantidad máxima de decimales
        });                 

        $('.totalseleccion').html(numeroFormateado);
        $('.cantidaseleccion').html(can_total);    
        
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

    $(".cfedocumento").on('click','#descargarcomprobantemasivotesoreriraexcel', function() {

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

    $(".agestioncomprobante").on('click','#descargarcomprobantemasivoreparableexcel', function() {


        var tipoarchivo_id       =   $('#tipoarchivo_id').val();
        var estado_id            =   $('#estado_id').val();
        var operacion_id         =   $('#operacion_id').val();
        var idopcion             =   $('#idopcion').val();
        var _token               =   $('#token').val();

        debugger;
        href = $(this).attr('data-href')+'/'+tipoarchivo_id+'/'+estado_id+'/'+operacion_id+'/'+idopcion;
        $(this).prop('href', href);
        return true;


    });




    $(".agestioncomprobante").on('click','.asignarmasivo', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();

        var array_item              =   datamasivo();
        if(array_item.length<=0){alerterrorajax('No existe ningun registro'); return false;}
        datastring = JSON.stringify(array_item);

        data                        =   {
                                            _token                  : _token,
                                            datastring              : datastring,
                                            idopcion                : idopcion
                                        };

        ajax_modal(data,"/ajax-modal-reparable-masivo",
                  "modal-detalle-requerimiento-masivo","modal-detalle-requerimiento-masivo-container");

    });

    function datamasivo(){
        var data = [];

        $(".listatabla tr").each(function(){

            check                       = $(this).find('input');
            data_requerimiento_id       = $(this).attr('data_requerimiento_id');

            if($(check).is(':checked')){
                data.push({
                    id: data_requerimiento_id
                });

            } 

        });

        return data;
    }


    function ajax_eliminar_lote_estiba(lote){

        var _token      = $('#token').val();
        data            =   {
                                _token                  : _token,
                                lote                    : lote
                            };
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+'/ajax-eliminar-lote-estiba',
            data    :   data,
            success: function (data) {
                cerrarcargando();
                $('.buscardocumentoadmin').trigger('click');
                alertajax("Eliminacion asignado exitosa");
                //$(".listajax").html(data);

            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });
    }


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
        var area_id                 =   $('#area_id').val();

        var idopcion                =   $('#idopcion').val();
        var _token                  =   $('#token').val();

        var fecha_inicio            =   $('#fecha_inicio').val();
        var fecha_fin               =   $('#fecha_fin').val();
        var proveedor_id            =   $('#proveedor_id').val();

        data            =   {
                                _token                  : _token,
                                operacion_id            : operacion_id,
                                area_id                 : area_id,
                                idopcion                : idopcion,
                                fecha_inicio            : fecha_inicio,
                                fecha_fin               : fecha_fin,
                                proveedor_id            : proveedor_id

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




