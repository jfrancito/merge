
function toggleContent() {
  var longText = document.getElementById('longText');
  var button = document.getElementById('toggleButton');
  if (longText.classList.contains('collapsed')) {
    longText.classList.remove('collapsed');
    button.innerHTML = "- Ver Menos";
  } else {
    longText.classList.add('collapsed');
    button.innerHTML = "+ Ver MÃ¡s";
  }
}
// Inicialmente colapsar el contenido adicional
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('longText').classList.add('collapsed');
});


$(document).ready(function(){
    var carpeta = $("#carpeta").val();

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

        if(fecha_gasto ==''){ alerterrorajax("Seleccione una Fecha de pago."); return false;}
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




