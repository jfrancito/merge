$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    $(".nav-tabs a[data-toggle=tab]").on("click", function(e) {
      if ($(this).parent().hasClass("disabled")) {
        e.preventDefault();
        return false;
      }
    });

    $(".conei").on('click','.btn-guardar-conei', function() {


        $.confirm({
            title: '¿Confirma el Registro?',
            content: 'CONEI',
            buttons: {
                confirmar: function () {
                    return true;
                },
                cancelar: function () {
                    $.alert('Se cancelo el registro');
                    return false;
                }
            }
        });

        return false;

    });


// 



    $(".conei").on('click','.btn-next', function() {
        event.preventDefault();

        var _token                                  =   $('#token').val();

        var i_tipodocumento_director                =   $('#i_tipodocumento_director').val();
        var i_dni_director                          =   $('#i_dni_director').val();
        var i_nombre_director                       =   $('#i_nombre_director').val();

        var i_tipodocumento_subdirector             =   $('#i_tipodocumento_subdirector').val();
        var i_dni_subdirector                       =   $('#i_dni_subdirector').val();
        var i_nombre_subdirector                    =   $('#i_nombre_subdirector').val();

        var i_tipodocumento_representantedocente            =   $('#i_tipodocumento_representantedocente').val();
        var i_dni_representantedocente                      =   $('#i_dni_representantedocente').val();
        var i_nombre_representantedocente                   =   $('#i_nombre_representantedocente').val();

        var i_tipodocumento_representanteapafa              =   $('#i_tipodocumento_representanteapafa').val();
        var i_dni_representanteapafa                        =   $('#i_dni_representanteapafa').val();
        var i_nombre_representanteapafa                     =   $('#i_nombre_representanteapafa').val();

        var i_tipodocumento_otrorepresentatecomunidad       =   $('#i_tipodocumento_otrorepresentatecomunidad').val();
        var i_dni_otrorepresentatecomunidad                 =   $('#i_dni_otrorepresentatecomunidad').val();
        var i_nombre_otrorepresentatecomunidad              =   $('#i_nombre_otrorepresentatecomunidad').val();

        var i_tipodocumento_representanteadministrativo     =   $('#i_tipodocumento_representanteadministrativo').val();
        var i_dni_representanteadministrativo               =   $('#i_dni_representanteadministrativo').val();
        var i_nombre_representanteadministrativo            =   $('#i_nombre_representanteadministrativo').val();

        var i_tipodocumento_representanteestudiante         =   $('#i_tipodocumento_representanteestudiante').val();
        var i_dni_representanteestudiante                   =   $('#i_dni_representanteestudiante').val();
        var i_nombre_representanteestudiante                =   $('#i_nombre_representanteestudiante').val();

        var i_tipodocumento_representanteexalumno           =   $('#i_tipodocumento_representanteexalumno').val();
        var i_dni_representanteexalumno                     =   $('#i_dni_representanteexalumno').val();
        var i_nombre_representanteexalumno                  =   $('#i_nombre_representanteexalumno').val();
        var periodo                                         =   $('#periodo').val();
        var array_detalle_producto                          =   $('#array_detalle_producto').val();

        var institucion_id                                  =   $('#institucion_id').val();
        var director_id                                     =   $('#director_id').val();


        if(periodo ==''){ alerterrorajax("Seleccione un periodo."); return false;}
        if(i_nombre_director ==''){ alerterrorajax("Ingrese un director."); return false;}
        if(i_nombre_subdirector ==''){ alerterrorajax("Ingrese un subdirector."); return false;}
        if(i_nombre_representantedocente ==''){ alerterrorajax("Ingrese un docente."); return false;}
        if(i_nombre_representanteapafa ==''){ alerterrorajax("Ingrese un representante de la apafa."); return false;}
        if(i_nombre_otrorepresentatecomunidad ==''){ alerterrorajax("Ingrese otro representante de la comunidad."); return false;}


        data                        =   {
                                            _token                        : _token,

                                            i_tipodocumento_director      : i_tipodocumento_director,
                                            i_dni_director                : i_dni_director,
                                            i_nombre_director             : i_nombre_director,

                                            i_tipodocumento_subdirector   : i_tipodocumento_subdirector,
                                            i_dni_subdirector             : i_dni_subdirector,
                                            i_nombre_subdirector          : i_nombre_subdirector,

                                            i_tipodocumento_representantedocente   : i_tipodocumento_representantedocente,
                                            i_dni_representantedocente             : i_dni_representantedocente,
                                            i_nombre_representantedocente          : i_nombre_representantedocente,

                                            i_tipodocumento_representanteapafa   : i_tipodocumento_representanteapafa,
                                            i_dni_representanteapafa             : i_dni_representanteapafa,
                                            i_nombre_representanteapafa          : i_nombre_representanteapafa,

                                            i_tipodocumento_otrorepresentatecomunidad   : i_tipodocumento_otrorepresentatecomunidad,
                                            i_dni_otrorepresentatecomunidad             : i_dni_otrorepresentatecomunidad,
                                            i_nombre_otrorepresentatecomunidad          : i_nombre_otrorepresentatecomunidad,

                                            i_tipodocumento_representanteadministrativo   : i_tipodocumento_representanteadministrativo,
                                            i_dni_representanteadministrativo             : i_dni_representanteadministrativo,
                                            i_nombre_representanteadministrativo          : i_nombre_representanteadministrativo,


                                            i_tipodocumento_representanteestudiante   : i_tipodocumento_representanteestudiante,
                                            i_dni_representanteestudiante             : i_dni_representanteestudiante,
                                            i_nombre_representanteestudiante          : i_nombre_representanteestudiante,

                                            i_tipodocumento_representanteexalumno   : i_tipodocumento_representanteexalumno,
                                            i_dni_representanteexalumno             : i_dni_representanteexalumno,
                                            i_nombre_representanteexalumno          : i_nombre_representanteexalumno,

                                            institucion_id             : institucion_id,
                                            director_id          : director_id,

                                            periodo                                 : periodo,
                                            array_detalle_producto                  : array_detalle_producto,

                                        };
                              
        ajax_modal(data,"/ajax-modal-confirmar-registro",
                  "modal-conei-apafa","modal-conei-apafa-container");

    });

    $(".conei").on('click','.btn-confirmar', function() {
        event.preventDefault();
        $('.nav-tabs a[href="#archivo"]').tab('show');
        $('#modal-conei-apafa').niftyModal('hide');
    });


    $(".conei").on('change','#tdg', function() {
        var tdg        =   $(this).val();
        if(tdg =='TIDO00000001'){ 
            $(".btn_buscar_dni").css("display", "block");
        }else{
            $(".btn_buscar_dni").css("display", "none");
        } 
    });

    $(".conei").on('click','.modal-registro', function() {
        event.preventDefault();
        var _token                  =   $('#token').val();
        var data_td                 =   $(this).attr('data_td');
        var data_dni                =   $(this).attr('data_dni');
        var data_nombre             =   $(this).attr('data_nombre');
        var data_titulo             =   $(this).attr('data_titulo');
        var data_nombre_visible     =   $(this).attr('data_nombre_visible');

        data                        =   {
                                            _token                  : _token,
                                            data_td                 : data_td,
                                            data_dni                : data_dni,
                                            data_nombre             : data_nombre,
                                            data_nombre_visible     : data_nombre_visible,
                                            data_titulo             : data_titulo,
                                        };
                              
        ajax_modal(data,"/ajax-modal-registro",
                  "modal-conei-apafa","modal-conei-apafa-container");

    });


    $(".conei").on('click','.modal-registro-oi', function() {
        event.preventDefault();
        var _token                  =   $('#token').val();

        data                        =   {
                                            _token                  : _token
                                        };
                              
        ajax_modal(data,"/ajax-modal-registro-oi",
                  "modal-conei-apafa","modal-conei-apafa-container");

    });


    $(".conei").on('click','.btn_buscar_dni_oi', function(e) {
        event.preventDefault();

        
        var data_dni_m              =   $(this).attr('data_dni_m');
        var data_nombre_m           =   $(this).attr('data_nombre_m');
        var dni                     =   $('#documentogoi').val();
        var _token                  =   $('#token').val();
        actualizar_ajax_dni_conei_oi(_token,carpeta,dni,data_nombre_m);


    });



    $(".conei").on('click','.btn_buscar_dni', function(e) {
        event.preventDefault();


        var data_dni_m              =   $(this).attr('data_dni_m');
        var data_nombre_m           =   $(this).attr('data_nombre_m');
        var dni                     =   $('#documentog').val();
        var _token                  =   $('#token').val();
        actualizar_ajax_dni_conei(_token,carpeta,dni,data_nombre_m);


    });

    $(".conei").on('click','.btn_asignar_nombre', function(e) {

        event.preventDefault();
        var tdg                     =   $('#tdg').val();
        var documentog              =   $('#documentog').val();
        var nombresg                =   $('#nombresg').val();

        var data_td                 =   $(this).attr('data_td');
        var data_dni                =   $(this).attr('data_dni');
        var data_nombre             =   $(this).attr('data_nombre');
        var data_nombre_visible     =   $(this).attr('data_nombre_visible');



        if(tdg ==''){ alerterrorajax("Seleccione un tipo documento."); return false;}
        if(documentog ==''){ alerterrorajax("Ingrese un documento de identidad."); return false;}
        if(nombresg ==''){ alerterrorajax("Ingrese un nombre."); return false;}

        $('#'+data_td).val(tdg);
        $('#'+data_dni).val(documentog);
        $('#'+data_nombre).val(nombresg);
        $('#'+data_nombre_visible).val(documentog + ' - ' +nombresg);

        $('#modal-conei-apafa').niftyModal('hide');


    });


    $(".conei").on('click','.btn_asignar_nombre_oi', function(e) {

        event.preventDefault();
        var tdg                     =   $('#tdgoi').val();
        var tdgtexto                =   $('select[name="tdgoi"] option:selected').text();

        var documentog              =   $('#documentogoi').val();
        var nombresg                =   $('#nombresgoi').val();
        var cargo                   =   $('#cargo').val();
        var _token                  =   $('#token').val();
        var array_detalle_producto  =   $('#array_detalle_producto').val();


        if(tdg ==''){ alerterrorajax("Seleccione un tipo documento."); return false;}
        if(documentog ==''){ alerterrorajax("Ingrese un documento de identidad."); return false;}
        if(nombresg ==''){ alerterrorajax("Ingrese un nombre."); return false;}
        if(cargo ==''){ alerterrorajax("Seleccione un cargo."); return false;}
        actualizar_ajax_oi(_token,carpeta,tdg,tdgtexto,documentog,nombresg,cargo,array_detalle_producto);
        $('#modal-conei-apafa').niftyModal('hide');
    });



    $(".conei").on('click','.eliminaroi', function(e) {

        event.preventDefault();
        var fila                   =   $(this).attr('data-fila');
        var _token                  =   $('#token').val();
        var array_detalle_producto  =   $('#array_detalle_producto').val();
        eliminar_ajax_oi(_token,carpeta,fila,array_detalle_producto);


    });






    function actualizar_ajax_dni_conei(_token,carpeta,data_dni_m,data_nombre_m){

        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-buscar-dni-ugel",
            data    :   {
                            _token          : _token,
                            dni             : data_dni_m
                        },
            success: function (data){
                cerrarcargando();
                var array        = $.parseJSON(data);

                debugger;

                var nombrea      = array[1];
                var apellidopa   = array[2];
                var apellidoma   = array[3];

                if(nombrea == null){
                    alerterrorajax('DNI NO EXISTE');
                    $('#nombresg').val('');
                }else{
                    $('#'+data_nombre_m).val(nombrea+' '+apellidopa+' '+apellidoma);
                }
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });
    }

    function actualizar_ajax_dni_conei_oi(_token,carpeta,data_dni_m,data_nombre_m){

        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-buscar-dni-ugel",
            data    :   {
                            _token          : _token,
                            dni             : data_dni_m
                        },
            success: function (data){
                cerrarcargando();
                var array        = $.parseJSON(data);

                debugger;

                var nombrea      = array[1];
                var apellidopa   = array[2];
                var apellidoma   = array[3];

                if(nombrea == null){
                    alerterrorajax('DNI NO EXISTE');
                    $('#nombresgoi').val('');
                }else{
                    $('#'+data_nombre_m).val(nombrea+' '+apellidopa+' '+apellidoma);
                }
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });
    }

    function actualizar_ajax_oi(_token,carpeta,tdg,tdgtexto,documentog,nombresg,cargo,array_detalle_producto){

        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-lista-tabla-oi",
            data    :   {
                            _token          : _token,
                            tdg             : tdg,
                            tdgtexto        : tdgtexto,
                            documentog      : documentog,
                            nombresg        : nombresg,
                            dcargoni        : cargo,
                            array_detalle_producto : array_detalle_producto
                        },
            success: function (data){
                cerrarcargando();
                $('.listaajaxoi').html(data);
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });
    }


    function eliminar_ajax_oi(_token,carpeta,fila,array_detalle_producto){

        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-elminar-fila-tabla-oi",
            data    :   {
                            _token          : _token,
                            fila            : fila,
                            array_detalle_producto : array_detalle_producto
                        },
            success: function (data){
                cerrarcargando();
                $('.listaajaxoi').html(data);
            },
            error: function (data) {
                cerrarcargando();
                error500(data);
            }
        });
    }




});




