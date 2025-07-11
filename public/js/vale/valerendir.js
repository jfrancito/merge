
$(document).ready(function(){

    var carpeta = $("#carpeta").val();


        $(".valerendirprincipal").on('click','#asignarvalerendir', function(e) {

            let _token                  =   $('#token').val();
            let usuario_autoriza        =   $('#cliente_select').val();
            let usuario_aprueba         =   $('#cliente_select1').val();
            let tipo_motivo             =   $('#tipo_motivo').val();
            let txt_glosa               =   $('#txt_glosa').val();
            let can_total_importe       =   $('#can_total_importe').val();
            let can_total_saldo         =   $('#can_total_saldo').val();
            let cod_moneda              =   $('#cod_moneda').val();


            let vale_rendir_id = $('#vale_rendir_id').val(); 

            let opcion = vale_rendir_id === null || vale_rendir_id === undefined  || vale_rendir_id === '' ? 'I' : 'U'; 



            if (!usuario_autoriza || !usuario_aprueba || !txt_glosa || !tipo_motivo || !can_total_importe || !can_total_saldo || !cod_moneda) {
                 alerterrorajax("Todos los campos son obligatorios. Por favor, complete todos los campos.");
            return; 
            }

            if (parseFloat(can_total_importe) <= 0 || isNaN(parseFloat(can_total_importe))) {
                alerterrorajax("El campo 'importe' debe ser un número positivo mayor a cero.");
                return;
            }

            if (parseFloat(can_total_saldo) <= 0 || isNaN(parseFloat(can_total_saldo))) {
                 alerterrorajax("El campo 'saldo' debe ser un número positivo mayor a cero.");
                return;
            }


            //DETALLE

            let detalles = [];
            $('#tabla_vale_rendir_detalle tbody tr').each(function () {
                let fechaInicio = $(this).find('td').eq(0).text().trim();
                let fechaFin = $(this).find('td').eq(1).text().trim();
                let codDestino = $(this).data('cod-destino');
                let nomDestino = $(this).find('td').eq(2).text().trim();
                let nombresTipos = $(this).find('td').eq(3).html().split('<br/>').join(',');
                let diffDays = parseInt($(this).find('td').eq(4).text().trim()) || 0;                
                let valoresBase = $(this).find('td').eq(5).html().split('<br/>').join(',');
                let importesCalculados = $(this).find('td').eq(6).html().split('<br/>').join(',');
                let totalImporte = parseFloat($(this).find('td').eq(7).text().trim()) || 0; 
                let ind_destino = parseInt($(this).find('td').eq(8).text().trim()) || 0;
                let ind_propio = parseInt($(this).find('td').eq(9).text().trim()) || 0;
                let ind_aereo = parseInt($(this).find('td').eq(10).text().trim()) || 0;

                let detalle_id = $(this).data('id'); 

                let opcion_detalle = 'I';

                detalles.push({
                    fec_inicio               : fechaInicio,
                    fec_fin                  : fechaFin,
                    cod_destino              : codDestino,
                    nom_destino              : nomDestino,
                    nom_tipos                : nombresTipos,
                    dias                     : diffDays,
                    can_unitario             : valoresBase,
                    can_unitario_total       : importesCalculados,
                    can_total_importe        : totalImporte, 
                    ind_destino              : ind_destino,
                    ind_propio               : ind_propio,  
                    ind_aereo                : ind_aereo,   
                    opcion_detalle           : opcion_detalle,
                    detalle_id               : detalle_id 
                });
            });
           
           $.ajax({
                  type    :   "POST",
                  url     :   carpeta+"/registrar_vale_rendir",
                  data    :   {
                                _token                                   : _token,
                                usuario_autoriza                         : usuario_autoriza,
                                usuario_aprueba                          : usuario_aprueba,
                                tipo_motivo                              : tipo_motivo,
                                txt_glosa                                : txt_glosa,
                                can_total_importe                        : can_total_importe,
                                can_total_saldo                          : can_total_saldo,
                                cod_moneda                               : cod_moneda,
                                vale_rendir_id                           : vale_rendir_id,
                                opcion                                   : opcion,
                                array_detalle                            : detalles
                                                                      
                              },
               
                success: function (data) {
                    if (data.error) {

                        if (data.error.includes("Vale de rendir procesado correctamente")) {
                        alerterrorajax("El vale a rendir ya ha sido autorizado y no puede modificarse.");

                        }else {
                            alerterrorajax(data.error); 
                        }
                        return;
                    }
            
                  
                    let nuevo_vale_id = data.vale_rendir_id || vale_rendir_id;

                    $.ajax({
                        type: "GET",
                        url: carpeta + "/enviar_correo_generado",
                        data: { valerendir_id: nuevo_vale_id },
                        success: function(response) {
                            if (response.success) {
                                alertajax("Vale a rendir registrado y correo enviado correctamente."); 
                            } else {
                                alertajax("Vale registrado, pero no se pudo enviar el correo.");
                            }
                            location.reload();
                        },
                        error: function() {
                            alertajax("Vale registrado, pero ocurrió un error al enviar el correo.");
                            location.reload();
                        }
                    });
                },

                error: function (data) {
                    error500(data);
                }
            });   
        });


 /* data    =   {
                              _token                                   : _token,
                                usuario_autoriza                         : usuario_autoriza,
                                usuario_aprueba                          : usuario_aprueba,
                                tipo_motivo                              : tipo_motivo,
                                txt_glosa                                : txt_glosa,
                                can_total_importe                        : can_total_importe,
                                can_total_saldo                          : can_total_saldo,
                                vale_rendir_id                           : vale_rendir_id,
                                opcion                                   : opcion,
                                array_detalle                            : detalles
                                                                                                          
                              };

            ajax_normal_combo(data,"/registrar_vale_rendir","listadetalleajax")  */

        $(".valerendirprincipal").on('dblclick', '.dobleclickpc', function (e) {
            let _token = $('#token').val();
            let valerendir_id = $(this).attr('data_vale_rendir');

            $.ajax({
                type: "POST",
                url: carpeta + "/data_vale_rendir",
                data: {
                    _token: _token,
                    valerendir_id: valerendir_id
                },
                success: function (data) {
                    let data_left = JSON.parse(data);
                    let estadoVale = data_left["0"]["TXT_CATEGORIA_ESTADO_VALE"];

                    if (estadoVale !== 'GENERADO') {
                        alerterrorajax('Solo se puede modificar un Vale de Rendir con estado "GENERADO".');
                        return;
                    }

                    // Cargar cabecera
                    $('#cliente_select').val(data_left["0"]["USUARIO_AUTORIZA"]).trigger('change');
                    $('#cliente_select1').val(data_left["0"]["USUARIO_APRUEBA"]).trigger('change');
                    $('#tipo_motivo').val(data_left["0"]["TIPO_MOTIVO"]).trigger('change');
                    $('#can_total_importe').val(data_left["0"]["CAN_TOTAL_IMPORTE"]);
                    $('#can_total_saldo').val(data_left["0"]["CAN_TOTAL_SALDO"]);
                    $('#txt_glosa').val(data_left["0"]["TXT_GLOSA"]);
                    $('#cod_moneda').val(data_left["0"]["COD_MONEDA"]).trigger('change'); 
                    $('#vale_rendir_id').val(valerendir_id);
                    $('#asignarvalerendir').text('Modificar');

                    $.ajax({
                        type: "POST",
                        url: carpeta + "/data_vale_rendir_detalle",
                        data: {
                            _token: _token,
                            valerendir_id: valerendir_id
                        },
                        success: function (data) {
                            let data_left = JSON.parse(data);
                            $('#tabla_vale_rendir_detalle tbody').empty();

                            data_left.forEach(function (item) {
                                let row = '<tr data-id="' + item.ID + '" data-cod-destino="' + item.COD_DESTINO + '">';
                                row += '<td>' + item.FEC_INICIO + '</td>';
                                row += '<td>' + item.FEC_FIN + '</td>';
                                row += '<td>' + item.NOM_DESTINO + '</td>';
                                row += '<td>' + item.NOM_TIPOS + '</td>';
                                row += '<td>' + item.DIAS + '</td>';
                                row += '<td>' + item.CAN_UNITARIO + '</td>';
                                row += '<td>' + item.CAN_UNITARIO_TOTAL + '</td>';
                                row += '<td>' + ((parseFloat(item.CAN_TOTAL_IMPORTE) || 0).toFixed(2)) + '</td>';
                                row += '<td><button type="button" class="btn btn-danger btn-sm eliminarFila" data-id-detalle="' + item.ID + '"><i class="fa fa-trash"></i></button></td>';
                                row += '</tr>';
                                $('#tabla_vale_rendir_detalle tbody').append(row);
                            });

                            $('#detalle_id').val(valerendir_id);
                            $('#asignarvalerendir').text('Modificar');
                        },
                        error: function (data) {
                            error500(data);
                        }
                    });
                },
                error: function (data) {
                    error500(data);
                }
            });
        });


        $(".valerendirprincipal").on('click', '.delete-valerendir', function(e) {
            e.preventDefault();
            
            var valerendir_id = $(this).closest('tr').attr('data_vale_rendir');
            var _token = $('#token').val();

            $.ajax({
                type: "POST",
                url: carpeta + "/eliminar_vale_rendir",
                data: {
                    _token: _token,
                    valerendir_id: valerendir_id
                },
                success: function(response) {
                    if (response.success) {
                        $.ajax({
                            type: "GET",
                            url: carpeta + "/rechazar_correo_generado",
                            data: {
                                valerendir_id: valerendir_id
                            },
                            success: function () {
                                console.log('Correo de eliminación enviado correctamente.');
                            },
                            error: function () {
                                console.warn('Error al enviar el correo de eliminación.');
                            }
                        });

                        location.reload();

                    } else {
                        alerterrorajax('Error al eliminar el vale de rendir.');
                    }
                },
                error: function(data) {
                    alerterrorajax('Error al eliminar el vale de rendir.');
                }
            });
        });



        // DETALLE
        $('#tabla_vale_rendir_detalle').on('click', '.eliminarFila', function () {
            let _token = $('#token').val();
            let id_detalle = $(this).data('id-detalle');
                let cod_destino = $(this).data('cod-destino');

            $.ajax({
                type: "POST",
                url: carpeta + "/eliminar_vale_rendir_detalle",
                data: {
                    _token: _token,
                    id_detalle: id_detalle,
                    cod_destino: cod_destino
                },
                success: function (data) {
                    // Elimina visualmente la fila si el backend responde correctamente
                    if (data.success) {
                        alertajax(data.success);
                       $('tr[data-id="' + id_detalle + '"][data-cod-destino="' + cod_destino + '"]').remove();
                         actualizarTotalImporte(); 
                    } else {
                        alerterrorajax('Ocurrió un error al eliminar el detalle.');
                    }
                },
                error: function (data) {
                    error500(data);
                }
             });
        });



        $('#tabla_vale_rendir_detalle').on('click', '.eliminarFila', function () {
            $(this).closest('tr').remove();
            actualizarTotalImporte();
        });

       $(".valerendirprincipal").on('click', '.rechazar-valerendir', function(e) {
            e.preventDefault();
            
            var valerendir_id = $(this).closest('tr').attr('data_vale_rendir');
                $('#rechazoModal').data('valerendir-id', valerendir_id);
                $('#rechazoModal').modal('show');
        });

        $('#confirmRechazo').on('click', function() {
            var valerendir_id = $('#rechazoModal').data('valerendir-id');
            var motivo_rechazo = $('#motivoRechazo').val().trim();  

                if (motivo_rechazo === '') {
                    alerterrorajax('Por favor ingrese un motivo de rechazo.');
                    return;
                }

            var _token = $('#token').val();     


            $.ajax({
                    type: "POST",
                    url: carpeta + "/rechazar_vale_rendir",
                    data: {
                        _token: _token,
                        valerendir_id: valerendir_id,
                        motivo_rechazo: motivo_rechazo  
                    },

                    success: function(response) {
                        if (response.success) {
                            alertajax('Vale de rendir rechazado con éxito.');

                            var row = $("tr[data_vale_rendir='" + valerendir_id + "']");
                            row.find("td").eq(7).html('<span class="badge badge-danger">RECHAZADO</span>'); 
                            location.reload(); 

                            row.find(".autorizar-valerendir").hide();
                            row.find(".aprobar-valerendir").hide();
                            row.find(".rechazar-valerendir").hide();

                            $('#rechazoModal').modal('hide');

                        }else{
                            alerterrorajax('Error al rechazar el vale de rendir.');
                        }
                    },
                    error: function() {
                        alerterrorajax('Error al procesar la solicitud.');
                    }
             });    
        });


        $(".valerendirprincipal").on('click', '.autorizar-valerendir', function(e) {
             e.preventDefault();
        
             var valerendir_id = $(this).closest('tr').attr('data_vale_rendir');
                $('#autorizaModal').data('valerendir-id', valerendir_id);
                $('#autorizaModal').modal('show');
        });

        $('#confirmAutoriza').on('click', function() {
                var valerendir_id = $('#autorizaModal').data('valerendir-id');
                var motivo_autoriza = $('#motivoAutoriza').val().trim();  

                if (motivo_autoriza === '') {
                    alerterrorajax('Por favor ingrese un motivo de autorizacion.');
                    return;
                }

                var _token = $('#token').val();
                
                $.ajax({
                    type: "POST",
                    url: carpeta + "/autorizar_vale_rendir",
                    data: {
                        _token: _token,
                        valerendir_id: valerendir_id,
                        motivo_autoriza: motivo_autoriza 
                    },



                    success: function(response) {
                        if (response.success) {
                            alertajax('Vale de rendir autorizado con éxito.');


                    $.ajax({

                            type: "GET",
                            url: carpeta + "/enviar_correo_autoriza",
                            data: {

                                valerendir_id: valerendir_id
                            },
                            success: function() {
                                console.log('Correo enviado correctamente.');
                            },
                            error: function() {
                                console.warn('Error al enviar el correo.');
                            }
                        });

                            
                            var row = $("tr[data_vale_rendir='" + valerendir_id + "']");
                            row.find("td").eq(7).html('<span class="badge badge-warning">AUTORIZADO</span>'); 
                           
                            location.reload(); 

                            row.find(".autorizar-valerendir").hide();
                            row.find(".aprobar-valerendir").hide();
                            row.find(".rechazar-valerendir").hide();



                            $('#autorizaModal').modal('hide');
                        } else {
                            alerterrorajax('Error al autorizar el vale de rendir.');
                        }
                    },
                    error: function() {
                        alerterrorajax('Error al procesar la solicitud.');
                    }
                });
        });


        $(".valerendirprincipal").on('click', '.registroaprobar-valerendir', function(e) {
            e.preventDefault(); 

            let valerendir_id = $(this).closest('tr').attr('data_vale_rendir'); 
            $('#vale_rendir_id').val(valerendir_id); 
            var _token = $('#token').val();
          //  debugger;
            data                        =   {
                                                _token                  : _token,
                                                valerendir_id           : valerendir_id,
                                            };

            ajax_modal(data,"/aprobarRegistro_vale_rendir",
                      "modal-detalledocumento-solicitud","modal-detalledocumento-solicitud-container");


        });



      /*  $(".valerendirprincipal").on('change', '#cuenta_id', function(e) {
                e.preventDefault(); 
                let nro_serie = $('#cuenta_id').val();
                let _token = $('#token').val();
                //debugger;

                $.ajax({
                  type    :   "POST",
                  url     :   carpeta+"/obtener_correlativo",
                  data    :   {
                                                _token                  : _token,
                                                nro_serie               : nro_serie,
                                            },
               
                     success: function (data) {
                        $('#nrodoc').val(data.nro_doc);
                   
                },
                error: function (data) {
                    error500(data);
                }
            });
        });*/


        $(".valerendirprincipal").on('change', '#radioCaja, #radioEfectivo', function(e) {
            e.preventDefault(); 

            if ($('#radioCaja').is(':checked')) {
               
                $('#selectContainer').show(); 
                
         
                if ($('#nomBanco').val() === '' && $('#numBanco').val() === '') {
                    $('#nomBanco').val($('#nomBanco').data('nombanco'));  
                    $('#numBanco').val($('#numBanco').data('numbanco'));  
                }
            } else {
                $('#selectContainer').hide(); 
                $('#nomBanco').val(''); 
                $('#numBanco').val(''); 
            }
        });


        $(".valerendirprincipal").on('click', '#aprobarvalerendir', function(e) {
             e.preventDefault();

         let _token                  =   $('#token').val();
         let txt_serie               =   $('#cuenta_id').val();
         let txt_numero              =   $('#nrodoc').val();
         let fec_autorizacion        =   $('#fecha').val();
         let cod_contrato            =   $('#cuenta_id_contrato').val();
         //let sub_cuenta              =   $('#cuenta_id_subcuenta option:selected').text();
         let sub_cuenta              =   $('#cuenta_id_subcuenta').val();
         let txt_glosa_autorizado    =   $('#glosaRegistrada').val();
         let tipo_pago_raw           =   $('input[name="tipo_pago"]:checked').val(); 
         let tipo_pago               =   (tipo_pago_raw === 'caja') ? 1 : 0;
         let txt_categoria_banco     =   $('#nomBanco').val();
         let numero_cuenta           =   $('#numBanco').val();
         let txt_glosa_aprobado      =   $('#glosa').val();   
         let vale_rendir_id          = $('#vale_rendir_id').val(); 

       
         
         if (!cod_contrato || !sub_cuenta ) {
                 alerterrorajax("El usuario no cuenta con contrato o sub cuenta.");
            return; 
            }

            $.ajax({
                  type    :   "POST",
                  url     :   carpeta+"/aprobar_vale_rendir",
                  data    :   {
                                _token                                   : _token,
                                txt_serie                                : txt_serie,
                                txt_numero                               : txt_numero,
                                fec_autorizacion                         : fec_autorizacion,
                                cod_contrato                             : cod_contrato,
                                sub_cuenta                               : sub_cuenta,
                                txt_glosa_autorizado                     : txt_glosa_autorizado,
                                tipo_pago                                : tipo_pago,   
                                txt_categoria_banco                      : txt_categoria_banco,
                                numero_cuenta                            : numero_cuenta,
                                txt_glosa_aprobado                       : txt_glosa_aprobado,
                                valerendir_id                            : vale_rendir_id,                                               
                              },
                               
                    success: function (data) {
                    if (data.error) {
                        const mensaje = data.error.includes("Vale de rendir procesado correctamente")
                            ? "Error en aprobar el vale a rendir"
                            : data.error;

                        alerterrorajax(mensaje);
                        return;
                    }

                    alertajax("Vale aprobado correctamente.");
                    
                 // Envío del correo tras la aprobación
                    $.ajax({
                        type: "GET",
                        url: carpeta + "/enviar_correo_aprueba",
                        data: {
                            valerendir_id: vale_rendir_id
                        },
                        success: function () {
                            console.log('Correo de aprobación enviado correctamente.');
                        },
                        error: function () {
                            console.warn('Error al enviar el correo de aprobación.');
                        }
                    });

                    location.reload();
                },
                error: function (data) {
                    error500(data);
                }
            });
        });

    
        $(".valerendirprincipal").on('click', '.verdetalleaprobar-valerendir', function(e) {
            e.preventDefault(); 
            let valerendir_id = $(this).closest('tr').attr('data_vale_rendir'); 
            $('#vale_rendir_id').val(valerendir_id); 
            var _token = $('#token').val();
           
            data                        =   {
                                                _token                  : _token,
                                                valerendir_id           : valerendir_id,
                                            };

            ajax_modal(data,"/verRegistro_vale_rendir",
                      "modal-verdetalledocumento-solicitud","modal-verdetalledocumento-solicitud-container");


        });


        $(".valerendirprincipal").on('click', '.verdetalleimporte-valerendir', function(e) {
            e.preventDefault(); 
            let valerendir_id = $(this).closest('tr').attr('data_vale_rendir'); 

            $('#vale_rendir_id').val(valerendir_id); 
            var _token = $('#token').val();
           
            data                        =   {
                                                _token                  : _token,
                                                valerendir_id           : valerendir_id,
                                            };

            ajax_modal(data, "/ver_detalle_importe",
                       "modal-verdetalledocumentoimporte-solicitud",
                       "modal-verdetalledocumentoimporte-solicitud-container");
        });


        $(".valerendirprincipal").on('click', '.verdetalleimporte-valerendir-autoriza', function(e) {
            e.preventDefault(); 
            let valerendir_id = $(this).closest('tr').attr('data_vale_rendir'); 

            $('#vale_rendir_id').val(valerendir_id); 
            var _token = $('#token').val();
           
            data                        =   {
                                                _token                  : _token,
                                                valerendir_id           : valerendir_id,
                                            };

            ajax_modal(data, "/ver_detalle_importe_autoriza",
                       "modal-verdetalledocumentoimporteautoriza-solicitud",
                       "modal-verdetalledocumentoimporteautoriza-solicitud-container");
        });


        $(".valerendirprincipal").on('click', '.verdetalleimporte-valerendir-vale', function(e) {
            e.preventDefault(); 
            let valerendir_id = $(this).closest('tr').attr('data_vale_rendir'); 

            $('#vale_rendir_id').val(valerendir_id); 
            var _token = $('#token').val();
           
            data                        =   {
                                                _token                  : _token,
                                                valerendir_id           : valerendir_id,
                                            };

            ajax_modal(data, "/ver_detalle_importe_vale",
                       "modal-verdetalledocumentoimportevale-solicitud",
                       "modal-verdetalledocumentoimportevale-solicitud-container");
        });







        $(document).on("click", ".show-glosa", function() {
            var glosaText = $(this).data('glosa');
            var type = $(this).data('type');

            if (type === "rechazo") {
                    $("#glosaRechazoMessage").text(glosaText);
                    $('#glosaModal').modal('show');
            } else if (type === "autoriza") {
                    $("#glosaAutorizaMessage").text(glosaText);
                    $('#glosaModal1').modal('show');
            }
        });



    //DETALLE
     
        $('#tipo_motivo').on('change', function() {
            var valorSeleccionado = $(this).find('option:selected').text().toUpperCase().trim();

            if (valorSeleccionado === 'GASTOS DE VIAJE O VIATICOS') {
                $('#vale_rendir_detalle').show();

             $('#can_total_importe').prop('readonly', true);
            $('#can_total_saldo').prop('readonly', true);
                
            } else {
                $('#vale_rendir_detalle').hide(); 

                $('#detalle_motivo').val('').trigger('change');
               

            }
        });

        function convertirFecha(fechaStr) {
            const partes = fechaStr.split('/');
            return `${partes[2]}-${partes[1]}-${partes[0]}`;
        }

        var importeDestinos = JSON.parse($('#importeDestinos').val());
        $('#agregarImporteGasto').on('click', function () {
            let destino = $('#destino option:selected').text();
            let codDestino = $('#destino').val();
            let fechaInicio = $('#fecha_inicio').val();
            let fechaFin = $('#fecha_fin').val();
            let nomCentro = $('#nom_centro').val();
            let ind_propio = $('#ind_propio').is(':checked') ? 1 : 0;
            let ind_aereo = $('#ind_aereo').is(':checked') ? 1 : 0;


            if (!codDestino || !fechaInicio || !fechaFin ) {
                alerterrorajax('Por favor complete todos los campos antes de agregar.');
                return;
            }

            if (new Date(fechaInicio) > new Date(fechaFin)) {
                alerterrorajax('La fecha de fin debe ser igual o mayor que la fecha de inicio.');
                return;
            }

            let filas = $('#tabla_vale_rendir_detalle tbody tr');
            if (filas.length > 0) {
                let ultimaFila = filas.last();
                let fechaFinUltima = ultimaFila.find('td').eq(1).text(); 
                let fechaFinUltimaDate = new Date(fechaFinUltima);
                let nuevaFechaInicioDate = new Date(fechaInicio);

                if (nuevaFechaInicioDate < fechaFinUltimaDate) {
                    alerterrorajax('La fecha de inicio debe ser igual o mayor a la fecha fin del registro anterior.');
                    return;
                }
            }

            // Validar que no se repita el mismo codDestino
            let destinoYaExiste = false;
            filas.each(function () {
                if ($(this).data('cod-destino') === codDestino) {
                    destinoYaExiste = true;
                    return false; // salir del each
                }
            });

            if (destinoYaExiste) {
                alerterrorajax('Este destino ya ha sido agregado.');
                return;
            }
            let destinoObj = importeDestinos.find(destino => destino.COD_DISTRITO === codDestino);
            let ind_destino = destinoObj?.IND_DESTINO || 0;


            let fecha1 = new Date(convertirFecha(fechaInicio));
            let fecha2 = new Date(convertirFecha(fechaFin));

            let diffTime = fecha2.getTime() - fecha1.getTime();
            let baseDiffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
            let diffDays = 0;


            if (ind_propio === 1) {
                // Siempre contar al menos 1 día
                if (baseDiffDays <= 1) {
                    diffDays = 1;
                } else {
                    diffDays = baseDiffDays;
                }
            } else {
                if (destinoObj?.IND_DESTINO == "1") {
                    diffDays = baseDiffDays + 1;
                } else {
                    diffDays = baseDiffDays > 0 ? baseDiffDays : 1;
                }
            }


            let total_Importe = 0;
            let nombresTipos = [];
            let importesCalculados = [];
            let valoresBase = [];
        

            if (destinoObj && destinoObj.TXT_NOM_TIPO) {
            let tipos = destinoObj.TXT_NOM_TIPO.split(',');
            tipos.forEach(tipoStr => {
            let [nombre, valorStr] = tipoStr.trim().split(':');
            let valor = parseFloat(valorStr.trim());
            let tipoImporte = 0;

            if (nombre === "COMBUSTIBLE + PEAJES" && ind_propio !== 1) {
                return;
            }

             if (ind_propio === 1 && !["HOSPEDAJE", "ALIMENTACION","COMBUSTIBLE + PEAJES"].includes(nombre)) {
             return; // saltar a la siguiente iteración
            }

            let filasExistentes = $('#tabla_vale_rendir_detalle tbody tr').length;

            if (nombre === "PASAJES TERRESTRES") {
            if (ind_aereo === 1) {
                return; // No agregar PASAJES TERRESTRES si es movilidad aérea
            }
            tipoImporte = filasExistentes === 0 ? valor * 2 : valor;

           } else if (["HOSPEDAJE", "ALIMENTACION", "PASAJES INTERNOS"].includes(nombre)) {

            if (nombre === "ALIMENTACION" && ind_propio === 1) {
                // ✅ ALIMENTACIÓN destino propio: suma 1 día si diffDays >= 2
                tipoImporte = valor * (diffDays >= 2 ? (diffDays + 1) : 1);

            } else if (nombre === "HOSPEDAJE" && ind_propio === 1) {
                // ✅ HOSPEDAJE destino propio: solo por los días
                tipoImporte = valor * diffDays;

            } else if (filasExistentes === 0) {
                // ✅ Primera fila, lógica completa
                if (nombre === "HOSPEDAJE" && destinoObj?.IND_DESTINO === "0") {
                    tipoImporte = valor * diffDays;
                } else {
                    tipoImporte = valor * diffDays;
                }

            } else {
                // Para otras combinaciones
               tipoImporte = valor * diffDays;
            }


            } else if (nombre === "PASAJES INTERPROVINCIAL") {
                // Solo valor base en el primer destino; luego 0
                tipoImporte = filasExistentes === 0 ? valor : 0;

            } else {
                tipoImporte = valor;
            }

            total_Importe += tipoImporte;

            nombresTipos.push(nombre);
            importesCalculados.push(`S/. ${tipoImporte.toFixed(2)}`);
            valoresBase.push(`S/. ${valor.toFixed(2)}`);
        });


        
        let filas = $('#tabla_vale_rendir_detalle tbody tr');
        if (filas.length >= 1) {
            let primeraFila = filas.eq(0);
            let $tds = primeraFila.find('td');

            // Asegurar que hay al menos 7 columnas
            if ($tds.length >= 7) {
                let nombres = $tds.eq(3).html().split(/<br\s*\/?>/).map(s => s.trim());
                let valores = $tds.eq(5).html().split(/<br\s*\/?>/).map(s => s.trim());
                let importes = $tds.eq(6).html().split(/<br\s*\/?>/).map(s => s.trim());
                let total = 0;

                let importesActualizados = nombres.map((nombreTipo, i) => {
                    let base = parseFloat(valores[i].replace('S/.', '').trim()) || 0;
                    let nuevoImporte = parseFloat(importes[i].replace('S/.', '').trim()) || 0;

                    if (nombreTipo === "PASAJES TERRESTRES") {
                        nuevoImporte = base; // *1 (en vez de *2)
                    }

                    total += nuevoImporte;
                    return `S/. ${nuevoImporte.toFixed(2)}`;
                });

                $tds.eq(6).html(importesActualizados.join('<br/>'));
                $tds.eq(7).text(total.toFixed(2));
            }
        }
    }
        
        let nuevaFila = `
                <tr data-cod-destino="${codDestino}" data-id="">
                    <td>${fechaInicio}</td>
                    <td>${fechaFin}</td>
                    <td>${destino}</td>
                    <td>${nombresTipos.join('<br/>')}</td>    
                    <td>${diffDays}</td>         
                    <td>${valoresBase.join('<br/>')}</td>               
                    <td>${importesCalculados.join('<br/>')}</td> 
                    <td>${total_Importe.toFixed(2)}</td>   
                    <td style="display:none;">${ind_destino}</td>
                    <td style="display:none;">${ind_propio}</td>
                    <td style="display:none;">${ind_aereo}</td>
                    <td><button type="button" class="btn btn-danger btn-sm eliminarFila"><i class="fa fa-trash"></i></button></td>
                </tr>
            `;

            $('#tabla_vale_rendir_detalle tbody').append(nuevaFila);
            actualizarTotalImporte();
        });



        
        $('#tabla_vale_rendir_detalle').on('click', '.eliminarFila', function () {
            $(this).closest('tr').remove();

            setTimeout(() => {
                let filas = $('#tabla_vale_rendir_detalle tbody tr');
                if (filas.length === 1) {
                    let primeraFila = filas.eq(0);
                    let $tds = primeraFila.find('td');

                    if ($tds.length >= 7) {
                        let nombres = $tds.eq(3).html().split(/<br\s*\/?>/).map(s => s.trim());
                        let valores = $tds.eq(5).html().split(/<br\s*\/?>/).map(s => s.trim());
                        let importes = $tds.eq(6).html().split(/<br\s*\/?>/).map(s => s.trim());
                        let total = 0;

                        let importesActualizados = nombres.map((nombreTipo, i) => {
                            let base = parseFloat(valores[i].replace('S/.', '').trim()) || 0;
                            let nuevoImporte = parseFloat(importes[i].replace('S/.', '').trim()) || 0;

                            if (nombreTipo === "PASAJES TERRESTRES") {
                                nuevoImporte = base * 2;
                            }

                            total += nuevoImporte;
                            return `S/. ${nuevoImporte.toFixed(2)}`;
                        });

                        $tds.eq(6).html(importesActualizados.join('<br/>'));
                        $tds.eq(7).text(total.toFixed(2));
                    }
                }

                actualizarTotalImporte();
            }, 0);
        });





         function actualizarTotalImporte() {
            let suma = 0;
            $('#tabla_vale_rendir_detalle tbody tr').each(function () {
                let importe = parseFloat($(this).find('td').eq(7).text()) || 0;
                suma += importe;
            });

            $('#suma_total_importe').text(suma.toFixed(2));

            // Solo llenar el campo si el motivo es "GASTOS DE VIAJE O VIATICOS"
            let valorMotivo = $('#tipo_motivo option:selected').text().toUpperCase().trim();
            if (valorMotivo === 'GASTOS DE VIAJE O VIATICOS') {
                $('#can_total_importe').val(suma.toFixed(2));
                 $('#can_total_saldo').val(suma.toFixed(2));
            }
        }


       $(document).on('click', '.verdetalleimportegastos-valerendir', function () {
        let filas = $('#tabla_vale_rendir_detalle tbody tr');
        let cuerpoModal = $('#tablaDetalleModal tbody');

        cuerpoModal.empty();

        let sumaTotal = 0;

        filas.each(function () {
            let fechaInicio = $(this).find('td').eq(0).text();
            let fechaFin = $(this).find('td').eq(1).text();
            let destino = $(this).find('td').eq(2).text();
            let tipos = $(this).find('td').eq(3).html(); 
            let dias = $(this).find('td').eq(4).text();
            let valores = $(this).find('td').eq(5).html();          
            let importes = $(this).find('td').eq(6).html();
            let totalImporte = parseFloat($(this).find('td').eq(7).text()) || 0;
            

            sumaTotal += totalImporte;

            let filaModal = `
                <tr class="text-center">
                    <td>
                        <strong>${destino}</strong><br/>
                        <small>${fechaInicio} al ${fechaFin} (${dias} día(s))</small>
                    </td>
                    <td><div class="text-center">${tipos}</div></td>
                    <td><div class="text-center text-primary fw-semibold">${valores}</div></td>
                    <td><div class="text-center text-success fw-semibold">${importes}</div></td>
                    <td><span class="badge bg-secondary">S/ ${totalImporte.toFixed(2)}</span></td>
                </tr>
            `;

            cuerpoModal.append(filaModal);
        });

           
            let filaTotal = `
                <tr class="table-warning fw-bold text-center">
                 <td colspan="4" class="text-end fw-bold"><strong>TOTAL GENERAL (S/)</strong></td>
                 <td><span class="badge bg-primary fs-6">S/ ${sumaTotal.toFixed(2)}</span></td>
                </tr>
            `;

            cuerpoModal.append(filaTotal);

            $('#modalDetalleImportes').modal('show');
        });


       $(document).ready(function () {
            $('#vale tbody').on('click', 'tr', function () {    
                $('#vale tbody tr').removeClass('selected');
                $(this).addClass('selected');
            });
        });

});







   /* $(".valerendirprincipal").on('click', '.autorizar-valerendir', function(e) {
        e.preventDefault();
        
        var valerendir_id = $(this).closest('tr').attr('data_vale_rendir');
        var _token = $('#token').val();

   
            $.ajax({
                type: "POST",
                url: carpeta + "/autorizar_vale_rendir",
                data: {
                    _token: _token,
                    valerendir_id: valerendir_id
                }, 
                success: function(response) {       
                    if (response.success) {           
                   //     $('tr[data_vale_rendir="'+valerendir_id+'"]').remove();           
                       location.reload();                     
                    } else {
                        alerterrorajax('Error al autorizar el vale de rendir.');
                    }
                },
                error: function(data) {
                    alerterrorajax('Error al autorizar el vale de rendir.');                   
                }
            });     
         });
*/




      /*  $(".valerendirprincipal").on('click', '#asignarvalerendirosiris', function (e) {
        e.preventDefault();

            let vale_rendir_id = $('#vale_rendir_id').val(); 
            let _token = $('#token').val();

            //console.log($('#vale_rendir_id').val());
            
            $.ajax({
                type: "POST",
                url: carpeta + "/insertar-osiris",
                data: {
                    _token: _token,
                    valerendir_id: vale_rendir_id
                },
               
                success: function (data) {
                    if (data.error) {
                        if (data.error.includes("Vale de rendir procesado correctamente")) {
                            alerterrorajax("El vale a rendir ya ha sido autorizado y no puede modificarse.");
                        } else {
                            alerterrorajax(data.error); 
                        }
                    } else if (data.success) {
                        alertajax(data.success);
                        location.reload();
                    }
                },
                error: function (xhr) {
                    error500(xhr);
                },
            });
        });*/




  /*data    =   {
                              _token                                   : _token,
                                usuario_autoriza                         : usuario_autoriza,
                                usuario_aprueba                          : usuario_aprueba,
                                tipo_motivo                              : tipo_motivo,
                                txt_glosa                                : txt_glosa,
                                can_total_importe                        : can_total_importe,
                                can_total_saldo                          : can_total_saldo,
                                vale_rendir_id                           : vale_rendir_id,
                                opcion                                   : opcion,
                                array_detalle                            : detalles
                                                                                                          
                              };

            ajax_normal_combo(data,"/registrar_vale_rendir","listadetalleajax")  */



