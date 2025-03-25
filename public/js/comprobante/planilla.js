$(document).ready(function(){
    var carpeta = $("#carpeta").val();

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


    $(".planillamovilidad").on('click','.btnemitirplanillamovilidad', function(e) {
        event.preventDefault();
        var _token                  =   $('#token').val();
        var data_lote               =   $(this).attr('data_lote');
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

    $(".planillamovilidad").on('click','.btn-guardar-detalle-compra', function(e) {
        event.preventDefault();
        var _token                  =   $('#token').val();
        var fecha_pago              =   $('#fecha_gasto').val();
        var cod_mes                 =   $('#cod_mes').val();
        var cod_anio                =   $('#cod_anio').val();
        var fechaString             =   fecha_pago; // "26-03-2025"
        if (!fechaString) return false; // Evita errores si el campo está vacío

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
        debugger;
        if(!(parseInt(cod_mes)===mes && parseInt(cod_anio)===año)){
            alerterrorajax('La fecha de pago no pertenece al periodo de la planilla.'); return false;
        }

        return true;
    });




    var carpeta = $("#carpeta").val();

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




});




