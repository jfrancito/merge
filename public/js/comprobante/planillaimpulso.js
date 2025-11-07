
$(document).ready(function(){
    var carpeta = $("#carpeta").val();

    $(".planillamovilidad").on('click','.agregartrabajador', function() {
        // debugger;
        var _token                                   =   $('#token').val();
        var data_planilla_movilidad_id               =   $(this).attr('data_planilla_movilidad_id');
        var idopcion                                 =   $('#idopcion').val();
        data                                         =   {
                                                                _token                                   : _token,
                                                                data_planilla_movilidad_id               : data_planilla_movilidad_id,
                                                                idopcion                                 : idopcion
                                                         };
                                        
        ajax_modal(data,"/ajax-modal-detalle-planilla-movilidad-impulso",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });

    $(".planillamovilidad").on('click','.selpartida', function(e) {
        $('.nav-tabs a[href="#partida"]').tab('show');
    });
    $(".planillamovilidad").on('click','.selllegada', function(e) {
        $('.nav-tabs a[href="#llegada"]').tab('show');
    });


    $(".planillamovilidad").on('click','.mdiselp', function(e) {
        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        const location              =   $(this).attr('location');
        const department_code       =   $(this).attr('department_code');
        const province_code         =   $(this).attr('province_code');
        const district_code         =   $(this).attr('district_code');

        $('#departamentopartida_id').val(department_code).trigger('change.select2');
        $('#departamentopartida_id').val(department_code).trigger('change');
        setTimeout(function() {
            $('#provinciapartida_id').val(province_code).trigger('change.select2');
            $('#provinciapartida_id').val(province_code).trigger('change');
            // Espera otros 500ms para el distrito
            setTimeout(function() {
                $('#distritopartida_id').val(district_code).trigger('change.select2');
                $('#lugarpartida').val(location);
                $('.nav-tabs a[href="#registro"]').tab('show');
            }, 1000);
        }, 1000);


    });

    $(".planillamovilidad").on('click','.mdisell', function(e) {
        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        const location              =   $(this).attr('location');
        const department_code       =   $(this).attr('department_code');
        const province_code         =   $(this).attr('province_code');
        const district_code         =   $(this).attr('district_code');

        $('#departamentollegada_id').val(department_code).trigger('change.select2');
        $('#departamentollegada_id').val(department_code).trigger('change');
        setTimeout(function() {
            $('#provinciallegada_id').val(province_code).trigger('change.select2');
            $('#provinciallegada_id').val(province_code).trigger('change');
            // Espera otros 500ms para el distrito
            setTimeout(function() {
                $('#distritollegada_id').val(district_code).trigger('change.select2');
                $('#lugarllegada').val(location);
                $('.nav-tabs a[href="#registro"]').tab('show');
            }, 1000);
        }, 1000);


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


    $(".cfedocumento").on('click','.clickpc', function(e) {

        var _token                  =   $('#token').val();
        var data_requerimiento_id   =   $(this).attr('data_requerimiento_opcion_id');
        var data_linea              =   $(this).attr('data_linea');


        var idopcion                =   $('#idopcion').val();

        data                        =   {
                                            _token                  : _token,
                                            data_requerimiento_id   : data_requerimiento_id,
                                            data_linea              : data_linea,
                                            idopcion                : idopcion,
                                        };
        ajax_modal(data,"/ajax-modal-planilla-consolidado-subir",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });

    $(".cfedocumento").on('dblclick','.dobleclickpc', function(e) {

        var _token                  =   $('#token').val();
        var data_requerimiento_id   =   $(this).attr('data_requerimiento_id');
        var data_linea              =   $(this).attr('data_linea');


        var idopcion                =   $('#idopcion').val();

        data                        =   {
                                            _token                  : _token,
                                            data_requerimiento_id   : data_requerimiento_id,
                                            data_linea              : data_linea,
                                            idopcion                : idopcion,
                                        };
        ajax_modal(data,"/ajax-modal-planilla-consolidado-subir",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });


    $(".cfedocumento").on('click','.buscardocumentomob', function() {

        event.preventDefault();

        var fecha_inicio         =   $('#fecha_inicio').val();
        var fecha_fin            =   $('#fecha_fin').val();
        var idopcion             =   $('#idopcion').val();
        var _token               =   $('#token').val();
        //validacioones
        if(fecha_inicio ==''){ alerterrorajax("Seleccione una fecha inicio."); return false;}
        if(fecha_fin ==''){ alerterrorajax("Seleccione una fecha fin."); return false;}

        data            =   {
                                _token                  : _token,
                                fecha_inicio            : fecha_inicio,
                                fecha_fin               : fecha_fin,
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-fe-entregable-pla-mob");

    });

    $(".cfedocumento").on('click','.buscardocumento', function() {

        event.preventDefault();

        var fecha_inicio         =   $('#fecha_inicio').val();
        var fecha_fin            =   $('#fecha_fin').val();
        var empresa_id           =   $('#empresa_id').val();
        
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
                                idopcion                : idopcion
                            };
        ajax_normal(data,"/ajax-buscar-documento-fe-entregable-pla");

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
        const link                  =   '/ajax-detalle-folio-pagos-ple'
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
        const data_periodo          =   $(this).attr('data_periodo');
        const data_iddocumento      =   $(this).attr('data_iddocumento');

        const tabId                 =   '#guardarfolio';
        $('#folio').val(data_folio);
        $('#glosa_g').val(data_glosa);
        $('#periodo').val(data_periodo);
        $('#cantidad').val(data_cantidad);
        $('#ID_DOCUMENTO').val(data_iddocumento);
        $('.nav-tabs a[href="' + tabId + '"]').tab('show');
        
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
        const link      = '/ajax-crear-folio-pagos-pla';
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
                    ajax_extornar(data,"/ajax-extornar-folio-pagos-lg");
                },
                cancelar: function () {
                    $.alert('Se cancelo el extorno');
                }
            }
        });
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



    $(".cfedocumento").on('click','.mdisel', function(e) {
        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        const data_folio            =   $(this).attr('data_folio'); // Obtener el id del checkbox
        const link                  =   '/ajax-select-folio-pagos-lg'
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



    $(".planillamovilidad").on('change','#departamentopartida_id', function() {

        debugger;
        var _token                                   =   $('#token').val();
        var departamentopartida_id                   =   $('#departamentopartida_id').val();
        var link                                     =   '/ajax-select-combo-provincia-partida';
        var section                                  =   'ajax_provincia_partida';


        data                        =   {
                                            _token                                   : _token,
                                            departamentopartida_id                   : departamentopartida_id
                                        };
                                        
        ajax_normal_section(data,link,section);

    });


    $(".cfedocumento").on('click','.loteentregable', function(e) {
        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        data                        =   {
                                            _token                  : _token,
                                            idopcion                : idopcion
                                        };
        ajax_modal(data,"/ajax-modal-detalle-folios-pla",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });


    $(".planillamovilidad").on('change','#provinciapartida_id', function() {

        debugger;
        var _token                                   =   $('#token').val();
        var departamentopartida_id                   =   $('#departamentopartida_id').val();
        var provinciapartida_id                      =   $('#provinciapartida_id').val();
        var link                                     =   '/ajax-select-combo-distrito-partida';
        var section                                  =   'ajax_distrito_partida';

        data                        =   {
                                            _token                                   : _token,
                                            departamentopartida_id                   : departamentopartida_id,
                                            provinciapartida_id                      : provinciapartida_id
                                        };
                                        
        ajax_normal_section(data,link,section);

    });



    $(".planillamovilidad").on('change','#departamentollegada_id', function() {

        debugger;
        var _token                                   =   $('#token').val();
        var departamentollegada_id                   =   $('#departamentollegada_id').val();
        var link                                     =   '/ajax-select-combo-provincia-llegada';
        var section                                  =   'ajax_provincia_llegada';


        data                        =   {
                                            _token                                   : _token,
                                            departamentollegada_id                   : departamentollegada_id
                                        };
                                        
        ajax_normal_section(data,link,section);

    });


    $(".planillamovilidad").on('change','#provinciallegada_id', function() {

        debugger;
        var _token                                   =   $('#token').val();
        var departamentollegada_id                   =   $('#departamentollegada_id').val();
        var provinciallegada_id                      =   $('#provinciallegada_id').val();
        var link                                     =   '/ajax-select-combo-distrito-llegada';
        var section                                  =   'ajax_distrito_llegada';

        data                        =   {
                                            _token                                   : _token,
                                            departamentollegada_id                   : departamentollegada_id,
                                            provinciallegada_id                      : provinciallegada_id
                                        };
                                        
        ajax_normal_section(data,link,section);

    });






    $(".planillamovilidad").on('click','.btn-guardar-detalle-planilla', function(e) {
        event.preventDefault();
        debugger;

        var _token                  =   $('#token').val();

        var cod_mes                 =   $('#cod_mes').val();
        var cod_anio                =   $('#cod_anio').val();


        var fecha_gasto             =   $('#fecha_gasto').val();
        var motivo_id               =   $('#motivo_id').val();
        var lugarpartida            =   $('#lugarpartida').val();
        var lugarllegada            =   $('#lugarllegada').val();
        var total                   =   $('#total').val();       
        var fechaString             =   fecha_gasto; // "26-03-2025"

        if(fecha_gasto ==''){ alerterrorajax("Seleccione una Fecha de gasto."); return false;}
        if(motivo_id ==''){ alerterrorajax("Seleccione un Motivo."); return false;}
        if(lugarpartida ==''){ alerterrorajax("Ingrese un direccion de Partida"); return false;}
        if(lugarllegada ==''){ alerterrorajax("Ingrese un direccion de LLegada"); return false;}

        var departamentopartida_id               =   $('#departamentopartida_id').val();
        var provinciapartida_id                  =   $('#provinciapartida_id').val();
        var distritopartida_id                   =   $('#distritopartida_id').val();

        if(departamentopartida_id ==''){ alerterrorajax("Seleccione un Departamento de Partida."); return false;}
        if(provinciapartida_id ==''){ alerterrorajax("Seleccione una Provincia de Partida."); return false;}
        if(distritopartida_id ==''){ alerterrorajax("Seleccione un Distrito de Partida."); return false;}

        var departamentollegada_id               =   $('#departamentollegada_id').val();
        var provinciallegada_id                  =   $('#provinciallegada_id').val();
        var distritollegada_id                   =   $('#distritollegada_id').val();

        if(departamentollegada_id ==''){ alerterrorajax("Seleccione un Departamento de Llegada."); return false;}
        if(provinciallegada_id ==''){ alerterrorajax("Seleccione una Provincia de Llegada."); return false;}
        if(distritollegada_id ==''){ alerterrorajax("Seleccione un Distrito de Llegada."); return false;}


        if(total ==''){ alerterrorajax("Ingrese un total"); return false;}


        // Separar día, mes y año
        var partes = fechaString.split('-');
        var dia = parseInt(partes[0], 10);
        var mes = parseInt(partes[1], 10);
        var año = parseInt(partes[2], 10);

        // Obtener la fecha actual
        var hoy = new Date();
        var añoHoy = hoy.getFullYear();
        var mesHoy = hoy.getMonth() + 1; // Los meses en JS van de 0 a 11
        var diaHoy = hoy.getDate();

        console.log('Fecha seleccionada:', dia, mes, año);
        console.log('Fecha actual:', diaHoy, mesHoy, añoHoy);
        debugger;
        // Comparar año, mes y día manualmente
        if (
            año > añoHoy || 
            (año === añoHoy && mes > mesHoy) || 
            (año === añoHoy && mes === mesHoy && dia > diaHoy)
        ) {
            alerterrorajax('La fecha de pago no puede ser mayor a la fecha actual.'); return false;
        }

        var codanio            =   $('#codanio').val();
        var codmes             =   $('#codmes').val(); 

        debugger;
        if(!(parseInt(cod_mes)===parseInt(codmes) && parseInt(cod_anio)===parseInt(codanio))){
            alerterrorajax('La fecha de pago no pertenece al periodo de la planilla.'); return false;
        }
        abrircargando();
        $( "#agregarpmd" ).submit();
    });

    $(".planillamovilidad").on('click','.agregardetalle', function() {
        // debugger;
        var _token                                   =   $('#token').val();
        var data_planilla_movilidad_id               =   $(this).attr('data_planilla_movilidad_id');
        var idopcion                                 =   $('#idopcion').val();
        data                        =   {
                                            _token                                   : _token,
                                            data_planilla_movilidad_id               : data_planilla_movilidad_id,
                                            idopcion                                 : idopcion
                                        };
                                        
        ajax_modal(data,"/ajax-modal-detalle-planilla-movilidad",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });

    $(".planillamovilidad").on('click','.modificardetallepm', function() {
        // debugger;
        var _token                                   =   $('#token').val();
        var data_iddocumento                         =   $(this).attr('data_iddocumento');
        var data_item                                =   $(this).attr('data_item');
        var idopcion                                 =   $('#idopcion').val();

        data                        =   {
                                            _token                  : _token,
                                            data_iddocumento        : data_iddocumento,
                                            data_item               : data_item,
                                            idopcion                : idopcion
                                        };
                                        
        ajax_modal(data,"/ajax-modal-modificar-detalle-planilla-movilidad",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });

    $(".planillamovilidad").on('change','#tipo_solicitud', function() {
        event.preventDefault();
        var tipo_solicitud     =   $(this).val();
        debugger;
        if(tipo_solicitud == 'RENDICION'){
            $('.cajaautoriza').hide();
        }else{
            $('#cajaautoriza').show();
        }
    });

    $(".planillamovilidad").on('click','.btnguardarplanillamovilidad', function(e) {
        event.preventDefault();
        var _token                  =   $('#token').val();
        var data_lote               =   $(this).attr('data_lote');
        $.confirm({
            title: '¿Confirma el registro?',
            content: 'Registro de Planilla de movilidad',
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

    $(".cfedocumento").on('click','.btn-extonar-pm', function(e) {
        event.preventDefault();
        var _token                  =   $('#token').val();
        $.confirm({
            title: '¿Confirma el extorno?',
            content: 'Extorno de Planilla de movilidad',
            buttons: {
                confirmar: function () {
                     $( "#forextornar" ).submit();   
                },
                cancelar: function () {
                    $.alert('Se cancelo el extorno');
                    window.location.reload();
                }
            }
        });
    });




    $(".planillamovilidad").on('click','.btnmovilidaddetalle', function(e) {
        event.preventDefault();
        var _token                  =   $('#token').val();


        $.confirm({
            title: '¿Confirma el registro?',
            content: 'Registro de movilidad impulso',
            buttons: {
                confirmar: function () {
                     $( "#frmdetalleimpulso" ).submit();   
                },
                cancelar: function () {
                    $.alert('Se cancelo la emision');
                    window.location.reload();
                }
            }
        });

    });


    $(".planillamovilidad").on('click','.btnemitirplanillamovilidad', function(e) {
        event.preventDefault();
        var _token                  =   $('#token').val();
        var data_lote               =   $(this).attr('data_lote');
        var tipo_solicitud          =   $("#tipo_solicitud").val();
        var autoriza_id             =   $("#autoriza_id").val();

        if(tipo_solicitud == 'REEMBOLSO'){
            if(autoriza_id == ''){
                alerterrorajax('Seleccione quien autorizara su REEMBOLSO'); return false;
            }
        }

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


});




