
$(document).ready(function(){
    var carpeta = $("#carpeta").val();


    $(".planillamovilidad").on('click','.agregar_cuenta_bancaria_oc', function() {

        var _token                  =   $('#token').val();
        var idopcion                =   $('#idopcion').val();
        var orden_id                =   $(this).attr('data_id');

        data                        =   {
                                            _token                  : _token,
                                            orden_id                : orden_id,
                                            idopcion                : idopcion,

                                        };

        ajax_modal(data,"/ajax-modal-configuracion-cuenta-bancaria-impulso",
                  "modal-detalle-requerimiento","modal-detalle-requerimiento-container");

    });


    $(".planillamovilidad").on('click','.ver_cuenta_bancaria', function() {

        var _token                  =   $('#token').val();
        var orden_id                =   $(this).attr('data_id');
        var idopcion                =   $('#idopcion').val();



        data                        =   {
                                            _token                  : _token,
                                            orden_id                : orden_id,
                                            idopcion                : idopcion,
                                        };

        ajax_modal(data,"/ajax-modal-ver-cuenta-bancaria-impulso",
              "modal-detalle-requerimiento","modal-detalle-requerimiento-container");



    });







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


    $(".cfedocumento").on('click','.buscardocumentomobmasivo', function() {

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
        ajax_normal(data,"/ajax-buscar-documento-fe-entregable-pla-mob-masivo");

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
        valor                       =   validarDatosAntesDeGuardar();
        if(valor){

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

        }



    });

    function validarDatosAntesDeGuardar() {
        let errores = [];
        let tabla = document.getElementById('nso_check');
        let filas = tabla.querySelectorAll('tbody tr');
        
        filas.forEach((fila, indexFila) => {
            let tipoCelda = fila.querySelector('td:nth-child(3)');
            let tipo = tipoCelda ? tipoCelda.textContent.trim() : '';
            
            if (tipo === 'ASIGNADO') {
                let siguienteFila = filas[indexFila + 1];
                if (!siguienteFila) return;
                
                let siguienteTipoCelda = siguienteFila.querySelector('td:nth-child(3)');
                let siguienteTipo = siguienteTipoCelda ? siguienteTipoCelda.textContent.trim() : '';
                
                if (siguienteTipo === 'OTRO_TIPO' || siguienteTipo === 'ADICIONAL') {
                    let celdasAsignado = fila.querySelectorAll('td.text-center');
                    let celdasOtro = siguienteFila.querySelectorAll('td.text-center');
                    
                    for (let i = 0; i < celdasAsignado.length && i < celdasOtro.length; i++) {
                        let celdaAsignado = celdasAsignado[i];
                        let celdaOtro = celdasOtro[i];
                        
                        let selectAsignado = celdaAsignado.querySelector('select');
                        let selectfecha_formateada = celdaAsignado.querySelector('input[name="fecha_formateada"]');
                        let valorFecha = selectfecha_formateada ? selectfecha_formateada.value : '';
                        let inputOtro = celdaOtro.querySelector('input[type="text"]');
                        
                        if (selectAsignado && inputOtro && inputOtro.value !== '') {
                            let textoSeleccionado = selectAsignado.options[selectAsignado.selectedIndex].text;
                            let valorIngresado = parseFloat(inputOtro.value) || 0;
                            
                            console.log(`Día ${i+1}: Select texto="${textoSeleccionado}", Input valor=${valorIngresado}`);
                            
                            let valorMaximoPermitido = extraerValorDelSelect(textoSeleccionado);
                            
                            console.log(`Valor máximo extraído: ${valorMaximoPermitido}`);
                            
                            if (valorIngresado > valorMaximoPermitido) {
                                let nombreTrabajador = fila.querySelector('td:first-child').textContent.trim();
                                let diaNumero = i + 1;
                                
                                errores.push({
                                    trabajador: nombreTrabajador,
                                    dia: valorFecha,
                                    valorMaximo: valorMaximoPermitido,
                                    valorIngresado: valorIngresado,
                                    textoSelect: textoSeleccionado
                                });
                            }
                        }
                    }
                }
            }
        });
        
        if (errores.length > 0) {
            mostrarErrores(errores);
            return false;
        } else {
            return true;
        }
    }

    function extraerValorDelSelect(textoSelect) {
        if (!textoSelect || textoSelect === '-' || textoSelect === '') {
            return 0;
        }
        
        console.log(`Extrayendo valor de: "${textoSelect}"`);
        
        // Buscar el patrón: número con decimales al final del string
        let match = textoSelect.match(/(\d+\.\d+)$/);
        if (match) {
            let valor = parseFloat(match[1]);
            console.log(`Encontrado con regex: ${valor}`);
            return valor;
        }
        
        // Si no encuentra con decimales, buscar cualquier número
        let numeros = textoSelect.match(/\d+\.?\d*/g);
        if (numeros && numeros.length > 0) {
            // Tomar el último número encontrado (asumiendo que es el valor)
            let valor = parseFloat(numeros[numeros.length - 1]);
            console.log(`Encontrado en array: ${valor}`);
            return valor;
        }
        
        console.log(`No se pudo extraer valor, retornando 0`);
        return 0;
    }

    function mostrarErrores(errores) {
        let mensaje = "❌ ERRORES DE VALIDACIÓN:\n\n";
        mensaje += "Se encontraron los siguientes problemas:\n\n";

        errores.forEach((error, index) => {
            mensaje += `${index + 1}. TRABAJADOR: ${error.trabajador}\n`;
            mensaje += `   DÍA ${error.dia}: Valor ingresado (${error.valorIngresado}) \n`;
            mensaje += `   EXCEDE el valor máximo permitido (${error.valorMaximo})\n`;
            mensaje += `   Configuración seleccionada: ${error.textoSelect}\n\n`;
        });

        mensaje += "Por favor, ajuste los valores antes de guardar.";

        // SweetAlert2
        Swal.fire({
            icon: 'error',
            title: '❌ ERRORES DE VALIDACIÓN',
            html: formatMessage(errores),
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#d33',
            width: '600px',
            customClass: {
                popup: 'custom-swal-popup'
            }
        });
    }

    // Función para formatear el mensaje como HTML
    function formatMessage(errores) {
        let html = '<div class="text-left">';
        html += '<p class="mb-3"><strong>Se encontraron los siguientes problemas:</strong></p>';
        
        errores.forEach((error, index) => {
            html += `<div class="error-item mb-3 p-2 border rounded">`;
            html += `<strong>${index + 1}. TRABAJADOR:</strong> ${error.trabajador}<br>`;
            html += `<strong>DÍA ${error.dia}:</strong> Valor ingresado (<span class="text-danger">${error.valorIngresado}</span>)<br>`;
            html += `<strong>EXCEDE</strong> el valor máximo permitido (<span class="text-success">${error.valorMaximo}</span>)<br>`;
            html += `<strong>Configuración seleccionada:</strong> ${error.textoSelect}`;
            html += `</div>`;
        });
        
        html += '<p class="mt-3 text-warning"><strong>Por favor, ajuste los valores antes de guardar.</strong></p>';
        html += '</div>';
        
        return html;
    }


    function validarYGuardar() {
        if (validarDatosAntesDeGuardar()) {
            alert('✅ Todos los datos son válidos. Procediendo a guardar...');
            // document.getElementById('formulario').submit();
        } else {
            alert('❌ No se puede guardar debido a errores de validación.');
        }
    }




    $(".planillamovilidad").on('click','.btnemitirplanillamovilidad', function(e) {
        event.preventDefault();
        var _token                  =   $('#token').val();
        var data_lote               =   $(this).attr('data_lote');

        // Validar bancos
        const erroresBanco = validarBancosAsignados();
        debugger;
        if (erroresBanco.length > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Bancos Pendientes',
                html: `
                    <div class="text-left">
                        <p>Hay <strong>${erroresBanco.length}</strong> trabajador(es) sin banco asignado:</p>
                        <ul class="text-start">
                            ${erroresBanco.slice(0, 5).map(error => 
                                `<li><strong>${error.trabajador}</strong></li>`
                            ).join('')}
                        </ul>
                        ${erroresBanco.length > 5 ? `<p>... y ${erroresBanco.length - 5} más</p>` : ''}
                        <p class="mt-3">¿Desea continuar de todos modos?</p>
                    </div>
                `,
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#d33'
            }).then((result) => {
                return false;
            });
        } else {
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
        }






    });


    function validarBancosAsignados() {
        let errores = [];
        
        // Recorrer todas las filas
        document.querySelectorAll('tbody tr').forEach((fila, index) => {
            const tipo = fila.querySelector('input[name*="[tipo]"]')?.value;
            const trabajador = fila.querySelector('td:first-child')?.textContent.trim();
            const inputBanco = fila.querySelector('input[name="TXT_EMPR_BANCO"]');
            debugger;
            // Solo validar para tipo ASIGNADO
            if (tipo === 'ASIGNADO') {
                if (!inputBanco || !inputBanco.value || inputBanco.value.trim() === '') {
                    errores.push({
                        trabajador: trabajador,
                        tipo: tipo,
                        mensaje: 'Trabajador ASIGNADO sin banco'
                    });
                }
            }
        });
        
        return errores;
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


});




