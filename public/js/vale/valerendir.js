
$(document).ready(function(){

    var carpeta = $("#carpeta").val();


    $(".valerendirprincipal").on('click', '#asignarvalerendir', function(e) {
        let _token = $('#token').val();
        let usuario_autoriza = $('#cliente_select').val();
        let usuario_aprueba = $('#cliente_select1').val();
        let tipo_motivo = $('#tipo_motivo').val();
        let txt_glosa = $('#txt_glosa').val();
        let can_total_importe = $('#can_total_importe').val();
        let can_total_saldo = $('#can_total_saldo').val();
        let cod_moneda = $('#cod_moneda').val();
        let vale_rendir_id = $('#vale_rendir_id').val();

        let opcion = !vale_rendir_id ? 'I' : 'U';

       let pendientes = 0;
        $("#vale tbody tr").each(function () {
            let estadoMerge = $(this).find("td").eq(7).text().trim().toUpperCase();
            let estadoOsiris = $(this).find("td").eq(8).text().trim().toUpperCase();

            if ((!estadoOsiris || estadoOsiris === "NULL") && estadoMerge !== "RECHAZADO" && estadoMerge !== "ANULADO") {
                pendientes++;
            }
        });

        if (pendientes >= 2) {
            alerterrorajax("Tienes dos registros pendientes por aprobar.");
            return;
        }


        if (!usuario_autoriza) {
            alerterrorajax("El campo 'Usuario Autoriza' es obligatorio.");
            return;
        }

        if (!tipo_motivo) {
            alerterrorajax("El campo 'Tipo de Motivo' es obligatorio.");
            return;
        }

        if (!cod_moneda) {
            alerterrorajax("El campo 'Moneda' es obligatorio.");
            return;
        }

        if (!can_total_importe) {
            alerterrorajax("El campo 'Total Importe' es obligatorio.");
            return;
        }

        if (!can_total_saldo) {
            alerterrorajax("El campo 'Total Saldo' es obligatorio.");
            return;
        }

        if (!txt_glosa) {
            alerterrorajax("El campo 'Glosa' es obligatorio.");
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

        let detalles = [];
        $('#tabla_vale_rendir_detalle tbody tr').each(function () {
            let fila = $(this);
            detalles.push({
                fec_inicio: fila.find('td').eq(0).text().trim(),
                fec_fin: fila.find('td').eq(1).text().trim(),
                cod_destino: fila.data('cod-destino'),
                nom_destino: fila.find('td').eq(2).text().trim(),
                nom_tipos: fila.find('td').eq(3).html().split('<br/>').join(','),
                dias: parseInt(fila.find('td').eq(4).text().trim()) || 0,
                can_unitario: fila.find('td').eq(5).html().split('<br/>').join(','),
                can_unitario_total: fila.find('td').eq(6).html().split('<br/>').join(','),
                can_total_importe: parseFloat(fila.find('td').eq(7).text().trim()) || 0,
                ind_destino: parseInt(fila.find('td').eq(8).text().trim()) || 0,
                ind_propio: parseInt(fila.find('td').eq(9).text().trim()) || 0,
                ind_aereo: parseInt(fila.find('td').eq(10).text().trim()) || 0,
                opcion_detalle: 'I',
                detalle_id: fila.data('id')
            });
        });

        abrircargando();

        $.ajax({
            type: "POST",
            url: carpeta + "/registrar_vale_rendir",
            data: {
                _token: _token,
                usuario_autoriza: usuario_autoriza,
                usuario_aprueba: usuario_aprueba,
                tipo_motivo: tipo_motivo,
                txt_glosa: txt_glosa,
                can_total_importe: can_total_importe,
                can_total_saldo: can_total_saldo,
                cod_moneda: cod_moneda,
                vale_rendir_id: vale_rendir_id,
                opcion: opcion,
                array_detalle: detalles
            },
            success: function (data) {
                if (data.error) {
                    if (data.error.includes("Vale de rendir procesado correctamente")) {
                        alerterrorajax("El vale a rendir ya ha sido autorizado y no puede modificarse.");
                    } else {
                        alerterrorajax(data.error);
                    }
                    return;
                }

                let nuevo_vale_id = data.vale_rendir_id || vale_rendir_id;
                let data_modal = {
                    _token: _token,
                    valerendir_id: nuevo_vale_id
                };

                // Segundo AJAX: enviar correo
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

                        setTimeout(function () {
                            ajax_modal(
                                data_modal,
                                "/ver_mensaje_vale_rendir",
                                "modal-verdetalledocumentomensajevale-solicitud",
                                "modal-verdetalledocumentomensajevale-solicitud-container"
                            );
                            // Forzar recarga al cerrar modal, incluso si no es bootstrap puro
                            const modal = $("#modal-verdetalledocumentomensajevale-solicitud");
                            modal.on('hide.bs.modal', function () {
                                location.reload();
                            });
                        }, 500);
                    },
                    error: function() {
                        alertajax("Vale registrado, pero ocurrió un error al enviar el correo.");

                        setTimeout(function () {
                            ajax_modal(
                                data_modal,
                                "/ver_mensaje_vale_rendir",
                                "modal-verdetalledocumentomensajevale-solicitud",
                                "modal-verdetalledocumentomensajevale-solicitud-container"
                            );


                            // Forzar recarga al cerrar modal, incluso si no es bootstrap puro
                            const modal = $("#modal-verdetalledocumentomensajevale-solicitud");
                            modal.on('hide.bs.modal', function () {
                                location.reload();
                            });
                        }, 500);
                    }
                });
            },
            error: function (data) {
                error500(data);
            }
        });
    });


        $(document).on('click', '.modal-close-recargar', function () {
            setTimeout(function () {
                location.reload();
            }, 300);
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
                    $('#btntexto').text('Modificar');

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
         let sub_cuenta              =   $('#cuenta_id_subcuenta').val();
         let txt_glosa_autorizado    =   $('#glosaRegistrada').val();
         let tipo_pago_raw           =   $('input[name="tipo_pago"]:checked').val(); 
         let tipo_pago               =   (tipo_pago_raw === 'caja') ? 1 : 0;
         let txt_categoria_banco     =   $('#nomBanco').val();
         let numero_cuenta           =   $('#numBanco').val();
         let txt_glosa_aprobado      =   $('#glosa').val();   
         let vale_rendir_id          =   $('#vale_rendir_id').val(); 

       
         
         if (!cod_contrato || !sub_cuenta ) {
                 alerterrorajax("El usuario no cuenta con contrato o sub cuenta.");
            return; 
            }

         if (tipo_pago === 1) {
            if (!numero_cuenta || !txt_categoria_banco) {
            alerterrorajax("La cuenta es en Dólares, debe ingresar la entidad bancaria y el número de cuenta.");
            return; 
            }
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




         $(".valerendirprincipal").on('click', '.vermensaje-valerendir', function(e) {
            e.preventDefault(); 
            //let valerendir_id = $(this).closest('tr').attr('data_vale_rendir'); 
            //$('#vale_rendir_id').val(valerendir_id); 
            var _token = $('#token').val();
           
            data                        =   {
                                                _token                  : _token,
                                                //valerendir_id           : valerendir_id,
                                            };

            ajax_modal(data,"/ver_mensaje_vale_rendir",
                      "modal-verdetalledocumentomensajevale-solicitud","modal-verdetalledocumentomensajevale-solicitud-container");

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
        $('#tipo_motivo').on('change', function () {
            var valorSeleccionado = $(this).find('option:selected').text().toUpperCase().trim();

            if (valorSeleccionado === 'GASTOS DE VIAJE O VIATICOS') {
                $('#vale_rendir_detalle').show();

                // 🧹 Limpia campos antes de ponerlos como readonly
                $('#can_total_importe').val('');
                $('#can_total_saldo').val('');

                // 🔒 Poner campos como solo lectura
                $('#can_total_importe').prop('readonly', true);
                $('#can_total_saldo').prop('readonly', true);

            } else {
                $('#vale_rendir_detalle').hide();

                // Limpia campo detalle motivo
                $('#detalle_motivo').val('').trigger('change');

                // 🔓 Habilita los campos de importes y limpia valores
                $('#can_total_importe').prop('readonly', false).val('');
                $('#can_total_saldo').prop('readonly', false).val('');

                // 🧹 Limpia la tabla de detalles
                $('#tabla_vale_rendir_detalle tbody').empty();

                // 🧹 Limpia campos del detalle
                $('#fecha_inicio').val('');
                $('#fecha_fin').val('');
                $('#destino').val('').trigger('change');
                $('#nom_centro').val('');

                // 🔄 Desmarca checkboxes
                $('#ind_propio').prop('checked', false);
                $('#ind_aereo').prop('checked', false);

                // 🔄 Recalcula totales
                actualizarTotalImporte();
            }
        });



        function convertirFecha(fechaStr) {
            const partes = fechaStr.split('/');
            return `${partes[2]}-${partes[1]}-${partes[0]}`;
        }

        $(document).ready(function () {
            let hoy = new Date();
            let fechaMin = new Date(hoy);
            fechaMin.setDate(hoy.getDate() - 7);

            let yyyy = fechaMin.getFullYear();
            let mm = String(fechaMin.getMonth() + 1).padStart(2, '0');
            let dd = String(fechaMin.getDate()).padStart(2, '0');

            let minDateStr = `${yyyy}-${mm}-${dd}`;

            $('#fecha_inicio').attr('min', minDateStr);
            $('#fecha_fin').attr('min', minDateStr);
        });


        var importeDestinos = JSON.parse($('#importeDestinos').val());
     
       // 🔹 Mapeo código -> nombre para mostrar al usuario
        const codigosNombres = {
            "TIG0000000000001": "ALIMENTACION",
            "TIG0000000000002": "ALOJAMIENTO",
            "TIG0000000000003": "MOVILIDAD LOCAL",
            "TIG0000000000004": "PASAJES INTERDEPARTAMENTALES",
            "TIG0000000000005": "PASAJES INTERPROVINCIAL",
            "TIG0000000000006": "COMBUSTIBLE",
            "TIG0000000000007": "PEAJES",
            "TIG0000000000008": "MANTENIMIENTO DE VEHICULOS"
        };

        $('#agregarImporteGasto').on('click', function () {
            let destino = $('#destino option:selected').text();
            let codDestino = $('#destino').val();
            let fechaInicio = $('#fecha_inicio').val();
            let fechaFin = $('#fecha_fin').val();
            let nomCentro = $('#nom_centro').val();
            let ind_propio = $('#ind_propio').is(':checked') ? 1 : 0;
            let ind_aereo = $('#ind_aereo').is(':checked') ? 1 : 0;

            // Validaciones de campos obligatorios
            if (!codDestino || !fechaInicio || !fechaFin) {
                alerterrorajax('Por favor complete todos los campos antes de agregar.');
                return;
            }

            if (new Date(fechaInicio) > new Date(fechaFin)) {
                alerterrorajax('La fecha de fin debe ser igual o mayor que la fecha de inicio.');
                return;
            }

            // Validar fecha contra la última fila
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
                diffDays = (baseDiffDays <= 1) ? 1 : baseDiffDays;
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

            // Procesar tipos de gasto (ahora por código)
           if (destinoObj && destinoObj.COD_TIPO) {
            let tipos = destinoObj.COD_TIPO.split(',');
                tipos.forEach(tipoStr => {
                    let [codigoTipo, valorStr] = tipoStr.trim().split(':');
                    let valor = parseFloat(valorStr.trim());
                    let tipoImporte = 0;

                    let nombre = codigosNombres[codigoTipo] || codigoTipo;
                    let filasExistentes = $('#tabla_vale_rendir_detalle tbody tr').length;

                    // COMBUSTIBLE + PEAJES (TIG0006 y TIG0007)
                    if ((codigoTipo === "TIG0000000000006" || codigoTipo === "TIG0000000000007") && ind_propio !== 1) {
                        return; 
                    }

                    // Filtro para destino propio
                    if (ind_propio === 1 && ![
                        "TIG0000000000001", // ALIMENTACION
                        "TIG0000000000002", // ALOJAMIENTO
                        "TIG0000000000006", // COMBUSTIBLE
                        "TIG0000000000007"  // PEAJES
                    ].includes(codigoTipo)) {
                        return; 
                    }

                    // PASAJES TERRESTRES (TIG0004)
                    if (codigoTipo === "TIG0000000000004") {
                        if (ind_aereo === 1) return; 
                        tipoImporte = filasExistentes === 0 ? valor * 2 : valor;
                    }

                    // ALIMENTACION, ALOJAMIENTO, MOVILIDAD LOCAL
                    else if (["TIG0000000000001", "TIG0000000000002", "TIG0000000000003"].includes(codigoTipo)) {
                        if (codigoTipo === "TIG0000000000001" && ind_propio === 1) {
                            tipoImporte = valor * (diffDays >= 2 ? (diffDays + 1) : 1);
                        } else if (codigoTipo === "TIG0000000000002" && ind_propio === 1) {
                            tipoImporte = valor * diffDays;
                        } else if (filasExistentes === 0) {
                            tipoImporte = valor * diffDays;
                        } else {
                            tipoImporte = valor * diffDays;
                        }
                    }

                    // PASAJES INTERPROVINCIAL (TIG0005)
                    else if (codigoTipo === "TIG0000000000005") {
                        tipoImporte = filasExistentes === 0 ? valor : 0;
                    }

                    // Otros casos
                    else {
                        tipoImporte = valor;
                    }

                    total_Importe += tipoImporte;
                    nombresTipos.push(nombre); // usuario ve nombre
                    importesCalculados.push(`S/. ${tipoImporte.toFixed(2)}`);
                    valoresBase.push(`S/. ${valor.toFixed(2)}`);
                });

                // Ajustar primera fila si corresponde
                let filasTabla = $('#tabla_vale_rendir_detalle tbody tr');
                if (filasTabla.length >= 1) {
                    let primeraFila = filasTabla.eq(0);
                    let $tds = primeraFila.find('td');

                    if ($tds.length >= 7) {
                        let nombres = $tds.eq(3).html().split(/<br\s*\/?>/).map(s => s.trim());
                        let valores = $tds.eq(5).html().split(/<br\s*\/?>/).map(s => s.trim());
                        let importes = $tds.eq(6).html().split(/<br\s*\/?>/).map(s => s.trim());
                        let total = 0;

                        let importesActualizados = nombres.map((nombreTipo, i) => {
                            let base = parseFloat(valores[i].replace('S/.', '').trim()) || 0;
                            let nuevoImporte = parseFloat(importes[i].replace('S/.', '').trim()) || 0;

                            if (nombreTipo === codigosNombres["TIG0000000000004"]) {
                                nuevoImporte = base; // *1 en vez de *2
                            }

                            total += nuevoImporte;
                            return `S/. ${nuevoImporte.toFixed(2)}`;
                        });

                        $tds.eq(6).html(importesActualizados.join('<br/>'));
                        $tds.eq(7).text(total.toFixed(2));
                    }
                }
            }

            // Agregar nueva fila
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

            // Asignar fecha inicio con fecha fin del último registro
            let ultimaFila = $('#tabla_vale_rendir_detalle tbody tr').last();
            let fechaFinUltima = ultimaFila.find('td').eq(1).text().trim();
            $('#fecha_inicio').val(fechaFinUltima);

            // Limpiar otros campos
            $('#fecha_fin').val('');
            $('#destino').val('').trigger('change');
            $('#ind_propio').prop('checked', false);
            $('#ind_aereo').prop('checked', false);
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



