$(function() {
    'use strict';

    // Inicializar Select2 para Ubigeo
    if ($('.select2-ubigeo').length) {
        $('.select2-ubigeo').select2({
            theme: 'bootstrap-5',
            placeholder: 'Buscar Distrito / Ubigeo',
            allowClear: true,
            ajax: {
                url: window.baseUrl + '/api/ubigeos/buscar',
                dataType: 'json',
                delay: 250,
                data: function (params) { return { q: params.term }; },
                processResults: function (data) { return { results: data }; },
                cache: true
            },
            minimumInputLength: 3
        });

        // Si hay un ubigeo inicial (en edición), cargarlo
        let initialUbigeo = $('#ubigeo').val();
        if (initialUbigeo) {
            $.get(window.baseUrl + '/api/ubigeos/buscar', { id: initialUbigeo }, function(data) {
                if (data) {
                    let opt = new Option(data.text, data.id, true, true);
                    $('#ubigeo').append(opt).trigger('change');
                }
            });
        }
    }

    // Mostrar/Ocultar secciones según tipo de documento
    $('select[name="tipo_documento"]').on('change', function() {
        let tipo = $(this).val();
        if (tipo == '1') { // DNI
            $('#div_licencia, .div_mtc_extra').fadeIn();
            $('#div_establecimientos').fadeOut();
        } else if (tipo == '6') { // RUC
            $('#div_licencia, .div_mtc_extra').fadeOut();
            $('#div_establecimientos').fadeIn();
        } else {
            $('#div_licencia, .div_mtc_extra, #div_establecimientos').fadeOut();
        }
    });

    // Forzar el disparo del cambio al cargar para que se muestre correctamente si ya es DNI o RUC
    $('select[name="tipo_documento"]').trigger('change');

    // Manejo de la consulta RUC/DNI en el mantenimiento de clientes
    $('#btn_consultar_cliente_api').on('click', function() {
        let doc = $('#numero_documento').val().trim();
        let tipo = $('select[name="tipo_documento"]').val();
        
        if (doc.length !== 8 && doc.length !== 11) {
            Swal.fire('Atención', 'El documento debe tener 8 (DNI) u 11 (RUC) dígitos.', 'warning');
            return;
        }

        let $btn = $(this);
        let oldHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
        
        // Mostrar mensaje de cargando en la tabla de locales
        if (tipo == '6') {
            $('#tabla_establecimientos tbody').html('<tr><td colspan="4" class="text-center"><span class="spinner-border spinner-border-sm text-primary"></span> Consultando locales en SUNAT...</td></tr>');
        }

        $.get(window.baseUrl + '/api/consultar-doc', { tipo: tipo, num: doc, save: 0 }, function(res) {
            $btn.prop('disabled', false).html(oldHtml);
            
            if (res.success) {
                $('input[name="razon_social"]').val(res.nombre);
                if ($('input[name="direccion"]').length) {
                    $('input[name="direccion"]').val(res.direccion);
                }
                
                // Llenar datos de licencia si aplica
                if (res.licencia) $('#licencia').val(res.licencia);
                if (res.licencia_categoria) $('#licencia_categoria').val(res.licencia_categoria);
                if (res.licencia_vencimiento) $('#licencia_vencimiento').val(res.licencia_vencimiento);
                if (res.licencia_estado) $('#licencia_estado').val(res.licencia_estado);

                // Llenar tabla de establecimientos si aplica
                if (res.establecimientos && res.establecimientos.length > 0) {
                    $('#establecimientos_json').val(JSON.stringify(res.establecimientos));
                    let $tbody = $('#tabla_establecimientos tbody');
                    $tbody.empty();
                    res.establecimientos.forEach(function(est) {
                        let ubigeoVal = Array.isArray(est.ubigeo) ? est.ubigeo[est.ubigeo.length - 1] : (est.ubigeo || '---');
                        $tbody.append(`
                            <tr>
                                <td><span class="badge bg-secondary">${est.cod || est.codigo || '---'}</span></td>
                                <td>${est.tipo || 'ESTABLECIMIENTO'}</td>
                                <td>${est.direccion || est.domicilio || '---'}</td>
                                <td>${ubigeoVal}</td>
                            </tr>
                        `);
                    });
                } else if (tipo == '6') {
                    $('#tabla_establecimientos tbody').html('<tr><td colspan="4" class="text-center text-muted">No se encontraron locales anexos.</td></tr>');
                }

                // Llenar ubigeo si aplica
                if (res.ubigeo) {
                    $.get(window.baseUrl + '/api/ubigeos/buscar', { id: res.ubigeo }, function(data) {
                        if (data) {
                            let opt = new Option(data.text, data.id, true, true);
                            $('#ubigeo').append(opt).trigger('change');
                        }
                    });
                }
                
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Datos obtenidos de ' + (tipo == '6' ? 'SUNAT' : 'RENIEC')
                });
            } else {
                Swal.fire('Atención', res.message, 'info');
            }
        }).fail(function() {
            $btn.prop('disabled', false).html(oldHtml);
            Swal.fire('Error', 'No se pudo conectar con el servicio.', 'error');
        });
    });
});
