$(document).ready(function() {
    var carpeta = $("#carpeta").val();

    function modalBonito(opciones) {
        var tipo = opciones.tipo || 'info';
        var icono = opciones.icono || 'ℹ️';
        var titulo = opciones.titulo || 'Información';
        var mensaje = opciones.mensaje || '';
        var ancho = opciones.ancho || '380px';

        var colores = {
            error: ['#ff416c', '#ff4b2b'],
            warn: ['#f7971e', '#ffd200'],
            info: ['#4facfe', '#00f2fe'],
            success: ['#00b09b', '#96c93d']
        };

        var botonesPorTipo = {
            error: 'btn-red',
            warn: 'btn-orange',
            success: 'btn-green',
            info: 'btn-blue'
        };

        var grad = colores[tipo] || colores.info;
        var claseBoton = botonesPorTipo[tipo] || 'btn-blue';

        const contenido = `
            <div style="position:relative;text-align:center;padding:40px 20px 25px;">
                <div style="
                    position:absolute;top:0;left:0;
                    width:100%;height:10px;
                    background:linear-gradient(135deg,${grad[0]},${grad[1]});
                    border-radius:6px 6px 0 0;">
                </div>

                <div style="
                    width:90px;height:90px;
                    border-radius:50%;
                    background:linear-gradient(135deg,${grad[0]},${grad[1]});
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    margin:0 auto 18px;
                    box-shadow:0 12px 25px rgba(0,0,0,.25);">
                    <span style="font-size:42px;color:white;">${icono}</span>
                </div>

                <h3 style="margin:0;font-weight:600;color:#2c3e50;">
                    ${titulo}
                </h3>

                <p style="margin-top:12px;font-size:15px;color:#555;">
                    ${mensaje}
                </p>
            </div>
        `;

        $.alert({
            title: false,
            content: contenido,
            boxWidth: ancho,
            useBootstrap: false,
            buttons: {
                ok: {
                    text: 'Entendido',
                    btnClass: claseBoton
                }
            }
        });
    }

    function modalBonitoConfirm(opciones) {
        var tipo = opciones.tipo || 'info';
        var icono = opciones.icono || '❓';
        var titulo = opciones.titulo || 'Confirmación';
        var mensaje = opciones.mensaje || '¿Está seguro de realizar esta acción?';
        var ancho = opciones.ancho || '420px';
        var onConfirm = opciones.onConfirm || function(){};

        var colores = {
            error: ['#ff416c', '#ff4b2b'],
            warn: ['#f7971e', '#ffd200'],
            info: ['#4facfe', '#00f2fe'],
            success: ['#00b09b', '#96c93d']
        };

        var grad = colores[tipo] || colores.info;

        const contenido = `
            <div style="position:relative;text-align:center;padding:40px 20px 25px;">
                <div style="
                    position:absolute;top:0;left:0;
                    width:100%;height:10px;
                    background:linear-gradient(135deg,${grad[0]},${grad[1]});
                    border-radius:6px 6px 0 0;">
                </div>

                <div style="
                    width:90px;height:90px;
                    border-radius:50%;
                    background:linear-gradient(135deg,${grad[0]},${grad[1]});
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    margin:0 auto 18px;
                    box-shadow:0 12px 25px rgba(0,0,0,.25);">
                    <span style="font-size:42px;color:white;">${icono}</span>
                </div>

                <h3 style="margin:0;font-weight:600;color:#2c3e50;">
                    ${titulo}
                </h3>

                <p style="margin-top:12px;font-size:15px;color:#555;">
                    ${mensaje}
                </p>
            </div>
        `;

        $.confirm({
            title: false,
            content: contenido,
            boxWidth: ancho,
            useBootstrap: false,
            buttons: {
                confirmar: {
                    text: 'Sí, continuar',
                    btnClass: 'btn-blue',
                    action: onConfirm
                },
                cancelar: {
                    text: 'Cancelar',
                    btnClass: 'btn-red'
                }
            }
        });
    }

    $(".buscarpedidoconsolidado").on("click", function(e) {
        e.preventDefault();
        
        var empresa_id = $("#empresa_id").val();
        var centro_pedido = $("#centro_pedido").val();
        var anio_pedido = $("#anio_pedido").val();
        var mes_pedido = $("#mes_pedido").val();
        var idopcion = $("#idopcion").val();

        if (mes_pedido == "") {
            modalBonito({
                tipo: 'error',
                icono: '❌',
                titulo: 'Periodo Requerido',
                mensaje: 'Debe seleccionar un <b>periodo</b> para poder realizar la búsqueda.',
                ancho: '400px'
            });
            return false;
        }

        abrircargando();
        $(".container-detalle-consolidado").html(""); // Limpiar detalle anterior
        $(".container-detalle-consolidados-aprobado").html(""); // Limpiar detalle anterior de aprobados
        $("#contenedor-detalle-area-producto").hide(); // Ocultar detalle de área anterior
        id_consolidado_seleccionado = ''; // Resetear ID seleccionado

        $.ajax({
            type: "POST",
            url: carpeta + "/ajax-buscar-consolidado-pedidos-aprobar",
            data: {
                _token: $("#token").val(),
                empresa_id: empresa_id,
                centro_pedido: centro_pedido,
                anio_pedido: anio_pedido,
                mes_pedido: mes_pedido,
                idopcion: idopcion
            },
            success: function(data) {
                cerrarcargando();
                $(".container-lista-consolidado").html(data);
                
                // Extraer la lista de aprobados del contenido oculto y ponerla en su tab
                var htmlAprobados = $(".container-lista-consolidado").find(".hidden-aprobados-ajax").html();
                
                // Destruir instancia previa de DataTable en la pestaña visible para evitar duplicados/errores
                if ($.fn.DataTable.isDataTable('#listacotizacionpedidoaprobados #tabla-consolidados-aprobados')) {
                    $('#listacotizacionpedidoaprobados #tabla-consolidados-aprobados').DataTable().destroy();
                }

                $(".container-lista-aprobados").html(htmlAprobados);

                App.dataTables();
                initFiltrosAprobados();
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function(data) {
                cerrarcargando();
                error_ajax(data);
            }
        });
    });

    var id_consolidado_seleccionado = '';

    // Doble clic en fila de consolidado para ver sus productos
    $(document).on('dblclick', '.fila-consolidado-ap, .fila-consolidado-ap-aprobado', function () {
        id_consolidado_seleccionado = $(this).data('id');
        var es_aprobado = $(this).hasClass('fila-consolidado-ap-aprobado');
        var idopcion = $("#idopcion").val();
        var _token = $("#token").val();

        $('.fila-consolidado-ap, .fila-consolidado-ap-aprobado').removeClass('background-fila-activa');
        $(this).addClass('background-fila-activa');

        abrircargando();

        $.ajax({
            type: "POST",
            url: carpeta + "/ajax-listar-detalle-consolidado-aprobado",
            data: {
                _token: _token,
                id_consolidado: id_consolidado_seleccionado,
                idopcion: idopcion
            },
            success: function(data) {
                cerrarcargando();
                
                if(es_aprobado) {
                    $(".container-detalle-consolidados-aprobado").html(data);
                    // Ocultar botones de acción en el detalle para consolidados ya aprobados
                    $(".container-detalle-consolidados-aprobado").find("#btn-guardar-detalle-consolidado-ap-editado").hide();
                    $(".container-detalle-consolidados-aprobado").find("#btn-aprobar-consolidado-ap").hide();

                    $('html, body').animate({
                        scrollTop: $(".container-detalle-consolidados-aprobado").offset().top
                    }, 800);
                } else {
                    $(".container-detalle-consolidado").html(data);
                    $('html, body').animate({
                        scrollTop: $(".container-detalle-consolidado").offset().top
                    }, 800);
                }
            },
            error: function(data) {
                cerrarcargando();
                error_ajax(data);
            }
        });
    });

    // Guardar cambios del detalle consolidado
    $(document).on('click', '#btn-guardar-detalle-consolidado-ap-editado', function () {
        let detalles = [];
        let _token = $("#token").val();
        let validacion = true;

        let table = $('#tabla-detalle-consolidado-ap').DataTable();
        table.rows().nodes().to$().each(function () {
            let cod_producto = $(this).data('id');
            let cantidad     = $(this).find('.input-cantidad-ap').val().replace(/,/g, '');
            let ind_compra   = $(this).find('.combo-compra-ap').val();

            if (ind_compra === '' || ind_compra === null) {
                validacion = false;
            }

            let $selected = $(this).find('.combo-compra-ap option:selected');
            let cod_centro_compra = $selected.data('codigo') || null;

            detalles.push({
                cod_producto: cod_producto,
                cantidad: cantidad,
                ind_compra: ind_compra,
                cod_centro_compra: cod_centro_compra
            });
        });

        if (!validacion) {
            modalBonito({
                tipo: 'error',
                icono: '❌',
                titulo: 'Campos Incompletos',
                mensaje: 'Debe seleccionar el lugar de <b>COMPRA (LOCAL o SEDE)</b> para todos los productos.'
            });
            return;
        }

        if (id_consolidado_seleccionado === '' || detalles.length === 0) {
            modalBonito({
                tipo: 'error',
                titulo: 'Error',
                mensaje: 'No hay datos válidos para guardar.'
            });
            return;
        }

        abrircargando();

        $.ajax({
            type: 'POST',
            url: carpeta + '/ajax-guardar-cambios-consolidado-aprobar',
            data: {
                _token: _token,
                id_consolidado: id_consolidado_seleccionado,
                detalles: JSON.stringify(detalles)
            },
            success: function (res) {
                cerrarcargando();
                if (res.success) {
                    modalBonito({
                        tipo: 'success',
                        icono: '✅',
                        titulo: 'Éxito',
                        mensaje: res.mensaje
                    });
                } else {
                    modalBonito({
                        tipo: 'error',
                        titulo: 'Error',
                        mensaje: res.mensaje
                    });
                }
            },
            error: function (e) {
                cerrarcargando();
                error_ajax(e);
            }
        });
    });

    // Aprobar Consolidado
    $(document).on('click', '#btn-aprobar-consolidado-ap', function () {
        let _token = $("#token").val();
        let detalles = [];
        let validacion = true;

        if (id_consolidado_seleccionado === '') {
            modalBonito({
                tipo: 'error',
                titulo: 'Error',
                mensaje: 'No hay un consolidado seleccionado.'
            });
            return;
        }

        let table = $('#tabla-detalle-consolidado-ap').DataTable();
        table.rows().nodes().to$().each(function () {
            let cod_producto = $(this).data('id');
            let cantidad     = $(this).find('.input-cantidad-ap').val().replace(/,/g, '');
            let ind_compra   = $(this).find('.combo-compra-ap').val();

            if (ind_compra === '' || ind_compra === null) {
                validacion = false;
            }

            let $selected = $(this).find('.combo-compra-ap option:selected');
            let cod_centro_compra = $selected.data('codigo') || null;

            detalles.push({
                cod_producto: cod_producto,
                cantidad: cantidad,
                ind_compra: ind_compra,
                cod_centro_compra: cod_centro_compra
            });
        });

        if (!validacion) {
            modalBonito({
                tipo: 'error',
                icono: '❌',
                titulo: 'Campos Incompletos',
                mensaje: 'Debe seleccionar el lugar de <b>COMPRA (LOCAL o SEDE)</b> para todos los productos.'
            });
            return;
        }

        modalBonitoConfirm({
            tipo: 'info',
            icono: '✅',
            titulo: 'Confirmar Aprobación',
            mensaje: '¿Está seguro de <b>guardar cambios y aprobar</b> este consolidado?',
            onConfirm: function () {
                abrircargando();
                $.ajax({
                    type: 'POST',
                    url: carpeta + '/ajax-aprobar-consolidado-aprobar',
                    data: {
                        _token: _token,
                        id_consolidado: id_consolidado_seleccionado,
                        detalles: JSON.stringify(detalles)
                    },
                    success: function (res) {
                        cerrarcargando();
                        if (res.success) {
                            modalBonito({
                                tipo: 'success',
                                icono: '✅',
                                titulo: 'Éxito',
                                mensaje: res.mensaje
                            });
                            // Recargar la búsqueda para refrescar la lista
                            $(".buscarpedidoconsolidado").trigger("click");
                            $(".container-detalle-consolidado").html("");
                        } else {
                            modalBonito({
                                tipo: 'error',
                                titulo: 'Error',
                                mensaje: res.mensaje
                            });
                        }
                    },
                    error: function (e) {
                        cerrarcargando();
                        error_ajax(e);
                    }
                });
            }
        });
    });

    // Doble clic en producto para ver detalle por área
    $(document).on('dblclick', '.fila-detalle-consolidado-ap', function () {
        let nom_producto = $(this).data('nombre');
        let detalle_string = $(this).data('detalle');

        $('#nombre-producto-area').text(nom_producto);
        let tbodyInferior = $('#tabla-area-detalle tbody');
        tbodyInferior.empty();

        $('#contenedor-detalle-area-producto').slideDown();

        $('html, body').animate({
            scrollTop: $("#contenedor-detalle-area-producto").offset().top
        }, 800);

        if (detalle_string) {
            let pedidos = detalle_string.split(' [SEP] ');

            if (pedidos.length > 0 && pedidos[0] !== "") {
                pedidos.forEach(p_str => {
                    let partes = p_str.split(' [FLD] ');

                    if (partes.length >= 2) {
                        let fecha = partes[0] ? partes[0].trim() : '';
                        let id = partes[1] ? partes[1].trim() : '';
                        let area = partes[2] ? partes[2].trim() : '';
                        let glosa = partes[3] ? partes[3].trim() : '';
                        let cantidad = partes[4] ? partes[4].trim() : "0.00";

                        // Los archivos pueden estar en la posición 5 o 6 dependiendo del origen de la consulta
                        let multi_archivos = '';
                        if (partes.length === 7) {
                            multi_archivos = partes[6] ? partes[6].trim() : '';
                        } else if (partes.length === 6) {
                            multi_archivos = partes[5] ? partes[5].trim() : '';
                        }

                        cantidad = cantidad.replace(/[^0-9.]/g, '');
                        let cantFloat = parseFloat(cantidad);
                        if (isNaN(cantFloat)) cantFloat = 0.00;

                        // Procesar archivos
                        let htmlArchivos = '<span class="text-muted" style="font-size: 0.9em;">-</span>';
                        if (multi_archivos && multi_archivos !== "") {
                            htmlArchivos = '';
                            let docs = multi_archivos.split(' [DOC] ');
                            docs.forEach(doc_str => {
                                if (doc_str.trim() !== "") {
                                    let subpartes = doc_str.split(' [URI] ');
                                    let nom_doc = subpartes[0] ? subpartes[0].trim() : 'Archivo';
                                    let uri_doc = subpartes[1] ? subpartes[1].trim() : '';

                                    if (uri_doc !== "") {
                                        let b64 = btoa(uri_doc);
                                        htmlArchivos += `
                                            <a href="${carpeta}/descargar-archivo-informe/${b64}" 
                                               class="btn btn-xs btn-primary shadow-sm" 
                                               style="border-radius: 12px; margin: 2px; padding: 2px 10px;"
                                               title="${nom_doc}" target="_blank">
                                                <i class="mdi mdi-download"></i> Archivo
                                            </a>
                                        `;
                                    }
                                }
                            });
                        }

                        tbodyInferior.append(`
                            <tr>
                                <td class="text-center">${fecha}</td>
                                <td class="text-center" style="font-weight: bold;">${id}</td>
                                <td>${area}</td>
                                <td>${glosa}</td>
                                <td class="text-center">
                                    <input type="number" 
                                           class="form-control input-sm input-cantidad-moderno" 
                                           value="${parseInt(cantFloat)}" 
                                           step="1"
                                           min="0"
                                           readonly>
                                </td>
                                <td class="text-center">
                                    ${htmlArchivos}
                                </td>
                            </tr>
                        `);
                    }
                });
            } else {
                tbodyInferior.html('<tr><td colspan="5" class="text-center">No hay detalles disponibles.</td></tr>');
            }
        } else {
            tbodyInferior.html('<tr><td colspan="5" class="text-center text-muted">No se encontró detalle para este producto.</td></tr>');
        }
    });

    // Delegación para botones de detalle si se agregan dinámicamente
    $('body').on('click', '.btn-detalle-consolidado-ap', function(e) {
        e.preventDefault();
        var id_consolidado = $(this).data('id');
    });

    // Limpiar detalles al cambiar de pestaña
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $(".container-detalle-consolidado").html("");
        $(".container-detalle-consolidados-aprobado").html("");
        $('.fila-consolidado-ap, .fila-consolidado-ap-aprobado').removeClass('background-fila-activa');
        id_consolidado_seleccionado = '';
    });

    // Validación de Checkboxes para que sean del mismo CENTRO
    $(document).on('change', '.chk-consolidado', function() {
        if ($(this).is(':checked')) {
            var centroActual = $(this).data('centro');
            var diferentes = false;
            
            $('.chk-consolidado:checked').each(function() {
                if ($(this).data('centro') !== centroActual) {
                    diferentes = true;
                    return false; // break loop
                }
            });

            if (diferentes) {
                $(this).prop('checked', false);
                modalBonito({
                    tipo: 'error',
                    icono: '❌',
                    titulo: 'Selección Inválida',
                    mensaje: 'Solo puede seleccionar consolidados que pertenezcan al mismo <b>CENTRO</b>.',
                    ancho: '400px'
                });
            }
        }
        
        // Sincronizar el "check all" visualmente considerando solo elementos visibles
        var totalVisible = $('.chk-consolidado:visible').length;
        var checkedVisible = $('.chk-consolidado:visible:checked').length;
        $('#check-all-consolidados').prop('checked', totalVisible === checkedVisible && totalVisible > 0);
    });

    $(document).on('change', '#check-all-consolidados', function() {
        var isChecked = $(this).is(':checked');
        var checkboxesVisibles = $('.chk-consolidado:visible');
        
        if (!isChecked) {
            checkboxesVisibles.prop('checked', false);
        } else {
            if (checkboxesVisibles.length > 0) {
                var primerCentro = checkboxesVisibles.first().data('centro');
                var todosIguales = true;
                
                checkboxesVisibles.each(function() {
                    if ($(this).data('centro') !== primerCentro) {
                        todosIguales = false;
                        return false;
                    }
                });

                if (todosIguales) {
                    checkboxesVisibles.prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                    modalBonito({
                        tipo: 'error',
                        icono: '❌',
                        titulo: 'Selección Inválida',
                        mensaje: 'No puede seleccionar todos a la vez porque la lista contiene consolidados de <b>diferentes CENTROS</b>. Utilice el filtro superior para listar solo un Centro antes de seleccionar todo.',
                        ancho: '450px'
                    });
                }
            }
        }
    });

    // Descargar Excel Masivo
    $(document).on('click', '#btn-descargar-excel-masivo', function(e) {
        e.preventDefault();
        
        var seleccionados = [];
        $('.chk-consolidado:checked').each(function() {
            seleccionados.push($(this).val());
        });

        if (seleccionados.length === 0) {
            modalBonito({
                tipo: 'warn',
                icono: '⚠️',
                titulo: 'Sin Selección',
                mensaje: 'Debe seleccionar al menos un consolidado marcando su casilla para poder descargar el Excel.',
                ancho: '400px'
            });
            return;
        }

        var ids_str = seleccionados.join(',');
        var url = carpeta + '/exportar-excel-masivo-consolidado?ids=' + ids_str;
        
        window.open(url, '_blank');
    });

    // Filtros de DataTables para Centro y Periodo
    function initFiltrosAprobados() {
        var $tabla = $('#listacotizacionpedidoaprobados #tabla-consolidados-aprobados');
        if ($tabla.length === 0) return;

        // Destruir instancia previa si existe para reinicializar limpiamente
        if ($.fn.DataTable.isDataTable('#listacotizacionpedidoaprobados #tabla-consolidados-aprobados')) {
            $tabla.DataTable().destroy();
        }

        // Inicializar DataTable en la tabla visible con configuración premium en español
        var table = $tabla.DataTable({
            "paging": false, // Sin paginación, mostrar todo en una sola vista
            "order": [[1, "desc"]], // Ordenar por ID CONSOLIDADO descendente por defecto
            "columnDefs": [
                { "targets": 0, "orderable": false }, // Checkbox
                { "targets": 8, "orderable": false }  // Acciones
            ],
            "language": {
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ registros",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "zeroRecords": "No se encontraron registros coincidentes",
                "paginate": {
                    "first": "Primero",
                    "previous": "Anterior",
                    "next": "Siguiente",
                    "last": "Último"
                }
            }
        });

        // Limpiar detalles automáticamente al realizar cualquier filtrado o búsqueda en la tabla
        table.on('search.dt', function () {
            $(".container-detalle-consolidado").html("");
            $(".container-detalle-consolidados-aprobado").html("");
            $("#contenedor-detalle-area-producto").hide();
            $('.fila-consolidado-ap, .fila-consolidado-ap-aprobado').removeClass('background-fila-activa');
            id_consolidado_seleccionado = '';
        });
        
        var indexCentro = 3;
        var indexPeriodo = 5;

        // Llenar select Centro
        var centros = table.column(indexCentro).data().unique().sort();
        var $selectCentro = $('#filtro-centro-aprobados');
        $selectCentro.find('option:not(:first)').remove();
        centros.each(function(d) {
            var textVal = $('<div>').html(d).text().trim();
            if(textVal) $selectCentro.append('<option value="'+textVal+'">'+textVal+'</option>');
        });

        // Llenar select Periodo
        var periodos = table.column(indexPeriodo).data().unique().sort();
        var $selectPeriodo = $('#filtro-periodo-aprobados');
        $selectPeriodo.find('option:not(:first)').remove();
        periodos.each(function(d) {
            // Eliminar tags HTML si los hay para el value
            var textVal = $('<div>').html(d).text().trim();
            if(textVal) $selectPeriodo.append('<option value="'+textVal+'">'+textVal+'</option>');
        });
    }

    // Usar document.on para asegurar que el evento persista y funcione con la tabla actualizada
    $(document).off('change', '#filtro-centro-aprobados, #filtro-periodo-aprobados').on('change', '#filtro-centro-aprobados, #filtro-periodo-aprobados', function() {
        var table = $('#listacotizacionpedidoaprobados #tabla-consolidados-aprobados').DataTable();
        var valCentro = $('#filtro-centro-aprobados').val();
        var valPeriodo = $('#filtro-periodo-aprobados').val();
        
        var indexCentro = 3;
        var indexPeriodo = 5;

        // Si hay valor, buscamos usando la búsqueda por defecto (smart search) que ignora espacios
        table.column(indexCentro).search(valCentro);
        table.column(indexPeriodo).search(valPeriodo);
        
        table.draw();
        
        // Actualizar checkbox global visible
        var totalVisible = $('.chk-consolidado:visible').length;
        var checkedVisible = $('.chk-consolidado:visible:checked').length;
        $('#check-all-consolidados').prop('checked', totalVisible === checkedVisible && totalVisible > 0);
    });

    // Inicializar al cargar la vista
    if ($('#listacotizacionpedidoaprobados #tabla-consolidados-aprobados').length > 0) {
        if (!$.fn.DataTable.isDataTable('#listacotizacionpedidoaprobados #tabla-consolidados-aprobados')) {
            initFiltrosAprobados();
        } else {
            setTimeout(initFiltrosAprobados, 300);
        }
    }

});
