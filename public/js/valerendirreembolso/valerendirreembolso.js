$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    $(".valerendirprincipal").on('click', '#asignarvalerendir', function (e) {
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
                url: carpeta + "/registrar_vale_rendir_reembolso",
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
                    cerrarcargando();
                    if (data.error) {
                        if (data.error.includes("Vale de rendir procesado correctamente")) {
                            $.alert({
                                title: 'Error',
                                content: 'El vale a rendir ya ha sido autorizado y no puede modificarse.',
                                type: 'red',
                                buttons: {
                                    ok: {
                                        text: 'OK',
                                        btnClass: 'btn-red',
                                    }
                                }
                            });
                        } else {
                            $.alert({
                                title: '',
                                content: `
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <div style="font-size: 35px; color: #e74c3c;">&#9888;</div>
                                        <div>
                                            <strong style="color: #e74c3c; font-size: 18px;">¡Error!</strong>
                                            <p style="margin: 8px 0 0; font-size: 15px; color: #333;">${data.error}</p>
                                        </div>
                                    </div>
                                `,
                                type: 'red',
                                typeAnimated: true,
                                boxWidth: '400px',  
                                useBootstrap: false,
                                backgroundDismiss: true,
                                buttons: {
                                    ok: {
                                        text: 'Aceptar',
                                        btnClass: 'btn-red',
                                    }
                                }
                            });
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
                        data: {valerendir_id: nuevo_vale_id},
                        success: function (response) {
                            if (response.success) {

                              alertajax("Vale a rendir registrado y correo enviado correctamente.");

                            } else {

                                $.alert({
                                    title: 'warning',
                                    content: 'Vale registrado, pero no se pudo enviar el correo.',
                                    type: 'yellow',
                                    buttons: {
                                        ok: {
                                            text: 'OK',
                                            btnClass: 'btn-yellow',
                                        }
                                    }
                                });

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
                        error: function () {
                            $.alert({
                                title: 'warning',
                                content: 'Vale registrado, pero ocurrió un error al enviar el correo.',
                                type: 'yellow',
                                buttons: {
                                    ok: {
                                        text: 'OK',
                                        btnClass: 'btn-yellow',
                                    }
                                }
                            });

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



      

        $(document).ready(function () {
            let hoy = new Date();
            let fechaMin = new Date(hoy);
            fechaMin.setDate(hoy.getDate() - 7);

            // 🔧 Función para formatear en "YYYY-MM-DDTHH:mm"
            function toLocalDatetimeStr(date) {
                const yyyy = date.getFullYear();
                const mm = String(date.getMonth() + 1).padStart(2, '0');
                const dd = String(date.getDate()).padStart(2, '0');
                const hh = String(date.getHours()).padStart(2, '0');
                const min = String(date.getMinutes()).padStart(2, '0');
                return `${yyyy}-${mm}-${dd}T${hh}:${min}`;
            }

            let minDateStr = toLocalDatetimeStr(fechaMin);

            $('#fecha_inicio').attr('min', minDateStr);
            $('#fecha_fin').attr('min', minDateStr);
        });

        function formatToSQLDateTime(fechaLocal) {
            if (!fechaLocal) return null; 
            return fechaLocal.replace("T", " ") + ":00"; 
        }


        var importeDestinos = JSON.parse($('#importeDestinos').val());
     
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
       
        let fechaInicio = formatToSQLDateTime($('#fecha_inicio').val());
        let fechaFin    = formatToSQLDateTime($('#fecha_fin').val());
        let nomCentro = $('#nom_centro').val();
        let ind_propio = $('#ind_propio').is(':checked') ? 1 : 0;
        let ind_aereo = $('#ind_aereo').is(':checked') ? 1 : 0;
        console.log(fechaInicio, fechaFin);

        // Validaciones de campos obligatorios
        if (!codDestino || !fechaInicio || !fechaFin) {
            alerterrorajax('Por favor complete todos los campos antes de agregar.');
            return;
        }

        let fecha1 = new Date(fechaInicio);
        let fecha2 = new Date(fechaFin);

        if (fecha1 > fecha2) {
            alerterrorajax('La fecha de fin debe ser igual o mayor que la fecha de inicio.');
            return;
        }

        // Validar fecha contra la última fila
        let filas = $('#tabla_vale_rendir_detalle tbody tr');
        if (filas.length > 0) {
            let ultimaFila = filas.last();
            let fechaFinUltima = new Date(ultimaFila.find('td').eq(1).text());
            if (fecha1 < fechaFinUltima) {
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

        // 🔹 Calcular días correctamente con datetime-local
        let diffTime = fecha2 - fecha1; // milisegundos
        let baseDiffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)); // días completos
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

        // 🔹 Procesar importes y tipos de gasto
        let total_Importe = 0;
        let nombresTipos = [];
        let importesCalculados = [];
        let valoresBase = [];

        if (destinoObj && destinoObj.COD_TIPO) {
            let tipos = destinoObj.COD_TIPO.split(',');
            tipos.forEach(tipoStr => {
                let [codigoTipo, valorStr] = tipoStr.trim().split(':');
                let valor = parseFloat(valorStr.trim());
                let tipoImporte = 0;

                let nombre = codigosNombres[codigoTipo] || codigoTipo;
                let filasExistentes = filas.length;

                // COMBUSTIBLE + PEAJES
                if ((codigoTipo === "TIG0000000000006" || codigoTipo === "TIG0000000000007") && ind_propio !== 1) return;

                // Filtro para destino propio
                if (ind_propio === 1 && !["TIG0000000000001","TIG0000000000002","TIG0000000000006","TIG0000000000007"].includes(codigoTipo)) return;

                // PASAJES TERRESTRES
                if (codigoTipo === "TIG0000000000004") {
                    if (ind_aereo === 1) return;
                    tipoImporte = filasExistentes === 0 ? valor * 2 : valor;
                }
                // ALIMENTACION, ALOJAMIENTO, MOVILIDAD LOCAL
                else if (["TIG0000000000001","TIG0000000000002","TIG0000000000003"].includes(codigoTipo)) {
                    if (codigoTipo === "TIG0000000000001" && ind_propio === 1) tipoImporte = valor * (diffDays >= 2 ? (diffDays + 1) : 1);
                    else if (codigoTipo === "TIG0000000000002" && ind_propio === 1) tipoImporte = valor * diffDays;
                    else tipoImporte = valor * diffDays;
                }
                // PASAJES INTERPROVINCIAL
                else if (codigoTipo === "TIG0000000000005") {
                    let pasajeYaAgregado = false;
                    filas.each(function () {
                        let nombres = $(this).find('td').eq(3).html();
                        if (nombres && nombres.includes(codigosNombres["TIG0000000000005"])) {
                            pasajeYaAgregado = true;
                            return false;
                        }
                    });
                    tipoImporte = pasajeYaAgregado ? 0 : valor;
                }
                // Otros casos
                else tipoImporte = valor;

                total_Importe += tipoImporte;
                nombresTipos.push(nombre);
                importesCalculados.push(`S/. ${tipoImporte.toFixed(2)}`);
                valoresBase.push(`S/. ${valor.toFixed(2)}`);
            });
        }

    // 🔹 Agregar fila a la tabla
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

            // Actualizar fecha_inicio con fecha_fin de la última fila
            $('#fecha_inicio').val(fechaFin);
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
                        <small>${fechaInicio} al <br/> ${fechaFin} (${dias} día(s))</small>
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
