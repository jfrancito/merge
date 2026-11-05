
$(document).ready(function() {
    let autoQueryOnLoad = false;
    // Referencias a Modales
    const modalComprobantesEl = document.getElementById('modalBuscarComprobantes');
    const modalProductosEl = document.getElementById('modalBuscarProductos');
    const modalMtcTranspEl = document.getElementById('modalMtcTransportista');
    
    // Inicializar instancias si existen
    const modalComprobantes = modalComprobantesEl ? bootstrap.Modal.getOrCreateInstance(modalComprobantesEl) : null;
    const modalProductos = modalProductosEl ? bootstrap.Modal.getOrCreateInstance(modalProductosEl) : null;
    const modalMtcTransp = modalMtcTranspEl ? bootstrap.Modal.getOrCreateInstance(modalMtcTranspEl) : null;

    // --- BIEN REGULADO SWITCH TOGGLE ---
    $(document).on('change', '.chk-bien-regulado', function() {
        let tr = $(this).closest('tr');
        let isChecked = $(this).is(':checked');
        tr.find('input[name="item_bienregulado[]"]').val(isChecked ? '1' : '0');
        
        let badge = tr.find('.badge-bien-regulado');
        if (isChecked) {
            badge.removeClass('bg-light text-secondary border').addClass('bg-warning text-dark').text('Reg: SÍ');
        } else {
            badge.removeClass('bg-warning text-dark').addClass('bg-light text-secondary border').text('Reg: NO');
        }
    });

    // --- UBIGEOS WITH SELECT2 ---
    $('.select2-ubigeo').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('body'),
        placeholder: 'Buscar Dept / Prov / Ubigeo Distrito',
        allowClear: true,
        width: '100%',
        ajax: {
            url: window.paramsGuia.urlBuscarUbigeo,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return { results: data };
            },
            cache: true
        },
        minimumInputLength: 3,
        language: {
            inputTooShort: function() { return "Ingresa 3 o más caracteres"; },
            noResults: function() { return "No se encontraron ubigeos"; },
            searching: function() { return "Buscando..."; }
        }
    });

    // --- SERIE → AUTOCARGAR SEDE (PUNTO DE PARTIDA) ---
    function cargarSedeDeSerie() {
        let $opt = $('#seriePrincipal option:selected');
        let ubigeo = $opt.data('sede-ubigeo');
        let dir = $opt.data('sede-dir');
        let nombre = $opt.data('sede-nombre');
        let correlativo = $opt.data('correlativo');

        if (ubigeo && dir) {
            // Cargar ubigeo en Select2 del campo partida
            $.get(window.paramsGuia.urlBuscarUbigeo, { id: ubigeo }, function(data) {
                if (data && data.id) {
                    let opt = new Option(data.text, data.id, true, true);
                    $('#ubigeo_partida').append(opt).trigger('change');
                }
            });
            // Cargar dirección
            $('input[name="direccion_partida"]').val(dir);
            $('#txtSedeNombre').text('📍 Sede: ' + (nombre || ''));
        }

        if (correlativo) {
            $('#correlativoPrincipal').val(correlativo);
        }
    }

    $('#seriePrincipal').on('change', cargarSedeDeSerie);
    // Cargar al inicio
    setTimeout(cargarSedeDeSerie, 400);

    // --- VALIDACIÓN FECHA TRASLADO ---
    $('#fecha_traslado').on('change', function() {
        let fechaHoy = new Date();
        fechaHoy.setHours(0,0,0,0);
        let fechaSeleccionada = new Date($(this).val() + 'T00:00:00');
        if (fechaSeleccionada < fechaHoy) {
            $('#msgFechaTraslado').text('⚠ La fecha de traslado no puede ser anterior a hoy').css('color','#e63946');
            $(this).addClass('is-invalid');
        } else {
            $('#msgFechaTraslado').text('');
            $(this).removeClass('is-invalid');
        }
    });

    // --- BÚSQUEDA DE CLIENTE (DESTINATARIO) ---
    var clienteTimer;
    $('#nro_doc_cliente').on('keyup', function() {
        let q = $(this).val().trim();
        let $resList = $('#cliente_results');

        // Autodetección rápida de tipo por longitud
        if (q.length === 8) {
            $('select[name="tipo_doc_cliente"]').val('1');
        } else if (q.length === 11) {
            $('select[name="tipo_doc_cliente"]').val('6');
        }

        clearTimeout(clienteTimer);

        if (q.length < 3) {
            $resList.addClass('d-none');
            return;
        }

        clienteTimer = setTimeout(function () {
            $.get(window.paramsGuia.urlBuscarCliente, { q: q }, function (data) {
                $resList.empty();
                if (data.length > 0) {
                    data.forEach(item => {
                        $resList.append(`
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action item-cliente"
                                data-id="${item.id}" 
                                data-num="${item.numero_documento}" 
                                data-tipo="${item.tipo_documento}" 
                                data-nom="${item.razon_social}"
                                data-dir="${item.direccion || ''}"
                                data-ubigeo="${item.ubigeo || ''}"
                                data-licencia="${item.licencia || ''}"
                                data-locales='${Array.isArray(item.establecimientos) ? JSON.stringify(item.establecimientos) : (item.establecimientos || "[]")}'>
                                <div class="fw-bold">${item.numero_documento}</div>
                                <small class="text-muted">${item.razon_social}</small>
                            </a>
                        `);
                    });
                    $resList.removeClass('d-none');
                } else {
                    $resList.html('<div class="list-group-item text-muted small py-2">No se encontraron resultados</div>').removeClass('d-none');
                }
            });
        }, 350);
    });

    let currentClienteLocales = [];
    let currentClienteInfo = {};

    // Función para asignar datos del cliente seleccionado
    function seleccionarCliente(cliente, autoOpenAnnexes = false) {
        $('input[name="nro_doc_cliente"]').val(cliente.numero_documento);
        $('select[name="tipo_doc_cliente"]').val(cliente.tipo_documento).trigger('change');
        $('input[name="razon_social_cliente"]').val(cliente.razon_social);
        
        // SIEMPRE LLENAR DIRECCIÓN FISCAL POR DEFECTO
        if (cliente.direccion) {
            $('input[name="direccion_llegada"]').val(cliente.direccion);
        }
        if (cliente.ubigeo) {
            window.setSelect2Value('#ubigeo_llegada', cliente.ubigeo);
        }

        // Guardar información para el botón manual
        currentClienteInfo = {
            direccion: cliente.direccion,
            ubigeo: cliente.ubigeo
        };
        
        let locales = [];
        try {
            let rawEst = cliente.establecimientos;
            if (typeof rawEst === 'string') {
                rawEst = JSON.parse(rawEst);
            }
            if (Array.isArray(rawEst)) {
                locales = rawEst;
            } else if (typeof rawEst === 'object' && rawEst !== null) {
                locales = Object.values(rawEst);
            }
        } catch (e) { 
            console.error("Error al parsear establecimientos:", e);
            locales = []; 
        }

        currentClienteLocales = locales;

        // Mostrar/Ocultar botón de locales anexos
        let esRuc = (cliente.tipo_documento == '6' || cliente.tipo_documento == 6 || (cliente.numero_documento && cliente.numero_documento.trim().length === 11));
        if (locales.length > 0 && esRuc) {
            $('#btnVerLocalesAnexos').removeClass('d-none');
            
            // OPCIONAL: Notificar al usuario que hay locales disponibles (Toast discreto)
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({ icon: 'info', title: 'Este cliente tiene locales anexos disponibles.' });

            if (autoOpenAnnexes) {
                setTimeout(() => {
                    $('#btnVerLocalesAnexos').trigger('click');
                }, 100);
            }
        } else {
            $('#btnVerLocalesAnexos').addClass('d-none');
        }

        // Si tiene licencia (útil si el cliente es también conductor)
        if (cliente.licencia) {
            $('#licencia_conductor').val(cliente.licencia);
        }

        $('#cliente_results').addClass('d-none');
    }
    window.seleccionarCliente = seleccionarCliente;

    // Acción del botón manual de sedes propias
    $('#btnVerMisSedes').on('click', function() {
        let sedes = window.paramsGuia.misSedes || [];
        if (sedes.length === 0) {
            Swal.fire('Atención', 'No tienes sedes registradas en tu empresa.', 'info');
            return;
        }

        let optionsHtml = `<div class="list-group text-start">`;
        sedes.forEach(s => {
            optionsHtml += `<button type="button" class="list-group-item list-group-item-action item-sede-propia" data-dir="${s.direccion}" data-ubigeo="${s.ubigeo}">
                <div class="fw-bold"><i class="ri-community-line text-info"></i> ${s.nombre}</div>
                <small class="text-muted">${s.direccion}</small>
            </button>`;
        });
        optionsHtml += `</div>`;

        Swal.fire({
            title: 'Seleccione Punto de Partida',
            html: `Seleccione una de las sedes de su empresa:<br>${optionsHtml}`,
            showConfirmButton: false,
            width: '600px'
        });
    });

    // Manejador para la selección de sede propia
    $(document).on('click', '.item-sede-propia', function() {
        let dir = $(this).data('dir');
        let ubi = $(this).data('ubigeo');
        
        $('input[name="direccion_partida"]').val(dir);
        if (ubi) {
            $.get(window.paramsGuia.urlBuscarUbigeo, { id: ubi }, function(data) {
                if (data && data.id) {
                    let opt = new Option(data.text, data.id, true, true);
                    $('#ubigeo_partida').empty().append(opt).trigger('change');
                }
            });
        }
        Swal.close();
    });

    // Acción del botón manual de locales anexos
    $('#btnVerLocalesAnexos').on('click', function() {
        if (currentClienteLocales.length === 0) return;

        let optionsHtml = `<div class="list-group text-start" id="listadoLocalesSwal">
            <button type="button" class="list-group-item list-group-item-action item-local" data-dir="${currentClienteInfo.direccion}" data-ubigeo="${currentClienteInfo.ubigeo}">
                <div class="fw-bold"><i class="ri-government-line text-primary"></i> 0000 - DIRECCIÓN FISCAL</div>
                <small class="text-muted">${currentClienteInfo.direccion}</small>
            </button>`;
        
        currentClienteLocales.forEach(l => {
            let ubi = '';
            if (l.ubigeo) {
                if (typeof l.ubigeo === 'string') {
                    ubi = l.ubigeo;
                } else if (Array.isArray(l.ubigeo) && l.ubigeo.length > 0) {
                    ubi = l.ubigeo[l.ubigeo.length - 1];
                }
            }
            optionsHtml += `<button type="button" class="list-group-item list-group-item-action item-local" data-dir="${l.direccion}" data-ubigeo="${ubi}">
                <div class="fw-bold"><i class="ri-map-pin-2-line text-success"></i> ${l.codigo || 'ANEXO'} - ${l.nombre || 'LOCAL ANEXO'}</div>
                <small class="text-muted">${l.direccion}</small>
            </button>`;
        });
        optionsHtml += `</div>`;

        Swal.fire({
            title: 'Seleccione Punto de Llegada',
            html: `
                <div class="mb-3">
                    <input type="text" id="buscarLocalSwal" class="form-control" placeholder="Filtrar por dirección o código...">
                </div>
                <div style="max-height: 400px; overflow-y: auto; border: 1px solid #eee; border-radius: 8px;">
                    ${optionsHtml}
                </div>
            `,
            showConfirmButton: false,
            width: '600px',
            didOpen: () => {
                const searchInput = document.getElementById('buscarLocalSwal');
                const listItems = document.querySelectorAll('#listadoLocalesSwal .item-local');
                
                searchInput.addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    listItems.forEach(item => {
                        const text = item.textContent.toLowerCase();
                        if (text.includes(filter)) {
                            item.style.setProperty('display', 'block', 'important');
                        } else {
                            item.style.setProperty('display', 'none', 'important');
                        }
                    });
                });
                // Focus al buscador
                searchInput.focus();
            }
        });
    });

    // Manejador para la selección del local (delegado para que funcione con el modal)
    $(document).on('click', '.item-local', function() {
        let dir = $(this).data('dir');
        let ubi = $(this).data('ubigeo');
        $('input[name="direccion_llegada"]').val(dir);
        if (ubi) window.setSelect2Value('#ubigeo_llegada', ubi);
        Swal.close();
    });

    // Elegir cliente del autocomplete
    $(document).on('click', '.item-cliente', function () {
        let cliente = {
            id: $(this).data('id'),
            numero_documento: $(this).data('num'),
            tipo_documento: $(this).data('tipo'),
            razon_social: $(this).data('nom'),
            direccion: $(this).data('dir'),
            ubigeo: $(this).data('ubigeo'),
            licencia: $(this).data('licencia'),
            establecimientos: $(this).data('locales')
        };
        seleccionarCliente(cliente);
    });

    // Cerrar resultados al hacer clic fuera
    $(document).on('click', function (e) {
        if (!$(e.target).closest("#nro_doc_cliente, #cliente_results").length) {
            $("#cliente_results").addClass('d-none');
        }
    });

    // Acción de búsqueda unificada (Ahora solo existe btn_consultar_api)


    // --- CONSULTA RUC/DNI EN TIEMPO REAL (NUEVO) ---
    $('#btn_consultar_api').on('click', function() {
        let doc = $('#nro_doc_cliente').val().trim();
        if (doc.length !== 8 && doc.length !== 11) {
            Swal.fire('Atención', 'El número de documento debe tener 8 (DNI) u 11 (RUC) caracteres.', 'warning');
            return;
        }

        let tipo = (doc.length === 11) ? '6' : '1';
        let $btn = $(this);
        let oldHtml = $btn.html();
        
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
        
        $.get(appBaseUrl + '/api/consultar-doc', { tipo: tipo, num: doc, save: 1 }, function(res) {
            $btn.prop('disabled', false).html(oldHtml);
            
            if (res.success) {
                let cliente = {
                    id: res.id,
                    numero_documento: doc,
                    tipo_documento: tipo,
                    razon_social: res.nombre,
                    direccion: res.direccion || '',
                    ubigeo: res.ubigeo || '',
                    licencia: res.licencia || '',
                    establecimientos: res.establecimientos || []
                };
                seleccionarCliente(cliente, autoQueryOnLoad);
                autoQueryOnLoad = false; // Resetear la bandera
            } else {
                Swal.fire('Atención', res.message, 'info');
                autoQueryOnLoad = false;
            }
        }).fail(function() {
            $btn.prop('disabled', false).html(oldHtml);
            autoQueryOnLoad = false;
            Swal.fire('Error', 'No se pudo conectar con el servicio de consulta.', 'error');
        });
    });

    // --- CAMBIO DE TIPO DE DOCUMENTO CONDUCTOR ---
    function updateConductorDocLayout() {
        let tipo = $('#tipo_documento_conductor').val() || '1';
        let $dniInput = $('#dni_conductor');
        let $labelDoc = $('#label_doc_conductor');
        let $btnSearch = $('#btn_consultar_api_cond');
        
        if (tipo === '1') { // DNI
            $labelDoc.html('DNI Conductor <span class="text-danger">*</span>');
            $dniInput.attr('placeholder', 'Ingrese DNI').attr('maxlength', '8');
            $btnSearch.prop('disabled', false).show();
        } else if (tipo === '4') { // CE
            $labelDoc.html('C.E. Conductor <span class="text-danger">*</span>');
            $dniInput.attr('placeholder', 'Ingrese Carnet de Extranjería').attr('maxlength', '15');
            $btnSearch.prop('disabled', true).hide();
        } else if (tipo === '7') { // Pasaporte
            $labelDoc.html('Pasaporte Conductor <span class="text-danger">*</span>');
            $dniInput.attr('placeholder', 'Ingrese Pasaporte').attr('maxlength', '15');
            $btnSearch.prop('disabled', true).hide();
        }
    }

    $(document).on('change', '#tipo_documento_conductor', function() {
        $('#dni_conductor').val('');
        $('#nombre_conductor').val('');
        updateConductorDocLayout();
    });

    // Inicializar estado del layout al cargar
    setTimeout(updateConductorDocLayout, 200);

    // --- CONSULTA DNI CONDUCTOR EN TIEMPO REAL ---
    $('#btn_consultar_api_cond').on('click', function() {
        let tipoDoc = $('#tipo_documento_conductor').val() || '1';
        if (tipoDoc !== '1') {
            Swal.fire('Atención', 'La consulta en línea solo está disponible para DNI.', 'info');
            return;
        }

        let doc = $('#dni_conductor').val().trim();
        if (doc.length !== 8) {
            Swal.fire('Atención', 'El DNI debe tener 8 caracteres.', 'warning');
            return;
        }

        let $btn = $(this);
        let oldHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
        
        $.get(appBaseUrl + '/api/consultar-doc', { tipo: '1', num: doc, save: 1 }, function(res) {
            $btn.prop('disabled', false).html(oldHtml);
            if (res.success) {
                $('#nombre_conductor').val(res.nombre);
                
                // Si el API ya trajo la licencia (ahora el backend lo hace automático y busca en DB local primero)
                if (res.licencia) {
                    $('#licencia_conductor').val(res.licencia);
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'Datos Obtenidos', 
                        text: res.nombre + ' - Lic: ' + res.licencia,
                        toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 
                    });
                } else {
                    Swal.fire({ icon: 'success', title: 'Conductor encontrado', text: res.nombre, toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
                }
            } else {
                Swal.fire('Atención', res.message, 'info');
            }
        }).fail(function() {
            $btn.prop('disabled', false).html(oldHtml);
            Swal.fire('Error', 'No se pudo conectar con el servicio de consulta.', 'error');
        });
    });


    // --- CONSULTA MTC PLACA EN TIEMPO REAL ---
    function performMtcQuery(inputSelector, targetTucSelector, btnSelector, updateMtcRegistro = true) {
        let placa = $(inputSelector).val().trim();
        if (placa.length < 6) {
            Swal.fire('Atención', 'Ingrese una placa válida.', 'warning');
            return;
        }

        let $btn = $(btnSelector);
        let oldHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
        
        $.get(appBaseUrl + '/api/consultar-mtc', { tipo: 'placa', valor: placa }, function(res) {
            $btn.prop('disabled', false).html(oldHtml);
            console.log("Respuesta MTC cruda:", res);
            if (res.success && res.encontrado) {
                let info = "";
                if (res.datos && Object.keys(res.datos).length > 0) {
                    info = Object.values(res.datos).join(' | ');
                    
                    // Buscar en todos los valores de 'datos' alguno que tenga el formato "CODIGO - NOMBRE"
                    Object.values(res.datos).forEach(val => {
                        if (typeof val === 'string' && val.includes(' - ')) {
                            let partes = val.split(' - ');
                            let posibleCodigo = partes[0].trim();
                            // Los códigos MTC suelen ser alfanuméricos de más de 6 caracteres
                            if (posibleCodigo.length >= 6 && !posibleCodigo.includes(' ')) {
                                if (updateMtcRegistro && $('#nro_registro_mtc').val().trim() === '') {
                                    $('#nro_registro_mtc').val(posibleCodigo);
                                }
                            }
                        }
                    });
                }

                if (res.vehiculos && res.vehiculos.length > 0) {
                    let v = res.vehiculos[0];
                    // El backend ahora normaliza a 'Certificado' cualquier columna que parezca ser el TUC
                    let tuc = v['Certificado'] || v['Nro. Certificado'] || v['Certificado de Habilitación'] || "";
                    if (tuc) {
                        $(targetTucSelector).val(tuc);
                        info = "TUC Encontrado: " + tuc;
                    }
                }

                Swal.fire({
                    icon: 'success',
                    title: 'MTC: Vehículo Validado',
                    text: info || 'Datos obtenidos correctamente',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000
                });
            } else {
                Swal.fire('Atención', res.message || 'No se encontró información en el MTC.', 'info');
            }
        }).fail(function() {
            $btn.prop('disabled', false).html(oldHtml);
            Swal.fire('Error', 'No se pudo conectar con el portal del MTC.', 'error');
        });
    }

    $('#btn_consultar_mtc').on('click', function() {
        performMtcQuery('#placa_vehiculo', '#tuse_principal', '#btn_consultar_mtc');
    });

    $('#btn_consultar_mtc_carreta').on('click', function() {
        performMtcQuery('#placa_carreta', '#tuse_secundario', '#btn_consultar_mtc_carreta', false);
    });

    // --- CONSULTA RUC TRANSPORTISTA EN TIEMPO REAL ---
    $('#btn_consultar_api_transp').on('click', function() {
        let doc = $('#ruc_transportista').val().trim();
        if (doc.length !== 11) {
            Swal.fire('Atención', 'El RUC debe tener 11 caracteres.', 'warning');
            return;
        }

        let $btn = $(this);
        let oldHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
        
        $.get(appBaseUrl + '/api/consultar-doc', { tipo: '6', num: doc, save: 1 }, function(res) {
            $btn.prop('disabled', false).html(oldHtml);
            if (res.success) {
                $('#razon_social_transportista').val(res.nombre);
                Swal.fire({ icon: 'success', title: 'Transportista encontrado', text: res.nombre, toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
                
                // Consultar partidas autorizadas en MTC
                buscarMtcTransportista(doc);
            } else {
                Swal.fire('Atención', res.message, 'info');
            }
        }).fail(function() {
            $btn.prop('disabled', false).html(oldHtml);
            Swal.fire('Error', 'No se pudo conectar con el servicio de consulta.', 'error');
        });
    });

    function buscarMtcTransportista(ruc) {
        if (!modalMtcTransp) return;
        
        // Mostrar cargando discreto
        Swal.fire({
            title: 'Consultando en MTC...',
            text: 'Buscando autorizaciones del transportista.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.get(appBaseUrl + '/api/consultar-mtc', { tipo: 'ruc', valor: ruc }, function(res) {
            Swal.close();
            if (res.success && res.partidas && res.partidas.length > 0) {
                if (res.partidas.length === 1) {
                    // Si hay solo una, autocompletar de inmediato
                    $('#nro_registro_mtc').val(res.partidas[0].codigo);
                    Swal.fire({
                        icon: 'success',
                        title: 'MTC Autocompletado',
                        text: 'Se asignó el código MTC: ' + res.partidas[0].codigo,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    // Si hay múltiples, renderizar lista en el modal
                    let html = '';
                    res.partidas.forEach(function(p) {
                        html += `
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action py-3 select-mtc-item" data-codigo="${p.codigo}">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-bold text-primary">${p.codigo}</h6>
                                    <small class="text-muted">Item: ${p.item} | ${p.razon_social}</small>
                                </div>
                                <i class="ri-checkbox-circle-fill text-success fs-20"></i>
                            </div>
                        </a>`;
                    });
                    
                    $('#listMtcTransportista').html(html);
                    modalMtcTransp.show();
                }
            } else {
                // Si no hay partidas o da error
                Swal.fire({
                    icon: 'info',
                    title: 'Consulta MTC',
                    text: 'No se encontraron autorizaciones vigentes en MTC para este transportista.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        }).fail(function() {
            Swal.close();
            console.warn('No se pudo conectar con la consulta MTC.');
        });
    }

    // Delegación para hacer clic en un código MTC
    $(document).on('click', '.select-mtc-item', function() {
        let codigo = $(this).data('codigo');
        $('#nro_registro_mtc').val(codigo);
        if (modalMtcTransp) {
            modalMtcTransp.hide();
        }
        Swal.fire({
            icon: 'success',
            title: 'MTC Seleccionado',
            text: 'Se asignó: ' + codigo,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });
    });

    // --- BÚSQUEDA DE COMPROBANTES (MODAL) ---
    $('#btnFiltrarComprobantes').on('click', function() {
        let btn = $(this);
        btn.html('<span class="spinner-border spinner-border-sm"></span>');
        
        let params = {
            desde: $('#filterDesde').val(),
            hasta: $('#filterHasta').val(),
            q: $('#filterQ').val(),
            empresa_id: window.paramsGuia.empresa_id
        };

        $.get(window.paramsGuia.urlBuscarComprobante, params, function(data) {
            btn.html('<i class="ri-search-2-line"></i>');
            let ruc_actual = $('input[name="nro_doc_cliente"]').val();
            let html = '';
            
            if (data.length == 0) {
                html = '<tr><td colspan="5" class="text-center text-muted py-4">No se encontraron resultados.</td></tr>';
            } else {
                data.forEach(function(item) {
                    let incompatible = (ruc_actual && item.cliente.numero_documento != ruc_actual);
                    let alreadyIn = ($(`.item-doc[data-id="${item.id}"]`).length > 0);
                    
                    let btnHtml = '';
                    if (alreadyIn) {
                        btnHtml = '<span class="badge bg-secondary-subtle text-secondary px-2">YA AGREGADO</span>';
                    } else if (incompatible) {
                        btnHtml = `<button type="button" class="btn btn-sm btn-outline-danger border-0" 
                                    onclick="Swal.fire({icon: 'warning', title: 'Cliente incompatible', text: 'Este comprobante (RUC ${item.cliente.numero_documento}) no coincide con el cliente actual (${ruc_actual}).', confirmButtonColor: '#3085d6'})">
                                    <i class="ri-error-warning-line"></i>
                                   </button>`;
                    } else {
                        // Usamos window.asociarDocumento para asegurar visibilidad global
                        btnHtml = `<button type="button" class="btn btn-sm btn-success" onclick="asociarDocumento('${item.id}', '${item.serie}-${String(item.correlativo).padStart(8, '0')}', '${item.cliente.tipo_documento}', '${item.cliente.numero_documento}', '${item.cliente.razon_social}', '${item.cliente.direccion}')">Seleccionar</button>`;
                    }

                    html += `<tr>
                        <td>${item.fecha_emision}</td>
                        <td class="fw-bold">${item.serie}-${String(item.correlativo).padStart(8, '0')}</td>
                        <td>${item.cliente.razon_social}</td>
                        <td class="text-end fw-bold">S/ ${item.total}</td>
                        <td class="text-center">${btnHtml}</td>
                    </tr>`;
                });
            }
            $('#tableSelectComprobantes tbody').html(html);
        });
    });

    // --- AGREGAR ÍTEM MANUAL (PRODUCTOS) ---
    $('#btnAgregarItemManual').on('click', function() {
        if (modalProductos) {
            // Limpiar filtro al abrir
            $('#inputSearchProd').val('');
            $('#btnRadioItiTodos').prop('checked', true);
            $('#resProd .item-prod-select').show();
            $('#prodCountText').text('Mostrando: ' + $('#resProd .item-prod-select').length);
            modalProductos.show();
        }
    });

    // Filtro local de productos precargados
    function filterProducts() {
        let filterText = $('#inputSearchProd').val().toLowerCase();
        let soloItinerantes = $('#btnRadioItiSolo').is(':checked');
        let listItems = $('#resProd .item-prod-select');
        let visibleCount = 0;
        
        listItems.each(function() {
            let $el = $(this);
            let text = $el.text().toLowerCase();
            let isItinerante = parseInt($el.data('itinerante')) === 1;
            
            let matchesText = text.includes(filterText);
            let matchesItinerante = !soloItinerantes || isItinerante;
            
            if (matchesText && matchesItinerante) {
                $el.show();
                visibleCount++;
            } else {
                $el.hide();
            }
        });
        
        $('#prodCountText').text('Mostrando: ' + visibleCount);
    }

    $('#inputSearchProd').on('input', filterProducts);
    $('input[name="btnradio_iti"]').on('change', filterProducts);

    // Delegación para agregar producto seleccionado de la lista
    $(document).on('click', '.item-prod-select', function() {
        let codigo = $(this).data('codigo');
        let descripcion = $(this).data('descripcion');
        let id = $(this).data('id');
        let peso = $(this).data('peso');
        let subpartida = $(this).data('subpartida');
        let unidad = $(this).data('unidad');
        let codsunat = $(this).data('codsunat');
        let bienregulado = $(this).data('bienregulado');
        
        window.addManualRow(codigo, descripcion, id, peso, subpartida, unidad, codsunat, bienregulado);
    });

    // Manejar cambio de motivo de traslado
    $('#motivo_traslado').on('change', function() {
        let val = $(this).val();

        // Mostrar/ocultar campo de especificación para motivo OTROS (13)
        if (val == '13') {
            $('#container_motivo_otros').removeClass('d-none');
            $('#motivo_traslado_otros').prop('required', true);
        } else {
            $('#container_motivo_otros').addClass('d-none');
            $('#motivo_traslado_otros').prop('required', false);
        }

        if (val == '18') { // Emisor Itinerante
            let ruc = $(this).data('mi-ruc');
            let razon = $(this).data('mi-razon');
            $('select[name="tipo_doc_cliente"]').val('6').trigger('change').css('pointer-events', 'none').css('background', '#e9ecef');
            $('input[name="nro_doc_cliente"]').val(ruc).prop('readonly', true).css('background', '#e9ecef');
            $('input[name="razon_social_cliente"]').val(razon).prop('readonly', true).css('background', '#e9ecef');
            $('#btnBuscarCliente').prop('disabled', true);

            // Hacer opcional el Ubigeo de llegada (Dirección sigue siendo obligatoria)
            $('#ubigeo_llegada').prop('required', false);
            $('#ubigeo_llegada').closest('.mb-2').find('.text-danger').hide();
            
            $('input[name="direccion_llegada"]').prop('required', true);
            $('input[name="direccion_llegada"]').closest('.col-md-6').find('label .text-danger').show();
            $('input[name="direccion_llegada"]').closest('div').find('.text-danger').show();
        } else {
            $('select[name="tipo_doc_cliente"]').css('pointer-events', '').css('background', '');
            $('input[name="nro_doc_cliente"]').prop('readonly', false).css('background', '');
            $('input[name="razon_social_cliente"]').prop('readonly', false).css('background', '');
            $('#btnBuscarCliente').prop('disabled', false);

            // Hacer requeridos campos de llegada
            $('#ubigeo_llegada').prop('required', true);
            $('input[name="direccion_llegada"]').prop('required', true);
            $('input[name="direccion_llegada"]').closest('.col-md-6').find('.text-danger').show();
        }
    });
    
    // Disparar validación inicial por si viene preseleccionada
    setTimeout(() => { 
        $('#motivo_traslado').trigger('change'); 
        $('#modalidadTraslado').trigger('change');
    }, 500);

    // Manejar cambio de modalidad
    $('#modalidadTraslado').on('change', function() {
        let val = $(this).val();
        if (val == '01') { // PÚBLICO
            $('#panelPrivado').hide();
            $('#panelPublico').fadeIn();
            $('#divIndVehicTransp').fadeIn();
            $('#label_mtc').text('Nro. Registro MTC (Transportista)');
            $('#nro_registro_mtc').next('small').text('Indispensable si el transportista tiene flota registrada');
        } else { // PRIVADO
            $('#panelPublico').hide();
            $('#panelPrivado').fadeIn();
            $('#divIndVehicTransp').hide();
            $('#ind_vehiculo_transp').prop('checked', false);
            $('#label_mtc').text('Nro. Registro MTC (Emisor)');
            $('#nro_registro_mtc').next('small').text('Indispensable si transportante con flota propia');
        }
    });

    // Indicador especial para mostrar datos de chofer en Público
    $('#ind_vehiculo_transp').on('change', function() {
        if ($(this).is(':checked')) {
            $('#panelPrivado').fadeIn();
        } else {
            if ($('#modalidadTraslado').val() == '01') {
                $('#panelPrivado').fadeOut();
            }
        }
    });

    // --- BÚSQUEDA DE CONDUCTOR (AUTOCOMPLETE) ---
    $('#dni_conductor').on('keyup', function() {
        let q = $(this).val().trim();
        if (q.length < 3) {
            $('#conductor_results').empty();
            return;
        }

        clearTimeout(clienteTimer);
        clienteTimer = setTimeout(() => {
            $.get(window.paramsGuia.urlBuscarCliente, { q: q }, function(data) {
                let html = '';
                if (data && data.length > 0) {
                    data.forEach(c => {
                        html += `
                            <div class="autocomplete-item p-2 border-bottom cursor-pointer item-conductor" 
                                 data-dni="${c.numero_documento}" 
                                 data-nombre="${c.razon_social}"
                                 data-direccion="${c.direccion || ''}"
                                 data-licencia="${c.licencia || ''}">
                                <div class="fw-bold fs-13">${c.numero_documento}</div>
                                <div class="text-muted fs-11">${c.razon_social}</div>
                            </div>`;
                    });
                }
                $('#conductor_results').html(html);
            });
        }, 300);
    });

    $(document).on('click', '.item-conductor', function() {
        let dni = $(this).data('dni');
        let nombre = $(this).data('nombre');
        let licencia = $(this).data('licencia');
        $('#dni_conductor').val(dni);
        $('#nombre_conductor').val(nombre);
        if(licencia) $('#licencia_conductor').val(licencia);
        $('#conductor_results').empty();
        
        Swal.fire({
            icon: 'success',
            title: 'Conductor seleccionado',
            text: nombre,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });
    });

    // --- BÚSQUEDA DE TRANSPORTISTA (AUTOCOMPLETE) ---
    $('#ruc_transportista').on('keyup', function() {
        let q = $(this).val().trim();
        if (q.length < 3) {
            $('#transportista_results').empty();
            return;
        }

        clearTimeout(clienteTimer);
        clienteTimer = setTimeout(() => {
            $.get(window.paramsGuia.urlBuscarCliente, { q: q }, function(data) {
                let html = '';
                if (data && data.length > 0) {
                    data.forEach(c => {
                        html += `
                            <div class="autocomplete-item p-2 border-bottom cursor-pointer item-transportista" 
                                 data-ruc="${c.numero_documento}" 
                                 data-nombre="${c.razon_social}"
                                 data-locales='${c.establecimientos || "[]"}'>
                                <div class="fw-bold fs-13">${c.numero_documento}</div>
                                <div class="text-muted fs-11">${c.razon_social}</div>
                            </div>`;
                    });
                }
                $('#transportista_results').html(html);
            });
        }, 300);
    });

    $(document).on('click', '.item-transportista', function() {
        let ruc = $(this).data('ruc');
        let nombre = $(this).data('nombre');
        $('#ruc_transportista').val(ruc);
        $('#razon_social_transportista').val(nombre);
        $('#transportista_results').empty();

        Swal.fire({
            icon: 'success',
            title: 'Transportista seleccionado',
            text: nombre,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });
    });

    // Ocultar resultados al hacer clic fuera
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#dni_conductor, #conductor_results').length) {
            $('#conductor_results').empty();
        }
        if (!$(e.target).closest('#ruc_transportista, #transportista_results').length) {
            $('#transportista_results').empty();
        }
    });

    // Botones Buscar Manuales (actualizados para llenar campos de nombre)
    $('#btnBuscarConductor').on('click', function() {
        let nroDoc = $('#dni_conductor').val().trim();
        if (nroDoc.length < 8) {
            Swal.fire('Atención', 'Ingrese al menos 8 dígitos.', 'warning');
            return;
        }

        let btn = $(this);
        let origHtml = btn.html();
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.get(window.paramsGuia.urlBuscarCliente, { q: nroDoc }, function(data) {
            btn.prop('disabled', false).html(origHtml);
            if (data && data.length > 0) {
                let c = data[0];
                $('#nombre_conductor').val(c.razon_social);
                Swal.fire('Conductor Encontrado', c.razon_social, 'success');
            } else {
                Swal.fire('No registrado', 'No se encontró en la base de datos local.', 'info');
            }
        });
    });

    $('#btnBuscarTransportista').on('click', function() {
        let nroDoc = $('#ruc_transportista').val().trim();
        if (nroDoc.length < 11) {
            Swal.fire('Atención', 'Ingrese 11 dígitos para RUC.', 'warning');
            return;
        }

        let btn = $(this);
        let origHtml = btn.html();
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.get(window.paramsGuia.urlBuscarCliente, { q: nroDoc }, function(data) {
            btn.prop('disabled', false).html(origHtml);
            if (data && data.length > 0) {
                let c = data[0];
                $('#razon_social_transportista').val(c.razon_social);
                Swal.fire('Transportista Encontrado', c.razon_social, 'success');
            } else {
                Swal.fire('No registrado', 'No se encontró en la base de datos local.', 'info');
            }
        });
    });

    // Eliminar item de la tabla
    $(document).on('click', '.btn-remove-item', function() {
        $(this).closest('tr').fadeOut(300, function() {
            $(this).remove();
            if ($('#tableItems tbody tr').not('#rowEmpty').length == 0) {
                if ($('#rowEmpty').length == 0) {
                    $('#tableItems tbody').html('<tr id="rowEmpty"><td colspan="4" class="text-center text-muted py-4">Agregue artículos manualmente o desde una factura.</td></tr>');
                }
            }
        });
    });

    $(document).on('click', '.btn-edit-item', function() {
        let row = $(this).closest('tr');
        row.find('input[name="item_cantidad[]"]').focus().select();
        
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
        Toast.fire({
            icon: 'info',
            title: 'Listo para modificar'
        });
    });

    // Eliminar documento asociado y sus productos vinculados
    $(document).on('click', '.btn-remove-doc', function() {
        let parent = $(this).closest('.item-doc');
        let docId = parent.data('id');
        
        // 1. Obtener los productos que trajo este documento desde el cache
        let itemsAVirar = window.docCache[docId] || [];
        
        itemsAVirar.forEach(function(it) {
            let row = $(`input[name="item_codigo[]"][value="${it.codigo}"]`).closest('tr');
            if (row.length > 0) {
                let inputCant = row.find('input[name="item_cantidad[]"]');
                let currentCant = parseFloat(inputCant.val()) || 0;
                let newCant = currentCant - parseFloat(it.cantidad);
                
                if (newCant <= 0) {
                    row.remove();
                } else {
                    inputCant.val(newCant.toFixed(3));
                    row.addClass('bg-danger-subtle');
                    setTimeout(() => row.removeClass('bg-danger-subtle'), 1000);
                }
            }
        });

        // 2. Limpiar cache y eliminar badge
        delete window.docCache[docId];
        parent.remove();

        if ($('#listaDocumentosAsociados .item-doc').length == 0) {
            $('#emptyDocs').removeClass('d-none');
            // Si no hay documentos y no hay items manuales (identificados por no tener titulo 'Factura' o similar si lo deseamos)
            // Por ahora dejamos los manuales intactos
        }
    });

    // --- VISTA PREVIA PDF (REPRESENTACIÓN IMPRESA) ---
    $(document).on('click', '#btnVistaPreviaPdf, #btnVistaPreviaPdfTicket', function(e) {
        e.preventDefault();
        let form = $('#formNuevaGuia, #formEditarGuia')[0];
        if (!form) return;

        // Validar que haya al menos un ítem antes de previsualizar
        if ($('#tableItems tbody tr').not('#rowEmpty').length === 0) {
            Swal.fire('Atención', 'Debe agregar al menos un artículo para previsualizar el PDF.', 'warning');
            return;
        }

        let isTicket = $(this).attr('id') === 'btnVistaPreviaPdfTicket' || $(this).data('format') === 'ticket';
        let format = isTicket ? 'ticket' : 'a4';

        // Guardar action y target originales
        let originalAction = $(form).attr('action');
        let originalTarget = $(form).attr('target') || '';

        // Cambiar temporalmente para enviar a la ruta de vista previa
        $(form).attr('action', appBaseUrl + '/guia/vista-previa-pdf/' + format);
        $(form).attr('target', '_blank');

        // Enviar formulario (abrirá en pestaña nueva con la vista previa del PDF/HTML)
        form.submit();

        // Restaurar action y target originales
        $(form).attr('action', originalAction);
        if (originalTarget) {
            $(form).attr('target', originalTarget);
        } else {
            $(form).removeAttr('target');
        }
    });

    // --- VISTA PREVIA XML (SIN FIRMA) ---
    $(document).on('click', '#btnVistaPreviaXml', function() {
        let form = $('#formNuevaGuia, #formEditarGuia')[0];
        if (!form) return;

        // Validar que haya al menos un ítem antes de previsualizar
        if ($('#tableItems tbody tr').not('#rowEmpty').length === 0) {
            Swal.fire('Atención', 'Debe agregar al menos un artículo para previsualizar el XML.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Generando Vista Previa...',
            text: 'Espere un momento por favor...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        let formData = new FormData(form);
        $.ajax({
            url: appBaseUrl + '/guia/vista-previa-xml',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                Swal.close();
                console.log("XML Preview Response:", res);
                if (res.success) {
                    Swal.fire({
                        title: 'Vista Previa del XML (Sin Firma)',
                        html: `
                            <div class="text-start">
                                <p class="text-secondary small mb-2">Estructura XML UBL 2.1 generada dinámicamente según tus datos:</p>
                                <textarea class="form-control text-start font-monospace bg-dark text-info p-3" rows="20" style="font-size: 11px; white-space: pre; overflow-wrap: normal;" readonly>${res.xml}</textarea>
                            </div>
                        `,
                        width: '80%',
                        confirmButtonText: 'Cerrar',
                        confirmButtonColor: '#3085d6'
                    });
                } else {
                    Swal.fire('Error', res.message || 'No se pudo generar la vista previa del XML', 'error');
                }
            },
            error: function(err) {
                Swal.close();
                let msg = 'Error de comunicación con el servidor.';
                if (err.responseJSON && err.responseJSON.message) msg = err.responseJSON.message;
                Swal.fire('Error', msg, 'error');
            }
        });
    });

    // --- VALIDACIÓN Y ENVÍO DEL FORMULARIO ---
    $('#formNuevaGuia, #formEditarGuia').on('submit', function(e) {
        e.preventDefault();
        const form = this;

        // 1. Validar Destinatario
        if (!$('input[name="razon_social_cliente"]').val()) {
            Swal.fire('Atención', 'Debe buscar y seleccionar un destinatario válido.', 'warning');
            return;
        }

        // 2. Validar Datos de Envío
        const modalidad = $('select[name="modalidad_traslado"]').val() || $('#modalidad_traslado').val();

        if (modalidad == '02') {
            let tipoDocCond = $('#tipo_documento_conductor').val() || '1';
            let dniCond = $('input[name="dni_conductor"]').val().trim();
            let labelDoc = tipoDocCond === '1' ? 'DNI' : (tipoDocCond === '4' ? 'Carnet de Extranjería' : 'Pasaporte');

            if (!dniCond) {
                Swal.fire('Atención', 'Debe ingresar el número de ' + labelDoc + ' del conductor.', 'warning'); return;
            }
            if (tipoDocCond === '1' && dniCond.length !== 8) {
                Swal.fire('Atención', 'El DNI del conductor debe tener exactamente 8 caracteres.', 'warning'); return;
            }
            if (dniCond.length < 6 || dniCond.length > 15) {
                Swal.fire('Atención', 'El número de documento (' + labelDoc + ') del conductor debe tener entre 6 y 15 caracteres.', 'warning'); return;
            }
            if (!$('input[name="nombre_conductor"]').val().trim()) {
                Swal.fire('Atención', 'Debe ingresar el nombre del conductor.', 'warning'); return;
            }
            if (!$('input[name="licencia_conductor"]').val()) {
                Swal.fire('Atención', 'Debe ingresar el N° de Licencia del conductor.', 'warning'); return;
            }
            if (!$('input[name="placa_vehiculo"]').val()) {
                Swal.fire('Atención', 'Debe ingresar la Placa del vehículo.', 'warning'); return;
            }
        }

        if (!$('#ubigeo_partida').val()) {
            Swal.fire('Atención', 'Debe seleccionar el Ubigeo de Partida.', 'warning');
            return;
        }

        if (!$('input[name="direccion_partida"]').val()) {
            Swal.fire('Atención', 'Debe ingresar la Dirección de Partida.', 'warning');
            return;
        }
        const motivoTraslado = $('#motivo_traslado').val();
        if (motivoTraslado !== '18') {
            if (!$('#ubigeo_llegada').val()) {
                Swal.fire('Atención', 'Debe seleccionar el Ubigeo de Llegada.', 'warning');
                return;
            }
        }
        if (!$('input[name="direccion_llegada"]').val()) {
            Swal.fire('Atención', 'Debe ingresar la Dirección de Llegada.', 'warning');
            return;
        }

        // 3. Validar Ítems
        if ($('#tableItems tbody tr').not('#rowEmpty').length === 0) {
            Swal.fire('Atención', 'Debe agregar al menos un artículo para trasladar.', 'warning');
            return;
        }

        // 3.5 Validar Bienes Regulados (Normalizados) y su código SUNAT
        let hasRegulatedWithoutCode = false;
        let regulatedProdName = '';
        $('#tableItems tbody tr').not('#rowEmpty').each(function() {
            let bienRegulado = $(this).find('input[name="item_bienregulado[]"]').val();
            let codSunat = $(this).find('input[name="item_codsunat[]"]').val();
            if (bienRegulado == '1' && (!codSunat || codSunat.trim() === '')) {
                hasRegulatedWithoutCode = true;
                regulatedProdName = $(this).find('input[name="item_descripcion[]"]').val() || $(this).find('td').eq(0).text().trim();
                return false; // break loop
            }
        });

        if (hasRegulatedWithoutCode) {
            Swal.fire('Atención', `El producto "${regulatedProdName}" es un Bien Normalizado (Regulado) y requiere obligatoriamente el Código de Producto SUNAT. Por favor, configúrelo en el módulo de productos antes de continuar.`, 'warning');
            return;
        }

        // 4. Validar Peso y Bultos
        let peso = parseFloat($('input[name="peso_total"]').val()) || 0;
        if (peso <= 0) {
            Swal.fire('Atención', 'El Peso Total Bruto debe ser mayor a 0.', 'warning');
            return;
        }

        // Si todo está bien, confirmar y enviar
        const isEdit = $(form).attr('id') === 'formEditarGuia';

        // Función para ejecutar el modal final de envío y la petición AJAX
        function procederConEnvio() {
            let previewHtml = `
                <div class="text-center mb-3">
                    <p class="text-muted small mb-2">Antes de continuar, puedes verificar cómo quedará el documento:</p>
                    <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
                        <button type="button" id="btnAlertPrevPdf" class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1 py-1.5 px-3 rounded-pill shadow-sm fw-semibold" style="font-size:11.5px;">
                            <i class="ri-file-pdf-line"></i> Vista A4
                        </button>
                        <button type="button" id="btnAlertPrevTicket" class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1 py-1.5 px-3 rounded-pill shadow-sm fw-semibold" style="font-size:11.5px;">
                            <i class="ri-ticket-line"></i> Vista Ticket
                        </button>
                        <button type="button" id="btnAlertPrevXml" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 py-1.5 px-3 rounded-pill shadow-sm fw-semibold" style="font-size:11.5px;">
                            <i class="ri-code-s-slash-line"></i> Vista XML
                        </button>
                    </div>
                    <p class="mb-0 text-secondary small fw-bold">¿Estás seguro de continuar con la emisión oficial a SUNAT?</p>
                </div>
            `;

            Swal.fire({
                title: isEdit ? '¿Actualizar y Reenviar Guía?' : '¿Emitir Guía Electrónica?',
                html: previewHtml,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: isEdit ? 'Sí, Reenviar' : 'Sí, Emitir',
                cancelButtonText: 'Cancelar',
                didOpen: () => {
                    // Vincular acciones de clicks a los botones ocultos
                    $(document).off('click', '#btnAlertPrevPdf').on('click', '#btnAlertPrevPdf', function() {
                        $('#btnVistaPreviaPdf').trigger('click');
                    });
                    $(document).off('click', '#btnAlertPrevTicket').on('click', '#btnAlertPrevTicket', function() {
                        $('#btnVistaPreviaPdfTicket').trigger('click');
                    });
                    $(document).off('click', '#btnAlertPrevXml').on('click', '#btnAlertPrevXml', function() {
                        $('#btnVistaPreviaXml').trigger('click');
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Procesando...',
                        text: 'Enviando comprobante a SUNAT...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    let formData = new FormData(form);
                    $.ajax({
                        url: $(form).attr('action'),
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            if (res.success) {
                                let downloadButtons = `
                                    <div class="mt-3 p-3 rounded-3" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                        <p class="mb-2 text-secondary small fw-bold text-uppercase">Accesos Rápidos:</p>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="${appBaseUrl}/guia/imprimir/${res.id_cifrado}" target="_blank" class="btn btn-warning d-flex align-items-center gap-2 shadow-sm">
                                                <i class="material-symbols-outlined fs-20">print</i> PDF
                                            </a>
                                            ${res.xml_url ? `
                                            <a href="${res.xml_url}" target="_blank" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
                                                <i class="material-symbols-outlined fs-20">code</i> XML
                                            </a>` : ''}
                                            ${res.cdr_url ? `
                                            <a href="${res.cdr_url}" target="_blank" class="btn btn-success d-flex align-items-center gap-2 shadow-sm">
                                                <i class="material-symbols-outlined fs-20">task_alt</i> CDR
                                            </a>` : ''}
                                        </div>
                                    </div>
                                `;

                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Guía Emitida!',
                                    html: `<div class="text-start">${res.message}</div> ${downloadButtons}`,
                                    showCancelButton: true,
                                    confirmButtonText: 'Emitir Otra',
                                    cancelButtonText: 'Ir al Listado',
                                    width: '500px'
                                }).then((r) => {
                                    if (r.isConfirmed) {
                                        window.location.reload();
                                    } else {
                                        window.location.href = `${appBaseUrl}/gestion-de-guias/${$('input[name="idopcion"]').val()}`;
                                    }
                                });
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        },
                        error: function(err) {
                            let msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : 'Error de red o del servidor.';
                            Swal.fire('Error', msg, 'error');
                        }
                    });
                }
            });
        }

        // Soft warning para Detracción si hay Bienes Regulados
        let hasRegulated = false;
        $('#tableItems tbody tr').not('#rowEmpty').each(function() {
            if ($(this).find('input[name="item_bienregulado[]"]').val() == '1') {
                hasRegulated = true;
                return false;
            }
        });

        let nroDetraccion = $('input[name="nro_detraccion"]').val();
        if (hasRegulated && (!nroDetraccion || nroDetraccion.trim() === '')) {
            Swal.fire({
                title: '¿Continuar sin Constancia de Detracción?',
                text: "Hemos detectado un Bien Regulado pero no has ingresado la 'Nro. Constancia Detracción'. Si esta operación supera los S/ 400, registrarla es un requisito legal para evitar multas o decomisos en carretera.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, emitir de todas formas',
                cancelButtonText: 'No, cancelar para ingresar número'
            }).then((result) => {
                if (result.isConfirmed) {
                    procederConEnvio();
                }
            });
        } else {
            procederConEnvio();
        }
    });
});

// Cache global para recordar qué trajo cada documento
window.docCache = {};

// Funciones globales para ser llamadas desde onclick
window.asociarDocumento = function(id, numero, tipoDoc, nroDoc, razonSocial, direccion) {
    // 1. Validar duplicados
    if ($(`.item-doc[data-id="${id}"]`).length > 0) {
        Swal.fire({
            icon: 'info',
            title: 'Documento ya asociado',
            text: 'Este comprobante ya se encuentra en la lista de documentos relacionados.',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    let inputRuc = $('input[name="nro_doc_cliente"]');
    if (inputRuc.val() && inputRuc.val() != nroDoc) {
        Swal.fire({
            icon: 'error',
            title: '¡Error de Asociación!',
            text: 'No se pueden mezclar documentos de diferentes clientes en una misma guía.',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Entendido'
        });
        return;
    }

    $('select[name="tipo_doc_cliente"]').val(tipoDoc);
    $('input[name="nro_doc_cliente"]').val(nroDoc);
    $('input[name="razon_social_cliente"]').val(razonSocial);
    $('input[name="direccion_llegada"]').val(direccion);

    let htmlDoc = `<div class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill d-flex align-items-center gap-2 item-doc" data-id="${id}">
                        <span><i class="ri-article-line"></i> ${numero}</span>
                        <input type="hidden" name="ventas_asociadas[]" value="${id}">
                        <i class="ri-close-line cursor-pointer btn-remove-doc"></i>
                    </div>`;
    $('#listaDocumentosAsociados').append(htmlDoc);
    $('#emptyDocs').addClass('d-none');
    
    // Cerrar modal
    const modalEl = document.getElementById('modalBuscarComprobantes');
    if (modalEl) {
        const inst = bootstrap.Modal.getInstance(modalEl);
        if (inst) inst.hide();
    }

    importarItems(id);
};

window.addManualRow = function(codigo, descripcion, productoId = null, peso = 0, subpartida = '', unidad = 'NIU', codSunat = '', bienRegulado = 0) {
    if ($('#rowEmpty').length) {
        $('#tableItems tbody').empty();
    }

    // Lógica de agrupación: Buscar si el código ya existe
    let existingRow = $(`input[name="item_codigo[]"][value="${codigo}"]`).closest('tr');
    if (existingRow.length > 0) {
        let inputCant = existingRow.find('input[name="item_cantidad[]"]');
        let currentCant = parseInt(inputCant.val()) || 0;
        let newCant = currentCant + 1;
        inputCant.val(newCant);

        // Actualizar peso de la fila
        let inputPesoItem = existingRow.find('.input-peso-item');
        let pesoUnitario = parseFloat(peso) || 0;
        inputPesoItem.val((newCant * pesoUnitario).toFixed(2));
        
        // Efecto visual de resaltado
        existingRow.addClass('bg-success-subtle');
        setTimeout(() => existingRow.removeClass('bg-success-subtle'), 1500);
    } else {
        let inputProdId = productoId ? `<input type="hidden" name="item_producto_id[]" value="${productoId}">` : '';

        let row = `<tr>
            <td class="align-middle">
                ${inputProdId}
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-dark fw-bold" style="min-width: 60px;">${codigo}</span>
                        <input type="text" name="item_descripcion[]" class="form-control form-control-sm border-0 bg-light text-wrap fw-semibold w-100" value="${descripcion}">
                        <input type="hidden" name="item_codigo[]" value="${codigo}">
                        <input type="hidden" name="item_subpartida[]" value="${subpartida}">
                        <input type="hidden" name="item_codsunat[]" value="${codSunat}">
                        <input type="hidden" name="item_bienregulado[]" value="${bienRegulado}">
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 fs-10" title="Subpartida">
                            Subp: ${subpartida || '-'}
                        </span>
                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 fs-10" title="Cód. SUNAT">
                            Sunat: ${codSunat || '-'}
                        </span>
                        <label class="d-inline-flex align-items-center gap-1 m-0 form-switch" style="cursor: pointer; min-height: auto;">
                            <input class="form-check-input chk-bien-regulado" type="checkbox" role="switch" ${bienRegulado == 1 ? 'checked' : ''} style="cursor: pointer; transform: scale(0.8); margin: 0; float: none;">
                            <span class="badge ${bienRegulado == 1 ? 'bg-warning text-dark' : 'bg-light text-secondary border'} fs-10 badge-bien-regulado">Reg: ${bienRegulado == 1 ? 'SÍ' : 'NO'}</span>
                        </label>
                    </div>
                </div>
            </td>
            <td class="align-middle text-center">
                <span class="badge bg-secondary-subtle text-secondary border border-secondary border-opacity-25 fw-bold fs-11">${unidad}</span>
                <input type="hidden" name="item_unidad[]" value="${unidad}">
            </td>
            <td class="align-middle"><input type="number" name="item_cantidad[]" step="1" class="form-control form-control-sm text-center fw-bold input-cant-item border border-secondary border-opacity-25" value="1" data-peso-u="${peso}" style="min-width: 80px;"></td>
            <td class="align-middle"><input type="number" name="item_peso[]" step="0.01" class="form-control form-control-sm text-center fw-bold input-peso-item border border-secondary border-opacity-25" value="${(1 * parseFloat(peso || 0)).toFixed(2)}" placeholder="0.00" style="min-width: 80px;"></td>
            <td class="align-middle text-end">
                <button type="button" class="btn btn-sm btn-outline-danger border-0 btn-remove-item"><i class="ri-delete-bin-line"></i></button>
            </td>
        </tr>`;
        $('#tableItems tbody').append(row);
    }
    
    // Cerrar modal
    const modalEl = document.getElementById('modalBuscarProductos');
    if (modalEl) {
        const inst = bootstrap.Modal.getInstance(modalEl);
        if (inst) inst.hide();
    }
    
    $('#inputSearchProd').val('');
    $('#resProd .item-prod-select').show();
    calcTotalPeso();
};

window.importarItems = function(ventaId) {
    $.get(window.paramsGuia.urlVentaDetalles, { venta_id: ventaId }, function(data) {
        if (data.success) {
            // Guardar en cache para poder restar si se elimina el doc
            window.docCache[ventaId] = data.detalles;

            if ($('#rowEmpty').length) {
                $('#tableItems tbody').empty();
            }

            data.detalles.forEach(function(it) {
                // Lógica de agrupación: Buscar si el código ya existe
                let existingRow = $(`input[name="item_codigo[]"][value="${it.codigo}"]`).closest('tr');
                
                if (existingRow.length > 0) {
                    let inputCant = existingRow.find('input[name="item_cantidad[]"]');
                    let currentCant = parseInt(inputCant.val()) || 0;
                    let addedCant = Math.round(parseFloat(it.cantidad)) || 0;
                    let newCant = currentCant + addedCant;
                    inputCant.val(newCant);
                    
                    // Actualizar peso
                    let inputPesoItem = existingRow.find('.input-peso-item');
                    let pesoUnitario = parseFloat(it.peso) || 0;
                    inputPesoItem.val((newCant * pesoUnitario).toFixed(2));

                    // Efecto visual de resaltado
                    existingRow.addClass('bg-primary-subtle');
                    setTimeout(() => existingRow.removeClass('bg-primary-subtle'), 2000);
                } else {
                    let subpartidaNac = it.producto ? (it.producto.subpartida_nacional || '') : '';
                    let codSunat = it.producto ? (it.producto.cod_prod_sunat || '') : '';
                    let bienRegulado = it.producto ? (it.producto.bien_regulado || 0) : 0;
                    let unidadMedida = it.producto ? (it.producto.unidad_medida || 'NIU') : (it.unidad_medida || 'NIU');
                    let row = `<tr>
                        <td class="align-middle">
                            <input type="hidden" name="item_producto_id[]" value="${it.producto_id || ''}">
                            <span class="fw-bold text-dark fs-12">${it.codigo}</span>
                            <input type="hidden" name="item_codigo[]" value="${it.codigo}">
                            <input type="hidden" name="item_subpartida[]" value="${subpartidaNac}">
                            <input type="hidden" name="item_codsunat[]" value="${codSunat}">
                            <input type="hidden" name="item_bienregulado[]" value="${bienRegulado}">
                        </td>
                        <td class="align-middle text-center">
                            <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 fw-bold fs-11">${subpartidaNac || '-'}</span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="badge bg-success-subtle text-success border border-success border-opacity-25 fw-bold fs-11">${codSunat || '-'}</span>
                        </td>
                        <td class="align-middle text-center">
                            <label class="d-inline-flex align-items-center gap-1 m-0 form-switch" style="cursor: pointer; min-height: auto;">
                                <input class="form-check-input chk-bien-regulado" type="checkbox" role="switch" ${bienRegulado == 1 ? 'checked' : ''} style="cursor: pointer; transform: scale(0.8); margin: 0; float: none;">
                                <span class="badge ${bienRegulado == 1 ? 'bg-warning text-dark' : 'bg-light text-secondary border'} fs-10 badge-bien-regulado">Reg: ${bienRegulado == 1 ? 'SÍ' : 'NO'}</span>
                            </label>
                        </td>
                        <td class="align-middle"><input type="text" name="item_descripcion[]" class="form-control form-control-sm border-0 bg-light" value="${it.descripcion}"></td>
                        <td class="align-middle text-center">
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary border-opacity-25 fw-bold fs-11">${unidadMedida}</span>
                            <input type="hidden" name="item_unidad[]" value="${unidadMedida}">
                        </td>
                        <td class="align-middle"><input type="number" name="item_cantidad[]" step="1" class="form-control form-control-sm text-center fw-bold input-cant-item border border-secondary border-opacity-25" value="${Math.round(parseFloat(it.cantidad))}" data-peso-u="${it.peso || 0}"></td>
                        <td class="align-middle"><input type="number" name="item_peso[]" step="0.01" class="form-control form-control-sm text-center fw-bold input-peso-item border border-secondary border-opacity-25" value="${(parseFloat(it.cantidad) * parseFloat(it.peso || 0)).toFixed(2)}" placeholder="0.00"></td>
                        <td class="align-middle text-end">
                            <button type="button" class="btn btn-sm btn-outline-danger border-0 btn-remove-item"><i class="ri-delete-bin-line"></i></button>
                        </td>
                    </tr>`;
                    $('#tableItems tbody').append(row);
                }
            });
            
            Swal.fire({
                icon: 'success',
                title: 'Ítems procesados',
                text: `${data.detalles.length} artículos analizados y agrupados según corresponda.`,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
            });
            calcTotalPeso();
        }
    });
};

window.setSelect2Value = function(selector, id) {
    let select = $(selector);
    $.get(window.paramsGuia.urlBuscarUbigeo, { id: id }, function(data) {
        if (data) {
            let newOption = new Option(data.text, data.id, true, true);
            select.append(newOption).trigger('change');
        }
    });
};

// Carga inicial si hay datos
$(document).ready(function() {
    console.log("DEBUG - Carga inicial: clienteInfo =", window.paramsGuia.clienteInfo);
    // Si viene con información del cliente (ej: de una venta), inicializarlo y abrir locales anexos si corresponde
    if (window.paramsGuia.clienteInfo) {
        let locales = [];
        try {
            let rawEst = window.paramsGuia.clienteInfo.establecimientos;
            console.log("DEBUG - establecimientos raw =", rawEst);
            if (typeof rawEst === 'string') {
                rawEst = JSON.parse(rawEst);
            }
            if (Array.isArray(rawEst)) {
                locales = rawEst;
            } else if (typeof rawEst === 'object' && rawEst !== null) {
                locales = Object.values(rawEst);
            }
        } catch (e) { 
            console.error("DEBUG - Error parseando establecimientos", e);
            locales = []; 
        }

        console.log("DEBUG - locales parsed =", locales);
        let esRuc = (window.paramsGuia.clienteInfo.tipo_documento == '6' || window.paramsGuia.clienteInfo.tipo_documento == 6 || (window.paramsGuia.clienteInfo.numero_documento && window.paramsGuia.clienteInfo.numero_documento.trim().length === 11));
        console.log("DEBUG - esRuc =", esRuc, "locales.length =", locales.length);

        if (esRuc && locales.length === 0) {
            autoQueryOnLoad = true;
            window.seleccionarCliente(window.paramsGuia.clienteInfo, false); // Cargar datos básicos primero
            console.log("DEBUG - Disparando consulta automática...");
            // Disparar consulta automática para buscar locales anexos del RUC
            setTimeout(() => {
                $('#btn_consultar_api').trigger('click');
            }, 600);
        } else {
            console.log("DEBUG - Llamando seleccionarCliente con autoOpen=true");
            window.seleccionarCliente(window.paramsGuia.clienteInfo, true);
        }
    } else {
        // Si no viene de una venta pero hay dirección/ubigeo precargado
        let initialUbigeoLlegada = window.paramsGuia.clienteUbigeo;
        if (initialUbigeoLlegada) {
            window.setSelect2Value('#ubigeo_llegada', initialUbigeoLlegada);
        }
    }

    let initialUbigeoPartida = window.paramsGuia.sedeUbigeo;
    if (initialUbigeoPartida) {
        window.setSelect2Value('#ubigeo_partida', initialUbigeoPartida);
    }

    calcTotalPeso();
});

function calcTotalPeso() {
    let totalPeso = 0;
    let totalBultos = 0;
    $('.input-peso-item').each(function() {
        let v = parseFloat($(this).val()) || 0;
        totalPeso += v;
    });
    $('.input-cant-item').each(function() {
        let v = parseInt($(this).val()) || 0;
        totalBultos += v;
    });
    $('input[name="peso_total"]').val(totalPeso.toFixed(2));
    $('input[name="numero_bultos"]').val(Math.ceil(totalBultos) || 1);
}

$(document).on('input', '.input-peso-item', function() {
    calcTotalPeso();
});

$(document).on('input', '.input-cant-item', function() {
    let row = $(this).closest('tr');
    let cant = parseInt($(this).val()) || 0;
    $(this).val(cant); // Forzar que siempre sea entero
    let pesoU = parseFloat($(this).data('peso-u')) || 0;
    row.find('.input-peso-item').val((cant * pesoU).toFixed(2));
    calcTotalPeso();
});

$(document).on('click', '.btn-remove-item', function() {
    $(this).closest('tr').remove();
    if ($('#tableItems tbody tr').length === 0) {
        $('#tableItems tbody').html('<tr id="rowEmpty"><td colspan="5" class="text-center text-muted py-4">Agregue artículos manualmente o desde una factura.</td></tr>');
    }
    calcTotalPeso();
});
